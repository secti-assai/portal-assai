<?php

declare(strict_types=1);

namespace App\Http\Middleware;

use App\Models\ApiKey;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpFoundation\Response;

class ValidarApiKey
{
    /**
     * Middleware para validar API Key
     * Procura a key em: header Authorization: Bearer <key> ou parâmetro api_key
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Extrair API Key
        $apiKey = $this->extrairApiKey($request);

        if (!$apiKey) {
            Log::warning('Requisição sem API Key', [
                'ip' => $request->ip(),
                'rota' => $request->path(),
            ]);

            return response()->json([
                'erro' => 'API Key não fornecida',
                'mensagem' => 'Use header Authorization: Bearer <sua-chave> ou ?api_key=<sua-chave>',
            ], 401);
        }

        // Validar API Key
        $chave = ApiKey::where('key', $apiKey)
            ->where('ativa', true)
            ->first();

        if (!$chave) {
            Log::warning('API Key inválida', [
                'ip' => $request->ip(),
                'rota' => $request->path(),
            ]);

            return response()->json([
                'erro' => 'API Key inválida ou inativa',
            ], 401);
        }

        // Incrementar contador de requisições (assíncrono para não afetar performance)
        dispatch_sync(fn() => $chave->incrementarRequisicoes());

        // Armazenar no request para uso posterior
        $request->attributes->set('api_key', $chave);

        return $next($request);
    }

    /**
     * Extrair API Key do request
     */
    private function extrairApiKey(Request $request): ?string
    {
        // Tentar header Authorization
        $authHeader = $request->header('Authorization');
        if ($authHeader && str_starts_with($authHeader, 'Bearer ')) {
            return substr($authHeader, 7);
        }

        // Tentar query parameter
        if ($request->has('api_key')) {
            return $request->input('api_key');
        }

        // Tentar header personalizado
        return $request->header('X-API-Key');
    }
}
