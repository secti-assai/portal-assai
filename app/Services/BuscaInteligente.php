<?php

declare(strict_types=1);

namespace App\Services;

use App\Cache\IntencaoCache;
use App\Models\Intencao;
use App\Models\QueryNaoRespondida;
use Illuminate\Support\Facades\Log;

class BuscaInteligente
{
    private const CONFIANCA_MINIMA = 30;
    private const LIMIAR_FUZZY = 0.75;

    private const RESPOSTA_PADRAO = 'Desculpe, não compreendi sua pergunta. Poderia reformular? Estou aqui para ajudar com informações sobre serviços municipais, documentos e procedimentos.';

    /**
     * Verifica se a mensagem possui correspondência no índice local.
     * Chamado estaticamente pelo AiChatService.
     */
    public static function temCorrespondenciaNoVault(string $mensagem): bool
    {
        $resultado = self::buscar($mensagem);
        return ($resultado['confianca'] ?? 0) >= self::CONFIANCA_MINIMA;
    }

    public static function buscar(string $mensagem): array
    {
        if (empty(trim($mensagem))) {
            return self::respostaPadrao();
        }

        // ===== VERIFICAÇÃO DIRETA DE SAUDAÇÕES (ANTES DA TOKENIZAÇÃO) =====
        $saudacao = self::verificarSaudacaoDireta($mensagem);
        if ($saudacao !== null) {
            return $saudacao;
        }

        $mensagemNormalizada = TextNormalizer::normalize($mensagem);
        $tokens = TextNormalizer::removeStopwords(
            TextNormalizer::tokenize($mensagemNormalizada)
        );

        if (empty($tokens)) {
            return self::respostaPadrao();
        }

        $indice = IntencaoCache::getIndice();

        if (!is_array($indice) || empty($indice)) {
            IntencaoIndexer::build();
            $indice = IntencaoCache::getIndice();

            if (!is_array($indice) || empty($indice)) {
                return self::logNaoRespondida($mensagem, null, 0);
            }
        }

        $tokensValidos = array_filter($tokens, fn($t) => isset($indice[$t]));

        if (empty($tokensValidos)) {
            return self::logNaoRespondida($mensagem, null, 0);
        }

        $proporcaoValida = count($tokensValidos) / count($tokens);
        $dados = self::calcularScores($tokens, $indice, $proporcaoValida);

        if (empty($dados['scores'])) {
            return self::logNaoRespondida($mensagem, null, 0);
        }

        arsort($dados['scores']);

        $melhorIntencaoId = key($dados['scores']);
        $confianca = (int) min(100, $dados['scores'][$melhorIntencaoId]);
        $matches = $dados['matches'][$melhorIntencaoId] ?? 0;

        if ($matches === 0 || $confianca < self::CONFIANCA_MINIMA) {
            return self::logNaoRespondida($mensagem, $melhorIntencaoId, $confianca);
        }

        $intencao = Intencao::where('intencao_id', $melhorIntencaoId)->first();

        if (!$intencao) {
            return self::logNaoRespondida($mensagem, $melhorIntencaoId, $confianca);
        }

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
     * Verifica se a mensagem é uma saudação simples (antes de tokenizar).
     * Retorna a resposta da intenção 'saudacao' com confiança 100, ou null.
     */
    private static function verificarSaudacaoDireta(string $mensagem): ?array
    {
        $mensagem = trim(mb_strtolower($mensagem));
        $saudacoes = [
            'bom dia',
            'boa tarde',
            'boa noite',
            'oi',
            'olá',
            'ola',
            'e aí',
            'e ai',
            'opa',
            'como vai',
        ];

        foreach ($saudacoes as $saudacao) {
            if ($mensagem === $saudacao || str_starts_with($mensagem, $saudacao)) {
                $intencao = Intencao::where('intencao_id', 'saudacao')->first();
                if ($intencao) {
                    $intencao->incrementarUso();
                    Log::info('Saudação detectada diretamente', ['mensagem' => $mensagem]);
                    return [
                        'resposta' => $intencao->resposta,
                        'confianca' => 100,
                        'intencao_id' => 'saudacao',
                    ];
                }
                break;
            }
        }

        return null;
    }

    private static function calcularScores(array $tokens, array $indice, float $proporcaoValida): array
    {
        $resultados = [];
        $matches = [];

        foreach ($tokens as $token) {
            if (isset($indice[$token])) {
                foreach ($indice[$token] as $intencaoId => $score) {
                    $resultados[$intencaoId] = ($resultados[$intencaoId] ?? 0) + ($score * 1.5);
                    $matches[$intencaoId] = ($matches[$intencaoId] ?? 0) + 1;
                }
                continue;
            }

            foreach (self::encontrarTokensSimilares($token, $indice) as $scores) {
                foreach ($scores as $intencaoId => $score) {
                    $resultados[$intencaoId] = ($resultados[$intencaoId] ?? 0) + ($score * 0.7);
                    $matches[$intencaoId] = ($matches[$intencaoId] ?? 0) + 1;
                }
            }

            $contexto = IntencaoCache::getContextTokens();
            if (isset($contexto[$token])) {
                foreach ($contexto[$token] as $intencaoId => $score) {
                    $resultados[$intencaoId] = ($resultados[$intencaoId] ?? 0) + ($score * 0.3);
                }
            }
        }

        foreach ($matches as $intencaoId => $m) {
            if ($m > 1 && isset($resultados[$intencaoId])) {
                $resultados[$intencaoId] *= (1 + ($m * 0.2));
            }
        }

        foreach ($resultados as &$score) {
            $score *= $proporcaoValida;
        }

        return [
            'scores' => $resultados,
            'matches' => $matches
        ];
    }

    private static function encontrarTokensSimilares(string $token, array $indice): array
    {
        $similares = [];
        $tamanhoToken = strlen($token);
        $limiar = $tamanhoToken < 4 ? 0.95 : self::LIMIAR_FUZZY;

        foreach ($indice as $tokenIndice => $scores) {
            if (!is_string($tokenIndice)) {
                continue;
            }

            $tamanhoIndice = strlen($tokenIndice);
            $tamanhoMax = max($tamanhoToken, $tamanhoIndice);
            if ($tamanhoMax === 0) continue;

            $distancia = levenshtein($token, $tokenIndice);
            $similaridade = 1.0 - ($distancia / $tamanhoMax);

            if ($similaridade >= $limiar) {
                $similares[$tokenIndice] = $scores;
                foreach ($similares[$tokenIndice] as &$score) {
                    $score *= $similaridade;
                }
                unset($score);
            }
        }

        return $similares;
    }

    private static function logNaoRespondida(string $mensagem, ?string $intencaoId, float $confianca): array
    {
        QueryNaoRespondida::create([
            'query' => $mensagem,
            'melhor_intencao_id' => $intencaoId,
            'confianca' => $confianca,
            'debug_info' => ['timestamp' => now()->toDateTimeString()],
        ]);

        Log::warning('Query não respondida', [
            'query' => $mensagem,
            'melhor_intencao_id' => $intencaoId,
            'confianca' => $confianca,
        ]);

        return self::respostaPadrao();
    }

    private static function respostaPadrao(): array
    {
        return [
            'resposta' => self::RESPOSTA_PADRAO,
            'confianca' => 0,
            'intencao_id' => null,
        ];
    }
}