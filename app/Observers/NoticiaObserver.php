<?php

namespace App\Observers;

use App\Models\Noticia;
use Illuminate\Support\Facades\Cache;

class NoticiaObserver
{
    public function saved(Noticia $noticia): void
    {
        Cache::forget('home_noticias');
    }

    public function deleted(Noticia $noticia): void
    {
        Cache::forget('home_noticias');
    }

    public function restored(Noticia $noticia): void
    {
        Cache::forget('home_noticias');
    }

    public function forceDeleted(Noticia $noticia): void
    {
        Cache::forget('home_noticias');
    }
}
