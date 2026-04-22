<?php
declare(strict_types=1);

require_once 'vendor/autoload.php';
require_once 'bootstrap/app.php';

use App\Models\Intencao;

echo "\n=== TODAS AS INTENÇÕES E SEUS TRIGGERS ===\n\n";

foreach (Intencao::all() as $intencao) {
    echo "ID: " . $intencao->intencao_id . "\n";
    echo "Triggers: " . implode(', ', $intencao->triggers) . "\n";
    echo "---\n";
}

echo "\n✓ Verifique se 'alvará' está em alguma lista acima\n";
