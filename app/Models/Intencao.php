<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Intencao extends Model
{
    use SoftDeletes;

    protected $table = 'intencoes';

    protected $fillable = [
        'intencao_id',
        'resposta',
        'contexto',
        'triggers',
        'prioridade',
        'uso_count',
        'metadata',
        'ativa',
    ];

    protected $casts = [
        'triggers' => 'array',
        'metadata' => 'array',
        'ativa' => 'boolean',
    ];

    public function incrementarUso(): void
    {
        $this->increment('uso_count');
    }

    public function getScore(): int
    {
        return ($this->uso_count * 2) + $this->prioridade;
    }
}
