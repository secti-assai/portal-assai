<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\AiConversation;
use App\Services\AiChatService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class AiChatController extends Controller
{
    public function __construct(
        private AiChatService $chatService
    ) {}

    /**
     * Obter ou criar conversa de IA
     */
    public function getOrCreateConversation(Request $request): JsonResponse
    {
        $sessionId = $request->input('session_id') ?? session()->getId();
        $userIp = $request->ip();

        $conversation = AiConversation::findOrCreateBySession($sessionId, $userIp);

        return response()->json([
            'success' => true,
            'conversation_id' => $conversation->id,
            'session_id' => $conversation->session_id,
        ]);
    }

    /**
     * Enviar mensagem e obter resposta
     */
    public function sendMessage(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'conversation_id' => 'required|exists:ai_conversations,id',
            'message' => 'required|string|min:1|max:1000',
        ]);

        try {
            $conversation = AiConversation::findOrFail($validated['conversation_id']);
            
            // Processar mensagem e obter resposta
            $result = $this->chatService->processMessage(
                $conversation,
                $validated['message']
            );

            return response()->json([
                'success' => true,
                'data' => $result,
                'message_count' => $conversation->messages()->count(),
            ]);
        } catch (\DomainException $e) {
            return response()->json([
                'success' => false,
                'error' => $e->getMessage(),
            ], 422);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'error' => 'Erro ao processar mensagem',
                'message' => $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Obter histórico de mensagens
     */
    public function getMessages(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'conversation_id' => 'required|exists:ai_conversations,id',
            'limit' => 'integer|min:1|max:100',
        ]);

        try {
            $conversation = AiConversation::findOrFail($validated['conversation_id']);
            
            $messages = $conversation->messages()
                ->latest()
                ->limit($validated['limit'] ?? 50)
                ->get()
                ->reverse()
                ->values();

            return response()->json([
                'success' => true,
                'messages' => $messages->map(fn ($msg) => [
                    'id' => $msg->id,
                    'role' => $msg->role,
                    'content' => $msg->content,
                    'created_at' => $msg->created_at->toIso8601String(),
                ]),
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'error' => 'Erro ao carregar mensagens',
                'message' => $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Limpar conversa
     */
    public function clearConversation(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'conversation_id' => 'required|exists:ai_conversations,id',
        ]);

        try {
            $conversation = AiConversation::findOrFail($validated['conversation_id']);
            $conversation->messages()->delete();

            return response()->json([
                'success' => true,
                'message' => 'Conversa limpa com sucesso',
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'error' => 'Erro ao limpar conversa',
                'message' => $e->getMessage(),
            ], 500);
        }
    }
}
