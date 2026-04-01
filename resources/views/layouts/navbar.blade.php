<header class="fixed top-0 left-0 right-0 z-50 w-full transition-all duration-300 bg-white shadow-sm text-slate-800 font-sans" id="site-header">

    {{-- ==========================================
         TOP BAR (Acessibilidade & Links) - Oculta no Mobile
         ========================================== --}}
    <div id="top-bar" class="hidden lg:flex items-center justify-between px-6 py-1.5 bg-blue-950 border-b border-blue-900 text-xs font-medium transition-all duration-300">
        <div class="flex items-center gap-4 text-blue-100">
            <span class="font-bold text-white tracking-widest uppercase text-[10px]">Acessibilidade</span>
            <button type="button" class="hover:text-white transition flex items-center gap-1.5">
                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z"></path>
                </svg>
                Contraste
            </button>
            <button type="button" class="hover:text-white transition font-bold">A-</button>
            <button type="button" class="hover:text-white transition font-bold">A+</button>
        </div>

        <div class="flex items-center gap-4 text-blue-100">
            <a href="#" class="hover:text-white transition">Portal da Transparência</a>
            <a href="#" class="hover:text-white transition">Licitações</a>
            <a href="#" class="hover:text-white transition">Diário Oficial</a>
            <a href="#" class="hover:text-white transition">Ouvidoria</a>
        </div>
    </div>

    {{-- ==========================================
         MAIN NAVBAR
         ========================================== --}}
    <div class="container mx-auto px-4 sm:px-6 py-2 lg:py-4 flex items-center justify-between relative transition-all duration-300" id="nav-inner">

        {{-- Logo Dinâmica --}}
        <a href="{{ route('home') }}" class="flex items-center gap-2 shrink-0 relative w-48 sm:w-56 lg:w-48 xl:w-56 h-14 sm:h-16 lg:h-12 xl:h-16 transition-all duration-300">
            <img src="{{ asset('img/logo_branca.png') }}" alt="Prefeitura de Assaí" class="absolute inset-0 w-full h-full object-contain object-left opacity-0 transition-opacity duration-300" id="logo-branca">
            <img src="{{ asset('img/logo_preta.png') }}" alt="Prefeitura de Assaí" class="absolute inset-0 w-full h-full object-contain object-left opacity-100 transition-opacity duration-300" id="logo-colorida">
        </a>

        {{-- Botão Mobile Hamburger --}}
        <button id="mobile-open-btn" class="lg:hidden p-2 -mr-2 text-blue-900 hover:text-orange-500 transition-colors" aria-label="Abrir menu">
            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16m-7 6h7"></path>
            </svg>
        </button>

        {{-- Menu Desktop --}}
        <nav class="hidden lg:flex items-center lg:gap-0.5 xl:gap-2 lg:text-xs xl:text-sm font-bold tracking-wide">
            <a href="{{ route('home') }}" class="nav-link lg:px-2 xl:px-3 py-2 rounded-lg hover:bg-slate-100 transition whitespace-nowrap">Início</a>

            <a href="{{ route('servicos.index') }}" class="lg:px-3 xl:px-4 py-2 bg-yellow-400 text-blue-950 rounded-full hover:bg-yellow-300 transition shadow-sm lg:mx-0.5 xl:mx-1 whitespace-nowrap">Serviços</a>

            <div class="relative group">
                <button class="nav-link flex items-center gap-1 lg:px-2 xl:px-3 py-2 rounded-lg hover:bg-slate-100 transition whitespace-nowrap">
                    A Cidade
                    <svg class="w-3.5 h-3.5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                    </svg>
                </button>
                <div class="absolute left-0 top-full mt-2 w-48 bg-white text-slate-800 text-sm rounded-xl shadow-xl opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all duration-200 transform origin-top-left border border-slate-100">
                    <a href="#" class="block px-4 py-2.5 hover:bg-blue-50 hover:text-blue-700 first:rounded-t-xl border-b border-slate-50">História</a>
                    <a href="#" class="block px-4 py-2.5 hover:bg-blue-50 hover:text-blue-700 border-b border-slate-50">Turismo</a>
                    <a href="#" class="block px-4 py-2.5 hover:bg-blue-50 hover:text-blue-700 last:rounded-b-xl">Galeria de Fotos</a>
                </div>
            </div>

            <a href="#" class="nav-link lg:px-2 xl:px-3 py-2 rounded-lg hover:bg-slate-100 transition whitespace-nowrap">Secretarias</a>
            <a href="#" class="nav-link lg:px-2 xl:px-3 py-2 rounded-lg hover:bg-slate-100 transition whitespace-nowrap">Notícias</a>
            <a href="#" class="nav-link lg:px-2 xl:px-3 py-2 rounded-lg hover:bg-slate-100 transition whitespace-nowrap">Agenda</a>
            <a href="#" class="nav-link lg:px-2 xl:px-3 py-2 rounded-lg hover:bg-slate-100 transition whitespace-nowrap">Contato</a>

            <a href="#" id="btn-transparencia" class="lg:px-3 xl:px-4 py-2 border border-emerald-600 text-emerald-700 rounded-full hover:bg-emerald-50 transition lg:ml-1 xl:ml-2 flex items-center gap-1.5 whitespace-nowrap">
                <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
                Transparência
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
                <img src="{{ asset('img/logo_branca.png') }}" alt="Assaí" class="h-12 sm:h-14 w-auto object-contain">
                <button id="mobile-close-btn" class="p-2 -mr-2 text-white hover:text-yellow-400 transition">
                    <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>
            </div>

            <div class="flex-1 overflow-y-auto">
                <div class="flex flex-col px-4 py-6 gap-1.5 font-bold text-base">
                    <a href="{{ route('home') }}" class="px-4 py-2.5 rounded-xl bg-white/5 hover:bg-white/10 transition">Início</a>
                    <a href="{{ route('servicos.index') }}" class="px-4 py-2.5 rounded-xl bg-yellow-400 text-blue-950 transition">Serviços ao Cidadão</a>

                    <div class="flex flex-col rounded-xl bg-white/5 overflow-hidden">
                        <button onclick="document.getElementById('mobile-submenu').classList.toggle('hidden')" class="flex items-center justify-between px-4 py-2.5 w-full hover:bg-white/10 transition text-left">
                            <span>A Cidade</span>
                            <svg class="w-4 h-4 text-white/50" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                            </svg>
                        </button>
                        <div id="mobile-submenu" class="hidden flex-col bg-black/20 divide-y divide-white/5">
                            <a href="#" class="block w-full px-6 py-2.5 text-sm font-medium text-blue-100 hover:bg-white/5 hover:text-white transition">História</a>
                            <a href="#" class="block w-full px-6 py-2.5 text-sm font-medium text-blue-100 hover:bg-white/5 hover:text-white transition">Turismo</a>
                            <a href="#" class="block w-full px-6 py-2.5 text-sm font-medium text-blue-100 hover:bg-white/5 hover:text-white transition">Mapas e Dados</a>
                        </div>
                    </div>

                    <a href="#" class="px-4 py-2.5 rounded-xl hover:bg-white/5 transition">Secretarias</a>
                    <a href="#" class="px-4 py-2.5 rounded-xl hover:bg-white/5 transition">Notícias</a>
                    <a href="#" class="px-4 py-2.5 rounded-xl hover:bg-white/5 transition">Agenda</a>
                    <a href="#" class="px-4 py-2.5 rounded-xl hover:bg-white/5 transition">Contato</a>
                </div>
            </div>

            {{-- ==========================================
                 NOVO ACESSO RÁPIDO (Estilo App com 5 itens)
                 ========================================== --}}
            <div class="p-5 sm:p-6 bg-blue-950/50 shrink-0 border-t border-white/10 mt-auto">
                <p class="text-xs uppercase tracking-widest text-blue-400 font-bold mb-4 px-1">Acesso Rápido</p>
                <div class="grid grid-cols-2 gap-2 text-sm text-blue-100">

                    {{-- DESTAQUE: Transparência ocupando as duas colunas --}}
                    <a href="#" class="col-span-2 flex items-center gap-3 p-3 rounded-xl hover:bg-white/10 transition group border border-white/5 bg-white/5">
                        <div class="p-2 bg-blue-900 rounded-lg group-hover:bg-yellow-400 transition-colors">
                            <svg class="w-5 h-5 text-blue-400 group-hover:text-blue-950 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                            </svg>
                        </div>
                        <span class="font-bold leading-tight text-sm">Portal da Transparência</span>
                    </a>

                    {{-- Os 4 cartões restantes perfeitamente alinhados --}}
                    <a href="#" class="flex flex-col items-start gap-2 p-3 rounded-xl hover:bg-white/10 transition group">
                        <svg class="w-6 h-6 text-blue-400 group-hover:text-yellow-400 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"></path>
                        </svg>
                        <span class="font-medium leading-tight text-[13px] sm:text-sm">Ouvidoria</span>
                    </a>

                    <a href="#" class="flex flex-col items-start gap-2 p-3 rounded-xl hover:bg-white/10 transition group">
                        <svg class="w-6 h-6 text-blue-400 group-hover:text-yellow-400 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9.5a2.5 2.5 0 00-2.5-2.5H15"></path>
                        </svg>
                        <span class="font-medium leading-tight text-[13px] sm:text-sm">Diário Oficial</span>
                    </a>

                    <a href="#" class="flex flex-col items-start gap-2 p-3 rounded-xl hover:bg-white/10 transition group">
                        <svg class="w-6 h-6 text-blue-400 group-hover:text-yellow-400 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                        </svg>
                        <span class="font-medium leading-tight text-[13px] sm:text-sm">Licitações</span>
                    </a>

                    {{-- NOVO: Cartão das Leis com ícone de balança --}}
                    <a href="#" class="flex flex-col items-start gap-2 p-3 rounded-xl hover:bg-white/10 transition group">
                        <svg class="w-6 h-6 text-blue-400 group-hover:text-yellow-400 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M3 6l3 1m0 0l-3 9a5.002 5.002 0 006.001 0M6 7l3 9M6 7l6-2m6 2l3-1m-3 1l-3 9a5.002 5.002 0 006.001 0M18 7l3 9m-3-9l-6-2m0-2v2m0 16V5m0 16H9m3 0h3"></path>
                        </svg>
                        <span class="font-medium leading-tight text-[13px] sm:text-sm">Leis</span>
                    </a>
                </div>
            </div>
        </div>
    </div>
