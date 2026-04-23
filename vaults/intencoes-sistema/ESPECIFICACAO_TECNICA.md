# ESPECIFICAÇÃO TÉCNICA - Sistema de Busca e Grafo de Conhecimento

**Versão:** 2.0
**Data:** 20 de Abril de 2026
**Status:** Pronto para Implementação

---

## 1. ARQUITETURA TÉCNICA

### 1.1 Estrutura de Dados - Nó

```php
class GrafoNo {
    public string $id;              // Identificador único
    public string $tipo;             // ENTIDADE|INTENCAO|ORGAO|FLUXO|TEMPLATE
    public string $nome;             // Nome descritivo
    public string $caminho;          // Caminho do arquivo .md
    public array $triggers = [];     // Palavras-chave para disparo
    public array $tags = [];         // Categorias
    public int $prioridade = 10;     // 1-20, maior = mais importante
    public array $tokens = [];       // Tokens normalizados
    public int $grau = 0;            // Número de conexões
    public array $relacoes_saida = []; // Relações que saem deste nó
    public array $relacoes_entrada = []; // Relações que chegam neste nó
}
```

### 1.2 Estrutura de Dados - Relação

```php
class GrafoRelacao {
    public string $tipo;             // EMITIDO_POR|NECESSITA|PERTENCE_A|etc
    public string $origem_id;        // ID do nó origem
    public string $destino_id;       // ID do nó destino
    public string $destino_nome;     // Nome para display (ex: [[Nome]])
    public float $peso = 1.0;        // Força da relação (1.0 = normal, 0.5 = fraca)
    public bool $bidirecional = false;
}
```

### 1.3 Índice de Busca

```php
class IndiceBusca {
    // Índices por tipo de nó
    private array $indice_por_tipo = [
        'ENTIDADE' => [],
        'INTENCAO' => [],
        'ORGAO' => [],
        'FLUXO' => [],
        'TEMPLATE' => []
    ];
    
    // Índice de tokens (para busca)
    private array $indice_tokens = [
        'token' => [nó_id1, nó_id2, ...]
    ];
    
    // Índice de triggers (para busca exata)
    private array $indice_triggers = [
        'trigger' => [nó_id1, nó_id2, ...]
    ];
}
```

---

## 2. ALGORITMO DE BUSCA

### 2.1 Pré-processamento

```php
function normalizarQuery($query) {
    // 1. Lowercase
    $query = strtolower($query);
    
    // 2. Remover acentos
    $query = removerAcentos($query);
    
    // 3. Remover pontuação
    $query = preg_replace('/[^\w\s]/', '', $query);
    
    // 4. Tokenizar
    $tokens = explode(' ', trim($query));
    
    // 5. Remover stopwords
    $stopwords = ['o', 'a', 'é', 'de', 'para', 'em', 'como'];
    $tokens = array_diff($tokens, $stopwords);
    
    // 6. Aplicar sinônimos
    foreach ($tokens as &$token) {
        $token = mapearSinonimo($token);
    }
    
    return $tokens;
}
```

### 2.2 Busca Inicial

```php
function buscarNos($tokens) {
    $candidatos = [];
    
    // Busca em índice de triggers (exato)
    foreach ($tokens as $token) {
        if (isset($indice_triggers[$token])) {
            foreach ($indice_triggers[$token] as $no_id) {
                $candidatos[$no_id] += 2.0; // Peso maior para trigger exato
            }
        }
    }
    
    // Busca em índice de tokens (parcial)
    foreach ($tokens as $token) {
        if (isset($indice_tokens[$token])) {
            foreach ($indice_tokens[$token] as $no_id) {
                $candidatos[$no_id] += 1.0;
            }
        }
    }
    
    return $candidatos;
}
```

### 2.3 Cálculo de Similaridade

