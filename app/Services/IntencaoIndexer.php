<?php

declare(strict_types=1);

namespace App\Services;

use App\Cache\IntencaoCache;
use App\Models\Intencao;
use Illuminate\Support\Facades\Log;

class IntencaoIndexer
{
    /**
     * Construir índice invertido de todas as intenções ativas
     * Estrutura: {token: {intencao_id: score}}
     * Armazena em cache (Redis ou memória)
     */
    public static function build(): void
    {
        try {
            $indice = [];
            $indiceContexto = [];

            // Buscar todas as intenções ativas
            $intencoes = Intencao::where('ativa', true)->get();

            foreach ($intencoes as $intencao) {
                // Score base: prioridade + uso ponderado
                $scoreBase = $intencao->prioridade + ($intencao->uso_count * 0.5);

                // Processar triggers (palavras-chave principais)
                if (!empty($intencao->triggers)) {
                    foreach ($intencao->triggers as $trigger) {
                        $tokenTrigger = TextNormalizer::normalize($trigger);
                        $tokens = TextNormalizer::tokenize($tokenTrigger);
                        $tokens = TextNormalizer::removeStopwords($tokens);

                        foreach ($tokens as $token) {
                            if (!isset($indice[$token])) {
                                $indice[$token] = [];
                            }
                            // Triggers têm peso 1.5x (mais importantes)
                            $indice[$token][$intencao->intencao_id] = $scoreBase * 1.5;
                        }
                    }
                }

                // Processar contexto (conteúdo adicional)
                if (!empty($intencao->contexto)) {
                    $frequencias = TextNormalizer::extrairTokensConteudo($intencao->contexto);

                    foreach ($frequencias as $token => $frequencia) {
                        if (!isset($indiceContexto[$token])) {
                            $indiceContexto[$token] = [];
                        }
                        // Contexto tem peso 0.7x e é ponderado por frequência
                        $indiceContexto[$token][$intencao->intencao_id] = ($scoreBase * 0.7) * (1 + log($frequencia + 1));
                    }
                }
            }

            // Armazenar em cache
            IntencaoCache::setIndice($indice);
            IntencaoCache::setContextTokens($indiceContexto);

            Log::info('Índice de intenções construído', [
                'total_intencoes' => $intencoes->count(),
                'total_tokens_trigger' => count($indice),
                'total_tokens_contexto' => count($indiceContexto),
            ]);
        } catch (\Exception $e) {
            Log::error('Erro ao construir índice de intenções', [
                'erro' => $e->getMessage(),
            ]);
            throw $e;
        }
    }

    /**
     * Obter o índice atual
     */
    public static function getIndice(): array
    {
        return IntencaoCache::getIndice();
    }

    /**
     * Limpar o índice
     */
    public static function flush(): void
    {
        IntencaoCache::flush();
        Log::info('Índice de intenções limpo');
    }

    /**
     * Reconstruir índice (flush + build)
     */
    public static function rebuild(): void
    {
        self::flush();
        self::build();
    }
}
