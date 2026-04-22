<div x-data="languageSelector()" class="relative font-sans text-left" @click.away="open = false" x-cloak>
    {{-- Botão Disparador (Trigger) --}}
    <button @click="open = !open" type="button" class="flex items-center justify-between w-full bg-white border border-slate-300 text-slate-800 text-xs font-bold rounded-lg focus:ring-2 focus:ring-yellow-400 focus:border-yellow-400 px-3 py-1.5 shadow-sm transition-colors hover:bg-slate-50 min-w-[150px]">
        <div class="flex items-center gap-2">
            <i class="fa-solid fa-language text-blue-700 text-sm" aria-hidden="true"></i>
            <span x-text="selectedLanguageName"></span>
        </div>
        <i class="fa-solid fa-chevron-down text-slate-400 text-[10px] ml-2 transition-transform duration-200" :class="open ? 'rotate-180' : ''" aria-hidden="true"></i>
    </button>

    {{-- Painel Dropdown com Busca --}}
    <div x-show="open"
         x-transition:enter="transition ease-out duration-150"
         x-transition:enter-start="transform opacity-0 scale-95"
         x-transition:enter-end="transform opacity-100 scale-100"
         x-transition:leave="transition ease-in duration-100"
         x-transition:leave-start="transform opacity-100 scale-100"
         x-transition:leave-end="transform opacity-0 scale-95"
         class="absolute right-0 mt-2 w-64 bg-white border border-slate-200 rounded-xl shadow-[0_10px_40px_-10px_rgba(0,0,0,0.15)] z-[200] overflow-hidden"
         style="display: none;">

        {{-- Campo de Busca --}}
        <div class="p-2.5 border-b border-slate-100 bg-slate-50/80">
            <div class="relative">
                <i class="fa-solid fa-magnifying-glass absolute left-3 top-1/2 transform -translate-y-1/2 text-slate-400 text-xs" aria-hidden="true"></i>
                <input x-model="search" x-ref="searchInput" type="text" placeholder="Buscar idioma..."
                       class="w-full pl-8 pr-3 py-1.5 text-xs border border-slate-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 bg-white placeholder-slate-400 shadow-inner">
            </div>
        </div>

        {{-- Lista de Resultados --}}
        <ul class="max-h-64 overflow-y-auto overscroll-contain py-1 [&::-webkit-scrollbar]:w-1.5 [&::-webkit-scrollbar-track]:bg-slate-50 [&::-webkit-scrollbar-thumb]:bg-slate-300 [&::-webkit-scrollbar-thumb]:rounded-full">
            
            {{-- Opção Padrão (Reset) --}}
            <li @click="selectLanguage('', '🇧🇷 Português (Original)')" class="px-4 py-2.5 text-[13px] font-extrabold text-blue-700 hover:bg-blue-50 cursor-pointer border-b border-slate-100 flex items-center justify-between transition-colors">
                <span>🇧🇷 Português (Original)</span>
                <i x-show="selectedLanguageCode === ''" class="fa-solid fa-check text-blue-600 text-xs"></i>
            </li>

            {{-- Renderização Dinâmica dos Idiomas --}}
            <template x-for="lang in filteredLanguages" :key="lang.code">
                <li @click="selectLanguage(lang.code, lang.name)"
                    class="px-4 py-2 text-[13px] text-slate-700 hover:bg-slate-100 hover:text-slate-900 cursor-pointer transition-colors flex items-center justify-between font-medium">
                    <span x-text="lang.name"></span>
                    <i x-show="selectedLanguageCode === lang.code" class="fa-solid fa-check text-blue-600 text-xs"></i>
                </li>
            </template>

            {{-- Estado Vazio (Sem Resultados) --}}
            <li x-show="filteredLanguages.length === 0" class="px-4 py-4 text-xs text-slate-500 text-center font-medium">
                Nenhum idioma encontrado para "<span x-text="search" class="font-bold text-slate-700"></span>".
            </li>
        </ul>
    </div>
</div>

