<?php

namespace App\Http\Controllers;

use App\Mail\ContatoSiteMail;
use App\Models\Noticia;
use App\Models\Servico;
use App\Models\Evento;
use App\Models\Programa;
use App\Models\Alerta;
use App\Models\Banner;
use App\Models\Secretaria;
use App\Models\ServicoAcesso;
use App\Models\BannerDestaque;
use App\Models\RedeSocial;
use App\Models\Portal;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Carbon\Carbon;
use App\Support\Concerns\NormalizesSearch;
use App\Models\Executivo;
use App\Services\ConectaApiService;
use App\Services\BuscaInteligente;

class PortalController extends Controller
{
    use NormalizesSearch;

    /**
     * Aplica o filtro de perfil às consultas de conteúdo.
     * Lê o Cookie e utiliza JSON Contains para filtrar.
     */
    private function aplicarFiltroPerfil($query, $perfil)
    {
        if ($perfil !== 'todos') {
            $query->where(function ($q) use ($perfil) {
                $q->whereJsonContains('perfis_alvo', $perfil)
                    ->orWhereNull('perfis_alvo');
            });
        }
        return $query;
    }

    // Página inicial
    public function index(Request $request, ConectaApiService $conectaApi)
    {
        $perfil = $request->cookie('portal_perfil', 'todos');

        $banners = Banner::where('ativo', true)
            ->orderBy('created_at', 'desc')
            ->get();

        $portais = Portal::where('ativo', true)
            ->get();

        $alertasAtivos = Alerta::where('ativo', true)
            ->orderBy('created_at', 'desc')
            ->get();

        // 1. Busca Notícias marcadas como Destaque (Filtro Perfil Aplicado)
        $destaquesQuery = Noticia::publicadas()
            ->where('destaque', true)
            ->orderBy('data_publicacao', 'desc')
            ->orderBy('created_at', 'desc')
            ->take(3);
        $destaquesSlider = $this->aplicarFiltroPerfil($destaquesQuery, $perfil)->get();

        // 2. Busca Notícias Recentes ignorando as que já estão no Destaque (Filtro Perfil Aplicado)
        $recentesQuery = Noticia::publicadas()
            ->whereNotIn('id', $destaquesSlider->pluck('id'))
            ->orderBy('data_publicacao', 'desc')
            ->orderBy('created_at', 'desc')
            ->take(3);
        $recentesSidebar = $this->aplicarFiltroPerfil($recentesQuery, $perfil)->get();

        // 3. Mescla as coleções
        $noticias = $destaquesSlider->concat($recentesSidebar);

        // Eventos (Filtro Perfil Aplicado)
        $eventosQuery = Evento::futurosPublicos()
            ->ordenarPorDataMaisProxima()
            ->take(4);
        $eventos = $this->aplicarFiltroPerfil($eventosQuery, $perfil)->get();

        // Programas Destaque (Filtro Perfil Aplicado)
        $destaquesProgQuery = Programa::where('ativo', true)
            ->where('destaque', true)
            ->latest()
            ->take(3);
        $destaques = $this->aplicarFiltroPerfil($destaquesProgQuery, $perfil)->get();

        $programas = $destaques->count() >= 3
            ? $destaques
            : $destaques->concat(
                $this->aplicarFiltroPerfil(
                    Programa::where('ativo', true)->where('destaque', false)->latest()->take(3 - $destaques->count()),
                    $perfil
                )->get()
            );

        $bannersDestaque = BannerDestaque::where('ativo', true)
            ->orderBy('ordem', 'asc')
            ->orderBy('created_at', 'desc')
            ->get();

        // Serviços Locais (Filtro Perfil Aplicado — Mais Acessados)
        $servicosQuery = Servico::where('ativo', true)
            ->orderByDesc('acessos')
            ->take(10);
        $servicos = $this->aplicarFiltroPerfil($servicosQuery, $perfil)->get();

        // Serviços Conecta (normalizado para a home)
        $conectaRaw      = $conectaApi->getTodosServicos($perfil);
        $conectaHome     = collect($conectaRaw)->take(10)->map(fn($s) => [
            'titulo'     => $s['titulo'] ?? '',
            'icone'      => $s['icone']  ?? null,
            'link'       => rtrim(config('services.conecta.url'), '/') . '/servico/' . ($s['id_conecta'] ?? ''),
            'is_conecta' => true,
        ]);

        // Merge: locais primeiro, conecta preenche até 10
        $localHome = $servicos->map(fn($s) => [
            'titulo'     => $s->titulo,
            'icone'      => $s->icone,
            'link'       => route('servicos.acessar', $s->id),
            'is_conecta' => false,
        ]);
        $servicosHome = $localHome->concat($conectaHome)->take(10);

        $inscricoesAbertas = Cache::remember('inscricoes_conecta', 1800, function () {
            try {
                $response = Http::timeout(3)->get('https://conecta.assai.pr.gov.br/api/public/inscricoes-abertas');
                if ($response->successful()) {
                    return $response->json()['editais'] ?? [];
                }
            } catch (\Exception $e) {
                return [];
            }
            return [];
        });

        $redesSociais = RedeSocial::orderBy('ordem', 'asc')->get();

        // Sugestões IA (Filtro Perfil Aplicado)
        $sugestoesQuery = Servico::where('ativo', true)
            ->withCount([
                'acessosLog as acessos_recentes' => function ($query) {
                    $query->where('created_at', '>=', Carbon::now()->subDays(7));
                }
            ])
            ->orderByDesc('acessos_recentes')
            ->take(3);
        $sugestoesIA = $this->aplicarFiltroPerfil($sugestoesQuery, $perfil)->pluck('titulo');

        return view('pages.pagina', compact(
            'banners',
            'alertasAtivos',
            'noticias',
            'destaquesSlider',
            'recentesSidebar',
            'eventos',
            'programas',
            'servicos',
            'servicosHome',
            'inscricoesAbertas',
            'sugestoesIA',
            'portais',
            'bannersDestaque',
            'redesSociais',
            'perfil'
        ));
    }

