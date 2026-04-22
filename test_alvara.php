<?php
declare(strict_types=1);

require_once 'vendor/autoload.php';
require_once 'bootstrap/app.php';

use App\Services\BuscaInteligente;

echo "\n=== TESTE DE BUSCA COM 'ALVARÁ' ===\n\n";

$resultado = BuscaInteligente::buscar('alvará');

echo "Resultado: " . $resultado['resposta'] . "\n";
echo "Confiança: " . $resultado['confianca'] . "%\n";
echo "Intenção: " . $resultado['intencao_id'] . "\n\n";

if ($resultado['confianca'] >= 30) {
    echo "✅ SUCESSO! Alvará foi reconhecido com " . $resultado['confianca'] . "% de confiança\n";
} else {
    echo "❌ FALHA! Confiança abaixo de 30%\n";
}
