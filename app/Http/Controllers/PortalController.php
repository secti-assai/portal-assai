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
use App\Models\Concurso;
use App\Models\Telefone;
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

        // 1. Notícia Destaque (Filtro Perfil Aplicado)
        $destaqueNoticia = $this->aplicarFiltroPerfil(
            Noticia::publicadas()->where('destaque', true)->latest('data_publicacao'),
            $perfil
        )->first();

        if (!$destaqueNoticia) {
            $destaqueNoticia = $this->aplicarFiltroPerfil(
                Noticia::publicadas()->latest('data_publicacao'),
                $perfil
            )->first();
        }

        // 2. Notícias Recentes (Excluindo o destaque)
        $recentesSidebar = $this->aplicarFiltroPerfil(
            Noticia::publicadas()
                ->when($destaqueNoticia, fn($q) => $q->where('id', '!=', $destaqueNoticia->id))
                ->latest('data_publicacao'),
            $perfil
        )->take(3)->get();

        // 3. Categorias para o Select (Temas)
        $categoriasNoticias = \App\Models\Categoria::where('ativo', true)
            ->whereHas('noticias', function($q) {
                $q->where('ativo', true)->whereDate('data_publicacao', '<=', today());
            })
            ->orderBy('nome')
            ->get();

        // Notícias - Coleção geral (fallback ou uso mobile)
        $noticias = collect([$destaqueNoticia])->filter()->concat($recentesSidebar);

        // 4. Eventos para o Calendário e Listagem
        // Pega todos do mês para o calendário
        $dataBaseHome = request('mes') ? Carbon::createFromFormat('Y-m', request('mes'))->startOfMonth() : now()->startOfMonth();
        $eventosNoMesQuery = Evento::futurosPublicos()
            ->whereYear('data_inicio', $dataBaseHome->year)
            ->whereMonth('data_inicio', $dataBaseHome->month);
        $eventosNoMes = $this->aplicarFiltroPerfil($eventosNoMesQuery, $perfil)->get();

        // Pega os 4 próximos para a listagem lateral
        $eventos = $eventosNoMes->sortBy('data_inicio')->take(4);

        // Programas Destaque (Filtro Perfil Aplicado)
        $destaquesProgQuery = Programa::where('ativo', true)
            ->where('destaque', true)
            ->latest()
            ->take(7);
        $destaques = $this->aplicarFiltroPerfil($destaquesProgQuery, $perfil)->get();

        $programas = $destaques->count() >= 7
            ? $destaques
            : $destaques->concat(
                $this->aplicarFiltroPerfil(
                    Programa::where('ativo', true)->where('destaque', false)->latest()->take(7 - $destaques->count()),
                    $perfil
                )->get()
            );

        $bannersDestaque = BannerDestaque::where('ativo', true)
            ->orderBy('ordem', 'asc')
            ->orderBy('created_at', 'desc')
            ->get();

        // 1. Serviços "Mais Acessados" Reais (Locais e Conecta já rastreados)
        $maisAcessadosQuery = Servico::where('ativo', true)
            ->orderByDesc('acessos')
            ->take(10);
        $maisAcessados = $this->aplicarFiltroPerfil($maisAcessadosQuery, $perfil)->get();

        // 2. Mapeia os já existentes
        $servicosHome = $maisAcessados->map(fn($s) => [
            'titulo'     => $s->titulo,
            'icone'      => $s->icone,
            'link'       => route('servicos.acessar', $s->id),
            'is_conecta' => !is_null($s->id_conecta),
        ]);

        // 3. Complementa com serviços do Conecta se houver menos de 10
        if ($servicosHome->count() < 10) {
            $conectaRaw = $conectaApi->getTodosServicos($perfil);
            
            // Filtra os que já estão no banco para não repetir
            $idsConectaNoBanco = $maisAcessados->whereNotNull('id_conecta')->pluck('id_conecta')->toArray();
            
            $conectaRestantes = collect($conectaRaw)
                ->reject(fn($s) => in_array($s['id_conecta'] ?? '', $idsConectaNoBanco))
                ->take(10 - $servicosHome->count())
                ->map(fn($s) => [
                    'titulo'     => $s['titulo'] ?? '',
                    'icone'      => $s['icone']  ?? 'fa-solid fa-laptop-code',
                    'link'       => route('servicos.acessar.conecta', [
                        'id_conecta' => $s['id_conecta'] ?? '',
                        'titulo'     => $s['titulo'] ?? '',
                        'link'       => rtrim(config('services.conecta.url'), '/') . '/servico/' . ($s['id_conecta'] ?? ''),
                        'icone'      => $s['icone']  ?? 'fa-solid fa-laptop-code'
                    ]),
                    'is_conecta' => true,
                ]);
                
            $servicosHome = $servicosHome->concat($conectaRestantes);
        }

        $servicos = $maisAcessados; // Para compatibilidade com outras partes se necessário

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

        $eventosPorDiaHome = [];
        foreach ($eventosNoMes as $e) {
            $data = $e->data_inicio->format('Y-m-d');
            $eventosPorDiaHome[$data][] = [
                'id' => $e->id,
                'titulo' => $e->titulo,
                'hora' => $e->data_inicio->format('H:i'),
                'local' => $e->local,
                'url' => route('agenda.show', $e->id),
                'resumo' => \Illuminate\Support\Str::limit(strip_tags($e->descricao), 80)
            ];
        }

        return view('pages.pagina', compact(
            'banners',
            'alertasAtivos',
            'noticias',
            'destaqueNoticia',
            'recentesSidebar',
            'categoriasNoticias',
            'eventos',
            'eventosPorDiaHome',
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

    /**
     * Busca notícias por tema (AJAX) para a Home.
     */
    public function ajaxNoticias(Request $request)
    {
        $perfil = $request->cookie('portal_perfil', 'todos');
        $categoriaId = $request->get('categoria');
        $excludeIds = $request->get('exclude', []);

        $query = Noticia::publicadas()
            ->with('categorias')
            ->whereHas('categorias', function($q) use ($categoriaId) {
                if (is_numeric($categoriaId)) {
                    $q->where('categorias.id', $categoriaId);
                } else {
                    $q->where('categorias.nome', $categoriaId);
                }
            })
            ->whereNotIn('id', $excludeIds)
            ->latest('data_publicacao')
            ->take(3);

        $noticias = $this->aplicarFiltroPerfil($query, $perfil)->get();

        // Mapeia para que o JS receba o nome da categoria
        $noticias->map(function($n) {
            $n->categoria_nome = $n->categorias->first()?->nome ?? 'Notícia';
            return $n;
        });

        return response()->json($noticias);
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

        if ($request->filled('periodo')) {
            $periodo = $request->periodo;
            switch ($periodo) {
                case '7d':
                    $query->whereDate('data_publicacao', '>=', now()->subDays(7));
                    break;
                case '30d':
                    $query->whereDate('data_publicacao', '>=', now()->subDays(30));
                    break;
                case '90d':
                    $query->whereDate('data_publicacao', '>=', now()->subDays(90));
                    break;
                case 'ano':
                    $query->whereYear('data_publicacao', now()->year);
                    break;
            }
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

        $eventosNoMes = $this->aplicarFiltroPerfil($diasComEventoQuery, $perfil)->get();

        $eventosPorDia = [];
        foreach ($eventosNoMes as $e) {
            $data = $e->data_inicio->format('Y-m-d');
            $eventosPorDia[$data][] = [
                'id' => $e->id,
                'titulo' => $e->titulo,
                'hora' => $e->data_inicio->format('H:i'),
                'local' => $e->local,
                'url' => route('agenda.show', $e->id),
                'resumo' => \Illuminate\Support\Str::limit(strip_tags($e->descricao), 80)
            ];
        }

        $calendarData = compact(
            'dataBase',
            'mesAnterior',
            'mesProximo',
            'tituloMes',
            'diasNoMes',
            'primeiroDiaSemana',
            'eventosPorDia'
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
            'icone'     => $s['icone'] ?? 'fa-solid fa-laptop-code',
            'orgao'     => $s['orgao'] ?? null,
            'link'      => route('servicos.acessar.conecta', [
                'id_conecta' => $s['id_conecta'] ?? '',
                'titulo'     => $s['titulo'] ?? '',
                'link'       => rtrim(config('services.conecta.url'), '/') . '/servico/' . ($s['id_conecta'] ?? ''),
                'icone'      => $s['icone']  ?? 'fa-solid fa-laptop-code'
            ]),
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

    public function acessarServicoConecta(Request $request)
    {
        $idConecta = $request->id_conecta;
        
        if (!$idConecta) {
            return redirect()->back();
        }

        // Busca ou cria o registro local para este serviço do Conecta
        $servico = Servico::firstOrCreate(
            ['id_conecta' => $idConecta],
            [
                'titulo' => $request->titulo ?? 'Serviço Conecta',
                'icone'  => $request->icone  ?? 'fa-solid fa-laptop-code',
                'link'   => $request->link   ?? config('services.conecta.url'),
                'ativo'  => true,
            ]
        );

        $servico->increment('acessos');
        ServicoAcesso::create(['servico_id' => $servico->id]);

        return redirect($servico->link);
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
                'url' => route('servicos.acessar.conecta', [
                    'id_conecta' => $s['id_conecta'] ?? '',
                    'titulo'     => $s['titulo'] ?? '',
                    'link'       => rtrim(config('services.conecta.url'), '/') . '/servico/' . ($s['id_conecta'] ?? ''),
                    'icone'      => $s['icone']  ?? 'fa-solid fa-laptop-code'
                ]),
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
                    'icone' => $s['icone'] ?? 'fa-solid fa-laptop-code',
                    'url_acesso' => route('servicos.acessar.conecta', [
                        'id_conecta' => $s['id_conecta'] ?? '',
                        'titulo'     => $s['titulo'] ?? '',
                        'link'       => rtrim(config('services.conecta.url'), '/') . '/servico/' . ($s['id_conecta'] ?? ''),
                        'icone'      => $s['icone']  ?? 'fa-solid fa-laptop-code'
                    ]),
                    'link' => route('servicos.acessar.conecta', [
                        'id_conecta' => $s['id_conecta'] ?? '',
                        'titulo'     => $s['titulo'] ?? '',
                        'link'       => rtrim(config('services.conecta.url'), '/') . '/servico/' . ($s['id_conecta'] ?? ''),
                        'icone'      => $s['icone']  ?? 'fa-solid fa-laptop-code'
                    ]),
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
            
            if ($request->filled('data_inicio')) {
                $eventosQuery->whereDate('data_inicio', '>=', $request->data_inicio);
            }
            if ($request->filled('data_fim')) {
                $eventosQuery->whereDate('data_inicio', '<=', $request->data_fim);
            }

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

            if ($request->filled('categoria')) {
                $noticiasQuery->where('categoria', $request->categoria);
            }
            if ($request->filled('data_inicio')) {
                $noticiasQuery->whereDate('data_publicacao', '>=', $request->data_inicio);
            }
            if ($request->filled('data_fim')) {
                $noticiasQuery->whereDate('data_publicacao', '<=', $request->data_fim);
            }

            $noticias = $noticiasQuery
                ->whereDate('data_publicacao', '<=', today())
                ->orderBy('data_publicacao', 'desc')
                ->orderBy('created_at', 'desc')
                ->take(12)
                ->get();
        }

        $categorias = Noticia::publicadas()
            ->whereNotNull('categoria')
            ->distinct()
            ->orderBy('categoria')
            ->pluck('categoria');

        return view('pages.busca', compact(
            'termo', 
            'noticias', 
            'servicos', 
            'eventos', 
            'programas', 
            'secretarias', 
            'paginas', 
            'respostaInteligente',
            'categorias'
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

    public function concursos()
    {
        $concursos = Concurso::where('ativo', true)->latest()->paginate(12);
        return view('pages.concursos', compact('concursos'));
    }

    public function telefones()
    {
        $telefones = Telefone::where('ativo', true)
            ->with('secretaria')
            ->orderBy('nome')
            ->get()
            ->groupBy(function($item) {
                return $item->secretaria ? $item->secretaria->nome : 'Diversos';
            });

        return view('pages.telefones', compact('telefones'));
    }

    public function galeriaFotos()
    {
        $fotos = \App\Models\Noticia::whereNotNull('imagem_capa')
            ->where('imagem_capa', '!=', '')
            ->orderBy('data_publicacao', 'desc')
            ->paginate(24);

        return view('pages.cidade.galeria-fotos', compact('fotos'));
    }
}
