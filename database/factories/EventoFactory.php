<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Evento>
 */
class EventoFactory extends Factory
{
    public function definition(): array
    {
        $locais = [
            'Centro Cívico de Assaí', 'Ginásio Municipal', 'Praça da Matriz',
            'Câmara Municipal', 'Parque Municipal', 'Escola Estadual',
            'Centro Cultural', 'Auditório da Prefeitura',
        ];

        $eventos = [
            [
                'titulo' => 'Feira da Cidadania e Economia Criativa',
                'descricao' => 'A programação reúne expositores locais, serviços públicos itinerantes, atrações culturais e atividades para toda a família.',
            ],
            [
                'titulo' => 'Mutirão de vacinação e promoção da saúde',
                'descricao' => 'As equipes da saúde estarão mobilizadas para vacinação, orientações preventivas e atendimento de triagem ao público.',
            ],
            [
                'titulo' => 'Audiência pública sobre planejamento urbano',
                'descricao' => 'Moradores poderão apresentar sugestões e acompanhar as prioridades definidas para mobilidade, obras e crescimento urbano.',
            ],
            [
                'titulo' => 'Mostra cultural com artistas de Assaí',
                'descricao' => 'O evento valoriza talentos locais com apresentações musicais, exposições, oficinas e atividades abertas à comunidade.',
            ],
            [
                'titulo' => 'Encontro de produtores e agricultura familiar',
                'descricao' => 'A ação fortalece a produção rural local com orientações técnicas, troca de experiências e incentivo à comercialização.',
            ],
            [
                'titulo' => 'Torneio municipal de integração esportiva',
                'descricao' => 'Equipes e atletas de diferentes bairros participam de competições voltadas à integração e ao incentivo ao esporte.',
            ],
            [
                'titulo' => 'Semana da inovação e empreendedorismo',
                'descricao' => 'Painéis, oficinas e encontros apresentam iniciativas de tecnologia, educação e desenvolvimento econômico para o município.',
            ],
            [
                'titulo' => 'Ação especial de serviços ao cidadão',
                'descricao' => 'O atendimento reúne orientação administrativa, atualização cadastral e encaminhamentos para serviços municipais.',
            ],
        ];

        $evento = fake()->randomElement($eventos);

        $inicio = fake()->dateTimeBetween('-6 months', '+6 months');
        $fim    = (clone $inicio)->modify('+' . fake()->numberBetween(1, 3) . ' days');

        return [
            'titulo'      => $evento['titulo'],
            'descricao'   => $evento['descricao'],
            'data_inicio' => $inicio,
            'data_fim'    => $fim,
            'local'       => fake()->randomElement($locais),
            'imagem'      => null,
            'status'      => fake()->randomElement(['confirmado', 'confirmado', 'confirmado', 'confirmado', 'cancelado']),
        ];
    }
}
