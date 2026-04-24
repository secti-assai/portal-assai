<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;
use App\Http\Controllers\ActivityLogController;
use App\Http\Controllers\PortalController;
use App\Http\Controllers\NoticiaController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\AlertaController;
use App\Http\Controllers\BannerController;
use App\Http\Controllers\ProgramaController;
use App\Http\Controllers\EventoController;
use App\Http\Controllers\SecretariaController;
use App\Http\Controllers\ServicoController;
use App\Http\Controllers\ExecutivoController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\BannerDestaqueController;
use App\Http\Controllers\RedeSocialController;
use App\Http\Controllers\PerfilController;
use App\Http\Controllers\VagaController;
use App\Http\Controllers\Admin\VagaAdminController;

// ================= ROTAS PÚBLICAS (O SITE) =================

Route::get('/', [PortalController::class, 'index'])->name('home');

Route::redirect('/novo', '/', 301);

Route::view('/em-desenvolvimento', 'pages.em-desenvolvimento')->name('em-desenvolvimento');

Route::post('/perfil/definir', [PerfilController::class, 'definir'])->name('perfil.definir');

Route::get('/noticias', [PortalController::class, 'noticias'])->name('noticias.index');
Route::get('/noticia/{slug}', [NoticiaController::class, 'show'])->name('noticias.show');

// Agenda
Route::get('/agenda', [PortalController::class, 'agenda'])->name('agenda.index');
Route::get('/agenda/{id}', [PortalController::class, 'eventoShow'])->name('agenda.show');

// Secretarias
Route::get('/secretarias', [PortalController::class, 'secretarias'])->name('secretarias.index');
Route::get('/secretarias/{id}', [PortalController::class, 'secretariaShow'])->name('secretarias.show');

// Busca
Route::get('/pesquisar', [PortalController::class, 'buscaGlobal'])->name('busca.index');
Route::get('/busca/autocomplete', [PortalController::class, 'autocomplete'])->name('busca.autocomplete');
Route::get('/busca/avancada', [PortalController::class, 'avancada'])->name('busca.avancada');

Route::get('/api/plantao-hoje', function () {
    $cacheKey = 'portal_plantao_hoje';
    $cachedPayload = Cache::get($cacheKey);

    if (
        is_array($cachedPayload)
        && ($cachedPayload['message'] ?? null) !== 'Plantao indisponivel'
    ) {
        return response()->json($cachedPayload);
    }

    try {
        $endpoint = 'https://informativos.assai.pr.gov.br/';
        $response = null;

        try {
            $response = Http::timeout(15)->accept('text/html')->get($endpoint);
        } catch (\Throwable $exception) {
            $response = null;
        }

        if (!$response || !$response->ok()) {
            $response = Http::withoutVerifying()->timeout(15)->accept('text/html')->get($endpoint);
        }

        if (!$response->ok()) {
            return response()->json([
                'hasDuty' => false,
                'message' => 'Plantao indisponivel',
            ]);
        }

        $html = $response->body();
        $matches = [];

        if (!preg_match('/var\s+booking\s*=\s*(\[[\s\S]*?\]);/u', $html, $matches) || empty($matches[1])) {
            return response()->json([
                'hasDuty' => false,
                'message' => 'Plantao indisponivel',
            ]);
        }

        $events = json_decode($matches[1], true, 512, JSON_THROW_ON_ERROR);
        $today = now('America/Sao_Paulo')->toDateString();

        $todayEvents = array_values(array_filter($events, static function (array $event) use ($today): bool {
            if (!isset($event['start'])) {
                return false;
            }

            return str_starts_with((string) $event['start'], $today);
        }));

        $pickDuty = static function (string $type) use ($todayEvents): ?array {
            foreach ($todayEvents as $event) {
                if (($event['type'] ?? '') === $type) {
                    return [
                        'title' => $event['title'] ?? null,
                        'address' => $event['address'] ?? null,
                        'contact' => $event['contact'] ?? null,
                        'type' => $event['type'] ?? null,
                    ];
                }
            }

            return null;
        };

        $pickFuelDuty = static function () use ($todayEvents): ?array {
            $fuelKeywords = ['combust', 'gasolina', 'etanol', 'diesel', 'auto posto', 'posto de combustivel'];
            $healthKeywords = ['saude', 'ubs', 'unidade basica', 'hospital', 'clinica', 'vacina'];

            foreach ($todayEvents as $event) {
                if (($event['type'] ?? '') !== 'Posto') {
                    continue;
                }

                $haystack = mb_strtolower(trim((string) (($event['title'] ?? '') . ' ' . ($event['address'] ?? '') . ' ' . ($event['type'] ?? ''))));

                $hasHealthHint = false;
                foreach ($healthKeywords as $keyword) {
                    if ($keyword !== '' && str_contains($haystack, $keyword)) {
                        $hasHealthHint = true;
                        break;
                    }
                }

                if ($hasHealthHint) {
                    continue;
                }

                $hasFuelHint = false;
                foreach ($fuelKeywords as $keyword) {
                    if ($keyword !== '' && str_contains($haystack, $keyword)) {
                        $hasFuelHint = true;
                        break;
                    }
                }

                if ($hasFuelHint || trim((string) ($event['type'] ?? '')) === 'Posto') {
                    return [
                        'title' => $event['title'] ?? null,
                        'address' => $event['address'] ?? null,
                        'contact' => $event['contact'] ?? null,
                        'type' => 'Posto de combustivel',
                    ];
                }
            }

            return null;
        };

        $farmacia = $pickDuty('Farmácia');
        $posto = $pickFuelDuty();

        $payload = [
            'hasDuty' => ($farmacia !== null || $posto !== null),
            'date' => $today,
            'farmacia' => $farmacia,
            'posto' => $posto,
            'message' => ($farmacia !== null || $posto !== null) ? null : 'Sem plantao hoje',
        ];

        Cache::put($cacheKey, $payload, now()->addMinutes(20));

        return response()->json($payload);
    } catch (\Throwable $exception) {
        return response()->json([
            'hasDuty' => false,
            'message' => 'Plantao indisponivel',
        ]);
    }
})->name('api.plantao.hoje');

