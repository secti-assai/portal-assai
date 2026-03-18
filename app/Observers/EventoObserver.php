<?php

namespace App\Observers;

use App\Models\Evento;
use Illuminate\Support\Facades\Cache;

class EventoObserver
{
    private function forgetHomeCache(): void
    {
        Cache::forget('home_eventos_v2');
        Cache::forget('home_eventos');
    }

    public function saved(Evento $evento): void
    {
        $this->forgetHomeCache();
    }

    public function deleted(Evento $evento): void
    {
        $this->forgetHomeCache();
    }

    public function restored(Evento $evento): void
    {
        $this->forgetHomeCache();
    }

    public function forceDeleted(Evento $evento): void
    {
        $this->forgetHomeCache();
    }
}
