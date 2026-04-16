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
                $response = Http::timeout(5)
                    ->retry(2, 100)
                    ->get("{$this->baseUrl}/api/v1/integracao/portal/servicos", [
                        'perfil'   => $perfil,
                        'per_page' => $perPage
                    ]);

                return $response->successful() ? $response->json() : ['data' => []];
            } catch (\Exception $e) {
                Log::error('Erro de I/O na API Conecta: ' . $e->getMessage());
                return ['data' => []];
            }
        });
    }
}