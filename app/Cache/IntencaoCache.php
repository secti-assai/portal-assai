<?php

declare(strict_types=1);

namespace App\Cache;

use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Redis;

class IntencaoCache
{
    private const CACHE_KEY = 'intencoes:indice';
    private const TOKENS_KEY = 'intencoes:tokens:stats';
    private const CONTEXT_TOKENS_KEY = 'intencoes:context:tokens';
    private const CACHE_TTL = 86400; // 24 horas
    private const TOKENS_TTL = 2592000; // 30 dias
    private static array $memoryFallback = [];
    private static bool $redisAvailable = true;

    /**
     * Obter o índice invertido de intenções do cache
     * Fallback para memória se Redis não estiver disponível
     */
    public static function getIndice(): array
    {
        // Primeiro tentar obter da memória (mais rápido)
        if (!empty(self::$memoryFallback)) {
            return self::$memoryFallback;
        }

        // Tentar obter do Redis
        try {
            $indice = Cache::get(self::CACHE_KEY);
            if ($indice !== null) {
                // Armazenar em memória para próximas chamadas
                self::$memoryFallback = $indice;
                return $indice;
            }
        } catch (\Exception $e) {
            Log::warning('Redis indisponível, usando fallback em memória', [
                'erro' => $e->getMessage(),
            ]);
            self::$redisAvailable = false;
        }

        return [];
    }

    /**
     * Armazenar o índice invertido em cache
     */
    public static function setIndice(array $indice): void
    {
        // Sempre armazenar em memória primeiro
        self::$memoryFallback = $indice;

        try {
            Cache::put(self::CACHE_KEY, $indice, self::CACHE_TTL);
        } catch (\Exception $e) {
            Log::warning('Falha ao armazenar índice no Redis', [
                'erro' => $e->getMessage(),
            ]);
        }
    }

    /**
     * Limpar cache de intenções
     */
    public static function flush(): void
    {
        self::$memoryFallback = [];
        try {
            Cache::forget(self::CACHE_KEY);
        } catch (\Exception $e) {
            Log::warning('Falha ao limpar cache do Redis', [
                'erro' => $e->getMessage(),
            ]);
        }
    }

    /**
     * Verificar se Redis está disponível
     */
    public static function isRedisAvailable(): bool
    {
        return self::$redisAvailable;
    }

    /**
     * Armazenar índice de tokens do contexto (conteúdo das intenções)
     * Estrutura: token => [intencao_id => score_contexto]
     */
    public static function setContextTokens(array $tokens): void
    {
        try {
            Cache::put(self::CONTEXT_TOKENS_KEY, $tokens, self::CACHE_TTL);
            Log::debug('Tokens de contexto armazenados', ['total_tokens' => count($tokens)]);
        } catch (\Exception $e) {
            Log::warning('Falha ao armazenar tokens de contexto no Redis', [
                'erro' => $e->getMessage(),
            ]);
        }
    }

    /**
     * Obter índice de tokens do contexto
     */
    public static function getContextTokens(): array
    {
        try {
            $tokens = Cache::get(self::CONTEXT_TOKENS_KEY);
            return $tokens ?? [];
        } catch (\Exception $e) {
            Log::warning('Falha ao obter tokens de contexto', [
                'erro' => $e->getMessage(),
            ]);
            return [];
        }
    }

    /**
     * Incrementar contador de acesso a um token
     * Rastreia quantas vezes um token foi requisitado/percorrido
     */
    public static function incrementarAcessoToken(string $token): void
    {
        try {
            $chave = self::TOKENS_KEY . ':' . $token;
            $acessosAtuais = (int) Cache::get($chave, 0);
            $novoTotal = $acessosAtuais + 1;
            Cache::put($chave, $novoTotal, now()->addSeconds(self::TOKENS_TTL));
        } catch (\Exception $e) {
            Log::warning('Falha ao incrementar acesso de token', [
                'token' => $token,
                'erro' => $e->getMessage(),
            ]);
        }
    }

    /**
     * Incrementar múltiplos tokens de uma vez
     */
    public static function incrementarAcessosTokens(array $tokens): void
    {
        foreach ($tokens as $token) {
            self::incrementarAcessoToken($token);
        }
    }

    /**
     * Obter estatísticas de acesso de um token
     */
    public static function getEstatisticasToken(string $token): array
    {
        try {
            $chave = self::TOKENS_KEY . ':' . $token;
            $acessos = Cache::get($chave) ?? 0;
            return [
                'token' => $token,
                'acessos' => $acessos,
                'ultima_atualizacao' => now()->toDateTimeString(),
            ];
        } catch (\Exception $e) {
            Log::warning('Falha ao obter estatísticas do token', [
                'token' => $token,
                'erro' => $e->getMessage(),
            ]);
            return ['token' => $token, 'acessos' => 0];
        }
    }

    /**
     * Obter top N tokens mais acessados
     */
    public static function getTokensMaisAcessados(int $limite = 50): array
    {
        try {
            $tokens = [];

            // Obter o Redis client
            $redis = Redis::connection('default');
            $padrao = self::TOKENS_KEY . ':*';

            // Usar SCAN em vez de KEYS para melhor performance
            $cursor = 0;
            $chaves = [];

            do {
                $resultado = $redis->scan($cursor, ['match' => $padrao, 'count' => 100]);
                $cursor = $resultado[0];
                $chaves = array_merge($chaves, $resultado[1]);
            } while ($cursor != 0);

            foreach ($chaves as $chave) {
                $token = str_replace(self::TOKENS_KEY . ':', '', $chave);
                $acessos = (int) $redis->get($chave);
                if ($acessos > 0) {
                    $tokens[$token] = $acessos;
                }
            }

            // Ordenar por número de acessos (descendente)
            arsort($tokens);

            return array_slice($tokens, 0, $limite, true);
        } catch (\Exception $e) {
            Log::warning('Falha ao obter tokens mais acessados', [
                'erro' => $e->getMessage(),
            ]);
            return [];
        }
    }

    /**
     * Limpar estatísticas de tokens
     */
    public static function limparEstatisticasTokens(): void
    {
        try {
            $redis = Redis::connection('default');
            $padrao = self::TOKENS_KEY . ':*';

            $cursor = 0;

            do {
                $resultado = $redis->scan($cursor, ['match' => $padrao, 'count' => 100]);
                $cursor = $resultado[0];
                $chaves = $resultado[1];

                if (!empty($chaves)) {
                    $redis->del(...$chaves);
                }
            } while ($cursor != 0);

            Log::info('Estatísticas de tokens limpas');
        } catch (\Exception $e) {
            Log::warning('Falha ao limpar estatísticas de tokens', [
                'erro' => $e->getMessage(),
            ]);
        }
    }
}
