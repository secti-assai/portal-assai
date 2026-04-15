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
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Carbon\Carbon;
use App\Support\Concerns\NormalizesSearch;
use App\Models\Executivo;

class PortalController extends Controller
{
    use NormalizesSearch;

    // Página inicial
    public function index()
    {
        $banners = Banner::where('ativo', true)
            ->orderBy('created_at', 'desc')
            ->get();

        $portais = \App\Models\Portal::where('ativo', true)
            ->get();

        $alertasAtivos = Alerta::where('ativo', true)
            ->orderBy('created_at', 'desc')
            ->get();

        // 1. Busca Notícias marcadas como Destaque (Para o Slider)
        $destaquesSlider = Noticia::publicadas()
            ->where('destaque', true)
            ->orderBy('data_publicacao', 'desc')
            ->orderBy('created_at', 'desc')
            ->take(3)
            ->get();

        // 2. Busca Notícias Recentes ignorando as que já estão no Destaque (Para a Sidebar)
        $recentesSidebar = Noticia::publicadas()
            ->whereNotIn('id', $destaquesSlider->pluck('id'))
            ->orderBy('data_publicacao', 'desc')
            ->orderBy('created_at', 'desc')
            ->take(3)
            ->get();

        // 3. Mescla as coleções para manter a variável $noticias populada na view
        $noticias = $destaquesSlider->concat($recentesSidebar);

        $eventos = Evento::futurosPublicos()
            ->ordenarPorDataMaisProxima()
            ->take(4)
            ->get();

        $destaques = Programa::where('ativo', true)
            ->where('destaque', true)
            ->latest()
            ->take(3)
            ->get();

        $programas = $destaques->count() >= 3
            ? $destaques
            : $destaques->concat(
                Programa::where('ativo', true)
                    ->where('destaque', false)
                    ->latest()
                    ->take(3 - $destaques->count())
                    ->get()
            );

        $bannersDestaque = BannerDestaque::where('ativo', true)
            ->orderBy('ordem', 'asc')
            ->orderBy('created_at', 'desc')
            ->get();

        $servicos = Servico::where('ativo', true)
            ->orderByDesc('acessos')
            ->take(10)
            ->get();

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

        $sugestoesIA = Servico::where('ativo', true)
            ->withCount([
                'acessosLog as acessos_recentes' => function ($query) {
                    $query->where('created_at', '>=', Carbon::now()->subDays(7));
                }
            ])
            ->orderByDesc('acessos_recentes')
            ->take(3)
            ->pluck('titulo');

        return view('pages.pagina', compact(
            'banners',
            'alertasAtivos',
            'noticias',
            'destaquesSlider',
            'recentesSidebar',
            'eventos',
            'programas',
            'servicos',
            'inscricoesAbertas',
            'sugestoesIA',
            'portais',
            'bannersDestaque'
        ));
    }

    // Página de notícias
    public function noticias(Request $request)
    {
        $categorias = Noticia::publicadas()
            ->whereNotNull('categoria')
            ->distinct()
            ->orderBy('categoria')
            ->pluck('categoria');

        $query = Noticia::publicadas()
            ->orderBy('data_publicacao', 'desc')
            ->orderBy('created_at', 'desc');

        if ($request->filled('q')) {
            $termo = $request->q;
            $query->where(function ($q) use ($termo) {
                $q->whereRaw('titulo ILIKE ?', ["%{$termo}%"])
                    ->orWhereRaw('resumo ILIKE ?', ["%{$termo}%"])
                    ->orWhereRaw('conteudo ILIKE ?', ["%{$termo}%"]);
            });
        }

        if ($request->filled('categoria')) {
            $query->where('categoria', $request->categoria);
        }

        $noticias = $query->paginate(15)->withQueryString();
        return view('noticias.index', compact('noticias', 'categorias'));
    }

    public function agenda(Request $request)
    {
        $mes = $request->get('mes');
        $dataBase = $mes
            ? Carbon::createFromFormat('Y-m', $mes)->startOfMonth()
            : now()->startOfMonth();

        $mesAnterior = $dataBase->copy()->subMonth()->format('Y-m');
        $mesProximo = $dataBase->copy()->addMonth()->format('Y-m');
        $tituloMes = $dataBase->translatedFormat('F Y');
        $diasNoMes = $dataBase->daysInMonth;
        $primeiroDiaSemana = $dataBase->dayOfWeek;

        $diasComEvento = Evento::futurosPublicos()
            ->whereYear('data_inicio', $dataBase->year)
            ->whereMonth('data_inicio', $dataBase->month)
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

        $eventos = Evento::publico()
            ->ordenarPorDataMaisProxima()
            ->paginate(4)
            ->withQueryString();

        return view('agenda.index', array_merge($calendarData, compact('eventos')));
    }