    // Página de notícias
    public function noticias(Request $request)
    {
        $perfil = $request->cookie('portal_perfil', 'todos');

        // Buscar apenas categorias ativas que possuem notícias publicadas
        $categorias = \App\Models\Categoria::where('ativo', true)
            ->whereHas('noticias', function($q) {
                $q->where('ativo', true)->whereDate('data_publicacao', '<=', today());
            })
            ->orderBy('nome')
            ->get();

        $query = Noticia::publicadas()
            ->with('categorias')
            ->orderBy('data_publicacao', 'desc')
            ->orderBy('created_at', 'desc');

        // Aplica o filtro de Perfil (usando perfis_alvo herdado das categorias)
        $this->aplicarFiltroPerfil($query, $perfil);

        if ($request->filled('q')) {
            $termo = $request->q;
            $query->where(function ($q) use ($termo) {
                $q->whereRaw('titulo ILIKE ?', ["%{$termo}%"])
                    ->orWhereRaw('resumo ILIKE ?', ["%{$termo}%"])
                    ->orWhereRaw('conteudo ILIKE ?', ["%{$termo}%"]);
            });
        }

        if ($request->filled('categoria')) {
            $catValue = $request->categoria;
            $query->whereHas('categorias', function($q) use ($catValue) {
                if (is_numeric($catValue)) {
                    $q->where('categorias.id', $catValue);
                } else {
                    $q->where('categorias.nome', $catValue);
                }
            });
        }

        $noticias = $query->paginate(12)->withQueryString();
        return view('noticias.index', compact('noticias', 'categorias'));
    }

