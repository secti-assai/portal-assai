<?php

require 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

use App\Models\AiConversation;
use Illuminate\Http\Request;
use App\Http\Controllers\Api\AiChatController;

echo "=== TESTE DO ENDPOINT DO CHAT ===\n\n";

// 1. Criar conversa
$conversation = AiConversation::findOrCreateBySession('test_session_123', '127.0.0.1');
echo "Conversa criada: ID {$conversation->id}\n\n";

// 2. Simular requisição POST
$request = new Request();
$request->setMethod('POST');
$request->headers->set('Content-Type', 'application/json');
$request->replace([
    'conversation_id' => $conversation->id,
    'message' => 'certidão',
]);

echo "Enviando para sendMessage()...\n";
$controller = app(AiChatController::class);
$response = $controller->sendMessage($request);

// Converter resposta para array
$content = json_decode($response->content(), true);

echo "\nRESPOSTA DO ENDPOINT:\n";
echo json_encode($content, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);

echo "\n\nESTRUTURA DA RESPOSTA:\n";
echo "- success: " . ($content['success'] ? 'true' : 'false') . "\n";
echo "- data.status: " . $content['data']['status'] . "\n";
echo "- data.response: " . substr($content['data']['response'], 0, 50) . "...\n";
echo "- data.timestamp: " . $content['data']['timestamp'] . "\n";
echo "- data.source: " . $content['data']['source'] . "\n";
echo "- message_count: " . $content['message_count'] . "\n";
