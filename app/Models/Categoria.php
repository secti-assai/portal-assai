<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Categoria extends Model
{
    use HasFactory, \Illuminate\Database\Eloquent\SoftDeletes;

    protected $table = 'categorias';

    protected $fillable = [
        'nome',
        'perfil',
        'ativo'
    ];

    protected $casts = [
        'ativo' => 'boolean'
    ];

    public function noticias()
    {
        return $this->hasMany(Noticia::class);
    }

    public function servicos()
    {
        return $this->hasMany(Servico::class);
    }

    public function programas()
    {
        return $this->hasMany(Programa::class);
    }

    public function eventos()
    {
        return $this->hasMany(Evento::class);
    }
}
