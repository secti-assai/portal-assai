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

// Helper: retorna URL da secretaria pelo nome parcial, ou /em-desenvolvimento
$secUrl = function(string $partial) use ($navSecretarias): string {
    foreach ($navSecretarias as $sec) {
        if (mb_stripos($sec->nome, $partial) !== false) {
            return route('secretarias.show', $sec->id);
        }
    }
    return route('em-desenvolvimento');
};

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

        {{-- Linha 1: Acessibilidade, Contraste, Fonte, Clima, Data --}}
        <div class="container mx-auto flex items-center justify-center px-4 sm:px-6 py-2 text-xs text-white font-sans relative z-[60] border-b border-white/10">
            <div class="flex items-center justify-center flex-wrap gap-3 text-white">

                <a href="{{ route('pages.acessibilidade') }}" class="font-bold hover:text-yellow-400 no-color-transition">Acessibilidade</a>
                <span class="text-white/20">|</span>

                <button type="button" class="btn-contrast font-bold hover:text-yellow-400 no-color-transition flex items-center gap-1.5">
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z"></path>
                    </svg>
                    Contraste
                </button>
                <span class="text-white/20">|</span>

                <span class="font-bold">Tamanho da Fonte:</span>
                <button type="button" class="btn-decrease-font hover:text-yellow-400 no-color-transition font-bold px-1" aria-label="Diminuir fonte">A-</button>
                <button type="button" class="btn-increase-font hover:text-yellow-400 no-color-transition font-bold px-1" aria-label="Aumentar fonte">A+</button>
                <span class="text-white/20">|</span>

                {{-- Clima --}}
                <div x-data="weatherWidget()" x-init="init()" class="flex items-center text-white" aria-live="polite">
                    <template x-if="loading">
                        <span class="text-xs font-medium text-white">Clima...</span>
                    </template>
                    <template x-if="error && !loading">
                        <span class="text-xs font-medium text-white">Clima indisponível</span>
                    </template>
                    <template x-if="!loading && !error">
                        <div class="flex items-center gap-2">
                            <i :class="weatherIconClass" class="text-yellow-300 drop-shadow-sm text-sm"></i>
                            <span class="font-semibold" x-text="weatherLabel"></span>
                            <span class="text-white/30">·</span>
                            <span class="font-semibold" x-text="formatNumber(temperature) + '°C'"></span>
                        </div>
                    </template>
                </div>
                <span class="text-white/20">|</span>

                {{-- Data por extenso --}}
                <span class="font-medium" x-data="{ dataExtenso: '' }" x-init="
                    const dias = ['Domingo','Segunda-feira','Terça-feira','Quarta-feira','Quinta-feira','Sexta-feira','Sábado'];
                    const meses = ['janeiro','fevereiro','março','abril','maio','junho','julho','agosto','setembro','outubro','novembro','dezembro'];
                    const now = new Date();
                    dataExtenso = dias[now.getDay()] + ', ' + now.getDate() + ' de ' + meses[now.getMonth()] + ' de ' + now.getFullYear();
                " x-text="dataExtenso" aria-live="polite"></span>

            </div>
        </div>

        {{-- Linha 2: Navegar como + Tradução --}}
        <div id="top-bar" class="container mx-auto flex items-center justify-center px-4 sm:px-6 py-1.5 text-xs text-white font-sans relative z-[60]">
            <div class="flex items-center justify-center flex-wrap gap-3 text-white">

                {{-- SELETOR DE PERFIL (DESKTOP) --}}
                <div x-data="{ menuPerfil: false }" class="relative flex items-center">
                    <span class="mr-2 text-white font-medium drop-shadow-sm">Navegar como:</span>
                    <button @click="menuPerfil = !menuPerfil" @click.away="menuPerfil = false" type="button" class="flex items-center gap-1.5 font-extrabold text-[#0f172a] hover:text-[#0f172a] bg-yellow-400 hover:bg-yellow-500 px-3 py-1 rounded-md border border-yellow-300 shadow-sm transition-all focus:outline-none focus:ring-2 focus:ring-white">
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

                {{-- Tradução --}}
                <div class="flex items-center shrink-0 gap-1.5">
                    <span class="font-medium">Tradução:</span>
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
        <nav class="hidden lg:flex items-center lg:gap-2.5 xl:gap-4 text-sm xl:text-base font-medium transition-colors duration-300" id="menu-principal">

            {{-- Início --}}
            <a href="{{ route('home') }}" class="py-1 no-color-transition hover:text-yellow-400 {{ request()->routeIs('home') ? 'border-b-2 border-yellow-400' : '' }}">Início</a>

            {{-- Cidade --}}
            <div class="relative group py-2">
                <button class="flex items-center gap-1 py-1 no-color-transition hover:text-yellow-400">
                    Cidade
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M19 9l-7 7-7-7"/></svg>
                </button>
                <div class="absolute left-0 top-full mt-0 w-52 bg-white/95 backdrop-blur-md rounded-xl shadow-lg opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all duration-200 border border-slate-200/60 overflow-hidden text-slate-700">
                    <a href="{{ route('cidade.nossa-cidade') }}"   class="block px-4 py-3 text-[13px] font-medium hover:bg-blue-50 hover:text-blue-700 border-b border-slate-100">Nossa Cidade</a>
                    <a href="{{ route('cidade.nossa-cultura') }}"  class="block px-4 py-3 text-[13px] font-medium hover:bg-blue-50 hover:text-blue-700 border-b border-slate-100">Nossa Cultura</a>
                    <a href="{{ route('cidade.galeria-fotos') }}"    class="block px-4 py-3 text-[13px] font-medium hover:bg-blue-50 hover:text-blue-700 border-b border-slate-100">Galeria de Fotos</a>
                    <a href="{{ route('agenda.index') }}"          class="block px-4 py-3 text-[13px] font-medium hover:bg-blue-50 hover:text-blue-700 border-b border-slate-100">Calendário</a>
                    <a href="{{ route('em-desenvolvimento') }}"    class="block px-4 py-3 text-[13px] font-medium hover:bg-blue-50 hover:text-blue-700">Método Assaiense</a>
                </div>
            </div>

            {{-- Governo --}}
            <div class="relative group py-2">
                <button class="flex items-center gap-1 py-1 no-color-transition hover:text-yellow-400 {{ request()->routeIs('secretarias.*') ? 'border-b-2 border-yellow-400' : '' }}">
                    Governo
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M19 9l-7 7-7-7"/></svg>
                </button>
                <div class="absolute left-0 top-full mt-0 w-72 bg-white/95 backdrop-blur-md rounded-xl shadow-lg opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all duration-200 border border-slate-200/60 overflow-y-auto text-slate-700" style="max-height:22rem;scrollbar-width:thin;scrollbar-color:#cbd5e1 transparent">
                    <a href="{{ route('secretarias.index') }}"                      class="block px-4 py-2.5 text-[13px] font-medium hover:bg-blue-50 hover:text-blue-700 border-b border-slate-100">Prefeito</a>
                    <a href="{{ $secUrl('Procuradoria') }}"                          class="block px-4 py-2.5 text-[13px] font-medium hover:bg-blue-50 hover:text-blue-700 border-b border-slate-100">Procuradoria-Geral do Município</a>
                    <a href="{{ $secUrl('Administração') }}"                         class="block px-4 py-2.5 text-[13px] font-medium hover:bg-blue-50 hover:text-blue-700 border-b border-slate-100">Administração e RH</a>
                    <a href="{{ $secUrl('Agricultura') }}"                           class="block px-4 py-2.5 text-[13px] font-medium hover:bg-blue-50 hover:text-blue-700 border-b border-slate-100">Agricultura, Abastecimento e Meio Ambiente</a>
                    <a href="{{ $secUrl('Assistência Social') }}"                    class="block px-4 py-2.5 text-[13px] font-medium hover:bg-blue-50 hover:text-blue-700 border-b border-slate-100">Assistência Social</a>
                    <a href="{{ $secUrl('Ciência') }}"                               class="block px-4 py-2.5 text-[13px] font-medium hover:bg-blue-50 hover:text-blue-700 border-b border-slate-100">Ciência, Tecnologia e Inovação</a>
                    <a href="{{ $secUrl('Cultura') }}"                               class="block px-4 py-2.5 text-[13px] font-medium hover:bg-blue-50 hover:text-blue-700 border-b border-slate-100">Cultura e Turismo</a>
                    <a href="{{ $secUrl('Educação') }}"                              class="block px-4 py-2.5 text-[13px] font-medium hover:bg-blue-50 hover:text-blue-700 border-b border-slate-100">Educação</a>
                    <a href="{{ $secUrl('Engenharia') }}"                            class="block px-4 py-2.5 text-[13px] font-medium hover:bg-blue-50 hover:text-blue-700 border-b border-slate-100">Engenharia e Planejamento Urbano</a>
                    <a href="{{ $secUrl('Esporte') }}"                               class="block px-4 py-2.5 text-[13px] font-medium hover:bg-blue-50 hover:text-blue-700 border-b border-slate-100">Esporte e Lazer</a>
                    <a href="{{ $secUrl('Finanças') }}"                              class="block px-4 py-2.5 text-[13px] font-medium hover:bg-blue-50 hover:text-blue-700 border-b border-slate-100">Finanças</a>
                    <a href="{{ $secUrl('Obras') }}"                                 class="block px-4 py-2.5 text-[13px] font-medium hover:bg-blue-50 hover:text-blue-700 border-b border-slate-100">Obras e Serviços Públicos</a>
                    <a href="{{ $secUrl('Saúde') }}"                                 class="block px-4 py-2.5 text-[13px] font-medium hover:bg-blue-50 hover:text-blue-700 border-b border-slate-100">Saúde</a>
                    <a href="{{ $secUrl('Segurança Alimentar') }}"                   class="block px-4 py-2.5 text-[13px] font-medium hover:bg-blue-50 hover:text-blue-700 border-b border-slate-100">Segurança Alimentar e Nutrição</a>
                    <a href="{{ $secUrl('Suprimentos') }}"                           class="block px-4 py-2.5 text-[13px] font-medium hover:bg-blue-50 hover:text-blue-700 border-b border-slate-100">Suprimentos</a>
                    <a href="{{ $secUrl('Trabalho') }}"                              class="block px-4 py-2.5 text-[13px] font-medium hover:bg-blue-50 hover:text-blue-700">Trabalho e Renda</a>
                </div>
            </div>

            {{-- Ouvidoria --}}
            <a href="https://www.govfacilcidadao.com.br/login" class="py-1 no-color-transition hover:text-yellow-400">Ouvidoria</a>

            {{-- Transparência --}}
            <div class="relative group py-2">
                <button class="flex items-center gap-1 py-1.5 px-3 bg-emerald-600 hover:bg-emerald-500 text-white rounded-md font-bold shadow-sm transition-colors duration-300">
                    Transparência
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M19 9l-7 7-7-7"/></svg>
                </button>
                <div class="absolute right-0 top-full mt-0 w-64 bg-white/95 backdrop-blur-md rounded-xl shadow-lg opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all duration-200 border border-slate-200/60 overflow-hidden text-slate-700">
                    <a href="https://transparencia.betha.cloud/#/yyGw8hIiYdv6bs-avrzVUg==/acesso-informacao" class="flex items-center gap-3 px-4 py-3 text-[13px] font-medium hover:bg-blue-50 hover:text-blue-700 border-b border-slate-100">
                        <i class="fa-solid fa-circle-info w-4 text-center text-blue-500"></i> Acesso à Informação
                    </a>
                    <a href="{{ route('diarios.index') }}" class="flex items-center gap-3 px-4 py-3 text-[13px] font-medium hover:bg-indigo-50 hover:text-indigo-700 border-b border-slate-100">
                        <i class="fa-solid fa-book-open w-4 text-center text-indigo-500"></i> Diário Oficial
                    </a>
                    <a href="https://leis.org/prefeitura/pr/assai" target="_blank" rel="noopener noreferrer" class="flex items-center gap-3 px-4 py-3 text-[13px] font-medium hover:bg-amber-50 hover:text-amber-700 border-b border-slate-100">
                        <i class="fa-solid fa-scale-balanced w-4 text-center text-amber-500"></i> Leis Municipais
                    </a>
                    <a href="{{ route('decretos.index') }}" class="flex items-center gap-3 px-4 py-3 text-[13px] font-medium hover:bg-rose-50 hover:text-rose-700 border-b border-slate-100">
                        <i class="fa-solid fa-file-pen w-4 text-center text-rose-500"></i> Decretos Municipais
                    </a>
                    <a href="{{ route('portarias.index') }}" class="flex items-center gap-3 px-4 py-3 text-[13px] font-medium hover:bg-sky-50 hover:text-sky-700 border-b border-slate-100">
                        <i class="fa-solid fa-file-lines w-4 text-center text-sky-500"></i> Portarias
                    </a>
                    <a href="https://transparencia.betha.cloud/#/yyGw8hIiYdv6bs-avrzVUg==" target="_blank" rel="noopener noreferrer" class="flex items-center gap-3 px-4 py-3 text-[13px] font-medium hover:bg-emerald-50 hover:text-emerald-700">
                        <i class="fa-solid fa-magnifying-glass-chart w-4 text-center text-emerald-500"></i> Portal da Transparência
                    </a>
                </div>
            </div>

            {{-- Sou Assaiense --}}
            @if(session()->has('gov_user'))
            <div class="relative group py-2 lg:ml-1 xl:ml-2">
                <button class="px-4 xl:px-5 py-2 rounded-lg flex items-center gap-2 font-medium text-white bg-blue-900 hover:bg-blue-800 shadow hover:shadow-md transition-colors duration-300 outline-none text-xs xl:text-sm whitespace-nowrap">
                    <img src="{{ asset('img/gov.assai.png') }}" class="h-4 w-auto object-contain" alt="Gov.Assaí">
                    Olá, {{ explode(' ', session('gov_user.nome', 'Cidadão'))[0] }}
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M19 9l-7 7-7-7"/></svg>
                </button>
                <div class="absolute right-0 top-full mt-0 w-64 bg-white/95 backdrop-blur-md rounded-xl shadow-lg opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all duration-200 border border-slate-200/60 overflow-hidden text-slate-700">
                    <div class="p-4 border-b border-slate-100 bg-slate-50">
                        <p class="font-bold text-slate-800">{{ session('gov_user.nome') }}</p>
                        <p class="text-xs text-slate-500 mt-1">Nível: <span class="font-bold text-blue-600">{{ session('gov_user.nivel', 'Bronze') }}</span></p>
                        <p class="text-xs text-slate-500 mt-1">Girassóis: <span class="font-bold text-yellow-600"><i class="fa-solid fa-sun"></i> {{ session('gov_user.girassois', 0) }} pts</span></p>
                    </div>
                    <form action="{{ route('govassai.logout') }}" method="POST">
                        @csrf
                        <button type="submit" class="w-full text-left flex items-center gap-3 px-4 py-3 text-[13px] font-medium hover:bg-red-50 hover:text-red-700 text-slate-600">
                            <i class="fa-solid fa-arrow-right-from-bracket w-4 text-center"></i> Sair
                        </button>
                    </form>
                </div>
            </div>
            @else
            <button type="button" @click.prevent="$dispatch('open-modal-sou-assaiense')"
                class="lg:ml-1 xl:ml-2 px-4 xl:px-5 py-2 rounded-lg flex items-center font-medium text-white bg-blue-900 hover:bg-yellow-400 hover:text-blue-950 shadow hover:shadow-md transition-colors duration-300 group outline-none focus-visible:ring-2 focus-visible:ring-blue-900 text-xs xl:text-sm whitespace-nowrap">
                Sou Assaiense
                <svg class="w-4 h-4 ml-1.5 transition-transform duration-300 group-hover:translate-x-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M13 7l5 5m0 0l-5 5m5-5H6"/>
                </svg>
            </button>
            @endif
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
                            <li><a class="block text-slate-600 text-sm py-2.5 pl-3 border-l-2 border-transparent hover:border-yellow-500 hover:text-yellow-500 transition-colors" href="{{ route('cidade.galeria-fotos') }}">Galeria de Fotos</a></li>
                            <li><a class="block text-slate-600 text-sm py-2.5 pl-3 border-l-2 border-transparent hover:border-yellow-500 hover:text-yellow-500 transition-colors" href="{{ route('agenda.index') }}">Calendário</a></li>
                            <li><a class="block text-slate-600 text-sm py-2.5 pl-3 border-l-2 border-transparent hover:border-yellow-500 hover:text-yellow-500 transition-colors" href="{{ route('em-desenvolvimento') }}">Método Assaiense</a></li>
                        </ul>
                    </li>

                    {{-- Secretarias (Mobile) --}}
                    <li x-data="{ open: false }" class="border-b border-slate-100">
                        <button @click="open = !open" type="button" class="flex items-center justify-between w-full text-slate-700 text-[1.08rem] leading-tight font-normal py-4 px-2 text-left focus:outline-none hover:text-yellow-500 transition-colors">
                            <span>Governo</span>
                            <i class="fa-solid fa-chevron-down text-slate-500 text-sm transition-transform duration-200" :class="open ? 'rotate-180' : ''"></i>
                        </button>
                        <ul x-show="open" style="display: none;" class="list-none m-0 pb-3 pt-1 px-2 bg-slate-50/50 max-h-[40vh] overflow-y-auto rounded-b-lg">
                            <li><a class="block text-slate-600 text-sm py-2.5 pl-3 border-l-2 border-transparent hover:border-yellow-500 hover:text-yellow-500 transition-colors" href="{{ route('secretarias.index') }}">Prefeito</a></li>
                            <li><a class="block text-slate-600 text-sm py-2.5 pl-3 border-l-2 border-transparent hover:border-yellow-500 hover:text-yellow-500 transition-colors" href="{{ $secUrl('Procuradoria') }}">Procuradoria-Geral do Município</a></li>
                            <li><a class="block text-slate-600 text-sm py-2.5 pl-3 border-l-2 border-transparent hover:border-yellow-500 hover:text-yellow-500 transition-colors" href="{{ $secUrl('Administração') }}">Administração e RH</a></li>
                            <li><a class="block text-slate-600 text-sm py-2.5 pl-3 border-l-2 border-transparent hover:border-yellow-500 hover:text-yellow-500 transition-colors" href="{{ $secUrl('Agricultura') }}">Agricultura, Abastecimento e Meio Ambiente</a></li>
                            <li><a class="block text-slate-600 text-sm py-2.5 pl-3 border-l-2 border-transparent hover:border-yellow-500 hover:text-yellow-500 transition-colors" href="{{ $secUrl('Assistência Social') }}">Assistência Social</a></li>
                            <li><a class="block text-slate-600 text-sm py-2.5 pl-3 border-l-2 border-transparent hover:border-yellow-500 hover:text-yellow-500 transition-colors" href="{{ $secUrl('Ciência') }}">Ciência, Tecnologia e Inovação</a></li>
                            <li><a class="block text-slate-600 text-sm py-2.5 pl-3 border-l-2 border-transparent hover:border-yellow-500 hover:text-yellow-500 transition-colors" href="{{ $secUrl('Cultura') }}">Cultura e Turismo</a></li>
                            <li><a class="block text-slate-600 text-sm py-2.5 pl-3 border-l-2 border-transparent hover:border-yellow-500 hover:text-yellow-500 transition-colors" href="{{ $secUrl('Educação') }}">Educação</a></li>
                            <li><a class="block text-slate-600 text-sm py-2.5 pl-3 border-l-2 border-transparent hover:border-yellow-500 hover:text-yellow-500 transition-colors" href="{{ $secUrl('Engenharia') }}">Engenharia e Planejamento Urbano</a></li>
                            <li><a class="block text-slate-600 text-sm py-2.5 pl-3 border-l-2 border-transparent hover:border-yellow-500 hover:text-yellow-500 transition-colors" href="{{ $secUrl('Esporte') }}">Esporte e Lazer</a></li>
                            <li><a class="block text-slate-600 text-sm py-2.5 pl-3 border-l-2 border-transparent hover:border-yellow-500 hover:text-yellow-500 transition-colors" href="{{ $secUrl('Finanças') }}">Finanças</a></li>
                            <li><a class="block text-slate-600 text-sm py-2.5 pl-3 border-l-2 border-transparent hover:border-yellow-500 hover:text-yellow-500 transition-colors" href="{{ $secUrl('Obras') }}">Obras e Serviços Públicos</a></li>
                            <li><a class="block text-slate-600 text-sm py-2.5 pl-3 border-l-2 border-transparent hover:border-yellow-500 hover:text-yellow-500 transition-colors" href="{{ $secUrl('Saúde') }}">Saúde</a></li>
                            <li><a class="block text-slate-600 text-sm py-2.5 pl-3 border-l-2 border-transparent hover:border-yellow-500 hover:text-yellow-500 transition-colors" href="{{ $secUrl('Segurança Alimentar') }}">Segurança Alimentar e Nutrição</a></li>
                            <li><a class="block text-slate-600 text-sm py-2.5 pl-3 border-l-2 border-transparent hover:border-yellow-500 hover:text-yellow-500 transition-colors" href="{{ $secUrl('Suprimentos') }}">Suprimentos</a></li>
                            <li><a class="block text-slate-600 text-sm py-2.5 pl-3 border-l-2 border-transparent hover:border-yellow-500 hover:text-yellow-500 transition-colors" href="{{ $secUrl('Trabalho') }}">Trabalho e Renda</a></li>
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
                            <li><a class="flex items-center gap-2 text-slate-600 text-sm py-2.5 pl-3 border-l-2 border-transparent hover:border-blue-600 hover:text-blue-600 transition-colors" href="https://transparencia.betha.cloud/#/yyGw8hIiYdv6bs-avrzVUg==/acesso-informacao"><i class="fa-solid fa-circle-info w-4 text-center"></i> Acesso à Informação</a></li>
                            <li><a class="flex items-center gap-2 text-slate-600 text-sm py-2.5 pl-3 border-l-2 border-transparent hover:border-indigo-600 hover:text-indigo-600 transition-colors" href="{{ route('diarios.index') }}"><i class="fa-solid fa-book-open w-4 text-center"></i> Diário Oficial</a></li>
                            <li><a class="flex items-center gap-2 text-slate-600 text-sm py-2.5 pl-3 border-l-2 border-transparent hover:border-amber-600 hover:text-amber-600 transition-colors" href="https://leis.org/prefeitura/pr/assai" target="_blank" rel="noopener noreferrer"><i class="fa-solid fa-scale-balanced w-4 text-center"></i> Leis Municipais</a></li>
                            <li><a class="flex items-center gap-2 text-slate-600 text-sm py-2.5 pl-3 border-l-2 border-transparent hover:border-rose-500 hover:text-rose-600 transition-colors" href="{{ route('decretos.index') }}"><i class="fa-solid fa-file-pen w-4 text-center text-rose-500"></i> Decretos Municipais</a></li>
                            <li><a class="flex items-center gap-2 text-slate-600 text-sm py-2.5 pl-3 border-l-2 border-transparent hover:border-sky-500 hover:text-sky-600 transition-colors" href="{{ route('portarias.index') }}"><i class="fa-solid fa-file-lines w-4 text-center text-sky-500"></i> Portarias</a></li>
                            <li><a class="flex items-center gap-2 text-slate-600 text-sm py-2.5 pl-3 border-l-2 border-transparent hover:border-emerald-600 hover:text-emerald-600 transition-colors" href="https://transparencia.betha.cloud/#/yyGw8hIiYdv6bs-avrzVUg==" target="_blank" rel="noopener noreferrer"><i class="fa-solid fa-magnifying-glass-chart w-4 text-center"></i> Portal da Transparência</a></li>
                        </ul>
                    </li>



                    <li class="pt-4">
                        @if(session()->has('gov_user'))
                        <div x-data="{ openGov: false }">
                            <button type="button" @click="openGov = !openGov" class="flex flex-col w-full px-4 py-3 rounded-xl bg-blue-900 hover:bg-blue-800 text-white font-bold shadow-md transition-all">
                                <div class="flex items-center justify-between w-full">
                                    <div class="flex items-center gap-2">
                                        <img src="{{ asset('img/gov.assai.png') }}" class="h-4 w-auto object-contain" alt="Gov.Assaí">
                                        <span>Olá, {{ explode(' ', session('gov_user.nome', 'Cidadão'))[0] }}</span>
                                    </div>
                                    <i class="fa-solid fa-chevron-down text-sm transition-transform duration-200" :class="openGov ? 'rotate-180' : ''"></i>
                                </div>
                            </button>
                            <ul x-show="openGov" style="display: none;" class="list-none m-0 pb-3 pt-2 px-2 bg-slate-50/50 rounded-b-lg border border-t-0 border-blue-100">
                                <li class="px-3 py-2">
                                    <p class="text-xs text-slate-500">Nível: <span class="font-bold text-blue-600">{{ session('gov_user.nivel', 'Bronze') }}</span></p>
                                    <p class="text-xs text-slate-500 mt-1">Girassóis: <span class="font-bold text-yellow-600"><i class="fa-solid fa-sun"></i> {{ session('gov_user.girassois', 0) }} pts</span></p>
                                </li>
                                <li>
                                    <form action="{{ route('govassai.logout') }}" method="POST">
                                        @csrf
                                        <button type="submit" class="w-full text-left flex items-center gap-2 text-slate-600 text-sm py-2 pl-3 border-l-2 border-transparent hover:border-red-600 hover:text-red-600 transition-colors">
                                            <i class="fa-solid fa-arrow-right-from-bracket w-4 text-center"></i> Sair
                                        </button>
                                    </form>
                                </li>
                            </ul>
                        </div>
                        @else
                        <button type="button" @click="$dispatch('open-modal-sou-assaiense')"
                            class="flex items-center justify-center gap-2 w-full px-4 py-3.5 rounded-xl bg-blue-900 hover:bg-blue-800 text-yellow-400 font-bold shadow-md transition-all active:scale-95 border-0">
                            <span>Sou Assaiense</span>
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M13 7l5 5m0 0l-5 5m5-5H6"></path>
                            </svg>
                        </button>
                        @endif
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