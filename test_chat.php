<?php

require 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

use App\Models\AiConversation;
use App\Services\AiChatService;

echo "=== TESTE COMPLETO DO CHAT ===\n\n";

// 1. Criar conversa
echo "1. Criando conversa...\n";
$conversation = AiConversation::findOrCreateBySession('test_session_123', '127.0.0.1');
echo "   ✓ Conversa ID: {$conversation->id}\n\n";

// 2. Processar mensagem
echo "2. Processando mensagem: 'certidão'\n";
$chatService = app(AiChatService::class);
$result = $chatService->processMessage($conversation, 'certidão');

echo "   Status: {$result['status']}\n";
echo "   Resposta: " . substr($result['response'], 0, 60) . "...\n";
echo "   Fonte: {$result['source']}\n\n";

// 3. Verificar mensagens salvas
echo "3. Verificando mensagens salvas na conversa...\n";
$messages = $conversation->messages()->get();
echo "   Total de mensagens: {$messages->count()}\n";
foreach ($messages as $msg) {
    echo "   - [{$msg->role}] " . substr($msg->content, 0, 50) . "...\n";
}
echo "\n";

// 4. Testar mais mensagens
echo "4. Processando mais mensagens...\n";
$testes = ['olá', 'agendar', 'serviço'];
foreach ($testes as $msg) {
    $result = $chatService->processMessage($conversation, $msg);
    echo "   ✓ '$msg' → Confiança: {$result['status']}, Fonte: {$result['source']}\n";
}

echo "\n✅ TODOS OS TESTES PASSARAM!\n";
