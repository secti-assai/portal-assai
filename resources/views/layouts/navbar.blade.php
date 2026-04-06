<script>
    if (typeof window.weatherWidget !== 'function') {
        window.weatherWidget = function() {
            return {
                temperature: null,
                apparentTemperature: null,
                humidity: null,
                windSpeed: null,
                precipitation: null,
                weatherCode: null,
                loading: true,
                error: false,

                formatNumber(value) {
                    if (value === null || value === undefined || Number.isNaN(value)) {
                        return '--';
                    }
                    return Math.round(value);
                },

                get weatherLabel() {
                    const code = Number(this.weatherCode);

                    if (code === 0) return 'Céu limpo';
                    if ([1, 2].includes(code)) return 'Poucas nuvens';
                    if (code === 3) return 'Nublado';
                    if ([45, 48].includes(code)) return 'Nevoeiro';
                    if ([51, 53, 55].includes(code)) return 'Garoa';
                    if ([56, 57].includes(code)) return 'Garoa gelada';
                    if ([61, 63, 65].includes(code)) return 'Chuva';
                    if ([66, 67].includes(code)) return 'Chuva gelada';
                    if ([71, 73, 75, 77, 85, 86].includes(code)) return 'Neve';
                    if ([80, 81, 82].includes(code)) return 'Pancadas';
                    if ([95, 96, 99].includes(code)) return 'Trovoadas';

                    return 'Tempo instável';
                },

                get weatherIconClass() {
                    const code = Number(this.weatherCode);

                    if (code === 0) return 'fas fa-sun';
                    if ([1, 2].includes(code)) return 'fas fa-cloud-sun';
                    if (code === 3) return 'fas fa-cloud';
                    if ([45, 48].includes(code)) return 'fas fa-smog';
                    if ([51, 53, 55, 56, 57].includes(code)) return 'fas fa-cloud-rain';
                    if ([61, 63, 65, 66, 67, 80, 81, 82].includes(code)) return 'fas fa-cloud-showers-heavy';
                    if ([71, 73, 75, 77, 85, 86].includes(code)) return 'fas fa-snowflake';
                    if ([95, 96, 99].includes(code)) return 'fas fa-bolt';

                    return 'fas fa-cloud';
                },

                async init() {
                    try {
                        const latitude = -23.3733;
                        const longitude = -50.8417;
                        const url = `https://api.open-meteo.com/v1/forecast?latitude=${latitude}&longitude=${longitude}&current=temperature_2m,apparent_temperature,relative_humidity_2m,precipitation,weather_code,wind_speed_10m&temperature_unit=celsius&wind_speed_unit=kmh&precipitation_unit=mm&timezone=America/Sao_Paulo`;

                        const response = await fetch(url);
                        if (!response.ok) throw new Error('API Error');

                        const data = await response.json();
                        this.temperature = this.formatNumber(data?.current?.temperature_2m);
                        this.apparentTemperature = this.formatNumber(data?.current?.apparent_temperature);
                        this.humidity = this.formatNumber(data?.current?.relative_humidity_2m);
                        this.windSpeed = this.formatNumber(data?.current?.wind_speed_10m);
                        this.precipitation = this.formatNumber(data?.current?.precipitation);
                        this.weatherCode = this.formatNumber(data?.current?.weather_code);
                        this.error = false;
                    } catch (err) {
                        this.error = true;
                        this.temperature = null;
                        this.apparentTemperature = null;
                        this.humidity = null;
                        this.windSpeed = null;
                        this.precipitation = null;
                        this.weatherCode = null;
                    } finally {
                        this.loading = false;
                    }
                }
            };
        };
    }

    if (typeof window.dutyWidget !== 'function') {
        window.dutyWidget = function() {
            return {
                loading: true,
                error: false,
                hasDuty: false,
                farmacia: null,
                posto: null,
                message: '',
                rotationItems: [],
                activeDutyIndex: 0,
                rotationTimer: null,

                formatAddress(address) {
                    if (!address) return '';

                    const parts = String(address)
                        .split(',')
                        .map((part) => part.trim())
                        .filter(Boolean);

                    if (parts.length >= 2) {
                        return parts[0] + ', ' + parts[1];
                    }

                    return parts[0] ?? '';
                },

                formatDutyText(item, fallbackType) {
                    if (!item) return '';

                    const name = String(item.title || item.type || fallbackType || 'Plantao').trim();
                    const address = this.formatAddress(item.address || '');
                    const phone = String(item.contact || '').trim();

                    let output = name + ': ' + (address || 'Endereco indisponivel');

                    if (phone) {
                        output += ' (' + phone + ')';
                    }

                    return output;
                },

                buildRotationItems() {
                    this.rotationItems = [];

                    if (this.farmacia) {
                        this.rotationItems.push({
                            kind: 'farmacia',
                            text: this.formatDutyText(this.farmacia, 'Farmacia')
                        });
                    }

                    if (this.posto) {
                        this.rotationItems.push({
                            kind: 'posto',
                            text: this.formatDutyText(this.posto, 'Posto')
                        });
                    }

                    this.activeDutyIndex = 0;
                },

                startRotation() {
                    this.stopRotation();

                    if (this.rotationItems.length > 1) {
                        this.rotationTimer = setInterval(() => {
                            this.activeDutyIndex = (this.activeDutyIndex + 1) % this.rotationItems.length;
                        }, 5000);
                    }
                },

                stopRotation() {
                    if (this.rotationTimer) {
                        clearInterval(this.rotationTimer);
                        this.rotationTimer = null;
                    }
                },

                get dutySummary() {
                    if (!this.rotationItems.length) {
                        return '';
                    }

                    return this.rotationItems[this.activeDutyIndex]?.text || '';
                },

                async init() {
                    try {
                        const response = await fetch("{{ route('api.plantao.hoje') }}", {
                            headers: {
                                'Accept': 'application/json'
                            }
                        });

                        if (!response.ok) {
                            throw new Error('API Error');
                        }

                        const data = await response.json();

                        this.hasDuty = Boolean(data?.hasDuty);
                        this.farmacia = data?.farmacia ?? null;
                        this.posto = data?.posto ?? null;
                        this.message = data?.message ?? '';
                        this.buildRotationItems();
                        this.startRotation();
                        this.error = false;
                    } catch (err) {
                        this.stopRotation();
                        this.error = true;
                        this.hasDuty = false;
                        this.farmacia = null;
                        this.posto = null;
                        this.message = 'Plantao indisponivel';
                        this.rotationItems = [];
                        this.activeDutyIndex = 0;
                    } finally {
                        this.loading = false;
                    }
                }
            };
        };
    }

    document.addEventListener('DOMContentLoaded', () => {
        // Inversão Dinâmica de Cor
        const header = document.getElementById('site-header');
        const logo = document.getElementById('nav-logo-img');
        const WHITE_LOGO_OFFSET_X = 0;
        const BLACK_LOGO_OFFSET_X = 6;

        function swapLogo(nextSrc, offsetX) {
            if (!logo) return;

            const currentSrc = logo.getAttribute('src') || '';
            const isSameLogo = currentSrc.includes(nextSrc);

            // Mantem o alinhamento sempre atualizado mesmo sem trocar de arquivo.
            logo.style.transform = `translateX(${offsetX}px)`;

            if (isSameLogo) return;

            // Fade-out rapido, troca src, depois fade-in para evitar efeito de "deslizar".
            logo.style.opacity = '0';

            const reveal = () => {
                logo.style.opacity = '1';
                logo.removeEventListener('load', reveal);
            };

            logo.addEventListener('load', reveal, { once: true });
            logo.src = nextSrc;

            // Fallback de seguranca para cache instantaneo do navegador.
            setTimeout(() => {
                logo.style.opacity = '1';
            }, 140);
        }

        function updateNavbar() {
            if (window.scrollY > 50) {
                if (header) {
                    header.classList.remove('bg-transparent', 'text-white', 'border-transparent');
                    header.classList.add('bg-white/95', 'backdrop-blur-md', 'shadow-sm', 'text-slate-700', 'border-slate-200/50');
                }
                swapLogo("{{ asset('img/logo_preta.png') }}", BLACK_LOGO_OFFSET_X);
            } else {
                if (header) {
                    header.classList.add('bg-transparent', 'text-white', 'border-transparent');
                    header.classList.remove('bg-white/95', 'backdrop-blur-md', 'shadow-sm', 'text-slate-700', 'border-slate-200/50');
                }
                swapLogo("{{ asset('img/logo_branca.png') }}", WHITE_LOGO_OFFSET_X);
            }
        }

        window.addEventListener('scroll', updateNavbar);
        updateNavbar();

        // Gestão de Acessibilidade (Refatorado para suportar Desktop e Mobile via Classes)
        const htmlEl = document.documentElement;
        const MIN_SIZE = 14,
            MAX_SIZE = 20,
            STEP = 2;

        function getCurrentFontSize() {
            const stored = localStorage.getItem('a11y_fontSize');
            return stored ? parseInt(stored) : 16;
        }

        document.querySelectorAll('.btn-increase-font').forEach(btn => {
            btn.addEventListener('click', () => {
                let next = Math.min(getCurrentFontSize() + STEP, MAX_SIZE);
                htmlEl.style.fontSize = next + 'px';
                localStorage.setItem('a11y_fontSize', next);
            });
        });

        document.querySelectorAll('.btn-decrease-font').forEach(btn => {
            btn.addEventListener('click', () => {
                let next = Math.max(getCurrentFontSize() - STEP, MIN_SIZE);
                htmlEl.style.fontSize = next + 'px';
                localStorage.setItem('a11y_fontSize', next);
            });
        });

        document.querySelectorAll('.btn-contrast').forEach(btn => {
            btn.setAttribute('aria-pressed', htmlEl.classList.contains('contrast-mode') ? 'true' : 'false');
            btn.addEventListener('click', function() {
                htmlEl.classList.toggle('contrast-mode');
                let active = htmlEl.classList.contains('contrast-mode');
                localStorage.setItem('a11y_contrast', active ? '1' : '0');
                document.querySelectorAll('.btn-contrast').forEach(b => b.setAttribute('aria-pressed', active ? 'true' : 'false'));
            });
        });
    });