```php
function calcularSimilaridade($query_tokens, $no) {
    // Interseção de tokens
    $tokens_comuns = array_intersect($query_tokens, $no->tokens);
    
    // Jaccard Similarity: |A ∩ B| / |A ∪ B|
    $uniao = array_unique(array_merge($query_tokens, $no->tokens));
    $similaridade_tokens = count($tokens_comuns) / count($uniao);
    
    // Normalização por tamanho do nó
    $tamanho_nó = count($no->tokens);
    if ($tamanho_nó > 0) {
        $similaridade_tokens *= (1 + log($tamanho_nó) / 5); // Nós maiores = mais relevantes
    }
    
    // Fator de grau (conectividade)
    $fator_grau = 1.0 + ($no->grau / 10); // Escalar com grau
    
    // Score final
    $score = $similaridade_tokens * $fator_grau * $no->prioridade / 10;
    
    return $score;
}
```

### 2.4 Expansão por Grafo

```php
function expandirGrafo($candidatos, $profundidade = 2) {
    $visitados = [];
    $fila = [];
    
    foreach ($candidatos as $no_id => $score) {
        $fila[] = [$no_id, 1, $score];
    }
    
    while (!empty($fila)) {
        [$no_id, $nivel, $score_pai] = array_shift($fila);
        
        if (isset($visitados[$no_id])) continue;
        if ($nivel > $profundidade) continue;
        
        $visitados[$no_id] = true;
        
        // Explorar vizinhos
        $no = $grafo->obterNo($no_id);
        
        // Relações de saída
        foreach ($no->relacoes_saida as $relacao) {
            $no_destino = $grafo->obterNo($relacao->destino_id);
            $score_novo = $score_pai * $relacao->peso * 0.7; // Decay por profundidade
            
            if (!isset($candidatos[$relacao->destino_id]) && $score_novo > 0.1) {
                $candidatos[$relacao->destino_id] = $score_novo;
                $fila[] = [$relacao->destino_id, $nivel + 1, $score_novo];
            }
        }
    }
    
    return $candidatos;
}
```

### 2.5 Ranqueamento Final

```php
function ranquear($candidatos) {
    $resultados = [];
    
    foreach ($candidatos as $no_id => $score) {
        $no = $grafo->obterNo($no_id);
        
        // Fatores de ranqueamento
        $fator_tipo = match($no->tipo) {
            'INTENCAO' => 1.0,
            'ENTIDADE' => 0.8,
            'ORGAO' => 0.6,
            'FLUXO' => 0.7,
            'TEMPLATE' => 0.5,
        };
        
        // Bonus de popularidade (hit count)
        $hits = redis()->get("node:{$no_id}:hits") ?? 0;
        $fator_popularidade = 1.0 + (log($hits + 1) / 10);
        
        // Score final
        $score_final = $score * $fator_tipo * $fator_popularidade;
        
        $resultados[] = [
            'no' => $no,
            'score' => $score_final
        ];
    }
    
    // Ordenar por score descendente
    usort($resultados, fn($a, $b) => $b['score'] <=> $a['score']);
    
    // Retornar top 10
    return array_slice($resultados, 0, 10);
}
```

---

## 3. SISTEMA DE CACHE (REDIS)

### 3.1 Estrutura de Dados no Redis

```
# Estatísticas de acesso por nó
node:{nodeId}:hits = 42 (TTL: 30 dias)
node:{nodeId}:last_accessed = "2026-04-20T15:30:00Z"

# Top nós por acessos
top_nodes:daily = ["node_id_1:847", "node_id_2:623", ...]
top_nodes:weekly = [...]
top_nodes:monthly = [...]

# Cache de índice (reconstruído a cada sync)
indice:tokens = {token: [nó_id1, nó_id2, ...]}
indice:triggers = {trigger: [nó_id1, nó_id2, ...]}

# Resultados de busca frequentes (cache de resultados)
search:cache:{query_hash} = [
    {no_id: score, tipo: INTENCAO, ...}
] (TTL: 24 horas)
```

### 3.2 Operações de Cache