Route::get('/api/clima-atual', function () {
    $cacheKey = 'portal_clima_atual';
    $cachedPayload = Cache::get($cacheKey);

    if (is_array($cachedPayload) && ($cachedPayload['error'] ?? true) === false) {
        return response()->json($cachedPayload);
    }

    try {
        $endpoint = 'https://api.open-meteo.com/v1/forecast';
        $query = [
            'latitude' => -23.3733,
            'longitude' => -50.8417,
            'current' => 'temperature_2m,apparent_temperature,relative_humidity_2m,precipitation,weather_code,wind_speed_10m',
            'temperature_unit' => 'celsius',
            'wind_speed_unit' => 'kmh',
            'precipitation_unit' => 'mm',
            'timezone' => 'America/Sao_Paulo',
        ];

        $response = null;

        try {
            $response = Http::timeout(15)->acceptJson()->get($endpoint, $query);
        } catch (\Throwable $exception) {
            $response = null;
        }

        if (!$response || !$response->ok()) {
            $response = Http::withoutVerifying()->timeout(15)->acceptJson()->get($endpoint, $query);
        }

        if (!$response->ok()) {
            return response()->json([
                'current' => null,
                'error' => true,
            ]);
        }

        $payload = [
            'current' => $response->json('current'),
            'error' => false,
        ];

        Cache::put($cacheKey, $payload, now()->addMinutes(15));

        return response()->json($payload);
    } catch (\Throwable $exception) {
        return response()->json([
            'current' => null,
            'error' => true,
        ]);
    }
})->name('api.clima.atual');