    public function agenda(Request $request)
    {
        $perfil = $request->cookie('portal_perfil', 'todos');
        $mes = $request->get('mes');

        $dataBase = $mes
            ? Carbon::createFromFormat('Y-m', $mes)->startOfMonth()
            : now()->startOfMonth();

        $mesAnterior = $dataBase->copy()->subMonth()->format('Y-m');
        $mesProximo = $dataBase->copy()->addMonth()->format('Y-m');
        $tituloMes = $dataBase->translatedFormat('F Y');
        $diasNoMes = $dataBase->daysInMonth;
        $primeiroDiaSemana = $dataBase->dayOfWeek;

        // Filtra dias com evento baseado no perfil
        $diasComEventoQuery = Evento::futurosPublicos()
            ->whereYear('data_inicio', $dataBase->year)
            ->whereMonth('data_inicio', $dataBase->month);

        $diasComEvento = $this->aplicarFiltroPerfil($diasComEventoQuery, $perfil)
            ->get()
            ->map(fn($e) => $e->data_inicio->format('Y-m-d'))
            ->unique()
            ->values()
            ->all();

        $calendarData = compact(
            'dataBase',
            'mesAnterior',
            'mesProximo',
            'tituloMes',
            'diasNoMes',
            'primeiroDiaSemana',
            'diasComEvento'
        );

        if ($request->ajax()) {
            return response(view('partials.calendario-widget', $calendarData)->render());
        }

        // Filtra eventos da listagem baseado no perfil
        $eventosQuery = Evento::publico()->ordenarPorDataMaisProxima();
        $eventos = $this->aplicarFiltroPerfil($eventosQuery, $perfil)
            ->paginate(4)
            ->withQueryString();

        return view('agenda.index', array_merge($calendarData, compact('eventos')));
    }

    public function eventoShow(Request $request, $id)
    {
        $perfil = $request->cookie('portal_perfil', 'todos');
        $evento = Evento::findOrFail($id);

        $outrosEventosQuery = Evento::where('id', '!=', $id)
            ->publico()
            ->ordenarPorDataMaisProxima()
            ->take(3);

        $outrosEventos = $this->aplicarFiltroPerfil($outrosEventosQuery, $perfil)->get();

        return view('agenda.show', compact('evento', 'outrosEventos'));
    }

    public function secretarias(Request $request)
    {
        $query = \App\Models\Secretaria::query();

        $query->when($request->filled('search'), function ($q) use ($request) {
            $termo = '%' . $this->normalizeSearchTerm($request->string('search')->trim()->toString()) . '%';

            $q->where(function ($subQuery) use ($termo) {
                $subQuery->whereRaw($this->normalizedColumnSql('nome') . ' LIKE ?', [$termo])
                    ->orWhereRaw($this->normalizedColumnSql('nome_secretario') . ' LIKE ?', [$termo]);
            });
        });

        $secretarias = $query->orderBy('nome', 'asc')->paginate(12)->withQueryString();

        $gestores = Executivo::all();
        $prefeito = $gestores->where('cargo', 'Prefeito')->first();
        $vicePrefeito = $gestores->where('cargo', 'Vice-Prefeito')->first();

        return view('secretarias.index', compact('secretarias', 'prefeito', 'vicePrefeito'));
    }

    public function servicos(Request $request, ConectaApiService $conectaApi)
    {
        $perfil     = $request->cookie('portal_perfil', 'todos');
        $termoBusca = $request->string('search')->trim()->toString();
        $page       = max(1, $request->integer('page', 1));
        $perPage    = 21;

        // 1. Serviços locais do portal → normalizados
        $queryLocal = \App\Models\Servico::where('ativo', true)->with('secretaria')->orderBy('titulo');
        $this->aplicarFiltroPerfil($queryLocal, $perfil);
        $localServicos = $queryLocal->get()->map(fn($s) => [
            'source'    => 'local',
            'titulo'    => $s->titulo,
            'descricao' => $s->descricao ? strip_tags($s->descricao) : '',
            'icone'     => $s->icone,
            'orgao'     => $s->secretaria?->nome,
            'link'      => route('servicos.acessar', $s->id),
            'externo'   => false,
        ]);

        // 2. Serviços do Conecta → normalizados
        $conectaBase = $conectaApi->getTodosServicos($perfil);
        $conectaServicos = collect($conectaBase)->map(fn($s) => [
            'source'    => 'conecta',
            'titulo'    => $s['titulo'] ?? '',
            'descricao' => $s['descricao'] ?? '',
            'icone'     => $s['icone'] ?? null,
            'orgao'     => $s['orgao'] ?? null,
            'link'      => rtrim(config('services.conecta.url'), '/') . '/servico/' . ($s['id_conecta'] ?? ''),
            'externo'   => true,
        ]);

        // 3. Merge: Conecta primeiro, depois locais
        $todos = $conectaServicos->concat($localServicos);

        // 4. Busca unificada
        if ($termoBusca !== '') {
            $busca = mb_strtolower($this->normalizeSearchTerm($termoBusca));
            $todos = $todos->filter(fn($s) =>
                str_contains(mb_strtolower($this->normalizeSearchTerm($s['titulo'])), $busca) ||
                str_contains(mb_strtolower($this->normalizeSearchTerm($s['descricao'])), $busca)
            );
        }

        // 5. Paginador único do Laravel
        $total    = $todos->count();
        $itens    = $todos->slice(($page - 1) * $perPage, $perPage)->values();
        $servicos = new \Illuminate\Pagination\LengthAwarePaginator(
            $itens,
            $total,
            $perPage,
            $page,
            ['path' => $request->url(), 'query' => $request->query()]
        );

        return view('servicos.index', compact('servicos', 'perfil'));
    }

