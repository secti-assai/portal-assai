<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Banner>
 */
class BannerFactory extends Factory
{
    public function definition(): array
    {
        $banners = [
            [
                'titulo' => 'Portal de serviços e informações da Prefeitura de Assaí',
                'subtitulo' => 'Acesse serviços, notícias, agenda e transparência em um só lugar.',
                'link' => '/servicos',
            ],
            [
                'titulo' => 'Agenda pública com eventos, campanhas e ações do município',
                'subtitulo' => 'Acompanhe inaugurações, atendimentos especiais, feiras e atividades culturais.',
                'link' => '/agenda',
            ],
            [
                'titulo' => 'Assaí em transformação com inovação, cuidado e participação',
                'subtitulo' => 'Conheça os programas e projetos que impulsionam o desenvolvimento local.',
                'link' => '/programas',
            ],
            [
                'titulo' => 'Notícias oficiais com informações úteis para o dia a dia da população',
                'subtitulo' => 'Fique por dentro das principais ações da Prefeitura e dos serviços em destaque.',
                'link' => '/noticias',
            ],
        ];

        $banner = fake()->randomElement($banners);

        return [
            'titulo'    => $banner['titulo'],
            'subtitulo' => $banner['subtitulo'],
            'imagem'    => 'img/Assaí.jpg',
            'link'      => $banner['link'],
            'ativo'     => fake()->boolean(80),
        ];
    }
}
