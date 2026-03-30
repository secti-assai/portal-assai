{{-- O cabeçalho agora tem 'fixed w-full' para flutuar, e classes de transição --}}
<header id="site-header" class="fixed top-0 z-50 w-full transition-all duration-300 bg-transparent text-white">

    {{-- BARRA SUPERIOR (Acessibilidade e Transparência) --}}
    {{-- Adicionada classe 'top-bar-container' para controlo via JS --}}
    <div id="top-bar" class="hidden px-4 py-2 text-xs text-white transition-all duration-300 bg-blue-900/90 backdrop-blur-md xl:block font-sans border-b border-white/10 top-bar-container">
        <div class="container flex justify-end items-center gap-5 mx-auto">
            <div class="flex items-center gap-2 border-r border-white/20 pr-4">
                <a href="{{ route('pages.acessibilidade') }}" class="hover:text-yellow-400 hover:underline font-bold flex items-center gap-1.5 transition py-1 px-1" title="Página de Acessibilidade">
                    Acessibilidade
                </a>
                <span class="text-white/40">|</span>
                <button id="btn-contrast" type="button" aria-label="Alternar modo alto contraste" aria-pressed="false" class="hover:text-yellow-400 font-bold flex items-center gap-1 transition py-1 px-1" title="Alto Contraste">
                    <svg class="w-3.5 h-3.5" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M12 2a10 10 0 100 20 10 10 0 000-20zM12 20a8 8 0 110-16 8 8 0 010 16zm0-14v12a6 6 0 100-12z" />
                    </svg>
                    Contraste
                </button>
                <button id="btn-decrease-font" class="hover:text-yellow-400 font-bold px-1 transition py-1" title="Diminuir Fonte">A-</button>
                <button id="btn-increase-font" class="hover:text-yellow-400 font-bold px-1 transition py-1" title="Aumentar Fonte">A+</button>
            </div>

            <a href="https://transparencia.betha.cloud/#/yyGw8hIiYdv6bs-avrzVUg==" target="_blank" rel="noopener noreferrer" class="transition hover:text-yellow-400">Portal da Transparência</a>
            <a href="https://leismunicipais.com.br/prefeitura/pr/assai" target="_blank" rel="noopener noreferrer" class="transition hover:text-yellow-400">Leis Municipais</a>
            <a href="https://transparencia.betha.cloud/#/yyGw8hIiYdv6bs-avrzVUg==/consulta/95802" target="_blank" rel="noopener noreferrer" class="transition hover:text-yellow-400">Licitações</a>
            <a href="https://www.doemunicipal.com.br/prefeituras/4" target="_blank" rel="noopener noreferrer" class="transition hover:text-yellow-400">Diário Oficial</a>
            <a href="https://assai.atende.net/subportal/ouvidoria" target="_blank" rel="noopener noreferrer" class="transition hover:text-yellow-400">Ouvidoria</a>
            <a href="https://e-gov.betha.com.br/e-nota/login.faces" target="_blank" rel="noopener noreferrer" class="transition hover:text-yellow-400">E-SIC</a>
        </div>
    </div>

    {{-- NAVEGAÇÃO PRINCIPAL --}}
    <div id="main-nav-container" class="transition-all duration-300">
        <div class="container flex items-center justify-between px-4 py-4 mx-auto transition-all duration-300 nav-inner">

            {{-- Logótipos (Troca no Scroll) --}}
            <a href="{{ route('home') }}" class="flex items-center shrink-0">
                <img id="logo-branca" src="{{ asset('img/logo_branca.png') }}" alt="Prefeitura de Assaí" class="h-10 md:h-14 w-auto object-contain transition-opacity duration-300">
                <img id="logo-preta" src="{{ asset('img/logo_preta.png') }}" alt="Prefeitura de Assaí" class="h-10 md:h-12 w-auto object-contain absolute opacity-0 transition-opacity duration-300">
            </a>

            {{-- Links Desktop --}}
            <nav accesskey="2" tabindex="-1" aria-label="Navegação Principal" class="items-center hidden gap-4 lg:gap-6 font-medium xl:flex xl:justify-between xl:flex-wrap font-sans focus:outline-none">
                <a href="{{ route('home') }}" class="nav-link transition hover:text-yellow-400 px-2 xl:px-3">Início</a>
                <a href="{{ route('servicos.index') }}" class="px-5 py-2.5 text-sm font-bold text-blue-900 bg-yellow-400 rounded-full hover:bg-yellow-300 shadow-sm transition-all hover:scale-105 mx-0.5 xl:mx-1">Serviços</a>

                {{-- Dropdown: A Cidade --}}
                <div class="relative group">
                    <button id="btn-cidade-desktop" type="button" aria-haspopup="true" aria-expanded="false" aria-controls="submenu-cidade-desktop" class="nav-link flex items-center gap-1 font-medium hover:text-yellow-400 transition">
                        A Cidade
                        <svg class="w-4 h-4 mt-px opacity-70 group-hover:opacity-100 transition" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                        </svg>
                    </button>
                    <div id="submenu-cidade-desktop" class="absolute left-0 top-full mt-4 w-56 bg-white border border-slate-100 rounded-2xl shadow-xl opacity-0 invisible group-hover:opacity-100 group-hover:visible group-focus-within:opacity-100 group-focus-within:visible transition-all duration-300 z-50 py-2 transform translate-y-2 group-hover:translate-y-0">
                        <a href="{{ route('pages.sobre') }}" class="flex items-center gap-3 px-5 py-3 text-sm text-slate-600 hover:bg-blue-50 hover:text-blue-700 transition">
                            <span class="p-1.5 rounded-lg bg-blue-50 text-blue-600">
                                <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                            </span>
                            História e Perfil
                        </a>
                        <a href="{{ route('pages.turismo') }}" class="flex items-center gap-3 px-5 py-3 text-sm text-slate-600 hover:bg-blue-50 hover:text-blue-700 transition">
                            <span class="p-1.5 rounded-lg bg-emerald-50 text-emerald-600">
                                <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 9l9-7 9 7v11a2 2 0 01-2 2H5a2 2 0 01-2-2z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 22V12h6v10" />
                                </svg>
                            </span>
                            Turismo
                        </a>
                    </div>
                </div>

                <a href="{{ route('secretarias.index') }}" class="nav-link transition hover:text-yellow-400 px-2 xl:px-3">Secretarias</a>
                <a href="{{ route('noticias.index') }}" class="nav-link transition hover:text-yellow-400 px-2 xl:px-3">Notícias</a>
                <a href="{{ route('agenda.index') }}" class="nav-link transition hover:text-yellow-400 px-2 xl:px-3">Agenda</a>
                <a href="{{ route('programas.index') }}" class="nav-link transition hover:text-yellow-400 px-2 xl:px-3">Programas</a>

                <a href="{{ route('pages.transparencia') }}" class="nav-link-special flex items-center gap-1.5 text-sm font-bold text-green-300 hover:text-green-200 transition-colors ml-2 bg-white/10 px-3 py-1.5 rounded-full border border-white/20 backdrop-blur-sm">
                    <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    Transparência
                </a>
                <a href="{{ route('contato.index') }}" class="nav-link transition hover:text-yellow-400 px-2 xl:px-3">Contato</a>
            </nav>

            {{-- Botão Mobile --}}
            <button id="mobile-menu-button" type="button" aria-controls="mobile-menu" aria-expanded="false" aria-label="Abrir menu principal" class="p-2 transition rounded-xl xl:hidden hover:bg-white/10 focus:outline-none">
                <svg id="hamburger-icon" class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
                </svg>
            </button>
        </div>
    </div>

    {{-- MENU MOBILE (Inalterado da sua versão) --}}
    <div id="mobile-menu" class="absolute hidden w-full z-50 bg-white border-t border-gray-100 shadow-2xl xl:hidden max-h-[calc(100vh-5rem)] overflow-y-auto overscroll-contain text-slate-800">
        <nav class="flex flex-col gap-1 px-4 pt-2 pb-6 font-sans text-center">
            <a href="{{ route('home') }}" class="block px-3 py-3 text-base font-medium text-gray-700 rounded-md hover:text-blue-900 hover:bg-blue-50 text-center">Início</a>
            <a href="{{ route('servicos.index') }}" class="flex items-center justify-center px-3 py-3 text-base font-bold text-white bg-blue-600 rounded-md hover:bg-blue-700 transition-colors">Serviços ao Cidadão</a>

            {{-- Acordeão: A Cidade --}}
            <div>
                <button id="btn-cidade-mobile" type="button" aria-controls="submenu-cidade-mobile" aria-expanded="false"
                    class="flex items-center justify-center gap-2 w-full px-3 py-3 text-base font-medium text-gray-700 rounded-md hover:text-blue-900 hover:bg-blue-50 transition">
                    A Cidade
                    <svg id="icon-cidade-mobile" class="w-4 h-4 text-gray-400 transition-transform duration-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                    </svg>
                </button>
                <div id="submenu-cidade-mobile" class="hidden mt-1 mb-1 space-y-1">
                    <a href="{{ route('pages.sobre') }}" class="block py-2 text-sm text-slate-500 rounded-md hover:text-blue-700 hover:bg-blue-50 transition text-center">História e Perfil</a>
                    <a href="{{ route('pages.turismo') }}" class="block py-2 text-sm text-slate-500 rounded-md hover:text-blue-700 hover:bg-blue-50 transition text-center">Turismo</a>
                </div>
            </div>

            <a href="{{ route('secretarias.index') }}" class="block px-3 py-3 text-base font-medium text-gray-700 rounded-md hover:text-blue-900 hover:bg-blue-50 text-center">Secretarias</a>
            <a href="{{ route('noticias.index') }}" class="block px-3 py-3 text-base font-medium text-gray-700 rounded-md hover:text-blue-900 hover:bg-blue-50 text-center">Notícias</a>
            <a href="{{ route('agenda.index') }}" class="block px-3 py-3 text-base font-medium text-gray-700 rounded-md hover:text-blue-900 hover:bg-blue-50 text-center">Agenda</a>
            <a href="{{ route('programas.index') }}" class="block px-3 py-3 text-base font-medium text-gray-700 rounded-md hover:text-blue-900 hover:bg-blue-50 text-center">Programas</a>
            <a href="{{ route('contato.index') }}" class="block px-3 py-3 text-base font-medium text-gray-700 rounded-md hover:text-blue-900 hover:bg-blue-50 text-center">Contato</a>

            <a href="{{ route('pages.transparencia') }}" class="flex items-center justify-center gap-2 w-full px-4 py-3 mt-1 text-sm font-bold text-emerald-600 border border-emerald-200 bg-emerald-50 rounded-xl hover:bg-emerald-100 transition-colors">
                <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                Transparência
            </a>

            <div class="pt-3 mt-2 border-t border-gray-100 grid grid-cols-2 gap-2 text-center">
                <a href="https://transparencia.betha.cloud/#/yyGw8hIiYdv6bs-avrzVUg==" class="px-3 py-2 text-xs font-bold text-blue-600 rounded-md bg-blue-50 text-center">Transparência</a>
                <a href="https://leismunicipais.com.br/prefeitura/pr/assai" target="_blank" rel="noopener noreferrer" class="px-3 py-2 text-xs font-medium text-slate-600 rounded-md bg-slate-50 hover:bg-slate-100 transition-colors text-center">Leis Municipais</a>
                <a href="https://transparencia.betha.cloud/#/yyGw8hIiYdv6bs-avrzVUg==/consulta/95802" target="_blank" rel="noopener noreferrer" class="px-3 py-2 text-xs font-medium text-slate-600 rounded-md bg-slate-50 hover:bg-slate-100 transition-colors text-center">Licitações</a>
                <a href="https://www.doemunicipal.com.br/prefeituras/4" target="_blank" rel="noopener noreferrer" class="px-3 py-2 text-xs font-medium text-slate-600 rounded-md bg-slate-50 hover:bg-slate-100 transition-colors text-center">Diário Oficial</a>
                <a href="https://assai.atende.net/subportal/ouvidoria" target="_blank" rel="noopener noreferrer" class="px-3 py-2 text-xs font-medium text-slate-600 rounded-md bg-slate-50 hover:bg-slate-100 transition-colors text-center">Ouvidoria</a>
                <a href="https://e-gov.betha.com.br/e-nota/login.faces" target="_blank" rel="noopener noreferrer" class="px-3 py-2 text-xs font-medium text-slate-600 rounded-md bg-slate-50 hover:bg-slate-100 transition-colors text-center">E-SIC</a>
            </div>
        </nav>
    </div>
</header>