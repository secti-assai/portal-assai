@php
// Verifica se estamos na página inicial para aplicar o efeito transparente.
// Ajuste 'home2' para o nome da rota da sua home oficial.
$isHome = request()->routeIs('home2') || request()->routeIs('home');

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
    data-logo-black="{{ asset('img/logo_preta.png') }}"
></div>


{{-- Define as classes iniciais da header baseado se é Home ou Interna --}}
<header class="fixed top-0 left-0 right-0 z-[60] w-full transition-all duration-300 font-sans {{ $isHome ? 'bg-transparent text-white border-transparent' : 'bg-white/95 backdrop-blur-md shadow-sm text-slate-700 border-slate-200/50' }}" id="site-header">

    {{-- TOP BAR (Sólida e Centralizada com o Container) --}}
    <div class="bg-blue-900 border-b border-white/10 transition-colors duration-300">
        <div id="top-bar" class="hidden lg:flex container mx-auto items-center justify-center px-4 sm:px-6 py-2.5 text-xs text-white font-sans">
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
    <div class="w-full lg:container lg:mx-auto px-2 sm:px-4 lg:px-6 py-2 lg:py-2.5 flex items-center justify-start lg:justify-between relative" id="nav-inner">

        {{-- Logo Dinâmica Baseada na Rota --}}
        <a href="{{ route('home2') }}" style="background: transparent !important; box-shadow: none !important;" class="flex items-center shrink-0 relative ml-0 h-20 sm:h-24 lg:h-20 xl:h-20 w-auto focus:outline-none focus-visible:ring-2 focus-visible:ring-yellow-400 transition-transform hover:scale-[1.02]">
            <img id="nav-logo-img" src="{{ $isHome ? asset('img/logo_branca.png') : asset('img/logo_preta.png') }}" alt="Prefeitura de Assaí" class="h-full w-auto object-contain transition-opacity duration-200 ease-out" style="transform: translateX({{ $isHome ? '0' : '6' }}px);">
        </a>

        {{-- Botão Mobile Hamburger --}}
        <button id="mobile-open-btn" class="lg:hidden ml-auto inline-flex flex-col items-center justify-center gap-0.5 px-3 py-2 text-inherit bg-slate-500/10 border border-slate-500/20 rounded-xl hover:bg-slate-500/20 transition-colors" aria-label="Abrir menu">
            <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16m-7 6h7"></path>
            </svg>
            <span class="text-[10px] font-bold uppercase leading-none tracking-wide">Menu</span>
        </button>

        {{-- Menu Desktop --}}
        <nav class="hidden lg:flex items-center lg:gap-3 xl:gap-5 text-base font-medium transition-colors duration-300">

            <a href="{{ route('home2') }}" class="transition-opacity hover:opacity-75 py-1 {{ request()->routeIs('home2') ? 'border-b-2 border-yellow-400' : '' }}">
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
                    <a href="{{ route('pages.sobre') }}" class="block px-4 py-3 text-[13px] font-medium hover:bg-blue-50 hover:text-blue-700 border-b border-slate-100 {{ request()->routeIs('pages.sobre') ? 'bg-blue-50 text-blue-700' : '' }}">História e Perfil</a>
                    <a href="{{ route('pages.turismo') }}" class="block px-4 py-3 text-[13px] font-medium hover:bg-blue-50 hover:text-blue-700 {{ request()->routeIs('pages.turismo') ? 'bg-blue-50 text-blue-700' : '' }}">Turismo</a>
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

            <a href="https://assai.atende.net/subportal/ouvidoria" target="_blank" rel="noopener noreferrer" class="transition-opacity hover:opacity-75">
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

    {{-- Gaveta Mobile (Mantida idêntica para não quebrar funcionalidade) --}}
    <div id="mobile-drawer" class="fixed inset-0 z-[100] invisible lg:hidden">
        <div id="mobile-overlay" class="absolute inset-0 bg-blue-950/80 backdrop-blur-sm opacity-0 transition-opacity duration-300"></div>

        <div id="mobile-panel" class="absolute right-0 top-0 h-[100dvh] w-[85%] max-w-[320px] md:max-w-[450px] bg-blue-900 shadow-2xl transform translate-x-full transition-transform duration-300 flex flex-col text-white">

            <div class="flex items-center justify-between p-4 md:p-8 border-b border-white/10 shrink-0">
                <img src="{{ asset('img/logo_branca.png') }}" alt="Assaí" class="h-14 md:h-16 w-auto object-contain">
                <button id="mobile-close-btn" class="p-2 -mr-2 text-white hover:text-yellow-400 transition" aria-label="Fechar menu">
                    <svg class="w-6 h-6 md:w-8 md:h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>
            </div>

            <div class="px-4 py-3 bg-blue-950/30 border-b border-white/5 flex flex-col gap-3 shrink-0">
                <div class="flex items-center justify-between text-blue-100 text-xs">
                    <div class="flex items-center gap-2">
                        <button type="button" class="btn-contrast hover:text-yellow-400 transition-colors flex items-center gap-1 font-semibold">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z"></path>
                            </svg>
                            Contraste
                        </button>
                    </div>
                    <div class="flex items-center gap-2 font-bold">
                        <button type="button" class="btn-decrease-font hover:text-yellow-400 transition-colors px-2 py-0.5 bg-white/5 rounded">A-</button>
                        <button type="button" class="btn-increase-font hover:text-yellow-400 transition-colors px-2 py-0.5 bg-white/5 rounded">A+</button>
                    </div>
                </div>

                <div x-data="weatherWidget()" x-init="init()" class="flex items-center text-white text-xs border-t border-white/10 pt-2" aria-live="polite">
                    <template x-if="!loading && !error">
                        <div class="flex flex-wrap items-center gap-2">
                            <i :class="weatherIconClass" class="text-yellow-300"></i>
                            <span class="font-semibold" x-text="formatNumber(temperature) + '°C'"></span>
                            <span class="text-white/30">|</span>
                            <span x-text="weatherLabel"></span>
                            <span class="text-white/30">|</span>
                            <span x-text="'Umid.: ' + formatNumber(humidity) + '%'" class="text-blue-100"></span>
                            <span class="text-white/30">|</span>
                            <span x-text="'Chuva: ' + formatNumber(precipitation) + ' mm'" class="text-blue-100"></span>
                        </div>
                    </template>
                </div>

                <div x-data="dutyWidget()" x-init="init()" class="flex items-center text-white text-xs border-t border-white/10 pt-2" aria-live="polite">
                    <template x-if="loading">
                        <span class="text-xs text-blue-100">Plantões de hoje...</span>
                    </template>
                    <template x-if="error && !loading">
                        <span class="text-xs text-blue-100">Plantões de hoje: indisponível</span>
                    </template>
                    <template x-if="!loading && !error && !hasDuty">
                        <span class="text-xs text-blue-100" x-text="'Plantões de hoje: ' + (message || 'Sem plantão hoje')"></span>
                    </template>
                    <template x-if="!loading && !error && hasDuty">
                        <div class="flex items-start gap-2 text-xs">
                            <i class="fa-solid fa-kit-medical text-yellow-300 mt-0.5"></i>
                            <div class="flex-1 min-w-0 text-blue-100">
                                <span class="font-semibold text-white">Plantões de hoje:</span>
                                <span class="ml-1" x-text="dutySummary"></span>
                            </div>
                        </div>
                    </template>
                </div>
            </div>

            <div class="flex-1 overflow-y-auto [&::-webkit-scrollbar]:w-2 [&::-webkit-scrollbar-track]:bg-transparent [&::-webkit-scrollbar-thumb]:bg-white/20 [&::-webkit-scrollbar-thumb]:rounded-full hover:[&::-webkit-scrollbar-thumb]:bg-white/40">
                <div class="flex flex-col px-3 md:px-8 py-4 md:py-6 gap-1 md:gap-2 font-medium text-base">

                    <a href="{{ route('home2') }}" class="px-4 md:px-6 py-2 md:py-3 rounded-xl transition flex items-center justify-between {{ request()->routeIs('home2') ? 'bg-white/10 text-white font-medium' : 'hover:bg-white/5 font-medium' }}">
                        <span>Início</span>
                    </a>

                    <div class="flex flex-col rounded-xl overflow-hidden mt-1 {{ request()->routeIs('pages.sobre') || request()->routeIs('pages.turismo') ? 'bg-white/5' : '' }}">
                        <button onclick="document.getElementById('mobile-submenu').classList.toggle('hidden')" class="flex items-center justify-between px-4 md:px-6 py-2 md:py-3 w-full hover:bg-white/10 transition text-left">
                            <div class="flex items-center gap-2">
                                <span>A Cidade</span>
                            </div>
                            <svg class="w-4 h-4 text-white/50" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                            </svg>
                        </button>
                        <div id="mobile-submenu" class="{{ request()->routeIs('pages.sobre') || request()->routeIs('pages.turismo') ? 'flex' : 'hidden' }} flex-col bg-black/20 divide-y divide-white/5">
                            <a href="{{ route('pages.sobre') }}" class="block w-full px-6 md:px-10 py-2 md:py-3 text-sm transition {{ request()->routeIs('pages.sobre') ? 'text-yellow-400' : 'text-blue-100 hover:bg-white/5 hover:text-white' }}">História e Perfil</a>
                            <a href="{{ route('pages.turismo') }}" class="block w-full px-6 md:px-10 py-2 md:py-3 text-sm transition {{ request()->routeIs('pages.turismo') ? 'text-yellow-400' : 'text-blue-100 hover:bg-white/5 hover:text-white' }}">Turismo</a>
                        </div>
                    </div>

                    <div class="flex flex-col rounded-xl overflow-hidden mt-1 {{ request()->routeIs('secretarias.*') ? 'bg-white/5' : '' }}">
                        <button onclick="document.getElementById('mobile-submenu-sec').classList.toggle('hidden')" class="flex items-center justify-between px-4 md:px-6 py-2 md:py-3 w-full hover:bg-white/10 transition text-left">
                            <div class="flex items-center gap-2">
                                <span>Secretarias</span>
                            </div>
                            <svg class="w-4 h-4 text-white/50" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                            </svg>
                        </button>
                        <div id="mobile-submenu-sec" class="{{ request()->routeIs('secretarias.*') && !request()->routeIs('secretarias.index') ? 'flex' : 'hidden' }} flex-col bg-black/20 divide-y divide-white/5 max-h-64 overflow-y-auto [&::-webkit-scrollbar]:w-1.5 [&::-webkit-scrollbar-track]:bg-transparent [&::-webkit-scrollbar-thumb]:bg-white/10 [&::-webkit-scrollbar-thumb]:rounded-full">
                            <a href="{{ route('secretarias.index') }}" class="block w-full px-6 md:px-10 py-2 md:py-3 text-sm transition text-yellow-400 hover:bg-white/5 whitespace-nowrap overflow-hidden text-ellipsis">Todas</a>

                            @foreach($navSecretarias as $sec)
                            <a href="{{ route('secretarias.show', $sec->id) }}" class="block w-full px-6 md:px-10 py-2 md:py-3 text-[13px] leading-tight transition text-blue-100 hover:bg-white/5 hover:text-white whitespace-normal break-words" title="{{ $sec->nome_menu }}">
                                {{ $sec->nome_menu }}
                            </a>
                            @endforeach
                        </div>
                    </div>

                    <a href="https://assai.atende.net/subportal/ouvidoria" target="_blank" rel="noopener noreferrer" class="px-4 md:px-6 py-2 md:py-3 rounded-xl transition flex items-center justify-between hover:bg-white/5 font-medium">
                        <span>Ouvidoria</span>
                    </a>

                    <a href="https://transparencia.betha.cloud/#/yyGw8hIiYdv6bs-avrzVUg==" target="_blank" rel="noopener noreferrer" class="px-4 md:px-6 py-2.5 md:py-3 rounded-xl transition flex items-center gap-2 hover:bg-emerald-800 bg-emerald-900/50 text-emerald-300 font-medium border border-emerald-700/50 mt-1">
                        <svg class="w-4 h-4 md:w-5 md:h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path>
                        </svg>
                        <span>Transparência</span>
                    </a>

                    <a href="https://gov.assai.pr.gov.br/cpf-check"
                        target="_blank"
                        rel="noopener noreferrer"
                        class="px-4 md:px-6 py-3 md:py-4 rounded-xl transition flex items-center justify-center gap-2 mt-2 md:mt-3 bg-yellow-400 hover:bg-yellow-300 text-blue-950 font-medium shadow-lg active:scale-95 transform outline-none">
                        <span>Entrar no Gov.Assaí</span>
                        <svg class="w-4 h-4 md:w-5 md:h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M13 7l5 5m0 0l-5 5m5-5H6"></path>
                        </svg>
                    </a>

                </div>
            </div>
        </div>
    </div>
</header>
