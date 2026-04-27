@extends('layouts.app')

@section('title', 'Prefeitura de Assaí')

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

    $sugestoesBusca = collect($sugestoesIA ?? [
    'Emitir nota fiscal eletronica',
    'Consultar protocolo digital',
    'Agendar atendimento administrativo',
    'Solicitar matricula na rede municipal',
    ])->take(3);

    $servicosPlMobile = [
    ['titulo' => 'Licitações', 'icone' => 'fa-file-contract', 'link' => '#'],
    ['titulo' => 'Boletim da Dengue', 'icone' => 'fa-mosquitonet', 'link' => '#'],
    ['titulo' => 'Concurso Público', 'icone' => 'fa-user-graduate', 'link' => '#'],
    ['titulo' => 'Livro Eletrônico', 'icone' => 'fa-book-open-reader', 'link' => '#'],
    ['titulo' => 'Nota Fiscal Eletrônica', 'icone' => 'fa-file-invoice-dollar', 'link' => '#'],
    ['titulo' => 'Cidadão Web', 'icone' => 'fa-user-gear', 'link' => '#'],
    ['titulo' => 'Telefones Úteis', 'icone' => 'fa-phone-volume', 'link' => '#'],
    ['titulo' => 'Vagas de Emprego', 'icone' => 'fa-briefcase', 'link' => '#'],
    ['titulo' => 'Cadastro no Gov.Assaí', 'icone' => 'fa-id-card-clip', 'link' => '#'],
    ['titulo' => 'Classificados de Assaí', 'icone' => 'fa-tags', 'link' => '#'],
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


    $calendarDays = [];
    $cursor = $calendarStart->copy();
    while ($cursor->lte($calendarEnd)) {
        $isoDate = $cursor->toDateString();
        $eventosNoDia = $eventosPorDiaHome[$isoDate] ?? [];
        $calendarDays[] = [
            'date' => $isoDate,
            'day' => (int) $cursor->format('j'),
            'isCurrentMonth' => $cursor->month === $calendarMonth->month,
            'isToday' => $cursor->isToday(),
            'hasEvent' => count($eventosNoDia) > 0,
            'eventos' => $eventosNoDia
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
    <section class="relative lg:hidden pl-mobile-home" id="pl-mobile-home">
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
                <source data-src="{{ asset('videos/video-portal.mp4') }}" type="video/mp4">
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
        FAIXA DE PLANTÃO (Abaixo da Hero)
        ========================================== --}}
    <div x-data="dutyWidget()" x-init="init()" class="w-full bg-gradient-to-r from-[#006eb7] to-[#004e82] border-b border-[#00385d] text-white shadow-inner relative z-40">
        <div class="container mx-auto max-w-6xl px-4 py-3 flex flex-col md:flex-row items-center justify-between gap-4 text-sm font-sans">
            
            <div class="flex items-center gap-3 shrink-0 bg-black/20 px-3 py-1.5 rounded-full">
                <span class="relative flex h-3 w-3">
                  <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-red-400 opacity-75"></span>
                  <span class="relative inline-flex rounded-full h-3 w-3 bg-red-500"></span>
                </span>
                <span class="font-bold tracking-wider uppercase text-[11px]">Plantão Agora</span>
            </div>

            <div class="flex-1 flex items-center justify-center text-center">
                <template x-if="loading">
                    <span class="text-white/70 italic text-xs animate-pulse">Carregando plantões...</span>
                </template>
                
                <template x-if="error && !loading">
                    <span class="text-red-300 text-xs font-medium">Plantões indisponíveis no momento.</span>
                </template>
                
                <template x-if="!loading && !error && !hasDuty">
                    <span class="text-white/80 italic text-sm" x-text="message || 'Nenhum plantão cadastrado para hoje.'"></span>
                </template>
                
                <template x-if="!loading && !error && hasDuty">
                    <div class="flex items-center justify-center gap-4 flex-wrap">
                        <template x-if="posto">
                            <div class="flex items-center gap-2">
                                <i class="fa-solid fa-gas-pump text-yellow-400 text-sm"></i>
                                <span class="font-semibold text-white tracking-wide" x-text="formatDutyText(posto, '')"></span>
                            </div>
                        </template>
                        
                        <template x-if="posto && farmacia">
                            <div class="w-1.5 h-1.5 rounded-full bg-white/30 hidden md:block"></div>
                        </template>
                        
                        <template x-if="farmacia">
                            <div class="flex items-center gap-2">
                                <i class="fa-solid fa-pills text-emerald-400 text-sm"></i>
                                <span class="font-semibold text-white tracking-wide" x-text="formatDutyText(farmacia, '')"></span>
                            </div>
                        </template>
                    </div>
                </template>
            </div>
        </div>
    </div>

    {{-- ==========================================
        SEÇÕES MOBILE (Apenas telas pequenas)
        ========================================== --}}
    <div class="lg:hidden pl-mobile-home">

        {{-- 1. FIQUE LIGADO (Programas Swiper) --}}
        @if(isset($programas) && $programas->count() > 0)
        <section class="bg-white-section">
            <div class="premium-title-wrapper">
                <div class="premium-title-decoration">
                    <div class="premium-title-line-left"><div class="premium-title-line-full"></div><div class="premium-title-line-short"></div></div>
                    <h3 class="premium-title-tag">Destaques</h3>
                    <div class="premium-title-line-right"><div class="premium-title-line-full"></div><div class="premium-title-line-short"></div></div>
                </div>
                <h2 class="section-title">Fique Ligado</h2>
            </div>
            <div class="px-4 relative">
                <div class="swiper swiper-fique-ligado w-full rounded-[22px] shadow-lg overflow-hidden relative border border-slate-100 bg-slate-50">
                    <div class="swiper-wrapper">
                        @foreach($programas as $programa)
                        <div class="swiper-slide relative bg-slate-50 flex items-center justify-center">
                            <a href="{{ $programa->link ?? route('programas.show', $programa) }}" 
                                {{ $programa->link ? 'target="_blank" rel="noopener"' : '' }}
                                class="block w-full h-full">
                                <img src="{{ $programa->icone ? (str_starts_with($programa->icone, 'img/') ? asset($programa->icone) : asset('storage/' . $programa->icone)) : asset('img/Assai.jpg') }}"
                                    alt="{{ $programa->titulo }}"
                                    loading="lazy"
                                    class="w-full h-80 object-cover">
                            </a>
                        </div>
                        @endforeach
                    </div>
                    
                    <div class="swiper-pagination swiper-pagination-fique-ligado !bottom-2"></div>
                    
                    <!-- Navigation buttons inside -->
                    <style>
                        .fique-ligado-mobile-arrow { width: 32px !important; height: 32px !important; }
                        .fique-ligado-mobile-arrow::after { font-size: 14px !important; }
                    </style>
                    <div class="swiper-button-prev program-swiper-arrow fique-ligado-mobile-arrow !left-2 bg-white/70 hover:bg-white rounded-full shadow-md !text-[#0b2f57]"></div>
                    <div class="swiper-button-next program-swiper-arrow fique-ligado-mobile-arrow !right-2 bg-white/70 hover:bg-white rounded-full shadow-md !text-[#0b2f57]"></div>
                </div>
            </div>
        </section>
        @endif

        {{-- 2. PORTAL DE NOTÍCIAS --}}
        @php 
            $noticiasMobile = isset($noticias) ? $noticias : (isset($recentesSidebar) ? $recentesSidebar : collect());
        @endphp
        @if($noticiasMobile->count() > 0)
        <section class="bg-gray-section">
            <div class="premium-title-wrapper">
                <div class="premium-title-decoration">
                    <div class="premium-title-line-left"><div class="premium-title-line-full"></div><div class="premium-title-line-short"></div></div>
                    <h3 class="premium-title-tag">Atualizações</h3>
                    <div class="premium-title-line-right"><div class="premium-title-line-full"></div><div class="premium-title-line-short"></div></div>
                </div>
                <h2 class="section-title">Portal de Notícias</h2>
            </div>
            <div class="mobile-news-grid">
                @foreach($noticiasMobile->take(3) as $not)
                <a href="{{ route('noticias.show', $not->slug) }}" class="card-news bg-white rounded-2xl overflow-hidden shadow-sm border border-slate-200 block">
                    <img src="{{ $not->imagem_capa ? (str_starts_with($not->imagem_capa, 'img/') ? asset($not->imagem_capa) : asset('storage/' . $not->imagem_capa)) : asset('img/Assai.jpg') }}" alt="{{ $not->titulo }}" class="w-full h-48 object-cover">
                    <div class="p-4">
                        <span class="text-[10px] font-bold text-blue-600 uppercase tracking-wider mb-1 block">{{ $not->categoria ?? 'Notícias' }}</span>
                        <h4 class="text-base font-bold text-[#1e3a5f] line-clamp-2 leading-snug mb-2" style="font-family: 'Montserrat', sans-serif;">{{ $not->titulo }}</h4>
                        <div class="flex items-center gap-2 text-slate-400 text-[11px] font-semibold">
                            <i class="fa-regular fa-calendar"></i>
                            <span>{{ \Carbon\Carbon::parse($not->data_publicacao)->format('d/m/Y') }}</span>
                        </div>
                    </div>
                </a>
                @endforeach
            </div>
            <div class="all-btn-wrapper">
                <a href="{{ route('noticias.index') }}" class="all-btn shadow-md">Ver todas as notícias <i class="fa-solid fa-arrow-right"></i></a>
            </div>
        </section>
        @endif

        <section class="bg-white-section">
            <div class="premium-title-wrapper">
                <div class="premium-title-decoration">
                    <div class="premium-title-line-left"><div class="premium-title-line-full"></div><div class="premium-title-line-short"></div></div>
                    <h3 class="premium-title-tag">Serviços</h3>
                    <div class="premium-title-line-right"><div class="premium-title-line-full"></div><div class="premium-title-line-short"></div></div>
                </div>
                <h2 class="section-title">Mais Acessados</h2>
            </div>
            <div class="small-cards-grid">
                @foreach($servicosHome as $srv)
                @php 
                    $s = (object)$srv;
                    $iconeClasse = !empty($s->icone) ? $s->icone : 'fa-solid fa-file-lines';
                    if (!str_contains($iconeClasse, 'fa-')) {
                        $iconeClasse = 'fa-solid fa-' . $iconeClasse;
                    }
                    $sLink = $s->link ?? '#';
                    $sTitulo = $s->titulo ?? 'Serviço';
                @endphp
                <a href="{{ $sLink }}" @if($s->is_conecta) target="_blank" rel="noopener" @endif class="small-card group">
                    <span class="helper-dot">.</span>
                    <div class="service-icon transition-transform group-hover:scale-110 duration-300">
                        <i class="{{ $iconeClasse }}"></i>
                    </div>
                    <h4 class="small-card-title">{{ $sTitulo }}</h4>
                </a>
                @endforeach
            </div>
            <div class="all-btn-wrapper">
                <a href="{{ route('servicos.index') }}" class="all-btn !bg-white !text-[#006eb7] border-2 border-[#006eb7]">Ver todos os serviços <i class="fa-solid fa-table-cells-large"></i></a>
            </div>
        </section>

        {{-- Define dados de Banners de Perfil --}}
        @php
            $perfilAtual = request()->cookie('portal_perfil', 'todos');
            
            $bannersPerfil = [
                'cidadao' => [
                    'titulo' => 'Perfil Cidadão',
                    'itens' => [
                        ['titulo' => 'Consulte seus Débitos de IPTU', 'imagem' => 'img/banner/IPTU-banner.jpg', 'link' => '#'],
                        ['titulo' => 'Consulte seus Débitos de ISSQN', 'imagem' => 'img/banner/ISS-banner.jpg', 'link' => '#'],
                        ['titulo' => 'Central de Estágios', 'imagem' => 'img/banner/central-estagio.png', 'link' => '#'],
                        ['titulo' => 'Plano de Metas', 'imagem' => 'img/banner/Metas.png', 'link' => '#'],
                    ]
                ],
                'empresario' => [
                    'titulo' => 'Perfil Empresário',
                    'itens' => [
                        ['titulo' => 'Consulta Prévia Empresa', 'imagem' => 'img/banner/IPTU-banner.jpg', 'link' => '#'],
                        ['titulo' => 'Invista em Assaí', 'imagem' => 'img/banner/ISS-banner.jpg', 'link' => '#'],
                        ['titulo' => 'Programa Acelera Assaí', 'imagem' => 'img/banner/central-estagio.png', 'link' => '#'],
                        ['titulo' => 'Portal de Talentos', 'imagem' => 'img/banner/Metas.png', 'link' => '#'],
                    ]
                ],
                'servidor' => [
                    'titulo' => 'Perfil Servidor',
                    'itens' => [
                        ['titulo' => 'Consulta Hollerit', 'imagem' => 'img/banner/IPTU-banner.jpg', 'link' => '#'],
                        ['titulo' => 'Dúvidas Requerimento', 'imagem' => 'img/banner/ISS-banner.jpg', 'link' => '#'],
                        ['titulo' => 'Cartão Verocard', 'imagem' => 'img/banner/central-estagio.png', 'link' => '#'],
                        ['titulo' => 'Resolução Atestados', 'imagem' => 'img/banner/Metas.png', 'link' => '#'],
                    ]
                ]
            ];

            $perfilChave = ($perfilAtual === 'todos' || !isset($bannersPerfil[$perfilAtual])) ? 'cidadao' : $perfilAtual;
            $bannersExibir = $bannersPerfil[$perfilChave];
        @endphp

        {{-- 3.5 BANNERS DE PERFIL (Destaques) MOBILE --}}
        @if(!empty($bannersExibir['itens']) && count($bannersExibir['itens']) > 0)
        <section class="bg-gray-section !py-6">
            <div class="px-4">
                <div class="grid grid-cols-1 gap-4">
                    @foreach($bannersExibir['itens'] as $bannerItem)
                    <a href="{{ $bannerItem['link'] }}" class="w-full rounded-2xl overflow-hidden shadow-sm border border-slate-200 bg-white flex justify-center aspect-[7/2]">
                        <img src="{{ asset($bannerItem['imagem']) }}" 
                             alt="{{ $bannerItem['titulo'] }}" 
                             class="w-full h-full block object-fill">
                    </a>
                    @endforeach
                </div>
            </div>
        </section>
        @endif

        {{-- 4. BANNERS DE PROGRAMAS (Seção sem título) --}}
        @if(isset($banners) && $banners->count() > 0)
        <section class="bg-gray-section !py-6">
            <div class="px-4">
                <div class="grid grid-cols-1 gap-4">
                    @foreach($banners->take(4) as $banner)
                    <div class="w-full rounded-2xl overflow-hidden shadow-sm border border-slate-200 bg-white flex justify-center aspect-[7/2]">
                        <img src="{{ str_starts_with($banner->imagem, 'img/') ? asset($banner->imagem) : asset('storage/' . $banner->imagem) }}" 
                            alt="Banner" class="w-full h-full block object-fill">
                    </div>
                    @endforeach
                </div>
            </div>
        </section>
        @endif

        {{-- 5. CALENDÁRIO DE EVENTOS --}}
        <section class="bg-white-section">
            <div class="premium-title-wrapper">
                <div class="premium-title-decoration">
                    <div class="premium-title-line-left"><div class="premium-title-line-full"></div><div class="premium-title-line-short"></div></div>
                    <h3 class="premium-title-tag">Agenda</h3>
                    <div class="premium-title-line-right"><div class="premium-title-line-full"></div><div class="premium-title-line-short"></div></div>
                </div>
                <h2 class="section-title">Calendário de Eventos</h2>
            </div>
            <div class="px-4">
                <div class="calendar-wrap" id="calendar-ajax-wrap" data-mes="{{ $calendarMonth->format('Y-m') }}">
                    <div class="calendar-head">
                        <button type="button" class="arrow-btn" id="calendar-prev-btn" aria-label="Mês anterior"><i class="fa-solid fa-chevron-left"></i></button>
                        <span class="month-name" id="calendar-month-name">{{ $calendarTituloMes }}</span>
                        <button type="button" class="arrow-btn" id="calendar-next-btn" aria-label="Próximo mês"><i class="fa-solid fa-chevron-right"></i></button>
                    </div>
                    <div class="calendar-grid" id="calendar-days-grid">
                        <span class="day-name">D</span><span class="day-name">S</span><span class="day-name">T</span><span class="day-name">Q</span><span class="day-name">Q</span><span class="day-name">S</span><span class="day-name">S</span>
                        @foreach($calendarDays as $calendarDay)
                        @php
                        $classesDay = 'day-number ';
                        if (!$calendarDay['isCurrentMonth']) $classesDay .= 'muted ';
                        if ($calendarDay['isToday']) $classesDay .= 'today ';
                        @endphp
                        <button type="button" disabled class="{{ $classesDay }}">
                            {{ $calendarDay['day'] }}
                        </button>
                        @endforeach
                    </div>
                </div>

                @if(isset($eventos) && $eventos->count() > 0)
                @php $ev = $eventos->first(); @endphp
                <a href="{{ route('agenda.show', $ev->id) }}" class="event-featured mt-6 border border-slate-100 shadow-sm block">
                    <div class="date-chip">
                        <span class="day">{{ \Carbon\Carbon::parse($ev->data_inicio)->format('d') }}</span>
                        <span class="month">{{ \Carbon\Carbon::parse($ev->data_inicio)->translatedFormat('M') }}</span>
                    </div>
                    <div class="event-info">
                        <h4 class="event-title line-clamp-2">{{ $ev->titulo }}</h4>
                        <div class="event-meta">
                            <i class="fa-regular fa-clock"></i>
                            <span>{{ \Carbon\Carbon::parse($ev->data_inicio)->format('H:i') }} @if($ev->local) - {{ $ev->local }} @endif</span>
                        </div>
                    </div>
                </a>
                @endif
            </div>
            <div class="all-btn-wrapper mt-8">
                <a href="{{ route('agenda.index') }}" class="all-btn !bg-slate-800">Ver todos os eventos <i class="fa-regular fa-calendar-days"></i></a>
            </div>
        </section>

        {{-- 6. NOSSOS PORTAIS --}}
        @if(isset($portais) && $portais->count() > 0)
        <section class="bg-gray-section">
            <div class="premium-title-wrapper">
                <div class="premium-title-decoration">
                    <div class="premium-title-line-left"><div class="premium-title-line-full"></div><div class="premium-title-line-short"></div></div>
                    <h3 class="premium-title-tag">Conheça</h3>
                    <div class="premium-title-line-right"><div class="premium-title-line-full"></div><div class="premium-title-line-short"></div></div>
                </div>
                <h2 class="section-title">Nossos Portais</h2>
            </div>
            <div class="small-cards-grid">
                @foreach($portais as $pt)
                @php 
                    $p = (object)$pt;
                    $pIcone = !empty($p->icone) ? str_replace(['fa-', 'fas ', 'fa-solid '], '', $p->icone) : 'file-lines';
                    $pUrl = $p->url ?? ($p->link ?? '#');
                    $pTitulo = $p->titulo ?? ($p->nome ?? 'Portal');
                    $isTransparencia = stripos($pTitulo, 'Transparência') !== false;
                    $pColor = $isTransparencia ? '#10b981' : ($p->cor ?? '#006eb7');
                @endphp
                <a href="{{ $pUrl }}" target="_blank" rel="noopener" class="small-card group" style="border-top: 4px solid {{ $pColor }}; {{ $isTransparencia ? 'background-color: #059669;' : '' }}">
                    <div class="service-icon transition-transform group-hover:scale-110 duration-300" style="color: {{ $isTransparencia ? '#ecfdf5' : $pColor }}">
                        <i class="fa-solid fa-{{ $pIcone }}"></i>
                    </div>
                    <h4 class="small-card-title" style="color: {{ $isTransparencia ? '#fff' : $pColor }}">{{ $pTitulo }}</h4>
                </a>
                @endforeach
            </div>
        </section>
        @endif

        {{-- 7. REDES SOCIAIS --}}
        @if(isset($redesSociais) && $redesSociais->whereNotNull('imagem')->count() > 0)
        <section class="bg-white-section">
            <div class="premium-title-wrapper">
                <div class="premium-title-decoration">
                    <div class="premium-title-line-left"><div class="premium-title-line-full"></div><div class="premium-title-line-short"></div></div>
                    <h3 class="premium-title-tag">Social</h3>
                    <div class="premium-title-line-right"><div class="premium-title-line-full"></div><div class="premium-title-line-short"></div></div>
                </div>
                <h2 class="section-title">Redes Sociais</h2>
            </div>
            <div class="flex flex-col gap-6 px-4">
                @foreach($redesSociais->whereNotNull('imagem')->take(2) as $post)
                <div class="bg-white rounded-3xl overflow-hidden shadow-[0_8px_30px_rgb(0,0,0,0.04)] border border-slate-100">
                    <div class="p-4 flex items-center gap-3">
                        <div class="w-10 h-10 rounded-full bg-blue-600 flex items-center justify-center text-white shadow-sm">
                            <i class="fa-brands fa-facebook-f text-xs"></i>
                        </div>
                        <div class="flex flex-col">
                            <span class="text-xs font-black text-slate-800">Prefeitura de Assaí</span>
                            <span class="text-[9px] font-bold text-slate-400 uppercase tracking-widest">Facebook</span>
                        </div>
                    </div>
                    <a href="{{ $post->link }}" target="_blank" class="block aspect-square overflow-hidden relative">
                        <img src="{{ asset('storage/' . $post->imagem) }}" alt="Post Social" class="w-full h-full object-cover">
                    </a>
                    <div class="p-5">
                        <p class="text-xs text-slate-600 line-clamp-3 leading-relaxed">{{ $post->legenda }}</p>
                    </div>
                </div>
                @endforeach
            </div>
            <div class="all-btn-wrapper mt-8">
                <a href="https://www.facebook.com/prefeituraassai" target="_blank" class="all-btn !bg-[#1877f2]">Siga-nos no Facebook <i class="fa-brands fa-facebook"></i></a>
            </div>
        </section>
        @endif

    </div>

    {{-- ==========================================
        SEÇÕES DESKTOP (Apenas telas grandes)
        ========================================== --}}

        {{-- Programas Desktop --}}
        <section id="programas-desktop" class="hidden lg:block pb-16 pt-10 bg-[#eef1f5]">
            <div class="container px-4 mx-auto max-w-6xl font-sans">
                <div class="flex flex-col items-center mb-10">
                    <div class="flex items-center justify-center gap-4 w-full overflow-hidden mb-2">
                        <div class="flex-1 max-w-[100px] flex flex-col gap-1">
                            <div class="h-px bg-blue-400 w-full opacity-60"></div>
                            <div class="h-px bg-blue-400 w-3/4 ml-auto"></div>
                        </div>
                        <h3 class="text-[10px] font-black text-blue-500 uppercase tracking-[0.3em] whitespace-nowrap">Destaques</h3>
                        <div class="flex-1 max-w-[100px] flex flex-col gap-1">
                            <div class="h-px bg-blue-400 w-full opacity-60"></div>
                            <div class="h-px bg-blue-400 w-3/4"></div>
                        </div>
                    </div>
                    <h2 class="text-4xl font-bold text-[#1e3a5f] tracking-tight" style="font-family: 'Montserrat', sans-serif;">Fique Ligado</h2>
                </div>
                @if(isset($programas) && $programas->count() > 0)
                <div class="relative w-full lg:px-4">
                    <div class="swiper swiper-fique-ligado w-full rounded-[22px] shadow-[0_8px_30px_rgb(0,0,0,0.12)] bg-slate-100 overflow-hidden pointer-events-auto group">
                        <div class="swiper-wrapper">
                            @foreach($programas as $programa)
                            <div class="swiper-slide relative w-full bg-slate-100">
                                <a href="{{ $programa->link ?? route('programas.show', $programa) }}"
                                    {{ $programa->link ? 'target="_blank" rel="noopener"' : '' }}
                                    class="block w-full h-full focus:outline-none focus:ring-4 focus:ring-inset focus:ring-[#006eb7]">
                                    <img src="{{ $programa->icone ? (str_starts_with($programa->icone, 'img/') ? asset($programa->icone) : asset('storage/' . $programa->icone)) : asset('img/Assai.jpg') }}"
                                        alt="{{ $programa->titulo }}"
                                        loading="lazy"
                                        class="absolute inset-0 object-cover w-full h-full bg-slate-50">
                                </a>
                            </div>
                            @endforeach
                        </div>
                        <div class="swiper-pagination !bottom-5"></div>
                        
                        {{-- Setas posicionadas internamente com hover --}}
                        <div class="swiper-button-prev program-swiper-arrow !text-[#0b2f57] !left-4 opacity-0 group-hover:opacity-100 transition-opacity bg-white/70 hover:bg-white rounded-full !w-12 !h-12 flex items-center justify-center shadow-md"></div>
                        <div class="swiper-button-next program-swiper-arrow !text-[#0b2f57] !right-4 opacity-0 group-hover:opacity-100 transition-opacity bg-white/70 hover:bg-white rounded-full !w-12 !h-12 flex items-center justify-center shadow-md"></div>
                    </div>
                </div>
                @endif
            </div>
        </section>

        {{-- Portal de Notícias Desktop --}}
        <section id="noticias-desktop" class="hidden lg:block py-16 bg-white border-t border-slate-100">
            <div class="container px-4 mx-auto max-w-6xl font-sans">

                <div class="flex flex-col items-center mb-10">
                    <div class="flex items-center justify-center gap-4 w-full overflow-hidden mb-2">
                        <div class="flex-1 max-w-[100px] flex flex-col gap-1">
                            <div class="h-px bg-blue-400 w-full opacity-60"></div>
                            <div class="h-px bg-blue-400 w-3/4 ml-auto"></div>
                        </div>
                        <h3 class="text-[10px] font-black text-blue-500 uppercase tracking-[0.3em] whitespace-nowrap">Portal de</h3>
                        <div class="flex-1 max-w-[100px] flex flex-col gap-1">
                            <div class="h-px bg-blue-400 w-full opacity-60"></div>
                            <div class="h-px bg-blue-400 w-3/4"></div>
                        </div>
                    </div>
                    <h2 class="text-4xl font-bold text-[#1e3a5f] tracking-tight" style="font-family: 'Montserrat', sans-serif;">Notícias</h2>
                </div>

                @if($destaqueNoticia)
                <div class="grid grid-cols-12 gap-8 lg:h-[500px] mb-16">
                    {{-- Coluna Esquerda: Notícia Destaque (Estático) --}}
                    <div class="col-span-8 flex flex-col h-full">
                        <article class="relative w-full h-full group overflow-hidden rounded-2xl shadow-lg border border-slate-100">
                            <a href="{{ route('noticias.show', $destaqueNoticia->slug) }}" class="block w-full h-full">
                                <img src="{{ $destaqueNoticia->imagem_capa ? (str_starts_with($destaqueNoticia->imagem_capa, 'img/') ? asset($destaqueNoticia->imagem_capa) : asset('storage/' . $destaqueNoticia->imagem_capa)) : asset('img/Assai.jpg') }}"
                                    class="absolute inset-0 w-full h-full object-cover transition-transform duration-700 group-hover:scale-105"
                                    alt="{{ $destaqueNoticia->titulo }}" loading="lazy">
                                <div class="absolute inset-0 bg-gradient-to-t from-black/95 via-black/20 to-transparent"></div>
                                <div class="absolute bottom-0 left-0 w-full p-8">
                                    <h3 class="text-3xl font-bold text-white leading-[1.1] mb-5 group-hover:text-yellow-400 transition-colors"
                                        style="font-family: 'Montserrat', sans-serif; letter-spacing: -0.5px;">
                                        {{ $destaqueNoticia->titulo }}
                                    </h3>
                                    <div class="flex flex-col gap-1.5 text-white/70 text-[11px] font-semibold uppercase tracking-wider">
                                        <div class="flex items-center gap-2">
                                            <span>Redação: Secretaria de Comunicação Social</span>
                                        </div>
                                        <div class="flex items-center gap-2">
                                            <span>Data da Publicação: {{ \Carbon\Carbon::parse($destaqueNoticia->data_publicacao)->format('d/m/Y') }}</span>
                                        </div>
                                    </div>
                                </div>
                            </a>
                        </article>
                    </div>

                    {{-- Coluna Direita: Recentes --}}
                    <div class="col-span-4 flex flex-col h-full">
                        <div class="flex items-center justify-between mb-6 shrink-0 bg-slate-50 p-4 rounded-t-xl border-x border-t border-slate-100">
                            <h3 class="text-xl font-bold text-slate-800"
                                style="font-family: 'Montserrat', sans-serif;">Recentes</h3>
                            <a href="{{ route('noticias.index') }}" class="text-sm font-bold text-blue-600 hover:text-blue-800 transition-colors">Todas</a>
                        </div>
                        <div class="flex flex-col gap-4 flex-1">
                            @foreach($recentesSidebar as $recente)
                            <a href="{{ route('noticias.show', $recente->slug) }}"
                                class="relative flex-1 w-full block group overflow-hidden border-x border-b border-slate-100 last:rounded-b-xl focus:outline-none focus:ring-2 focus:ring-[#006eb7] min-h-[120px]">
                                <img src="{{ $recente->imagem_capa ? (str_starts_with($recente->imagem_capa, 'img/') ? asset($recente->imagem_capa) : asset('storage/' . $recente->imagem_capa)) : asset('img/Assai.jpg') }}"
                                    class="absolute inset-0 w-full h-full object-cover transition-transform duration-700 group-hover:scale-105"
                                    alt="{{ $recente->titulo }}" loading="lazy">
                                <div class="absolute inset-0 bg-gradient-to-t from-black/90 via-black/10 to-transparent"></div>
                                <div class="absolute bottom-0 left-0 w-full p-4 bg-black/40 backdrop-blur-[2px]">
                                    <h4 class="text-white text-xs font-bold leading-snug line-clamp-2 group-hover:text-yellow-400 transition-colors"
                                        style="font-family: 'Montserrat', sans-serif;">
                                        {{ $recente->titulo }}
                                    </h4>
                                </div>
                            </a>
                            @endforeach
                        </div>
                    </div>
                </div>

                {{-- Seção Temática com Select --}}
                <div class="mt-16 pt-12 border-t border-slate-100">
                    <div class="flex flex-col md:flex-row md:items-center justify-between gap-6 mb-10">
                        <div>
                            <h3 class="text-xl font-black text-slate-800 uppercase tracking-tight" style="font-family: 'Montserrat', sans-serif;">Notícias por Tema</h3>
                            <p class="text-sm text-slate-500 font-medium">Selecione uma categoria para filtrar</p>
                        </div>
                        <div class="relative min-w-[280px]">
                            <select id="select-tema-noticias" class="w-full pl-4 pr-10 py-3 bg-slate-50 border border-slate-200 rounded-xl text-slate-700 font-bold appearance-none focus:outline-none focus:ring-2 focus:ring-blue-500 transition-all cursor-pointer shadow-sm">
                                <option value="">Selecione um Tema</option>
                                @foreach($categoriasNoticias as $cat)
                                    <option value="{{ $cat->id }}" {{ strtolower($cat->nome) == 'geral' ? 'selected' : '' }}>{{ $cat->nome }}</option>
                                @endforeach
                            </select>
                            <div class="absolute right-4 top-1/2 -translate-y-1/2 pointer-events-none text-blue-600">
                                <i class="fa-solid fa-chevron-down"></i>
                            </div>
                        </div>
                    </div>

                    {{-- Container de Notícias Temáticas (AJAX) --}}
                    <div id="container-noticias-tematicas" class="hidden grid-cols-1 md:grid-cols-3 gap-8 mt-10 transition-opacity duration-300">
                    </div>
                </div>

                <div id="btn-ver-todas-container" class="mt-16 flex justify-center">
                    <a href="{{ route('noticias.index') }}"
                        class="bg-[#006eb7] text-white rounded-full px-10 py-4 text-base font-black flex items-center gap-3 hover:bg-blue-800 transition shadow-lg hover:-translate-y-1">
                        <i class="fa-solid fa-plus-circle"></i> Ver todas as Notícias
                    </a>
                </div>

                <script>
                    document.addEventListener('DOMContentLoaded', function() {
                        const selectTema = document.getElementById('select-tema-noticias');
                        const container = document.getElementById('container-noticias-tematicas');
                        const excludeIds = @json(isset($noticias) ? $noticias->pluck('id') : []);

                        selectTema.addEventListener('change', function() {
                            const tema = this.value;
                            const btnTodas = document.getElementById('btn-ver-todas-container');

                            if (!tema) {
                                // Se for vazio, busca todas as notícias (Geral)
                                fetchTemaNoticias('');
                                return;
                            }

                            // Ao selecionar um tema, mostra o container
                            container.classList.remove('hidden');
                            container.classList.add('grid');

                            container.style.opacity = '0.5';
                            fetchTemaNoticias(tema);
                        });
                        
                        function fetchTemaNoticias(temaId) {
                            const url = temaId 
                                ? `{{ route('api.noticias.tema') }}?categoria=${encodeURIComponent(temaId)}&${excludeIds.map(id => `exclude[]=${id}`).join('&')}`
                                : `{{ route('api.noticias.tema') }}?${excludeIds.map(id => `exclude[]=${id}`).join('&')}`;

                            fetch(url)
                                .then(response => response.json())
                                .then(data => {
                                    container.style.opacity = '1';
                                    if (data.length === 0) {
                                        container.innerHTML = `
                                            <div class="col-span-3 flex flex-col items-center justify-center py-16 text-slate-400">
                                                <p class="font-medium">Nenhuma notícia encontrada para este tema (excluindo destaques).</p>
                                            </div>
                                        `;
                                        return;
                                    }

                                    let html = '';
                                    data.forEach(noticia => {
                                        const imgUrl = noticia.imagem_capa 
                                            ? (noticia.imagem_capa.startsWith('img/') ? `{{ asset('') }}${noticia.imagem_capa}` : `{{ asset('storage') }}/${noticia.imagem_capa}`)
                                            : `{{ asset('img/Assai.jpg') }}`;
                                        
                                        const date = new Date(noticia.data_publicacao);
                                        const formattedDate = date.toLocaleDateString('pt-BR');

                                        html += `
                                            <article class="flex flex-col bg-white rounded-2xl overflow-hidden border border-slate-100 shadow-sm hover:shadow-md transition-all group">
                                                <a href="/noticia/${noticia.slug}" class="block h-48 overflow-hidden">
                                                    <img src="${imgUrl}" class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-105" alt="${noticia.titulo}">
                                                </a>
                                                <div class="p-6 flex-1 flex flex-col">
                                                    <span class="text-[10px] font-black text-blue-600 uppercase tracking-widest mb-3">${noticia.categoria_nome}</span>
                                                    <h4 class="text-lg font-bold text-slate-800 leading-snug mb-4 group-hover:text-blue-700 transition-colors line-clamp-3">${noticia.titulo}</h4>
                                                    <div class="mt-auto pt-4 border-t border-slate-50 flex items-center justify-between text-[11px] text-slate-400 font-bold uppercase tracking-wide">
                                                        <span>${formattedDate}</span>
                                                        <span class="text-blue-500">Ler mais <i class="fa-solid fa-arrow-right ml-1"></i></span>
                                                    </div>
                                                </div>
                                            </article>
                                        `;
                                    });
                                    container.innerHTML = html;
                                })
                                .catch(error => {
                                    console.error('Error fetching thematic news:', error);
                                    container.style.opacity = '1';
                                    container.innerHTML = '<div class="col-span-3 text-center py-16 text-red-400">Erro ao carregar notícias.</div>';
                                });
                        }
                        
                        // Executa automaticamente no carregamento da página para mostrar o tema selecionado
                        container.classList.remove('hidden');
                        container.classList.add('grid');
                        fetchTemaNoticias(selectTema.value);
                    });
                </script>

                @endif
            </div>
        </section>

        {{-- Serviços Desktop --}}
        <section id="servicos-desktop" class="hidden lg:block py-16 bg-[#f8fafc] border-b border-[#e2e8f0]">
            <div class="container px-4 mx-auto max-w-6xl font-sans">
                <div class="flex flex-col items-center mb-12">
                    <div class="flex items-center justify-center gap-4 w-full overflow-hidden mb-2">
                        <div class="flex-1 max-w-[100px] flex flex-col gap-1">
                            <div class="h-px bg-blue-400 w-full opacity-60"></div>
                            <div class="h-px bg-blue-400 w-3/4 ml-auto"></div>
                        </div>
                        <h3 class="text-[10px] font-black text-blue-500 uppercase tracking-[0.3em] whitespace-nowrap">Serviços</h3>
                        <div class="flex-1 max-w-[100px] flex flex-col gap-1">
                            <div class="h-px bg-blue-400 w-full opacity-60"></div>
                            <div class="h-px bg-blue-400 w-3/4"></div>
                        </div>
                    </div>
                    <h2 class="text-4xl font-bold text-[#1e3a5f] tracking-tight" style="font-family: 'Montserrat', sans-serif;">Mais Acessados</h2>
                </div>
                
                <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-5 gap-4">
                    @foreach($servicosHome as $servico)
                    @php 
                        $item = (object)$servico; 
                        $iconeClasse = !empty($item->icone) ? $item->icone : 'fa-solid fa-file-lines';
                        if (!str_contains($iconeClasse, 'fa-')) {
                            $iconeClasse = 'fa-solid fa-' . $iconeClasse;
                        }
                        $link = $item->link ?? '#';
                        $titulo = $item->titulo;
                    @endphp
                    <a href="{{ $link }}" @if($item->is_conecta) target="_blank" rel="noopener" @endif
                        class="bg-white rounded-[22px] border border-[#edf2f7] p-5 flex flex-col items-center justify-center text-center relative shadow-[0_6px_14px_rgba(15,23,42,0.07)] hover:-translate-y-1 transition-transform duration-300 group h-full">
                        <i class="{{ $iconeClasse }} text-4xl text-[#006eb7] mb-3 mt-2 transition-all duration-300"></i>
                        <h3 class="text-base font-medium text-[#006eb7] leading-snug transition-colors duration-300 min-h-[48px] flex items-center justify-center px-1">
                            {{ $titulo }}
                        </h3>
                    </a>
                    @endforeach
                </div>
                
                <div class="mt-12 flex justify-center">
                    <a href="{{ route('servicos.index') }}"
                        class="bg-white text-[#006eb7] border-2 border-[#006eb7] rounded-full px-10 py-3.5 text-[13px] font-black flex items-center gap-3 hover:bg-[#006eb7] hover:text-white transition-all duration-300 shadow-sm uppercase tracking-wider">
                        <i class="fa-solid fa-table-cells-large"></i> VER TODOS OS SERVIÇOS
                    </a>
                </div>
            </div>
        </section>

        {{-- Banners de Perfil Desktop --}}
        <section id="banners-perfil-desktop" class="hidden lg:block py-12 bg-white border-b border-[#e2e8f0]">
            <div class="container px-4 mx-auto max-w-6xl font-sans">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 lg:gap-8">
                    @foreach($bannersExibir['itens'] as $bannerItem)
                    <a href="{{ $bannerItem['link'] }}" class="group block relative overflow-hidden rounded-[16px] shadow-md hover:shadow-xl transition-all duration-500 hover:-translate-y-1 bg-white border border-slate-100 aspect-[7/2]">
                        <img src="{{ asset($bannerItem['imagem']) }}" 
                             alt="{{ $bannerItem['titulo'] }}" 
                             class="absolute inset-0 w-full h-full object-fill transition-transform duration-700 group-hover:scale-105"
                             loading="lazy">
                        {{-- Overlay sutil no hover --}}
                        <div class="absolute inset-0 bg-black/0 group-hover:bg-black/10 transition-colors duration-300"></div>
                    </a>
                    @endforeach
                </div>
            </div>
        </section>

        {{-- Agenda Desktop --}}
        <section id="agenda-desktop" class="hidden lg:block py-16 bg-[#eef1f5]">
            <div class="container px-4 mx-auto max-w-6xl font-sans">
                <div class="flex flex-col items-center mb-10">
                    <div class="flex items-center justify-center gap-4 w-full overflow-hidden mb-2">
                        <div class="flex-1 max-w-[100px] flex flex-col gap-1">
                            <div class="h-px bg-blue-400 w-full opacity-60"></div>
                            <div class="h-px bg-blue-400 w-3/4 ml-auto"></div>
                        </div>
                        <h3 class="text-[10px] font-black text-blue-500 uppercase tracking-[0.3em] whitespace-nowrap">Eventos</h3>
                        <div class="flex-1 max-w-[100px] flex flex-col gap-1">
                            <div class="h-px bg-blue-400 w-full opacity-60"></div>
                            <div class="h-px bg-blue-400 w-3/4"></div>
                        </div>
                    </div>
                    <h2 class="text-4xl font-bold text-[#1e3a5f] tracking-tight" style="font-family: 'Montserrat', sans-serif;">Calendário</h2>
                </div>
                <div class="grid grid-cols-12 gap-8 items-start">
                    <div class="col-span-5 bg-white rounded-2xl p-8 shadow-[0_4px_10px_rgba(0,0,0,0.04)]" id="calendar-desktop-wrap" data-mes="{{ $calendarMonth->format('Y-m') }}">
                        <div class="flex items-center justify-between mb-6 text-[#11181d]">
                            <button type="button" id="calendar-desktop-prev"
                                class="w-10 h-10 rounded-full border border-[#e2e8f0] flex items-center justify-center text-[#334155] hover:bg-slate-50 transition" aria-label="Mês anterior">
                                <i class="fa-solid fa-chevron-left"></i>
                            </button>
                            <span id="calendar-desktop-month" class="text-[1.2rem] font-bold"
                                style="font-family: 'Montserrat', sans-serif;">{{ $calendarTituloMes }}</span>
                            <button type="button" id="calendar-desktop-next"
                                class="w-10 h-10 rounded-full border border-[#e2e8f0] flex items-center justify-center text-[#334155] hover:bg-slate-50 transition" aria-label="Próximo mês">
                                <i class="fa-solid fa-chevron-right"></i>
                            </button>
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
                        <div class="grid grid-cols-7 text-center gap-2" id="calendar-desktop-days">
                            @foreach($calendarDays as $calendarDay)
                            @php
                            $classes = 'w-10 h-10 flex items-center justify-center mx-auto rounded-full text-base font-medium transition-all ';
                            if (!$calendarDay['isCurrentMonth'])
                                $classes .= 'text-[#cbd5e1] ';
                            else
                                $classes .= 'text-[#334155] ';

                            if ($calendarDay['isToday'])
                                $classes .= 'border-2 border-[#14b8a6] ';
                            else
                                $classes .= 'hover:bg-slate-100 ';
                            @endphp
                            
                            <button type="button" disabled class="{{ $classes }} cursor-default">{{ $calendarDay['day'] }}</button>
                            @endforeach
                        </div>
                    </div>

                    <div class="col-span-7 flex flex-col gap-4">
                        @if(isset($eventos) && $eventos->count() > 0)
                        @foreach($eventos->take(3) as $eventoItem)
                        <a href="{{ route('agenda.show', $eventoItem->id) }}"
                            class="bg-white rounded-[16px] shadow-[0_4px_10px_rgba(0,0,0,0.04)] flex p-6 gap-6 items-center hover:shadow-md transition-shadow group">
                            <div
                                class="flex flex-col items-center justify-center border-r border-[#e2e8f0] pr-6 text-[#006eb7] shrink-0">
                                <span class="text-[2.6rem] font-extrabold leading-none group-hover:scale-110 transition-transform"
                                    style="font-family: 'Montserrat', sans-serif;">{{ \Carbon\Carbon::parse($eventoItem->data_inicio)->format('d') }}</span>
                                <span
                                    class="text-sm font-semibold lowercase mt-1">{{ \Carbon\Carbon::parse($eventoItem->data_inicio)->translatedFormat('M') }}</span>
                            </div>
                            <div class="flex-1">
                                <h3 class="text-lg font-bold text-[#006eb7] mb-2 leading-snug group-hover:text-blue-800 transition-colors">{{ $eventoItem->titulo }}
                                </h3>
                                <p class="text-sm text-[#334155] mb-1 flex items-center gap-2"><i
                                        class="fa-solid fa-clock text-slate-400"></i>
                                    {{ \Carbon\Carbon::parse($eventoItem->data_inicio)->format('d \d\e F \à\s H:i') }}
                                </p>
                                <p class="text-sm text-[#334155] flex items-center gap-2"><i
                                        class="fa-solid fa-location-dot text-slate-400"></i>
                                    {{ $eventoItem->local ?? 'Assaí, PR' }}
                                </p>
                            </div>
                            <i class="fa-solid fa-chevron-right text-slate-300 group-hover:text-[#006eb7] transition-colors"></i>
                        </a>
                        @endforeach
                        @else
                        <div
                            class="bg-white rounded-[16px] shadow-[0_4px_10px_rgba(0,0,0,0.04)] p-8 text-center text-slate-500 font-medium">
                            Nenhum evento programado para este mês.
                        </div>
                        @endif
                    </div>
                </div>
                <div class="mt-10 flex justify-center w-full">
                    <a href="{{ route('agenda.index') }}"
                        class="bg-[#006eb7] text-white rounded-full px-8 py-3 text-base font-bold flex items-center gap-2 hover:bg-blue-800 transition shadow-md">
                        <i class="fa-regular fa-calendar-days"></i> Ver todos os Eventos
                    </a>
                </div>
            </div>
        </section>

        {{-- Nossos Portais Desktop --}}
        <section id="nossos-portais-desktop" class="hidden lg:block py-12 bg-[#f8fafc] border-b border-[#e2e8f0]">
            <div class="container px-4 mx-auto max-w-6xl font-sans">
                <div class="flex flex-col items-center mb-10">
                    <div class="flex items-center justify-center gap-4 w-full overflow-hidden mb-2">
                        <div class="flex-1 max-w-[100px] flex flex-col gap-1">
                            <div class="h-px bg-blue-400 w-full opacity-60"></div>
                            <div class="h-px bg-blue-400 w-3/4 ml-auto"></div>
                        </div>
                        <h3 class="text-[10px] font-black text-blue-500 uppercase tracking-[0.3em] whitespace-nowrap">Conheça</h3>
                        <div class="flex-1 max-w-[100px] flex flex-col gap-1">
                            <div class="h-px bg-blue-400 w-full opacity-60"></div>
                            <div class="h-px bg-blue-400 w-3/4"></div>
                        </div>
                    </div>
                    <h2 class="text-4xl font-bold text-[#1e3a5f] tracking-tight" style="font-family: 'Montserrat', sans-serif;">Nossos Portais</h2>
                </div>

                <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-6 xl:grid-cols-7 gap-4">
                    @foreach($portais as $portal)
                    @php 
                        $isTransparencia = stripos($portal->titulo, 'Transparência') !== false;
                        $bgClass = $isTransparencia ? 'bg-emerald-600 border-emerald-500' : 'bg-white border-[#edf2f7]';
                        $textClass = $isTransparencia ? 'text-white' : 'text-[#1e3a5f]';
                        $iconClass = $isTransparencia ? 'text-emerald-100' : 'text-[#006eb7]';
                        $pIcone = !empty($portal->icone) ? str_replace(['fa-', 'fas ', 'fa-solid '], '', $portal->icone) : 'circle-nodes';
                    @endphp
                    <a href="{{ $portal->url }}" target="_blank" rel="noopener"
                        class="rounded-[22px] border p-5 flex flex-col items-center justify-center text-center relative shadow-[0_6px_14px_rgba(15,23,42,0.07)] hover:-translate-y-1 transition-transform duration-300 group {{ $bgClass }} min-h-[140px]">
                        
                        <i class="fa-solid fa-{{ $pIcone }} text-5xl {{ $iconClass }} mb-3 mt-2 transition-transform duration-300 group-hover:scale-110"></i>
                        <h3 class="text-sm font-bold {{ $textClass }} leading-tight" style="font-family: 'Montserrat', sans-serif;">{{ $portal->titulo }}</h3>
                    </a>
                    @endforeach
                </div>
            </div>
        </section>

    </div>

    {{-- ==========================================
         REDES SOCIAIS (Vitrine Visual 4 Posts)
         ========================================== --}}
    <section id="redes-sociais-unificada" class="hidden lg:block py-12 lg:py-16 bg-[#f8fafc] border-t border-slate-200">
        <div class="container px-4 mx-auto max-w-6xl font-sans text-[#1e3a5f]">

            <div class="flex flex-col items-center mb-10">
                <div class="flex items-center justify-center gap-4 w-full overflow-hidden mb-2">
                    <div class="flex-1 max-w-[100px] flex flex-col gap-1">
                        <div class="h-px bg-blue-400 w-full opacity-60"></div>
                        <div class="h-px bg-blue-400 w-3/4 ml-auto"></div>
                    </div>
                    <h3 class="text-[10px] font-black text-blue-500 uppercase tracking-[0.3em] whitespace-nowrap">Social</h3>
                    <div class="flex-1 max-w-[100px] flex flex-col gap-1">
                        <div class="h-px bg-blue-400 w-full opacity-60"></div>
                        <div class="h-px bg-blue-400 w-3/4"></div>
                    </div>
                </div>
                <h2 class="text-4xl font-bold text-[#1e3a5f] tracking-tight" style="font-family: 'Montserrat', sans-serif;">Redes Sociais</h2>
            </div>

            @if(isset($redesSociais) && $redesSociais->whereNotNull('imagem')->count() > 0)
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4 lg:gap-6 mb-10">
                @foreach($redesSociais as $post)
                @if($post->imagem)
                <a href="{{ $post->link ?? '#' }}" target="_blank" rel="noopener" class="block group relative w-full aspect-square rounded-2xl overflow-hidden shadow-md max-w-[360px] mx-auto bg-white border border-slate-100">

                    {{-- Imagem --}}
                    <img src="{{ asset('storage/' . $post->imagem) }}" class="absolute inset-0 w-full h-full object-cover transition-transform duration-500 group-hover:scale-105" loading="lazy" alt="Post Social">

                    {{-- Efeito Hover com ícone --}}
                    <div class="absolute inset-0 bg-black/0 group-hover:bg-black/40 transition-colors duration-300 flex items-center justify-center">
                        <i class="fa-brands fa-instagram text-white text-4xl opacity-0 group-hover:opacity-100 scale-50 group-hover:scale-100 transition-all duration-300"></i>
                    </div>
                </a>
                @endif
                @endforeach
            </div>
            @endif

            <div class="flex flex-wrap justify-center items-center gap-4 w-full mt-2">
                <a href="https://instagram.com/prefeituradeassai" target="_blank" rel="noopener" class="bg-[#006eb7] text-white rounded-full px-6 py-2.5 text-sm font-bold flex items-center gap-2 hover:bg-blue-800 transition-all hover:scale-105 shadow-[0_4px_12px_rgba(0,110,183,0.25)]">
                    <i class="fa-brands fa-instagram text-lg"></i> Siga nosso Instagram
                </a>
                <a href="https://facebook.com/prefeituradeassai" target="_blank" rel="noopener" class="bg-[#1877F2] text-white rounded-full px-6 py-2.5 text-sm font-bold flex items-center gap-2 hover:bg-[#166fe5] transition-all hover:scale-105 shadow-[0_4px_12px_rgba(24,119,242,0.25)]">
                    <i class="fa-brands fa-facebook-f text-lg"></i> Curta nosso Facebook
                </a>
            </div>

        </div>
    </section>

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

        document.addEventListener('DOMContentLoaded', function() {
            var swiperClass = window.Swiper || (typeof Swiper !== 'undefined' ? Swiper : null);

            if (swiperClass) {
                if (document.querySelector('.swiper-noticias-desktop')) {
                    new swiperClass('.swiper-noticias-desktop', {
                        loop: true,
                        autoplay: {
                            delay: 6000,
                            disableOnInteraction: true
                        },
                        navigation: {
                            nextEl: '.swiper-noticias-desktop .swiper-button-next',
                            prevEl: '.swiper-noticias-desktop .swiper-button-prev',
                        },
                        effect: 'fade',
                        fadeEffect: {
                            crossFade: true
                        }
                    });
                }

                if (document.querySelector('.swiper-noticias-mobile')) {
                    new swiperClass('.swiper-noticias-mobile', {
                        loop: true,
                        autoHeight: false,
                        autoplay: {
                            delay: 5000,
                            disableOnInteraction: false
                        },
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
        class="bg-white w-full max-w-2xl mx-4 rounded-xl shadow-2xl flex flex-col font-sans overflow-hidden">

        <header class="flex items-center justify-between px-6 py-4 border-b border-slate-200 bg-gradient-to-r from-[#006eb7] to-[#0087dc]">
            <div class="flex items-center gap-3">
                <div class="w-8 h-8 rounded-full bg-white/20 flex items-center justify-center">
                    <i class="fa-solid fa-sliders text-white text-sm" aria-hidden="true"></i>
                </div>
                <h2 id="modal-busca-avancada-title" class="text-[1.05rem] font-bold text-white"
                    style="font-family: 'Montserrat', sans-serif;">
                    Busca Avançada
                </h2>
            </div>
            <button type="button" @click="modalAberta = false" aria-label="Fechar janela de busca avançada"
                class="text-white/70 hover:text-white focus:outline-none focus:ring-2 focus:ring-white/50 rounded-full p-1.5 transition-colors">
                <i class="fa-solid fa-xmark text-lg" aria-hidden="true"></i>
            </button>
        </header>

        <form action="{{ route('busca.index') }}" method="GET" class="p-6 flex flex-col gap-5">

            {{-- Campo de busca --}}
            <div class="flex flex-col gap-1.5">
                <label for="adv-keyword" class="text-[0.82rem] font-bold text-slate-500 uppercase tracking-wide">Palavra-chave</label>
                <div class="relative">
                    <i class="fa-solid fa-magnifying-glass absolute left-3.5 top-1/2 -translate-y-1/2 text-slate-400 text-sm pointer-events-none"></i>
                    <input type="text" id="adv-keyword" name="q" placeholder="Ex: IPTU, saúde, concurso público..."
                        class="w-full border border-slate-300 rounded-lg pl-10 pr-4 py-3 text-sm text-slate-700 bg-white focus:border-[#006eb7] focus:ring-2 focus:ring-[#006eb7]/20 outline-none transition-all"
                        autocomplete="off">
                </div>
            </div>

            {{-- Tipo de conteúdo --}}
            <div class="flex flex-col gap-2">
                <span class="text-[0.82rem] font-bold text-slate-500 uppercase tracking-wide">O que você quer encontrar?</span>
                <div class="grid grid-cols-3 sm:grid-cols-6 gap-2">
                    @php
                        $tipos = [
                            ['value' => '',            'icon' => 'fa-border-all',      'label' => 'Tudo'],
                            ['value' => 'noticias',    'icon' => 'fa-newspaper',       'label' => 'Notícias'],
                            ['value' => 'servicos',    'icon' => 'fa-file-lines',      'label' => 'Serviços'],
                            ['value' => 'eventos',     'icon' => 'fa-calendar-days',   'label' => 'Eventos'],
                            ['value' => 'programas',   'icon' => 'fa-star',            'label' => 'Programas'],
                            ['value' => 'secretarias', 'icon' => 'fa-building-columns','label' => 'Secretarias'],
                        ];
                    @endphp
                    @foreach($tipos as $tipo)
                    <label class="flex flex-col items-center gap-1.5 cursor-pointer border-2 border-slate-200 rounded-xl px-2 py-3 text-xs font-bold text-slate-500 hover:border-[#006eb7] hover:text-[#006eb7] hover:bg-blue-50 transition-all text-center has-[:checked]:border-[#006eb7] has-[:checked]:text-[#006eb7] has-[:checked]:bg-blue-50">
                        <input type="radio" name="tipo" value="{{ $tipo['value'] }}" class="sr-only" {{ $tipo['value'] === '' ? 'checked' : '' }}>
                        <i class="fa-solid {{ $tipo['icon'] }} text-xl" aria-hidden="true"></i>
                        {{ $tipo['label'] }}
                    </label>
                    @endforeach
                </div>
            </div>

            {{-- Filtro Global de Categorias --}}
            @php
                $categoriasFiltro = \App\Models\Categoria::where('ativo', true)->orderBy('nome')->get();
            @endphp
            @if($categoriasFiltro->count() > 0)
            <div class="flex flex-col gap-1.5">
                <label for="adv-categoria" class="text-[0.82rem] font-bold text-slate-500 uppercase tracking-wide">
                    <i class="fa-solid fa-tag mr-1 text-[#006eb7]" aria-hidden="true"></i>
                    Filtrar por Categoria
                </label>
                <select id="adv-categoria" name="categoria"
                    class="w-full border border-slate-300 rounded-lg px-4 py-3 text-sm text-slate-700 bg-white focus:border-[#006eb7] focus:ring-2 focus:ring-[#006eb7]/20 outline-none appearance-none transition-all"
                    style="background-image: url('data:image/svg+xml;charset=US-ASCII,%3Csvg xmlns%3D%22http%3A%2F%2Fwww.w3.org%2F2000%2Fsvg%22 width%3D%22292.4%22 height%3D%22292.4%22%3E%3Cpath fill%3D%22%23475569%22 d%3D%22M287 69.4a17.6 17.6 0 0 0-13-5.4H18.4c-5 0-9.3 1.8-12.9 5.4A17.6 17.6 0 0 0 0 82.2c0 5 1.8 9.3 5.4 12.9l128 127.9c3.6 3.6 7.8 5.4 12.8 5.4s9.2-1.8 12.8-5.4L287 95c3.5-3.5 5.4-7.8 5.4-12.8 0-5-1.9-9.2-5.4-12.8z%22%2F%3E%3C%2Fsvg%3E'); background-repeat: no-repeat; background-position: right 1rem center; background-size: 0.65rem auto;">
                    <option value="">Todas as categorias</option>
                    @foreach($categoriasFiltro as $cat)
                    <option value="{{ $cat->id }}">{{ $cat->nome }}</option>
                    @endforeach
                </select>
            </div>
            @endif

            {{-- Apenas conteúdo recente --}}
            <div class="flex items-center border border-slate-200 rounded-xl px-4 py-3.5 bg-slate-50 hover:border-[#006eb7]/40 transition-colors">
                <label for="adv-novos" class="flex items-center cursor-pointer gap-4 w-full">
                    <input type="checkbox" id="adv-novos" name="somente_novos" class="sr-only peer" value="1">
                    <div class="w-11 h-6 bg-slate-300 rounded-full peer-focus:outline-none peer-focus:ring-2 peer-focus:ring-[#006eb7]/40 peer-checked:bg-[#006eb7] transition-colors relative flex-shrink-0 cursor-pointer">
                        <div class="absolute left-[3px] top-[3px] bg-white h-[18px] w-[18px] rounded-full transition-all peer-checked:translate-x-5 shadow-sm"></div>
                    </div>
                    <div>
                        <span class="text-[0.92rem] font-bold text-slate-700 block leading-tight">Apenas conteúdo recente</span>
                        <span class="text-[0.75rem] text-slate-400">Publicado nos últimos 30 dias</span>
                    </div>
                </label>
            </div>

            {{-- Ações --}}
            <div class="flex items-center justify-end gap-3 pt-4 border-t border-slate-100">
                <button type="button" @click="modalAberta = false"
                    class="px-5 py-2.5 text-sm font-bold text-slate-600 bg-white border border-slate-200 rounded-lg hover:bg-slate-50 focus:outline-none focus:ring-2 focus:ring-slate-300 transition-colors">
                    Cancelar
                </button>
                <button type="submit"
                    class="px-6 py-2.5 text-sm font-bold text-white bg-[#006eb7] rounded-lg hover:bg-[#005ea2] focus:outline-none focus:ring-2 focus:ring-[#006eb7] focus:ring-offset-1 flex items-center gap-2 transition-colors shadow-md hover:shadow-lg">
                    <i class="fa-solid fa-magnifying-glass" aria-hidden="true"></i> Pesquisar
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
                            autoplay: {
                                delay: 6000,
                                disableOnInteraction: false
                            },
                            pagination: {
                                el: '.swiper-pagination',
                                clickable: true
                            },
                            navigation: {
                                nextEl: '.seta-unica-next',
                                prevEl: '.seta-unica-prev'
                            },
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