    public function acessarServico($id)
    {
        $servico = Servico::findOrFail($id);
        $servico->increment('acessos');
        ServicoAcesso::create(['servico_id' => $servico->id]);
        $destino = trim((string) ($servico->url_acesso ?? $servico->link ?? ''));

        if ($destino === '' || $destino === '#') {
            return redirect()->back();
        }

        return redirect($destino);
    }

    public function secretariaShow($id)
    {
        $secretaria = \App\Models\Secretaria::findOrFail($id);

        $servicos = $secretaria->servicos()
            ->where('ativo', true)
            ->orderBy('titulo', 'asc')
            ->paginate(6)
            ->withQueryString();

        return view('secretarias.show', compact('secretaria', 'servicos'));
    }

    public function contato()
    {
        $secretarias = Secretaria::whereNotNull('email')
            ->orderBy('nome', 'asc')
            ->get(['nome', 'email']);

        return view('pages.contato', compact('secretarias'));
    }

    public function enviarContato(Request $request)
    {
        $validated = $request->validate([
            'nome' => 'required|string|min:2|max:120',
            'email' => 'required|email|max:120',
            'destinatario' => 'required|email',
            'assunto' => 'required|string|min:3|max:200',
            'mensagem' => 'required|string|min:10|max:4000',
        ], [
            'nome.required' => 'O nome é obrigatório.',
            'nome.min' => 'O nome deve ter pelo menos 2 caracteres.',
            'email.required' => 'O e-mail é obrigatório.',
            'email.email' => 'Informe um e-mail válido.',
            'destinatario.required' => 'Selecione o setor de destino.',
            'destinatario.email' => 'Setor de destino inválido.',
            'assunto.required' => 'O assunto é obrigatório.',
            'assunto.min' => 'O assunto deve ter pelo menos 3 caracteres.',
            'mensagem.required' => 'A mensagem é obrigatória.',
            'mensagem.min' => 'A mensagem deve ter pelo menos 10 caracteres.',
            'mensagem.max' => 'A mensagem pode ter no máximo 4000 caracteres.',
        ]);

        try {
            Mail::to($validated['destinatario'])->send(new ContatoSiteMail($validated));
        } catch (\Throwable $exception) {
            Log::error('Falha ao enviar formulário de contato do portal.', [
                'erro' => $exception->getMessage(),
                'nome' => $validated['nome'] ?? null,
                'email' => $validated['email'] ?? null,
                'destinatario' => $validated['destinatario'] ?? null,
                'assunto' => $validated['assunto'] ?? null,
            ]);

            return back()
                ->withInput()
                ->with('error', 'Não foi possível enviar sua mensagem no momento. Tente novamente em instantes.');
        }

        return back()->with('success', 'Mensagem enviada com sucesso! O setor responsável entrará em contato em breve.');
    }

    public function storeContato(Request $request)
    {
        $validated = $request->validate([
            'nome' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'destinatario' => 'required|email',
            'assunto' => 'required|string|max:255',
            'mensagem' => 'required|string|min:10',
        ]);

        $emailDestino = $validated['destinatario'];

        try {
            Mail::to($emailDestino)->send(new ContatoSiteMail($validated));

            return redirect()->back()->with('success', 'Mensagem enviada com sucesso para o departamento selecionado.');
        } catch (\Throwable $th) {
            return redirect()->back()->withInput()->with('error', 'Ocorreu um erro ao enviar a mensagem. Tente novamente mais tarde.');
        }
    }