// ── API Calendário Mobile ─────────────────────────────────────────────────────
// Retorna os dias do mês para re-renderização via AJAX.
Route::get('/api/calendario', static function () {
    $mesParam = request()->query('mes');

    try {
        $month = (is_string($mesParam) && preg_match('/^\d{4}-\d{2}$/', $mesParam) === 1)
            ? \Carbon\Carbon::createFromFormat('Y-m', $mesParam)->startOfMonth()
            : \Carbon\Carbon::now()->startOfMonth();
    } catch (\Throwable) {
        $month = \Carbon\Carbon::now()->startOfMonth();
    }

    $start = $month->copy()->startOfWeek(\Carbon\Carbon::SUNDAY);
    $end   = $month->copy()->endOfMonth()->endOfWeek(\Carbon\Carbon::SATURDAY);

    $eventDates = \App\Models\Evento::query()
        ->whereNotNull('data_inicio')
        ->whereBetween('data_inicio', [$month->copy()->startOfMonth(), $month->copy()->endOfMonth()])
        ->get()
        ->map(fn($e) => \Carbon\Carbon::parse($e->data_inicio)->toDateString())
        ->unique()
        ->values()
        ->all();

    $dias   = [];
    $cursor = $start->copy();
    while ($cursor->lte($end)) {
        $dias[] = [
            'day'            => (int) $cursor->format('j'),
            'isCurrentMonth' => $cursor->month === $month->month,
            'isToday'        => $cursor->isToday(),
            'hasEvent'       => in_array($cursor->toDateString(), $eventDates, true),
        ];
        $cursor->addDay();
    }

    return response()->json([
        'mes'      => $month->format('Y-m'),
        'tituloMes' => mb_strtolower($month->locale('pt_BR')->translatedFormat('F Y')),
        'dias'     => $dias,
    ]);
})->name('api.calendario');

// Navega para o mês anterior ou próximo e retorna o novo mês no formato Y-m.
Route::get('/api/calendario-prev-next', static function () {
    $mesParam = request()->query('mes');
    $dir      = request()->query('dir', 'next');

    try {
        $month = (is_string($mesParam) && preg_match('/^\d{4}-\d{2}$/', $mesParam) === 1)
            ? \Carbon\Carbon::createFromFormat('Y-m', $mesParam)->startOfMonth()
            : \Carbon\Carbon::now()->startOfMonth();
    } catch (\Throwable) {
        $month = \Carbon\Carbon::now()->startOfMonth();
    }

    $result = $dir === 'prev'
        ? $month->subMonth()->format('Y-m')
        : $month->addMonth()->format('Y-m');

    return response()->json(['mes' => $result]);
})->name('api.calendario.nav');

// Serviços ao Cidadão
Route::get('/servicos', [PortalController::class, 'servicos'])->name('servicos.index');

// Tracking de cliques em serviços
Route::get('/servico/{id}/acessar', [PortalController::class, 'acessarServico'])->name('servicos.acessar');

// Contato
Route::get('/contato', [PortalController::class, 'contato'])->name('contato.index');
Route::post('/contato', [PortalController::class, 'enviarContato'])->name('contato.store');

// Programas
Route::get('/programas', [PortalController::class, 'programas'])->name('programas.index');
Route::get('/programas/{programa}', [PortalController::class, 'showPrograma'])->name('programas.show');

// Páginas Estáticas
Route::prefix('cidade')->name('cidade.')->group(function () {
    Route::get('/nossa-cidade', [PortalController::class, 'nossaCidade'])->name('nossa-cidade');
    Route::get('/nossa-cultura', [PortalController::class, 'nossaCultura'])->name('nossa-cultura');
    Route::get('/demografia', [PortalController::class, 'demografia'])->name('demografia');
    Route::get('/historias-de-sucessos', [PortalController::class, 'historiasSucesso'])->name('historias-sucesso');
    Route::get('/qualidade-de-vida', [PortalController::class, 'qualidadeVida'])->name('qualidade-vida');
});
Route::view('/turismo', 'pages.turismo')->name('pages.turismo');
Route::view('/transparencia', 'pages.transparencia')->name('pages.transparencia');
Route::view('/acessibilidade', 'pages.acessibilidade')->name('pages.acessibilidade');
Route::view('/faq', 'pages.faq')->name('pages.faq');
Route::view('/lgpd', 'pages.lgpd')->name('pages.lgpd');
Route::view('/cookies', 'pages.cookies')->name('pages.cookies');
Route::view('/termos-de-uso', 'pages.termos')->name('pages.termos');

// Substituir as rotas Route::view estáticas pelas dinâmicas
Route::get('/oportunidades', [VagaController::class, 'formais'])->name('oportunidades');
Route::get('/trabalhos-informais', [VagaController::class, 'informais'])->name('trabalhos-informais');


