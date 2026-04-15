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
                'url'    => 'https://conecta.assai.pr.gov.br',
                'icone'  => 'fa-circle-nodes',
                'ativo'  => true,
            ],
            [
                'titulo' => 'Sala do Empreendedor',
                'url'    => 'https://sde.assai.pr.gov.br/sala',
                'icone'  => 'fa-briefcase',
                'ativo'  => true,
            ],
            [
                'titulo' => 'Turismo',
                'url'    => url('/turismo'),
                'icone'  => 'fa-map-location-dot',
                'ativo'  => true,
            ],
            [
                'titulo' => 'Invista em Assaí',
                'url'    => url('/em-desenvolvimento'),
                'icone'  => 'fa-chart-line',
                'ativo'  => true,
            ],
            [
                'titulo' => 'Educação',
                'url'    => url('/em-desenvolvimento'),
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