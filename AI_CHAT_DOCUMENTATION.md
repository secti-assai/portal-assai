# Sistema de Chat IA Profissional - Documentação

## 📋 Overview

Sistema profissional de chat com inteligência artificial integrado ao portal municipal. O assistente IA responde perguntas sobre serviços, documentos e procedimentos municipais.

## 🏗️ Arquitetura

### Backend
- **Models**: `AiConversation`, `AiMessage`
- **Service**: `AiChatService` (lógica de respostas inteligentes)
- **Controller**: `AiChatController` (API endpoints)
- **Database**: Tabelas `ai_conversations` e `ai_messages`

### Frontend
- **Componente**: `ai-chat-widget.blade.php`
- **Framework**: Alpine.js + Tailwind CSS
- **Armazenamento**: localStorage para session_id

## 🚀 Instalação

### 1. Executar Migration

```bash
php artisan migrate
```

Isso criará as tabelas:
- `ai_conversations` - Armazena conversas
- `ai_messages` - Armazena mensagens (usuário e bot)

### 2. Verificar Rotas

As seguintes rotas API foram criadas:

```
POST   /api/ai-chat/conversation    - Criar/obter conversa
POST   /api/ai-chat/send            - Enviar mensagem
GET    /api/ai-chat/messages        - Listar histórico
POST   /api/ai-chat/clear           - Limpar conversa
```

## 💻 Como Usar

### Abrir o Chat

O widget aparece como um botão flutuante roxo no canto inferior direito com o ícone ✨.

### Interação

1. **Clicar no botão** → Abre a sidebar do chat
2. **Digitar pergunta** → Enviar ao servidor
3. **Receber resposta** → IA responde automaticamente
4. **Histórico** → Todos os diálogos são salvos no banco

### Sugestões Rápidas

Ao abrir, há 3 botões de sugestões rápidas:
- 📋 Serviços disponíveis
- 📝 Solicitar documento  
- 🚨 Denúncia

## 🤖 Base de Conhecimento

O assistente responde sobre:

| Padrão | Resposta |
|--------|----------|
| serviço/serviços | Lista de serviços municipais |
| certidão | Como solicitar documentos |
| denúncia | Canal de ouvidoria |
| agendamento | Como agendar atendimento |
| horário | Horários de funcionamento |
| transparência | Portal de transparência |

## 📊 Estrutura de Dados

### ai_conversations
```sql
- id (PK)
- session_id (unique) - Identifica sessão do usuário
- user_ip - IP da requisição
- context (json) - Contexto adicional
- timestamps
- soft_deletes
```

### ai_messages
```sql
- id (PK)
- ai_conversation_id (FK)
- role (enum: 'user', 'bot')
- content (text) - Conteúdo da mensagem
- metadata (json) - Dados adicionais
- timestamps
```

## 🔌 Endpoints API

### 1. Criar/Obter Conversa
```http
POST /api/ai-chat/conversation
Content-Type: application/json

{
  "session_id": "session_xxx"
}

Response:
{
  "success": true,
  "conversation_id": 1,
  "session_id": "session_xxx"
}
```

### 2. Enviar Mensagem
```http
POST /api/ai-chat/send
Content-Type: application/json

{
  "conversation_id": 1,
  "message": "Quais serviços disponíveis?"
}

Response:
{
  "success": true,
  "data": {
    "response": "Oferecemos diversos serviços...",
    "timestamp": "2026-04-21T10:30:00Z"
  },
  "message_count": 4
}
```

### 3. Listar Mensagens
```http
GET /api/ai-chat/messages?conversation_id=1&limit=50

Response:
{
  "success": true,
  "messages": [
    {
      "id": 1,
      "role": "user",
      "content": "Olá",
      "created_at": "2026-04-21T10:30:00Z"
    },
    {
      "id": 2,
      "role": "bot",
      "content": "Oi! Como posso ajudar?",
      "created_at": "2026-04-21T10:30:05Z"
    }
  ]
}
```

### 4. Limpar Conversa
```http
POST /api/ai-chat/clear
Content-Type: application/json

{
  "conversation_id": 1
}

Response:
{
  "success": true,
  "message": "Conversa limpa com sucesso"
}
```

## 🎨 Personalização

### Alterar Cores
Editar `ai-chat-widget.blade.php`:
- `from-purple-600 to-purple-800` → Cores do gradient

### Adicionar Conhecimento
Editar `AiChatService::generateResponse()`:
```php
'padrão|palavra-chave' => 'Resposta do bot'
```

### Mudar Sugestões Rápidas
Editar `ai-chat-widget.blade.php` seção "Sugestões Rápidas"

## 🔒 Segurança

- ✅ CSRF Protection (X-CSRF-TOKEN)
- ✅ Validação de entrada (max 1000 caracteres)
- ✅ IP logging para rastreabilidade
- ✅ Soft deletes para auditoria
- ✅ Sem dados sensíveis armazenados

## 📈 Monitoramento

### Ver Conversas
```bash
php artisan tinker
>>> AiConversation::with('messages')->latest()->first()
```

### Limpar Conversas Antigas
```bash
php artisan tinker
>>> AiConversation::where('created_at', '<', now()->subDays(30))->forceDelete()
```

## 🔄 Próximas Melhorias

- [ ] Integração com OpenAI/Claude API
- [ ] Análise de sentimento
- [ ] Histórico persistente entre sessões
- [ ] Suporte a upload de documentos
- [ ] Dashboard de analytics
- [ ] Feedback dos usuários

## 📞 Suporte

Para dúvidas ou bugs, entre em contato com a equipe de desenvolvimento.
