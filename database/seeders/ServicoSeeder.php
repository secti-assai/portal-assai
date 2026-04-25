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
            ],
            [
                'titulo' => 'Boletim da Dengue',
                'icone' => 'fa-solid fa-virus-covid',
                'descricao' => 'Acompanhe as atualizações e boletins informativos sobre a situação da dengue em Assaí.',
                'link' => 'https://www.dengue.pr.gov.br/Endereco/Assai',
                'ativo' => true,
            ],
            [
                'titulo' => 'Concurso Público',
                'icone' => 'fa-solid fa-user-graduate',
                'descricao' => 'Confira os editais abertos, inscrições e resultados dos concursos e seleções do município.',
                'link' => '/concursos',
                'ativo' => true,
            ],
            [
                'titulo' => 'Livro Eletrônico',
                'icone' => 'fa-solid fa-book-bookmark',
                'descricao' => 'Acesse o sistema de Livro Eletrônico para gestão fiscal e tributária de serviços.',
                'link' => 'https://e-gov.betha.com.br/livroeletronico2/02022-038/login.faces?lastUrl=/selecaodemodulo.faces',
                'ativo' => true,
            ],
            [
                'titulo' => 'Telefones Úteis',
                'icone' => 'fa-solid fa-phone-volume',
                'descricao' => 'Lista completa de telefones de emergência, secretarias e serviços essenciais de Assaí.',
                'link' => '/telefones',
                'ativo' => true,
            ],
            [
                'titulo' => 'Vagas de Emprego',
                'icone' => 'fa-solid fa-briefcase',
                'descricao' => 'Encontre oportunidades de trabalho e vagas disponíveis através do portal GoAssaí.',
                'link' => 'https://goassai.pr.gov.br',
                'ativo' => true,
            ],
            [
                'titulo' => 'Cadastro no Gov.Assaí',
                'icone' => 'fa-solid fa-id-card-clip',
                'descricao' => 'Realize seu cadastro único no Gov.Assaí para acessar diversos serviços digitais do município.',
                'link' => 'https://gov.assai.pr.gov.br',
                'ativo' => true,
            ],
            [
                'titulo' => 'Classificados de Assaí',
                'icone' => 'fa-solid fa-tags',
                'descricao' => 'Portal de anúncios e classificados locais para compra, venda e trocas (Em breve).',
                'link' => '#',
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