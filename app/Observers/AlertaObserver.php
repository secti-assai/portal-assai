<?php

namespace App\Observers;

use App\Models\Alerta;
use Illuminate\Support\Facades\Cache;

class AlertaObserver
{
    public function saved(Alerta $alerta): void
    {
        Cache::forget('home_alertas');
    }

    public function deleted(Alerta $alerta): void
    {
        Cache::forget('home_alertas');
    }

    public function restored(Alerta $alerta): void
    {
        Cache::forget('home_alertas');
    }

    public function forceDeleted(Alerta $alerta): void
    {
        Cache::forget('home_alertas');
    }
}
