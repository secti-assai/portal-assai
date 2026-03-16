<?php

namespace Database\Factories;

use App\Models\Secretaria;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Servico>
 */
class ServicoFactory extends Factory
{
    public function definition(): array
    {
        $servicos = [
            ['titulo' => 'Emitir guia de IPTU', 'link' => 'https://assai.atende.net/'],
            ['titulo' => 'Consultar protocolo digital', 'link' => 'https://conecta.assai.pr.gov.br/servico/27'],
            ['titulo' => 'Solicitar poda de árvore', 'link' => null],
            ['titulo' => 'Agendar atendimento administrativo', 'link' => null],
            ['titulo' => 'Acessar portal da transparência', 'link' => 'https://transparencia.betha.cloud/#/yyGw8hIiYdv6bs-avrzVUg=='],
            ['titulo' => 'Emitir nota fiscal eletrônica', 'link' => 'https://e-gov.betha.com.br/e-nota/login.faces'],
            ['titulo' => 'Solicitar manutenção de iluminação pública', 'link' => null],
            ['titulo' => 'Consultar calendário de vacinação', 'link' => null],
            ['titulo' => 'Inscrição em atividades esportivas', 'link' => null],
            ['titulo' => 'Solicitar matrícula na rede municipal', 'link' => null],
            ['titulo' => 'Acompanhar licitações', 'link' => 'https://transparencia.betha.cloud/#/yyGw8hIiYdv6bs-avrzVUg==/consulta/95802'],
            ['titulo' => 'Acessar ouvidoria municipal', 'link' => 'https://assai.atende.net/subportal/ouvidoria'],
        ];

        $servico = fake()->randomElement($servicos);

        $icones = [
            'padrao',
            'saude',
            'vagas',
            'documentos',
            'ouvidoria',
            'alvara',
            'educacao',
        ];

        return [
            'secretaria_id' => Secretaria::inRandomOrder()->value('id')
                               ?? Secretaria::factory(),
            'titulo'        => $servico['titulo'],
            'link'          => $servico['link'],
            'icone'         => fake()->randomElement($icones),
            'ativo'         => fake()->boolean(70),
            'acessos'       => fake()->numberBetween(0, 5000),
        ];
    }
}
