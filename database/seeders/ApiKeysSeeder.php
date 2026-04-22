<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\Models\ApiKey;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class ApiKeysSeeder extends Seeder
{
    public function run(): void
    {
        $apiKeys = [
            [
                'key' => 'test_' . Str::random(32),
                'nome' => 'Chave de Teste',
                'descricao' => 'Chave padrão para testes da API IA',
                'ativa' => true,
            ],
            [
                'key' => 'prod_' . Str::random(32),
                'nome' => 'Chave de Produção',
                'descricao' => 'Chave para uso em produção',
                'ativa' => true,
            ],
        ];

        foreach ($apiKeys as $apiKey) {
            ApiKey::updateOrCreate(
                ['nome' => $apiKey['nome']],
                $apiKey
            );
        }
    }
}
