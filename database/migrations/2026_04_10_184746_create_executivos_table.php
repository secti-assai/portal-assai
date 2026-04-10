<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('executivos', function (Blueprint $table) {
            $table->id();
            $table->enum('cargo', ['Prefeito', 'Vice-Prefeito'])->unique();
            $table->string('nome');
            $table->string('foto')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('executivos');
    }
};