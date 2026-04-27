{{-- Chat Lateral IA Profissional --}}
<div id="ai-chat-container" 
     x-cloak
     x-data="aiChatWidget()" 
     @alpine:init="setTimeout(() => init(), 100)"
     @keydown.escape="closeSidebar()">

    {{-- Overlay (apenas em mobile) --}}
    <div x-show="isOpen" 
         x-transition:enter="transition ease-out duration-300"
         x-transition:enter-start="opacity-0"
         x-transition:enter-end="opacity-100"
         x-transition:leave="transition ease-in duration-200"
         x-transition:leave-start="opacity-100"
         x-transition:leave-end="opacity-0"
         @click="closeSidebar()"
         class="fixed inset-0 bg-black/40 backdrop-blur-sm z-[9998] sm:hidden"
         aria-hidden="true"></div>

    {{-- Botão Flutuante (quando fechado) --}}
    <button x-show="!isOpen"
            x-transition:enter="transition ease-out duration-300"
            x-transition:enter-start="scale-0 opacity-0"
            x-transition:enter-end="scale-100 opacity-100"
            x-transition:leave="transition ease-in duration-200"
            x-transition:leave-start="scale-100 opacity-100"
            x-transition:leave-end="scale-0 opacity-0"
            @click="openSidebar()"
            :aria-expanded="isOpen"
            aria-label="Abrir assistente de IA"
            class="fixed bottom-24 right-6 w-16 h-16 rounded-full bg-white shadow-[0_8px_30px_rgb(0,0,0,0.12)] hover:shadow-[0_8px_30px_rgb(0,0,0,0.18)] transition-all duration-300 flex items-center justify-center z-[9999] group overflow-hidden border-2 border-purple-100">
        <div class="absolute inset-0 bg-purple-500 opacity-0 group-hover:opacity-10 transition-opacity"></div>
        <img src="{{ asset('img/mascote.png') }}" alt="Mascote IA" class="w-full h-full object-cover scale-[1.5] relative z-10 transition-transform duration-300 group-hover:scale-[1.65]">
    </button>

    {{-- Sidebar Chat --}}
    <aside x-show="isOpen"
           x-transition:enter="transition ease-out duration-300"
           x-transition:enter-start="sm:translate-x-full opacity-0"
           x-transition:enter-end="translate-x-0 opacity-100"
           x-transition:leave="transition ease-in duration-200"
           x-transition:leave-start="translate-x-0 opacity-100"
           x-transition:leave-end="sm:translate-x-full opacity-0"
           class="fixed right-0 top-0 w-full sm:w-96 h-[100dvh] bg-white shadow-2xl flex flex-col z-[9999] sm:border-l sm:border-gray-200"
           role="dialog"
           aria-modal="true"
           aria-labelledby="ai-chat-title">

        {{-- Header --}}
        <div class="bg-gradient-to-r from-purple-600 to-purple-800 text-white p-4 sm:p-6 flex items-center justify-between shrink-0">
            <div class="flex items-center gap-3 min-w-0">
                <div class="w-10 h-10 bg-white rounded-full flex items-center justify-center shrink-0 overflow-hidden border border-white/30 shadow-sm">
                    <img src="{{ asset('img/mascote.png') }}" alt="Mascote IA" class="w-full h-full object-cover scale-[1.5]">
                </div>
                <div class="min-w-0">
                    <h2 id="ai-chat-title" class="font-bold text-base sm:text-lg truncate">Assistente IA</h2>
                    <p class="text-xs opacity-90" x-text="isLoading ? 'Conectando...' : 'Online'"></p>
                </div>
            </div>
            <button @click="closeSidebar()"
                    aria-label="Fechar assistente"
                    class="text-white/80 hover:text-white transition text-2xl leading-none shrink-0 ml-2">
                ×
            </button>
        </div>

        {{-- Área de Mensagens --}}
        <div class="flex-1 overflow-y-auto bg-gray-50 p-4 space-y-4 scroll-smooth" id="messages-container">
            
            {{-- Mensagem Inicial --}}
            <div x-show="messages.length === 0" class="text-center py-8">
                <div class="mb-4">
                    <i class="fa-solid fa-sparkles text-4xl text-purple-400 opacity-60"></i>
                </div>
                <h3 class="text-gray-700 font-bold text-base mb-2">Bem-vindo ao Assistente Municipal</h3>
                <p class="text-gray-600 text-sm mb-6">Como posso ajudá-lo hoje?</p>
                
                {{-- Sugestões Rápidas --}}
                <div class="space-y-2">
                    <button @click="sendMessage('Quais serviços estão disponíveis?')"
                            class="w-full text-left px-3 py-2.5 rounded-lg bg-white border border-gray-300 hover:border-purple-500 hover:bg-purple-50 text-gray-700 text-xs transition font-medium">
                        📋 Serviços disponíveis
                    </button>
                    <button @click="sendMessage('Como solicitar uma certidão?')"
                            class="w-full text-left px-3 py-2.5 rounded-lg bg-white border border-gray-300 hover:border-purple-500 hover:bg-purple-50 text-gray-700 text-xs transition font-medium">
                        📝 Solicitar documento
                    </button>
                    <button @click="sendMessage('Como fazer uma denúncia?')"
                            class="w-full text-left px-3 py-2.5 rounded-lg bg-white border border-gray-300 hover:border-purple-500 hover:bg-purple-50 text-gray-700 text-xs transition font-medium">
                        🚨 Denúncia
                    </button>
                </div>
            </div>

            {{-- Mensagens --}}
            <template x-for="message in messages" :key="message.id">
                <div :class="message.role === 'user' ? 'flex justify-end' : 'flex justify-start'">
                    <div :class="[
                        'max-w-[80%] px-4 py-2.5 rounded-lg text-sm break-words',
                        message.role === 'user' 
                            ? 'bg-purple-600 text-white rounded-br-none' 
                            : 'bg-white border border-gray-300 text-gray-800 rounded-bl-none'
                    ]">
                        <p x-html="message.content"></p>
                        <p :class="message.role === 'user' ? 'text-purple-100' : 'text-gray-500'" class="text-xs mt-1.5 opacity-70">
                            <span x-text="formatTime(message.created_at)"></span>
                        </p>
                    </div>
                </div>
            </template>

            {{-- Indicador Digitando --}}
            <div x-show="isTyping" class="flex justify-start">
                <div class="bg-white border border-gray-300 px-4 py-2.5 rounded-lg rounded-bl-none">
                    <div class="flex gap-1 items-center">
                        <span class="w-2 h-2 bg-gray-400 rounded-full animate-bounce" style="animation-delay: 0ms;"></span>
                        <span class="w-2 h-2 bg-gray-400 rounded-full animate-bounce" style="animation-delay: 150ms;"></span>
                        <span class="w-2 h-2 bg-gray-400 rounded-full animate-bounce" style="animation-delay: 300ms;"></span>
                    </div>
                </div>
            </div>
        </div>

        {{-- Ações --}}
        <div x-show="messages.length > 0" class="border-t bg-white px-4 py-2 flex items-center justify-between text-xs">
            <button @click="clearConversation()"
                    class="text-gray-600 hover:text-red-600 transition font-medium flex items-center gap-1">
                <i class="fa-solid fa-trash-alt"></i>
                Limpar
            </button>
            <span class="text-gray-400" x-text="`${messages.length} mensagens`"></span>
        </div>

        {{-- Input --}}
        <div class="border-t bg-white p-4 shrink-0">
            <form @submit.prevent="sendMessage()" class="flex gap-2">
                <input x-model="inputValue"
                       :disabled="isLoading || isTyping"
                       type="text"
                       placeholder="Digite sua pergunta..."
                       aria-label="Digite sua pergunta"
                       class="flex-1 px-4 py-2.5 rounded-lg border border-gray-300 focus:outline-none focus:ring-2 focus:ring-purple-500 focus:border-transparent text-sm placeholder-gray-500 transition disabled:bg-gray-100 disabled:cursor-not-allowed">
                
                <button type="submit"
                        :disabled="!inputValue.trim() || isLoading || isTyping"
                        aria-label="Enviar mensagem"
                        class="px-4 py-2.5 rounded-lg bg-purple-600 hover:bg-purple-700 disabled:bg-gray-300 disabled:cursor-not-allowed text-white transition flex items-center justify-center text-sm font-medium shrink-0">
                    <i class="fa-solid fa-paper-plane"></i>
                </button>
            </form>
        </div>
    </aside>
