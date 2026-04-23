<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('vagas', function (Blueprint $table) {
            $table->id();
            $table->string('titulo');
            $table->enum('tipo', ['formal', 'informal'])->index();
            $table->string('setor_ou_contato');
            $table->text('descricao')->nullable();
            $table->date('data_limite')->nullable();
            $table->string('link_acao')->nullable(); // Link para inscrição ou WhatsApp
            $table->boolean('status')->default(true);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('vagas');
    }
};