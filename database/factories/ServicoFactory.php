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
        // Serviços com ícones FontAwesome válidos e descrições contextuais
        $servicos = [
            [
                'titulo'    => 'Emitir guia de IPTU',
                'link'      => 'https://assai.atende.net/',
                'icone'     => 'file-invoice-dollar',
                'descricao' => 'Gere e imprima a guia de pagamento do IPTU do seu imóvel diretamente pelo portal, de forma rápida e sem precisar comparecer à Prefeitura.',
            ],
            [
                'titulo'    => 'Consultar protocolo digital',
                'link'      => 'https://conecta.assai.pr.gov.br/servico/27',
                'icone'     => 'magnifying-glass',
                'descricao' => 'Acompanhe o andamento de requerimentos, ofícios e solicitações protocoladas junto à Prefeitura informando o número do protocolo.',
            ],
            [
                'titulo'    => 'Solicitar poda de árvore',
                'link'      => null,
                'icone'     => 'tree',
                'descricao' => 'Solicite o serviço de poda ou remoção de árvores em vias públicas e calçadas do município. O atendimento é realizado pela equipe de manutenção urbana.',
            ],
            [
                'titulo'    => 'Agendar atendimento administrativo',
                'link'      => null,
                'icone'     => 'calendar-check',
                'descricao' => 'Agende seu atendimento presencial nas secretarias municipais e evite filas. Escolha a data, o horário e o setor de acordo com sua necessidade.',
            ],
            [
                'titulo'    => 'Acessar portal da transparência',
                'link'      => 'https://transparencia.betha.cloud/#/yyGw8hIiYdv6bs-avrzVUg==',
                'icone'     => 'scale-balanced',
                'descricao' => 'Consulte receitas, despesas, contratos, licitações e informações sobre a gestão pública municipal em conformidade com a Lei de Transparência.',
            ],
            [
                'titulo'    => 'Emitir nota fiscal eletrônica',
                'link'      => 'https://e-gov.betha.com.br/e-nota/login.faces',
                'icone'     => 'receipt',
                'descricao' => 'Acesse o sistema de emissão de NFS-e do município para emitir, gerenciar e consultar notas fiscais eletrônicas de serviços prestados.',
            ],
            [
                'titulo'    => 'Solicitar manutenção de iluminação pública',
                'link'      => null,
                'icone'     => 'lightbulb',
                'descricao' => 'Informe pontos de iluminação pública com defeito, lâmpadas queimadas ou postes danificados para que a equipe técnica atue no conserto.',
            ],
            [
                'titulo'    => 'Consultar calendário de vacinação',
                'link'      => null,
                'icone'     => 'syringe',
                'descricao' => 'Confira o calendário oficial de vacinação do município, incluindo campanhas, datas e locais de atendimento nas unidades de saúde.',
            ],
            [
                'titulo'    => 'Inscrição em atividades esportivas',
                'link'      => null,
                'icone'     => 'person-running',
                'descricao' => 'Inscreva-se nas atividades esportivas e de lazer oferecidas gratuitamente pela Prefeitura: futebol, ginástica, natação, musculação e muito mais.',
            ],
            [
                'titulo'    => 'Solicitar matrícula na rede municipal',
                'link'      => null,
                'icone'     => 'graduation-cap',
                'descricao' => 'Realize a matrícula ou rematrícula do seu filho nas escolas e CEMEIs da rede municipal de ensino de Assaí para o próximo ano letivo.',
            ],
            [
                'titulo'    => 'Acompanhar licitações',
                'link'      => 'https://transparencia.betha.cloud/#/yyGw8hIiYdv6bs-avrzVUg==/consulta/95802',
                'icone'     => 'gavel',
                'descricao' => 'Acesse editais, atas e resultados de licitações, pregões e dispensas realizados pela Prefeitura Municipal de Assaí.',
            ],
            [
                'titulo'    => 'Acessar ouvidoria municipal',
                'link'      => 'https://assai.atende.net/subportal/ouvidoria',
                'icone'     => 'bullhorn',
                'descricao' => 'Registre reclamações, sugestões, elogios ou denúncias sobre os serviços públicos municipais. Suas manifestações são respondidas em até 30 dias.',
            ],
        ];

        $servico = fake()->randomElement($servicos);

        return [
            'secretaria_id' => Secretaria::inRandomOrder()->value('id')
                               ?? Secretaria::factory(),
            'titulo'        => $servico['titulo'],
            'descricao'     => $servico['descricao'],
            'link'          => $servico['link'],
            'icone'         => $servico['icone'],
            'ativo'         => fake()->boolean(70),
            'acessos'       => fake()->numberBetween(0, 5000),
        ];
    }
}
