<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ServicoAcesso extends Model
{
    protected $fillable = ['servico_id'];

    public function servico()
    {
        return $this->belongsTo(Servico::class);
    }
}