    public function programas(Request $request)
    {
        $perfil = $request->cookie('portal_perfil', 'todos');

        $query = \App\Models\Programa::where('ativo', true)
            ->orderBy('created_at', 'desc');

        $this->aplicarFiltroPerfil($query, $perfil);

        $programas = $query->paginate(12);

        return view('programas.index', compact('programas'));
    }

    public function showPrograma(Programa $programa)
    {
        abort_unless($programa->ativo, 404);
        return view('programas.show', compact('programa'));
    }

    public function autocomplete(Request $request, ConectaApiService $conectaApi)
    {
        $perfil = $request->cookie('portal_perfil', 'todos');
        $termo = trim($request->get('q', ''));

        if (strlen($termo) < 2) {
            return response()->json([]);
        }

        $termoNormalizado = mb_strtolower($this->normalizeSearchTerm($termo));

        // 1. Serviços (Prioridade Máxima)
        $servicosQuery = Servico::where('ativo', true);
        $this->applyInsensitiveSearch($servicosQuery, ['titulo'], $termo);
        $this->aplicarFiltroPerfil($servicosQuery, $perfil);

        $localServicos = $servicosQuery
            ->select('id', 'titulo')
            ->limit(4)
            ->get()
            ->map(fn($s) => [
                'titulo' => $s->titulo,
                'url' => route('servicos.acessar', $s->id),
                'tipo' => 'Serviço',
            ]);

        $conectaBase = collect($conectaApi->getTodosServicos($perfil));
        $conectaServicos = $conectaBase->filter(function($s) use ($termoNormalizado) {
            return str_contains(mb_strtolower($this->normalizeSearchTerm($s['titulo'] ?? '')), $termoNormalizado);
        })->take(4)->map(function($s) {
            return [
                'titulo' => $s['titulo'] ?? '',
                'url' => rtrim(config('services.conecta.url'), '/') . '/servico/' . ($s['id_conecta'] ?? ''),
                'tipo' => 'Serviço',
            ];
        });

        $servicos = $conectaServicos->concat($localServicos)->take(4);

        // 2. Páginas do Portal
        $paginas = $this->getPaginasEstaticas()->filter(function ($pagina) use ($termoNormalizado) {
            return str_contains(mb_strtolower($this->normalizeSearchTerm($pagina['titulo'])), $termoNormalizado) ||
                   collect($pagina['keywords'] ?? [])->contains(fn($k) => str_contains(mb_strtolower($this->normalizeSearchTerm($k)), $termoNormalizado));
        })->take(3)->map(fn($p) => [
            'titulo' => $p['titulo'],
            'url' => $p['url'],
            'tipo' => 'Portal',
        ]);

        // 3. Programas
        $programasQuery = Programa::where('ativo', true);
        $this->applyInsensitiveSearch($programasQuery, ['titulo', 'descricao'], $termo);
        $this->aplicarFiltroPerfil($programasQuery, $perfil);

        $programas = $programasQuery
            ->select('id', 'titulo')
            ->limit(2)
            ->get()
            ->map(fn($p) => [
                'titulo' => $p->titulo,
                'url' => route('programas.show', $p->id),
                'tipo' => 'Programa',
            ]);

        // 4. Secretarias
        $secretariasQuery = Secretaria::query();
        $this->applyInsensitiveSearch($secretariasQuery, ['nome', 'nome_secretario', 'descricao'], $termo);

        $secretarias = $secretariasQuery
            ->select('id', 'nome')
            ->limit(2)
            ->get()
            ->map(fn($sec) => [
                'titulo' => $sec->nome,
                'url' => route('secretarias.show', $sec->id),
                'tipo' => 'Secretaria',
            ]);

        // 5. Notícias (Prioridade Mínima)
        $noticiasQuery = Noticia::where('ativo', true);
        $this->applyInsensitiveSearch($noticiasQuery, ['titulo', 'resumo', 'conteudo'], $termo);
        $this->aplicarFiltroPerfil($noticiasQuery, $perfil);

        $noticias = $noticiasQuery
            ->select('id', 'titulo', 'slug')
            ->whereDate('data_publicacao', '<=', today())
            ->latest('data_publicacao')
            ->limit(3)
            ->get()
            ->map(fn($n) => [
                'titulo' => $n->titulo,
                'url' => route('noticias.show', $n->slug),
                'tipo' => 'Notícia',
            ]);

        // Merge seguindo a nova prioridade
        $resultados = collect($servicos)
            ->concat($paginas)
            ->concat($programas)
            ->concat($secretarias)
            ->concat($noticias)
            ->values();

        return response()->json($resultados);
    }

