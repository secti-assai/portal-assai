<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Servico;

class ServicoSeeder extends Seeder
{
    public function run()
    {
        $servicos = [
            // Tributos e Finanças
            [
                'titulo' => 'Emissão de Guia de IPTU',
                'icone' => 'fa-solid fa-file-invoice-dollar',
                'descricao' => 'Gere o boleto ou guia de pagamento do IPTU de forma rápida (Cota única ou parcelado).',
                'link' => 'https://e-gov.betha.com.br/cdweb/03114-502/contribuinte/rel_guiaiptu.faces',
                'ativo' => true,
            ],
            [
                'titulo' => 'Nota Fiscal Eletrônica (Fly e-Nota)',
                'icone' => 'fa-solid fa-file-signature',
                'descricao' => 'Sistema oficial para emissão, consulta e cancelamento de Notas Fiscais de Serviços Eletrônicas.',
                'link' => 'https://e-gov.betha.com.br/e-nota/login.faces',
                'ativo' => true,
            ],
            [
                'titulo' => 'Cidadão Web (Portal Completo)',
                'icone' => 'fa-solid fa-computer-mouse',
                'descricao' => 'Acesse todos os serviços tributários: Certidões Negativas, Alvarás, ITBI, Taxas e consulta de débitos.',
                'link' => 'https://e-gov.betha.com.br/cdweb/03114-502/main.faces',
                'ativo' => true,
            ],

            // Transparência e Governança
            [
                'titulo' => 'Portal da Transparência',
                'icone' => 'fa-solid fa-magnifying-glass-chart',
                'descricao' => 'Acesso em tempo real a receitas, despesas e gestão fiscal do município.',
                'link' => 'https://transparencia.betha.cloud/#/yyGw8hIiYdv6bs-avrzVUg==',
                'ativo' => true,
            ],
            [
                'titulo' => 'Licitações e Contratos',
                'icone' => 'fa-solid fa-file-contract',
                'descricao' => 'Acompanhamento detalhado de processos licitatórios e contratos firmados.',
                'link' => 'https://transparencia.betha.cloud/#/yyGw8hIiYdv6bs-avrzVUg==/consulta/95802',
                'ativo' => true,
            ],
            [
                'titulo' => 'Legislação Municipal (Leis.org)',
                'icone' => 'fa-solid fa-scale-balanced',
                'descricao' => 'Plataforma oficial para pesquisa rápida de todas as Leis, Códigos, Decretos e do Plano Diretor de Assaí.',
                'link' => 'https://leis.org/prefeitura/pr/assai',
                'ativo' => true,
            ],

            // Saúde e Serviços
            [
                'titulo' => 'Meu SUS Digital',
                'icone' => 'fa-solid fa-notes-medical',
                'descricao' => 'Emita seu Certificado Nacional de Vacinação contra a Covid-19 e acompanhe seu histórico.',
                'link' => 'https://meususdigital.saude.gov.br/login',
                'ativo' => true,
            ],
            [
                'titulo' => 'Sala do Empreendedor',
                'icone' => 'fa-solid fa-store',
                'descricao' => 'Serviços exclusivos para o MEI: Abertura de empresa, impressão de DAS, Declaração Anual.',
                'link' => 'https://conecta.assai.pr.gov.br/servico/89',
                'ativo' => true,
            ],
            
            // Previdência e Trabalho
            [
                'titulo' => 'Extrato de Contribuição (CNIS)',
                'icone' => 'fa-solid fa-piggy-bank',
                'descricao' => 'Emita o documento que informa todos os seus vínculos, remunerações e contribuições previdenciárias.',
                'link' => 'https://meu.inss.gov.br/',
                'ativo' => true,
            ]
        ];

        foreach ($servicos as $servico) {
            Servico::updateOrCreate(
                ['titulo' => $servico['titulo']],
                [
                    'icone'     => $servico['icone'],
                    'descricao' => $servico['descricao'],
                    'link'      => $servico['link'],
                    'ativo'     => $servico['ativo'],
                    'acessos'   => 0,
                ]
            );
        }
    }
}