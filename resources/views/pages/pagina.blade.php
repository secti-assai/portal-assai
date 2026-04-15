@extends('layouts.app')

@section('title', 'Portal - Prefeitura de Assaí')

@section('content')

    <main id="home-main" class="transition-opacity duration-300">

        {{-- Loaders --}}
        <div id="hero-mobile-loader"
            class="fixed inset-0 z-[200] flex items-center justify-center bg-gradient-to-b from-slate-950 via-blue-950 to-slate-900 text-white transition-opacity duration-500 lg:hidden"
            aria-live="polite">
            <div class="flex flex-col items-center gap-5 px-6 text-center">
                <img src="{{ asset('img/logo_branca.png') }}" alt="Prefeitura de Assaí" loading="eager" decoding="sync"
                    fetchpriority="high" class="w-56 max-w-[80vw] h-auto object-contain">
                <div
                    class="flex items-center gap-3 text-xs sm:text-sm font-semibold tracking-[0.18em] uppercase text-blue-100">
                    <span class="inline-block h-5 w-5 rounded-full border-2 border-white/35 border-t-white animate-spin"
                        aria-hidden="true"></span>
                    Preparando experiência
                </div>
            </div>
        </div>

        <div id="hero-video-loader"
            class="hidden lg:flex fixed inset-0 z-[200] items-center justify-center bg-gradient-to-b from-slate-950 via-blue-950 to-slate-900 text-white transition-opacity duration-500"
            aria-live="polite">
            <div class="flex flex-col items-center gap-5 px-6 text-center">
                <img src="{{ asset('img/logo_branca.png') }}" alt="Prefeitura de Assaí" loading="eager" decoding="sync"
                    fetchpriority="high" class="w-56 max-w-[80vw] h-auto object-contain">
                <div
                    class="flex items-center gap-3 text-xs sm:text-sm font-semibold tracking-[0.18em] uppercase text-blue-100">
                    <span class="inline-block h-5 w-5 rounded-full border-2 border-white/35 border-t-white animate-spin"
                        aria-hidden="true"></span>
                    Preparando experiência
                </div>
            </div>
        </div>

        {{-- Variáveis Globais da Home --}}
        @php
            $destaquesSlider = isset($noticias) && $noticias->count() > 0 ? $noticias->take(3) : collect();
            $recentesSidebar = isset($noticias) && $noticias->count() > 3 ? $noticias->skip(3)->take(3) : (isset($noticias) ? $noticias->take(3) : collect());

            $sugestoesBusca = collect($sugestoesIA ?? [
                'Emitir nota fiscal eletronica',
                'Consultar protocolo digital',
                'Agendar atendimento administrativo',
                'Solicitar matricula na rede municipal',
            ])->take(3);

            $servicosPlMobile = [
                ['titulo' => 'Nota Fiscal Pr. / ISS', 'icone' => 'fa-file-invoice-dollar', 'link' => '#'],
                ['titulo' => 'Alvará Web', 'icone' => 'fa-building-columns', 'link' => '#'],
                ['titulo' => 'Holerite Online', 'icone' => 'fa-file-invoice', 'link' => '#'],
                ['titulo' => 'ITBI', 'icone' => 'fa-house-circle-check', 'link' => '#'],
                ['titulo' => 'Livro Eletrônico', 'icone' => 'fa-book-open-reader', 'link' => '#'],
                ['titulo' => 'Portal da Transparência', 'icone' => 'fa-money-bill-trend-up', 'link' => '#'],
                ['titulo' => 'Ouvidoria', 'icone' => 'fa-bullhorn', 'link' => '#'],
                ['titulo' => 'Procon', 'icone' => 'fa-scale-balanced', 'link' => '#'],
                ['titulo' => 'Diário Oficial', 'icone' => 'fa-book-bookmark', 'link' => '#'],
                ['titulo' => 'Licitações', 'icone' => 'fa-file-contract', 'link' => '#'],
            ];

            $calendarMesParam = request()->query('mes');
            $calendarMonth = null;
            if (is_string($calendarMesParam) && preg_match('/^\d{4}-\d{2}$/', $calendarMesParam) === 1) {
                try {
                    $calendarMonth = \Carbon\Carbon::createFromFormat('Y-m', $calendarMesParam)->startOfMonth();
                } catch (\Throwable $e) {
                    $calendarMonth = null;
                }
            }

            $calendarMonth = ($calendarMonth ?? \Carbon\Carbon::now())->startOfMonth();
            $calendarStart = $calendarMonth->copy()->startOfWeek(\Carbon\Carbon::SUNDAY);
            $calendarEnd = $calendarMonth->copy()->endOfMonth()->endOfWeek(\Carbon\Carbon::SATURDAY);

            $eventDates = collect($eventos ?? [])
                ->filter(fn($evento) => !empty($evento->data_inicio))
                ->map(fn($evento) => \Carbon\Carbon::parse($evento->data_inicio)->toDateString())
                ->unique()->values()->all();

            $calendarDays = [];
            $cursor = $calendarStart->copy();
            while ($cursor->lte($calendarEnd)) {
                $isoDate = $cursor->toDateString();
                $calendarDays[] = [
                    'day' => (int) $cursor->format('j'),
                    'isCurrentMonth' => $cursor->month === $calendarMonth->month,
                    'isToday' => $cursor->isToday(),
                    'hasEvent' => in_array($isoDate, $eventDates, true),
                ];
                $cursor->addDay();
            }

            $calendarMesAnterior = $calendarMonth->copy()->subMonth()->format('Y-m');
            $calendarMesProximo = $calendarMonth->copy()->addMonth()->format('Y-m');
            $calendarTituloMes = mb_strtolower($calendarMonth->locale('pt_BR')->translatedFormat('F Y'));
        @endphp


        {{-- ==========================================
        HERO MOBILE
        ========================================== --}}
        <section class="lg:hidden pl-mobile-home" id="pl-mobile-home">
            <div class="home-hero-mobile">
                <div class="home-hero-content">
                    <h1 class="hero-title">O QUE VOCÊ <strong>PRECISA?</strong></h1>

                    <form action="{{ route('busca.index') }}" method="GET" class="home-search-bar relative" role="search"
                        x-data="searchAutocomplete()" x-on:click.outside="open = false" @submit="open = false">
                        <input id="busca-portal-mobile" class="home-search-input-custom" type="search" name="q"
                            placeholder="Emitir Nota fiscal..." required x-model.debounce.300ms="query"
                            @focus="if(results.length > 0) open = true" @keydown.escape="open = false" autocomplete="off">
                        <button class="home-search-button-custom" type="submit" aria-label="Pesquisar">
                            <i class="fa-solid fa-magnifying-glass" aria-hidden="true" x-show="!loading"></i>
                            <template x-if="loading">
                                <span
                                    class="inline-block w-4 h-4 border-2 border-white/30 border-t-white rounded-full animate-spin"></span>
                            </template>
                        </button>

                        <div x-show="open" x-transition:enter="transition ease-out duration-200"
                            x-transition:enter-start="opacity-0 translate-y-1"
                            x-transition:enter-end="opacity-100 translate-y-0" x-cloak
                            class="search-suggestions-dropdown text-left z-50">
                            <template x-for="(items, tipo) in groupedResults" :key="tipo">
                                <div class="search-category-group">
                                    <div class="search-category-title">
                                        <i class="fa-solid" :class="getIcon(tipo)"></i>
                                        <span x-text="tipo"></span>
                                    </div>
                                    <template x-for="item in items" :key="item.url">
                                        <a :href="item.url" class="search-suggestion-item">
                                            <span x-text="item.titulo"></span>
                                        </a>
                                    </template>
                                </div>
                            </template>
                            <template x-if="results.length === 0 && query.length >= 2 && !loading">
                                <div class="p-6 text-center text-slate-500 text-sm italic">
                                    Sem resultados para "<span x-text="query"></span>"
                                </div>
                            </template>
                        </div>
                    </form>

                    <div class="mt-4 flex justify-center w-full" x-data>
                        <button type="button" @click="$dispatch('open-modal-busca-avancada')"
                            class="inline-flex items-center gap-2 text-[13px] font-bold text-white/90 hover:text-white transition-colors border-b border-dashed border-white/50 hover:border-white focus:outline-none focus:ring-2 focus:ring-yellow-400 p-1">
                            <i class="fa-solid fa-sliders" aria-hidden="true"></i>
                            Busca Avançada
                        </button>
                    </div>
                </div>
            </div>
        </section>


        {{-- ==========================================
        HERO DESKTOP
        ========================================== --}}
        <section id="hero-oficial" class="hidden lg:block relative w-full bg-slate-950 py-40 md:py-56"
            style="padding-top: var(--site-header-height,130px);">
            <div class="absolute inset-0 z-0 bg-slate-950">
                <video id="hero-video-lazy"
                    class="w-full h-full object-cover object-center opacity-0 transition-opacity duration-1000" muted loop
                    playsinline poster="{{ asset('img/Assai.jpg') }}" preload="none">
                    <source data-src="{{ asset('videos/panorama.mp4') }}" type="video/mp4">
                </video>
                <div class="absolute inset-0 bg-gradient-to-b from-slate-900/60 via-blue-950/40 to-slate-900/60"></div>
            </div>

            <div class="relative z-50 container mx-auto max-w-4xl flex flex-col items-center justify-center px-4"
                x-data="searchAutocomplete()" @click.outside="open = false">
                <h1
                    class="mt-16 mb-6 text-3xl md:text-5xl font-extrabold text-white drop-shadow-md font-heading leading-tight text-center break-words">
                    O QUE VOCÊ <strong>PRECISA?</strong></h1>

                <form action="{{ route('busca.index') }}" method="GET"
                    class="relative flex items-center w-full max-w-2xl bg-white/95 focus-within:bg-white backdrop-blur-md shadow-2xl rounded-full border border-white/60 transition-all duration-300 p-1"
                    role="search" @submit="open = false">
                    <input id="busca-portal-fixo" type="text" name="q" placeholder="Emitir Nota Fiscal..." required
                        class="flex-1 min-w-0 px-4 py-2.5 text-sm text-gray-800 bg-transparent border-none md:px-5 md:py-4 md:text-base focus:ring-0 focus:outline-none font-sans placeholder:text-slate-400 w-full"
                        x-model.debounce.300ms="query" @focus="if(results.length > 0) open = true"
                        @keydown.escape="open = false" autocomplete="off">

                    <div class="flex items-center gap-1 pr-1 shrink-0">
                        <div class="w-px h-8 bg-slate-200 mx-2" aria-hidden="true"></div>
                        <button type="button" @click="$dispatch('open-modal-busca-avancada')"
                            class="flex items-center justify-center gap-2 px-3 py-2 text-[13px] md:text-sm font-bold text-slate-600 transition-colors rounded-full hover:bg-slate-100 hover:text-[#006eb7] focus:outline-none focus:ring-2 focus:ring-blue-500/50 whitespace-nowrap">
                            <i class="fa-solid fa-sliders text-base text-[#006eb7]" aria-hidden="true"></i>
                            <span>Busca Avançada</span>
                        </button>
                    </div>

                    <button type="submit"
                        class="m-1.5 px-4 py-2 font-bold text-sm text-blue-900 transition-all bg-yellow-400 rounded-full shrink-0 md:px-6 md:py-3 hover:bg-yellow-500 hover:shadow-lg font-heading">
                        Buscar
                    </button>

                    <div x-show="open" x-transition:enter="transition ease-out duration-200"
                        x-transition:enter-start="opacity-0 translate-y-1"
                        x-transition:enter-end="opacity-100 translate-y-0" x-cloak
                        class="search-suggestions-dropdown text-left z-50">
                        <template x-for="(items, tipo) in groupedResults" :key="tipo">
                            <div class="search-category-group">
                                <div class="search-category-title">
                                    <i class="fa-solid" :class="getIcon(tipo)"></i>
                                    <span x-text="tipo"></span>
                                </div>
                                <template x-for="item in items" :key="item.url">
                                    <a :href="item.url" class="search-suggestion-item">
                                        <span x-text="item.titulo"></span>
                                    </a>
                                </template>
                            </div>
                        </template>
                        <template x-if="results.length === 0 && query.length >= 2 && !loading">
                            <div class="p-6 text-center text-slate-500 text-sm italic">
                                Nenhum resultado rápido encontrado para "<span x-text="query"></span>"
                            </div>
                        </template>
                    </div>
                </form>

                @if($sugestoesBusca->count() > 0)
                    <div x-show="!open" x-transition.opacity
                        class="flex flex-wrap items-center justify-center gap-2 mt-4 max-w-4xl px-4 mx-auto">
                        @foreach($sugestoesBusca as $sugestao)
                            <a href="{{ route('busca.index', ['q' => $sugestao]) }}"
                                class="inline-flex items-center gap-1.5 px-3 py-1.5 text-xs font-semibold text-white cursor-pointer select-none transition-all duration-200 bg-white/10 border border-white/25 backdrop-blur-sm rounded-full hover:bg-blue-600 hover:text-white hover:border-transparent hover:shadow-md whitespace-nowrap">
                                <svg class="w-3 h-3 opacity-70" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                                </svg>
                                {{ $sugestao }}
                            </a>
                        @endforeach
                    </div>
                @endif
            </div>

            <div class="absolute bottom-6 md:bottom-10 left-1/2 -translate-x-1/2 z-30 flex flex-col items-center">
                <span class="hidden md:block mb-3 text-[10px] font-bold tracking-[0.2em] text-white/70 uppercase">Role para
                    explorar</span>
                <a href="#conteudo-destaque"
                    class="inline-flex items-center justify-center w-10 h-10 md:w-12 md:h-12 text-white transition-all duration-300 border border-white/20 rounded-full bg-white/10 backdrop-blur-md hover:bg-white/20 hover:scale-110 animate-bounce shadow-lg">
                    <svg class="w-5 h-5 md:w-6 md:h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M19 14l-7 7m0 0l-7-7m7 7V3"></path>
                    </svg>
                </a>
            </div>
        </section>

        <div id="conteudo-destaque" class="w-full h-px"></div>

        {{-- ==========================================
        BANNERS FIXOS DESTAQUE
        ========================================== --}}
        @if(isset($bannersDestaque) && $bannersDestaque->count() > 0)
            <section class="py-8 lg:py-12 bg-white border-b border-slate-100">
                <div class="container px-4 mx-auto max-w-6xl font-sans">
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4 md:gap-6">
                        @foreach($bannersDestaque as $banner)
                            <a href="{{ $banner->link ?? '#' }}" {{ $banner->link ? 'target="_blank" rel="noopener"' : '' }}
                                class="block relative w-full overflow-hidden rounded-2xl shadow-sm hover:shadow-lg transition-all duration-300 group transform hover:-translate-y-1">
                                <div class="relative w-full pb-[40%] md:pb-[50%] lg:pb-[45%] bg-slate-100">
                                    <img src="{{ asset('storage/' . $banner->imagem) }}" alt="{{ $banner->titulo }}" loading="lazy"
                                        class="absolute inset-0 w-full h-full object-cover transition-transform duration-700 group-hover:scale-105">
                                </div>
                            </a>
                        @endforeach
                    </div>
                </div>
            </section>
        @endif


        {{-- ==========================================
        SEÇÕES MOBILE (Apenas telas pequenas)
        ========================================== --}}
        <div class="lg:hidden pl-mobile-home"> {{-- CLASSE pl-mobile-home ADICIONADA AQUI --}}

            {{-- Nossos Portais Mobile --}}
            <section class="bg-white-section border-b border-slate-100">
                <h2 class="section-title font-bold mb-6">Nossos Portais</h2>
                <div class="small-cards-grid">
                    @foreach($portais as $portal)
                        <div class="small-card group relative">
                            <a href="{{ $portal->url }}" target="_blank" rel="noopener"
                                class="flex flex-col items-center justify-center w-full h-full px-1 py-3">
                                @php $iconePortal = !empty($portal->icone) ? str_replace(['fa-', 'fas ', 'fa-solid '], '', $portal->icone) : 'file-lines'; @endphp
                                <i class="fa-solid fa-{{ $iconePortal }} service-icon" aria-hidden="true"></i>
                                <h4 class="small-card-title">{{ $portal->titulo }}</h4>
                            </a>
                        </div>
                    @endforeach
                </div>
            </section>

            {{-- Serviços Mobile --}}
            <section class="bg-white-section">
                <h2 class="section-title font-bold">Mais Acessados</h2>
                <div class="small-cards-grid">
                    @if(isset($servicos) && $servicos->count() > 0)
                        @foreach($servicos->take(8) as $servicoItem)
                            <div class="small-card group relative">
                                <a href="{{ route('servicos.acessar', $servicoItem->id) }}" target="_blank" rel="noopener"
                                    class="flex flex-col items-center justify-center w-full h-full px-1 py-3">
                                    @php $iconeServico = !empty($servicoItem->icone) ? str_replace(['fa-', 'fas ', 'fa-solid '], '', $servicoItem->icone) : 'file-lines'; @endphp
                                    <i class="fa-solid fa-{{ $iconeServico }} service-icon" aria-hidden="true"></i>
                                    <h4 class="small-card-title">{{ $servicoItem->titulo }}</h4>
                                </a>
                            </div>
                        @endforeach
                    @else
                        @foreach(collect($servicosPlMobile)->take(8) as $servicoItem)
                            <div class="small-card group relative">
                                <a href="{{ $servicoItem['link'] }}" target="_blank" rel="noopener"
                                    class="flex flex-col items-center justify-center w-full h-full px-1 py-3">
                                    <i class="fa-solid {{ $servicoItem['icone'] }} service-icon" aria-hidden="true"></i>
                                    <h4 class="small-card-title">{{ $servicoItem['titulo'] }}</h4>
                                </a>
                            </div>
                        @endforeach
                    @endif
                </div>
                <div class="all-btn-wrapper">
                    <a href="{{ route('servicos.index') }}" class="all-btn"><i class="fa-solid fa-table-cells-large"
                            aria-hidden="true"></i> Ver Todos Serviços</a>
                </div>
            </section>

            {{-- Programas Mobile --}}
            <section class="bg-gray-section" style="padding-top: 1.5rem; padding-bottom: 2.5rem;">
                <h2 class="section-title mb-6 font-bold">Fique ligado</h2>
                @if(isset($programas) && $programas->count() > 0)
                    <div class="px-4 w-full">
                        <div
                            class="swiper swiper-fique-ligado h-[360px] w-full rounded-[16px] shadow-md overflow-hidden relative">
                            <div class="swiper-wrapper">
                                @foreach($programas as $programa)
                                    <div class="swiper-slide relative h-[360px] bg-slate-100">
                                        <a href="{{ route('programas.show', $programa) }}" class="block w-full h-full">
                                            <img src="{{ $programa->imagem ? asset('storage/' . $programa->imagem) : asset('img/Assai.jpg') }}"
                                                alt="{{ $programa->titulo }}" loading="lazy"
                                                class="absolute inset-0 object-cover w-full h-full">
                                            <div
                                                class="absolute inset-0 bg-gradient-to-t from-[#020617] via-[#020617]/30 to-transparent pointer-events-none">
                                            </div>
                                            <div
                                                class="absolute bottom-0 left-0 w-full p-4 bg-white/10 backdrop-blur-sm border-t border-white/20 z-10 flex flex-col justify-end">
                                                <h3 class="text-xl font-bold text-white leading-snug drop-shadow-lg text-center"
                                                    style="font-family: 'Montserrat', sans-serif;">
                                                    {{ Str::limit($programa->titulo, 70) }}</h3>
                                            </div>
                                        </a>
                                    </div>
                                @endforeach
                            </div>
                            <div class="swiper-pagination !bottom-3"></div>
                            <div class="swiper-button-prev program-swiper-arrow program-swiper-arrow-mobile !text-[#0b2f57]">
                            </div>
                            <div class="swiper-button-next program-swiper-arrow program-swiper-arrow-mobile !text-[#0b2f57]">
                            </div>
                        </div>
                    </div>
                    <div class="mt-8 flex justify-center w-full pb-4">
                        <a href="{{ route('programas.index') }}"
                            class="bg-[#006eb7] text-white rounded-full px-8 py-3 text-sm font-bold flex items-center gap-2 hover:bg-blue-800 transition shadow-md">
                            <i class="fa-solid fa-bullhorn"></i> Ver Todos Programas
                        </a>
                    </div>
                @endif
            </section>

            {{-- Notícias Mobile --}}
            <section class="bg-white-section border-b border-slate-100">
                <h2 class="section-title font-bold mb-6">Últimas Notícias</h2>

                @if($destaquesSlider->count() > 0)
                    <div class="px-2 mb-8">
                        <div class="swiper swiper-noticias-mobile w-full pb-10">
                            <div class="swiper-wrapper">
                                @foreach($destaquesSlider as $destaque)
                                    <div class="swiper-slide h-auto">
                                        <a href="{{ route('noticias.show', $destaque->slug) }}"
                                            class="flex flex-col h-full bg-slate-50 border border-slate-200 rounded-xl overflow-hidden shadow-sm">
                                            <div class="w-full aspect-[4/3] relative shrink-0 bg-slate-100">
                                                <img src="{{ $destaque->imagem_capa ? asset('storage/' . $destaque->imagem_capa) : asset('img/Assai.jpg') }}"
                                                    class="absolute inset-0 w-full h-full object-cover"
                                                    alt="{{ $destaque->titulo }}" loading="lazy">
                                                <div
                                                    class="absolute inset-0 bg-gradient-to-t from-black/60 via-transparent to-transparent">
                                                </div>
                                            </div>
                                            <div class="p-5 flex-1 flex flex-col justify-between bg-white">
                                                <h3 class="text-[1.1rem] font-bold text-slate-800 leading-snug mb-3"
                                                    style="font-family: 'Rawline', 'Open Sans', sans-serif;">{{ $destaque->titulo }}
                                                </h3>
                                                <span class="text-[11px] text-slate-500 font-medium uppercase tracking-wide">
                                                    {{ \Carbon\Carbon::parse($destaque->data_publicacao)->format('d/m/Y') }}
                                                </span>
                                            </div>
                                        </a>
                                    </div>
                                @endforeach
                            </div>
                            <div class="swiper-button-prev program-swiper-arrow program-swiper-arrow-mobile !text-[#0b2f57]"></div>
                            <div class="swiper-button-next program-swiper-arrow program-swiper-arrow-mobile !text-[#0b2f57]"></div>
                        </div>
                    </div>

                    <div class="px-2">
                        <div class="flex items-center justify-between mb-4">
                            <h3 class="text-lg font-extrabold text-slate-800"
                                style="font-family: 'Rawline', 'Open Sans', sans-serif;">Recentes</h3>
                            <a href="{{ route('noticias.index') }}"
                                class="text-[12px] font-bold text-[#006eb7] hover:underline py-1">Ver Todas</a>
                        </div>
                        <div class="flex flex-col gap-3">
                            @foreach($recentesSidebar as $recente)
                                <a href="{{ route('noticias.show', $recente->slug) }}"
                                    class="relative h-[200px] w-full block group overflow-hidden rounded-xl shadow-sm border border-slate-100">
                                    <img src="{{ $recente->imagem_capa ? asset('storage/' . $recente->imagem_capa) : asset('img/Assai.jpg') }}"
                                        class="absolute inset-0 w-full h-full object-cover" alt="{{ $recente->titulo }}"
                                        loading="lazy">
                                    <div class="absolute inset-0 bg-gradient-to-t from-black/90 via-black/40 to-transparent"></div>
                                    <div class="absolute bottom-0 left-0 w-full p-4">
                                        <h4 class="text-white text-[13px] font-bold leading-snug line-clamp-3"
                                            style="font-family: 'Rawline', 'Open Sans', sans-serif;">{{ $recente->titulo }}</h4>
                                    </div>
                                </a>
                            @endforeach
                        </div>
                    </div>
                @else
                    <div
                        class="mx-4 rounded-xl border border-dashed border-slate-300 bg-slate-50 px-5 py-8 text-center text-sm text-slate-500">
                        Nenhuma notícia publicada no momento.
                    </div>
                @endif
            </section>

            {{-- Calendário Mobile --}}
            <section class="bg-gray-section" style="padding-top: 2.5rem;">
                <h2 class="section-title font-bold">Calendário de Eventos</h2>
                <div class="calendar-wrap">
                    <div class="calendar-head">
                        <a href="{{ route('home', ['mes' => $calendarMesAnterior]) }}" class="arrow-btn"
                            aria-label="Mês anterior"><i class="fa-solid fa-chevron-left"></i></a>
                        <span class="month-name">{{ $calendarTituloMes }}</span>
                        <a href="{{ route('home', ['mes' => $calendarMesProximo]) }}" class="arrow-btn"
                            aria-label="Próximo mês"><i class="fa-solid fa-chevron-right"></i></a>
                    </div>
                    <div class="calendar-grid">
                        <span class="day-name">D</span><span class="day-name">S</span><span class="day-name">T</span><span
                            class="day-name">Q</span><span class="day-name">Q</span><span class="day-name">S</span><span
                            class="day-name">S</span>
                        @foreach($calendarDays as $calendarDay)
                            @php
                                $calendarClasses = 'day-number';
                                if (!$calendarDay['isCurrentMonth'])
                                    $calendarClasses .= ' muted';
                                if ($calendarDay['isToday'])
                                    $calendarClasses .= ' today';
                                if ($calendarDay['hasEvent'])
                                    $calendarClasses .= ' event';
                            @endphp
                            <span class="{{ $calendarClasses }}">{{ $calendarDay['day'] }}</span>
                        @endforeach
                    </div>
                </div>

                @if(isset($eventos) && $eventos->count() > 0)
                    @foreach($eventos->take(2) as $eventoItem)
                        <div class="event-featured">
                            <div class="date-chip">
                                <span class="day">{{ \Carbon\Carbon::parse($eventoItem->data_inicio)->format('d') }}</span>
                                <span
                                    class="month">{{ \Carbon\Carbon::parse($eventoItem->data_inicio)->translatedFormat('M') }}</span>
                            </div>
                            <div>
                                <h3 class="event-title">{{ $eventoItem->titulo }}</h3>
                                <p class="event-meta"><i class="fa-solid fa-clock"></i>
                                    {{ \Carbon\Carbon::parse($eventoItem->data_inicio)->format('d \d\e F \à\s H:i') }}</p>
                                <p class="event-meta"><i class="fa-solid fa-location-dot"></i>
                                    {{ $eventoItem->local ?? 'Assaí, PR' }}</p>
                            </div>
                        </div>
                    @endforeach
                @endif
                <div class="all-btn-wrapper">
                    <a href="{{ route('agenda.index') }}" class="all-btn"><i class="fa-regular fa-calendar-days"></i> Ver
                        todos os Eventos</a>
                </div>
            </section>

        </div>

        {{-- ==========================================
        SEÇÕES DESKTOP (Apenas telas grandes)
        ========================================== --}}
        <div class="hidden lg:block">

            {{-- Nossos Portais Desktop --}}
            <section id="nossos-portais-desktop" class="py-12 bg-[#f8fafc] border-b border-[#e2e8f0]">
                <div class="container px-4 mx-auto max-w-6xl font-sans">
                    <h2 class="text-[1.72rem] font-bold text-[#4a5c6a] text-center mb-10"
                        style="font-family: 'Montserrat', sans-serif;">Nossos Portais</h2>
                    <div class="grid grid-cols-4 lg:grid-cols-5 gap-4">
                        @foreach($portais as $portal)
                            <a href="{{ $portal->url }}" target="_blank" rel="noopener"
                                class="bg-white rounded-[22px] border border-[#edf2f7] p-5 flex flex-col items-center justify-center text-center relative shadow-[0_6px_14px_rgba(15,23,42,0.07)] hover:-translate-y-1 transition-transform duration-300 group">
                                @php $iconePortal = !empty($portal->icone) ? str_replace(['fa-', 'fas ', 'fa-solid '], '', $portal->icone) : 'file-lines'; @endphp
                                <i class="fa-solid fa-{{ $iconePortal }} text-6xl text-[#006eb7] mb-3 mt-2"></i>
                                <h3 class="text-lg font-medium text-[#006eb7] leading-snug">{{ $portal->titulo }}</h3>
                            </a>
                        @endforeach
                    </div>
                </div>
            </section>

            {{-- Serviços Desktop --}}
            <section id="servicos-desktop" class="py-16 bg-white border-b border-[#e2e8f0]">
                <div class="container px-4 mx-auto max-w-6xl font-sans">
                    <h2 class="text-[1.72rem] font-bold text-[#4a5c6a] text-center mb-10"
                        style="font-family: 'Montserrat', sans-serif;">Mais Acessados</h2>
                    <div class="grid grid-cols-4 lg:grid-cols-5 gap-4">
                        @if(isset($servicos) && $servicos->count() > 0)
                            @foreach($servicos->take(10) as $servico)
                                <a href="{{ route('servicos.acessar', $servico->id) }}" target="_blank" rel="noopener"
                                    class="bg-white rounded-[22px] border border-[#edf2f7] p-5 flex flex-col items-center justify-center text-center relative shadow-[0_6px_14px_rgba(15,23,42,0.07)] hover:-translate-y-1 transition-transform duration-300 group">
                                    @php $iconeServico = !empty($servico->icone) ? str_replace(['fa-', 'fas ', 'fa-solid '], '', $servico->icone) : 'file-lines'; @endphp
                                    <i class="fa-solid fa-{{ $iconeServico }} text-6xl text-[#006eb7] mb-3 mt-2"></i>
                                    <h3 class="text-lg font-medium text-[#006eb7] leading-snug">{{ $servico->titulo }}</h3>
                                </a>
                            @endforeach
                        @else
                            @foreach(collect($servicosPlMobile)->take(10) as $servico)
                                <a href="{{ $servico['link'] }}" target="_blank" rel="noopener"
                                    class="bg-white rounded-[22px] border border-[#edf2f7] p-5 flex flex-col items-center justify-center text-center relative shadow-[0_6px_14px_rgba(15,23,42,0.07)] hover:-translate-y-1 transition-transform duration-300 group">
                                    <i class="fa-solid {{ $servico['icone'] }} text-4xl text-[#006eb7] mb-3 mt-2"></i>
                                    <h3 class="text-[0.95rem] font-medium text-[#006eb7] leading-snug">{{ $servico['titulo'] }}</h3>
                                </a>
                            @endforeach
                        @endif
                    </div>
                    <div class="mt-10 flex justify-center">
                        <a href="{{ route('servicos.index') }}"
                            class="bg-[#006eb7] text-white rounded-full px-8 py-3 text-base font-bold flex items-center gap-2 hover:bg-blue-800 transition shadow-md">
                            <i class="fa-solid fa-table-cells-large"></i> Ver Todos Serviços
                        </a>
                    </div>
                </div>
            </section>

            {{-- Programas Desktop --}}
            <section id="programas-desktop" class="pb-16 pt-10 bg-[#eef1f5]">
                <div class="container px-4 mx-auto max-w-6xl font-sans">
                    <h2 class="text-[1.72rem] font-bold text-[#4a5c6a] text-center mb-10"
                        style="font-family: 'Montserrat', sans-serif;">Fique ligado</h2>
                    @if(isset($programas) && $programas->count() > 0)
                        <div
                            class="relative h-[520px] w-full rounded-[22px] overflow-hidden shadow-[0_8px_30px_rgb(0,0,0,0.12)] bg-slate-100">
                            <div class="swiper swiper-fique-ligado h-[520px] w-full">
                                <div class="swiper-wrapper">
                                    @foreach($programas as $programa)
                                        <div class="swiper-slide relative h-[520px] w-full bg-slate-100">
                                            <a href="{{ route('programas.show', $programa) }}"
                                                class="block w-full h-full focus:outline-none focus:ring-4 focus:ring-inset focus:ring-[#006eb7]">
                                                <img src="{{ $programa->imagem ? asset('storage/' . $programa->imagem) : asset('img/Assai.jpg') }}"
                                                    alt="{{ $programa->titulo }}" loading="lazy"
                                                    class="absolute inset-0 object-cover w-full h-full">
                                                <div
                                                    class="absolute inset-0 bg-gradient-to-t from-[#020617] via-[#020617]/30 to-transparent pointer-events-none">
                                                </div>
                                                <div
                                                    class="absolute bottom-0 left-0 w-full p-4 md:p-6 bg-white/10 backdrop-blur-sm border-t border-white/20 z-10">
                                                    <h3 class="text-3xl md:text-4xl font-bold text-white leading-tight drop-shadow-lg max-w-4xl mx-auto text-center"
                                                        style="font-family: 'Montserrat', sans-serif;">{{ $programa->titulo }}</h3>
                                                </div>
                                            </a>
                                        </div>
                                    @endforeach
                                </div>
                                <div class="swiper-pagination !bottom-5"></div>
                            </div>
                        </div>
                        <div class="mt-10 flex justify-center w-full">
                            <a href="{{ route('programas.index') }}"
                                class="bg-[#006eb7] text-white rounded-full px-8 py-3 text-base font-bold flex items-center gap-2 hover:bg-blue-800 transition shadow-md">
                                <i class="fa-solid fa-bullhorn"></i> Ver Todos Programas
                            </a>
                        </div>
                    @endif
                </div>
            </section>

            {{-- Notícias Desktop Correção Flexbox & Título --}}
            <section id="noticias-desktop" class="py-16 bg-white border-t border-slate-100">
                <div class="container px-4 mx-auto max-w-6xl font-sans">

                    {{-- Título Padronizado --}}
                    <h2 class="text-[1.72rem] font-bold text-[#4a5c6a] text-center mb-10"
                        style="font-family: 'Montserrat', sans-serif;">Últimas Notícias</h2>

                    @if($destaquesSlider->count() > 0)
                        <div class="grid grid-cols-12 gap-8 lg:h-[500px]">
                            {{-- Coluna Esquerda: Slider Destaque --}}
                            <div class="col-span-8 flex flex-col h-full">
                                <div
                                    class="swiper swiper-noticias-desktop w-full h-full group relative flex-1 overflow-hidden shadow-sm border border-slate-100">
                                    <div class="swiper-wrapper h-full">
                                        @foreach($destaquesSlider as $destaque)
                                            <div class="swiper-slide bg-white h-full flex flex-col">
                                                <a href="{{ route('noticias.show', $destaque->slug) }}"
                                                    class="flex flex-col h-full focus:outline-none focus:ring-2 focus:ring-[#006eb7]">
                                                    <div class="p-6 shrink-0 bg-white">
                                                        <h3 class="text-[1.85rem] font-bold text-slate-800 mb-3 leading-[1.2] line-clamp-2"
                                                            style="font-family: 'Rawline', 'Open Sans', sans-serif;">
                                                            {{ $destaque->titulo }}
                                                        </h3>
                                                        <div class="text-[13px] text-slate-500 flex flex-col gap-0.5 font-medium">
                                                            <span>Data da Publicação:
                                                                {{ \Carbon\Carbon::parse($destaque->data_publicacao)->format('d/m/Y') }}</span>
                                                        </div>
                                                    </div>
                                                    <div class="relative w-full flex-1 bg-slate-100 border-t border-slate-100">
                                                        <img src="{{ $destaque->imagem_capa ? asset('storage/' . $destaque->imagem_capa) : asset('img/Assai.jpg') }}"
                                                            class="absolute inset-0 w-full h-full object-cover"
                                                            alt="{{ $destaque->titulo }}" loading="lazy">
                                                    </div>
                                                </a>
                                            </div>
                                        @endforeach
                                    </div>
                                    @if($destaquesSlider->count() > 1)
                                        <div class="swiper-button-prev program-swiper-arrow !text-[#0b2f57]"></div>
                                        <div class="swiper-button-next program-swiper-arrow !text-[#0b2f57]"></div>
                                    @endif
                                </div>
                            </div>

                            {{-- Coluna Direita: Recentes --}}
                            <div class="col-span-4 flex flex-col h-full">
                                <div class="flex items-center justify-between mb-4 shrink-0 px-1">
                                    <h3 class="text-[1.3rem] font-extrabold text-slate-800"
                                        style="font-family: 'Rawline', 'Open Sans', sans-serif;">Recentes</h3>
                                    <a href="{{ route('noticias.index') }}"
                                        class="text-[13px] font-bold text-[#006eb7] hover:underline px-2 py-1">Ver Todas</a>
                                </div>
                                <div class="flex flex-col gap-4 flex-1">
                                    @foreach($recentesSidebar as $recente)
                                        <a href="{{ route('noticias.show', $recente->slug) }}"
                                            class="relative flex-1 w-full block group overflow-hidden shadow-sm border border-slate-100 focus:outline-none focus:ring-2 focus:ring-[#006eb7] min-h-[110px]">
                                            <img src="{{ $recente->imagem_capa ? asset('storage/' . $recente->imagem_capa) : asset('img/Assai.jpg') }}"
                                                class="absolute inset-0 w-full h-full object-cover transition-transform duration-700 group-hover:scale-105"
                                                alt="{{ $recente->titulo }}" loading="lazy">
                                            <div class="absolute inset-0 bg-gradient-to-t from-black/90 via-black/40 to-black/10">
                                            </div>
                                            <div class="absolute bottom-0 left-0 w-full p-4">
                                                <h4 class="text-white text-[14px] font-bold leading-snug line-clamp-3 drop-shadow-md"
                                                    style="font-family: 'Rawline', 'Open Sans', sans-serif;">
                                                    {{ $recente->titulo }}
                                                </h4>
                                            </div>
                                        </a>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    @else
                        <div
                            class="border border-dashed border-slate-300 bg-slate-50 px-5 py-10 text-center text-sm text-slate-500 shadow-sm">
                            Nenhuma notícia publicada no momento.
                        </div>
                    @endif
                </div>
            </section>

            {{-- Agenda Desktop --}}
            <section id="agenda-desktop" class="py-16 bg-[#eef1f5]">
                <div class="container px-4 mx-auto max-w-6xl font-sans">
                    <h2 class="text-[1.72rem] font-bold text-[#4a5c6a] text-center mb-10"
                        style="font-family: 'Montserrat', sans-serif;">Calendário de Eventos</h2>
                    <div class="grid grid-cols-12 gap-8 items-start">
                        <div class="col-span-5 bg-white rounded-2xl p-8 shadow-[0_4px_10px_rgba(0,0,0,0.04)]">
                            <div class="flex items-center justify-between mb-6 text-[#11181d]">
                                <a href="{{ route('home', ['mes' => $calendarMesAnterior]) }}"
                                    class="w-10 h-10 rounded-full border border-[#e2e8f0] flex items-center justify-center text-[#334155] hover:bg-slate-50 transition"><i
                                        class="fa-solid fa-chevron-left"></i></a>
                                <span class="text-[1.2rem] font-bold"
                                    style="font-family: 'Montserrat', sans-serif;">{{ $calendarTituloMes }}</span>
                                <a href="{{ route('home', ['mes' => $calendarMesProximo]) }}"
                                    class="w-10 h-10 rounded-full border border-[#e2e8f0] flex items-center justify-center text-[#334155] hover:bg-slate-50 transition"><i
                                        class="fa-solid fa-chevron-right"></i></a>
                            </div>
                            <div class="grid grid-cols-7 text-center gap-2 mb-2">
                                <span class="text-[#94a3b8] font-bold text-[0.85rem] pb-2">D</span>
                                <span class="text-[#94a3b8] font-bold text-[0.85rem] pb-2">S</span>
                                <span class="text-[#94a3b8] font-bold text-[0.85rem] pb-2">T</span>
                                <span class="text-[#94a3b8] font-bold text-[0.85rem] pb-2">Q</span>
                                <span class="text-[#94a3b8] font-bold text-[0.85rem] pb-2">Q</span>
                                <span class="text-[#94a3b8] font-bold text-[0.85rem] pb-2">S</span>
                                <span class="text-[#94a3b8] font-bold text-[0.85rem] pb-2">S</span>
                            </div>
                            <div class="grid grid-cols-7 text-center gap-2">
                                @foreach($calendarDays as $calendarDay)
                                    @php
                                        $classes = 'w-10 h-10 flex items-center justify-center mx-auto rounded-full text-base font-medium ';
                                        if (!$calendarDay['isCurrentMonth'])
                                            $classes .= 'text-[#cbd5e1] ';
                                        else
                                            $classes .= 'text-[#334155] ';

                                        if ($calendarDay['isToday'])
                                            $classes .= 'border-2 border-[#14b8a6] ';
                                        if ($calendarDay['hasEvent'])
                                            $classes .= 'bg-[#64748b] text-white font-bold ';
                                    @endphp
                                    <span class="{{ $classes }}">{{ $calendarDay['day'] }}</span>
                                @endforeach
                            </div>
                        </div>

                        <div class="col-span-7 flex flex-col gap-4">
                            @if(isset($eventos) && $eventos->count() > 0)
                                @foreach($eventos->take(3) as $eventoItem)
                                    <div
                                        class="bg-white rounded-[16px] shadow-[0_4px_10px_rgba(0,0,0,0.04)] flex p-6 gap-6 items-center hover:shadow-md transition-shadow">
                                        <div
                                            class="flex flex-col items-center justify-center border-r border-[#e2e8f0] pr-6 text-[#006eb7] shrink-0">
                                            <span class="text-[2.6rem] font-extrabold leading-none"
                                                style="font-family: 'Montserrat', sans-serif;">{{ \Carbon\Carbon::parse($eventoItem->data_inicio)->format('d') }}</span>
                                            <span
                                                class="text-sm font-semibold lowercase mt-1">{{ \Carbon\Carbon::parse($eventoItem->data_inicio)->translatedFormat('M') }}</span>
                                        </div>
                                        <div>
                                            <h3 class="text-lg font-bold text-[#006eb7] mb-2 leading-snug">{{ $eventoItem->titulo }}
                                            </h3>
                                            <p class="text-sm text-[#334155] mb-1 flex items-center gap-2"><i
                                                    class="fa-solid fa-clock text-slate-400"></i>
                                                {{ \Carbon\Carbon::parse($eventoItem->data_inicio)->format('d \d\e F \à\s H:i') }}
                                            </p>
                                            <p class="text-sm text-[#334155] flex items-center gap-2"><i
                                                    class="fa-solid fa-location-dot text-slate-400"></i>
                                                {{ $eventoItem->local ?? 'Assaí, PR' }}</p>
                                        </div>
                                    </div>
                                @endforeach
                            @else
                                <div
                                    class="bg-white rounded-[16px] shadow-[0_4px_10px_rgba(0,0,0,0.04)] p-8 text-center text-slate-500 font-medium">
                                    Nenhum evento programado para este mês.
                                </div>
                            @endif
                            <div class="mt-6 flex justify-start">
                                <a href="{{ route('agenda.index') }}"
                                    class="bg-[#006eb7] text-white rounded-full px-8 py-3 text-base font-bold flex items-center gap-2 hover:bg-blue-800 transition shadow-md">
                                    <i class="fa-regular fa-calendar-days"></i> Ver todos os Eventos
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </section>

        </div>

        {{-- ==========================================
        SCRIPTS GLOBAIS DA HOME E ALPINEJS
        ========================================== --}}
        <script>
            function searchAutocomplete() {
                return {
                    query: '',
                    results: [],
                    open: false,
                    loading: false,
                    init() {
                        this.$watch('query', value => {
                            if (value.length < 2) {
                                this.results = [];
                                this.open = false;
                                return;
                            }
                            this.fetchResults();
                        });
                    },
                    async fetchResults() {
                        this.loading = true;
                        try {
                            const response = await fetch(`/busca/autocomplete?q=${encodeURIComponent(this.query)}`);
                            const data = await response.json();
                            this.results = data;
                            this.open = true;
                        } catch (e) {
                            console.error('Erro na busca rápida:', e);
                        } finally {
                            this.loading = false;
                        }
                    },
                    get groupedResults() {
                        return this.results.reduce((acc, curr) => {
                            if (!acc[curr.tipo]) acc[curr.tipo] = [];
                            acc[curr.tipo].push(curr);
                            return acc;
                        }, {});
                    },
                    getIcon(tipo) {
                        const icons = {
                            'Notícia': 'fa-newspaper',
                            'Serviço': 'fa-bolt-lightning',
                            'Programa': 'fa-bullhorn',
                            'Secretaria': 'fa-building-columns'
                        };
                        return icons[tipo] || 'fa-magnifying-glass';
                    }
                }
            }

            document.addEventListener('DOMContentLoaded', function () {
                const searchIdeas = [
                    "Emitir Nota Fiscal...",
                    "IPTU...",
                    "Telefones...",
                    "Ouvidoria municipal..."
                ];

                const inputs = [
                    document.getElementById('busca-portal-mobile'),
                    document.getElementById('busca-portal-fixo')
                ];

                let phraseIndex = 0;
                let charIndex = 0;
                let isDeleting = false;

                const typingSpeed = 100;
                const erasingSpeed = 50;
                const delayBetweenPhrases = 2000;
                const delayBeforeRestart = 500;

                function typePlaceholder() {
                    const currentPhrase = searchIdeas[phraseIndex];

                    inputs.forEach(input => {
                        if (input) {
                            if (isDeleting) {
                                input.setAttribute('placeholder', currentPhrase.substring(0, charIndex - 1));
                            } else {
                                input.setAttribute('placeholder', currentPhrase.substring(0, charIndex + 1));
                            }
                        }
                    });

                    if (isDeleting) {
                        charIndex--;
                    } else {
                        charIndex++;
                    }

                    let loopDelay = isDeleting ? erasingSpeed : typingSpeed;

                    if (!isDeleting && charIndex === currentPhrase.length) {
                        loopDelay = delayBetweenPhrases;
                        isDeleting = true;
                    } else if (isDeleting && charIndex === 0) {
                        isDeleting = false;
                        phraseIndex = (phraseIndex + 1) % searchIdeas.length;
                        loopDelay = delayBeforeRestart;
                    }

                    setTimeout(typePlaceholder, loopDelay);
                }

                if (inputs[0] || inputs[1]) {
                    setTimeout(typePlaceholder, delayBetweenPhrases);
                }
            });

            document.addEventListener('DOMContentLoaded', function () {
                var swiperClass = window.Swiper || (typeof Swiper !== 'undefined' ? Swiper : null);

                if (swiperClass) {
                    if (document.querySelector('.swiper-noticias-desktop')) {
                        new swiperClass('.swiper-noticias-desktop', {
                            loop: true,
                            autoplay: { delay: 6000, disableOnInteraction: true },
                            navigation: {
                                nextEl: '.swiper-noticias-desktop .swiper-button-next',
                                prevEl: '.swiper-noticias-desktop .swiper-button-prev',
                            },
                            effect: 'fade',
                            fadeEffect: { crossFade: true }
                        });
                    }

                    if (document.querySelector('.swiper-noticias-mobile')) {
                        new swiperClass('.swiper-noticias-mobile', {
                            loop: true,
                            autoHeight: false,
                            autoplay: { delay: 5000, disableOnInteraction: false },
                            navigation: {
                                nextEl: '.swiper-noticias-mobile .swiper-button-next',
                                prevEl: '.swiper-noticias-mobile .swiper-button-prev',
                            },
                        });
                    }
                }
            });
        </script>
    </main>
