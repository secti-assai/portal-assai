<?php

namespace App\Http\Controllers;

use App\Models\Noticia;
use App\Models\Servico;
use App\Models\Evento;
use App\Models\Programa;
use App\Models\Alerta;
use App\Models\Banner;
use App\Models\Secretaria;
use App\Models\ServicoAcesso;
use App\Models\TelefoneUtil;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class PortalController extends Controller
{
    // Página inicial
    public function index()
    {
        // 1. Busca os Banners (usando created_at em vez de ordem)
        $banners = Cache::remember('home_banners', 3600, function () {
            return Banner::where('ativo', true)
                ->orderBy('created_at', 'desc')
                ->get();
        });

        $alertasAtivos = Cache::remember('home_alertas', 3600, function () {
            return Alerta::where('ativo', true)
                ->orderBy('created_at', 'desc')
                ->get();
        });

        // 2. Busca as Notícias
        $noticias = Cache::remember('home_noticias', 3600, function () {
            return Noticia::orderBy('data_publicacao', 'desc')
                ->take(5)
                ->get();
        });

        // 3. Busca os Próximos 5 Eventos (todos os status; fechamento automático por data)
        $eventos = Cache::remember('home_eventos_v2', 3600, function () {
            return Evento::where(function ($query) {
                $query->whereNotNull('data_fim')
                      ->where('data_fim', '>=', now())
                      ->orWhere(function ($q) {
                          $q->whereNull('data_fim')
                            ->whereDate('data_inicio', '>=', today());
                      });
            })
            ->orderBy('data_inicio', 'asc')
            ->take(5)
            ->get();
        });

        // 4. Busca os Programas (Assaí em Ação) — destaques primeiro, complementa com os mais recentes
        $programas = Cache::remember('home_programas', 3600, function () {
            $destaques = Programa::where('ativo', true)
                ->where('destaque', true)
                ->latest()
                ->take(6)
                ->get();

            return $destaques->count() >= 6
                ? $destaques
                : $destaques->concat(
                    Programa::where('ativo', true)
                        ->where('destaque', false)
                        ->latest()
                        ->take(6 - $destaques->count())
                        ->get()
                );
        });

        // 5. Grelha principal: serviços ordenados pelo total histórico de acessos
        $servicos = Cache::remember('home_servicos', 3600, function () {
            return Servico::where('ativo', true)
                ->orderByDesc('acessos')
                ->take(8)
                ->get();
        });

        // Pegando os dados do Conecta com CACHE de 30 minutos (1800 segundos)
        $inscricoesAbertas = Cache::remember('inscricoes_conecta', 1800, function () {
            try {
                // ATENÇÃO: Troque a URL pelo link oficial do Conecta se já estiver em produção
                $response = Http::timeout(3)->get('https://conecta.assai.pr.gov.br/api/public/inscricoes-abertas');

                if ($response->successful()) {
                    return $response->json()['editais'] ?? [];
                }
            } catch (\Exception $e) {
                // Em caso de erro (ex: Conecta caiu), retorna array vazio e não derruba o Portal!
                return [];
            }

            return [];
        });

        // 6. Trending Topics: 4 serviços mais acessados nos últimos 7 dias (barra de pesquisa)
        $sugestoesIA = Servico::where('ativo', true)
            ->withCount(['acessosLog as acessos_recentes' => function ($query) {
                $query->where('created_at', '>=', Carbon::now()->subDays(7));
            }])
            ->orderByDesc('acessos_recentes')
            ->take(4)
            ->pluck('titulo');

        return view('pages.index', compact('banners', 'alertasAtivos', 'noticias', 'eventos', 'programas', 'servicos', 'inscricoesAbertas', 'sugestoesIA'));
    }

    // Página de notícias
    public function noticias(Request $request)
    {
        $categorias = Noticia::whereNotNull('categoria')
            ->distinct()
            ->orderBy('categoria')
            ->pluck('categoria');

        $query = Noticia::orderBy('data_publicacao', 'desc');

        if ($request->filled('q')) {
            $termo = $request->q;
            $query->where(function ($q) use ($termo) {
                $q->whereRaw('unaccent(titulo) ILIKE unaccent(?)', ["%{$termo}%"])
                  ->orWhereRaw('unaccent(resumo) ILIKE unaccent(?)', ["%{$termo}%"])
                  ->orWhereRaw('unaccent(conteudo) ILIKE unaccent(?)', ["%{$termo}%"]);
            });
        }

        if ($request->filled('categoria')) {
            $query->where('categoria', $request->categoria);
        }

        $noticias = $query->paginate(14)->withQueryString();
        return view('noticias.index', compact('noticias', 'categorias'));
    }

    public function agenda(Request $request)
    {
        // 1. Mês base: parâmetro ?mes=Y-m ou mês atual
        $mes      = $request->get('mes');
        $dataBase = $mes
            ? Carbon::createFromFormat('Y-m', $mes)->startOfMonth()
            : now()->startOfMonth();

        // 2. Variáveis de navegação e cabeçalho do mini-calendário
        $mesAnterior       = $dataBase->copy()->subMonth()->format('Y-m');
        $mesProximo        = $dataBase->copy()->addMonth()->format('Y-m');
        $tituloMes         = $dataBase->translatedFormat('F Y');
        $diasNoMes         = $dataBase->daysInMonth;
        $primeiroDiaSemana = $dataBase->dayOfWeek; // 0=Dom … 6=Sáb

        // 3. Dias com evento no mês visualizado (highlights do calendário)
        $diasComEvento = Evento::whereYear('data_inicio', $dataBase->year)
            ->whereMonth('data_inicio', $dataBase->month)
            ->get()
            ->map(fn($e) => $e->data_inicio->format('Y-m-d'))
            ->unique()
            ->values()
            ->all();

        // 4. Dados do calendário (compartilhados entre resposta AJAX e full-page)
        $calendarData = compact(
            'dataBase', 'mesAnterior', 'mesProximo', 'tituloMes',
            'diasNoMes', 'primeiroDiaSemana', 'diasComEvento'
        );

        // Resposta AJAX: devolve apenas o HTML do widget do calendário
        if ($request->ajax()) {
            return response(view('partials.calendario-widget', $calendarData)->render());
        }

        // 5. Feed principal: todos os eventos futuros paginados
        $eventos = Evento::where(function ($query) {
                $query->whereNotNull('data_fim')
                      ->where('data_fim', '>=', now())
                      ->orWhere(function ($q) {
                          $q->whereNull('data_fim')
                            ->whereDate('data_inicio', '>=', today());
                      });
            })
            ->orderBy('data_inicio', 'asc')
            ->paginate(12);

        return view('agenda.index', array_merge($calendarData, compact('eventos')));
    }

    public function eventoShow($id)
    {
        $evento = Evento::findOrFail($id);

        // Outros eventos futuros para sugestão no sidebar (exclui o atual)
        $outrosEventos = Evento::where('id', '!=', $id)
            ->where(function ($q) {
                $q->whereNotNull('data_fim')
                  ->where('data_fim', '>=', now())
                  ->orWhere(function ($q2) {
                      $q2->whereNull('data_fim')
                         ->whereDate('data_inicio', '>=', today());
                  });
            })
            ->orderBy('data_inicio', 'asc')
            ->take(3)
            ->get();

        return view('agenda.show', compact('evento', 'outrosEventos'));
    }

    public function secretarias()
    {
        // Puxa todas as secretarias por ordem alfabética
        $secretarias = \App\Models\Secretaria::orderBy('nome', 'asc')->get();
        return view('secretarias.index', compact('secretarias'));
    }

    public function servicos(Request $request)
    {
        $query = Servico::where('ativo', true)->with('secretaria')->orderBy('titulo');

        if ($request->filled('q')) {
            $termo = $request->q;
            $query->where(function ($q) use ($termo) {
                $q->where('titulo', 'like', "%{$termo}%");
            });
        }

        if ($request->filled('secretaria')) {
            $query->where('secretaria_id', $request->secretaria);
        }

        $servicos    = $query->paginate(12)->withQueryString();
        $secretarias = \App\Models\Secretaria::orderBy('nome')->get();

        return view('servicos.index', compact('servicos', 'secretarias'));
    }

    public function acessarServico($id)
    {
        $servico = Servico::findOrFail($id);

        // Contabiliza no histórico geral
        $servico->increment('acessos');

        // Regista no log semanal (usado pelas sugestões da barra de pesquisa)
        ServicoAcesso::create(['servico_id' => $servico->id]);

        $destino = $servico->url_acesso ?? $servico->link ?? route('servicos.index');

        return redirect($destino);
    }

    public function secretariaShow($id)
    {
        $secretaria = \App\Models\Secretaria::with(['servicos' => function ($query) {
            $query->where('ativo', true)->orderBy('titulo', 'asc');
        }])->findOrFail($id);

        return view('secretarias.show', compact('secretaria'));
    }

    public function contato()
    {
        return view('pages.contato');
    }


    public function contatoStore(Request $request)
    {
        $request->validate([
            'nome'     => 'required|string|min:2|max:120',
            'email'    => 'required|email|max:120',
            'assunto'  => 'required|string|min:3|max:200',
            'mensagem' => 'required|string|min:10|max:4000',
        ], [
            'nome.required'     => 'O nome é obrigatório.',
            'nome.min'          => 'O nome deve ter pelo menos 2 caracteres.',
            'email.required'    => 'O e-mail é obrigatório.',
            'email.email'       => 'Informe um e-mail válido.',
            'assunto.required'  => 'O assunto é obrigatório.',
            'assunto.min'       => 'O assunto deve ter pelo menos 3 caracteres.',
            'mensagem.required' => 'A mensagem é obrigatória.',
            'mensagem.min'      => 'A mensagem deve ter pelo menos 10 caracteres.',
            'mensagem.max'      => 'A mensagem pode ter no máximo 4000 caracteres.',
        ]);

        // Opcional: enviar e-mail ao configurar o MAIL no .env
        // Mail::raw(
        //     "Nome: {$request->nome}\nEmail: {$request->email}\n\nAssunto: {$request->assunto}\n\n{$request->mensagem}",
        //     fn ($m) => $m->to('contato@assai.pr.gov.br')->subject('[Portal] ' . $request->assunto)
        // );

        return back()->with('success', 'Mensagem enviada com sucesso! Entraremos em contato em breve.');
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

        $noticiasQuery = Noticia::query();
        $this->applyInsensitiveSearch($noticiasQuery, ['titulo', 'resumo', 'conteudo'], $termo);

        $noticias = $noticiasQuery
            ->select('id', 'titulo', 'slug')
            ->latest('data_publicacao')
            ->limit(3)
            ->get()
            ->map(fn($n) => [
                'titulo' => $n->titulo,
                'url'    => route('noticias.show', $n->slug),
                'tipo'   => 'Notícia',
            ]);

        $servicosQuery = Servico::where('ativo', true);
        $this->applyInsensitiveSearch($servicosQuery, ['titulo'], $termo);

        $servicos = $servicosQuery
            ->select('id', 'titulo')
            ->limit(3)
            ->get()
            ->map(fn($s) => [
                'titulo' => $s->titulo,
                'url'    => route('servicos.acessar', $s->id),
                'tipo'   => 'Serviço',
            ]);

        $programasQuery = Programa::where('ativo', true);
        $this->applyInsensitiveSearch($programasQuery, ['titulo', 'descricao'], $termo);

        $programas = $programasQuery
            ->select('id', 'titulo')
            ->limit(3)
            ->get()
            ->map(fn($p) => [
                'titulo' => $p->titulo,
                'url'    => route('programas.show', $p->id),
                'tipo'   => 'Programa',
            ]);

        $secretariasQuery = Secretaria::query();
        $this->applyInsensitiveSearch($secretariasQuery, ['nome', 'nome_secretario', 'descricao'], $termo);

        $secretarias = $secretariasQuery
            ->select('id', 'nome')
            ->limit(3)
            ->get()
            ->map(fn($sec) => [
                'titulo' => $sec->nome,
                'url'    => route('secretarias.show', $sec->id),
                'tipo'   => 'Secretaria',
            ]);

        $resultados = $noticias->concat($servicos)->concat($programas)->concat($secretarias)->values();

        return response()->json($resultados);
    }

    public function buscaGlobal(Request $request)
    {
        $termo = trim($request->input('q', ''));

        $noticias    = collect();
        $servicos    = collect();
        $eventos     = collect();
        $programas   = collect();
        $secretarias = collect();

        if (strlen($termo) >= 2) {
            $noticiasQuery = Noticia::query();
            $this->applyInsensitiveSearch($noticiasQuery, ['titulo', 'resumo', 'conteudo'], $termo);

            $noticias = $noticiasQuery
                ->orderBy('data_publicacao', 'desc')
                ->take(12)
                ->get();

            $servicosQuery = Servico::where('ativo', true);
            $this->applyInsensitiveSearch($servicosQuery, ['titulo'], $termo);

            $servicos = $servicosQuery
                ->take(9)
                ->get();

            $eventosQuery = Evento::where('status', '!=', 'cancelado');
            $this->applyInsensitiveSearch($eventosQuery, ['titulo', 'descricao', 'local'], $termo);

            $eventos = $eventosQuery
                ->orderBy('data_inicio', 'asc')
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
        $like = "%{$term}%";

        $query->where(function ($searchQuery) use ($columns, $driver, $like) {
            foreach ($columns as $index => $column) {
                if ($driver === 'pgsql') {
                    $method = $index === 0 ? 'whereRaw' : 'orWhereRaw';
                    $searchQuery->{$method}("unaccent({$column}) ILIKE unaccent(?)", [$like]);
                } else {
                    $method = $index === 0 ? 'where' : 'orWhere';
                    $searchQuery->{$method}($column, 'like', $like);
                }
            }
        });
    }
}
