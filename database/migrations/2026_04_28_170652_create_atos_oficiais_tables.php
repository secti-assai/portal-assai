<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // 1. Tabela de Portarias
        Schema::create('portarias', function (Blueprint $table) {
            $table->id();
            $table->string('numero');
            $table->date('data_publicacao')->index();
            $table->text('sumula');
            $table->string('pdf_url', 500)->nullable();       // Link original do site
            $table->string('caminho_local', 500)->nullable(); // Onde o PDF será guardado no seu servidor
            $table->timestamps();
            
            // Impede a importação de duplicados
            $table->unique(['numero', 'data_publicacao']); 
        });

        // 2. Tabela de Decretos
        Schema::create('decretos', function (Blueprint $table) {
            $table->id();
            $table->string('numero');
            $table->date('data_publicacao')->index();
            $table->string('tipo')->nullable(); // Algumas portarias/decretos podem não ter tipo
            $table->text('sumula');
            $table->string('pdf_url', 500)->nullable();
            $table->string('caminho_local', 500)->nullable();
            $table->timestamps();
            
            $table->unique(['numero', 'data_publicacao']);
        });

        // 3. Tabela de Diários Oficiais (Estrutura mais complexa do Next.js)
        Schema::create('diarios_oficiais', function (Blueprint $table) {
            $table->id();
            $table->integer('edicao')->unique();
            $table->date('data_publicacao')->index();
            $table->string('pdf_url', 500)->nullable();
            $table->string('caminho_local', 500)->nullable();

            // Metadados do Assinante
            $table->string('assinante_id')->nullable(); 
            $table->string('assinante_nome')->nullable();
            $table->string('assinante_cpf', 11)->nullable();
            $table->string('assinante_email')->nullable();

            // Metadados do Certificado Digital
            $table->date('certificado_emissao')->nullable();
            $table->date('certificado_validade')->nullable();
            $table->string('certificado_versao', 10)->nullable();
            $table->string('certificado_serial')->nullable();
            $table->string('certificado_hash')->nullable();

            // Metadados do Carimbo de Tempo
            $table->timestamp('carimbo_data_hora')->nullable();
            $table->string('carimbo_servidor', 50)->nullable();
            $table->string('carimbo_politica')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('diarios_oficiais');
        Schema::dropIfExists('decretos');
        Schema::dropIfExists('portarias');
    }
};