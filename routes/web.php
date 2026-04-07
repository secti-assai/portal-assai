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
use App\Http\Controllers\Admin\UserController;
use App\Models\Banner;
use App\Models\Servico;

// ================= ROTAS PÚBLICAS (O SITE) =================

Route::get('/', [PortalController::class, 'index'])->name('home');

Route::get('/novo', function () {
    // 1. Puxa os banners ativos
    $banners = Banner::where('ativo', true)
        ->orderBy('created_at', 'desc')
        ->get();

    // 2. Puxa as noticias para a seção "Noticias em destaque"
    $noticias = Cache::remember('home_noticias', 3600, function () {
        return \App\Models\Noticia::whereDate('data_publicacao', '<=', today())
            ->orderBy('data_publicacao', 'desc')
            ->orderBy('created_at', 'desc')
            ->take(3)
            ->get();
    });

    // 4. Envia os dados consolidados para a view
    return view('pages.pagina', compact('banners', 'noticias'));
})->name('home2');

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

Route::get('/api/plantao-hoje', function () {
    $payload = Cache::remember('portal_plantao_hoje', now()->addMinutes(20), function () {
        try {
            $response = Http::timeout(15)->accept('text/html')->get('https://informativos.assai.pr.gov.br/');

            if (!$response->ok()) {
                return [
                    'hasDuty' => false,
                    'message' => 'Plantao indisponivel',
                ];
            }

            $html = $response->body();
            $matches = [];

            if (!preg_match('/var\s+booking\s*=\s*(\[[\s\S]*?\]);/u', $html, $matches) || empty($matches[1])) {
                return [
                    'hasDuty' => false,
                    'message' => 'Plantao indisponivel',
                ];
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

            $farmacia = $pickDuty('Farmácia');
            $posto = $pickDuty('Posto');

            return [
                'hasDuty' => ($farmacia !== null || $posto !== null),
                'date' => $today,
                'farmacia' => $farmacia,
                'posto' => $posto,
                'message' => ($farmacia !== null || $posto !== null) ? null : 'Sem plantao hoje',
            ];
        } catch (\Throwable $exception) {
            return [
                'hasDuty' => false,
                'message' => 'Plantao indisponivel',
            ];
        }
    });

    return response()->json($payload);
})->name('api.plantao.hoje');

Route::get('/api/clima-atual', function () {
    $payload = Cache::remember('portal_clima_atual', now()->addMinutes(15), function () {
        try {
            $response = Http::timeout(15)->acceptJson()->get('https://api.open-meteo.com/v1/forecast', [
                'latitude' => -23.3733,
                'longitude' => -50.8417,
                'current' => 'temperature_2m,apparent_temperature,relative_humidity_2m,precipitation,weather_code,wind_speed_10m',
                'temperature_unit' => 'celsius',
                'wind_speed_unit' => 'kmh',
                'precipitation_unit' => 'mm',
                'timezone' => 'America/Sao_Paulo',
            ]);

            if (!$response->ok()) {
                return [
                    'current' => null,
                    'error' => true,
                ];
            }

            return [
                'current' => $response->json('current'),
                'error' => false,
            ];
        } catch (\Throwable $exception) {
            return [
                'current' => null,
                'error' => true,
            ];
        }
    });

    return response()->json($payload);
})->name('api.clima.atual');

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
Route::view('/sobre', 'pages.sobre')->name('pages.sobre');
Route::view('/turismo', 'pages.turismo')->name('pages.turismo');
Route::view('/transparencia', 'pages.transparencia')->name('pages.transparencia');
Route::view('/acessibilidade', 'pages.acessibilidade')->name('pages.acessibilidade');

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

    Route::middleware(['permission:gerir banners'])->group(function () {
        // Rotas de Banners
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
