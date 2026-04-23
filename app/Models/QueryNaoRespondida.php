<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class QueryNaoRespondida extends Model
{
    protected $table = 'queries_nao_respondidas';

    protected $fillable = [
        'query',
        'melhor_intencao_id',
        'confianca',
        'debug_info',
    ];

    protected $casts = [
        'confianca' => 'decimal:2',
        'debug_info' => 'array',
    ];
}
