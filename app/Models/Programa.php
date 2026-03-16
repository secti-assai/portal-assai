<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;

class Programa extends Model
{
    use HasFactory, SoftDeletes, LogsActivity;

    protected $fillable = ['titulo', 'descricao', 'icone', 'link', 'ativo', 'destaque'];

    protected $casts = [
        'ativo'    => 'boolean',
        'destaque' => 'boolean',
    ];

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logFillable()
            ->logOnlyDirty()
            ->dontSubmitEmptyLogs()
            ->setDescriptionForEvent(fn(string $eventName) => "Programa {$eventName}");
    }
}