    public function buscaGlobal(Request $request, ConectaApiService $conectaApi)
    {
        $perfil = $request->cookie('portal_perfil', 'todos');
        $termo = trim($request->input('q', ''));
        $categoriaId = $request->input('categoria');
        $somenteNovos = $request->has('somente_novos');

        $noticias = collect();
        $servicos = collect();
        $eventos = collect();
        $programas = collect();
        $secretarias = collect();
        $paginas = collect();
        $respostaInteligente = null;

        $temFiltroAvancado = !empty($categoriaId) || $somenteNovos;

        if (strlen($termo) >= 2 || $temFiltroAvancado) {
            // 1. Resposta Inteligente (IA) - Apenas se tiver termo
            if (strlen($termo) >= 2) {
                $resultadoIA = BuscaInteligente::buscar($termo);
                if ($resultadoIA['confianca'] >= 60) {
                    $respostaInteligente = $resultadoIA;
                }
            }

            // 2. Páginas Estáticas do Portal - Apenas se tiver termo e não tiver filtro avançado
            $termoNormalizado = mb_strtolower($this->normalizeSearchTerm($termo));
            if (!$temFiltroAvancado && strlen($termo) >= 2) {
                $paginas = $this->getPaginasEstaticas()->filter(function ($pagina) use ($termoNormalizado) {
                    return str_contains(mb_strtolower($this->normalizeSearchTerm($pagina['titulo'])), $termoNormalizado) ||
                           str_contains(mb_strtolower($this->normalizeSearchTerm($pagina['descricao'])), $termoNormalizado) ||
                           collect($pagina['keywords'] ?? [])->contains(fn($k) => str_contains(mb_strtolower($this->normalizeSearchTerm($k)), $termoNormalizado));
                })->take(6);
            }

            // 3. Serviços (Prioridade Máxima)
            $servicosQuery = Servico::where('ativo', true);
            if (!empty($termo)) {
                $this->applyInsensitiveSearch($servicosQuery, ['titulo', 'descricao'], $termo);
            }
            if ($categoriaId) {
                $servicosQuery->where('categoria_id', $categoriaId);
            }
            if ($somenteNovos) {
                $servicosQuery->where('created_at', '>=', now()->subDays(30));
            }
            $this->aplicarFiltroPerfil($servicosQuery, $perfil);
            
            $localServicos = $servicosQuery->take(9)->get()->map(function($s) {
                $s->url_acesso = route('servicos.acessar', $s->id);
                $s->link = route('servicos.acessar', $s->id);
                $s->is_conecta = false;
                return $s;
            });

            $conectaBase = collect($conectaApi->getTodosServicos($perfil));
            $conectaServicos = $conectaBase->filter(function($s) use ($termoNormalizado, $categoriaId) {
                $passaTermo = empty($termoNormalizado) || str_contains(mb_strtolower($this->normalizeSearchTerm($s['titulo'] ?? '')), $termoNormalizado) ||
                       str_contains(mb_strtolower($this->normalizeSearchTerm($s['descricao'] ?? '')), $termoNormalizado);
                
                $passaCategoria = true;
                if (!empty($categoriaId)) {
                    $passaCategoria = ($s['categoria_id'] ?? null) == $categoriaId;
                }

                return $passaTermo && $passaCategoria;
            })->map(function($s) {
                return (object) [
                    'titulo' => $s['titulo'] ?? '',
                    'descricao' => $s['descricao'] ?? '',
                    'categoria_id' => $s['categoria_id'] ?? null,
                    'categoria' => $s['categoria'] ?? null,
                    'icone' => $s['icone'] ?? null,
                    'url_acesso' => rtrim(config('services.conecta.url'), '/') . '/servico/' . ($s['id_conecta'] ?? ''),
                    'link' => rtrim(config('services.conecta.url'), '/') . '/servico/' . ($s['id_conecta'] ?? ''),
                    'is_conecta' => true,
                ];
            });

            $servicos = $conectaServicos->concat($localServicos)->take(9);

            // 4. Eventos
            $eventosQuery = Evento::publico()->ordenarPorDataMaisProxima();
            if (!empty($termo)) {
                $this->applyInsensitiveSearch($eventosQuery, ['titulo', 'descricao', 'local'], $termo);
            }
            if ($categoriaId) {
                $eventosQuery->where('categoria_id', $categoriaId);
            }
            if ($somenteNovos) {
                $eventosQuery->where('created_at', '>=', now()->subDays(30));
            }
            $this->aplicarFiltroPerfil($eventosQuery, $perfil);
            $eventos = $eventosQuery->take(8)->get();

            // 5. Programas
            $programasQuery = Programa::where('ativo', true);
            if (!empty($termo)) {
                $this->applyInsensitiveSearch($programasQuery, ['titulo', 'descricao'], $termo);
            }
            if ($categoriaId) {
                $programasQuery->where('categoria_id', $categoriaId);
            }
            if ($somenteNovos) {
                $programasQuery->where('created_at', '>=', now()->subDays(30));
            }
            $this->aplicarFiltroPerfil($programasQuery, $perfil);
            $programas = $programasQuery->take(9)->get();

            // 6. Secretarias
            $secretariasQuery = Secretaria::query();
            if (!empty($termo)) {
                $this->applyInsensitiveSearch($secretariasQuery, ['nome', 'nome_secretario', 'descricao'], $termo);
            }
            $secretarias = $secretariasQuery->take(6)->get();

            // 7. Notícias (Prioridade Mínima)
            $noticiasQuery = Noticia::where('ativo', true);
            if (!empty($termo)) {
                $this->applyInsensitiveSearch($noticiasQuery, ['titulo', 'resumo', 'conteudo'], $termo);
            }
            if ($categoriaId) {
                $noticiasQuery->whereHas('categorias', function($q) use ($categoriaId) {
                    $q->where('categorias.id', $categoriaId);
                });
            }
            if ($somenteNovos) {
                $noticiasQuery->whereDate('data_publicacao', '>=', now()->subDays(30));
            }
            $this->aplicarFiltroPerfil($noticiasQuery, $perfil);
            $noticias = $noticiasQuery
                ->whereDate('data_publicacao', '<=', today())
                ->orderBy('data_publicacao', 'desc')
                ->orderBy('created_at', 'desc')
                ->take(12)
                ->get();
        }

        return view('pages.busca', compact(
            'termo', 
            'noticias', 
            'servicos', 
            'eventos', 
            'programas', 
            'secretarias', 
            'paginas', 
            'respostaInteligente'
        ));
    }

