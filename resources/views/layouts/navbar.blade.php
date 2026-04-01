<header class="fixed top-0 left-0 right-0 z-50 w-full bg-white shadow-sm text-slate-700 font-sans" id="site-header">

    {{-- ==========================================
         TOP BAR (Acessibilidade & Links Externos)
         ========================================== --}}
    <div id="top-bar" class="hidden lg:flex items-center justify-between px-6 py-1.5 bg-blue-950 border-b border-blue-900 text-xs font-medium">
        <div class="flex items-center gap-3 text-blue-100">
            <a href="{{ route('pages.acessibilidade') }}" class="font-bold text-white tracking-widest uppercase text-[10px] hover:text-yellow-400 transition">Acessibilidade</a>
            <span class="text-white/20">|</span>
            <button id="btn-contrast" type="button" class="hover:text-yellow-400 transition flex items-center gap-1.5">
                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z"></path>
                </svg>
                Contraste
            </button>
            <button id="btn-decrease-font" type="button" class="hover:text-yellow-400 transition font-bold px-1">A-</button>
            <button id="btn-increase-font" type="button" class="hover:text-yellow-400 transition font-bold px-1">A+</button>
        </div>

        <div class="flex items-center gap-4 text-blue-100">
            <a href="https://transparencia.betha.cloud/#/yyGw8hIiYdv6bs-avrzVUg==" target="_blank" rel="noopener noreferrer" class="hover:text-white transition">Portal da Transparência</a>
            <a href="https://www.doemunicipal.com.br/prefeituras/4" target="_blank" rel="noopener noreferrer" class="hover:text-white transition">Diário Oficial</a>
            <a href="https://transparencia.betha.cloud/#/yyGw8hIiYdv6bs-avrzVUg==/consulta/95802" target="_blank" rel="noopener noreferrer" class="hover:text-white transition">Licitações</a>
            <a href="https://assai.atende.net/subportal/ouvidoria" target="_blank" rel="noopener noreferrer" class="hover:text-white transition">Ouvidoria</a>
            <a href="https://leismunicipais.com.br/prefeitura/pr/assai" target="_blank" rel="noopener noreferrer" class="hover:text-white transition">Leis Municipais</a>
            <a href="https://e-gov.betha.com.br/e-nota/login.faces" target="_blank" rel="noopener noreferrer" class="hover:text-white transition">E-Sic</a>
        </div>
    </div>

    {{-- ==========================================
         MAIN NAVBAR
         ========================================== --}}
    <div class="container mx-auto px-4 sm:px-6 py-2 lg:py-2 xl:py-3 flex items-center justify-between relative" id="nav-inner">

        {{-- Logo --}}
        <a href="{{ route('home2') }}" class="flex items-center shrink-0 relative h-16 sm:h-20 lg:h-18 xl:h-20 w-auto py-1">
            <img src="{{ asset('img/logo_preta.png') }}" alt="Prefeitura de Assaí" class="h-full w-auto object-contain">
        </a>

        {{-- Botão Mobile Hamburger --}}
        <button id="mobile-open-btn" class="lg:hidden p-2 -mr-2 text-blue-900 hover:text-orange-500 transition-colors" aria-label="Abrir menu">
            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16m-7 6h7"></path>
            </svg>
        </button>

        {{-- Menu Desktop (Lógica Dinâmica) --}}
        <nav class="hidden lg:flex items-center lg:gap-0.5 xl:gap-1.5 lg:text-[11px] xl:text-sm font-bold tracking-wide">
            
            {{-- INÍCIO --}}
            <a href="{{ route('home2') }}" class="lg:px-1.5 xl:px-3 py-2 rounded-lg transition whitespace-nowrap flex flex-col items-center hover:bg-slate-50 {{ request()->routeIs('home2') ? 'text-blue-700' : 'text-slate-700' }}">
                <span>Início</span>
                @if(request()->routeIs('home2'))
                    <span class="w-1.5 h-1.5 bg-yellow-400 rounded-full mt-0.5"></span>
                @endif
            </a>

            {{-- SERVIÇOS --}}
            <a href="{{ route('servicos.index') }}" class="lg:px-2.5 xl:px-4 py-2 text-blue-950 rounded-full transition shadow-sm lg:mx-0.5 xl:mx-1 whitespace-nowrap {{ request()->routeIs('servicos.*') ? 'bg-yellow-300' : 'bg-yellow-400 hover:bg-yellow-300' }}">
                Serviços
            </a>

            {{-- A CIDADE (Dropdown) --}}
            <div class="relative group">
                <button class="flex items-center gap-1 lg:px-1.5 xl:px-3 py-2 rounded-lg hover:bg-slate-50 transition whitespace-nowrap {{ request()->routeIs('pages.sobre') || request()->routeIs('pages.turismo') ? 'text-blue-700' : 'text-slate-700' }}">
                    <div class="flex flex-col items-center">
                        <span>A Cidade</span>
                        @if(request()->routeIs('pages.sobre') || request()->routeIs('pages.turismo'))
                            <span class="w-1.5 h-1.5 bg-yellow-400 rounded-full mt-0.5"></span>
                        @endif
                    </div>
                    <svg class="w-3.5 h-3.5 shrink-0 mb-auto mt-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                </button>
                <div class="absolute left-0 top-full mt-2 w-48 bg-white text-slate-800 text-sm rounded-xl shadow-xl opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all duration-200 transform origin-top-left border border-slate-100">
                    <a href="{{ route('pages.sobre') }}" class="block px-4 py-2.5 hover:bg-blue-50 hover:text-blue-700 first:rounded-t-xl border-b border-slate-50 {{ request()->routeIs('pages.sobre') ? 'bg-blue-50 text-blue-700 font-extrabold' : '' }}">História e Perfil</a>
                    <a href="{{ route('pages.turismo') }}" class="block px-4 py-2.5 hover:bg-blue-50 hover:text-blue-700 last:rounded-b-xl {{ request()->routeIs('pages.turismo') ? 'bg-blue-50 text-blue-700 font-extrabold' : '' }}">Turismo</a>
                </div>
            </div>

            {{-- SECRETARIAS --}}
            <a href="{{ route('secretarias.index') }}" class="lg:px-1.5 xl:px-3 py-2 rounded-lg hover:bg-slate-50 transition whitespace-nowrap flex flex-col items-center {{ request()->routeIs('secretarias.*') ? 'text-blue-700' : 'text-slate-700' }}">
                <span>Secretarias</span>
                @if(request()->routeIs('secretarias.*'))
                    <span class="w-1.5 h-1.5 bg-yellow-400 rounded-full mt-0.5"></span>
                @endif
            </a>

            {{-- PROGRAMAS --}}
            <a href="{{ route('programas.index') }}" class="lg:px-1.5 xl:px-3 py-2 rounded-lg hover:bg-slate-50 transition whitespace-nowrap flex flex-col items-center {{ request()->routeIs('programas.*') ? 'text-blue-700' : 'text-slate-700' }}">
                <span>Programas</span>
                @if(request()->routeIs('programas.*'))
                    <span class="w-1.5 h-1.5 bg-yellow-400 rounded-full mt-0.5"></span>
                @endif
            </a>

            {{-- NOTÍCIAS --}}
            <a href="{{ route('noticias.index') }}" class="lg:px-1.5 xl:px-3 py-2 rounded-lg hover:bg-slate-50 transition whitespace-nowrap flex flex-col items-center {{ request()->routeIs('noticias.*') ? 'text-blue-700' : 'text-slate-700' }}">
                <span>Notícias</span>
                @if(request()->routeIs('noticias.*'))
                    <span class="w-1.5 h-1.5 bg-yellow-400 rounded-full mt-0.5"></span>
                @endif
            </a>

            {{-- AGENDA --}}
            <a href="{{ route('agenda.index') }}" class="lg:px-1.5 xl:px-3 py-2 rounded-lg hover:bg-slate-50 transition whitespace-nowrap flex flex-col items-center {{ request()->routeIs('agenda.*') ? 'text-blue-700' : 'text-slate-700' }}">
                <span>Agenda</span>
                @if(request()->routeIs('agenda.*'))
                    <span class="w-1.5 h-1.5 bg-yellow-400 rounded-full mt-0.5"></span>
                @endif
            </a>

            {{-- CONTATO --}}
            <a href="{{ route('contato.index') }}" class="lg:px-1.5 xl:px-3 py-2 rounded-lg hover:bg-slate-50 transition whitespace-nowrap flex flex-col items-center {{ request()->routeIs('contato.*') ? 'text-blue-700' : 'text-slate-700' }}">
                <span>Contato</span>
                @if(request()->routeIs('contato.*'))
                    <span class="w-1.5 h-1.5 bg-yellow-400 rounded-full mt-0.5"></span>
                @endif
            </a>
        </nav>
    </div>

    {{-- ==========================================
         MOBILE MENU DRAWER (Gaveta Lateral)
         ========================================== --}}
    <div id="mobile-drawer" class="fixed inset-0 z-[100] invisible lg:hidden">
        <div id="mobile-overlay" class="absolute inset-0 bg-blue-950/80 backdrop-blur-sm opacity-0 transition-opacity duration-300"></div>

        <div id="mobile-panel" class="absolute right-0 top-0 h-[100dvh] w-[85%] max-w-[320px] bg-blue-900 shadow-2xl transform translate-x-full transition-transform duration-300 flex flex-col text-white">

            <div class="flex items-center justify-between p-4 border-b border-white/10 shrink-0">
                <img src="{{ asset('img/logo_branca.png') }}" alt="Assaí" class="h-16 sm:h-18 w-auto object-contain">
                <button id="mobile-close-btn" class="p-2 -mr-2 text-white hover:text-yellow-400 transition">
                    <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M6 18L18 6M6 6l12 12"></path></svg>
                </button>
            </div>

            <div class="flex-1 overflow-y-auto">
                <div class="flex flex-col px-4 py-6 gap-1 font-bold text-base">
                    
                    <a href="{{ route('home2') }}" class="px-4 py-2.5 rounded-xl transition flex items-center justify-between {{ request()->routeIs('home2') ? 'bg-white/10 text-white font-extrabold' : 'hover:bg-white/5 font-bold' }}">
                        <span>Início</span>
                        @if(request()->routeIs('home2'))
                            <span class="w-2 h-2 bg-yellow-400 rounded-full shadow-[0_0_6px_rgba(250,204,21,0.6)]"></span>
                        @endif
                    </a>
                    
                    <a href="{{ route('servicos.index') }}" class="px-4 py-2.5 rounded-xl text-blue-950 transition flex items-center justify-between {{ request()->routeIs('servicos.*') ? 'bg-yellow-300' : 'bg-yellow-400 hover:bg-yellow-300' }}">
                        <span>Serviços ao Cidadão</span>
                    </a>

                    <div class="flex flex-col rounded-xl overflow-hidden mt-1 {{ request()->routeIs('pages.sobre') || request()->routeIs('pages.turismo') ? 'bg-white/5' : '' }}">
                        <button onclick="document.getElementById('mobile-submenu').classList.toggle('hidden')" class="flex items-center justify-between px-4 py-2.5 w-full hover:bg-white/10 transition text-left">
                            <div class="flex items-center gap-2">
                                <span>A Cidade</span>
                                @if(request()->routeIs('pages.sobre') || request()->routeIs('pages.turismo'))
                                    <span class="w-2 h-2 bg-yellow-400 rounded-full shadow-[0_0_6px_rgba(250,204,21,0.6)]"></span>
                                @endif
                            </div>
                            <svg class="w-4 h-4 text-white/50" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                        </button>
                        <div id="mobile-submenu" class="{{ request()->routeIs('pages.sobre') || request()->routeIs('pages.turismo') ? 'flex' : 'hidden' }} flex-col bg-black/20 divide-y divide-white/5">
                            <a href="{{ route('pages.sobre') }}" class="block w-full px-6 py-2.5 text-sm transition {{ request()->routeIs('pages.sobre') ? 'text-yellow-400 font-extrabold' : 'text-blue-100 hover:bg-white/5 hover:text-white font-medium' }}">História e Perfil</a>
                            <a href="{{ route('pages.turismo') }}" class="block w-full px-6 py-2.5 text-sm transition {{ request()->routeIs('pages.turismo') ? 'text-yellow-400 font-extrabold' : 'text-blue-100 hover:bg-white/5 hover:text-white font-medium' }}">Turismo</a>
                        </div>
                    </div>

                    <a href="{{ route('secretarias.index') }}" class="px-4 py-2.5 rounded-xl transition flex items-center justify-between {{ request()->routeIs('secretarias.*') ? 'bg-white/10 text-white font-extrabold' : 'hover:bg-white/5 font-bold' }}">
                        <span>Secretarias</span>
                        @if(request()->routeIs('secretarias.*')) <span class="w-2 h-2 bg-yellow-400 rounded-full shadow-[0_0_6px_rgba(250,204,21,0.6)]"></span> @endif
                    </a>

                    <a href="{{ route('programas.index') }}" class="px-4 py-2.5 rounded-xl transition flex items-center justify-between {{ request()->routeIs('programas.*') ? 'bg-white/10 text-white font-extrabold' : 'hover:bg-white/5 font-bold' }}">
                        <span>Programas</span>
                        @if(request()->routeIs('programas.*')) <span class="w-2 h-2 bg-yellow-400 rounded-full shadow-[0_0_6px_rgba(250,204,21,0.6)]"></span> @endif
                    </a>

                    <a href="{{ route('noticias.index') }}" class="px-4 py-2.5 rounded-xl transition flex items-center justify-between {{ request()->routeIs('noticias.*') ? 'bg-white/10 text-white font-extrabold' : 'hover:bg-white/5 font-bold' }}">
                        <span>Notícias</span>
                        @if(request()->routeIs('noticias.*')) <span class="w-2 h-2 bg-yellow-400 rounded-full shadow-[0_0_6px_rgba(250,204,21,0.6)]"></span> @endif
                    </a>

                    <a href="{{ route('agenda.index') }}" class="px-4 py-2.5 rounded-xl transition flex items-center justify-between {{ request()->routeIs('agenda.*') ? 'bg-white/10 text-white font-extrabold' : 'hover:bg-white/5 font-bold' }}">
                        <span>Agenda</span>
                        @if(request()->routeIs('agenda.*')) <span class="w-2 h-2 bg-yellow-400 rounded-full shadow-[0_0_6px_rgba(250,204,21,0.6)]"></span> @endif
                    </a>

                    <a href="{{ route('contato.index') }}" class="px-4 py-2.5 rounded-xl transition flex items-center justify-between {{ request()->routeIs('contato.*') ? 'bg-white/10 text-white font-extrabold' : 'hover:bg-white/5 font-bold' }}">
                        <span>Contato</span>
                        @if(request()->routeIs('contato.*')) <span class="w-2 h-2 bg-yellow-400 rounded-full shadow-[0_0_6px_rgba(250,204,21,0.6)]"></span> @endif
                    </a>

                </div>
            </div>

            <div class="p-5 sm:p-6 bg-blue-950/50 shrink-0 border-t border-white/10 mt-auto">
                <p class="text-[10px] uppercase tracking-widest text-blue-400 font-bold mb-3 px-1">Links Externos Oficiais</p>
                <div class="grid grid-cols-2 gap-2 text-sm sm:text-base text-blue-100">
                    <a href="https://transparencia.betha.cloud/#/yyGw8hIiYdv6bs-avrzVUg==" target="_blank" class="flex flex-col items-start gap-1 p-2.5 rounded-xl bg-white/5 border border-white/5 hover:bg-white/10 transition group">
                        <svg class="w-5 h-5 text-blue-400 group-hover:text-yellow-400 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                        <span class="font-medium leading-tight text-xs sm:text-sm">Transparência</span>
                    </a>
                    <a href="https://www.doemunicipal.com.br/prefeituras/4" target="_blank" class="flex flex-col items-start gap-1 p-2.5 rounded-xl bg-white/5 border border-white/5 hover:bg-white/10 transition group">
                        <svg class="w-5 h-5 text-blue-400 group-hover:text-yellow-400 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9.5a2.5 2.5 0 00-2.5-2.5H15"></path></svg>
                        <span class="font-medium leading-tight text-xs sm:text-sm">Diário Oficial</span>
                    </a>
                    <a href="https://transparencia.betha.cloud/#/yyGw8hIiYdv6bs-avrzVUg==/consulta/95802" target="_blank" class="flex flex-col items-start gap-1 p-2.5 rounded-xl bg-white/5 border border-white/5 hover:bg-white/10 transition group">
                        <svg class="w-5 h-5 text-blue-400 group-hover:text-yellow-400 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                        <span class="font-medium leading-tight text-xs sm:text-sm">Licitações</span>
                    </a>
                    <a href="https://assai.atende.net/subportal/ouvidoria" target="_blank" class="flex flex-col items-start gap-1 p-2.5 rounded-xl bg-white/5 border border-white/5 hover:bg-white/10 transition group">
                        <svg class="w-5 h-5 text-blue-400 group-hover:text-yellow-400 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"></path></svg>
                        <span class="font-medium leading-tight text-xs sm:text-sm">Ouvidoria</span>
                    </a>
                    <a href="https://leismunicipais.com.br/prefeitura/pr/assai" target="_blank" class="flex flex-col items-start gap-1 p-2.5 rounded-xl bg-white/5 border border-white/5 hover:bg-white/10 transition group">
                        <svg class="w-5 h-5 text-blue-400 group-hover:text-yellow-400 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M3 6l3 1m0 0l-3 9a5.002 5.002 0 006.001 0M6 7l3 9M6 7l6-2m6 2l3-1m-3 1l-3 9a5.002 5.002 0 006.001 0M18 7l3 9m-3-9l-6-2m0-2v2m0 16V5m0 16H9m3 0h3"></path></svg>
                        <span class="font-medium leading-tight text-xs sm:text-sm">Leis Mun.</span>
                    </a>
                    <a href="https://e-gov.betha.com.br/e-nota/login.faces" target="_blank" class="flex flex-col items-start gap-1 p-2.5 rounded-xl bg-white/5 border border-white/5 hover:bg-white/10 transition group">
                        <svg class="w-5 h-5 text-blue-400 group-hover:text-yellow-400 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M10 6H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V8a2 2 0 00-2-2h-5m-4 0V5a2 2 0 114 0v1m-4 0a2 2 0 104 0m-5 8a2 2 0 100-4 2 2 0 000 4zm0 0c1.306 0 2.417.835 2.83 2M9 14a3.001 3.001 0 00-2.83 2M15 11h3m-3 4h2"></path></svg>
                        <span class="font-medium leading-tight text-xs sm:text-sm">E-SIC</span>
                    </a>
                </div>
            </div>
        </div>
    </div>
