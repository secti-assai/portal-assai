<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Vaga extends Model
{
    use HasFactory;

    protected $fillable = [
        'titulo',
        'tipo',
        'setor_ou_contato',
        'descricao',
        'data_limite',
        'link_acao',
        'status',
    ];

    protected $casts = [
        'data_limite' => 'date',
        'status' => 'boolean',
    ];

    public function scopeAtivas($query)
    {
        return $query->where('status', true);
    }
}