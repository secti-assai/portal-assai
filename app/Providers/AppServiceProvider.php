<?php

namespace App\Providers;

use App\Models\{Banner, Alerta, Servico, Programa, Noticia, Evento};
use App\Observers\{BannerObserver, AlertaObserver, ServicoObserver, ProgramaObserver, NoticiaObserver, EventoObserver};
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
            $view->with('alertasAtivos', \App\Models\Alerta::where('ativo', true)->orderBy('created_at', 'desc')->get());
        });
    }
}