</header>

<script>
    document.addEventListener('DOMContentLoaded', () => {
        // ---- COMPENSAÇÃO DE ALTURA ----
        const header = document.getElementById('site-header');
        if (header) document.body.style.paddingTop = header.offsetHeight + 'px';

        // ---- GESTÃO DO MENU MOBILE ----
        const drawer = document.getElementById('mobile-drawer');
        const overlay = document.getElementById('mobile-overlay');
        const panel = document.getElementById('mobile-panel');
        const closeBtn = document.getElementById('mobile-close-btn');
        const mobileBtn = document.getElementById('mobile-open-btn');

        function openMenu() {
            drawer.classList.remove('invisible');
            document.body.style.overflow = 'hidden';
            requestAnimationFrame(() => {
                overlay.classList.remove('opacity-0');
                panel.classList.remove('translate-x-full');
            });
        }

        function closeMenu() {
            overlay.classList.add('opacity-0');
            panel.classList.add('translate-x-full');
            document.body.style.overflow = '';
            setTimeout(() => {
                drawer.classList.add('invisible');
            }, 300);
        }

        if(mobileBtn) mobileBtn.addEventListener('click', openMenu);
        if(closeBtn) closeBtn.addEventListener('click', closeMenu);
        if(overlay) overlay.addEventListener('click', closeMenu);
    });
</script>