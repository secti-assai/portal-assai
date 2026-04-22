<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Http\Requests\PerguntarRequest;
use App\Services\BuscaInteligente;
use App\Services\IntencaoIndexer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class BuscaController extends Controller
{
    /**
     * GET /ia/health
     * Verificar status da API
     */
    public function health(): array
    {
        return [
            'status' => 'ok',
            'timestamp' => now()->toDateTimeString(),
            'ambiente' => config('app.env'),
        ];
    }

    /**
     * POST /ia/teste-perguntar
     * Endpoint de teste sem autenticação (para testes)
     * @param PerguntarRequest $request
     */
    public function testePerguntar(PerguntarRequest $request): array
    {
        Log::info('Teste perguntar chamado', [
            'mensagem' => $request->input('mensagem'),
            'ip' => $request->ip(),
        ]);

        $mensagem = $request->validated('mensagem') ?? '';
        $resultado = BuscaInteligente::buscar($mensagem);

        return [
            'sucesso' => true,
            'resposta' => $resultado['resposta'],
            'confianca' => $resultado['confianca'],
            'intencao_id' => $resultado['intencao_id'],
        ];
    }

    /**
     * POST /ia/perguntar
     * Endpoint de produção com autenticação por API Key
     * Espera header: Authorization: Bearer <api_key>
     * @param PerguntarRequest $request
     */
    public function perguntar(PerguntarRequest $request): array
    {
        $apiKey = $request->attributes->get('api_key');

        Log::info('Perguntar chamado', [
            'mensagem' => $request->input('mensagem'),
            'ip' => $request->ip(),
            'api_key_id' => $apiKey->id ?? null,
        ]);

        $mensagem = $request->validated('mensagem') ?? '';
        $resultado = BuscaInteligente::buscar($mensagem);

        return [
            'sucesso' => true,
            'resposta' => $resultado['resposta'],
            'confianca' => $resultado['confianca'],
            'intencao_id' => $resultado['intencao_id'],
        ];
    }

    /**
     * POST /ia/reindex
     * Reconstruir índice de intenções (operação administrativa)
     */
    public function reindex(Request $request): array
    {
        $apiKey = $request->attributes->get('api_key');

        Log::info('Reindex chamado', [
            'ip' => $request->ip(),
            'api_key_id' => $apiKey->id ?? null,
        ]);

        IntencaoIndexer::rebuild();

        return [
            'sucesso' => true,
            'mensagem' => 'Índice reconstruído com sucesso',
        ];
    }

    /**
     * GET /ia/stats/tokens
     * Obter estatísticas dos tokens mais acessados
     */
    public function statsTokens(Request $request): array
    {
        $limite = (int) $request->input('limite', 50);
        $tokens = BuscaInteligente::obterTokensMaisAcessados($limite);

        return [
            'sucesso' => true,
            'total' => count($tokens),
            'tokens' => $tokens,
        ];
    }

    /**
     * GET /ia/stats/token/{token}
     * Obter estatísticas de um token específico
     */
    public function statsToken(Request $request, string $token): array
    {
        $stats = BuscaInteligente::obterEstatisticasToken($token);

        return [
            'sucesso' => true,
            'stats' => $stats,
        ];
    }

    /**
     * POST /ia/stats/clear
     * Limpar estatísticas de tokens (operação administrativa)
     */
    public function statsClear(Request $request): array
    {
        BuscaInteligente::limparEstatisticas();

        return [
            'sucesso' => true,
            'mensagem' => 'Estatísticas limpas com sucesso',
        ];
    }
}
