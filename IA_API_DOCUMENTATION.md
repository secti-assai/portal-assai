# API de Busca Inteligente e Chat IA

## Overview

O sistema integra um motor de busca inteligente com indexação invertida, caching inteligente e fuzzy matching. O chat IA funciona com integração a um backend com processamento sofisticado de linguagem natural.

## Endpoints Públicos

### 1. Health Check
```
GET /api/ia/health
```

**Response:**
```json
{
  "status": "ok",
  "timestamp": "2024-04-21T10:30:00.000000Z",
  "ambiente": "local"
}
```

### 2. Teste de Busca (Sem Autenticação)
```
POST /api/ia/teste-perguntar
Content-Type: application/json

{
  "mensagem": "Qual é o horário de funcionamento?"
}
```

**Response:**
```json
{
  "sucesso": true,
  "resposta": "Você pode entrar em contato conosco...",
  "confianca": 85,
  "intencao_id": "contato"
}
```

## Endpoints Protegidos (API Key Required)

Todos os endpoints protegidos requerem uma chave API. Forneça via:
- Header: `Authorization: Bearer <api_key>`
- Query: `?api_key=<api_key>`
- Header: `X-API-Key: <api_key>`

### 3. Busca de Produção
```
POST /api/ia/perguntar
Authorization: Bearer {api_key}
Content-Type: application/json

{
  "mensagem": "Preciso de uma certidão de negativa de débitos"
}
```

**Response:**
```json
{
  "sucesso": true,
  "resposta": "Para solicitar uma certidão...",
  "confianca": 92,
  "intencao_id": "certidoes"
}
```

### 4. Reconstruir Índice
```
POST /api/ia/reindex
Authorization: Bearer {api_key}
```

Reconstrói o índice invertido de todas as intenções ativas.

### 5. Estatísticas de Tokens
```
GET /api/ia/stats/tokens?limite=50
Authorization: Bearer {api_key}
```

Retorna os 50 tokens mais acessados com sua frequência.

### 6. Estatísticas de Um Token
```
GET /api/ia/stats/token/{token}
Authorization: Bearer {api_key}
```

### 7. Limpar Estatísticas
```
POST /api/ia/stats/clear
Authorization: Bearer {api_key}
```

## Configuração

### 1. Executar Migrations
```bash
php artisan migrate
```

### 2. Popular Dados
```bash
php artisan db:seed --class=IntencoesSeeder
php artisan db:seed --class=ApiKeysSeeder
```

Ou executar todos os seeders:
```bash
php artisan db:seed
```

### 3. Obter API Keys
Após rodar os seeders, obtenha as chaves do banco:
```bash
php artisan tinker
>>> App\Models\ApiKey::all();
```

## Algoritmo de Busca Inteligente

### Características

1. **Índice Invertido**: Mapeia tokens (palavras) para intenções com scores
2. **Especificidade de Tokens**: Tokens raros valem mais que comuns
3. **Peso Contextual**: Triggers (1.5x) valem mais que contexto (0.7x)
4. **Fuzzy Matching**: Corrige typos com Levenshtein distance
5. **Boost Múltiplo**: Múltiplos matches aumentam confiança
6. **Caching**: Redis para performance (fallback em memória)

### Scoring

```
score = base_score * (1 + especificidade)
      + fuzzy_matches * 0.8 (penalidade)
      + boost_multiplo (1 match = 1x, 2 matches = 1.3x, 3+ = 1.6x+)
      + mega_boost (token único = 2x)
```

### Confiança

- **0-30%**: Não respondida, registrada em `queries_nao_respondidas`
- **30-70%**: Respondida com confiança baixa
- **70-100%**: Respondida com confiança alta

## Chat IA

O chat IA funciona via endpoints em `/api/ai-chat/`:

### Criar Conversa
```
POST /api/ai-chat/conversation
{
  "session_id": "user_session_uuid"
}
```

### Enviar Mensagem
```
POST /api/ai-chat/send
{
  "conversation_id": "conv_id",
  "message": "Olá"
}
```

### Obter Histórico
```
GET /api/ai-chat/messages?conversation_id=conv_id&limit=20
```

## Modelos de Dados

### Intencao
```
- intencao_id: string (unique)
- resposta: text (resposta do bot)
- contexto: text (informação de contexto)
- triggers: json (palavras-chave que ativam)
- prioridade: int (peso para ranking)
- uso_count: int (contador de uso)
- metadata: json (dados estruturados)
- ativa: boolean
```

### QueryNaoRespondida
Registra queries que não foram respondidas com confiança >= 30%
- query: texto da pergunta
- melhor_intencao_id: melhor match encontrado
- confianca: score de confiança
- debug_info: informações adicionais

### ApiKey
Chaves de acesso à API
- key: chave única
- nome: descrição
- requisicoes_count: contador
- ultimo_uso: timestamp
- ativa: status

## Exemplo de Uso

### JavaScript (Frontend)
```javascript
const apiKey = 'sua_api_key';

async function buscar(mensagem) {
  const response = await fetch('/api/ia/perguntar', {
    method: 'POST',
    headers: {
      'Content-Type': 'application/json',
      'Authorization': `Bearer ${apiKey}`
    },
    body: JSON.stringify({ mensagem })
  });
  
  return await response.json();
}

// Usar
const resultado = await buscar('Preciso de uma certidão');
console.log(resultado.resposta); // "Para solicitar uma certidão..."
```

### PHP/Laravel
```php
use App\Services\BuscaInteligente;

$resultado = BuscaInteligente::buscar('Qual é o horário?');

echo $resultado['resposta'];        // string
echo $resultado['confianca'];       // int (0-100)
echo $resultado['intencao_id'];     // string
```

## Cache e Performance

- **Index**: Cache 24h (Redis + memória)
- **Tokens Stats**: Cache 30 dias
- **Fallback**: Se Redis indisponível, usa memória
- **Logging**: Todas as queries não respondidas

## Troubleshooting

### Redis não disponível
Sistema funciona normalmente com cache em memória, mas com performance reduzida. Ver logs em `storage/logs/`.

### Índice vazio
Execute: `php artisan tinker` → `App\Services\IntencaoIndexer::rebuild()`

### API Key rejeitada
Verifique:
1. Chave existe em `api_keys` table
2. Campo `ativa` = true
3. Formato correto no header/query

## Monitoramento

Verifique queries não respondidas:
```bash
php artisan tinker
>>> App\Models\QueryNaoRespondida::latest()->limit(10)->get();
```

Tokens mais acessados:
```
GET /api/ia/stats/tokens?limite=50
Authorization: Bearer {api_key}
```