</script>

@php
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

<header class="fixed top-0 left-0 right-0 z-[60] w-full bg-transparent text-white border-b border-transparent transition-all duration-300 font-sans" id="site-header">

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

        {{-- Logo --}}
        <a href="{{ route('home2') }}" style="background: transparent !important; box-shadow: none !important;" class="flex items-center shrink-0 relative ml-0 h-20 sm:h-24 lg:h-20 xl:h-20 w-auto focus:outline-none focus-visible:ring-2 focus-visible:ring-yellow-400 transition-transform hover:scale-[1.02]">
            <img id="nav-logo-img" src="{{ asset('img/logo_branca.png') }}" alt="Prefeitura de Assaí" class="h-full w-auto object-contain transition-opacity duration-200 ease-out">
        </a>

        {{-- Botão Mobile Hamburger --}}
        <button id="mobile-open-btn" class="lg:hidden ml-auto inline-flex flex-col items-center justify-center gap-0.5 px-3 py-2 text-inherit bg-blue-50/10 border border-white/20 rounded-xl hover:bg-blue-50/20 transition-colors" aria-label="Abrir menu">
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

    {{-- Gaveta Mobile --}}
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

            {{-- UTILITÁRIOS MOBILE (Acessibilidade e Clima inseridos no topo da gaveta) --}}
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