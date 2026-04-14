<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Portal extends Model
{
    protected $table = 'portais';
    protected $fillable = ['titulo', 'url', 'icone', 'ativo'];
}