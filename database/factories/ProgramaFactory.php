<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Programa>
 */
class ProgramaFactory extends Factory
{
    public function definition(): array
    {
        $programas = [
            [
                'titulo' => 'Assaí em Ação',
                'descricao' => 'Programa municipal voltado à modernização de espaços públicos, melhoria de infraestrutura e qualificação dos serviços prestados à população.',
            ],
            [
                'titulo' => 'Cidade Inteligente',
                'descricao' => 'Iniciativa que conecta tecnologia, dados e inovação para melhorar a gestão pública e ampliar o atendimento ao cidadão.',
            ],
            [
                'titulo' => 'Educação que Transforma',
                'descricao' => 'Conjunto de ações para fortalecer a aprendizagem, a formação de professores e a modernização dos ambientes escolares.',
            ],
            [
                'titulo' => 'Assaí Mais Saúde',
                'descricao' => 'Programa de cuidado contínuo com foco em prevenção, atendimento humanizado e ampliação do acesso à rede municipal de saúde.',
            ],
            [
                'titulo' => 'Cultura Viva Assaí',
                'descricao' => 'Ações culturais que valorizam a identidade local, incentivam artistas do município e promovem ocupação qualificada dos espaços públicos.',
            ],
            [
                'titulo' => 'Esporte para Todos',
                'descricao' => 'Projeto que amplia o acesso às práticas esportivas com atividades comunitárias, formação de base e ações de qualidade de vida.',
            ],
            [
                'titulo' => 'Desenvolve Assaí',
                'descricao' => 'Programa de incentivo ao empreendedorismo, à qualificação profissional e ao fortalecimento da economia local.',
            ],
            [
                'titulo' => 'Bairros Bem Cuidados',
                'descricao' => 'Conjunto de frentes de trabalho para manutenção urbana, zeladoria, pequenas obras e melhoria dos espaços de convivência.',
            ],
        ];

        $programa = fake()->randomElement($programas);

        return [
            'titulo'   => $programa['titulo'],
            'descricao' => $programa['descricao'],
            'icone'    => null,
            'link'     => fake()->randomElement(['/programas', '/agenda', '/servicos', null]),
            'ativo'    => fake()->boolean(80),
            'destaque' => fake()->boolean(35),
        ];
    }
}
