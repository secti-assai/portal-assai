<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    
    // Array com as tabelas que receberão a filtragem
    protected array $tabelas = ['servicos', 'noticias', 'programas', 'eventos'];

    public function up(): void
    {
        foreach ($this->tabelas as $tabela) {
            Schema::table($tabela, function (Blueprint $table) {
                // Adiciona a coluna JSON após a coluna 'ativo' (ou outra existente como 'link')
                $table->json('perfis_alvo')->nullable();
            });
        }
    }

    public function down(): void
    {
        foreach ($this->tabelas as $tabela) {
            Schema::table($tabela, function (Blueprint $table) {
                $table->dropColumn('perfis_alvo');
            });
        }
    }
};