```php
class CacheGrafo {
    public function registrarAcesso($no_id) {
        $key = "node:$no_id:hits";
        redis()->incr($key);
        redis()->expire($key, 30 * 24 * 60 * 60); // 30 dias
        
        redis()->set("node:$no_id:last_accessed", date('c'));
        
        $this->atualizarTopNodes();
    }
    
    public function atualizarTopNodes() {
        $keys = redis()->keys('node:*:hits');
        $hits = [];
        
        foreach ($keys as $key) {
            $no_id = str_replace('node:', '', str_replace(':hits', '', $key));
            $count = redis()->get($key);
            $hits[$no_id] = $count;
        }
        
        arsort($hits);
        $top = array_slice($hits, 0, 20);
        
        redis()->set('top_nodes:daily', json_encode($top), 'EX', 24 * 60 * 60);
    }
    
    public function obterTopNodes($limite = 10) {
        return json_decode(redis()->get('top_nodes:daily'), true)
            ?? $this->calcularTopNodes($limite);
    }
}
```

---

## 4. API DE BUSCA

### 4.1 Endpoint Principal

```
GET /api/v1/busca?q={query}&tipo={tipo}&limite={limite}&expandir={bool}

Parâmetros:
- q (string): Query de busca
- tipo (string, opcional): Filtrar por tipo (ENTIDADE|INTENCAO|ORGAO|FLUXO)
- limite (int, default=10): Número máximo de resultados
- expandir (bool, default=true): Expandir busca por grafo

Response:
{
    "sucesso": true,
    "query": "como tirar rg",
    "tempo_ms": 45,
    "total_resultados": 3,
    "resultados": [
        {
            "id": "intencao_solicitar_rg",
            "tipo": "INTENCAO",
            "nome": "Solicitar RG",
            "score": 0.98,
            "descricao": "...",
            "triggers": ["onde tirar rg", "como tirar rg", ...],
            "orgao": "Polícia Civil",
            "relacoes": [
                {
                    "tipo": "PERTENCE_A",
                    "destino": "Polícia Civil",
                    "destino_id": "orgao_policia_civil"
                },
                ...
            ]
        },
        ...
    ]
}
```

### 4.2 Endpoint de Recomendação

```
GET /api/v1/recomenda?node_id={id}&limite={limite}

Response:
{
    "sucesso": true,
    "node_atual": "intencao_solicitar_rg",
    "recomendacoes": [
        {
            "id": "entidade_rg",
            "tipo": "ENTIDADE",
            "nome": "RG",
            "score": 0.95,
            "motivo": "Documento relacionado"
        },
        ...
    ]
}
```

### 4.3 Endpoint de Grafo Completo

```
GET /api/v1/grafo?formato={json|graphml|cytoscape}

Response:
{
    "nós": [...],
    "relações": [...],
    "estatísticas": {
        "total_nós": 32,
        "total_relações": 47,
        "conectividade_media": 2.8,
        "isolados": 0
    }
}
```

---

## 5. INDEXAÇÃO E SINCRONIZAÇÃO

### 5.1 Processo de Indexação

