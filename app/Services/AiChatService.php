<?php

declare(strict_types=1);

namespace App\Services;

use App\Models\AiConversation;
use App\Models\AiMessage;
use Illuminate\Support\Facades\Log;

class AiChatService
{
    /**
     * Processar mensagem usando Busca Inteligente como padrão
     */
    public function processMessage(AiConversation $conversation, string $userMessage): array
    {
        // Salvar mensagem do usuário
        AiMessage::addMessage(
            $conversation->id,
            'user',
            $userMessage,
            ['ip' => request()->ip()]
        );

        if (!BuscaInteligente::temCorrespondenciaNoVault($userMessage)) {
            throw new \DomainException('Não encontrei essa informação. Pode reformular ou dar mais detalhes? Se preferir, fale com a Secretaria de Ciência e Inovação pelo WhatsApp (43) 3262-8306.');
        }

        try {
            $resultado = BuscaInteligente::buscar($userMessage);
            $confianca = (int) ($resultado['confianca'] ?? 0);

            if ($confianca < 30) {
                throw new \DomainException('Assunto nao encontrado na base de conhecimento.');
            }

            $botResponse = (string) ($resultado['resposta'] ?? '');
            $source = 'busca_inteligente';
        } catch (\DomainException $e) {
            throw $e;
        } catch (\Exception $e) {
            Log::error('Erro ao usar Busca Inteligente', [
                'error' => $e->getMessage(),
                'conversation_id' => $conversation->id,
            ]);

            throw new \RuntimeException('Erro ao processar mensagem no mecanismo de busca.');
        }

        // Salvar resposta do bot
        AiMessage::addMessage(
            $conversation->id,
            'bot',
            $botResponse,
            [
                'generated_at' => now(),
                'source' => $source,
            ]
        );

        return [
            'status' => 'success',
            'response' => $botResponse,
            'timestamp' => now()->toIso8601String(),
            'source' => $source,
        ];
    }
}


