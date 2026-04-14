<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Portal;

class PortalSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $portais = [
            [
                'titulo' => 'Conecta Assaí',
                'url'    => 'https://conecta.assai.pr.gov.br', // Substitua pela URL real se for diferente
                'icone'  => 'fa-circle-nodes',
                'ativo'  => true,
            ],
            [
                'titulo' => 'Sala do Empreendedor',
                'url'    => '#', // Substitua pela URL correta
                'icone'  => 'fa-briefcase',
                'ativo'  => true,
            ],
            [
                'titulo' => 'Turismo',
                'url'    => 'http://127.0.0.1:8000/turismo', // Substitua pela URL correta
                'icone'  => 'fa-map-location-dot',
                'ativo'  => true,
            ],
            [
                'titulo' => 'Invista em Assaí',
                'url'    => '#', // Substitua pela URL correta
                'icone'  => 'fa-chart-line',
                'ativo'  => true,
            ],
            [
                'titulo' => 'Educação',
                'url'    => '#', // Substitua pela URL correta
                'icone'  => 'fa-graduation-cap',
                'ativo'  => true,
            ],
        ];

        foreach ($portais as $portal) {
            Portal::updateOrCreate(
                ['titulo' => $portal['titulo']], // Evita duplicatas caso rode o seeder mais de uma vez
                $portal
            );
        }
    }
}