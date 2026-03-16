<header class="relative z-50 bg-white shadow-sm">
    <div class="hidden px-4 py-2.5 text-sm text-white bg-blue-900 sm:block font-sans">
        <div class="container flex justify-end items-center gap-5 mx-auto">
            <div class="flex items-center gap-2 border-r border-blue-700 pr-4">
                <a href="{{ route('pages.acessibilidade') }}" class="hover:text-yellow-400 hover:underline font-bold flex items-center gap-1.5 transition py-1 px-1" title="Página de Acessibilidade">
                    Acessibilidade
                </a>
                <span class="text-blue-700">|</span>
                <button id="btn-contrast" type="button" aria-label="Alternar modo alto contraste" aria-pressed="false" class="hover:text-yellow-400 font-bold flex items-center gap-1 transition py-1 px-1" title="Alto Contraste">
                    <svg class="w-3.5 h-3.5" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M12 2a10 10 0 100 20 10 10 0 000-20zM12 20a8 8 0 110-16 8 8 0 010 16zm0-14v12a6 6 0 100-12z" />
                    </svg>
                    Contraste
                </button>
                <button id="btn-decrease-font" class="hover:text-yellow-400 font-bold px-1 transition py-1" title="Diminuir Fonte">A-</button>
                <button id="btn-increase-font" class="hover:text-yellow-400 font-bold px-1 transition py-1" title="Aumentar Fonte">A+</button>
            </div>

            <a href="https://transparencia.betha.cloud/#/yyGw8hIiYdv6bs-avrzVUg==" target="_blank" class="transition hover:text-yellow-400">Portal da Transparência</a>
            <a href="https://leismunicipais.com.br/prefeitura/pr/assai" target="_blank" class="transition hover:text-yellow-400">Leis Municipais</a>
            <a href="https://transparencia.betha.cloud/#/yyGw8hIiYdv6bs-avrzVUg==/consulta/95802" target="_blank" class="transition hover:text-yellow-400">Licitações</a>
            <a href="https://www.doemunicipal.com.br/prefeituras/4" target="_blank" class="transition hover:text-yellow-400">Diário Oficial</a>
            <a href="https://assai.atende.net/subportal/ouvidoria" target="_blank" class="transition hover:text-yellow-400">Ouvidoria</a>
            <a href="https://e-gov.betha.com.br/e-nota/login.faces" target="_blank" class="transition hover:text-yellow-400">E-SIC</a>
        </div>
    </div>

    <div class="container flex items-center justify-between px-4 py-4 mx-auto">
        <a href="{{ route('home') }}" class="flex items-center shrink-0">
            <img src="{{ asset('img/logo_preta.png') }}" alt="Prefeitura de Assaí" class="h-10 md:h-14 w-auto object-contain">
        </a>

        <nav accesskey="2" tabindex="-1" aria-label="Navegação Principal" class="items-center hidden gap-4 lg:gap-5 font-medium text-gray-700 md:flex font-sans focus:outline-none">
            <a href="{{ route('home') }}" class="transition hover:text-blue-600">Início</a>
            <a href="{{ route('servicos.index') }}" class="px-4 py-2 text-sm font-bold text-white bg-blue-600 rounded-xl hover:bg-blue-700 shadow-sm transition-colors">Serviços</a>

            {{-- Dropdown: A Cidade --}}
            <div class="relative group">
                <button class="flex items-center gap-1 font-medium text-gray-700 hover:text-blue-600 transition">
                    A Cidade
                    <svg class="w-4 h-4 mt-px text-gray-400 group-hover:text-blue-500 transition" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                    </svg>
                </button>
                <div class="absolute left-0 top-full mt-2 w-52 bg-white border border-slate-100 rounded-xl shadow-lg opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all duration-200 z-50 py-1.5">
                    <a href="{{ route('pages.sobre') }}" class="flex items-center gap-2.5 px-4 py-2.5 text-sm text-slate-600 hover:bg-blue-50 hover:text-blue-700 transition">
                        <svg class="w-4 h-4 shrink-0 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                        História e Perfil
                    </a>
                    <a href="{{ route('pages.turismo') }}" class="flex items-center gap-2.5 px-4 py-2.5 text-sm text-slate-600 hover:bg-blue-50 hover:text-blue-700 transition">
                        <svg class="w-4 h-4 shrink-0 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 9l9-7 9 7v11a2 2 0 01-2 2H5a2 2 0 01-2-2z"/>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 22V12h6v10"/>
                        </svg>
                        Turismo
                    </a>
                </div>
            </div>

            <a href="{{ route('secretarias.index') }}" class="transition hover:text-blue-600">Secretarias</a>
            <a href="{{ route('noticias.index') }}" class="transition hover:text-blue-600">Notícias</a>
            <a href="{{ route('agenda.index') }}" class="transition hover:text-blue-600">Agenda</a>
            <a href="{{ route('programas.index') }}" class="transition hover:text-blue-600">Programas</a>

            <a href="{{ route('pages.transparencia') }}" class="flex items-center gap-1.5 text-sm font-bold text-emerald-600 hover:text-emerald-700 transition-colors">
                <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
                Transparência
            </a>

            <a href="{{ route('contato.index') }}" class="transition hover:text-blue-600">Contato</a>

            <a href="https://gov.assai.pr.gov.br/" target="_blank" class="px-5 py-2.5 text-sm font-bold text-blue-900 transition border-2 border-blue-900 rounded-lg hover:bg-yellow-500 hover:border-yellow-500 font-sans shadow-sm">
                Entrar com gov.assai
            </a>
        </nav>

        <button id="mobile-menu-button" class="p-2 text-blue-900 transition rounded-lg md:hidden hover:bg-blue-50 focus:outline-none">
            <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
            </svg>
        </button>
    </div>

    <div id="mobile-menu" class="absolute hidden w-full z-50 bg-white border-t border-gray-100 shadow-2xl md:hidden">
        <nav class="flex flex-col gap-1 px-4 pt-2 pb-6 font-sans">
            <a href="{{ route('home') }}" class="block px-3 py-3 text-base font-medium text-gray-700 rounded-md hover:text-blue-900 hover:bg-blue-50">Início</a>
            <a href="{{ route('servicos.index') }}" class="flex items-center justify-center px-3 py-3 text-base font-bold text-white bg-blue-600 rounded-md hover:bg-blue-700 transition-colors">Serviços ao Cidadão</a>

            {{-- Acordeão: A Cidade --}}
            <div>
                <button id="btn-cidade-mobile"
                        class="flex items-center justify-between w-full px-3 py-3 text-base font-medium text-gray-700 rounded-md hover:text-blue-900 hover:bg-blue-50 transition">
                    A Cidade
                    <svg id="icon-cidade-mobile" class="w-4 h-4 text-gray-400 transition-transform duration-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                    </svg>
                </button>
                <div id="submenu-cidade-mobile" class="hidden pl-4 border-l-2 border-blue-100 ml-3 mt-0.5 mb-1 space-y-0.5">
                    <a href="{{ route('pages.sobre') }}" class="block pl-4 py-2 text-sm text-slate-500 rounded-md hover:text-blue-700 hover:bg-blue-50 transition">História e Perfil</a>
                    <a href="{{ route('pages.turismo') }}" class="block pl-4 py-2 text-sm text-slate-500 rounded-md hover:text-blue-700 hover:bg-blue-50 transition">Turismo</a>
                </div>
            </div>

            <a href="{{ route('secretarias.index') }}" class="block px-3 py-3 text-base font-medium text-gray-700 rounded-md hover:text-blue-900 hover:bg-blue-50">Secretarias</a>
            <a href="{{ route('noticias.index') }}" class="block px-3 py-3 text-base font-medium text-gray-700 rounded-md hover:text-blue-900 hover:bg-blue-50">Notícias</a>
            <a href="{{ route('agenda.index') }}" class="block px-3 py-3 text-base font-medium text-gray-700 rounded-md hover:text-blue-900 hover:bg-blue-50">Agenda</a>
            <a href="{{ route('programas.index') }}" class="block px-3 py-3 text-base font-medium text-gray-700 rounded-md hover:text-blue-900 hover:bg-blue-50">Programas</a>
            <a href="{{ route('contato.index') }}" class="block px-3 py-3 text-base font-medium text-gray-700 rounded-md hover:text-blue-900 hover:bg-blue-50">Contato</a>

            <a href="{{ route('pages.transparencia') }}" class="flex items-center justify-center gap-2 w-full px-4 py-3 mt-1 text-sm font-bold text-emerald-600 border border-emerald-200 bg-emerald-50 rounded-xl hover:bg-emerald-100 transition-colors">
                <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
                Transparência
            </a>

            <div class="pt-3 mt-2 border-t border-gray-100 grid grid-cols-2 gap-2">
                <a href="https://transparencia.betha.cloud/#/yyGw8hIiYdv6bs-avrzVUg==" class="px-3 py-2 text-xs font-bold text-blue-600 rounded-md bg-blue-50">Transparência</a>
                <a href="https://leismunicipais.com.br/prefeitura/pr/assai" target="_blank" class="px-3 py-2 text-xs font-medium text-slate-600 rounded-md bg-slate-50 hover:bg-slate-100 transition-colors">Leis Municipais</a>
                <a href="https://transparencia.betha.cloud/#/yyGw8hIiYdv6bs-avrzVUg==/consulta/95802" target="_blank" class="px-3 py-2 text-xs font-medium text-slate-600 rounded-md bg-slate-50 hover:bg-slate-100 transition-colors">Licitações</a>
                <a href="https://www.doemunicipal.com.br/prefeituras/4" target="_blank" class="px-3 py-2 text-xs font-medium text-slate-600 rounded-md bg-slate-50 hover:bg-slate-100 transition-colors">Diário Oficial</a>
                <a href="https://assai.atende.net/subportal/ouvidoria" target="_blank" class="px-3 py-2 text-xs font-medium text-slate-600 rounded-md bg-slate-50 hover:bg-slate-100 transition-colors">Ouvidoria</a>
                <a href="https://e-gov.betha.com.br/e-nota/login.faces" target="_blank" class="px-3 py-2 text-xs font-medium text-slate-600 rounded-md bg-slate-50 hover:bg-slate-100 transition-colors">E-SIC</a>
            </div>

            <a href="https://gov.assai.pr.gov.br/" target="_blank" class="w-full px-4 py-3 mt-4 font-bold text-center text-blue-900 transition border-2 border-blue-900 rounded-lg hover:bg-yellow-500 hover:border-yellow-500 block">
                Entrar com gov.assai
            </a>
        </nav>
    </div>
</header>

<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" />

@if(isset($alertasAtivos) && $alertasAtivos->count() > 0)
<div class="relative z-40 overflow-hidden bg-red-600 border-b border-red-700 shadow-md">
    <div class="container mx-auto swiper swiper-alertas">
        <div class="swiper-wrapper">

            @foreach($alertasAtivos as $alerta)
            <div class="swiper-slide">
                <div class="flex flex-col items-center justify-center w-full h-full gap-3 px-4 font-sans text-white sm:flex-row">

                    <span class="flex items-center gap-1 px-2.5 py-1 text-xs font-bold tracking-wide uppercase bg-red-800 rounded-md shrink-0">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
                        </svg>
                        {{ $alerta->titulo }}
                    </span>

                    <span class="text-sm font-medium text-center break-words sm:line-clamp-1">{{ $alerta->mensagem }}</span>

                    @if($alerta->link)
                    <a href="{{ $alerta->link }}" target="_blank" class="text-sm font-bold underline text-center hover:text-red-200 transition">
                        Saiba mais >
                    </a>
                    @endif

                </div>
            </div>
            @endforeach

        </div>
    </div>
</div>

@endif