    /**
     * Retorna uma coleção de páginas estáticas e institucionais do portal.
     */
    private function getPaginasEstaticas()
    {
        return collect([
            [
                'titulo' => 'Nossa Cidade',
                'url' => route('cidade.nossa-cidade'),
                'descricao' => 'Conheça a história e informações gerais sobre Assaí.',
                'keywords' => ['historia', 'sobre', 'cidade', 'fundação']
            ],
            [
                'titulo' => 'Turismo',
                'url' => route('pages.turismo'),
                'descricao' => 'Pontos turísticos e atrações de Assaí.',
                'keywords' => ['turismo', 'visita', 'lazer', 'atrativos']
            ],
            [
                'titulo' => 'Transparência',
                'url' => route('pages.transparencia'),
                'descricao' => 'Portal da Transparência, contas públicas e gastos municipais.',
                'keywords' => ['contas', 'gastos', 'portal da transparência', 'licitações']
            ],
            [
                'titulo' => 'Contato',
                'url' => route('contato.index'),
                'descricao' => 'Fale com a prefeitura e suas secretarias.',
                'keywords' => ['telefone', 'email', 'fale conosco', 'endereço']
            ],
            [
                'titulo' => 'Agenda de Eventos',
                'url' => route('agenda.index'),
                'descricao' => 'Confira o calendário de eventos e compromissos do município.',
                'keywords' => ['calendario', 'agenda', 'eventos', 'datas']
            ],
            [
                'titulo' => 'Secretarias',
                'url' => route('secretarias.index'),
                'descricao' => 'Lista de todas as secretarias municipais e seus gestores.',
                'keywords' => ['secretarios', 'gestão', 'departamentos']
            ],
            [
                'titulo' => 'Acessibilidade',
                'url' => route('pages.acessibilidade'),
                'descricao' => 'Informações sobre os recursos de acessibilidade do portal.',
                'keywords' => ['acessível', 'libras', 'contraste']
            ],
            [
                'titulo' => 'FAQ - Perguntas Frequentes',
                'url' => route('pages.faq'),
                'descricao' => 'Respostas para as dúvidas mais comuns dos cidadãos.',
                'keywords' => ['ajuda', 'duvidas', 'perguntas', 'como fazer']
            ],
            [
                'titulo' => 'Oportunidades de Emprego',
                'url' => route('oportunidades'),
                'descricao' => 'Vagas de emprego formais disponíveis no município.',
                'keywords' => ['trabalho', 'vagas', 'emprego', 'agencia do trabalhador']
            ],
            [
                'titulo' => 'Saúde Assaí',
                'url' => 'https://saude.assai.pr.gov.br',
                'descricao' => 'Portal dedicado aos serviços de saúde do município.',
                'keywords' => ['medico', 'hospital', 'ubs', 'vacina', 'agendamento']
            ]
        ]);
    }

