<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\Models\Secretaria;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Throwable;
use Illuminate\Support\Facades\Log;

class SecretariaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     * Implementação baseada na extração de dados reais do portal oficial (assai.pr.gov.br).
     * Mapeamento estrito dos campos `$fillable` definidos no Model Secretaria.
     * Proteção transacional (ACID) para inserção em lote.
     */
    public function run(): void
    {
        // Endereço e telefone padrões da Prefeitura Municipal de Assaí
        $enderecoPadrao = 'Av. Rio de Janeiro, 720 - CEP 86220-000 - Assaí - PR';
        $telefonePadrao = '(43) 3262-1313';

        $secretarias = [
            [
                'nome' => 'Chefe de Gabinete',
                'email' => 'gabinete@assai.pr.gov.br',
                'nome_secretario' => 'A Definir',
            ],
            [
                'nome' => 'Procuradoria Geral',
                'email' => 'procuradoria@assai.pr.gov.br',
                'nome_secretario' => 'A Definir',
            ],
            [
                'nome' => 'Secretaria de Administração e Recursos Humanos',
                'email' => 'adm@assai.pr.gov.br',
                'nome_secretario' => 'Claudio Roberto Prudêncio', //
            ],
            [
                'nome' => 'Secretaria de Agricultura, Abastecimento e Meio Ambiente',
                'email' => 'agricultura@assai.pr.gov.br',
                'nome_secretario' => 'A Definir',
            ],
            [
                'nome' => 'Secretaria de Assistência Social',
                'email' => 'assistenciasocial@assai.pr.gov.br',
                'nome_secretario' => 'A Definir',
            ],
            [
                'nome' => 'Secretaria de Ciência Tecnologia e Inovação',
                'email' => 'tecnologia@assai.pr.gov.br',
                'nome_secretario' => 'A Definir',
            ],
            [
                'nome' => 'Secretaria de Cultura e Turismo',
                'email' => 'cultura@assai.pr.gov.br',
                'nome_secretario' => 'Mariana Valéria Leonardi', //
            ],
            [
                'nome' => 'Secretaria de Desenvolvimento Local',
                'email' => 'desenvolvimento@assai.pr.gov.br',
                'nome_secretario' => 'A Definir',
            ],
            [
                'nome' => 'Secretaria de Educação',
                'email' => 'educacao@assai.pr.gov.br',
                'nome_secretario' => 'A Definir',
            ],
            [
                'nome' => 'Secretaria de Esporte e Lazer',
                'email' => 'esporte@assai.pr.gov.br',
                'nome_secretario' => 'A Definir',
            ],
            [
                'nome' => 'Secretaria de Finanças',
                'email' => 'financas@assai.pr.gov.br',
                'nome_secretario' => 'A Definir',
            ],
            [
                'nome' => 'Secretaria de Obras e Serviços',
                'email' => 'obras@assai.pr.gov.br',
                'nome_secretario' => 'A Definir',
            ],
            [
                'nome' => 'Secretaria de Saúde',
                'email' => 'saude@assai.pr.gov.br',
                'nome_secretario' => 'Dylan Custódio', //
            ],
            [
                'nome' => 'Secretaria de Trabalho, Emprego e Geração de Renda',
                'email' => 'trabalho@assai.pr.gov.br',
                'nome_secretario' => 'A Definir',
            ],
            [
                'nome' => 'Secretaria Municipal de Segurança Alimentar e Nutrição',
                'email' => 'segurancaalimentar@assai.pr.gov.br',
                'nome_secretario' => 'A Definir',
            ],
        ];

        try {
            DB::transaction(function () use ($secretarias, $enderecoPadrao, $telefonePadrao) {
                foreach ($secretarias as $secretaria) {
                    Secretaria::updateOrCreate(
                        ['nome' => $secretaria['nome']], // Chave de verificação para evitar duplicidade
                        [
                            'nome_secretario' => $secretaria['nome_secretario'],
                            'descricao' => "Página institucional da {$secretaria['nome']} do município de Assaí. Responsável pela formulação, planejamento e execução de políticas públicas correlatas à pasta, garantindo atendimento, transparência e eficiência para a população.",
                            'foto' => null,
                            'telefone' => $telefonePadrao,
                            'email' => $secretaria['email'],
                            'endereco' => $enderecoPadrao,
                        ]
                    );
                }
            });
        } catch (Throwable $e) {
            Log::error('Erro ao executar SecretariaSeeder: ' . $e->getMessage());
            throw $e;
        }
    }
}