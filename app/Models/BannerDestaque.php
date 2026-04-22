<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BannerDestaque extends Model
{
    protected $table = 'banner_destaques';

    protected $fillable = [
        'titulo',
        'imagem',
        'link',
        'ordem',
        'ativo',
    ];

    protected $casts = [
        'ativo' => 'boolean',
    ];
}