@endsection


{{-- ==========================================
MODAIS (Busca Avançada e Banners Pop-up)
========================================== --}}
@push('modals')
    <div x-data="{ modalAberta: false }" @open-modal-busca-avancada.window="modalAberta = true"
        @keydown.escape.window="modalAberta = false" x-show="modalAberta"
        class="fixed inset-0 z-[2147483647] flex items-center justify-center bg-slate-900/70 backdrop-blur-sm" x-cloak
        role="dialog" aria-modal="true" aria-labelledby="modal-busca-avancada-title">

        <div @click.away="modalAberta = false" x-show="modalAberta" x-transition:enter="transition ease-out duration-300"
            x-transition:enter-start="opacity-0 scale-95" x-transition:enter-end="opacity-100 scale-100"
            x-transition:leave="transition ease-in duration-200" x-transition:leave-start="opacity-100 scale-100"
            x-transition:leave-end="opacity-0 scale-95"
            class="bg-white w-full max-w-2xl mx-4 rounded shadow-2xl flex flex-col font-sans">

            <header class="flex items-center justify-between px-6 py-4 border-b border-slate-200">
                <h2 id="modal-busca-avancada-title" class="text-[1.15rem] font-bold text-slate-800"
                    style="font-family: 'Rawline', 'Open Sans', sans-serif;">
                    Busca Avançada
                </h2>
                <button type="button" @click="modalAberta = false" aria-label="Fechar janela de busca avançada"
                    class="text-slate-400 hover:text-slate-700 focus:outline-none focus:ring-2 focus:ring-blue-500 rounded p-1 transition-colors">
                    <i class="fa-solid fa-xmark text-lg" aria-hidden="true"></i>
                </button>
            </header>

            <form action="{{ route('busca.avancada') ?? '#' }}" method="GET" class="p-6 flex flex-col gap-5">
                <div class="flex flex-col gap-1">
                    <label for="adv-keyword" class="sr-only">Digite uma palavra-chave</label>
                    <input type="text" id="adv-keyword" name="q" placeholder="Digite uma palavra-chave"
                        class="w-full border border-slate-300 rounded px-4 py-2.5 text-sm text-slate-700 bg-white focus:border-blue-500 focus:ring-1 focus:ring-blue-500 outline-none transition-colors"
                        autocomplete="off">
                </div>

                <div class="flex flex-col gap-1">
                    <label for="adv-categoria" class="text-[0.85rem] font-bold text-slate-500">Categoria</label>
                    <select id="adv-categoria" name="categoria"
                        class="w-full border border-slate-300 rounded px-4 py-2.5 text-sm text-slate-700 bg-white focus:border-blue-500 focus:ring-1 focus:ring-blue-500 outline-none appearance-none bg-[url('data:image/svg+xml;charset=US-ASCII,%3Csvg%20xmlns%3D%22http%3A%2F%2Fwww.w3.org%2F2000%2Fsvg%22%20width%3D%22292.4%22%20height%3D%22292.4%22%3E%3Cpath%20fill%3D%22%23475569%22%20d%3D%22M287%2069.4a17.6%2017.6%200%200%200-13-5.4H18.4c-5%200-9.3%201.8-12.9%205.4A17.6%2017.6%200%200%200%200%2082.2c0%205%201.8%209.3%205.4%2012.9l128%20127.9c3.6%203.6%207.8%205.4%2012.8%205.4s9.2-1.8%2012.8-5.4L287%2095c3.5-3.5%205.4-7.8%205.4-12.8%200-5-1.9-9.2-5.4-12.8z%22%2F%3E%3C%2Fsvg%3E')] bg-[length:0.7rem_auto] bg-no-repeat bg-[position:right_1rem_center]">
                        <option value="">Todos</option>
                    </select>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                    <div class="flex flex-col gap-1">
                        <label for="adv-modalidade" class="text-[0.85rem] font-bold text-slate-500">Modalidade</label>
                        <select id="adv-modalidade" name="modalidade"
                            class="w-full border border-slate-300 rounded px-4 py-2.5 text-sm text-slate-700 bg-white focus:border-blue-500 outline-none appearance-none bg-[url('data:image/svg+xml;charset=US-ASCII,%3Csvg%20xmlns%3D%22http%3A%2F%2Fwww.w3.org%2F2000%2Fsvg%22%20width%3D%22292.4%22%20height%3D%22292.4%22%3E%3Cpath%20fill%3D%22%23475569%22%20d%3D%22M287%2069.4a17.6%2017.6%200%200%200-13-5.4H18.4c-5%200-9.3%201.8-12.9%205.4A17.6%2017.6%200%200%200%200%2082.2c0%205%201.8%209.3%205.4%2012.9l128%20127.9c3.6%203.6%207.8%205.4%2012.8%205.4s9.2-1.8%2012.8-5.4L287%2095c3.5-3.5%205.4-7.8%205.4-12.8%200-5-1.9-9.2-5.4-12.8z%22%2F%3E%3C%2Fsvg%3E')] bg-[length:0.7rem_auto] bg-no-repeat bg-[position:right_1rem_center]">
                            <option value="">Todos</option>
                        </select>
                    </div>
                    <div class="flex flex-col gap-1">
                        <label for="adv-tag" class="text-[0.85rem] font-bold text-slate-500">Tag</label>
                        <select id="adv-tag" name="tag"
                            class="w-full border border-slate-300 rounded px-4 py-2.5 text-sm text-slate-700 bg-white focus:border-blue-500 outline-none appearance-none bg-[url('data:image/svg+xml;charset=US-ASCII,%3Csvg%20xmlns%3D%22http%3A%2F%2Fwww.w3.org%2F2000%2Fsvg%22%20width%3D%22292.4%22%20height%3D%22292.4%22%3E%3Cpath%20fill%3D%22%23475569%22%20d%3D%22M287%2069.4a17.6%2017.6%200%200%200-13-5.4H18.4c-5%200-9.3%201.8-12.9%205.4A17.6%2017.6%200%200%200%200%2082.2c0%205%201.8%209.3%205.4%2012.9l128%20127.9c3.6%203.6%207.8%205.4%2012.8%205.4s9.2-1.8%2012.8-5.4L287%2095c3.5-3.5%205.4-7.8%205.4-12.8%200-5-1.9-9.2-5.4-12.8z%22%2F%3E%3C%2Fsvg%3E')] bg-[length:0.7rem_auto] bg-no-repeat bg-[position:right_1rem_center]">
                            <option value="">Todos</option>
                        </select>
                    </div>
                </div>

                <div class="flex flex-col gap-1">
                    <label for="adv-servico" class="text-[0.85rem] font-bold text-slate-500">Serviço</label>
                    <select id="adv-servico" name="servico"
                        class="w-full border border-[#4eb1d8] rounded px-4 py-2.5 text-sm text-slate-700 bg-white focus:border-blue-600 focus:ring-1 focus:ring-blue-600 outline-none appearance-none bg-[url('data:image/svg+xml;charset=US-ASCII,%3Csvg%20xmlns%3D%22http%3A%2F%2Fwww.w3.org%2F2000%2Fsvg%22%20width%3D%22292.4%22%20height%3D%22292.4%22%3E%3Cpath%20fill%3D%22%23475569%22%20d%3D%22M287%2069.4a17.6%2017.6%200%200%200-13-5.4H18.4c-5%200-9.3%201.8-12.9%205.4A17.6%2017.6%200%200%200%200%2082.2c0%205%201.8%209.3%205.4%2012.9l128%20127.9c3.6%203.6%207.8%205.4%2012.8%205.4s9.2-1.8%2012.8-5.4L287%2095c3.5-3.5%205.4-7.8%205.4-12.8%200-5-1.9-9.2-5.4-12.8z%22%2F%3E%3C%2Fsvg%3E')] bg-[length:0.7rem_auto] bg-no-repeat bg-[position:right_1rem_center]">
                        <option value="">Todos</option>
                    </select>
                </div>

                <div class="flex items-center border border-slate-300 rounded px-4 py-3 bg-white mt-1">
                    <label for="adv-novos" class="flex items-center cursor-pointer relative gap-3 w-full">
                        <input type="checkbox" id="adv-novos" name="somente_novos" class="sr-only peer" value="1">
                        <div
                            class="w-10 h-5 bg-slate-300 rounded-full peer-focus:outline-none peer-focus:ring-2 peer-focus:ring-blue-500 peer-checked:bg-[#4eb1d8] transition-colors relative">
                            <div
                                class="absolute left-[2px] top-[2px] bg-white border border-slate-300 h-4 w-4 rounded-full transition-transform peer-checked:translate-x-5 peer-checked:border-white">
                            </div>
                        </div>
                        <span class="text-[0.95rem] font-bold text-slate-500 select-none">Somente serviços novos</span>
                    </label>
                </div>

                <div class="flex items-center justify-end gap-3 mt-4 pt-4 border-t border-slate-100">
                    <button type="button" @click="modalAberta = false"
                        class="px-5 py-2 text-sm font-bold text-slate-700 bg-slate-50 border border-slate-200 rounded hover:bg-slate-100 focus:outline-none focus:ring-2 focus:ring-slate-300 transition-colors">
                        Cancelar
                    </button>
                    <button type="submit"
                        class="px-5 py-2 text-sm font-bold text-white bg-[#4eb1d8] rounded hover:bg-[#3ca3ca] focus:outline-none focus:ring-2 focus:ring-[#4eb1d8] focus:ring-offset-1 flex items-center gap-2 transition-colors">
                        <i class="fa-solid fa-magnifying-glass" aria-hidden="true"></i> Buscar
                    </button>
                </div>
            </form>
        </div>
    </div>

    @if(isset($banners) && $banners->count() > 0)
        <style>
            #banner-portal-modal {
                position: fixed;
                inset: 0;
                z-index: 2147483647;
                background-color: rgba(0, 0, 0, 0.95);
                display: flex;
                align-items: center;
                justify-content: center;
                opacity: 0;
                pointer-events: none;
                transition: opacity 0.4s ease;
            }

            #banner-portal-modal.is-visible {
                opacity: 1;
                pointer-events: auto;
            }

            .modal-banner-close {
                position: absolute;
                top: 16px;
                right: 16px;
                width: 44px;
                height: 44px;
                background: rgba(255, 255, 255, 0.1);
                border: 1px solid rgba(255, 255, 255, 0.3);
                border-radius: 50%;
                color: white;
                font-size: 20px;
                display: flex;
                align-items: center;
                justify-content: center;
                cursor: pointer;
                z-index: 2147483648;
            }

            .modal-banner-close:hover {
                background: rgba(220, 38, 38, 0.9);
            }

            .swiper-modal-vanilla {
                width: 100vw;
                height: 85dvh;
                max-width: 900px;
                display: block;
                position: relative;
            }

            .swiper-modal-vanilla .swiper-slide {
                display: flex;
                align-items: center;
                justify-content: center;
                width: 100%;
                height: 100%;
            }

            .swiper-modal-vanilla img {
                max-width: 95vw;
                max-height: 85dvh;
                object-fit: contain;
                display: block;
                margin: 0 auto;
            }

            .nav-modal-exclusiva {
                background-color: rgba(0, 0, 0, 0.6) !important;
                background-image: none !important;
                color: rgba(255, 255, 255, 0.9) !important;
                width: 48px !important;
                height: 48px !important;
                border-radius: 50% !important;
                align-items: center !important;
                justify-content: center !important;
                transition: all 0.3s ease;
                display: none;
            }

            .nav-modal-exclusiva:hover {
                background-color: rgba(0, 0, 0, 0.9) !important;
                color: #ffffff !important;
                transform: scale(1.05);
            }

            .nav-modal-exclusiva>* {
                display: none !important;
            }

            .nav-modal-exclusiva::after {
                display: block !important;
                font-family: 'swiper-icons' !important;
                font-size: 20px !important;
                font-weight: 900 !important;
            }

            @media (min-width: 768px) {
                .nav-modal-exclusiva {
                    display: flex !important;
                }
            }
        </style>

        <div id="banner-portal-modal" onclick="if(event.target === this) fecharBannerModal()">
            <button class="modal-banner-close" onclick="fecharBannerModal()" aria-label="Fechar">
                <i class="fa-solid fa-xmark"></i>
            </button>
            <div class="swiper swiper-modal-vanilla">
                <div class="swiper-wrapper">
                    @foreach($banners as $banner)
                        <div class="swiper-slide">
                            @if($banner->link) <a href="{{ $banner->link }}" target="_blank"
                            style="display:block; width:100%; height:100%;"> @endif
                                <img src="{{ asset('storage/' . $banner->imagem) }}" alt="Banner Modal">
                                @if($banner->link) </a> @endif
                        </div>
                    @endforeach
                </div>
                @if($banners->count() > 1)
                    <div class="swiper-pagination"></div>
                    <div class="swiper-button-prev nav-modal-exclusiva seta-unica-prev"></div>
                    <div class="swiper-button-next nav-modal-exclusiva seta-unica-next"></div>
                @endif
            </div>
        </div>

        <script>
            function fecharBannerModal() {
                var modal = document.getElementById('banner-portal-modal');
                if (modal) {
                    modal.classList.remove('is-visible');
                    document.body.style.overflow = '';
                }
            }

            document.addEventListener('DOMContentLoaded', function () {
                var mobileLoader = document.getElementById('hero-mobile-loader');
                var desktopLoader = document.getElementById('hero-video-loader');
                var modal = document.getElementById('banner-portal-modal');
                var swiperInstanciado = false;

                function isLoaderVisible(el) {
                    return el && window.getComputedStyle(el).display !== 'none' && !el.classList.contains('hidden') && el.style.opacity !== '0';
                }

                function tryInitModal() {
                    if (isLoaderVisible(mobileLoader) || isLoaderVisible(desktopLoader)) {
                        setTimeout(tryInitModal, 500);
                        return;
                    }

                    if (modal) {
                        modal.classList.add('is-visible');
                        document.body.style.overflow = 'hidden';

                        if (!swiperInstanciado) {
                            var swiperClass = window.Swiper || (typeof Swiper !== 'undefined' ? Swiper : null);
                            if (swiperClass) {
                                new swiperClass('.swiper-modal-vanilla', {
                                    loop: true,
                                    autoplay: { delay: 6000, disableOnInteraction: false },
                                    pagination: { el: '.swiper-pagination', clickable: true },
                                    navigation: { nextEl: '.seta-unica-next', prevEl: '.seta-unica-prev' },
                                });
                                swiperInstanciado = true;
                            }
                        }
                    }
                }
                setTimeout(tryInitModal, 1000);
            });
        </script>
    @endif
@endpush