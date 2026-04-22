<?php

require 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

use App\Services\BuscaInteligente;

echo "=== TESTE DE BUSCA INTELIGENTE ===\n\n";

$testes = [
    'olá',
    'certidão',
    'agendar',
    'horário',
    'serviço',
];

foreach ($testes as $mensagem) {
    $resultado = BuscaInteligente::buscar($mensagem);
    echo "Pergunta: $mensagem\n";
    echo "Confiança: {$resultado['confianca']}%\n";
    echo "Intenção: {$resultado['intencao_id']}\n";
    echo "Resposta: " . substr($resultado['resposta'], 0, 80) . "...\n";
    echo str_repeat('-', 80) . "\n\n";
}
