<?php

namespace Database\Seeders;

use App\Models\Concurso;
use App\Models\Telefone;
use App\Models\Secretaria;
use Illuminate\Database\Seeder;

class ConcursoTelefoneSeeder extends Seeder
{
    public function run()
    {
        // Seed Concursos
        Concurso::create([
            'titulo' => 'Concurso Público 2025 - Geral',
            'descricao' => 'Processo seletivo para preenchimento de vagas em diversas áreas da administração pública municipal.',
            'link' => 'https://www.assai.pr.gov.br/concursos',
            'ativo' => true,
        ]);

        Concurso::create([
            'titulo' => 'Processo Seletivo Simplificado (PSS) - Educação',
            'descricao' => 'Contratação temporária de professores e profissionais de apoio para a rede municipal de ensino.',
            'link' => '#',
            'ativo' => true,
        ]);
    }
}
