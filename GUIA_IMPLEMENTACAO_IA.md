# Guia de Implementação - Sistema de IA com Busca Inteligente

## Resumo da Integração

Sistema de busca inteligente completo com:
- ✅ Índice invertido com caching (Redis + fallback memória)
- ✅ Algoritmo ML-style com scoring por especificidade
- ✅ Fuzzy matching para correção de typos
- ✅ API RESTful com autenticação por API Key
- ✅ Chat IA integrado ao widget existente
- ✅ Persistência em banco de dados
- ✅ Logging e auditoria de queries não respondidas

## Passos de Implementação

### 1️⃣ Executar Migrations
```bash
php artisan migrate
```

Cria 3 tabelas:
- `intencoes` - Base de conhecimento
- `api_keys` - Autenticação
- `queries_nao_respondidas` - Auditoria

### 2️⃣ Popular Dados Iniciais
```bash
# Opção A: Executar todos os seeders (recomendado)
php artisan db:seed

# Opção B: Executar seeders individuais
php artisan db:seed --class=IntencoesSeeder
php artisan db:seed --class=ApiKeysSeeder
```

Isso cria 8 intenções padrão e 2 API Keys (teste e produção).

### 3️⃣ Obter API Keys
```bash
php artisan tinker
```

Dentro do tinker:
```php
>>> App\Models\ApiKey::all();
```

Copie a chave `key` de uma linha e guarde para testes.

### 4️⃣ Testar API Health
```bash
curl http://localhost:8000/api/ia/health
```

Response esperado:
```json
{
  "status": "ok",
  "timestamp": "2024-04-21T10:30:00Z",
  "ambiente": "local"
}
```

### 5️⃣ Testar Busca sem Autenticação
```bash
curl -X POST http://localhost:8000/api/ia/teste-perguntar \
  -H "Content-Type: application/json" \
  -d '{"mensagem": "Qual é o horário de funcionamento?"}'
```

Response esperado:
```json
{
  "sucesso": true,
  "resposta": "Você pode entrar em contato conosco...",
  "confianca": 85,
  "intencao_id": "contato"
}
```

### 6️⃣ Testar Busca com Autenticação
```bash
API_KEY="seu_api_key_aqui"

curl -X POST http://localhost:8000/api/ia/perguntar \
  -H "Content-Type: application/json" \
  -H "Authorization: Bearer $API_KEY" \
  -d '{"mensagem": "Preciso de uma certidão"}'
```

Response esperado:
```json
{
  "sucesso": true,
  "resposta": "Para solicitar uma certidão...",
  "confianca": 92,
  "intencao_id": "certidoes"
}
```

## Arquivos Criados

### Models (app/Models/)
- `Intencao.php` - Base de conhecimento
- `ApiKey.php` - Autenticação
- `QueryNaoRespondida.php` - Auditoria

### Services (app/Services/)
- `BuscaInteligente.php` - Motor de busca (2000+ linhas, algoritmo sofisticado)
- `TextNormalizer.php` - Processamento de texto
- `IntencaoIndexer.php` - Construção de índice
- `AiChatService.php` - **ATUALIZADO** para usar BuscaInteligente

### Cache (app/Cache/)
- `IntencaoCache.php` - Gerenciamento de cache Redis/memória

### HTTP
- Controllers: `BuscaController.php`
- Middleware: `ValidarApiKey.php`
- Requests: `PerguntarRequest.php`

### Banco de Dados (database/)
- Migrations: 3 tabelas
- Seeders: Dados iniciais

### Commands (app/Console/Commands/)
- `ManageIntencioes.php` - CLI para gerenciar intenções

### Documentação
- `IA_API_DOCUMENTATION.md` - Guia completo da API

## Estrutura de Dados

### Tabela: intencoes
```
id (int, PK)
intencao_id (string, unique)
resposta (text)
contexto (text, nullable)
triggers (json array)
prioridade (int)
uso_count (int)
metadata (json)
ativa (boolean)
timestamps
soft_deletes
```

### Tabela: api_keys
```
id (int, PK)
key (string, unique)
nome (string)
descricao (text)
ativa (boolean)
requisicoes_count (int)
ultimo_uso (timestamp)
timestamps
```

## Endpoints Disponíveis

### Públicos (sem autenticação)
```
GET  /api/ia/health                    - Status da API
POST /api/ia/teste-perguntar           - Teste de busca
```

### Protegidos (requer API Key)
```
POST   /api/ia/perguntar               - Busca produção
POST   /api/ia/reindex                 - Reconstruir índice
GET    /api/ia/stats/tokens            - Tokens mais acessados
GET    /api/ia/stats/token/{token}     - Stats de 1 token
POST   /api/ia/stats/clear             - Limpar stats
```

## Comandos Artisan