</header>

<script>
    document.addEventListener('DOMContentLoaded', () => {
        const header = document.getElementById('site-header');
        if (header) document.body.style.paddingTop = header.offsetHeight + 'px';

        const isHome = document.getElementById('home-hero') !== null;
        const topBar = document.getElementById('top-bar');
        const navInner = document.getElementById('nav-inner');
        const logoBranca = document.getElementById('logo-branca');
        const logoColorida = document.getElementById('logo-colorida');
        const navLinks = document.querySelectorAll('.nav-link');
        const mobileBtn = document.getElementById('mobile-open-btn');
        const btnTransparencia = document.getElementById('btn-transparencia');

        function onScroll() {
            if (!isHome) return;

            if (window.scrollY > 50) {
                header.classList.replace('bg-transparent', 'bg-white');
                header.classList.replace('text-white', 'text-slate-800');
                header.classList.add('shadow-sm');

                if (topBar) topBar.classList.replace('lg:flex', 'hidden');
                if (navInner) navInner.classList.replace('lg:py-4', 'lg:py-2');

                logoBranca.classList.add('opacity-0');
                logoColorida.classList.remove('opacity-0');

                navLinks.forEach(l => l.classList.replace('hover:bg-white/10', 'hover:bg-slate-100'));
                mobileBtn.classList.replace('text-white', 'text-blue-900');

                btnTransparencia.classList.replace('border-emerald-400', 'border-emerald-600');
                btnTransparencia.classList.replace('text-emerald-300', 'text-emerald-700');
                btnTransparencia.classList.replace('hover:text-blue-950', 'hover:bg-emerald-50');

            } else {
                header.classList.replace('bg-white', 'bg-transparent');
                header.classList.replace('text-slate-800', 'text-white');
                header.classList.remove('shadow-sm');

                if (topBar) topBar.classList.replace('hidden', 'lg:flex');
                if (navInner) navInner.classList.replace('lg:py-2', 'lg:py-4');

                logoBranca.classList.remove('opacity-0');
                logoColorida.classList.add('opacity-0');

                navLinks.forEach(l => l.classList.replace('hover:bg-slate-100', 'hover:bg-white/10'));
                mobileBtn.classList.replace('text-blue-900', 'text-white');

                btnTransparencia.classList.replace('border-emerald-600', 'border-emerald-400');
                btnTransparencia.classList.replace('text-emerald-700', 'text-emerald-300');
                btnTransparencia.classList.replace('hover:bg-emerald-50', 'hover:text-blue-950');
            }
        }

        window.addEventListener('scroll', onScroll, {
            passive: true
        });
        onScroll();

        const drawer = document.getElementById('mobile-drawer');
        const overlay = document.getElementById('mobile-overlay');
        const panel = document.getElementById('mobile-panel');
        const closeBtn = document.getElementById('mobile-close-btn');

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

        mobileBtn.addEventListener('click', openMenu);
        closeBtn.addEventListener('click', closeMenu);
        overlay.addEventListener('click', closeMenu);
    });
</script>