```php
class IndexadorGrafo {
    public function indexar() {
        // 1. Leitura de todos os .md
        $arquivos = glob('vaults/intencoes-sistema/**/*.md', GLOB_RECURSIVE);
        
        // 2. Parse YAML frontmatter
        foreach ($arquivos as $arquivo) {
            $conteudo = file_get_contents($arquivo);
            [$yaml, $markdown] = $this->parseYamlMarkdown($conteudo);
            
            $no = $this->criarNo($yaml, $markdown, $arquivo);
            
            // 3. Tokenização
            $tokens = $this->tokenizar($no->nome, $no->tags, $yaml['triggers'] ?? []);
            $no->tokens = $tokens;
            
            // 4. Parsing de relações
            $relacoes = $this->parseRelacoes($markdown);
            $no->relacoes_saida = $relacoes;
            
            // 5. Armazenar no grafo
            $this->grafo->adicionarNo($no);
        }
        
        // 6. Processar relações bidirecionais
        $this->processarRelacoesBidirecionais();
        
        // 7. Calcular graus
        $this->calcularGraus();
        
        // 8. Reconstruir índices
        $this->reconstruirIndices();
        
        // 9. Persistir em cache
        $this->persistirEmCache();
    }
    
    private function tokenizar($nome, $tags, $triggers) {
        $tokens = [];
        
        // Nome
        $tokens = array_merge($tokens, explode(' ', strtolower($nome)));
        
        // Tags
        foreach ($tags as $tag) {
            $tokens = array_merge($tokens, explode('-', strtolower($tag)));
        }
        
        // Triggers
        foreach ($triggers as $trigger) {
            $tokens = array_merge($tokens, explode(' ', strtolower($trigger)));
        }
        
        // Remover stopwords e acentos
        $tokens = array_map('removerAcentos', $tokens);
        $tokens = array_diff($tokens, $this->stopwords);
        
        return array_unique($tokens);
    }
    
    private function parseRelacoes($markdown) {
        $relacoes = [];
        
        // Regex para [[Nome_da_Relacao|Tipo]]: [[Destino]]
        preg_match_all('/\[\[([^\]]+)\]\]/m', $markdown, $matches);
        
        foreach ($matches[1] as $link) {
            // Exemplo: "Órgãos/Receita Federal"
            $partes = explode('/', $link);
            if (count($partes) === 2) {
                [$categoria, $nome] = $partes;
                $relacoes[] = new GrafoRelacao(
                    tipo: 'RELACIONADO_A', // Padrão, pode ser sobrescrito no YAML
                    destino_nome: $link,
                    destino_id: $this->resolverNoId($nome)
                );
            }
        }
        
        return $relacoes;
    }
}
```

### 5.2 Comando Artisan para Sincronização

```php
// app/Console/Commands/SincronizarGrafo.php

class SincronizarGrafo extends Command {
    protected $signature = 'grafo:sincronizar {--reconstruir-indice}';
    
    public function handle() {
        $this->info('🔄 Sincronizando grafo...');
        
        $indexador = new IndexadorGrafo();
        $indexador->indexar();
        
        if ($this->option('reconstruir-indice')) {
            $this->info('🔨 Reconstruindo índices...');
            $indexador->reconstruirIndices();
        }
        
        $this->info('✅ Sincronização concluída!');
        
        $stats = $indexador->obterEstatisticas();
        $this->info("Total de nós: {$stats['total_nos']}");
        $this->info("Total de relações: {$stats['total_relacoes']}");
    }
}
```

---

## 6. EXEMPLOS DE USO

### 6.1 Busca Simples

```php
$buscador = new BuscadorGrafo();
$resultados = $buscador->buscar('como tirar rg');

foreach ($resultados as $resultado) {
    echo "{$resultado['nome']} ({$resultado['tipo']}): {$resultado['score']}\n";
}

// Output:
// Solicitar RG (INTENCAO): 0.98
// RG (ENTIDADE): 0.85
// Documentos de Identidade (TEMPLATE): 0.65
```

### 6.2 Busca com Filtro

```php
$resultados = $buscador->buscar(
    'cpf',
    tipo: 'INTENCAO'
);

// Retorna apenas intenções relacionadas a CPF
```

### 6.3 Recomendação

```php
$recomendador = new RecomendadorGrafo();
$recomendacoes = $recomendador->obterRecomendacoes('intencao_solicitar_rg');

foreach ($recomendacoes as $rec) {
    echo "{$rec['nome']}: {$rec['motivo']}\n";
}

// Output:
// CPF: Documento pré-requisito
// Polícia Civil: Órgão responsável
// Poupatempo: Alternativa recomendada
```

---

## 7. TESTES

### 7.1 Testes de Busca

```php
class BuscaGrafoTest extends TestCase {
    public function test_busca_exata() {
        $resultado = $this->buscador->buscar('solicitar rg');
        $this->assertEquals('intencao_solicitar_rg', $resultado[0]['id']);
    }
    
    public function test_busca_sinonimos() {
        $resultado1 = $this->buscador->buscar('onde tirar rg');
        $resultado2 = $this->buscador->buscar('como obter rg');
        $this->assertEquals($resultado1[0]['id'], $resultado2[0]['id']);
    }
    
    public function test_expansao_grafo() {
        $resultado = $this->buscador->buscar('documento', expandir: true);
        $this->assertGreaterThan(5, count($resultado));
    }
    
    public function test_ranqueamento() {
        $resultado = $this->buscador->buscar('rg');
        $this->assertGreaterThan($resultado[1]['score'], $resultado[0]['score']);
    }
}
```

