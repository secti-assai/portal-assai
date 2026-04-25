<?php

namespace Database\Seeders;

use App\Models\Alerta;
use App\Models\Banner;
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
        $this->call([EventosCalendario2026Seeder::class]);

    }
}