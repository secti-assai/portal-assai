<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\Models\Intencao;
use Illuminate\Database\Seeder;

class IntencoesSeeder extends Seeder
{
    public function run(): void
    {
        $intencoes = [
            [
                'intencao_id' => 'servicos_municipais',
                'resposta' => 'Bem-vindo ao Portal da Prefeitura! Você pode consultar informações sobre serviços municipais, agendamentos, certidões, denúncias e muito mais. Como posso ajudá-lo?',
                'contexto' => 'Serviços municipais oferecidos pela prefeitura incluem emissão de certidões, agendamentos de atendimento, protocolos de denúncia e informações sobre órgãos públicos.',
                'triggers' => [
                    'serviço',
                    'serviços',
                    'prefeitura',
                    'municipal',
                    'ajuda',
                    'pode me ajudar',
                    'preciso de',
                    'como faço',
                ],
                'prioridade' => 100,
                'uso_count' => 0,
                'ativa' => true,
                'metadata' => [
                    'categoria' => 'geral',
                    'tags' => ['serviços', 'informação'],
                ],
            ],
            [
                'intencao_id' => 'certidoes',
                'resposta' => 'Para solicitar uma certidão, acesse o formulário de solicitação em nosso portal ou compareça pessoalmente à prefeitura. Você pode solicitar certidões de negativa de débitos, negativa de servidores públicos e outras certidões administrativas. Qual tipo de certidão você precisa?',
                'contexto' => 'Certidões municipais incluem certidão de negativa de débitos, certidão de negativa de infrações, certidão de propriedade de imóvel. O processo leva entre 3 a 5 dias úteis.',
                'triggers' => [
                    'certidão',
                    'certidões',
                    'negativa',
                    'debitos',
                    'dívida',
                    'emissão',
                ],
                'prioridade' => 90,
                'uso_count' => 0,
                'ativa' => true,
                'metadata' => [
                    'categoria' => 'certidões',
                    'tags' => ['certidão', 'negativa', 'débito'],
                ],
            ],
            [
                'intencao_id' => 'alvaras',
                'resposta' => 'Para solicitar um alvará (alvará de funcionamento, localização, construção, etc.), acesse o portal ou compareça pessoalmente na secretaria responsável. Alvarás são documentos de autorização para funcionar como empresa ou realizar atividades específicas. Qual tipo de alvará você precisa?',
                'contexto' => 'Alvarás municipais incluem alvará de funcionamento, alvará de localização, alvará de construção e outros. O processo de emissão geralmente leva de 5 a 10 dias úteis dependendo do tipo.',
                'triggers' => [
                    'alvará',
                    'alvarás',
                    'alvara',
                    'alvaras',
                    'funcionamento',
                    'localização',
                    'construção',
                    'autorização',
                ],
                'prioridade' => 85,
                'uso_count' => 0,
                'ativa' => true,
                'metadata' => [
                    'categoria' => 'alvarás',
                    'tags' => ['alvará', 'funcionamento', 'autorização'],
                ],
            ],
            [
                'intencao_id' => 'agendamentos',
                'resposta' => 'Você pode realizar agendamentos de atendimento diretamente no portal ou ligando para nossa central de atendimento. Oferecemos agendamentos para atendimentos na Prefeitura, Câmara Municipal e secretarias. Qual serviço você gostaria de agendar?',
                'contexto' => 'Agendamentos podem ser realizados online ou por telefone. Os horários variam de acordo com a secretaria. Agendamentos normalmente são confirmados em até 24 horas.',
                'triggers' => [
                    'agendar',
                    'agendamento',
                    'marcar',
                    'horário',
                    'data',
                    'consulta',
                    'atendimento',
                ],
                'prioridade' => 95,
                'uso_count' => 0,
                'ativa' => true,
                'metadata' => [
                    'categoria' => 'agendamentos',
                    'tags' => ['agenda', 'consulta', 'atendimento'],
                ],
            ],
            [
                'intencao_id' => 'denuncia',
                'resposta' => 'Você pode fazer uma denúncia através de nosso formulário de denúncias no portal (anônimo ou identificado), ou comparecer pessoalmente à Prefeitura. Aceitamos denúncias sobre infrações administrativas, irregularidades e problemas municipais. Gostaria de fazer uma denúncia?',
                'contexto' => 'Denúncias podem ser anônimas ou identificadas. Todas as denúncias são investigadas e sigilosas. O prazo de resposta é de até 30 dias úteis.',
                'triggers' => [
                    'denúncia',
                    'denunciar',
                    'reclamação',
                    'problema',
                    'irregular',
                    'ilegal',
                    'infração',
                ],
                'prioridade' => 80,
                'uso_count' => 0,
                'ativa' => true,
                'metadata' => [
                    'categoria' => 'denúncias',
                    'tags' => ['denuncia', 'infração', 'reclamação'],
                ],
            ],
            [
                'intencao_id' => 'contato',
                'resposta' => 'Você pode entrar em contato conosco de várias formas: pelo formulário de contato no portal, por telefone, email ou redes sociais. Nossa central de atendimento funciona de segunda a sexta-feira, das 8h às 18h. Como posso ajudar?',
                'contexto' => 'Contato por telefone: (XX) XXXX-XXXX | Email: contato@prefeitura.com.br | Horário de funcionamento: seg-sex 8h-18h, sábado 9h-13h.',
                'triggers' => [
                    'contato',
                    'telefone',
                    'email',
                    'falar com',
                    'comunicar',
                    'endereço',
                    'horário',
                ],
                'prioridade' => 70,
                'uso_count' => 0,
                'ativa' => true,
                'metadata' => [
                    'categoria' => 'contato',
                    'tags' => ['contato', 'comunicação', 'endereço'],
                ],
            ],
            [
                'intencao_id' => 'transparencia',
                'resposta' => 'Acesse nossa área de Transparência para consultar informações sobre execução orçamentária, licitações, contratos e relatórios administrativos. Todos os documentos públicos estão disponíveis para download. Qual informação específica você procura?',
                'contexto' => 'Transparência municipal inclui: orçamento, despesas, receitas, licitações públicas, editais, contratos e relatórios de gestão. Tudo conforme Lei de Acesso à Informação (LAI).',
                'triggers' => [
                    'transparência',
                    'orçamento',
                    'licitação',
                    'contrato',
                    'despesa',
                    'acesso informação',
                    'documento',
                ],
                'prioridade' => 75,
                'uso_count' => 0,
                'ativa' => true,
                'metadata' => [
                    'categoria' => 'transparência',
                    'tags' => ['transparência', 'orçamento', 'documento'],
                ],
            ],
            [
                'intencao_id' => 'saudacao',
                'resposta' => 'Olá! Bem-vindo ao Portal da Prefeitura. Como posso ajudá-lo hoje?',
                'contexto' => 'Saudações iniciais para começar uma conversa de forma amigável e acessível.',
                'triggers' => [
                    'olá',
                    'oi',
                    'opa',
                    'e aí',
                    'como vai',
                    'bom dia',
                    'boa tarde',
                    'boa noite',
                ],
                'prioridade' => 10,
                'uso_count' => 0,
                'ativa' => true,
                'metadata' => [
                    'categoria' => 'saudação',
                    'tags' => ['saudação', 'cumprimento'],
                ],
            ],
            [
                'intencao_id' => 'obrigado',
                'resposta' => 'De nada! Fico feliz em ajudar. Se tiver mais dúvidas, é só falar!',
                'contexto' => 'Resposta de agradecimento de forma educada e amigável.',
                'triggers' => [
                    'obrigado',
                    'muito obrigado',
                    'brigadão',
                    'thanks',
                    'vlw',
                    'flw',
                    'valeu',
                ],
                'prioridade' => 5,
                'uso_count' => 0,
                'ativa' => true,
                'metadata' => [
                    'categoria' => 'saudação',
                    'tags' => ['agradecimento'],
                ],
            ],
            [
                'intencao_id' => 'despedida',
                'resposta' => 'Até logo! Tenha um ótimo dia!',
                'contexto' => 'Despedida cordial de uma conversa.',
                'triggers' => [
                    'adeus',
                    'tchau',
                    'falou',
                    'até mais',
                    'até breve',
                    'até logo',
                    'bye',
                ],
                'prioridade' => 5,
                'uso_count' => 0,
                'ativa' => true,
                'metadata' => [
                    'categoria' => 'saudação',
                    'tags' => ['despedida'],
                ],
            ],
        ];

        foreach ($intencoes as $intencao) {
            Intencao::updateOrCreate(
                ['intencao_id' => $intencao['intencao_id']],
                $intencao
            );
        }
    }
}
