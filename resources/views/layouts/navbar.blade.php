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
@endphp

{{--
    Configuração dos widgets Alpine.js via data-attributes.
    Os arquivos widgets.js e navbar.js lêem estas URLs em vez de
    depender de Blade inline, permitindo que funcionem corretamente
    tanto quando incluídos via @include direto quanto via app.blade.php.
--}}
<div id="portal-config" class="hidden"
    data-weather-url="{{ route('api.clima.atual') }}"
    data-duty-url="{{ route('api.plantao.hoje') }}"
    data-is-home="{{ $isHome ? 'true' : 'false' }}"
    data-logo-white="{{ asset('img/logo_branca.png') }}"
    data-logo-black="{{ asset('img/logo_preta.png') }}"></div>


{{-- Define as classes iniciais da header baseado se é Home ou Interna --}}
<header class="fixed top-0 left-0 right-0 z-[60] w-full transition-all duration-300 font-sans {{ $isHome ? 'bg-white/95 backdrop-blur-md shadow-sm text-slate-700 border-slate-200/50 lg:bg-transparent lg:backdrop-blur-none lg:shadow-none lg:text-white lg:border-transparent' : 'bg-white/95 backdrop-blur-md shadow-sm text-slate-700 border-slate-200/50' }}" id="site-header">

    {{-- TOP BAR (Sólida e Centralizada com o Container) --}}
    <div class="hidden lg:block bg-blue-900 border-b border-white/10 transition-colors duration-300">
        <div id="top-bar" class="container mx-auto flex items-center justify-center px-4 sm:px-6 py-2.5 text-xs text-white font-sans">
            <div class="flex items-center justify-center flex-wrap gap-3 text-white">
                <a href="{{ route('pages.acessibilidade') }}" class="font-bold hover:text-yellow-400 transition-colors">Acessibilidade</a>
                <span class="text-white/20">|</span>
                <button type="button" class="btn-contrast font-bold hover:text-yellow-400 transition-colors flex items-center gap-1.5">
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z"></path>
                    </svg>
                    Contraste
                </button>
                <button type="button" class="btn-decrease-font hover:text-yellow-400 transition-colors font-bold px-1">A-</button>
                <button type="button" class="btn-increase-font hover:text-yellow-400 transition-colors font-bold px-1">A+</button>
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
        <nav class="hidden lg:flex items-center lg:gap-3 xl:gap-5 text-base font-medium transition-colors duration-300">

            <a href="{{ route('home') }}" class="transition-opacity hover:opacity-75 py-1 {{ request()->routeIs('home') ? 'border-b-2 border-yellow-400' : '' }}">
                Início
            </a>

            <div class="relative group py-2">
                <button class="flex items-center gap-1 transition-opacity hover:opacity-75 py-1 {{ request()->routeIs('pages.sobre') || request()->routeIs('pages.turismo') ? 'border-b-2 border-yellow-400' : '' }}">
                    A Cidade
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M19 9l-7 7-7-7"></path>
                    </svg>
                </button>
                <div class="absolute left-0 top-full mt-0 w-52 bg-white/95 backdrop-blur-md rounded-xl shadow-lg opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all duration-200 border border-slate-200/60 overflow-hidden text-slate-700">
                    <a href="{{ route('pages.sobre') }}" class="block px-4 py-3 text-[13px] font-medium hover:bg-blue-50 hover:text-blue-700 border-b border-slate-100">História e Perfil</a>
                    <a href="{{ route('pages.turismo') }}" class="block px-4 py-3 text-[13px] font-medium hover:bg-blue-50 hover:text-blue-700">Turismo</a>
                </div>
            </div>

            <div class="relative group py-2">
                <button class="flex items-center gap-1 transition-opacity hover:opacity-75 py-1 {{ request()->routeIs('secretarias.*') ? 'border-b-2 border-yellow-400' : '' }}">
                    Secretarias
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M19 9l-7 7-7-7"></path>
                    </svg>
                </button>
                <div class="absolute left-0 top-full mt-0 w-[34rem] max-w-[90vw] bg-white/95 backdrop-blur-md rounded-xl shadow-lg opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all duration-200 border border-slate-200/60 max-h-96 overflow-y-auto [&::-webkit-scrollbar]:w-1.5 [&::-webkit-scrollbar-track]:bg-transparent [&::-webkit-scrollbar-thumb]:bg-slate-300 [&::-webkit-scrollbar-thumb]:rounded-full text-slate-700">
                    <a href="{{ route('secretarias.index') }}" class="block px-4 py-3 bg-slate-50/80 text-[13px] text-blue-900 font-medium border-b border-slate-200 hover:bg-blue-100/80">Todas</a>

                    @foreach($navSecretarias as $sec)
                    <a href="{{ route('secretarias.show', $sec->id) }}" class="block px-4 py-2.5 text-[13px] font-medium hover:bg-blue-50 hover:text-blue-700 border-b border-slate-100 last:border-0 transition-colors whitespace-nowrap" title="{{ $sec->nome_menu }}">
                        {{ $sec->nome_menu }}
                    </a>
                    @endforeach
                </div>
            </div>

            <a href="https://www.govfacilcidadao.com.br/login" target="_blank" rel="noopener noreferrer" class="transition-opacity hover:opacity-75">
                Ouvidoria
            </a>

            <a href="{{ route('pages.transparencia') }}" target="_blank" rel="noopener noreferrer"
                class="ml-1 flex items-center gap-2 px-4 py-2 bg-emerald-600 text-white rounded-full hover:bg-emerald-500 transition-colors font-medium text-sm shadow border border-transparent">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path>
                </svg>
                Transparência
            </a>

            <a href="https://gov.assai.pr.gov.br/cpf-check"
                target="_blank"
                rel="noopener noreferrer"
                class="ml-3 px-5 py-2 rounded-lg flex items-center font-medium text-white bg-blue-900 hover:bg-yellow-400 hover:text-blue-950 shadow hover:shadow-md transition-all duration-300 group outline-none focus-visible:ring-2 focus-visible:ring-blue-900">
                    Entrar no Gov.Assai
                <svg class="w-4 h-4 ml-1.5 transition-transform duration-300 group-hover:translate-x-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M13 7l5 5m0 0l-5 5m5-5H6"></path>
                </svg>
            </a>
        </nav>
    </div>

    {{-- Dropdown Mobile (padronizado com a Home) --}}
    <aside id="mobile-drawer-nav" class="lg:hidden absolute top-full left-0 right-0 bg-white shadow-[0_10px_22px_rgba(15,23,42,0.12)] border-t border-slate-100 overflow-hidden opacity-0 invisible pointer-events-none transition-all duration-150" aria-hidden="true" aria-label="Menu principal mobile">
        <nav class="max-h-[72vh] overflow-y-auto px-4 pb-3" aria-label="Links principais">
            <ul class="list-none m-0 p-0 flex flex-col">
                <li><a class="flex items-center justify-between w-full text-slate-700 text-[1.08rem] leading-tight font-normal py-4 border-b border-slate-100" href="{{ route('home') }}">Início</a></li>

                <li class="mobile-nav-group">
                    <button type="button" class="mobile-nav-toggle flex items-center justify-between w-full text-slate-700 text-[1.08rem] leading-tight font-normal py-4 border-b border-slate-100 text-left" data-submenu-target="mobile-submenu-cidade" aria-expanded="false">
                        <span>A Cidade</span>
                        <i class="fa-solid fa-chevron-down caret text-slate-500 text-sm transition-transform duration-200" aria-hidden="true"></i>
                    </button>
                    <ul id="mobile-submenu-cidade" class="mobile-submenu hidden list-none m-0 pb-2 border-b border-slate-100 max-h-60 overflow-y-auto">
                        <li><a class="block text-slate-600 text-sm py-2 pl-2" href="{{ route('pages.sobre') }}">História e Perfil</a></li>
                        <li><a class="block text-slate-600 text-sm py-2 pl-2" href="{{ route('pages.turismo') }}">Turismo</a></li>
                    </ul>
                </li>

                <li class="mobile-nav-group">
                    <button type="button" class="mobile-nav-toggle flex items-center justify-between w-full text-slate-700 text-[1.08rem] leading-tight font-normal py-4 border-b border-slate-100 text-left" data-submenu-target="mobile-submenu-secretarias" aria-expanded="false">
                        <span>Secretarias</span>
                        <i class="fa-solid fa-chevron-down caret text-slate-500 text-sm transition-transform duration-200" aria-hidden="true"></i>
                    </button>
                    <ul id="mobile-submenu-secretarias" class="mobile-submenu hidden list-none m-0 pb-2 border-b border-slate-100 max-h-64 overflow-y-auto">
                        <li><a class="block text-slate-600 text-sm py-2 pl-2" href="{{ route('secretarias.index') }}">Todas as Secretarias</a></li>
                        @foreach($navSecretarias as $sec)
                        <li>
                            <a class="block text-slate-600 text-sm py-2 pl-2" href="{{ route('secretarias.show', $sec->id) }}" title="{{ $sec->nome_menu }}">
                                {{ $sec->nome_menu }}
                            </a>
                        </li>
                        @endforeach
                    </ul>
                </li>

                <li><a class="flex items-center justify-between w-full text-slate-700 text-[1.08rem] leading-tight font-normal py-4 border-b border-slate-100" href="https://www.govfacilcidadao.com.br/login" target="_blank" rel="noopener noreferrer">Ouvidoria</a></li>
                <li><a class="flex items-center justify-between w-full text-slate-700 text-[1.08rem] leading-tight font-normal py-4 border-b border-slate-100" href="{{ route('pages.transparencia') }}" target="_blank" rel="noopener noreferrer">Transparência</a></li>
                <li class="pt-3">
                    <a href="https://gov.assai.pr.gov.br/cpf-check"
                        target="_blank"
                        rel="noopener noreferrer"
                        class="flex items-center justify-center gap-2 w-full px-4 py-3 rounded-xl bg-blue-900 hover:bg-blue-800 text-white font-semibold shadow-md transition-all active:scale-95">
                        <span>Entrar no Gov.Assaí</span>
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M13 7l5 5m0 0l-5 5m5-5H6"></path>
                        </svg>
                    </a>
                </li>
            </ul>

            <div class="mt-4 grid grid-cols-1 gap-3">
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