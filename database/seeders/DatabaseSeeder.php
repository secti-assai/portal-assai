<?php

namespace Database\Seeders;

use App\Models\Alerta;
use App\Models\Banner;
use App\Models\Evento;
use App\Models\Noticia;
use App\Models\Programa;
use App\Models\Secretaria;
use App\Models\Servico;
use App\Models\User;
use App\Models\Executivo;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    public function run(): void
    {
        $this->call([RolesAndPermissionsSeeder::class]);

        // Usuário administrador (preservado)
        $this->call([AdminSeeder::class]);
        $this->call([SecretariaSeeder::class]);
        $this->call([ExecutivosSeeder::class]);
        $this->call([ServicoSeeder::class]);
        $this->call([PortalSeeder::class]);
        
        // Programas municipais
        Programa::factory(10)->create();

        // Serviços associados às secretarias
        Servico::factory(50)->create();

        // MAPEAMENTO CORRETO: Classe do FontAwesome => Contexto
        $iconesValidos = [
            'file-alt'            => 'padrao',
            'heart-pulse'         => 'saude',
            'briefcase'           => 'vagas',
            'file-lines'          => 'documentos',
            'bullhorn'            => 'ouvidoria',
            'file-signature'      => 'alvara',
            'graduation-cap'      => 'educacao',
        ];

        $descricoesFixas = [
            'padrao'    => 'Acesse os serviços digitais da Prefeitura de Assaí de forma prática, sem precisar sair de casa. Agilidade e comodidade para você e sua família.',
            'saude'     => 'Consulte unidades de saúde, agende atendimentos e acesse informações sobre campanhas de vacinação, prevenção e promoção da saúde no município.',
            'vagas'     => 'Confira as oportunidades de emprego disponíveis no município, cadastre seu currículo e acompanhe os processos seletivos da Prefeitura e parceiros.',
            'documentos'=> 'Emita certidões, requerimentos e documentos oficiais de forma digital, com validade jurídica, sem precisar ir presencialmente à Prefeitura.',
            'ouvidoria' => 'Registre sua reclamação, sugestão, elogio ou denúncia sobre os serviços públicos. Todas as manifestações são analisadas e respondidas em até 30 dias.',
            'alvara'    => 'Solicite, acompanhe e renove alvarás de funcionamento, construção e habite-se de forma online, com orientação da equipe técnica municipal.',
            'educacao'  => 'Acesse informações sobre matrículas, calendário escolar, transporte e demais serviços oferecidos pela Secretaria de Educação do município.',
        ];

        // Garante cobertura dos filtros com ícones válidos e descrições
        foreach ($iconesValidos as $faClass => $contexto) {
            Servico::factory()->create([
                'titulo'    => 'Serviço de teste - ' . ucfirst($contexto) . ' ativo',
                'descricao' => $descricoesFixas[$contexto],
                'icone'     => $faClass,
                'ativo'     => true,
            ]);

            Servico::factory()->create([
                'titulo'    => 'Serviço de teste - ' . ucfirst($contexto) . ' inativo',
                'descricao' => $descricoesFixas[$contexto],
                'icone'     => $faClass,
                'ativo'     => false,
            ]);
        }

        // Eventos
        Evento::factory(10)->create();

        Evento::factory()->create([
            'titulo' => 'Evento de teste agendado',
            'status' => 'confirmado',
            'data_inicio' => now()->addDays(20),
            'data_fim' => now()->addDays(21),
        ]);

        Evento::factory()->create([
            'titulo' => 'Evento de teste realizado',
            'status' => 'confirmado',
            'data_inicio' => now()->subDays(20),
            'data_fim' => now()->subDays(19),
        ]);

        Evento::factory()->create([
            'titulo' => 'Evento de teste cancelado',
            'status' => 'cancelado',
            'data_inicio' => now()->addDays(40),
            'data_fim' => now()->addDays(41),
        ]);

    }
}