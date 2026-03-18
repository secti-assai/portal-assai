<?php

declare(strict_types=1);

namespace Tests\Feature;

use App\Models\Secretaria;
use App\Models\Servico;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PublicSearchNormalizationTest extends TestCase
{
    use RefreshDatabase;

    public function test_servicos_public_search_ignores_case_and_accents(): void
    {
        $secretaria = Secretaria::factory()->create();

        Servico::factory()->create([
            'secretaria_id' => $secretaria->id,
            'titulo' => 'Emissão de Alvará Comercial',
            'link' => 'https://exemplo.test/alvara',
            'ativo' => true,
        ]);

        Servico::factory()->create([
            'secretaria_id' => $secretaria->id,
            'titulo' => 'Cadastro de Transporte Escolar',
            'link' => 'https://exemplo.test/transporte',
            'ativo' => true,
        ]);

        $response = $this->get(route('servicos.index', ['search' => 'ALVARA']));

        $response->assertOk();
        $response->assertSee('Emissão de Alvará Comercial');
        $response->assertDontSee('Cadastro de Transporte Escolar');
    }

    public function test_secretarias_public_search_ignores_case_and_accents(): void
    {
        Secretaria::factory()->create([
            'nome' => 'Secretária de Saúde',
            'nome_secretario' => 'Mariana Costa',
        ]);

        Secretaria::factory()->create([
            'nome' => 'Secretaria de Educação',
            'nome_secretario' => 'Ricardo Saito',
        ]);

        $response = $this->get(route('secretarias.index', ['search' => 'SECRETARIA DE SAUDE']));

        $response->assertOk();
        $response->assertSee('Secretária de Saúde');
        $response->assertDontSee('Secretaria de Educação');
    }
}
