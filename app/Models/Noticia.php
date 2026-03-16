<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;

class Noticia extends Model
{
    use HasFactory, SoftDeletes, LogsActivity;

    protected $fillable = [
        'titulo',
        'slug',
        'categoria',
        'resumo',
        'conteudo',
        'imagem_capa',
        'data_publicacao',
    ];

    protected $casts = [
        'data_publicacao' => 'date',
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