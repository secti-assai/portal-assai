<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;

class Servico extends Model
{
    use HasFactory, SoftDeletes, LogsActivity;

    protected $fillable = [
        'secretaria_id',
        'titulo',
        'descricao',
        'link',
        'icone',
        'categoria_id',
        'ativo',
        'perfis_alvo',
        'acessos'
    ];

    protected $casts = ['perfis_alvo' => 'array',];
    
    public function secretaria(): BelongsTo
    {
        return $this->belongsTo(Secretaria::class);
    }

    public function categoriaRel()
    {
        return $this->belongsTo(Categoria::class, 'categoria_id');
    }

    public function acessosLog()
    {
        return $this->hasMany(ServicoAcesso::class);
    }

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logFillable()
            ->logOnlyDirty()
            ->dontSubmitEmptyLogs()
            ->setDescriptionForEvent(fn(string $eventName) => "Serviço {$eventName}");
    }
}