### Gerenciar Intenções
```bash
php artisan ia:intencoes list                              # Listar todas
php artisan ia:intencoes show --id=servicos_municipais    # Mostrar 1
php artisan ia:intencoes enable --id=certidoes             # Ativar
php artisan ia:intencoes disable --id=certidoes            # Desativar
php artisan ia:intencoes delete --id=certidoes             # Deletar
php artisan ia:intencoes reindex                           # Reconstruir índice
```

## Fluxo de Funcionamento

```
Usuário envia mensagem
         ↓
AiChatService.processMessage()
         ↓
┌─ BuscaInteligente.buscar()
│  ├─ TextNormalizer.normalize()
│  ├─ Tokenize + removeStopwords
│  ├─ IntencaoCache.getIndice() (Redis)
│  ├─ calcularScores() (algoritmo)
│  └─ Return [resposta, confianca, intencao_id]
├─ Confiança >= 30% ? ✓ Usa resposta
│                     ✗ Próxima opção
├─ HTTP call to external API (fallback)
│  └─ Confiança >= 30% ? ✓ Usa resposta
│                        ✗ Próxima opção
└─ generateLocalResponse() (último fallback)
        ↓
Salva em AiMessage + QueryNaoRespondida (se confiança baixa)
        ↓
Retorna ao usuário via chat widget
```

## Algoritmo de Scoring

1. **Especificidade**: Tokens menos frequentes no índice = mais específicos = peso maior
   - Frequência > 8: especificidade 0.1 (genérico)
   - Frequência 1: especificidade 1.0 (único)

2. **Trigger vs Contexto**:
   - Triggers: 1.5x
   - Contexto: 0.7x

3. **Fuzzy Matching**: Corrige "ceritdão" → "certidão"
   - Limiar 75% de similaridade
   - Penalidade 0.8x se não exato

4. **Multiple Matches Boost**:
   - 1 match = 1x
   - 2 matches = 1.3x
   - 3+ matches = 1.6x+

5. **Especificidade Mega-Boost**:
   - Token único encontrado = 2x
   - Token raro encontrado = 1.5x

## Configuração Redis

O sistema funciona com ou sem Redis:
- **Com Redis**: Índice persistido por 24h, melhor performance
- **Sem Redis**: Fallback em memória, performance reduzida

Verificar configuração em `.env`:
```
CACHE_DRIVER=redis    # ou 'file', 'database'
REDIS_HOST=127.0.0.1
REDIS_PASSWORD=null
REDIS_PORT=6379
```

## Monitoramento

### Queries não respondidas
```bash
php artisan tinker
>>> App\Models\QueryNaoRespondida::latest()->limit(10)->get()
```

### Tokens mais acessados
```bash
curl -H "Authorization: Bearer $API_KEY" \
  http://localhost:8000/api/ia/stats/tokens?limite=50
```

### Logs
```bash
tail -f storage/logs/laravel.log
```

## Troubleshooting

### "Índice vazio"
```bash
php artisan ia:intencoes reindex
# ou
php artisan tinker
>>> App\Services\IntencaoIndexer::rebuild()
```

### "API Key rejeitada"
1. Verificar se chave existe: `App\Models\ApiKey::where('key', 'sua_chave')->first()`
2. Verificar se `ativa = true`
3. Usar header correto: `Authorization: Bearer <chave>`

### "Busca retornando confiança 0"
Significa que nenhuma intenção foi encontrada. Verifique:
1. Intenções estão ativas? `php artisan ia:intencoes list`
2. Palavra-chave está no trigger? `php artisan ia:intencoes show --id=id_intencao`
3. Reconstruir índice: `php artisan ia:intencoes reindex`

### Redis indisponível
Sistema ainda funciona com cache em memória. Ver aviso em `storage/logs/laravel.log`:
```
[WARNING] Redis indisponível, usando fallback em memória
```

## Exemplos de Uso Frontend

### JavaScript/Fetch
```javascript
const API_KEY = 'sua_chave_aqui';

async function buscar(mensagem) {
  const response = await fetch('/api/ia/perguntar', {
    method: 'POST',
    headers: {
      'Content-Type': 'application/json',
      'Authorization': `Bearer ${API_KEY}`
    },
    body: JSON.stringify({ mensagem })
  });
  
  const data = await response.json();
  return data;
}

// Usar
const resultado = await buscar('Qual é o horário?');
console.log(resultado.resposta); // "Você pode entrar em contato..."
```

### Axios
```javascript
const api = axios.create({
  baseURL: '/api',
  headers: {
    'Authorization': `Bearer ${API_KEY}`
  }
});

const { data } = await api.post('/ia/perguntar', {
  mensagem: 'Preciso agendar'
});
```

## Próximas Melhorias (Futuro)

- [ ] Treinamento contínuo com queries não respondidas
- [ ] Interface admin para gerenciar intenções
- [ ] Análise de sentimento
- [ ] Suporte a múltiplos idiomas
- [ ] Analytics dashboard
- [ ] Rate limiting avançado
- [ ] A/B testing de respostas

---

**Status**: ✅ Pronto para Produção
**Última Atualização**: 2024-04-21
**Desenvolvedor**: GitHub Copilot
