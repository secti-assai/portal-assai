<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Noticia>
 */
class NoticiaFactory extends Factory
{
    public function definition(): array
    {
        $noticias = [
            [
                'titulo' => 'Mutirão de saúde amplia atendimentos preventivos no município',
                'categoria' => 'Saúde',
                'resumo' => 'A ação reuniu equipes da rede municipal para vacinação, exames e orientações de prevenção em diferentes bairros.',
                'conteudo' => [
                    'A Prefeitura de Assaí promoveu um mutirão de saúde com foco em prevenção, vacinação e atendimento básico à população.',
                    'Durante a ação, equipes das unidades de saúde realizaram triagem, atualização de carteiras vacinais e encaminhamentos para consultas especializadas.',
                    'A iniciativa também contou com orientações sobre alimentação saudável, controle de hipertensão e cuidados com a saúde da mulher e da criança.',
                ],
            ],
            [
                'titulo' => 'Rede municipal reforça calendário de matrículas e projetos pedagógicos',
                'categoria' => 'Educação',
                'resumo' => 'Escolas e centros de educação infantil receberam novos materiais e organizaram o cronograma de atendimento às famílias.',
                'conteudo' => [
                    'A Secretaria de Educação intensificou o atendimento às famílias para matrículas, rematrículas e atualização cadastral dos estudantes.',
                    'Além do calendário escolar, a rede municipal apresentou projetos pedagógicos voltados à leitura, tecnologia e reforço da aprendizagem.',
                    'As unidades também receberam materiais de apoio para fortalecer o trabalho em sala de aula ao longo do ano letivo.',
                ],
            ],
            [
                'titulo' => 'Obras de infraestrutura avançam em vias estratégicas de Assaí',
                'categoria' => 'Infraestrutura',
                'resumo' => 'Frentes de trabalho atuam em pavimentação, drenagem e melhoria da mobilidade urbana em pontos de maior circulação.',
                'conteudo' => [
                    'As equipes de infraestrutura seguem com obras de pavimentação e drenagem em vias estratégicas para o deslocamento diário da população.',
                    'O cronograma inclui recuperação de trechos, reforço da sinalização e melhorias em acessibilidade para pedestres.',
                    'Segundo a Prefeitura, as intervenções foram priorizadas a partir das demandas registradas pela comunidade e pelos levantamentos técnicos.',
                ],
            ],
            [
                'titulo' => 'Ações ambientais mobilizam escolas e moradores em programação especial',
                'categoria' => 'Meio Ambiente',
                'resumo' => 'Campanhas educativas e atividades práticas reforçam a preservação de áreas verdes e o descarte correto de resíduos.',
                'conteudo' => [
                    'A programação ambiental reuniu escolas, servidores e moradores em atividades de conscientização sobre preservação e sustentabilidade.',
                    'Entre as ações desenvolvidas estão plantio de mudas, coleta seletiva orientada e oficinas sobre uso consciente da água.',
                    'A proposta é ampliar o envolvimento da comunidade e consolidar hábitos sustentáveis no cotidiano da cidade.',
                ],
            ],
            [
                'titulo' => 'Programação cultural valoriza artistas locais e espaços públicos',
                'categoria' => 'Cultura',
                'resumo' => 'Apresentações, oficinas e atividades abertas ao público fortalecem a ocupação cultural em diferentes regiões da cidade.',
                'conteudo' => [
                    'A agenda cultural do município ganhou novas ações com apresentações musicais, oficinas criativas e atividades de formação artística.',
                    'Os eventos valorizam artistas locais e ampliam o uso dos espaços públicos como pontos de convivência e expressão cultural.',
                    'A programação também busca aproximar famílias, jovens e visitantes das iniciativas promovidas pela Prefeitura.',
                ],
            ],
            [
                'titulo' => 'Esporte comunitário recebe novas atividades e calendário ampliado',
                'categoria' => 'Esporte',
                'resumo' => 'Projetos esportivos passam a atender mais faixas etárias, com modalidades voltadas à iniciação e à qualidade de vida.',
                'conteudo' => [
                    'O calendário esportivo municipal foi ampliado com novas turmas, modalidades e horários de atendimento à população.',
                    'As ações incluem atividades de iniciação esportiva, alongamento, recreação e incentivo à prática regular de exercícios.',
                    'O objetivo é promover bem-estar, integração entre os bairros e acesso democrático ao esporte.',
                ],
            ],
            [
                'titulo' => 'Prefeitura intensifica serviços de limpeza e manutenção urbana',
                'categoria' => 'Infraestrutura',
                'resumo' => 'Equipes atuam em roçada, poda, recolhimento de resíduos e conservação de áreas públicas em diversos pontos da cidade.',
                'conteudo' => [
                    'Os serviços de manutenção urbana foram reforçados com novas frentes de trabalho em áreas de maior circulação e convivência.',
                    'As ações contemplam roçada, poda preventiva, limpeza de calçadas e conservação de praças e canteiros.',
                    'A Prefeitura informou que o trabalho seguirá em cronograma contínuo para atender todas as regiões do município.',
                ],
            ],
            [
                'titulo' => 'Campanha social mobiliza rede de apoio e fortalece atendimento às famílias',
                'categoria' => 'Assistência Social',
                'resumo' => 'Equipes ampliam orientações, encaminhamentos e acolhimento para famílias em situação de vulnerabilidade.',
                'conteudo' => [
                    'A rede de assistência social intensificou o atendimento às famílias com foco em acolhimento, orientação e encaminhamentos.',
                    'As equipes também reforçaram o acesso a benefícios eventuais e programas de acompanhamento socioassistencial.',
                    'A iniciativa busca garantir proteção social com atendimento humanizado e mais próximo da realidade de cada território.',
                ],
            ],
        ];

        $noticia = fake()->randomElement($noticias);
        $titulo = $noticia['titulo'];

        return [
            'titulo'          => $titulo,
            'slug'            => Str::slug($titulo) . '-' . fake()->unique()->numerify('####'),
            'categoria'       => $noticia['categoria'],
            'resumo'          => $noticia['resumo'],
            'conteudo'        => implode("\n\n", $noticia['conteudo']),
            'imagem_capa'     => null,
            'data_publicacao' => fake()->dateTimeBetween('-6 months', '+2 months'),
        ];
    }
}
