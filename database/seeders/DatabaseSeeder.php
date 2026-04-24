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
use App\Models\Executivo;
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
        $this->call([SecretariaSeeder::class]);
        $this->call([ExecutivosSeeder::class]);
        $this->call([ServicoSeeder::class]);

        // Intenções para Busca Inteligente
        $this->call([IntencoesSeeder::class]);

        // API Keys para acesso à API IA
        $this->call([ApiKeysSeeder::class]);

        
        // Programas municipais
        $this->call([PortalSeeder::class]);
        $this->call([ProgramaSeeder::class]);
        $this->call([BannerDestaqueSeeder::class]);
        $this->call([VagasAdminSeeder::class]);

        // Eventos
        Evento::factory(10)->create();

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

    }
}