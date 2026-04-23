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

    public function getServicos(string $perfil = 'todos', int $perPage = 15): array
    {
        $cacheKey = "conecta_servicos_perfil_{$perfil}_limit_{$perPage}";

        return Cache::remember($cacheKey, now()->addMinutes(30), function () use ($perfil, $perPage) {
            try {
                $apiKey = config('services.conecta.key');

                $request = Http::timeout(5)->retry(2, 100);

                if (!empty($apiKey)) {
                    $request = $request->withHeaders(['X-API-Key' => $apiKey]);
                }

                $response = $request->get("{$this->baseUrl}/api/v1/integracao/portal/servicos", [
                    'perfil'   => $perfil,
                    'per_page' => $perPage,
                ]);

                if (!$response->successful()) {
                    Log::warning('Conecta API retornou erro.', [
                        'status' => $response->status(),
                        'body'   => $response->body(),
                    ]);
                    return ['data' => []];
                }

                return $response->json();
            } catch (\Exception $e) {
                Log::error('Erro de I/O na API Conecta: ' . $e->getMessage());
                return ['data' => []];
            }
        });
    }
}