<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Portaria extends Model
{
    protected $fillable = [
        'numero', 'data_publicacao', 'sumula', 'pdf_url', 'caminho_local'
    ];
    
    protected $casts = [
        'data_publicacao' => 'date'
    ];
}