{{-- Lógica de Estado Alpine.js --}}
@once
<script>
    document.addEventListener('alpine:init', () => {
        Alpine.data('languageSelector', () => ({
            open: false,
            search: '',
            selectedLanguageCode: '',
            selectedLanguageName: '🇧🇷 Idioma',
            
            // Dicionário Oficial Google Translate (ISO 639-1)
            languages: [
                { code: 'af', name: 'Africâner' }, { code: 'sq', name: 'Albanês' }, { code: 'de', name: 'Alemão' },
                { code: 'am', name: 'Amárico' }, { code: 'ar', name: 'Árabe' }, { code: 'hy', name: 'Armênio' },
                { code: 'az', name: 'Azerbaijano' }, { code: 'eu', name: 'Basco' }, { code: 'bn', name: 'Bengali' },
                { code: 'be', name: 'Bielorrusso' }, { code: 'my', name: 'Birmanês' }, { code: 'bs', name: 'Bósnio' },
                { code: 'bg', name: 'Búlgaro' }, { code: 'ca', name: 'Catalão' }, { code: 'kk', name: 'Cazaque' },
                { code: 'ceb', name: 'Cebuano' }, { code: 'ny', name: 'Chicheua' }, { code: 'zh-CN', name: 'Chinês (Simplificado)' },
                { code: 'zh-TW', name: 'Chinês (Tradicional)' }, { code: 'si', name: 'Cingalês' }, { code: 'ko', name: 'Coreano' },
                { code: 'co', name: 'Corso' }, { code: 'ht', name: 'Crioulo Haitiano' }, { code: 'hr', name: 'Croata' },
                { code: 'ku', name: 'Curdo (Kurmanji)' }, { code: 'da', name: 'Dinamarquês' }, { code: 'sk', name: 'Eslovaco' },
                { code: 'sl', name: 'Esloveno' }, { code: 'es', name: '🇪🇸 Espanhol' }, { code: 'eo', name: 'Esperanto' },
                { code: 'et', name: 'Estoniano' }, { code: 'fi', name: 'Finlandês' }, { code: 'fr', name: '🇫🇷 Francês' },
                { code: 'fy', name: 'Frísio Ocidental' }, { code: 'gd', name: 'Gaélico Escocês' }, { code: 'gl', name: 'Galego' },
                { code: 'cy', name: 'Galês' }, { code: 'ka', name: 'Georgiano' }, { code: 'el', name: 'Grego' },
                { code: 'gu', name: 'Guzerate' }, { code: 'ha', name: 'Hauçá' }, { code: 'haw', name: 'Havaiano' },
                { code: 'he', name: 'Hebraico' }, { code: 'hi', name: 'Hindi' }, { code: 'hmn', name: 'Hmong' },
                { code: 'nl', name: 'Holandês' }, { code: 'hu', name: 'Húngaro' }, { code: 'ig', name: 'Igbo' },
                { code: 'id', name: 'Indonésio' }, { code: 'en', name: '🇺🇸 Inglês' }, { code: 'yo', name: 'Iorubá' },
                { code: 'ga', name: 'Irlandês' }, { code: 'is', name: 'Islandês' }, { code: 'it', name: 'Italiano' },
                { code: 'ja', name: '🇯🇵 Japonês' }, { code: 'jw', name: 'Javanês' }, { code: 'kn', name: 'Canarês' },
                { code: 'km', name: 'Khmer' }, { code: 'rw', name: 'Kinyarwanda' }, { code: 'ky', name: 'Quirguiz' },
                { code: 'lo', name: 'Laosiano' }, { code: 'la', name: 'Latim' }, { code: 'lv', name: 'Letão' },
                { code: 'lt', name: 'Lituano' }, { code: 'lb', name: 'Luxemburguês' }, { code: 'mk', name: 'Macedônio' },
                { code: 'ml', name: 'Malaiala' }, { code: 'ms', name: 'Malaio' }, { code: 'mg', name: 'Malgaxe' },
                { code: 'mt', name: 'Maltês' }, { code: 'mi', name: 'Maori' }, { code: 'mr', name: 'Marathi' },
                { code: 'mn', name: 'Mongol' }, { code: 'ne', name: 'Nepalês' }, { code: 'no', name: 'Norueguês' },
                { code: 'or', name: 'Odia' }, { code: 'ps', name: 'Pashto' }, { code: 'fa', name: 'Persa' },
                { code: 'pl', name: 'Polonês' }, { code: 'pt', name: 'Português (Portugal)' }, { code: 'pa', name: 'Punjabi' },
                { code: 'ro', name: 'Romeno' }, { code: 'ru', name: 'Russo' }, { code: 'sm', name: 'Samoano' },
                { code: 'sr', name: 'Sérvio' }, { code: 'st', name: 'Sesotho' }, { code: 'sn', name: 'Shona' },
                { code: 'sd', name: 'Sindi' }, { code: 'so', name: 'Somali' }, { code: 'su', name: 'Sundanês' },
                { code: 'sw', name: 'Suaíli' }, { code: 'sv', name: 'Sueco' }, { code: 'tg', name: 'Tadjique' },
                { code: 'tl', name: 'Tagalo' }, { code: 'th', name: 'Tailandês' }, { code: 'ta', name: 'Tâmil' },
                { code: 'tt', name: 'Tártaro' }, { code: 'cs', name: 'Tcheco' }, { code: 'te', name: 'Telugu' },
                { code: 'tr', name: 'Turco' }, { code: 'tk', name: 'Turcomeno' }, { code: 'uk', name: 'Ucraniano' },
                { code: 'ug', name: 'Uigur' }, { code: 'ur', name: 'Urdu' }, { code: 'uz', name: 'Uzbeque' },
                { code: 'vi', name: 'Vietnamita' }, { code: 'xh', name: 'Xhosa' }, { code: 'yi', name: 'Yiddish' },
                { code: 'zu', name: 'Zulu' }
            ].sort((a, b) => a.name.localeCompare(b.name)),

            init() {
                // Ao abrir o dropdown, foca no input de busca
                this.$watch('open', value => {
                    if (value) {
                        setTimeout(() => this.$refs.searchInput.focus(), 100);
                    }
                });
            },

            get filteredLanguages() {
                if (this.search === '') {
                    return this.languages;
                }
                const query = this.search.toLowerCase().normalize("NFD").replace(/[\u0300-\u036f]/g, "");
                return this.languages.filter(lang => 
                    lang.name.toLowerCase().normalize("NFD").replace(/[\u0300-\u036f]/g, "").includes(query)
                );
            },

            selectLanguage(code, name) {
                this.selectedLanguageCode = code;
                
                // Formatação curta para caber no botão
                if(code === '') {
                    this.selectedLanguageName = '🇧🇷 Idioma';
                } else {
                    // Extrai o primeiro emoji (se houver) e limita a string
                    const parts = name.split(' ');
                    this.selectedLanguageName = parts.length > 1 && parts[0].length <= 4 
                        ? parts[0] + ' ' + parts[1].substring(0, 10) 
                        : name.substring(0, 12);
                }

                this.open = false;
                this.search = '';
                
                // Injeta no proxy de mutação do DOM
                if (typeof window.syncGoogleTranslate === 'function') {
                    window.syncGoogleTranslate(code);
                }
                
                // Dispara evento customizado para sincronizar instâncias múltiplas (Mobile/Desktop)
                window.dispatchEvent(new CustomEvent('language-changed', { detail: { code, name: this.selectedLanguageName } }));
            }
        }));
    });

    // Sincronizador global para manter a Navbar Desktop e Menu Mobile espelhados
    window.addEventListener('language-changed', (e) => {
        document.querySelectorAll('[x-data="languageSelector()"]').forEach(el => {
            let alpineInstance = Alpine.$data(el);
            if(alpineInstance.selectedLanguageCode !== e.detail.code) {
                alpineInstance.selectedLanguageCode = e.detail.code;
                alpineInstance.selectedLanguageName = e.detail.name;
            }
        });
    });
</script>
@endonce