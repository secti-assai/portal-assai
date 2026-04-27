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

        // Nome dos arquivos de foto (coloque as fotos em public/img/secretarias/)
        // Se não houver foto, use 'default.jpg'
        $secretarias = [
            [
                'nome' => 'Gabinete do Prefeito',
                'email' => 'gabinete@assai.pr.gov.br',
                'nome_secretario' => 'Paulo Roberto Moreira',
                'foto' => 'paulo_roberto_moreira.jpg',
            ],
            [
                'nome' => 'Procuradoria Geral do Município',
                'email' => 'juridico@assai.pr.gov.br',
                'nome_secretario' => 'Whashington Rafael Proenca da Fonseca',
                'foto' => 'whashington_rafael_proenca_da_fonseca.jpg',
            ],
            [
                'nome' => 'Secretaria de Administração e RH',
                'email' => 'adm@assai.pr.gov.br',
                'nome_secretario' => 'Claudio Roberto Prudencio',
                'foto' => 'claudio_roberto_prudencio.jpg',
            ],
            [
                'nome' => 'Secretaria de Agricultura, Abastecimento e Meio Ambiente',
                'email' => 'agricultura@assai.pr.gov.br',
                'nome_secretario' => 'Adilson Lopes',
                'telefone' => '(43) 3262-0089',
                'foto' => 'adilson_lopes.jpg',
            ],
            [
                'nome' => 'Secretaria de Assistência Social',
                'email' => 'smas@assai.pr.gov.br',
                'nome_secretario' => 'Vera Lucia Lourenco',
                'telefone' => '(43) 3262-1223',
                'foto' => 'vera_lucia_lourenco.jpg',
            ],
            [
                'nome' => 'Secretaria de Ciência, Tecnologia e Inovação',
                'email' => 'secti@assai.pr.gov.br',
                'nome_secretario' => 'Igor Lima Freire Oliveira',
                'telefone' => '(43) 3262-0516',
                'foto' => 'igor_lima_freire_oliveira.jpg',
            ],
            [
                'nome' => 'Secretaria de Cultura e Turismo',
                'email' => 'cultura@assai.pr.gov.br',
                'nome_secretario' => 'Mariana Valeria Leonardi',
                'telefone' => '(43) 3262-3232',
                'foto' => 'mariana_valeria_leonardi.jpg',
            ],
            [
                'nome' => 'Secretaria de Engenharias e Planejamento Urbano',
                'email' => 'desenvolvimento@assai.pr.gov.br',
                'nome_secretario' => 'Flavio Valini',
                'foto' => 'flavio_valini.jpg',
            ],
            [
                'nome' => 'Secretaria de Educação',
                'email' => 'educacao@assai.pr.gov.br',
                'nome_secretario' => 'Josiane Santana Cheffer',
                'telefone' => '(43) 3262-8451',
                'foto' => 'josiane_santana_cheffer.jpg',
            ],
            [
                'nome' => 'Secretaria de Saúde',
                'email' => 'saude@assai.pr.gov.br',
                'nome_secretario' => 'Dylan Custodio',
                'telefone' => '(43) 3262-8405',
                'foto' => 'dylan_custodio.jpg',
            ],
            [
                'nome' => 'Secretaria de Esporte e Lazer',
                'email' => 'esporte@assai.pr.gov.br',
                'nome_secretario' => 'Roberto Fernandes',
                'telefone' => '(43) 3262-1964',
                'foto' => 'roberto_fernandes.jpg',
            ],
            [
                'nome' => 'Secretaria de Finanças',
                'email' => 'financas@assai.pr.gov.br',
                'nome_secretario' => 'Nilse Shinohata Menegazzo',
                'foto' => 'nilse_shinohata_menegazzo.jpg',
            ],
            [
                'nome' => 'Secretaria de Obras e Serviços Públicos',
                'email' => 'obras@assai.pr.gov.br',
                'nome_secretario' => 'Orlando Menegazzo Filho',
                'telefone' => '(43) 3262-0089',
                'foto' => 'orlando_menegazzo_filho.jpg',
            ],
            [
                'nome' => 'Secretaria de Trabalho e Renda',
                'email' => 'trabalho@assai.pr.gov.br',
                'nome_secretario' => 'Orlando Junior',
                'telefone' => '(43) 3262-4958',
                'foto' => 'orlando_junior.jpg',
            ],
            [
                'nome' => 'Secretaria de Suprimentos',
                'email' => 'suprimentos@assai.pr.gov.br',
                'nome_secretario' => '',
                'telefone' => '(43) 3262-1313',
                'foto' => 'default.jpg',
            ],
            [
                'nome' => 'Secretaria de Segurança Alimentar e Nutrição',
                'email' => 'ouvidoria@assai.pr.gov.br',
                'nome_secretario' => 'Margareth Ferreira',
                'telefone' => '(43) 3262-4349',
                'foto' => 'margareth_ferreira.jpg',
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
                            'foto' => $secretaria['foto'] ?? 'default.jpg',
                            'telefone' => $secretaria['telefone'] ?? $telefonePadrao,
                            'email' => $secretaria['email'],
                            'endereco' => $secretaria['endereco'] ?? $enderecoPadrao
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