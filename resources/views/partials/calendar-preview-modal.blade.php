{{-- Modal de Prévia de Eventos do Calendário --}}
<div x-data="calendarPreview()" 
     @open-calendar-preview.window="show($event.detail)"
     x-show="isOpen" 
     class="fixed inset-0 z-[2147483647] flex items-center justify-center p-4 sm:p-6"
     x-cloak>
    
    {{-- Overlay --}}
    <div x-show="isOpen" 
         x-transition:enter="ease-out duration-300"
         x-transition:enter-start="opacity-0"
         x-transition:enter-end="opacity-100"
         x-transition:leave="ease-in duration-200"
         x-transition:leave-start="opacity-100"
         x-transition:leave-end="opacity-0"
         @click="close()"
         class="absolute inset-0 bg-slate-900/60 backdrop-blur-sm"></div>

    {{-- Conteúdo do Modal --}}
    <div x-show="isOpen"
         x-transition:enter="ease-out duration-300"
         x-transition:enter-start="opacity-0 scale-95 translate-y-4"
         x-transition:enter-end="opacity-100 scale-100 translate-y-0"
         x-transition:leave="ease-in duration-200"
         x-transition:leave-start="opacity-100 scale-100 translate-y-0"
         x-transition:leave-end="opacity-0 scale-95 translate-y-4"
         class="relative bg-white w-full max-w-sm rounded-2xl shadow-2xl overflow-hidden font-sans">
        
        {{-- Header --}}
        <div class="bg-gradient-to-r from-blue-600 to-blue-700 px-5 py-4 flex items-center justify-between">
            <div>
                <h3 class="text-white font-bold text-lg" x-text="formatDate(currentDate)"></h3>
                <p class="text-blue-100 text-xs uppercase tracking-wider font-semibold" x-text="eventos.length > 0 ? 'Eventos do dia' : 'Agenda'"></p>
            </div>
            <button @click="close()" class="text-white/80 hover:text-white transition-colors">
                <i class="fa-solid fa-xmark text-xl"></i>
            </button>
        </div>

        {{-- Corpo --}}
        <div class="p-5 max-h-[60vh] overflow-y-auto custom-scrollbar">
            <template x-if="eventos.length > 0">
                <div class="flex flex-col gap-4">
                    <template x-for="evento in eventos" :key="evento.id">
                        <div class="group border-b border-slate-100 last:border-0 pb-4 last:pb-0">
                            <h4 class="font-bold text-slate-800 text-base mb-1 group-hover:text-blue-600 transition-colors" x-text="evento.titulo"></h4>
                            
                            <div class="flex flex-col gap-1.5 mb-3">
                                <div class="flex items-center gap-2 text-slate-500 text-sm">
                                    <i class="fa-solid fa-clock w-4 text-blue-500/70"></i>
                                    <span x-text="evento.hora"></span>
                                </div>
                                <div class="flex items-center gap-2 text-slate-500 text-sm">
                                    <i class="fa-solid fa-location-dot w-4 text-blue-500/70"></i>
                                    <span x-text="evento.local || 'Assaí, PR'"></span>
                                </div>
                            </div>

                            <p class="text-slate-600 text-sm mb-4 line-clamp-2" x-text="evento.resumo"></p>

                            <a :href="evento.url" class="inline-flex items-center justify-center w-full bg-blue-50 text-blue-700 font-bold py-2.5 rounded-xl hover:bg-blue-600 hover:text-white transition-all text-sm gap-2">
                                Saiba mais <i class="fa-solid fa-arrow-right text-xs"></i>
                            </a>
                        </div>
                    </template>
                </div>
            </template>

            <template x-if="eventos.length === 0">
                <div class="py-8 flex flex-col items-center text-center">
                    <div class="w-16 h-16 bg-slate-50 rounded-full flex items-center justify-center mb-4">
                        <i class="fa-regular fa-calendar-xmark text-slate-300 text-3xl"></i>
                    </div>
                    <p class="text-slate-500 font-medium">Não há eventos programados para este dia.</p>
                </div>
            </template>
        </div>
    </div>
</div>

<script>
    function calendarPreview() {
        return {
            isOpen: false,
            currentDate: '',
            eventos: [],
            
            show(detail) {
                this.currentDate = detail.dia;
                this.eventos = detail.eventos || [];
                this.isOpen = true;
                document.body.style.overflow = 'hidden';
            },
            
            close() {
                this.isOpen = false;
                document.body.style.overflow = '';
            },
            
            formatDate(dateStr) {
                if (!dateStr) return '';
                const parts = dateStr.split('-');
                const date = new Date(parts[0], parts[1] - 1, parts[2]);
                return date.toLocaleDateString('pt-BR', { day: 'numeric', month: 'long' });
            }
        }
    }

    window.abrirPreviewEvento = function(el) {
        const dia = el.dataset.dia;
        const eventos = el.dataset.eventos ? JSON.parse(el.dataset.eventos) : [];
        
        window.dispatchEvent(new CustomEvent('open-calendar-preview', {
            detail: { dia, eventos }
        }));
    }
</script>

<style>
    .custom-scrollbar::-webkit-scrollbar {
        width: 4px;
    }
    .custom-scrollbar::-webkit-scrollbar-track {
        background: transparent;
    }
    .custom-scrollbar::-webkit-scrollbar-thumb {
        background: #e2e8f0;
        border-radius: 10px;
    }
    .custom-scrollbar::-webkit-scrollbar-thumb:hover {
        background: #cbd5e1;
    }
</style>
