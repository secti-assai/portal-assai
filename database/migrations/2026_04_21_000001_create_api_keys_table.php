<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('api_keys', function (Blueprint $table) {
            $table->id();
            $table->string('key')->unique()->indexed();
            $table->string('nome');
            $table->text('descricao')->nullable();
            $table->boolean('ativa')->default(true)->indexed();
            $table->integer('requisicoes_count')->default(0);
            $table->timestamp('ultimo_uso')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('api_keys');
    }
};
