<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Decreto extends Model
{
    protected $fillable = [
        'numero', 'data_publicacao', 'tipo', 'sumula', 'pdf_url', 'caminho_local'
    ];
    
    protected $casts = [
        'data_publicacao' => 'date'
    ];
}