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
        'perfis',
        'ativo'
    ];

    protected $casts = [
        'ativo' => 'boolean',
        'perfis' => 'array'
    ];

    public function noticias()
    {
        return $this->belongsToMany(Noticia::class, 'categoria_noticia');
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