---

## 8. PERFORMANCE

### 8.1 Otimizações

- **Índice de tokens:** O(1) para busca de tokens
- **Índice de triggers:** O(1) para busca exata
- **Cache Redis:** Resultados frequentes cacheados por 24h
- **Lazy loading:** Relações carregadas sob demanda

### 8.2 Benchmarks Esperados

| Operação | Tempo | Notas |
|----------|-------|-------|
| Busca simples | <50ms | Com cache Redis |
| Busca com expansão | <100ms | 2 níveis de profundidade |
| Indexação completa | ~500ms | Para 32 nós |
| Recomendação | <30ms | Cache de top nodes |

---

## 9. DIAGRAMA DE ARQUITETURA

```
┌─────────────────────────────────────────────────────────────────┐
│                        Cliente / API                            │
├─────────────────────────────────────────────────────────────────┤
│                                                                 │
│  ┌──────────────────────────────────────────────────────────┐  │
│  │                   Camada de API                          │  │
│  │  GET /api/v1/busca  |  POST /api/v1/recomenda           │  │
│  └──────────────────────────────────────────────────────────┘  │
│                          ↓                                       │
│  ┌──────────────────────────────────────────────────────────┐  │
│  │           Motor de Busca (BuscadorGrafo)                │  │
│  │  - Normalização de query                                │  │
│  │  - Busca inicial em índices                             │  │
│  │  - Cálculo de similaridade                              │  │
│  │  - Expansão por grafo                                   │  │
│  │  - Ranqueamento                                         │  │
│  └──────────────────────────────────────────────────────────┘  │
│        ↓ Consulta Índices        ↓ Carrega Nós                │
│  ┌────────────────────────┐  ┌────────────────────────────┐  │
│  │   Índices (Em Memória) │  │   Grafo (Em Banco de Dados)│  │
│  │ - Tokens               │  │ - Nós                      │  │
│  │ - Triggers             │  │ - Relações                 │  │
│  │ - Tipo                 │  │ - Metadados                │  │
│  └────────────────────────┘  └────────────────────────────┘  │
│        ↑                              ↑                         │
│  ┌─────────────────────────────────────────────────────────┐   │
│  │              Cache (Redis)                              │   │
│  │ - Hits por nó (TTL: 30 dias)                           │   │
│  │ - Top nodes (TTL: 24 horas)                            │   │
│  │ - Resultados de busca (TTL: 24 horas)                 │   │
│  └─────────────────────────────────────────────────────────┘   │
│        ↑ Sincronização (Comando Artisan)                       │
│  ┌─────────────────────────────────────────────────────────┐   │
│  │      Vault Obsidian (Arquivos .md)                     │   │
│  │ vaults/intencoes-sistema/                              │   │
│  │  ├─ Intenções/                                         │   │
│  │  ├─ Entidades/                                         │   │
│  │  ├─ Órgãos/                                            │   │
│  │  └─ Fluxos/                                            │   │
│  └─────────────────────────────────────────────────────────┘   │
│                                                                 │
└─────────────────────────────────────────────────────────────────┘
```

---

## 10. CHECKLIST DE IMPLEMENTAÇÃO

- [ ] Estrutura de classes Nó, Relação, Índice
- [ ] Algoritmo de normalização e tokenização
- [ ] Sistema de índices (tokens, triggers, tipo)
- [ ] Motor de busca com similaridade
- [ ] Expansão por grafo (BFS)
- [ ] Ranqueamento com múltiplos fatores
- [ ] Integração com Redis para cache
- [ ] API RESTful para busca
- [ ] Comando artisan para sincronização
- [ ] Testes unitários
- [ ] Documentação de API
- [ ] Dashboard de analytics
- [ ] Visualizador de grafo

