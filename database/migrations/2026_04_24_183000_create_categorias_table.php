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
        Schema::create('categorias', function (Blueprint $table) {
            $table->id();
            $table->string('nome')->unique();
            $table->json('perfis')->nullable(); // Suporta múltiplos perfis: ['Cidadão', 'Empresário']
            $table->boolean('ativo')->default(true);
            $table->timestamps();
            $table->softDeletes();
        });

        // Cria a tabela pivô para relação Many-to-Many entre Notícias e Categorias
        Schema::create('categoria_noticia', function (Blueprint $table) {
            $table->id();
            $table->foreignId('noticia_id')->constrained('noticias')->cascadeOnDelete();
            $table->foreignId('categoria_id')->constrained('categorias')->cascadeOnDelete();
            $table->timestamps();
            
            // Impede a mesma categoria duas vezes na mesma notícia
            $table->unique(['noticia_id', 'categoria_id']);
        });

        // Adiciona a foreign key em servicos
        Schema::table('servicos', function (Blueprint $table) {
            $table->foreignId('categoria_id')->nullable()->constrained('categorias')->nullOnDelete();
        });

        // Adiciona a foreign key em programas
        Schema::table('programas', function (Blueprint $table) {
            $table->foreignId('categoria_id')->nullable()->constrained('categorias')->nullOnDelete();
        });

        // Adiciona a foreign key em eventos
        Schema::table('eventos', function (Blueprint $table) {
            $table->foreignId('categoria_id')->nullable()->constrained('categorias')->nullOnDelete();
        });

        // Criar as categorias padrão
        $categorias = [
            ['nome' => 'Gestão', 'perfil' => 'Servidor Público'],
            ['nome' => 'Transparência', 'perfil' => 'Cidadão'],
            ['nome' => 'Saúde', 'perfil' => 'Cidadão'],
            ['nome' => 'Educação', 'perfil' => 'Cidadão'],
            ['nome' => 'Inovação', 'perfil' => 'Empresário'],
            ['nome' => 'Tecnologia', 'perfil' => 'Empresário'],
            ['nome' => 'Obras', 'perfil' => 'Cidadão'],
            ['nome' => 'Emprego', 'perfil' => 'Cidadão'],
            ['nome' => 'Cultura', 'perfil' => 'Turista'],
            ['nome' => 'Lazer', 'perfil' => 'Cidadão'],
            ['nome' => 'Esporte', 'perfil' => 'Cidadão'],
            ['nome' => 'Segurança', 'perfil' => 'Cidadão'],
            ['nome' => 'Meio Ambiente', 'perfil' => 'Cidadão'],
            ['nome' => 'Assistência Social', 'perfil' => 'Cidadão'],
            ['nome' => 'Segurança Alimentar', 'perfil' => 'Cidadão'],
        ];

        foreach ($categorias as $categoria) {
            \Illuminate\Support\Facades\DB::table('categorias')->insertOrIgnore([
                'nome' => $categoria['nome'],
                'perfis' => json_encode([$categoria['perfil']]),
                'ativo' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('eventos', function (Blueprint $table) {
            $table->dropForeign(['categoria_id']);
            $table->dropColumn('categoria_id');
        });

        Schema::table('programas', function (Blueprint $table) {
            $table->dropForeign(['categoria_id']);
            $table->dropColumn('categoria_id');
        });

        Schema::table('servicos', function (Blueprint $table) {
            $table->dropForeign(['categoria_id']);
            $table->dropColumn('categoria_id');
        });

        Schema::dropIfExists('categoria_noticia');
        Schema::dropIfExists('categorias');
    }
};
