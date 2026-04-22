<?php

declare(strict_types=1);

namespace App\Services;

use App\Cache\IntencaoCache;
use App\Models\Intencao;
use App\Models\QueryNaoRespondida;
use Illuminate\Support\Facades\Log;

class BuscaInteligente
{
    private const CONFIANCA_MINIMA = 30; // 30%
    private const RESPOSTA_PADRAO = 'Desculpe, não consegui entender sua pergunta. Tente usar palavras-chave como "serviço", "horário", "contato" ou "agendamento".';
    private const LIMIAR_FUZZY = 0.75; // 75% de similaridade

    /**
     * Realizar busca inteligente na base de intenções
     * 
     * @return array ['resposta' => string, 'confianca' => int (0-100), 'intencao_id' => ?string]
     */
    public static function buscar(string $mensagem): array
    {
        if (empty(trim($mensagem))) {
            return [
                'resposta' => self::RESPOSTA_PADRAO,
                'confianca' => 0,
                'intencao_id' => null,
            ];
        }

        // Normalizar e processar entrada
        $mensagemNormalizada = TextNormalizer::normalize($mensagem);
        $tokens = TextNormalizer::tokenize($mensagemNormalizada);
        $tokens = TextNormalizer::removeStopwords($tokens);

        if (empty($tokens)) {
            return [
                'resposta' => self::RESPOSTA_PADRAO,
                'confianca' => 0,
                'intencao_id' => null,
            ];
        }

        // Obter índice de intenções
        $indice = IntencaoCache::getIndice();
        if (empty($indice)) {
            // Se índice vazio, tentar reconstruir
            IntencaoIndexer::build();
            $indice = IntencaoCache::getIndice();
        }

        // Calcular scores de relevância
        $resultados = self::calcularScores($tokens, $indice);

        // Encontrar melhor resultado
        if (empty($resultados)) {
            return self::logNaoRespondida($mensagem, null, 0);
        }

        // Ordenar por score descendente
        arsort($resultados);
        $melhorResultado = reset($resultados);
        $melhorIntencaoId = key($resultados);

        // Normalizar confiança para 0-100
        $confianca = min(100, max(0, (int) $melhorResultado));

        if ($confianca < self::CONFIANCA_MINIMA) {
            return self::logNaoRespondida($mensagem, $melhorIntencaoId, $confianca);
        }

        // Buscar intenção completa
        $intencao = Intencao::where('intencao_id', $melhorIntencaoId)->first();
        if (!$intencao) {
            return self::logNaoRespondida($mensagem, $melhorIntencaoId, $confianca);
        }

        // Registrar acesso aos tokens (para aprendizado)
        IntencaoCache::incrementarAcessosTokens($tokens);
        $intencao->incrementarUso();

        Log::info('Query respondida com sucesso', [
            'mensagem' => $mensagem,
            'intencao_id' => $melhorIntencaoId,
            'confianca' => $confianca,
        ]);

        return [
            'resposta' => $intencao->resposta,
            'confianca' => $confianca,
            'intencao_id' => $melhorIntencaoId,
        ];
    }