    public function eventoShow($id)
    {
        $evento = Evento::findOrFail($id);

        $outrosEventos = Evento::where('id', '!=', $id)
            ->publico()
            ->ordenarPorDataMaisProxima()
            ->take(3)
            ->get();

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

    public function servicos(Request $request)
    {
        $query = Servico::where('ativo', true)->with('secretaria')->orderBy('titulo');

        if ($request->filled('search')) {
            $termo = $request->string('search')->trim()->toString();
            $query->where(function ($q) use ($termo) {
                $busca = '%' . $this->normalizeSearchTerm($termo) . '%';

                $q->whereRaw($this->normalizedColumnSql('titulo') . ' LIKE ?', [$busca])
                    ->orWhereRaw($this->normalizedColumnSql('link') . ' LIKE ?', [$busca]);
            });
        }

        if ($request->filled('secretaria')) {
            $query->where('secretaria_id', $request->secretaria);
        }

        $servicos = $query->paginate(21)->withQueryString();
        $secretarias = \App\Models\Secretaria::orderBy('nome')->get();

        return view('servicos.index', compact('servicos', 'secretarias'));
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

    public function programas()
    {
        $programas = \App\Models\Programa::where('ativo', true)
            ->orderBy('created_at', 'desc')
            ->paginate(12);

        return view('programas.index', compact('programas'));
    }

    public function showPrograma(Programa $programa)
    {
        abort_unless($programa->ativo, 404);
        return view('programas.show', compact('programa'));
    }

    public function autocomplete(Request $request)
    {
        $termo = trim($request->get('q', ''));

        if (strlen($termo) < 2) {
            return response()->json([]);
        }

        $noticiasQuery = Noticia::where('ativo', true);
        $this->applyInsensitiveSearch($noticiasQuery, ['titulo', 'resumo', 'conteudo'], $termo);

        $noticias = $noticiasQuery
            ->select('id', 'titulo', 'slug')
            ->latest('data_publicacao')
            ->limit(3)
            ->get()
            ->map(fn($n) => [
                'titulo' => $n->titulo,
                'url' => route('noticias.show', $n->slug),
                'tipo' => 'Notícia',
            ]);

        $servicosQuery = Servico::where('ativo', true);
        $this->applyInsensitiveSearch($servicosQuery, ['titulo'], $termo);

        $servicos = $servicosQuery
            ->select('id', 'titulo')
            ->limit(3)
            ->get()
            ->map(fn($s) => [
                'titulo' => $s->titulo,
                'url' => route('servicos.acessar', $s->id),
                'tipo' => 'Serviço',
            ]);

        $programasQuery = Programa::where('ativo', true);
        $this->applyInsensitiveSearch($programasQuery, ['titulo', 'descricao'], $termo);

        $programas = $programasQuery
            ->select('id', 'titulo')
            ->limit(3)
            ->get()
            ->map(fn($p) => [
                'titulo' => $p->titulo,
                'url' => route('programas.show', $p->id),
                'tipo' => 'Programa',
            ]);

        $secretariasQuery = Secretaria::query();
        $this->applyInsensitiveSearch($secretariasQuery, ['nome', 'nome_secretario', 'descricao'], $termo);

        $secretarias = $secretariasQuery
            ->select('id', 'nome')
            ->limit(3)
            ->get()
            ->map(fn($sec) => [
                'titulo' => $sec->nome,
                'url' => route('secretarias.show', $sec->id),
                'tipo' => 'Secretaria',
            ]);

        $resultados = $noticias->concat($servicos)->concat($programas)->concat($secretarias)->values();

        return response()->json($resultados);
    }

    public function buscaGlobal(Request $request)
    {
        $termo = trim($request->input('q', ''));

        $noticias = collect();
        $servicos = collect();
        $eventos = collect();
        $programas = collect();
        $secretarias = collect();

        if (strlen($termo) >= 2) {
            $noticiasQuery = Noticia::where('ativo', true);
            $this->applyInsensitiveSearch($noticiasQuery, ['titulo', 'resumo', 'conteudo'], $termo);

            $noticias = $noticiasQuery
                ->whereDate('data_publicacao', '<=', today())
                ->orderBy('data_publicacao', 'desc')
                ->orderBy('created_at', 'desc')
                ->take(12)
                ->get();

            $servicosQuery = Servico::where('ativo', true);
            $this->applyInsensitiveSearch($servicosQuery, ['titulo'], $termo);

            $servicos = $servicosQuery
                ->take(9)
                ->get();

            $eventosQuery = Evento::publico()->ordenarPorDataMaisProxima();
            $this->applyInsensitiveSearch($eventosQuery, ['titulo', 'descricao', 'local'], $termo);

            $eventos = $eventosQuery
                ->take(8)
                ->get();

            $programasQuery = Programa::where('ativo', true);
            $this->applyInsensitiveSearch($programasQuery, ['titulo', 'descricao'], $termo);

            $programas = $programasQuery
                ->take(9)
                ->get();

            $secretariasQuery = Secretaria::query();
            $this->applyInsensitiveSearch($secretariasQuery, ['nome', 'nome_secretario', 'descricao'], $termo);

            $secretarias = $secretariasQuery
                ->take(6)
                ->get();
        }

        return view('pages.busca', compact('termo', 'noticias', 'servicos', 'eventos', 'programas', 'secretarias'));
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
        $termo = trim($request->input('q', ''));
        $categoria = $request->input('categoria');
        $modalidade = $request->input('modalidade');
        $tag = $request->input('tag');
        $servico = $request->input('servico');
        $somenteNovos = $request->has('somente_novos');

        $resultados = collect();

        if (!empty($termo) || $request->anyFilled(['categoria', 'modalidade', 'tag', 'servico'])) {

            $query = Servico::where('ativo', true);

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
}