// ================= ROTAS DE LOGIN =================
Route::get('/login', [AuthController::class, 'login'])->name('login');
Route::post('/login', [AuthController::class, 'authenticate'])->name('authenticate');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// ================= ROTAS DO PAINEL ADMIN =================
Route::middleware('auth')->prefix('admin')->group(function () {

    // A rota principal do painel (Acessada via /admin)
    Route::get('/', [AdminController::class, 'dashboard'])
        ->name('admin.dashboard');

    Route::middleware('role:admin')->group(function () {
        Route::get('/auditoria', [ActivityLogController::class, 'index'])->name('admin.activity-logs.index');
        Route::get('/auditoria/exportar', [ActivityLogController::class, 'export'])->name('admin.activity-logs.export');
        Route::get('/auditoria/{activity}', [ActivityLogController::class, 'show'])->name('admin.activity-logs.show');

        // Módulo de Gestão de Utilizadores
        Route::resource('users', UserController::class)->except(['show'])->names([
            'index'   => 'users.index',
            'create'  => 'admin.users.create',
            'store'   => 'admin.users.store',
            'edit'    => 'admin.users.edit',
            'update'  => 'admin.users.update',
            'destroy' => 'admin.users.destroy',
        ]);
    });

    // Módulo de Gestão de Oportunidades (Formal e Informal)
    Route::middleware(['permission:gerenciar vagas'])->group(function () {
        Route::resource('vagas', VagaAdminController::class)->names([
            'index'   => 'admin.vagas.index',
            'create'  => 'admin.vagas.create',
            'store'   => 'admin.vagas.store',
            'edit'    => 'admin.vagas.edit',
            'update'  => 'admin.vagas.update',
            'destroy' => 'admin.vagas.destroy',
        ]);
    });

    Route::middleware(['permission:gerir alertas'])->group(function () {
        // Rotas de Alertas
        Route::resource('alertas', AlertaController::class)->except(['show'])->names([
            'index'   => 'admin.alertas.index',
            'create'  => 'admin.alertas.create',
            'store'   => 'admin.alertas.store',
            'edit'    => 'admin.alertas.edit',
            'update'  => 'admin.alertas.update',
            'destroy' => 'admin.alertas.destroy',
        ]);
        Route::patch('alertas/{id}/toggle', [AlertaController::class, 'toggleAtivo'])->name('admin.alertas.toggle');
        Route::patch('alertas/{alerta}/toggle-status', [App\Http\Controllers\AlertaController::class, 'toggleStatus'])->name('admin.alertas.toggle-status');
    });

    Route::middleware(['permission:gerir noticias'])->group(function () {
        // Upload de imagem via CKEditor
        Route::post('/upload-imagem-editor', [NoticiaController::class, 'uploadImagemEditor'])->name('admin.upload.editor');

        // Módulo de Notícias do Admin
        Route::get('/noticias', [NoticiaController::class, 'index'])->name('admin.noticias.index');
        Route::get('/noticias/nova', [NoticiaController::class, 'create'])->name('admin.noticias.create');
        Route::post('/noticias', [NoticiaController::class, 'store'])->name('admin.noticias.store');
        Route::get('/noticias/{id}/editar', [NoticiaController::class, 'edit'])->name('admin.noticias.edit');
        Route::put('/noticias/{id}', [NoticiaController::class, 'update'])->name('admin.noticias.update');
        Route::delete('/noticias/{id}', [NoticiaController::class, 'destroy'])->name('admin.noticias.destroy');
    });

    // Categorias (Temas) Genéricos
    Route::middleware(['permission:gerir noticias|gerir servicos|gerir programas|gerir eventos'])->group(function () {
        Route::resource('categorias', \App\Http\Controllers\Admin\CategoriaController::class)->except(['show'])->names([
            'index'   => 'admin.categorias.index',
            'create'  => 'admin.categorias.create',
            'store'   => 'admin.categorias.store',
            'edit'    => 'admin.categorias.edit',
            'update'  => 'admin.categorias.update',
            'destroy' => 'admin.categorias.destroy',
        ]);
    });

    Route::middleware(['permission:gerir banners'])->group(function () {
        // Rotas de Banners (Modais)
        Route::resource('banners', BannerController::class)->except(['show'])->names([
            'index'   => 'admin.banners.index',
            'create'  => 'admin.banners.create',
            'store'   => 'admin.banners.store',
            'edit'    => 'admin.banners.edit',
            'update'  => 'admin.banners.update',
            'destroy' => 'admin.banners.destroy',
        ]);
        Route::patch('banners/{banner}/toggle-status', [BannerController::class, 'toggleStatus'])->name('admin.banners.toggle-status');
        Route::patch('banners/{id}/toggle', [BannerController::class, 'toggleAtivo'])->name('admin.banners.toggle');

        // Rotas de Banners de Destaque (Página Inicial)
        Route::resource('banner-destaques', BannerDestaqueController::class)->except(['show'])->names([
            'index'   => 'admin.banner-destaques.index',
            'create'  => 'admin.banner-destaques.create',
            'store'   => 'admin.banner-destaques.store',
            'edit'    => 'admin.banner-destaques.edit',
            'update'  => 'admin.banner-destaques.update',
            'destroy' => 'admin.banner-destaques.destroy',
        ]);
        // NOVO: Módulo de Redes Sociais
        Route::get('redes-sociais', [RedeSocialController::class, 'index'])->name('admin.redes-sociais.index');
        Route::put('redes-sociais', [RedeSocialController::class, 'updateAll'])->name('admin.redes-sociais.updateAll');
    });

    Route::middleware(['permission:gerir eventos'])->group(function () {
        // Módulo de Eventos/Agenda
        Route::resource('eventos', EventoController::class)->except(['show'])->names([
            'index'   => 'admin.eventos.index',
            'create'  => 'admin.eventos.create',
            'store'   => 'admin.eventos.store',
            'edit'    => 'admin.eventos.edit',
            'update'  => 'admin.eventos.update',
            'destroy' => 'admin.eventos.destroy',
        ]);
        Route::patch('eventos/{id}/toggle', [EventoController::class, 'toggleAtivo'])->name('admin.eventos.toggle');
    });

    Route::middleware(['permission:gerir programas'])->group(function () {
        // Módulo de Programas (Assaí em Ação)
        Route::resource('programas', ProgramaController::class)->except(['show'])->names([
            'index'   => 'admin.programas.index',
            'create'  => 'admin.programas.create',
            'store'   => 'admin.programas.store',
            'edit'    => 'admin.programas.edit',
            'update'  => 'admin.programas.update',
            'destroy' => 'admin.programas.destroy',
        ]);
        Route::patch('programas/{programa}/toggle', [ProgramaController::class, 'toggle'])->name('admin.programas.toggle');
        Route::patch('programas/{programa}/toggle-status', [ProgramaController::class, 'toggleStatus'])->name('admin.programas.toggle-status');
        Route::patch('programas/{programa}/toggle-destaque', [ProgramaController::class, 'toggleDestaque'])->name('admin.programas.toggle-destaque');
    });

    Route::middleware(['permission:gerir secretarias'])->group(function () {

        // Módulo do Executivo (Prefeito e Vice)
        Route::get('/executivos', [ExecutivoController::class, 'index'])->name('admin.executivos.index');
        Route::put('/executivos/{id}', [ExecutivoController::class, 'update'])->name('admin.executivos.update');

        // Módulo de Secretarias
        Route::resource('secretarias', SecretariaController::class)->except(['show'])->names([
            'index'   => 'admin.secretarias.index',
            'create'  => 'admin.secretarias.create',
            'store'   => 'admin.secretarias.store',
            'edit'    => 'admin.secretarias.edit',
            'update'  => 'admin.secretarias.update',
            'destroy' => 'admin.secretarias.destroy',
        ]);
    });

    Route::middleware(['permission:gerir servicos'])->group(function () {
        // Módulo de Serviços Rápidos
        Route::patch('servicos/{id}/toggle', [ServicoController::class, 'toggleAtivo'])->name('admin.servicos.toggle');
        Route::patch('servicos/{servico}/toggle-status', [ServicoController::class, 'toggleStatus'])->name('admin.servicos.toggle-status');
        Route::resource('servicos', ServicoController::class)->except(['show'])->names([
            'index'   => 'admin.servicos.index',
            'create'  => 'admin.servicos.create',
            'store'   => 'admin.servicos.store',
            'edit'    => 'admin.servicos.edit',
            'update'  => 'admin.servicos.update',
            'destroy' => 'admin.servicos.destroy',
        ]);
    });
});
