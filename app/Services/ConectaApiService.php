<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;

class ConectaApiService
{
    private string $baseUrl;

    public function __construct()
    {
        $this->baseUrl = config('services.conecta.url');
    }

    /**
     * Retorna TODOS os serviços do Conecta (percorre todas as páginas).
     * Cada item é normalizado com um campo 'source' = 'conecta'.
     */
    public function getTodosServicos(string $perfil = 'todos'): array
    {
        $cacheKey = "conecta_todos_servicos_{$perfil}";

        return Cache::remember($cacheKey, now()->addMinutes(10), function () use ($perfil) {
            try {
                $apiKey = config('services.conecta.key');

                $request = Http::timeout(5)->retry(2, 100);

                if (!empty($apiKey)) {
                    $request = $request->withHeaders(['X-API-Key' => $apiKey]);
                }

                if (app()->environment('local')) {
                    $request = $request->withoutVerifying();
                }

                $todos = [];
                $page  = 1;

                do {
                    $response = $request->get("{$this->baseUrl}/api/v1/integracao/portal/servicos", [
                        'perfil'   => $perfil,
                        'per_page' => 50,
                        'page'     => $page,
                    ]);

                    if (!$response->successful()) {
                        Log::warning('Conecta API retornou erro.', [
                            'status' => $response->status(),
                            'body'   => $response->body(),
                        ]);
                        break;
                    }

                    $payload     = $response->json();
                    $todos       = array_merge($todos, $payload['data'] ?? []);
                    $lastPage    = $payload['last_page']    ?? 1;
                    $currentPage = $payload['current_page'] ?? 1;
                    $page++;

                } while ($currentPage < $lastPage);

                return $todos;

            } catch (\Exception $e) {
                Log::error('Erro de I/O na API Conecta: ' . $e->getMessage());
                return [];
            }
        });
    }
}