    /**
     * Calcular scores de relevância para todas as intenções
     * Implementa algoritmo sofisticado com múltiplas heurísticas:
     * - Especificidade de tokens (tokens raros são mais específicos)
     * - Triggers vs contexto (triggers têm peso 1.5x)
     * - Fuzzy matching para typos
     * - Boost para múltiplos matches
     * 
     * @return array [intencao_id => score]
     */
    private static function calcularScores(array $tokens, array $indice): array
    {
        $resultados = [];
        $contagemMatches = [];
        $maiorEspecificidade = [];

        // Calcular especificidade: tokens raros são mais específicos
        // Frequência dos tokens no índice determina especificidade
        $frequenciaTokens = [];
        foreach ($indice as $token => $scores) {
            foreach ($scores as $intencaoId => $score) {
                $frequenciaTokens[$token] = ($frequenciaTokens[$token] ?? 0) + 1;
            }
        }

        // Processar cada token da query
        foreach ($tokens as $token) {
            $encontrado = false;

            // Buscar match exato no índice
            if (isset($indice[$token])) {
                $encontrado = true;
                $frequencia = $frequenciaTokens[$token] ?? 1;

                // Calcular especificidade (tokens menos frequentes são mais específicos)
                // Tiers de especificidade baseados em frequência
                if ($frequencia > 8) {
                    $especificidade = 0.1; // Muito comum, pouco específico
                } elseif ($frequencia > 5) {
                    $especificidade = 0.2;
                } elseif ($frequencia > 3) {
                    $especificidade = 0.4;
                } elseif ($frequencia > 1) {
                    $especificidade = 0.7; // Raro, muito específico
                } else {
                    $especificidade = 1.0; // Único, máxima especificidade
                }

                // Aplicar scores das triggers para esta intenção
                foreach ($indice[$token] as $intencaoId => $score) {
                    if (!isset($resultados[$intencaoId])) {
                        $resultados[$intencaoId] = 0;
                    }

                    // Score com especificidade: tokens mais raros (específicos) valem mais
                    $scoreComEspecificidade = $score * (1.0 + $especificidade); // 1.0-2.0 range
                    $resultados[$intencaoId] += $scoreComEspecificidade;

                    // Rastrear especificidade máxima por intenção
                    if (!isset($maiorEspecificidade[$intencaoId])) {
                        $maiorEspecificidade[$intencaoId] = 0;
                    }
                    $maiorEspecificidade[$intencaoId] = max($maiorEspecificidade[$intencaoId], $especificidade);

                    // Contar quantos matches essa intenção tem
                    if (!isset($contagemMatches[$intencaoId])) {
                        $contagemMatches[$intencaoId] = 0;
                    }
                    $contagemMatches[$intencaoId]++;
                }
            } else {
                // Tentar fuzzy matching para typos
                $similares = self::encontrarTokensSimilares($token, $indice);
                if (!empty($similares)) {
                    $encontrado = true;
                    foreach ($similares as $tokenSimilar => $scores) {
                        foreach ($scores as $intencaoId => $score) {
                            if (!isset($resultados[$intencaoId])) {
                                $resultados[$intencaoId] = 0;
                            }

                            // Penalizar levemente por ser fuzzy match
                            $resultados[$intencaoId] += ($score * 0.8); // 20% de desconto

                            if (!isset($contagemMatches[$intencaoId])) {
                                $contagemMatches[$intencaoId] = 0;
                            }
                            $contagemMatches[$intencaoId]++;
                        }
                    }
                }
            }

            // Se token não foi encontrado, tentar no contexto
            if (!$encontrado) {
                $contextTokens = IntencaoCache::getContextTokens();
                if (!empty($contextTokens) && isset($contextTokens[$token])) {
                    foreach ($contextTokens[$token] as $intencaoId => $scoreContexto) {
                        if (!isset($resultados[$intencaoId])) {
                            $resultados[$intencaoId] = 0;
                        }

                        if (!isset($maiorEspecificidade[$intencaoId])) {
                            $maiorEspecificidade[$intencaoId] = 0;
                        }

                        // Score contexto com especificidade reduzida
                        $resultados[$intencaoId] += ($scoreContexto * 0.3 * $maiorEspecificidade[$intencaoId]);
                    }
                }
            }
        }

        // Boost para múltiplos matches ESPECÍFICOS (não genéricos)
        foreach ($contagemMatches as $intencaoId => $matches) {
            if ($matches > 1) {
                $boostMultiplo = 1.0 + (($matches - 1) * 0.3); // 1 match=1x, 2=1.3x, 3=1.6x
                if (isset($resultados[$intencaoId])) {
                    $resultados[$intencaoId] *= $boostMultiplo;
                }
            }
        }

        // Mega-boost para intenções que tiveram match com termo MUITO específico
        foreach ($maiorEspecificidade as $intencaoId => $especificidade) {
            if (!isset($resultados[$intencaoId])) {
                continue;
            }

            if ($especificidade >= 1.0) {
                // Encontrou um termo único para essa intenção
                $resultados[$intencaoId] *= 2.0; // Dobra o score
            } elseif ($especificidade >= 0.8) {
                // Encontrou um termo raro para essa intenção
                $resultados[$intencaoId] *= 1.5;
            }
        }

        return $resultados;
    }

    /**
     * Registrar query que não foi respondida com confiança suficiente
     * Útil para análise e melhoria do sistema
     */
    private static function logNaoRespondida(
        string $mensagem,
        ?string $melhorIntencaoId,
        float $confianca
    ): array {
        QueryNaoRespondida::create([
            'query' => $mensagem,
            'melhor_intencao_id' => $melhorIntencaoId,
            'confianca' => $confianca,
            'debug_info' => [
                'timestamp' => now()->toDateTimeString(),
            ],
        ]);

        Log::warning('Query não respondida', [
            'query' => $mensagem,
            'melhor_intencao_id' => $melhorIntencaoId,
            'confianca' => $confianca,
        ]);

        return [
            'resposta' => self::RESPOSTA_PADRAO,
            'confianca' => 0,
            'intencao_id' => null,
        ];
    }

    /**
     * Encontrar tokens similares no índice usando fuzzy matching
     * Usa Levenshtein distance para encontrar aproximações
     * 
     * @param string $token Token procurado
     * @param array $indice Índice disponível
     * @param float $limiarSimilaridade Limiar de 0-1 (padrão 0.75 = 75% similar)
     * @return array Tokens encontrados com seus scores
     */
    private static function encontrarTokensSimilares(string $token, array $indice, float $limiarSimilaridade = 0.75): array
    {
        $similares = [];
        $tamanhoToken = strlen($token);

        // Se o token é muito pequeno, requer 100% de similaridade
        if ($tamanhoToken < 4) {
            $limiarSimilaridade = 0.95;
        }

        foreach (array_keys($indice) as $tokenIndice) {
            // Calcular distância de Levenshtein normalizada (0-1, onde 1 = idêntico)
            $distancia = levenshtein($token, $tokenIndice);
            $tamanhoMax = max($tamanhoToken, strlen($tokenIndice));
            $similaridade = 1.0 - ($distancia / $tamanhoMax);

            if ($similaridade >= $limiarSimilaridade) {
                // Penalizar levemente por não ser exato
                $pesoFuzzy = $similaridade; // 0.75-1.0 range
                $similares[$tokenIndice] = $indice[$tokenIndice];

                // Aplicar penalidade ao score fuzzy
                foreach ($similares[$tokenIndice] as &$score) {
                    $score *= $pesoFuzzy;
                }
                unset($score);
            }
        }

        return $similares;
    }

    /**
     * Obter estatísticas de tokens mais acessados
     * Útil para análise de padrões de busca
     */
    public static function obterTokensMaisAcessados(int $limite = 50): array
    {
        return IntencaoCache::getTokensMaisAcessados($limite);
    }

    /**
     * Obter estatísticas de um token específico
     */
    public static function obterEstatisticasToken(string $token): array
    {
        $tokenNormalizado = TextNormalizer::normalize($token);
        return IntencaoCache::getEstatisticasToken($tokenNormalizado);
    }

    /**
     * Limpar estatísticas de tokens
     */
    public static function limparEstatisticas(): void
    {
        IntencaoCache::limparEstatisticasTokens();
    }
}
