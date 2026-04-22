<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Programa;

class ProgramaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $destaques = [
            [
                'titulo' => 'Rainha do Rodeio 2026',
                'icone'  => 'img/programas/rainha_rodeio.jpg', // Trocado 'imagem' por 'icone'
                'link'   => 'https://www.assai.pr.gov.br/arquivos/REGULAMENTORAINHADORODEIO2026.pdf',
                'descricao' => 'Confira o regulamento oficial e participe da escolha da Rainha do Rodeio de Assaí 2026. Represente a beleza e a cultura de nossa terra!',
            ],
            [
                'titulo' => 'Cartilha: Juntos por uma Cidade Limpa',
                'icone'  => 'img/programas/cidade_limpa.png', // Trocado 'imagem' por 'icone'
                'link'   => 'https://www.flipsnack.com/prefeituradeassai/cartilha-prefeitura-ordem-impressa.html',
                'descricao' => 'Acesse a nossa cartilha digital e aprenda como descartar corretamente seus resíduos. Pequenas atitudes mantêm Assaí cada vez melhor.',
            ],
            [
                'titulo' => 'Pesquisa de Satisfação',
                'icone'  => 'img/programas/pesquisa_satisfacao.jpg', // Trocado 'imagem' por 'icone'
                'link'   => 'https://docs.google.com/forms/d/e/1FAIpQLSc0lpSL1zZMc4by5oNd0pUqbgU2EJHWmNn5lTbs9863Maiv6w/viewform',
                'descricao' => 'Sua opinião é fundamental para nós. Participe da nossa pesquisa e ajude a melhorar os serviços públicos oferecidos pela Prefeitura.',
            ],
        ];

        foreach ($destaques as $item) {
            Programa::updateOrCreate(
                ['titulo' => $item['titulo']], 
                [
                    'icone'     => $item['icone'],
                    'link'      => $item['link'],
                    'descricao' => $item['descricao'],
                    'ativo'     => true,
                    'destaque'  => true,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]
            );
        }
    }
}