</div>

<script>
/**
 * Widget de Chat IA Profissional
 * Integrado com API backend
 */
function aiChatWidget() {
    return {
        isOpen: false,
        messages: [],
        inputValue: '',
        isLoading: false,
        isTyping: false,
        conversationId: null,
        sessionId: null,
        _initialized: false,

        async init() {
            // Prevenir inicialização múltipla
            if (this._initialized) {
                console.log('[Chat IA] Widget já inicializado, ignorando reinicialização');
                return;
            }
            this._initialized = true;

            try {
                console.log('[Chat IA] Inicializando widget...');
                
                // Gerar ou obter session ID
                this.sessionId = this.getOrCreateSessionId();
                console.log('[Chat IA] Session ID:', this.sessionId);
                
                // Criar ou obter conversa
                await this.initConversation();
                
                // Carregar histórico
                await this.loadMessages();
                
                console.log('[Chat IA] Widget inicializado com sucesso!');
            } catch (error) {
                console.error('[Chat IA] Erro ao inicializar:', error);
                this._initialized = false; // Reset se falhar
            }
        },

        getOrCreateSessionId() {
            let sessionId = localStorage.getItem('ai_session_id');
            if (!sessionId) {
                sessionId = `session_${Date.now()}_${Math.random().toString(36).substr(2, 9)}`;
                localStorage.setItem('ai_session_id', sessionId);
                console.log('[Chat IA] Novo session ID criado:', sessionId);
            }
            return sessionId;
        },

        async initConversation() {
            try {
                this.isLoading = true;
                console.log('[Chat IA] Criando conversa...');
                
                const response = await fetch('/api/ai-chat/conversation', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.content || '',
                    },
                    body: JSON.stringify({
                        session_id: this.sessionId,
                    }),
                });

                if (!response.ok) {
                    throw new Error(`HTTP ${response.status}: ${response.statusText}`);
                }

                const data = await response.json();
                if (data.success) {
                    this.conversationId = data.conversation_id;
                    console.log('[Chat IA] Conversa criada. ID:', this.conversationId);
                } else {
                    throw new Error('Falha na resposta da API: ' + JSON.stringify(data));
                }
            } catch (error) {
                console.error('[Chat IA] Erro ao criar conversa:', error);
                throw error;
            } finally {
                this.isLoading = false;
            }
        },

        async sendMessage(message = null) {
            const text = message || this.inputValue.trim();
            if (!text || !this.conversationId) {
                console.warn('[Chat IA] Validação falhou. Text:', text, 'ConvID:', this.conversationId);
                return;
            }

            console.log('[Chat IA] Enviando mensagem:', text);

            // Limpar input
            this.inputValue = '';

            // Adicionar mensagem do usuário localmente
            this.messages.push({
                id: Date.now(),
                role: 'user',
                content: text,
                created_at: new Date(),
            });

            this.isTyping = true;
            this.scrollToBottom();

            try {
                const response = await fetch('/api/ai-chat/send', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.content || '',
                    },
                    body: JSON.stringify({
                        conversation_id: this.conversationId,
                        message: text,
                    }),
                });

                if (!response.ok) {
                    let errorMessage = `HTTP ${response.status}: ${response.statusText}`;
                    try {
                        const errorData = await response.json();
                        errorMessage = errorData.error || errorData.message || errorMessage;
                    } catch (parseError) {
                        console.warn('[Chat IA] Nao foi possivel ler corpo de erro da API', parseError);
                    }

                    throw new Error(errorMessage);
                }

                const data = await response.json();
                console.log('[Chat IA] Resposta recebida:', data);
                
                if (data.success) {
                    // Adicionar resposta do bot
                    this.messages.push({
                        id: Date.now() + 1,
                        role: 'bot',
                        content: data.data.response,
                        created_at: new Date(data.data.timestamp),
                    });
                    console.log('[Chat IA] Mensagem do bot adicionada');
                } else {
                    throw new Error(data.error || data.message || 'Resposta invalida da API');
                }
            } catch (error) {
                console.error('[Chat IA] Erro ao enviar mensagem:', error);
                this.messages.push({
                    id: Date.now() + 1,
                    role: 'bot',
                    content: `❌ ${error.message || 'Erro ao processar sua mensagem.'}`,
                    created_at: new Date(),
                });
            } finally {
                this.isTyping = false;
                this.scrollToBottom();
            }
        },

        async loadMessages() {
            try {
                const response = await fetch(`/api/ai-chat/messages?conversation_id=${this.conversationId}`, {
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.content || '',
                    },
                });

                const data = await response.json();
                if (data.success) {
                    this.messages = data.messages;
                    this.$nextTick(() => this.scrollToBottom());
                }
            } catch (error) {
                console.error('Erro ao carregar mensagens:', error);
            }
        },

        async clearConversation() {
            if (!confirm('Tem certeza que deseja limpar o histórico?')) return;

            try {
                const response = await fetch('/api/ai-chat/clear', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.content || '',
                    },
                    body: JSON.stringify({
                        conversation_id: this.conversationId,
                    }),
                });

                const data = await response.json();
                if (data.success) {
                    this.messages = [];
                }
            } catch (error) {
                console.error('Erro ao limpar conversa:', error);
            }
        },

        openSidebar() {
            this.isOpen = true;
            this.$nextTick(() => this.scrollToBottom());
        },

        closeSidebar() {
            this.isOpen = false;
        },

        scrollToBottom() {
            this.$nextTick(() => {
                const container = document.getElementById('messages-container');
                if (container) {
                    container.scrollTop = container.scrollHeight;
                }
            });
        },

        formatTime(date) {
            const d = new Date(date);
            return d.toLocaleTimeString('pt-BR', { hour: '2-digit', minute: '2-digit' });
        },
    };
}
</script>
