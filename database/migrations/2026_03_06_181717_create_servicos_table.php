<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('servicos', function (Blueprint $table) {
            $table->id();
            // Chave estrangeira para o relacionamento com secretarias
            $table->foreignId('secretaria_id')
                ->nullable()
                ->constrained('secretarias')
                ->onDelete('set null');
            $table->string('titulo', 50); // Ex: Saúde, Alvará
            $table->string('link')->nullable(); // Para onde o botão vai
            $table->string('icone')->nullable(); // Upload da imagem/ícone
            $table->boolean('ativo')->default(true);
            $table->integer('acessos')->default(0);
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('servicos');
    }
};
