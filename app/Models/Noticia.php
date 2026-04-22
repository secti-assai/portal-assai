<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Carbon;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;

class Noticia extends Model
{
    use HasFactory, SoftDeletes, LogsActivity;

    public function scopePublicadas(Builder $query): Builder
    {
        return $query
            ->where('ativo', true)
            ->whereDate('data_publicacao', '<=', Carbon::today());
    }

    protected $fillable = [
        'titulo',
        'slug',
        'categoria',
        'resumo',
        'conteudo',
        'imagem_capa',
        'data_publicacao',
        'ativo',
        'perfis_alvo',
        'destaque',
    ];

    protected $casts = [
        'data_publicacao' => 'date',
        'ativo' => 'boolean',
        'destaque' => 'boolean',
        'perfis_alvo' => 'array',
    ];

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logFillable()
            ->logOnlyDirty()
            ->dontSubmitEmptyLogs()
            ->setDescriptionForEvent(fn(string $eventName) => "Notícia {$eventName}");
    }
}