<?php

namespace App\Observers;

use App\Models\Evento;
use Illuminate\Support\Facades\Cache;

class EventoObserver
{
    public function saved(Evento $evento): void
    {
        Cache::forget('home_eventos');
    }

    public function deleted(Evento $evento): void
    {
        Cache::forget('home_eventos');
    }

    public function restored(Evento $evento): void
    {
        Cache::forget('home_eventos');
    }

    public function forceDeleted(Evento $evento): void
    {
        Cache::forget('home_eventos');
    }
}
