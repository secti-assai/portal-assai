<?php

declare(strict_types=1);

namespace App\Services;

use App\Models\AiConversation;
use App\Models\AiMessage;
use Illuminate\Support\Facades\Http;

class AiChatService
{
    private string $externalApiUrl = 'http://127.0.0.1:8001/api';

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

        // Tentar usar Busca Inteligente primeiro
        $botResponse = null;
        $source = null;

        try {
            $resultado = BuscaInteligente::buscar($userMessage);
            
            // Se confiança for aceitável, usar resultado
            if ($resultado['confianca'] >= 30) {
                $botResponse = $resultado['resposta'];
                $source = 'busca_inteligente';
            }
        } catch (\Exception $e) {
            \Log::warning('Erro ao usar Busca Inteligente', [
                'error' => $e->getMessage(),
                'conversation_id' => $conversation->id,
            ]);
        }

        // Fallback para API externa se Busca Inteligente tiver baixa confiança
        if (!$botResponse) {
            try {
                $response = Http::timeout(30)
                    ->post("{$this->externalApiUrl}/chat/send", [
                        'message' => $userMessage,
                        'conversation_id' => $conversation->id,
                        'session_id' => $conversation->session_id,
                    ])
                    ->throw();

                $botResponse = $response->json('response') ?? $response->json('data.response');
                $source = 'external_api';
            } catch (\Exception $e) {
                \Log::error('Erro ao conectar com API externa IA', [
                    'error' => $e->getMessage(),
                    'conversation_id' => $conversation->id,
                ]);
            }
        }

        // Fallback local se nada funcionar
        if (!$botResponse) {
            $botResponse = $this->generateLocalResponse($userMessage);
            $source = 'local_fallback';
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

    /**
     * Gerar resposta local (fallback quando Busca Inteligente e API externa falharem)
     */
    private function generateLocalResponse(string $userMessage): string
    {
        $message = mb_strtolower($userMessage);

        // Base de conhecimento sobre serviços municipais
        $responses = [
            'serviço|serviços|disponível' => 'Oferecemos diversos serviços nas secretarias municipais como: certidões, licenças, alvarás, registros e documentações. Qual tipo de serviço você procura?',
            
            'certidão|certidões' => 'Para solicitar uma certidão: 1) Ir pessoalmente ao balcão da Prefeitura. 2) Enviar solicitação pelo gov.assai.pr.gov.br. 3) Ligar para a secretaria responsável. Qual tipo de certidão você precisa?',
            
            'denúncia|denunciar|reclamação' => 'Você pode fazer denúncias através da Ouvidoria: https://www.govfacilcidadao.com.br/login ou na Prefeitura pessoalmente. Todas as denúncias são analisadas com sigilo.',
            
            'agendamento|agendar|marcar' => 'Para agendar atendimento, visite nossa plataforma de agendamento online ou entre em contato com a secretaria desejada.',
            
            'horário|horários|funcionamento' => 'Os horários geralmente são de segunda a sexta-feira das 8h às 17h. Qual secretaria você procura?',
            
            'transparência|portal transparência|licitações' => 'Acesse nosso Portal da Transparência em: transparencia.betha.cloud. Todos os dados públicos estão disponíveis.',
            
            'obrigado|valeu|thanks|obrigada' => 'De nada! Se precisar de mais ajuda, é só chamar. 😊',
            
            'oi|olá|opa' => 'Oi! Bem-vindo ao atendimento municipal. Como posso ajudá-lo?',
            
            'adeus|tchau|até logo' => 'Até logo! Volte sempre que precisar. 👋',
        ];

        // Buscar melhor correspondência
        foreach ($responses as $pattern => $response) {
            if ($this->matchesPattern($message, $pattern)) {
                return $response;
            }
        }

        // Resposta padrão se não encontrar correspondência
        return 'Desculpe, não compreendi sua pergunta. Poderia reformular? Estou aqui para ajudar com informações sobre serviços municipais, documentos e procedimentos.';
    }

    /**
     * Verificar se a mensagem corresponde ao padrão
     */
    private function matchesPattern(string $message, string $pattern): bool
    {
        $keywords = explode('|', $pattern);
        
        foreach ($keywords as $keyword) {
            if (strpos($message, trim($keyword)) !== false) {
                return true;
            }
        }
        
        return false;
    }
}


