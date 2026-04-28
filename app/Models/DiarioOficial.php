<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DiarioOficial extends Model
{
    // Informa ao Laravel o nome exato da tabela, pois foge do plural padrão em inglês
    protected $table = 'diarios_oficiais'; 
    
    protected $fillable = [
        'edicao', 'data_publicacao', 'pdf_url', 'caminho_local',
        'assinante_id', 'assinante_nome', 'assinante_cpf', 'assinante_email', 
        'certificado_emissao', 'certificado_validade', 'certificado_versao', 
        'certificado_serial', 'certificado_hash', 
        'carimbo_data_hora', 'carimbo_servidor', 'carimbo_politica'
    ];
    
    protected $casts = [
        'data_publicacao' => 'date',
        'certificado_emissao' => 'date',
        'certificado_validade' => 'date',
        'carimbo_data_hora' => 'datetime',
    ];
}