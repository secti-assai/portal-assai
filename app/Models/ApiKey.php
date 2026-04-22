<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ApiKey extends Model
{
    protected $fillable = [
        'key',
        'nome',
        'descricao',
        'ativa',
        'requisicoes_count',
        'ultimo_uso',
    ];

    protected $casts = [
        'ativa' => 'boolean',
        'ultimo_uso' => 'datetime',
    ];

    public function incrementarRequisicoes(): void
    {
        $this->update([
            'requisicoes_count' => $this->requisicoes_count + 1,
            'ultimo_uso' => now(),
        ]);
    }
}
