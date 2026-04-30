<?php

namespace App\Providers;

use App\Models\{Banner, Alerta, Servico, Programa, Noticia, Evento};
use App\Observers\{BannerObserver, AlertaObserver, ServicoObserver, ProgramaObserver, NoticiaObserver, EventoObserver};
use App\Services\IntencaoIndexer;
use Carbon\Carbon;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Banner::observe(BannerObserver::class);
        Alerta::observe(AlertaObserver::class);
        Servico::observe(ServicoObserver::class);
        Programa::observe(ProgramaObserver::class);
        Noticia::observe(NoticiaObserver::class);
        Evento::observe(EventoObserver::class);

        Carbon::setLocale('pt_BR');

        \Illuminate\Support\Facades\View::composer('*', function ($view) {
            // Restaurar sessão do Gov.Assai se existir cookie
            if (!session()->has('gov_user') && request()->hasCookie('gov_user_remember')) {
                try {
                    $userData = json_decode(request()->cookie('gov_user_remember'), true);
                    if ($userData) {
                        session(['gov_user' => $userData]);
                    }
                } catch (\Exception $e) {
                    // Ignore
                }
            }
            
            $view->with('alertasAtivos', \App\Models\Alerta::where('ativo', true)->orderBy('created_at', 'desc')->get());
        });

        // Construir índice de intenções ao inicializar a aplicação
        try {
            IntencaoIndexer::build();
        } catch (\Exception $e) {
            \Illuminate\Support\Facades\Log::warning('Falha ao construir índice de intenções', [
                'erro' => $e->getMessage(),
            ]);
        }
    }
}
