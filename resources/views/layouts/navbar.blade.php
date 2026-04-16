@php
// Verifica se estamos na página inicial para aplicar o efeito transparente.
$isHome = request()->routeIs('home');

$navSecretarias = \App\Models\Secretaria::orderBy('nome')->get(['id', 'nome'])->map(function ($sec) {
    $sec->nome_curto = preg_replace('/^Secretaria(?:\s+Municipal)?\s+(?:de|da|do|das|dos)\s+/iu', '', $sec->nome) ?: $sec->nome;
    $nomeMenuBase = trim((string) $sec->nome_curto);

    if (in_array(mb_strtolower($nomeMenuBase), ['chefe de gabinete', 'procuradoria geral'], true)) {
        $sec->nome_menu = $nomeMenuBase;
    } else {
        $sec->nome_menu = 'Secretaria Municipal de ' . $nomeMenuBase;
    }
    return $sec;
});

$navLogoSrc = $isHome ? asset('img/logo_branca.png') : asset('img/logo_preta.png');

// Dados dos Perfis para Personalização
$perfis = [
    'todos' => 'Geral',
    'cidadao' => 'Cidadão',
    'empresario' => 'Empresário',
    'turista' => 'Turista',
    'servidor' => 'Servidor Público'
];
$perfilAtual = request()->cookie('portal_perfil', 'todos');
@endphp

{{-- Remove transição apenas para a propriedade color nos links simples do navbar --}}
<style>
    .no-color-transition {
        transition-property: background-color, border-color, text-decoration-color, fill, stroke, opacity, box-shadow, transform, filter, backdrop-filter;
        /* Exclui propositalmente 'color' para ser instantâneo */
    }
</style>

<div id="portal-config" class="hidden"
    data-weather-url="{{ route('api.clima.atual') }}"
    data-duty-url="{{ route('api.plantao.hoje') }}"
    data-is-home="{{ $isHome ? 'true' : 'false' }}"
    data-logo-white="{{ asset('img/logo_branca.png') }}"
    data-logo-black="{{ asset('img/logo_preta.png') }}"></div>

