<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('queries_nao_respondidas', function (Blueprint $table) {
            $table->id();
            $table->text('query');
            $table->string('melhor_intencao_id')->nullable()->indexed();
            $table->decimal('confianca', 5, 2)->default(0);
            $table->json('debug_info')->nullable();
            $table->timestamps();

            $table->foreign('melhor_intencao_id')
                ->references('intencao_id')
                ->on('intencoes')
                ->onDelete('set null');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('queries_nao_respondidas');
    }
};
