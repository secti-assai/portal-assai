<?php

namespace App\Observers;

use App\Models\Servico;
use Illuminate\Support\Facades\Cache;

class ServicoObserver
{
    public function saved(Servico $servico): void
    {
        Cache::forget('home_servicos');
    }

    public function deleted(Servico $servico): void
    {
        Cache::forget('home_servicos');
    }

    public function restored(Servico $servico): void
    {
        Cache::forget('home_servicos');
    }

    public function forceDeleted(Servico $servico): void
    {
        Cache::forget('home_servicos');
    }
}
