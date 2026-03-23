<?php

namespace Database\Seeders;

use App\Models\Alerta;
use App\Models\Banner;
use App\Models\Evento;
use App\Models\Noticia;
use App\Models\Programa;
use App\Models\Secretaria;
use App\Models\Servico;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    public function run(): void
    {
        $this->call([RolesAndPermissionsSeeder::class]);

        // Usuário administrador (preservado)
        $this->call([AdminSeeder::class]);

        // Banners do carrossel principal (ativos/inativos para filtro)
        Banner::factory(10)->create();

        // Secretarias (devem existir antes dos serviços)
        Secretaria::factory(20)->create();

        // Programas municipais
        Programa::factory(50)->create();

        // Serviços associados às secretarias (com ícones padronizados)
        Servico::factory(100)->create();

        // Garante cobertura dos filtros de ícone/status em serviços
        foreach (['padrao', 'saude', 'vagas', 'documentos', 'ouvidoria', 'alvara', 'educacao'] as $icone) {
            Servico::factory()->create([
                'titulo' => 'Serviço de teste - ' . ucfirst($icone) . ' ativo',
                'icone' => $icone,
                'ativo' => true,
            ]);

            Servico::factory()->create([
                'titulo' => 'Serviço de teste - ' . ucfirst($icone) . ' inativo',
                'icone' => $icone,
                'ativo' => false,
            ]);
        }

        // Notícias (publicadas e rascunho)
        Noticia::factory(200)->create();

        Noticia::factory()->create([
            'titulo' => 'Notícia de teste publicada',
            'categoria' => 'Saúde',
            'data_publicacao' => now()->subDays(2),
        ]);

        Noticia::factory()->create([
            'titulo' => 'Notícia de teste rascunho',
            'categoria' => 'Educação',
            'data_publicacao' => now()->addDays(10),
        ]);

        // Eventos (confirmado e cancelado + passado/futuro para agendado/realizado)
        Evento::factory(50)->create();

        Evento::factory()->create([
            'titulo' => 'Evento de teste agendado',
            'status' => 'confirmado',
            'data_inicio' => now()->addDays(20),
            'data_fim' => now()->addDays(21),
        ]);

        Evento::factory()->create([
            'titulo' => 'Evento de teste realizado',
            'status' => 'confirmado',
            'data_inicio' => now()->subDays(20),
            'data_fim' => now()->subDays(19),
        ]);

        Evento::factory()->create([
            'titulo' => 'Evento de teste cancelado',
            'status' => 'cancelado',
            'data_inicio' => now()->addDays(40),
            'data_fim' => now()->addDays(41),
        ]);

        // Alertas para testar busca e status
        Alerta::factory(20)->create();

    }
}
