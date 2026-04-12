@extends('layouts.app')

@section('title', 'Portal - Prefeitura de Assaí')

@section('content')

<main id="home-main" class="transition-opacity duration-300">

    <div id="hero-mobile-loader" class="fixed inset-0 z-[200] flex items-center justify-center bg-gradient-to-b from-slate-950 via-blue-950 to-slate-900 text-white transition-opacity duration-500 lg:hidden" aria-live="polite">
        <div class="flex flex-col items-center gap-5 px-6 text-center">
            <img src="{{ asset('img/logo_branca.png') }}" alt="Prefeitura de Assaí" loading="eager" decoding="sync" fetchpriority="high" class="w-56 max-w-[80vw] h-auto object-contain">
            <div class="flex items-center gap-3 text-xs sm:text-sm font-semibold tracking-[0.18em] uppercase text-blue-100">
                <span class="inline-block h-5 w-5 rounded-full border-2 border-white/35 border-t-white animate-spin" aria-hidden="true"></span>
                Preparando experiência
            </div>
        </div>
    </div>

    <div id="hero-video-loader" class="hidden lg:flex fixed inset-0 z-[200] items-center justify-center bg-gradient-to-b from-slate-950 via-blue-950 to-slate-900 text-white transition-opacity duration-500" aria-live="polite">
        <div class="flex flex-col items-center gap-5 px-6 text-center">
            <img src="{{ asset('img/logo_branca.png') }}" alt="Prefeitura de Assaí" loading="eager" decoding="sync" fetchpriority="high" class="w-56 max-w-[80vw] h-auto object-contain">
            <div class="flex items-center gap-3 text-xs sm:text-sm font-semibold tracking-[0.18em] uppercase text-blue-100">
                <span class="inline-block h-5 w-5 rounded-full border-2 border-white/35 border-t-white animate-spin" aria-hidden="true"></span>
                Preparando experiência
            </div>
        </div>
    </div>

    @php
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
    ->filter(fn ($evento) => !empty($evento->data_inicio))
    ->map(fn ($evento) => \Carbon\Carbon::parse($evento->data_inicio)->toDateString())
    ->unique()
    ->values()
    ->all();

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
    <div class="lg:hidden pl-mobile-home" id="pl-mobile-home">

        {{-- Hero --}}
        <div class="home-hero-mobile">
            <div class="home-hero-content">
                <h1 class="hero-title">O QUE VOCÊ <strong>PRECISA?</strong></h1>
                <form action="{{ route('busca.index') }}" method="GET" 
                      class="home-search-bar relative" 
                      role="search"
                      x-data="searchAutocomplete()"
                      x-on:click.outside="open = false"
                      @submit="open = false">
                    <input id="busca-portal-mobile" class="home-search-input-custom" type="search" name="q" placeholder="Emitir Nota fiscal..." required
                           x-model.debounce.300ms="query"
                           @focus="if(results.length > 0) open = true"
                           @keydown.escape="open = false"
                           autocomplete="off">
                    <button class="home-search-button-custom" type="submit" aria-label="Pesquisar">
                        <i class="fa-solid fa-magnifying-glass" aria-hidden="true" x-show="!loading"></i>
                        <template x-if="loading">
                            <span class="inline-block w-4 h-4 border-2 border-white/30 border-t-white rounded-full animate-spin"></span>
                        </template>
                    </button>

                    {{-- Dropdown de Sugestões (Mobile) --}}
                    <div x-show="open" 
                         x-transition:enter="transition ease-out duration-200"
                         x-transition:enter-start="opacity-0 translate-y-1"
                         x-transition:enter-end="opacity-100 translate-y-0"
                         x-cloak
                         class="search-suggestions-dropdown text-left">
                        
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
            </div>
        </div>

    </div>

    {{-- HERO DESKTOP --}}
    <section id="hero-oficial" class="hidden lg:block relative w-full bg-slate-950 py-40 md:py-56" style="padding-top: var(--site-header-height,130px);">
        <div class="absolute inset-0 z-0 bg-slate-950">
            <video id="hero-video-lazy" class="w-full h-full object-cover object-center opacity-0 transition-opacity duration-1000" muted loop playsinline poster="{{ asset('img/Assai.jpg') }}" preload="none">
                <source data-src="{{ asset('videos/panorama.mp4') }}" type="video/mp4">
            </video>
            <div class="absolute inset-0 bg-gradient-to-b from-slate-900/60 via-blue-950/40 to-slate-900/60"></div>
        </div>
        <div class="relative z-50 container mx-auto max-w-4xl flex flex-col items-center justify-center px-4" x-data="searchAutocomplete()" @click.outside="open = false">
            <h1 class="mt-16 mb-6 text-3xl md:text-5xl font-extrabold text-white drop-shadow-md font-heading leading-tight text-center break-words">O QUE VOCÊ <strong>PRECISA?</strong></h1>
            <form action="{{ route('busca.index') }}" method="GET" 
                  class="relative flex items-center w-full max-w-2xl bg-white/95 focus-within:bg-white backdrop-blur-md shadow-2xl rounded-full border border-white/60 transition-all duration-300 p-1" 
                  role="search"
                  @submit="open = false">
                <label for="busca-portal-fixo" class="sr-only">Buscar no portal</label>
                <div class="flex items-center justify-center pl-4 md:pl-5 pr-2 text-slate-400 shrink-0 hidden md:flex" aria-hidden="true">
                    <template x-if="!loading">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                        </svg>
                    </template>
                    <template x-if="loading">
                        <div class="search-loader"></div>
                    </template>
                </div>
                <input id="busca-portal-fixo" type="text" name="q" placeholder="Emitir Nota Fiscal..." required 
                       class="flex-1 min-w-0 px-3 py-2.5 text-sm text-gray-800 bg-transparent border-none md:px-2 md:py-4 md:text-base focus:ring-0 focus:outline-none font-sans placeholder:text-slate-400 w-full"
                       x-model.debounce.300ms="query"
                       @focus="if(results.length > 0) open = true"
                       @keydown.escape="open = false"
                       autocomplete="off">
                <button type="submit" class="m-1.5 px-3.5 max-[360px]:px-3 py-2.5 max-[360px]:py-2 font-bold text-sm text-blue-900 transition-all bg-yellow-400 rounded-full shrink-0 md:px-6 md:py-3 hover:bg-yellow-500 hover:shadow-lg font-heading">
                    Buscar
                </button>

                {{-- Dropdown de Sugestões --}}
                <div x-show="open" 
                     x-transition:enter="transition ease-out duration-200"
                     x-transition:enter-start="opacity-0 translate-y-1"
                     x-transition:enter-end="opacity-100 translate-y-0"
                     x-cloak
                     class="search-suggestions-dropdown text-left">
                    
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

                    {{-- No Results State --}}
                    <template x-if="results.length === 0 && query.length >= 2 && !loading">
                        <div class="p-6 text-center text-slate-500 text-sm italic">
                            Nenhum resultado rápido encontrado para "<span x-text="query"></span>"
                        </div>
                    </template>
                </div>
            </form>
            @if($sugestoesBusca->count() > 0)
            <div x-show="!open" x-transition.opacity class="flex flex-wrap items-center justify-center gap-2 mt-3 md:mt-4 max-w-xs sm:max-w-2xl lg:max-w-4xl px-2 sm:px-4 mx-auto">
                @foreach($sugestoesBusca as $sugestao)
                <a href="{{ route('busca.index', ['q' => $sugestao]) }}" class="inline-flex items-center gap-1.5 px-3 py-1.5 text-[11px] sm:text-xs font-semibold text-white cursor-pointer select-none transition-all duration-200 bg-white/10 border border-white/25 backdrop-blur-sm rounded-full hover:bg-blue-600 hover:text-white hover:border-transparent hover:shadow-md active:scale-95 focus:outline-none focus:ring-2 focus:ring-white/60 font-sans whitespace-nowrap">
                    <svg class="w-3 h-3 opacity-70" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                    </svg>
                    {{ $sugestao }}
                </a>
                @endforeach
            </div>
            @endif
        </div>
        <div class="absolute bottom-6 md:bottom-10 left-1/2 -translate-x-1/2 z-30 flex flex-col items-center">
            <span class="hidden md:block mb-3 text-[10px] font-bold tracking-[0.2em] text-white/70 uppercase">Role para explorar</span>
            <a href="#servicos-desktop" class="inline-flex items-center justify-center w-10 h-10 md:w-12 md:h-12 text-white transition-all duration-300 border border-white/20 rounded-full bg-white/10 backdrop-blur-md hover:bg-white/20 hover:scale-110 animate-bounce focus:outline-none focus:ring-2 focus:ring-yellow-400 shadow-lg"><svg class="w-5 h-5 md:w-6 md:h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 14l-7 7m0 0l-7-7m7 7V3"></path>
                </svg></a>
        </div>
    </section>

    {{-- ==========================================
         MOBILE SECTION
         ========================================== --}}
    <section class="lg:hidden pl-mobile-home">
        {{-- Mais Acessados --}}
        <section class="bg-white-section">
            <h2 class="section-title font-bold">Mais Acessados</h2>
            <div class="small-cards-grid">

                @if(isset($servicos) && $servicos->count() > 0)
                @foreach($servicos->take(8) as $servicoItem)
                <div class="small-card group relative">
                    <a href="{{ route('servicos.acessar', $servicoItem->id) }}" target="_blank" rel="noopener" class="flex flex-col items-center justify-center w-full h-full px-1 z-0 py-3">
                        @php
                        $iconeServico = !empty($servicoItem->icone) ? str_replace(['fa-', 'fas ', 'fa-solid '], '', $servicoItem->icone) : 'file-lines';
                        @endphp
                        <i class="fa-solid fa-{{ $iconeServico }} service-icon" aria-hidden="true"></i>
                        <h4 class="small-card-title">{{ $servicoItem->titulo }}</h4>
                    </a>
                </div>
                @endforeach
                @else
                @foreach(collect($servicosPlMobile)->take(8) as $servicoItem)
                <div class="small-card group relative">
                    <a href="{{ $servicoItem['link'] }}" target="_blank" rel="noopener" class="flex flex-col items-center justify-center w-full h-full px-1 z-0 py-3">
                        <i class="fa-solid {{ $servicoItem['icone'] }} service-icon" aria-hidden="true"></i>
                        <h4 class="small-card-title">{{ $servicoItem['titulo'] }}</h4>
                    </a>
                </div>
                @endforeach
                @endif
            </div>

            <div class="all-btn-wrapper">
                <a href="{{ route('servicos.index') }}" class="all-btn">
                    <i class="fa-solid fa-table-cells-large" aria-hidden="true"></i> Ver Todos Serviços
                </a>
            </div>
        </section>

        {{-- Fique Ligado (Swiper Mobile) --}}
        <section class="bg-gray-section" style="padding-top: 1.5rem; padding-bottom: 2.5rem;">
            <h2 class="section-title mb-6 font-bold">Fique ligado</h2>
            @if(isset($programas) && $programas->count() > 0)
            <div class="px-4 w-full">
                <div class="swiper swiper-fique-ligado h-[360px] w-full rounded-[16px] shadow-md overflow-hidden relative">
                    <div class="swiper-wrapper">
                        @foreach($programas as $programa)
                        <div class="swiper-slide relative h-[360px] bg-slate-100">
                            <a href="{{ route('programas.show', $programa) }}" class="block w-full h-full">
                                <img src="{{ $programa->imagem ? asset('storage/' . $programa->imagem) : asset('img/Assai.jpg') }}" alt="{{ $programa->titulo }}" loading="lazy" class="absolute inset-0 object-cover w-full h-full">
                                <div class="absolute inset-0 bg-gradient-to-t from-[#020617] via-[#020617]/30 to-transparent pointer-events-none"></div>
                                <div class="absolute bottom-0 left-0 w-full p-4 bg-white/10 backdrop-blur-sm border-t border-white/20 z-10 flex flex-col justify-end">
                                    <h3 class="text-xl font-bold text-white leading-snug drop-shadow-lg text-center w-full flex justify-center items-center" style="font-family: 'Montserrat', sans-serif;">{{ Str::limit($programa->titulo, 70) }}</h3>
                                </div>
                            </a>
                        </div>
                        @endforeach
                    </div>

                    <div class="swiper-pagination !bottom-3"></div>
                    <div class="swiper-button-prev program-swiper-arrow program-swiper-arrow-mobile !text-[#0b2f57]"></div>
                    <div class="swiper-button-next program-swiper-arrow program-swiper-arrow-mobile !text-[#0b2f57]"></div>
                </div>
            </div>
            <div class="mt-8 flex justify-center w-full pb-4">
                <a href="{{ route('programas.index') }}" class="bg-[#006eb7] text-white rounded-full px-8 py-3 text-sm font-bold flex items-center gap-2 hover:bg-blue-800 transition shadow-md">
                    <i class="fa-solid fa-bullhorn"></i> Ver Todos Programas
                </a>
            </div>
            @endif
        </section>

        {{-- Últimas Notícias --}}
        <section class="bg-white-section">
            <h2 class="section-title font-bold">Últimas Notícias</h2>
            <div class="mobile-news-grid">
                @if(isset($noticias) && $noticias->count() > 0)
                @foreach($noticias->take(3) as $noticia)
                <article class="card-news relative h-[320px] overflow-hidden rounded-2xl group bg-slate-100 shadow-md">
                    <a href="{{ route('noticias.show', $noticia->slug) }}" class="block w-full h-full outline-none focus-within:ring-4 focus-within:ring-blue-500 focus-within:ring-inset">
                        <img src="{{ $noticia->imagem_capa ? asset('storage/' . $noticia->imagem_capa) : asset('img/Assai.jpg') }}" alt="" loading="lazy" class="absolute inset-0 object-cover w-full h-full transition-transform duration-700 ease-out group-hover:scale-105">
                        <div class="absolute inset-0 bg-gradient-to-t from-black/80 via-black/20 to-transparent opacity-80 pointer-events-none"></div>
                        <div class="absolute bottom-0 left-0 w-full p-5 bg-white/10 backdrop-blur-lg border-t border-white/30 z-10">
                            <h2 class="text-sm font-bold leading-snug text-white font-heading drop-shadow-md">{{ ucfirst(Str::lower($noticia->titulo)) }}</h2>
                        </div>
                    </a>
                </article>
                @endforeach
                @else
                <div class="rounded-2xl border border-dashed border-slate-300 bg-white px-5 py-8 text-center text-sm text-slate-500 shadow-sm">
                    Nenhuma notícia publicada no momento.
                </div>
                @endif
            </div>
            <div class="all-btn-wrapper">
                <a href="{{ route('noticias.index') }}" class="all-btn">
                    <i class="fa-regular fa-newspaper" aria-hidden="true"></i> Ver Todas Notícias
                </a>
            </div>
        </section>

        {{-- Calendário --}}
        <section class="bg-gray-section" style="padding-top: 2.5rem;">
            <h2 class="section-title font-bold">Calendário de Eventos</h2>

            <div class="calendar-wrap">
                <div class="calendar-head">
                    <a href="{{ route('home', ['mes' => $calendarMesAnterior]) }}" class="arrow-btn" aria-label="Mês anterior"><i class="fa-solid fa-chevron-left" aria-hidden="true"></i></a>
                    <span class="month-name">{{ $calendarTituloMes }}</span>
                    <a href="{{ route('home', ['mes' => $calendarMesProximo]) }}" class="arrow-btn" aria-label="Próximo mês"><i class="fa-solid fa-chevron-right" aria-hidden="true"></i></a>
                </div>
                <div class="calendar-grid">
                    <span class="day-name">D</span><span class="day-name">S</span><span class="day-name">T</span><span class="day-name">Q</span><span class="day-name">Q</span><span class="day-name">S</span><span class="day-name">S</span>
                    @foreach($calendarDays as $calendarDay)
                    @php
                    $calendarClasses = 'day-number';
                    if (!$calendarDay['isCurrentMonth']) {
                    $calendarClasses .= ' muted';
                    }
                    if ($calendarDay['isToday']) {
                    $calendarClasses .= ' today';
                    }
                    if ($calendarDay['hasEvent']) {
                    $calendarClasses .= ' event';
                    }
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
                    <span class="month">{{ \Carbon\Carbon::parse($eventoItem->data_inicio)->translatedFormat('M') }}</span>
                </div>
                <div>
                    <h3 class="event-title">{{ $eventoItem->titulo }}</h3>
                    <p class="event-meta"><i class="fa-solid fa-clock"></i> {{ \Carbon\Carbon::parse($eventoItem->data_inicio)->format('d \d\e F \à\s H:i') }}</p>
                    <p class="event-meta"><i class="fa-solid fa-location-dot"></i> {{ $eventoItem->local ?? 'Assaí, PR' }}</p>
                </div>
            </div>
            @endforeach
            @endif

            <div class="all-btn-wrapper">
                <a href="{{ route('agenda.index') }}" class="all-btn"><i class="fa-regular fa-calendar-days"></i> Ver todos os Eventos</a>
            </div>
        </section>

    </section>

    {{-- ==========================================
         DESKTOP SECTION
         ========================================== --}}
    {{-- SERVIÇOS (DESKTOP) --}}
    <section id="servicos-desktop" class="hidden lg:block py-16 bg-white border-b border-[#e2e8f0]" style="scroll-margin-top: calc(var(--site-header-height, 130px) + 16px);">
        <div class="container px-4 mx-auto max-w-6xl font-sans">
            <h2 class="text-[1.72rem] font-bold text-[#4a5c6a] text-center mb-10" style="font-family: 'Montserrat', sans-serif;">Mais Acessados</h2>

            @if(isset($servicos) && $servicos->count() > 0)
            <div class="grid grid-cols-4 lg:grid-cols-5 gap-4">
                @foreach($servicos->take(10) as $servico)
                <a href="{{ route('servicos.acessar', $servico->id) }}" target="_blank" rel="noopener" class="bg-white rounded-[22px] border border-[#edf2f7] p-5 flex flex-col items-center justify-center text-center relative shadow-[0_6px_14px_rgba(15,23,42,0.07)] hover:-translate-y-1 transition-transform duration-300 group">
                    @php
                    $iconeServico = !empty($servico->icone) ? str_replace(['fa-', 'fas ', 'fa-solid '], '', $servico->icone) : 'file-lines';
                    @endphp
                    <i class="fa-solid fa-{{ $iconeServico }} text-6xl text-[#006eb7] mb-3 mt-2"></i>
                    <h3 class="text-lg font-medium text-[#006eb7] leading-snug">{{ $servico->titulo }}</h3>
                </a>
                @endforeach
            </div>

            <div class="mt-10 flex justify-center">
                <a href="{{ route('servicos.index') }}" class="bg-[#006eb7] text-white rounded-full px-8 py-3 text-base font-bold flex items-center gap-2 hover:bg-blue-800 transition shadow-md">
                    <i class="fa-solid fa-table-cells-large"></i> Ver Todos Serviços
                </a>
            </div>
            @else
            <div class="grid grid-cols-4 lg:grid-cols-5 gap-4">
                @foreach(collect($servicosPlMobile)->take(10) as $servico)
                <a href="{{ $servico['link'] }}" target="_blank" rel="noopener" class="bg-white rounded-[22px] border border-[#edf2f7] p-5 flex flex-col items-center justify-center text-center relative shadow-[0_6px_14px_rgba(15,23,42,0.07)] hover:-translate-y-1 transition-transform duration-300 group">
                    <i class="fa-solid {{ $servico['icone'] }} text-4xl text-[#006eb7] mb-3 mt-2"></i>
                    <h3 class="text-[0.95rem] font-medium text-[#006eb7] leading-snug">{{ $servico['titulo'] }}</h3>
                </a>
                @endforeach
            </div>
            <div class="mt-10 flex justify-center">
                <a href="{{ route('servicos.index') }}" class="bg-[#006eb7] text-white rounded-full px-8 py-3 text-base font-bold flex items-center gap-2 hover:bg-blue-800 transition shadow-md">
                    <i class="fa-solid fa-table-cells-large"></i> Ver Todos Serviços
                </a>
            </div>
            @endif
        </div>
    </section>

    {{-- PROGRAMAS E AÇÕES (Swiper Desktop) --}}
    <section id="programas-desktop" class="hidden lg:block pb-16 pt-10 bg-[#eef1f5]">
        <div class="container px-4 mx-auto max-w-6xl font-sans">
            <h2 class="text-[1.72rem] font-bold text-[#4a5c6a] text-center mb-10" style="font-family: 'Montserrat', sans-serif;">Fique ligado</h2>

            @if(isset($programas) && $programas->count() > 0)
            <div class="relative h-[520px] w-full rounded-[22px] overflow-hidden shadow-[0_8px_30px_rgb(0,0,0,0.12)] bg-slate-100">
                <div class="swiper swiper-fique-ligado h-[520px] w-full">
                    <div class="swiper-wrapper">
                        @foreach($programas as $programa)
                        <div class="swiper-slide relative h-[520px] w-full bg-slate-100">
                            <a href="{{ route('programas.show', $programa) }}" class="block w-full h-full focus:outline-none focus:ring-4 focus:ring-inset focus:ring-[#006eb7]">
                                <img src="{{ $programa->imagem ? asset('storage/' . $programa->imagem) : asset('img/Assai.jpg') }}" alt="{{ $programa->titulo }}" loading="lazy" class="absolute inset-0 object-cover w-full h-full">
                                <div class="absolute inset-0 bg-gradient-to-t from-[#020617] via-[#020617]/30 to-transparent pointer-events-none"></div>
                                <div class="absolute bottom-0 left-0 w-full p-4 md:p-6 bg-white/10 backdrop-blur-sm border-t border-white/20 z-10">
                                    <h3 class="text-3xl md:text-4xl font-bold text-white leading-tight drop-shadow-lg max-w-4xl mx-auto text-center" style="font-family: 'Montserrat', sans-serif;">
                                        {{ $programa->titulo }}
                                    </h3>
                                </div>
                            </a>
                        </div>
                        @endforeach
                    </div>

                    <div class="swiper-pagination !bottom-5"></div>
                </div>
            </div>

            <div class="mt-10 flex justify-center w-full">
                <a href="{{ route('programas.index') }}" class="bg-[#006eb7] text-white rounded-full px-8 py-3 text-base font-bold flex items-center gap-2 hover:bg-blue-800 transition shadow-md">
                    <i class="fa-solid fa-bullhorn"></i> Ver Todos Programas
                </a>
            </div>
            @endif
        </div>
    </section>

    {{-- NOTÍCIAS (DESKTOP) --}}
    <section id="noticias-desktop" class="hidden lg:block py-16 bg-white">
        <div class="container px-4 mx-auto max-w-6xl font-sans">
            <h2 class="text-[1.72rem] font-bold text-[#4a5c6a] text-center mb-10" style="font-family: 'Montserrat', sans-serif;">Últimas Notícias</h2>

            @if(isset($noticias) && $noticias->count() > 0)
            <div class="grid grid-cols-3 gap-6">
                @foreach($noticias->take(3) as $noticia)
                <article class="relative rounded-[16px] overflow-hidden shadow-[0_4px_10px_rgba(0,0,0,0.08)] group h-[460px] bg-slate-50">
                    <a href="{{ route('noticias.show', $noticia->slug) }}" class="block w-full h-full outline-none focus-within:ring-4 focus-within:ring-blue-500 focus-within:ring-inset">
                        <img src="{{ $noticia->imagem_capa ? asset('storage/' . $noticia->imagem_capa) : asset('img/Assai.jpg') }}" class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-105" alt="{{ $noticia->titulo }}">
                        <div class="absolute inset-0 bg-gradient-to-t from-[#020617]/80 via-[#020617]/10 to-transparent pointer-events-none"></div>

                        <div class="absolute bottom-0 left-0 w-full p-6 bg-white/10 backdrop-blur-md border-t border-white/30 z-10 flex flex-col justify-end transition-all duration-500">
                            <h3 class="text-[1.05rem] font-semibold text-white leading-snug drop-shadow-md" style="font-family: 'Montserrat', sans-serif;">{{ ucfirst(Str::lower($noticia->titulo)) }}</h3>

                            <div class="grid grid-rows-[0fr] group-hover:grid-rows-[1fr] transition-all duration-500 ease-in-out mt-2">
                                <div class="overflow-hidden opacity-0 group-hover:opacity-100 transition-opacity duration-500 delay-150">
                                    <p class="pt-2 text-[13px] leading-relaxed text-gray-100 font-sans line-clamp-4 mb-4">
                                        {{ $noticia->resumo ?? Str::limit(strip_tags($noticia->conteudo), 160) }}
                                    </p>
                                    <div class="flex items-center justify-between border-t border-white/20 pt-4">
                                        <span class="text-[10px] font-bold text-yellow-400 uppercase tracking-widest drop-shadow-sm">Ler mais</span>
                                        <time class="text-[10px] font-medium text-gray-300">{{ \Carbon\Carbon::parse($noticia->data_publicacao)->format('d/m/Y') }}</time>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </a>
                </article>
                @endforeach
            </div>

            <div class="mt-10 flex justify-center">
                <a href="{{ route('noticias.index') }}" class="bg-[#006eb7] text-white rounded-full px-8 py-3 text-base font-bold flex items-center gap-2 hover:bg-blue-800 transition shadow-md">
                    <i class="fa-regular fa-newspaper"></i> Ver Todas Notícias
                </a>
            </div>
            @endif
        </div>
    </section>

    {{-- AGENDA (DESKTOP) --}}
    <section id="agenda-desktop" class="hidden lg:block py-16 bg-[#eef1f5]">
        <div class="container px-4 mx-auto max-w-6xl font-sans">
            <h2 class="text-[1.72rem] font-bold text-[#4a5c6a] text-center mb-10" style="font-family: 'Montserrat', sans-serif;">Calendário de Eventos</h2>

            <div class="grid grid-cols-12 gap-8 items-start">

                <div class="col-span-5 bg-white rounded-2xl p-8 shadow-[0_4px_10px_rgba(0,0,0,0.04)]">
                    <div class="flex items-center justify-between mb-6 text-[#11181d]">
                        <a href="{{ route('home', ['mes' => $calendarMesAnterior]) }}" class="w-10 h-10 rounded-full border border-[#e2e8f0] flex items-center justify-center text-[#334155] hover:bg-slate-50 transition"><i class="fa-solid fa-chevron-left"></i></a>
                        <span class="text-[1.2rem] font-bold" style="font-family: 'Montserrat', sans-serif;">{{ $calendarTituloMes }}</span>
                        <a href="{{ route('home', ['mes' => $calendarMesProximo]) }}" class="w-10 h-10 rounded-full border border-[#e2e8f0] flex items-center justify-center text-[#334155] hover:bg-slate-50 transition"><i class="fa-solid fa-chevron-right"></i></a>
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
                        if(!$calendarDay['isCurrentMonth']) $classes .= 'text-[#cbd5e1] ';
                        else $classes .= 'text-[#334155] ';

                        if($calendarDay['isToday']) $classes .= 'border-2 border-[#14b8a6] ';
                        if($calendarDay['hasEvent']) $classes .= 'bg-[#64748b] text-white font-bold ';
                        @endphp
                        <span class="{{ $classes }}">{{ $calendarDay['day'] }}</span>
                        @endforeach
                    </div>
                </div>

                <div class="col-span-7 flex flex-col gap-4">
                    @if(isset($eventos) && $eventos->count() > 0)
                    @foreach($eventos->take(3) as $eventoItem)
                    <div class="bg-white rounded-[16px] shadow-[0_4px_10px_rgba(0,0,0,0.04)] flex p-6 gap-6 items-center hover:shadow-md transition-shadow">
                        <div class="flex flex-col items-center justify-center border-r border-[#e2e8f0] pr-6 text-[#006eb7] shrink-0">
                            <span class="text-[2.6rem] font-extrabold leading-none" style="font-family: 'Montserrat', sans-serif;">{{ \Carbon\Carbon::parse($eventoItem->data_inicio)->format('d') }}</span>
                            <span class="text-sm font-semibold lowercase mt-1">{{ \Carbon\Carbon::parse($eventoItem->data_inicio)->translatedFormat('M') }}</span>
                        </div>
                        <div>
                            <h3 class="text-lg font-bold text-[#006eb7] mb-2 leading-snug">{{ $eventoItem->titulo }}</h3>
                            <p class="text-sm text-[#334155] mb-1 flex items-center gap-2"><i class="fa-solid fa-clock text-slate-400"></i> {{ \Carbon\Carbon::parse($eventoItem->data_inicio)->format('d \d\e F \à\s H:i') }}</p>
                            <p class="text-sm text-[#334155] flex items-center gap-2"><i class="fa-solid fa-location-dot text-slate-400"></i> {{ $eventoItem->local ?? 'Assaí, PR' }}</p>
                        </div>
                    </div>
                    @endforeach
                    @else
                    <div class="bg-white rounded-[16px] shadow-[0_4px_10px_rgba(0,0,0,0.04)] p-8 text-center text-slate-500 font-medium">
                        Nenhum evento programado para este mês.
                    </div>
                    @endif

                    <div class="mt-6 flex justify-start">
                        <a href="{{ route('agenda.index') }}" class="bg-[#006eb7] text-white rounded-full px-8 py-3 text-base font-bold flex items-center gap-2 hover:bg-blue-800 transition shadow-md">
                            <i class="fa-regular fa-calendar-days"></i> Ver todos os Eventos
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- Logic for Search Autocomplete --}}
    <script>
        function searchAutocomplete() {
            return {
                query: '',
                results: [],
                open: false,
                loading: false,

                init() {
                    // Watch query changes with debounce
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
    </script>

    {{-- Script para o efeito de Digitação nos placeholders de busca --}}
    <script>
        document.addEventListener('DOMContentLoaded', function() {
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
    </script>

</main>
@endsection

@push('modals')
@if(isset($banners) && $banners->count() > 0)
<style>
    /* CSS Vanilla de Alto Nível de Z-Index para isolamento do Tailwind */
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
    
/* === Setas do Swiper Isoladas === */
    .nav-modal-exclusiva {
        /* Fundo escuro com 60% de opacidade para garantir visibilidade sobre imagens claras */
        background-color: rgba(0, 0, 0, 0.6) !important; 
        background-image: none !important; /* Anula a seta maior proveniente do CSS global */
        color: rgba(255, 255, 255, 0.9) !important;
        
        /* Dimensões forçadas e borda arredondada para criar o círculo */
        width: 48px !important;
        height: 48px !important;
        border-radius: 50% !important;
        
        /* Centralização absoluta do ícone dentro da bolinha */
        align-items: center !important;
        justify-content: center !important;
        
        transition: all 0.3s ease;
        display: none; 
    }
    
    .nav-modal-exclusiva:hover {
        /* Escurece o fundo e aumenta levemente ao passar o cursor */
        background-color: rgba(0, 0, 0, 0.9) !important; 
        color: #ffffff !important;
        transform: scale(1.05);
    }

    /* Oculta nós HTML internos (ex: <svg> ou <i>) caso injetados por JS */
    .nav-modal-exclusiva > * {
        display: none !important;
    }

    /* Define a exibição estrita da seta menor nativa do Swiper */
    .nav-modal-exclusiva::after {
        display: block !important;
        font-family: 'swiper-icons' !important;
        font-size: 20px !important; /* Dimensão da seta ajustada para o centro da bolinha */
        font-weight: 900 !important;
    }
    
    @media (min-width: 768px) {
        .nav-modal-exclusiva {
            display: flex !important; /* O flex é crucial para o align-items e justify-content funcionarem */
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
                @if($banner->link) <a href="{{ $banner->link }}" target="_blank" style="display:block; width:100%; height:100%;"> @endif
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

    document.addEventListener('DOMContentLoaded', function() {
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
                            // Mapeamento exclusivo para não puxar setas de outros componentes
                            navigation: { 
                                nextEl: '.seta-unica-next', 
                                prevEl: '.seta-unica-prev' 
                            },
                            observer: true,
                            observeParents: true,
                            resizeObserver: true
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