    private function applyInsensitiveSearch($query, array $columns, string $term): void
    {
        $driver = DB::connection()->getDriverName();
        $normalizedTerm = "%" . $this->normalizeSearchTerm($term) . "%";

        $query->where(function ($searchQuery) use ($columns, $driver, $normalizedTerm) {
            foreach ($columns as $index => $column) {
                $normalizedColumn = $this->normalizedColumnSql($column);
                $method = $index === 0 ? 'whereRaw' : 'orWhereRaw';
                $searchQuery->{$method}("$normalizedColumn LIKE ?", [$normalizedTerm]);
            }
        });
    }

    public function avancada(Request $request)
    {
        $perfil = $request->cookie('portal_perfil', 'todos');
        $termo = trim($request->input('q', ''));
        $categoria = $request->input('categoria');
        $modalidade = $request->input('modalidade');
        $tag = $request->input('tag');
        $servico = $request->input('servico');
        $somenteNovos = $request->has('somente_novos');

        $resultados = collect();

        if (!empty($termo) || $request->anyFilled(['categoria', 'modalidade', 'tag', 'servico'])) {

            $query = Servico::where('ativo', true);

            // Aplica filtro de Perfil
            $this->aplicarFiltroPerfil($query, $perfil);

            if (!empty($termo)) {
                $this->applyInsensitiveSearch($query, ['titulo', 'descricao'], $termo);
            }

            if (!empty($categoria)) {
                $query->where('categoria_id', $categoria);
            }

            if ($somenteNovos) {
                $query->where('created_at', '>=', now()->subDays(30));
            }

            $resultados = $query->paginate(15)->withQueryString();
        }

        return view('busca.resultados', compact(
            'resultados',
            'termo',
            'categoria',
            'modalidade',
            'tag',
            'servico',
            'somenteNovos'
        ));
    }
    /**
     * Exibe a página "Nossa Cidade".
     */
    public function nossaCidade()
    {
        return view('pages.cidade.nossa-cidade');
    }

    public function historiasSucesso()
    {
        return view('pages.cidade.historias-sucesso');
    }

    public function demografia()
    {
        return view('pages.cidade.demografia');
    }

    public function nossaCultura()
    {
        return view('pages.cidade.nossa-cultura');
    }

    public function qualidadeVida()
    {
        return view('pages.cidade.qualidade-vida');
    }
}