<header
    x-data="{ showNavbar: false }"
    x-init="window.addEventListener('DOMContentLoaded', () => { setTimeout(() => { showNavbar = true }, 350); });"
    x-show="showNavbar"
    x-cloak
    class="fixed top-0 left-0 right-0 z-[160] w-full transition-all duration-300 font-sans {{ $isHome ? 'bg-white/95 backdrop-blur-md shadow-sm text-slate-700 border-slate-200/50 lg:bg-transparent lg:backdrop-blur-none lg:shadow-none lg:text-white lg:border-transparent' : 'bg-white/95 backdrop-blur-md shadow-sm text-slate-700 border-slate-200/50' }}"
    id="site-header">

    {{-- TOP BAR --}}
    <div class="hidden lg:block bg-blue-900 border-b border-white/10 transition-colors duration-300">
        <div id="top-bar" class="container mx-auto flex items-center justify-center px-4 sm:px-6 py-2.5 text-xs text-white font-sans relative z-[60]">
            <div class="flex items-center justify-center flex-wrap gap-3 text-white">
                
                <a href="{{ route('pages.acessibilidade') }}" class="font-bold hover:text-yellow-400 no-color-transition">Acessibilidade</a>
                <span class="text-white/20">|</span>
                
                <button type="button" class="btn-contrast font-bold hover:text-yellow-400 no-color-transition flex items-center gap-1.5">
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z"></path>
                    </svg>
                    Contraste
                </button>
                <button type="button" class="btn-decrease-font hover:text-yellow-400 no-color-transition font-bold px-1">A-</button>
                <button type="button" class="btn-increase-font hover:text-yellow-400 no-color-transition font-bold px-1">A+</button>
                <span class="text-white/20">|</span>
                
                <div x-data="weatherWidget()" x-init="init()" class="flex items-center text-white" aria-live="polite">
                    <template x-if="loading">
                        <span class="text-xs font-medium text-white">Clima...</span>
                    </template>
                    <template x-if="error && !loading">
                        <span class="text-xs font-medium text-white">Clima indisponível</span>
                    </template>
                    <template x-if="!loading && !error">
                        <div class="flex items-center gap-2.5">
                            <i :class="weatherIconClass" class="text-yellow-300 drop-shadow-sm text-sm"></i>
                            <span class="text-xs font-semibold" x-text="weatherLabel"></span>
                            <span class="text-white/30">|</span>
                            <span class="text-xs font-semibold" x-text="formatNumber(temperature) + '°C'"></span>
                            <span class="hidden xl:inline text-xs text-white" x-text="'Chuva: ' + formatNumber(precipitation) + ' mm'"></span>
                            <span class="hidden xl:inline text-xs text-white" x-text="'Umid.: ' + formatNumber(humidity) + '%'"></span>
                            <span class="hidden 2xl:inline text-xs text-white" x-text="'Vento: ' + formatNumber(windSpeed) + ' km/h'"></span>
                        </div>
                    </template>
                </div>
                <span class="text-white/20">|</span>
                
                <div x-data="dutyWidget()" x-init="init()" class="flex items-center text-white" aria-live="polite">
                    <template x-if="loading">
                        <span class="text-xs font-medium text-white">Plantão de hoje...</span>
                    </template>
                    <template x-if="error && !loading">
                        <span class="text-xs font-medium text-white">Plantões de hoje: indisponivel</span>
                    </template>
                    <template x-if="!loading && !error && !hasDuty">
                        <span class="text-xs font-medium text-white" x-text="'Plantoes de hoje: ' + (message || 'Sem plantao hoje')"></span>
                    </template>
                    <template x-if="!loading && !error && hasDuty">
                        <div class="flex items-center gap-2.5">
                            <i class="fa-solid fa-kit-medical text-yellow-300 text-sm"></i>
                            <span class="text-xs font-semibold">Plantões de hoje:</span>
                            <span class="text-xs font-semibold" x-text="dutySummary"></span>
                        </div>
                    </template>
                </div>

                <span class="text-white/20">|</span>

                {{-- SELETOR DE PERFIL (DESKTOP) ALTO CONTRASTE --}}
                <div x-data="{ menuPerfil: false }" class="relative flex items-center">
                    <span class="mr-2 text-white font-medium drop-shadow-sm">Navegar como:</span>
                    <button @click="menuPerfil = !menuPerfil" @click.away="menuPerfil = false" type="button" class="flex items-center gap-1.5 font-extrabold text-[#0f172a] hover:text-[#0f172a] bg-yellow-400 hover:bg-yellow-500 px-3 py-1.5 rounded-md border border-yellow-300 shadow-sm transition-all focus:outline-none focus:ring-2 focus:ring-white">
                        <i class="fa-solid fa-user-circle text-sm opacity-80"></i>
                        <span class="tracking-wide">{{ $perfis[$perfilAtual] }}</span>
                        <i class="fa-solid fa-chevron-down text-[10px] transition-transform duration-200" :class="menuPerfil ? 'rotate-180' : ''"></i>
                    </button>

                    <div x-show="menuPerfil" x-transition x-cloak class="absolute top-full mt-2 right-0 w-52 bg-white rounded-lg shadow-xl border border-slate-200 overflow-hidden text-slate-700">
                        <div class="px-4 py-2 bg-slate-50 border-b border-slate-100">
                            <p class="text-[10px] font-extrabold text-slate-500 uppercase tracking-wider">Personalizar Portal</p>
                        </div>
                        <form action="{{ route('perfil.definir') }}" method="POST" class="flex flex-col">
                            @csrf
                            @foreach($perfis as $valor => $rotulo)
                                <button type="submit" name="perfil" value="{{ $valor }}" class="text-left px-4 py-2.5 text-[13px] hover:bg-slate-50 transition-colors flex items-center justify-between {{ $perfilAtual === $valor ? 'text-blue-700 bg-blue-50/50 font-bold border-l-4 border-blue-600' : 'border-l-4 border-transparent text-slate-600' }}">
                                    {{ $rotulo }}
                                    @if($perfilAtual === $valor) <i class="fa-solid fa-check text-blue-600 text-xs"></i> @endif
                                </button>
                            @endforeach
                        </form>
                    </div>
                </div>

                <span class="text-white/20">|</span>

                <div class="flex items-center shrink-0">
                    <x-google-translate />
                </div>
            </div>
        </div>
    </div>

    {{-- MAIN NAVBAR --}}
    <div class="w-full lg:container lg:mx-auto px-2 sm:px-4 lg:px-6 {{ $isHome ? 'py-0 lg:py-2.5' : 'py-2 lg:py-2.5' }} flex items-center justify-start lg:justify-between relative" id="nav-inner">

        {{-- Logo Dinâmica Baseada na Rota --}}
        <a href="{{ route('home') }}" style="background: transparent !important; box-shadow: none !important;" class="flex items-center shrink-0 relative ml-0 h-20 sm:h-20 lg:h-20 xl:h-20 w-auto focus:outline-none focus-visible:ring-2 focus-visible:ring-yellow-400 transition-transform hover:scale-[1.02]">
            <img id="nav-logo-img" src="{{ $navLogoSrc }}" alt="Prefeitura de Assaí" class="h-full w-auto object-contain transition-opacity duration-200 ease-out {{ $isHome ? 'translate-x-0' : 'translate-x-[6px]' }}">
        </a>

        {{-- Botão Mobile Hamburger --}}
        <button type="button" class="lg:hidden ml-auto inline-flex items-center gap-2 text-[#006eb7] font-extrabold text-base px-2 py-1" id="mobile-menu-trigger" aria-label="Abrir menu" aria-expanded="false" aria-controls="mobile-drawer-nav">
            <span>Menu</span>
            <i class="fa-solid fa-bars icon-open" aria-hidden="true"></i>
            <span class="icon-close hidden text-xl leading-none" aria-hidden="true">X</span>
        </button>

        {{-- Menu Desktop --}}
        <nav class="hidden lg:flex items-center lg:gap-2.5 xl:gap-4 text-sm xl:text-base font-medium transition-colors duration-300">

            {{-- Remoção da classe transition-colors e uso de no-color-transition --}}
            <a href="{{ route('home') }}" class="py-1 no-color-transition hover:text-yellow-400 {{ request()->routeIs('home') ? 'border-b-2 border-yellow-400' : '' }}">
                Início
            </a>

            <div class="relative group py-2">
                {{-- Manter no-color-transition nos elementos pai --}}
                <button class="flex items-center gap-1 py-1 no-color-transition hover:text-yellow-400 {{ request()->routeIs('pages.sobre') || request()->routeIs('pages.turismo') ? 'border-b-2 border-yellow-400' : '' }}">
                    Cidade
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M19 9l-7 7-7-7"></path>
                    </svg>
                </button>
                <div class="absolute left-0 top-full mt-0 w-52 bg-white/95 backdrop-blur-md rounded-xl shadow-lg opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all duration-200 border border-slate-200/60 overflow-hidden text-slate-700">
                    <a href="{{ route('cidade.nossa-cidade') }}" class="block px-4 py-3 text-[13px] font-medium hover:bg-blue-50 hover:text-blue-700 border-b border-slate-100">Nossa Cidade</a>
                    <a href="{{ route('cidade.nossa-cultura') }}" class="block px-4 py-3 text-[13px] font-medium hover:bg-blue-50 hover:text-blue-700 border-b border-slate-100">Nossa Cultura</a>
                    <a href="{{ route('cidade.demografia') }}" class="block px-4 py-3 text-[13px] font-medium hover:bg-blue-50 hover:text-blue-700 border-b border-slate-100">Demografia</a>
                    <a href="{{ route('cidade.historias-sucesso') }}" class="block px-4 py-3 text-[13px] font-medium hover:bg-blue-50 hover:text-blue-700 border-b border-slate-100">Histórias de Sucessos</a>
                    <a href="{{ route('cidade.qualidade-vida') }}" class="block px-4 py-3 text-[13px] font-medium hover:bg-blue-50 hover:text-blue-700">Qualidade de Vida</a>
                    <a href="{{ route('pages.turismo') }}" class="block px-4 py-3 text-[13px] font-medium hover:bg-blue-50 hover:text-blue-700">Turismo</a>
                </div>
            </div>

            <div class="relative group py-2">
                {{-- Manter no-color-transition nos elementos pai --}}
                <button class="flex items-center gap-1 py-1 no-color-transition hover:text-yellow-400 {{ request()->routeIs('secretarias.*') ? 'border-b-2 border-yellow-400' : '' }}">
                    Governo
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M19 9l-7 7-7-7"></path>
                    </svg>
                </button>
                <div class="absolute left-0 top-full mt-0 w-[34rem] max-w-[90vw] bg-white/95 backdrop-blur-md rounded-xl shadow-lg opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all duration-200 border border-slate-200/60 max-h-96 overflow-y-auto [&::-webkit-scrollbar]:w-1.5 [&::-webkit-scrollbar-track]:bg-transparent [&::-webkit-scrollbar-thumb]:bg-slate-300 [&::-webkit-scrollbar-thumb]:rounded-full text-slate-700">
                    <a href="{{ route('secretarias.index') }}" class="block px-4 py-3 bg-slate-50/80 text-[13px] text-blue-900 font-medium border-b border-slate-200 hover:bg-blue-100/80">Todas as Secretarias</a>

                    @foreach($navSecretarias as $sec)
                    <a href="{{ route('secretarias.show', $sec->id) }}" class="block px-4 py-2.5 text-[13px] font-medium hover:bg-blue-50 hover:text-blue-700 border-b border-slate-100 last:border-0 transition-colors whitespace-nowrap" title="{{ $sec->nome_menu }}">
                        {{ $sec->nome_menu }}
                    </a>
                    @endforeach
                </div>
            </div>

            {{-- Remoção da classe transition-colors e uso de no-color-transition --}}
            <a href="https://www.govfacilcidadao.com.br/login" class="py-1 no-color-transition hover:text-yellow-400">
                Ouvidoria
            </a>

            {{-- Dropdown Transparência & Diário Oficial (Desktop) --}}
            <div class="relative group lg:ml-1 py-2">
                <a href="{{ route('pages.transparencia') }}" class="flex items-center gap-1.5 px-3 xl:px-4 py-2 bg-emerald-600 text-white rounded-full hover:bg-emerald-500 no-color-transition font-medium text-xs xl:text-sm shadow border border-transparent focus:outline-none">
                    <svg class="w-3.5 h-3.5 xl:w-4 xl:h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path>
                    </svg>
                    Transparência
                    <svg class="w-3 h-3 xl:w-3.5 xl:h-3.5 ml-0.5 transition-transform duration-200 group-hover:rotate-180" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M19 9l-7 7-7-7"></path>
                    </svg>
                </a>

                <div class="absolute right-0 top-full mt-0 w-64 bg-white/95 backdrop-blur-md rounded-xl shadow-lg opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all duration-200 border border-slate-200/60 overflow-hidden text-slate-700 flex flex-col">
                    <a href="https://www.doemunicipal.com.br/prefeituras/4" target="_blank" rel="noopener noreferrer" class="flex items-center gap-3 px-4 py-3 text-sm font-medium hover:bg-indigo-50 hover:text-indigo-700 border-b border-slate-100 transition-colors">
                        <div class="flex items-center justify-center w-8 h-8 rounded-full bg-indigo-100 text-indigo-600 shrink-0">
                            <i class="fa-solid fa-book-open"></i>
                        </div>
                        Diário Oficial
                    </a>
                    <a href="https://transparencia.betha.cloud/#/yyGw8hIiYdv6bs-avrzVUg==" target="_blank" rel="noopener noreferrer" class="flex items-center gap-3 px-4 py-3 text-sm font-medium hover:bg-emerald-50 hover:text-emerald-700 border-b border-slate-100 transition-colors">
                        <div class="flex items-center justify-center w-8 h-8 rounded-full bg-emerald-100 text-emerald-600 shrink-0">
                            <i class="fa-solid fa-magnifying-glass-chart"></i>
                        </div>
                        Portal da Transparência
                    </a>

                    <a href="https://leis.org/prefeitura/pr/assai" target="_blank" rel="noopener noreferrer" class="flex items-center gap-3 px-4 py-3 text-sm font-medium hover:bg-amber-50 hover:text-amber-700 border-b border-slate-100 transition-colors">
                        <div class="flex items-center justify-center w-8 h-8 rounded-full bg-amber-100 text-amber-600 shrink-0">
                            <i class="fa-solid fa-scale-balanced"></i>
                        </div>
                        Leis Municipais
                    </a>

                    <a href="https://transparencia.betha.cloud/#/yyGw8hIiYdv6bs-avrzVUg==/consulta/95802" target="_blank" rel="noopener noreferrer" class="flex items-center gap-3 px-4 py-3 text-sm font-medium hover:bg-teal-50 hover:text-teal-700 transition-colors">
                        <div class="flex items-center justify-center w-8 h-8 rounded-full bg-teal-100 text-teal-600 shrink-0">
                            <i class="fa-solid fa-file-contract"></i>
                        </div>
                        Licitações
                    </a>
                </div>
            </div>

            {{-- Remoção da classe transition-colors e uso de no-color-transition --}}
            <a href="https://transparencia.betha.cloud/#/yyGw8hIiYdv6bs-avrzVUg==/acesso-informacao" class="py-1 no-color-transition hover:text-yellow-400">
                Acesso a Informação
            </a>

            <a href="https://gov.assai.pr.gov.br/cpf-check"
                target="_blank"
                rel="noopener noreferrer"
                class="lg:ml-1 xl:ml-3 px-4 xl:px-5 py-2 rounded-lg flex items-center font-medium text-white bg-blue-900 hover:bg-yellow-400 hover:text-blue-950 shadow hover:shadow-md no-color-transition duration-300 group outline-none focus-visible:ring-2 focus-visible:ring-blue-900 text-xs xl:text-sm whitespace-nowrap">
                Sou Assaiense
                <svg class="w-4 h-4 ml-1.5 transition-transform duration-300 group-hover:translate-x-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M13 7l5 5m0 0l-5 5m5-5H6"></path>
                </svg>
            </a>
        </nav>

        {{-- Drawer Mobile (Dropdown Overlay) --}}
        <aside id="mobile-drawer-nav" class="lg:hidden absolute top-full left-0 right-0 z-[160] w-full h-[calc(100vh-var(--site-header-height,70px))] md:h-auto md:max-h-[72vh] bg-white shadow-xl border-t border-slate-100 transition-all duration-300 transform -translate-y-2 opacity-0 pointer-events-none overflow-hidden" aria-hidden="true" aria-label="Menu principal mobile">

            <nav class="h-full overflow-y-auto px-4 pb-20 overscroll-contain" aria-label="Links principais">
                <ul class="list-none m-0 p-0 flex flex-col pt-3">

                    {{-- SELETOR DE PERFIL (MOBILE - DESTACADO) --}}
                    <li x-data="{ open: false }" class="border-b border-blue-100 bg-blue-50/80 rounded-xl mb-3 shadow-sm border">
                        <button @click="open = !open" type="button" class="flex items-center justify-between w-full text-slate-700 py-3 px-4 text-left focus:outline-none hover:text-blue-800 transition-colors rounded-xl">
                            <div class="flex items-center gap-3">
                                <div class="w-10 h-10 rounded-full bg-blue-600 flex items-center justify-center text-white shadow-inner">
                                    <i class="fa-solid fa-user text-lg"></i>
                                </div>
                                <div class="flex flex-col">
                                    <span class="text-[10px] uppercase text-blue-600 font-extrabold tracking-wider leading-none mb-1 mt-0.5">Perfil de Navegação</span>
                                    <span class="font-black text-blue-950 leading-none text-base">{{ $perfis[$perfilAtual] }}</span>
                                </div>
                            </div>
                            <div class="bg-blue-100/50 p-2 rounded-full flex items-center justify-center">
                                <i class="fa-solid fa-chevron-down text-blue-600 text-sm transition-transform duration-300" :class="open ? 'rotate-180' : ''"></i>
                            </div>
                        </button>
                        
                        <div x-show="open" style="display: none;" x-transition class="px-3 pb-3">
                            <form action="{{ route('perfil.definir') }}" method="POST" class="flex flex-col gap-1.5 pt-1 border-t border-blue-200/50">
                                @csrf
                                @foreach($perfis as $valor => $rotulo)
                                    <button type="submit" name="perfil" value="{{ $valor }}" class="flex items-center justify-between px-4 py-3 rounded-lg text-sm transition-all border {{ $perfilAtual === $valor ? 'text-blue-900 bg-white border-blue-400 font-extrabold shadow-sm ring-2 ring-blue-500/20' : 'text-slate-600 border-transparent bg-transparent hover:bg-white hover:border-slate-200' }}">
                                        <span>{{ $rotulo }}</span>
                                        @if($perfilAtual === $valor) <i class="fa-solid fa-circle-check text-blue-600 text-lg"></i> @endif
                                    </button>
                                @endforeach
                            </form>
                        </div>
                    </li>

                    <li><a class="flex items-center justify-between w-full text-slate-700 text-[1.08rem] leading-tight font-normal py-4 px-2 border-b border-slate-100 hover:text-yellow-500 transition-colors" href="{{ route('home') }}">Início</a></li>

                    {{-- A Cidade (Mobile) --}}
                    <li x-data="{ open: false }" class="border-b border-slate-100">
                        <button @click="open = !open" type="button" class="flex items-center justify-between w-full text-slate-700 text-[1.08rem] leading-tight font-normal py-4 px-2 text-left focus:outline-none hover:text-yellow-500 transition-colors">
                            <span>Cidade</span>
                            <i class="fa-solid fa-chevron-down text-slate-500 text-sm transition-transform duration-200" :class="open ? 'rotate-180' : ''"></i>
                        </button>
                        <ul x-show="open" style="display: none;" class="list-none m-0 pb-3 pt-1 px-2 bg-slate-50/50 rounded-b-lg">
                            <li><a class="block text-slate-600 text-sm py-2.5 pl-3 border-l-2 border-transparent hover:border-yellow-500 hover:text-yellow-500 transition-colors" href="{{ route('cidade.nossa-cidade') }}">Nossa Cidade</a></li>
                            <li><a class="block text-slate-600 text-sm py-2.5 pl-3 border-l-2 border-transparent hover:border-yellow-500 hover:text-yellow-500 transition-colors" href="{{ route('cidade.nossa-cultura') }}">Nossa Cultura</a></li>
                            <li><a class="block text-slate-600 text-sm py-2.5 pl-3 border-l-2 border-transparent hover:border-yellow-500 hover:text-yellow-500 transition-colors" href="{{ route('cidade.demografia') }}">Demografia</a></li>
                            <li><a class="block text-slate-600 text-sm py-2.5 pl-3 border-l-2 border-transparent hover:border-yellow-500 hover:text-yellow-500 transition-colors" href="{{ route('cidade.historias-sucesso') }}">Histórias de Sucessos</a></li>
                            <li><a class="block text-slate-600 text-sm py-2.5 pl-3 border-l-2 border-transparent hover:border-yellow-500 hover:text-yellow-500 transition-colors" href="{{ route('cidade.qualidade-vida') }}">Qualidade de Vida</a></li>
                            <li><a class="block text-slate-600 text-sm py-2.5 pl-3 border-l-2 border-transparent hover:border-yellow-500 hover:text-yellow-500 transition-colors" href="{{ route('pages.turismo') }}">Turismo</a></li>
                        </ul>
                    </li>

                    {{-- Secretarias (Mobile) --}}
                    <li x-data="{ open: false }" class="border-b border-slate-100">
                        <button @click="open = !open" type="button" class="flex items-center justify-between w-full text-slate-700 text-[1.08rem] leading-tight font-normal py-4 px-2 text-left focus:outline-none hover:text-yellow-500 transition-colors">
                            <span>Governo</span>
                            <i class="fa-solid fa-chevron-down text-slate-500 text-sm transition-transform duration-200" :class="open ? 'rotate-180' : ''"></i>
                        </button>
                        <ul x-show="open" style="display: none;" class="list-none m-0 pb-3 pt-1 px-2 bg-slate-50/50 max-h-[40vh] overflow-y-auto rounded-b-lg">
                            <li><a class="block text-blue-700 font-semibold text-sm py-2.5 pl-3 border-l-2 border-blue-600 mb-1 hover:text-yellow-500 hover:border-yellow-500 transition-colors" href="{{ route('secretarias.index') }}">Todas as Secretarias</a></li>
                            @foreach($navSecretarias as $sec)
                            <li>
                                <a class="block text-slate-600 text-sm py-2.5 pl-3 border-l-2 border-transparent hover:border-yellow-500 hover:text-yellow-500 transition-colors" href="{{ route('secretarias.show', $sec->id) }}" title="{{ $sec->nome_menu }}">
                                    {{ $sec->nome_menu }}
                                </a>
                            </li>
                            @endforeach
                        </ul>
                    </li>

                    <li><a class="flex items-center justify-between w-full text-slate-700 text-[1.08rem] leading-tight font-normal py-4 px-2 border-b border-slate-100 hover:text-yellow-500 transition-colors" href="https://www.govfacilcidadao.com.br/login">Ouvidoria</a></li>

                    {{-- Transparência (Mobile) --}}
                    <li x-data="{ open: false }" class="border-b border-slate-100">
                        <button @click="open = !open" type="button" class="flex items-center justify-between w-full text-slate-700 text-[1.08rem] leading-tight font-normal py-4 px-2 text-left focus:outline-none hover:text-emerald-600 transition-colors">
                            <div class="flex items-center gap-2">
                                <i class="fa-solid fa-magnifying-glass-chart text-emerald-600"></i>
                                <span class="font-bold text-emerald-700">Transparência</span>
                            </div>
                            <i class="fa-solid fa-chevron-down text-slate-500 text-sm transition-transform duration-200" :class="open ? 'rotate-180' : ''"></i>
                        </button>
                        <ul x-show="open" style="display: none;" class="list-none m-0 pb-3 pt-1 px-2 bg-slate-50/50 rounded-b-lg">
                            <li><a class="flex items-center gap-2 text-slate-600 text-sm py-2.5 pl-3 border-l-2 border-transparent hover:border-emerald-600 hover:text-emerald-600 transition-colors" href="https://www.doemunicipal.com.br/prefeituras/4" target="_blank" rel="noopener noreferrer"><i class="fa-solid fa-book-open w-4 text-center"></i> Diário Oficial</a></li>
                            <li><a class="flex items-center gap-2 text-slate-600 text-sm py-2.5 pl-3 border-l-2 border-transparent hover:border-emerald-600 hover:text-emerald-600 transition-colors" href="https://transparencia.betha.cloud/#/yyGw8hIiYdv6bs-avrzVUg=="><i class="fa-solid fa-magnifying-glass-chart w-4 text-center"></i> Portal da Transparência</a></li>
                            <li><a class="flex items-center gap-2 text-slate-600 text-sm py-2.5 pl-3 border-l-2 border-transparent hover:border-emerald-600 hover:text-emerald-600 transition-colors" href="https://leis.org/prefeitura/pr/assai" target="_blank" rel="noopener noreferrer"><i class="fa-solid fa-scale-balanced w-4 text-center"></i> Leis Municipais</a></li>
                            <li><a class="flex items-center gap-2 text-slate-600 text-sm py-2.5 pl-3 border-l-2 border-transparent hover:border-emerald-600 hover:text-emerald-600 transition-colors" href="https://transparencia.betha.cloud/#/yyGw8hIiYdv6bs-avrzVUg==/consulta/95802" target="_blank" rel="noopener noreferrer"><i class="fa-solid fa-file-contract w-4 text-center"></i> Licitações</a></li>
                        </ul>
                    </li>

                    <li><a class="flex items-center justify-between w-full text-slate-700 text-[1.08rem] leading-tight font-normal py-4 px-2 border-b border-slate-100 hover:text-yellow-500 transition-colors" href="https://transparencia.betha.cloud/#/yyGw8hIiYdv6bs-avrzVUg==/acesso-informacao">Acesso a Informação</a></li>

                    <li class="pt-4">
                        <a href="https://gov.assai.pr.gov.br/cpf-check"
                            target="_blank"
                            rel="noopener noreferrer"
                            class="flex items-center justify-center gap-2 w-full px-4 py-3.5 rounded-xl bg-blue-900 hover:bg-blue-800 text-yellow-400 font-bold shadow-md transition-all active:scale-95">
                            <span>Sou Assaiense</span>
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M13 7l5 5m0 0l-5 5m5-5H6"></path>
                            </svg>
                        </a>
                    </li>
                </ul>

                <div class="mt-4 rounded-2xl border border-slate-200 bg-slate-50/95 p-3 shadow-sm flex items-center justify-start gap-3 mx-1">
                    <span class="text-[11px] font-extrabold uppercase tracking-[0.16em] text-slate-500">Idioma</span>
                    <x-google-translate />
                </div>

                <div class="mt-4 mx-1 rounded-2xl border border-slate-200 bg-slate-50/95 p-3 shadow-sm" aria-label="Acessibilidade">
                    <p class="text-[11px] font-extrabold uppercase tracking-[0.16em] text-slate-500 mb-2">Acessibilidade</p>
                    <div class="flex items-center gap-2">
                        <button type="button" class="btn-contrast inline-flex items-center justify-center rounded-lg border border-slate-300 bg-white px-3 py-2 text-xs font-semibold text-slate-700">
                            Contraste
                        </button>
                        <button type="button" class="btn-decrease-font inline-flex items-center justify-center rounded-lg border border-slate-300 bg-white px-2.5 py-2 text-xs font-bold text-slate-700" aria-label="Diminuir fonte">A-</button>
                        <button type="button" class="btn-increase-font inline-flex items-center justify-center rounded-lg border border-slate-300 bg-white px-2.5 py-2 text-xs font-bold text-slate-700" aria-label="Aumentar fonte">A+</button>
                    </div>
                </div>

                <div class="mt-4 mx-1 grid grid-cols-1 gap-3">
                    <section x-data="weatherWidget()" x-init="init()" class="rounded-2xl border border-slate-200 bg-slate-50/95 p-4 shadow-sm text-slate-700">
                        <div class="flex items-start justify-between gap-3">
                            <div>
                                <p class="text-[11px] font-extrabold uppercase tracking-[0.16em] text-slate-500">Clima agora</p>
                                <template x-if="loading">
                                    <p class="mt-2 text-sm font-medium text-slate-500">Carregando previsão...</p>
                                </template>
                                <template x-if="error && !loading">
                                    <p class="mt-2 text-sm font-medium text-slate-500">Clima indisponível</p>
                                </template>
                                <template x-if="!loading && !error">
                                    <div class="mt-2 flex items-center gap-2">
                                        <span class="inline-flex h-8 w-8 items-center justify-center rounded-xl bg-white text-blue-700 border border-slate-200 shadow-sm">
                                            <i :class="weatherIconClass" class="text-base" aria-hidden="true"></i>
                                        </span>
                                        <div class="min-w-0">
                                            <p class="text-sm font-bold text-slate-800" x-text="weatherLabel"></p>
                                            <p class="text-xs text-slate-500"><span x-text="formatNumber(temperature) + '°C'"></span> • Umid. <span x-text="formatNumber(humidity) + '%'"></span></p>
                                        </div>
                                    </div>
                                </template>
                            </div>
                        </div>
                    </section>

                    <section x-data="dutyWidget()" x-init="init()" class="rounded-2xl border border-slate-200 bg-slate-50/95 p-4 shadow-sm text-slate-700">
                        <p class="text-[11px] font-extrabold uppercase tracking-[0.16em] text-slate-500">Plantão de hoje</p>
                        <template x-if="loading">
                            <p class="mt-2 text-sm font-medium text-slate-500">Carregando plantão...</p>
                        </template>
                        <template x-if="error && !loading">
                            <p class="mt-2 text-sm font-medium text-slate-500">Plantão indisponível</p>
                        </template>
                        <template x-if="!loading && !error && !hasDuty">
                            <p class="mt-2 text-sm font-medium text-slate-500" x-text="message || 'Sem plantão hoje'"></p>
                        </template>
                        <template x-if="!loading && !error && hasDuty">
                            <div class="mt-2 flex items-start gap-2">
                                <span class="inline-flex h-8 w-8 items-center justify-center rounded-xl bg-white text-blue-700 border border-slate-200 shadow-sm shrink-0">
                                    <i class="fa-solid fa-kit-medical text-base" aria-hidden="true"></i>
                                </span>
                                <div class="min-w-0">
                                    <p class="text-xs font-bold text-slate-500 leading-relaxed line-clamp-2" x-text="dutySummary"></p>
                                </div>
                            </div>
                        </template>
                    </section>
                </div>
            </nav>
        </aside>
</header>