<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Secretaria>
 */
class SecretariaFactory extends Factory
{
    public function definition(): array
    {
        $prefixos = [
            'Secretaria Municipal de', 'Departamento de', 'Coordenadoria de',
            'Secretaria Especial de', 'Subsecretaria de',
        ];

        $areas = [
            'Saúde e Bem-Estar', 'Educação e Cultura', 'Obras e Urbanismo',
            'Meio Ambiente e Recursos Hídricos', 'Administração e Finanças',
            'Desenvolvimento Social', 'Agricultura Familiar',
            'Ciência, Tecnologia e Inovação', 'Esporte e Lazer',
            'Habitação e Saneamento', 'Planejamento e Gestão',
        ];

        $gestores = [
            'Mariana Costa', 'Ricardo Yamamoto', 'Patrícia Fernandes', 'Eduardo Nishimura',
            'Camila Azevedo', 'João Henrique Saito', 'Luciana Martins', 'Felipe Tanaka',
            'Renata Oliveira', 'Carlos Henrique Ueno', 'Aline Barbosa', 'Gustavo Watanabe',
        ];

        $enderecos = [
            'Av. Rio de Janeiro, 720 - Centro, Assaí - PR',
            'Rua Manoel Ribas, 145 - Centro, Assaí - PR',
            'Rua Brasil, 310 - Vila Esperança, Assaí - PR',
            'Av. Tsuruo Tanno, 98 - Centro, Assaí - PR',
            'Rua das Acácias, 54 - Jardim Panorama, Assaí - PR',
        ];

        $descricoes = [
            'Saúde e Bem-Estar' => 'Responsável pela coordenação das unidades de saúde, programas preventivos e ações de promoção do bem-estar da população.',
            'Educação e Cultura' => 'Atua na gestão da rede municipal de ensino, no fortalecimento da aprendizagem e na valorização das expressões culturais locais.',
            'Obras e Urbanismo' => 'Coordena obras públicas, manutenção de vias, drenagem, planejamento urbano e melhorias na infraestrutura da cidade.',
            'Meio Ambiente e Recursos Hídricos' => 'Desenvolve ações de preservação ambiental, educação ecológica, manejo de resíduos e proteção de recursos naturais.',
            'Administração e Finanças' => 'Organiza processos internos, orçamento, arrecadação e apoio administrativo às demais áreas do município.',
            'Desenvolvimento Social' => 'Promove programas de proteção social, atendimento às famílias e ações voltadas à inclusão e ao acolhimento.',
            'Agricultura Familiar' => 'Fortalece a produção rural, a assistência técnica e o apoio aos produtores da agricultura familiar.',
            'Ciência, Tecnologia e Inovação' => 'Fomenta projetos de transformação digital, inovação pública e soluções inteligentes para o desenvolvimento local.',
            'Esporte e Lazer' => 'Incentiva a prática esportiva, organiza atividades comunitárias e amplia o acesso ao lazer em diferentes bairros.',
            'Habitação e Saneamento' => 'Atua em políticas habitacionais, infraestrutura básica e melhoria das condições de saneamento no município.',
            'Planejamento e Gestão' => 'Conduz o planejamento estratégico, o monitoramento de metas e a integração entre programas e políticas públicas.',
        ];

        $area = fake()->randomElement($areas);
        $prefixo = fake()->randomElement($prefixos);
        $nome = $prefixo . ' ' . $area;

        return [
            'nome'            => $nome,
            'nome_secretario' => fake()->randomElement($gestores),
            'descricao'       => $descricoes[$area] ?? 'Responsável pelo planejamento e execução de políticas públicas voltadas ao atendimento da população.',
            'foto'            => null,
            'telefone'        => '(43) ' . fake()->numerify('3###-####'),
            'email'           => Str::slug($area) . '@assai.pr.gov.br',
            'endereco'        => fake()->randomElement($enderecos),
        ];
    }
}
