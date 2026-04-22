<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RedeSocial extends Model
{
    // Força o Laravel a usar a tabela com o nome correto
    protected $table = 'redes_sociais';

    // Apenas os campos que a vitrine fixa utiliza
    protected $fillable = [
        'ordem', 
        'link', 
        'imagem'
    ];
}