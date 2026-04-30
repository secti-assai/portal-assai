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
            class="fixed bottom-24 right-6 w-16 h-16 rounded-full bg-blue-900 shadow-[0_8px_30px_rgba(30,58,138,0.3)] hover:shadow-[0_12px_40px_rgba(30,58,138,0.4)] transition-all duration-300 flex items-center justify-center z-[9999] group overflow-hidden border-2 border-white/20">
        <div class="absolute inset-0 bg-gradient-to-tr from-blue-900 to-indigo-800 opacity-100 group-hover:scale-110 transition-transform duration-500"></div>
        <img src="{{ asset('img/mascote.png') }}" alt="Mascote IA" class="w-full h-full object-cover scale-[2.2] object-center relative z-10 transition-transform duration-300 group-hover:scale-[2.4] group-hover:-rotate-3">
        <div class="absolute -top-1 -right-1 w-5 h-5 bg-yellow-400 border-2 border-blue-900 rounded-full z-20 animate-pulse"></div>
    </button>

    {{-- Sidebar Chat --}}
    <aside x-show="isOpen"
           x-transition:enter="transition ease-out duration-300"
           x-transition:enter-start="sm:translate-x-full opacity-0"
           x-transition:enter-end="translate-x-0 opacity-100"
           x-transition:leave="transition ease-in duration-200"
           x-transition:leave-start="translate-x-0 opacity-100"
           x-transition:leave-end="sm:translate-x-full opacity-0"
           class="fixed right-0 top-0 w-full sm:w-96 h-[100dvh] bg-white shadow-2xl flex flex-col z-[9999] sm:border-l sm:border-slate-200"
           role="dialog"
           aria-modal="true"
           aria-labelledby="ai-chat-title">

        {{-- Header --}}
        <div class="bg-gradient-to-r from-blue-900 via-blue-800 to-indigo-900 text-white p-4 sm:p-6 flex items-center justify-between shrink-0 relative overflow-hidden">
            <div class="absolute top-0 right-0 p-4 opacity-10 pointer-events-none">
                <i class="fa-solid fa-robot text-6xl -rotate-12"></i>
            </div>
            <div class="flex items-center gap-3 min-w-0 relative z-10">
                <div class="w-12 h-12 bg-white rounded-full flex items-center justify-center shrink-0 overflow-hidden border border-white/30 shadow-inner">
                    <img src="{{ asset('img/mascote.png') }}" alt="Mascote IA" class="w-full h-full object-cover scale-[2.2] object-center">
                </div>
                <div class="min-w-0">
                    <h2 id="ai-chat-title" class="font-black text-base sm:text-lg tracking-tight leading-tight">Assistente <span class="text-yellow-400">Assaiense</span></h2>
                    <div class="flex items-center gap-1.5">
                        <span class="w-2 h-2 bg-emerald-400 rounded-full animate-pulse"></span>
                        <p class="text-[10px] uppercase font-bold tracking-widest opacity-80" x-text="isLoading ? 'Conectando...' : 'Online'"></p>
                    </div>
                </div>
            </div>
            <button @click="closeSidebar()"
                    aria-label="Fechar assistente"
                    class="w-8 h-8 rounded-full bg-white/10 hover:bg-white/20 transition-all flex items-center justify-center text-white text-xl leading-none shrink-0 ml-2 border border-white/10">
                <i class="fa-solid fa-xmark text-sm"></i>
            </button>
        </div>

        {{-- Área de Mensagens --}}
        <div class="flex-1 overflow-y-auto bg-slate-50 p-4 space-y-4 scroll-smooth scrollbar-hide" id="messages-container">
            
            {{-- Mensagem Inicial --}}
            <div x-show="messages.length === 0" class="text-center py-10 px-4">
                <div class="mb-6 relative inline-block">
                    <div class="w-24 h-24 bg-gradient-to-tr from-blue-100 to-white rounded-full flex items-center justify-center mx-auto shadow-[inset_0_2px_10px_rgba(30,58,138,0.1)] border border-blue-200/50 overflow-hidden relative">
                        <img src="{{ asset('img/mascote.png') }}" alt="Mascote" class="w-full h-full object-cover animate-float">
                        <div class="absolute inset-0 bg-gradient-to-t from-blue-900/10 to-transparent"></div>
                    </div>
                </div>
                <h3 class="text-slate-800 font-black text-xl mb-2 leading-tight" style="font-family: 'Montserrat', sans-serif;">Olá! Sou o seu <br> <span class="text-blue-700">Assistente Virtual</span></h3>
                <p class="text-slate-500 text-[15px] mb-8 leading-relaxed max-w-[240px] mx-auto">Tire dúvidas sobre IPTU, saúde, serviços e muito mais em poucos segundos.</p>
                
                {{-- Sugestões Rápidas --}}
                <div class="grid grid-cols-1 gap-2.5 max-w-[280px] mx-auto">
                    <button @click="sendMessage('Quais os serviços disponíveis online?')"
                            class="w-full text-left px-4 py-3.5 rounded-2xl bg-white border border-slate-200 hover:border-blue-600 hover:shadow-md hover:-translate-y-0.5 text-slate-700 text-[13px] transition-all font-bold flex items-center gap-3 group">
                        <div class="w-9 h-9 rounded-xl bg-blue-50 text-blue-600 flex items-center justify-center text-sm group-hover:bg-blue-600 group-hover:text-white transition-colors shrink-0 shadow-sm">
                            <i class="fa-solid fa-list-check"></i>
                        </div>
                        Serviços Online
                    </button>
                    <button @click="sendMessage('Como emitir a guia do IPTU?')"
                            class="w-full text-left px-4 py-3.5 rounded-2xl bg-white border border-slate-200 hover:border-blue-600 hover:shadow-md hover:-translate-y-0.5 text-slate-700 text-[13px] transition-all font-bold flex items-center gap-3 group">
                        <div class="w-9 h-9 rounded-xl bg-emerald-50 text-emerald-600 flex items-center justify-center text-sm group-hover:bg-emerald-600 group-hover:text-white transition-colors shrink-0 shadow-sm">
                            <i class="fa-solid fa-file-invoice-dollar"></i>
                        </div>
                        Guia do IPTU
                    </button>
                    <button @click="sendMessage('Onde agendar consulta médica?')"
                            class="w-full text-left px-4 py-3.5 rounded-2xl bg-white border border-slate-200 hover:border-blue-600 hover:shadow-md hover:-translate-y-0.5 text-slate-700 text-[13px] transition-all font-bold flex items-center gap-3 group">
                        <div class="w-9 h-9 rounded-xl bg-rose-50 text-rose-600 flex items-center justify-center text-sm group-hover:bg-rose-600 group-hover:text-white transition-colors shrink-0 shadow-sm">
                            <i class="fa-solid fa-calendar-plus"></i>
                        </div>
                        Agendar Consulta
                    </button>
                </div>
            </div>

            {{-- Mensagens --}}
            <template x-for="message in messages" :key="message.id">
                <div :class="message.role === 'user' ? 'flex justify-end' : 'flex justify-start'">
                    <div :class="[
                        'max-w-[88%] px-4 py-3.5 rounded-2xl text-[14px] leading-relaxed break-words shadow-sm',
                        message.role === 'user' 
                            ? 'bg-blue-900 text-white rounded-tr-none' 
                            : 'bg-white border border-slate-200 text-slate-700 rounded-tl-none'
                    ]">
                        <div x-html="message.content" class="prose prose-sm prose-slate max-w-none"></div>
                        <div :class="message.role === 'user' ? 'text-blue-200' : 'text-slate-400'" class="text-[10px] mt-2 flex items-center gap-1 font-bold">
                            <i class="fa-regular fa-clock text-[9px] opacity-70"></i>
                            <span x-text="formatTime(message.created_at)"></span>
                        </div>
                    </div>
                </div>
            </template>

            {{-- Indicador Digitando --}}
            <div x-show="isTyping" class="flex justify-start">
                <div class="bg-white border border-slate-200 px-5 py-4 rounded-2xl rounded-tl-none shadow-sm">
                    <div class="flex gap-1.5 items-center">
                        <span class="w-2 h-2 bg-blue-600 rounded-full animate-bounce" style="animation-delay: 0ms;"></span>
                        <span class="w-2 h-2 bg-blue-600 rounded-full animate-bounce" style="animation-delay: 150ms;"></span>
                        <span class="w-2 h-2 bg-blue-600 rounded-full animate-bounce" style="animation-delay: 300ms;"></span>
                    </div>
                </div>
            </div>
        </div>

        {{-- Ações --}}
        <div x-show="messages.length > 0" class="border-t border-slate-100 bg-white px-5 py-2.5 flex items-center justify-between text-[11px] font-bold tracking-tight">
            <button @click="clearConversation()"
                    class="text-slate-400 hover:text-red-500 transition-colors flex items-center gap-1.5">
                <i class="fa-solid fa-trash-can text-[10px]"></i>
                LIMPAR CHAT
            </button>
            <span class="text-slate-400 uppercase opacity-60" x-text="`${messages.length} mensagens`"></span>
        </div>

        {{-- Input --}}
        <div class="border-t border-slate-100 bg-white p-4 shrink-0 shadow-[0_-4px_15px_rgba(0,0,0,0.02)]">
            <form @submit.prevent="sendMessage()" class="flex gap-2.5">
                <div class="relative flex-1">
                    <input x-model="inputValue"
                           :disabled="isLoading || isTyping"
                           type="text"
                           placeholder="Qual sua dúvida?"
                           aria-label="Qual sua dúvida?"
                           class="w-full pl-4 pr-10 py-3.5 rounded-xl border border-slate-200 focus:outline-none focus:ring-4 focus:ring-blue-500/10 focus:border-blue-500 text-[14px] placeholder-slate-400 transition-all disabled:bg-slate-50 disabled:cursor-not-allowed font-medium">
                    <div class="absolute right-3 inset-y-0 flex items-center text-slate-300">
                        <i class="fa-solid fa-keyboard text-xs"></i>
                    </div>
                </div>
                
                <button type="submit"
                        :disabled="!inputValue.trim() || isLoading || isTyping"
                        aria-label="Enviar mensagem"
                        class="w-12 h-12 rounded-xl bg-blue-900 hover:bg-blue-800 disabled:bg-slate-200 disabled:cursor-not-allowed text-white transition-all flex items-center justify-center text-sm font-bold shrink-0 shadow-lg shadow-blue-900/10 active:scale-90">
                    <i class="fa-solid fa-paper-plane-top"></i>
                    <svg x-show="isLoading || isTyping" class="animate-spin h-5 w-5 text-white absolute" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                    </svg>
                </button>
            </form>
            <p class="text-[9px] text-center text-slate-400 mt-3 font-bold uppercase tracking-widest opacity-50">Inteligência Artificial Municipal</p>
        </div>
    </aside>
</div>

<style>
    @keyframes float {
        0%, 100% { transform: translateY(0) scale(2.2); }
        50% { transform: translateY(-8px) scale(2.25); }
    }
    .animate-float {
        animation: float 3s ease-in-out infinite;
    }
    .scrollbar-hide::-webkit-scrollbar {
        display: none;
    }
    .scrollbar-hide {
        -ms-overflow-style: none;
        scrollbar-width: none;
    }
</style>

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
