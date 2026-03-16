<?php

namespace App\Observers;

use App\Models\Programa;
use Illuminate\Support\Facades\Cache;

class ProgramaObserver
{
    public function saved(Programa $programa): void
    {
        Cache::forget('home_programas');
    }

    public function deleted(Programa $programa): void
    {
        Cache::forget('home_programas');
    }

    public function restored(Programa $programa): void
    {
        Cache::forget('home_programas');
    }

    public function forceDeleted(Programa $programa): void
    {
        Cache::forget('home_programas');
    }
}
