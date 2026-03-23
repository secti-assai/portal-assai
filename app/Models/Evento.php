<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;

class Evento extends Model
{
    use HasFactory, SoftDeletes, LogsActivity;

    protected $fillable = ['titulo', 'descricao', 'data_inicio', 'data_fim', 'local', 'imagem', 'status'];

    protected $casts = [
        'data_inicio' => 'datetime',
        'data_fim' => 'datetime',
    ];

    public function getStatusAttribute($value): string
    {
        return $value === 'adiado' ? 'confirmado' : $value;
    }

    public function setStatusAttribute($value): void
    {
        $this->attributes['status'] = $value === 'adiado' ? 'confirmado' : $value;
    }

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logFillable()
            ->logOnlyDirty()
            ->dontSubmitEmptyLogs()
            ->setDescriptionForEvent(fn(string $eventName) => "Evento {$eventName}");
    }

    public function scopePublico($query)
    {
        return $query->where('status', '!=', 'cancelado');
    }

    public function scopeFuturosPublicos($query)
    {
        return $query->publico()
            ->where(function ($intervalo) {
                $intervalo->whereNotNull('data_fim')
                    ->where('data_fim', '>=', now())
                    ->orWhere(function ($somenteInicio) {
                        $somenteInicio->whereNull('data_fim')
                            ->whereDate('data_inicio', '>=', today());
                });
            });
    }

    public function scopeOrdenarPorDataMaisProxima($query)
    {
        $agora = now();

        return $query
            ->orderByRaw('CASE WHEN data_inicio >= ? THEN 0 ELSE 1 END ASC', [$agora])
            ->orderByRaw('CASE WHEN data_inicio >= ? THEN data_inicio END ASC', [$agora])
            ->orderByRaw('CASE WHEN data_inicio < ? THEN data_inicio END DESC', [$agora]);
    }
}