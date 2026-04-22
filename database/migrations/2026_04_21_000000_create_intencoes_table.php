<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('intencoes', function (Blueprint $table) {
            $table->id();
            $table->string('intencao_id')->unique()->indexed();
            $table->text('resposta');
            $table->text('contexto')->nullable();
            $table->json('triggers')->nullable();
            $table->integer('prioridade')->default(0);
            $table->integer('uso_count')->default(0);
            $table->json('metadata')->nullable();
            $table->boolean('ativa')->default(true)->indexed();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('intencoes');
    }
};
