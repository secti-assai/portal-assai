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
                $page = 1;

                do {
                    $response = $request->get("{$this->baseUrl}/api/v1/integracao/portal/servicos", [
                        'perfil' => $perfil,
                        'per_page' => 50,
                        'page' => $page,
                    ]);

                    if (!$response->successful()) {
                        Log::warning('Conecta API retornou erro.', [
                            'status' => $response->status(),
                            'body' => $response->body(),
                        ]);
                        break;
                    }

                    $payload = $response->json();
                    $todos = array_merge($todos, $payload['data'] ?? []);
                    $lastPage = $payload['last_page'] ?? 1;
                    $currentPage = $payload['current_page'] ?? 1;
                    $page++;

                } while ($currentPage < $lastPage);

                // Fetch categories once to use in mapping
                $categoriasMap = \App\Models\Categoria::where('ativo', true)->pluck('id', 'nome')->toArray();

                // Processa cada serviço para remover emojis e mapear um FontAwesome
                $todos = array_map(function ($servico) use ($categoriasMap) {
                    $tituloStr = $servico['titulo'] ?? '';

                    // 1. Remove emojis 
                    $regexEmoji = '/[\x{1F600}-\x{1F64F}\x{1F300}-\x{1F5FF}\x{1F680}-\x{1F6FF}\x{1F1E0}-\x{1F1FF}\x{2600}-\x{26FF}\x{2700}-\x{27BF}\x{1F900}-\x{1F9FF}\x{1FA70}-\x{1FAFF}\x{2300}-\x{23FF}\x{2B50}]/u';
                    $tituloLimpo = trim(preg_replace($regexEmoji, '', $tituloStr));
                    $tituloLimpo = preg_replace('/\s+/', ' ', $tituloLimpo);

                    $servico['titulo'] = $tituloLimpo;

                    // 2. NORMALIZAÇÃO CRÍTICA: Tira acentos e converte para minúsculas
                    // Ex: "Iluminação" vira "iluminacao", "Diário" vira "diario"
                    $tituloNormalizado = \Illuminate\Support\Str::lower(\Illuminate\Support\Str::ascii($tituloLimpo));

                    $icon = 'fa-solid fa-laptop-code'; // Default Fallback

                    $map = [
                        // ==========================================
                        // 1. PROGRAMAS ESPECÍFICOS E FEDERAIS
                        // ==========================================
                        'vale do sol' => 'fa-sun',
                        'bolsa familia' => 'fa-hand-holding-dollar',
                        'cadastro unico' => 'fa-users-rectangle',
                        'cadunico' => 'fa-users-rectangle',
                        'auxilio gas' => 'fa-fire-flame-simple',
                        'identidade jovem' => 'fa-id-card',
                        'seguro-desemprego' => 'fa-briefcase',
                        'aposentadoria' => 'fa-person-cane',
                        'inss' => 'fa-person-cane',
                        'fgts' => 'fa-piggy-bank',
                        'pis/pasep' => 'fa-piggy-bank',
                        'abono' => 'fa-money-bill-wave',
                        'desenrola' => 'fa-handshake-angle',
                        'valores a receber' => 'fa-hand-holding-dollar',
                        'beneficio' => 'fa-hand-holding-dollar',

                        // ==========================================
                        // 2. DOCUMENTOS E AUTENTICAÇÃO DIGITAL
                        // ==========================================
                        'antecedentes' => 'fa-fingerprint',
                        'passaporte' => 'fa-passport',
                        'habilitacao' => 'fa-id-card',
                        'cnh' => 'fa-id-card',
                        'cpf' => 'fa-id-card-clip',
                        'pessoa fisica' => 'fa-id-card',
                        'assinatura' => 'fa-file-signature',
                        'assinar' => 'fa-signature',
                        'procuracao' => 'fa-stamp',
                        'gov.assai' => 'fa-id-badge',
                        'gov.br' => 'fa-id-card',
                        'residencia' => 'fa-house-user',

                        // ==========================================
                        // 3. ÓRGÃOS E SISTEMAS ESPECÍFICOS
                        // ==========================================
                        'receita federal' => 'fa-building-columns',
                        'e-sic' => 'fa-circle-info',
                        'sic' => 'fa-circle-info',
                        'cadin' => 'fa-triangle-exclamation',
                        'darf' => 'fa-file-invoice-dollar',
                        'das' => 'fa-file-invoice-dollar',
                        'mei' => 'fa-store',
                        'microempreendedor' => 'fa-store',
                        'procon' => 'fa-scale-unbalanced',
                        'sus' => 'fa-notes-medical',

                        // ==========================================
                        // 4. TRIBUTOS, FINANÇAS E FISCAL
                        // ==========================================
                        'diario oficial' => 'fa-book-bookmark',
                        'livro eletronico' => 'fa-book-open-reader',
                        'nota fiscal' => 'fa-receipt',
                        'nfs-e' => 'fa-receipt',
                        'malha fiscal' => 'fa-magnifying-glass-dollar',
                        'divida ativa' => 'fa-hand-holding-dollar',
                        'divida' => 'fa-hand-holding-dollar',
                        'restituicao' => 'fa-money-bill-transfer',
                        'tributo' => 'fa-coins',
                        'imposto' => 'fa-money-bills',
                        'guias' => 'fa-file-invoice',
                        'guia' => 'fa-file-invoice',
                        'taxa' => 'fa-file-invoice',
                        'iptu' => 'fa-house-user',
                        'itbi' => 'fa-house-flag',
                        'iss' => 'fa-file-invoice-dollar',
                        'alvara' => 'fa-file-signature',
                        'certidao' => 'fa-certificate',
                        'certificado' => 'fa-certificate',
                        'comprovante' => 'fa-file-contract',

                        // ==========================================
                        // 5. VEÍCULOS E TRÂNSITO
                        // ==========================================
                        'placa veicular' => 'fa-car-side',
                        'placa' => 'fa-car-side',
                        'crv' => 'fa-file-lines',
                        'renavam' => 'fa-car',
                        'infracoes' => 'fa-triangle-exclamation',
                        'veiculo' => 'fa-car',
                        'transito' => 'fa-traffic-light',
                        'passe livre' => 'fa-bus',

                        // ==========================================
                        // 6. OBRAS, URBANISMO, MEIO AMBIENTE E AGRO
                        // ==========================================
                        'plano diretor' => 'fa-city',
                        'saneamento' => 'fa-droplet',
                        'iluminacao' => 'fa-lightbulb',
                        'meio ambiente' => 'fa-leaf',
                        'obras' => 'fa-person-digging',
                        'agua' => 'fa-faucet-drip',
                        'lixo' => 'fa-trash-can',
                        'pesca' => 'fa-fish',
                        'pescador' => 'fa-fish',

                        // ==========================================
                        // 7. SAÚDE E VIGILÂNCIA
                        // ==========================================
                        'assistencia medica' => 'fa-notes-medical',
                        'dengue' => 'fa-mosquito',
                        'vacina' => 'fa-syringe',
                        'saude' => 'fa-heart-pulse',
                        'farmacia' => 'fa-pills',
                        'medico' => 'fa-user-doctor',

                        // ==========================================
                        // 8. EDUCAÇÃO
                        // ==========================================
                        'rede municipal' => 'fa-school',
                        'historico escolar' => 'fa-file-lines',
                        'matricula' => 'fa-id-card-clip',
                        'educacao' => 'fa-graduation-cap',
                        'escola' => 'fa-school',
                        'aluno' => 'fa-user-graduate',
                        'enem' => 'fa-pen-to-square',
                        'encceja' => 'fa-pen-to-square',

                        // ==========================================
                        // 9. RH, CONCURSOS E EMPREGO
                        // ==========================================
                        'processo seletivo' => 'fa-file-pen',
                        'concurso' => 'fa-file-pen',
                        'holerite' => 'fa-file-invoice',
                        'contracheque' => 'fa-file-invoice',
                        'emprego' => 'fa-briefcase',

                        // ==========================================
                        // 10. INSTITUCIONAL E GERAL
                        // ==========================================
                        'transparencia' => 'fa-magnifying-glass-chart',
                        'licitacao' => 'fa-gavel',
                        'compras' => 'fa-cart-shopping',
                        'portaria' => 'fa-clipboard-list',
                        'decreto' => 'fa-scroll',
                        'leis' => 'fa-scale-balanced',
                        'ouvidoria' => 'fa-bullhorn',
                        'processo' => 'fa-folder-open',
                        'protocolo' => 'fa-folder-open',
                        'lgpd' => 'fa-shield-halved',
                        'defesa civil' => 'fa-person-military-pointing',
                        'alistamento' => 'fa-person-military-pointing',
                        'militar' => 'fa-person-military-pointing',
                        'satisfacao' => 'fa-face-smile',
                        'pesquisa' => 'fa-square-poll-vertical',
                        'social' => 'fa-hands-holding-child',
                        'cras' => 'fa-people-roof',
                        'idoso' => 'fa-person-cane',
                        'forum' => 'fa-users',
                        'empresa' => 'fa-building'
                    ];

                    foreach ($map as $keyword => $faIcon) {
                        if (str_contains($tituloNormalizado, $keyword)) {
                            $icon = 'fa-solid ' . $faIcon;
                            break;
                        }
                    }

                    $servico['icone'] = $icon;

                    // 3. MAPEAMENTO DE CATEGORIA
                    // Identifica a categoria baseada em palavras-chave no título normalizado
                    $categoriaName = 'Gestão'; // Categoria padrão (fallback)
                    
                    $mapCategoria = [
                        'Gestão' => ['iptu', 'nota fiscal', 'nfs-e', 'alvara', 'certidao', 'imposto', 'taxa', 'iss', 'itbi', 'diario oficial', 'guia', 'guias', 'malha fiscal', 'divida', 'restituicao', 'comprovante', 'processo', 'protocolo', 'rh', 'servidor', 'holerite', 'contracheque', 'empresa', 'mei', 'microempreendedor', 'receita federal'],
                        'Transparência' => ['transparencia', 'licitacao', 'compras', 'portaria', 'decreto', 'leis', 'ouvidoria', 'e-sic', 'sic'],
                        'Saúde' => ['saude', 'vacina', 'medicamento', 'farmacia', 'medico', 'assistencia medica', 'sus', 'dengue'],
                        'Educação' => ['educacao', 'escola', 'aluno', 'rede municipal', 'historico escolar', 'matricula', 'enem', 'encceja'],
                        'Obras' => ['obras', 'saneamento', 'iluminacao', 'plano diretor', 'agua'],
                        'Emprego' => ['emprego', 'concurso', 'processo seletivo', 'seguro-desemprego', 'fgts', 'pis/pasep', 'abono'],
                        'Meio Ambiente' => ['meio ambiente', 'lixo', 'pesca', 'pescador'],
                        'Assistência Social' => ['social', 'cras', 'idoso', 'bolsa familia', 'cadastro unico', 'cadunico', 'auxilio gas', 'identidade jovem', 'aposentadoria', 'inss'],
                        'Segurança' => ['seguranca', 'defesa civil', 'alistamento', 'militar', 'transito', 'multa', 'infracoes', 'veiculo', 'renavam', 'crv', 'placa veicular'],
                    ];

                    foreach ($mapCategoria as $catName => $keywords) {
                        foreach ($keywords as $kw) {
                            if (str_contains($tituloNormalizado, $kw)) {
                                $categoriaName = $catName;
                                break 2; // Sai dos dois foreach
                            }
                        }
                    }

                    $servico['categoria'] = $categoriaName;
                    $servico['categoria_id'] = $categoriasMap[$categoriaName] ?? null;

                    return $servico;
                }, $todos);

                return $todos;

            } catch (\Exception $e) {
                Log::error('Erro de I/O na API Conecta: ' . $e->getMessage());
                return [];
            }
        });
    }
}