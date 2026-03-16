<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Alerta>
 */
class AlertaFactory extends Factory
{
    public function definition(): array
    {
        $alertas = [
            [
                'titulo' => 'Atenção: expediente especial na Prefeitura',
                'mensagem' => 'Confira os horários de atendimento desta semana para os serviços administrativos.',
                'link' => '/contato',
            ],
            [
                'titulo' => 'Campanha de vacinação em andamento',
                'mensagem' => 'Leve documento com foto e carteira vacinal para atendimento nas unidades de saúde.',
                'link' => '/agenda',
            ],
            [
                'titulo' => 'Atualização no sistema de protocolos',
                'mensagem' => 'Acompanhe solicitações pelo portal e mantenha seu cadastro atualizado.',
                'link' => '/servicos',
            ],
            [
                'titulo' => 'Interdição temporária de via',
                'mensagem' => 'Trecho em manutenção com desvio sinalizado. Dirija com atenção.',
                'link' => null,
            ],
        ];

        $alerta = fake()->randomElement($alertas);

        return [
            'titulo' => $alerta['titulo'],
            'mensagem' => $alerta['mensagem'],
            'link' => $alerta['link'],
            'ativo' => fake()->boolean(60),
        ];
    }
}
