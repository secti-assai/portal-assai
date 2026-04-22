<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\BannerDestaque;

class BannerDestaqueSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $banners = [
            [
                'titulo' => 'Consultar Débitos de IPTU',
                'imagem' => 'img/banner/IPTU-banner.jpg',
                'link'   => 'https://conecta.assai.pr.gov.br/servico/99',
                'ordem'  => 1,
            ],
            [
                'titulo' => 'Consultar Débitos de ISSQN',
                'imagem' => 'img/banner/ISS-banner.jpg',
                'link'   => 'https://conecta.assai.pr.gov.br/servico/101',
                'ordem'  => 2,
            ],
            [
                'titulo' => 'Central de Estágios',
                'imagem' => 'img/banner/central-estagio.png',
                'link'   => '#', // Substitua pelo link correto quando tiver
                'ordem'  => 3,
            ],
            [
                'titulo' => 'Plano de Metas – 2022 até 2025',
                'imagem' => 'img/banner/Metas.png',
                'link'   => '#', // Substitua pelo link correto quando tiver
                'ordem'  => 4,
            ],
        ];

        foreach ($banners as $item) {
            BannerDestaque::updateOrCreate(
                ['titulo' => $item['titulo']], 
                [
                    'imagem'      => $item['imagem'],
                    'link'        => $item['link'],
                    'ordem'       => $item['ordem'],
                    'ativo'       => true,
                    'created_at'  => now(),
                    'updated_at'  => now(),
                ]
            );
        }
    }
}