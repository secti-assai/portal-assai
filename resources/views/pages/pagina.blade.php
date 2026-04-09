@extends('layouts.app')

@section('title', 'Portal - Prefeitura de Assaí')

@section('content')

<main id="home-main" class="transition-opacity duration-300">

    <div id="hero-mobile-loader" class="fixed inset-0 z-[120] flex items-center justify-center bg-gradient-to-b from-slate-950 via-blue-950 to-slate-900 text-white transition-opacity duration-500 lg:hidden" aria-live="polite">
        <div class="flex flex-col items-center gap-5 px-6 text-center">
            <img src="{{ asset('img/logo_branca.png') }}" alt="Prefeitura de Assaí" loading="eager" decoding="sync" fetchpriority="high" class="w-56 max-w-[80vw] h-auto object-contain">
            <div class="flex items-center gap-3 text-xs sm:text-sm font-semibold tracking-[0.18em] uppercase text-blue-100">
                <span class="inline-block h-5 w-5 rounded-full border-2 border-white/35 border-t-white animate-spin" aria-hidden="true"></span>
                Preparando experiência
            </div>
        </div>
    </div>

    @php
    $heroVideos = [ asset('videos/panorama.mp4') ];

    $sugestoesBusca = collect($sugestoesIA ?? [
    'Emitir nota fiscal eletronica',
    'Consultar protocolo digital',
    'Agendar atendimento administrativo',
    'Solicitar matricula na rede municipal',
    ])->take(3);

    $servicosPlMobile = [
    ['titulo' => 'Lista de Espera para CEMAI', 'descricao' => 'Consulte informações sobre inscrições e vagas disponíveis nas creches municipais de Pedro Leopoldo.', 'link' => '#', 'icone' => 'fa-baby'],
    ['titulo' => 'Vagas de Emprego', 'descricao' => 'Veja as vagas de emprego atualizadas pelo SINE e saiba como se candidatar.', 'link' => '#', 'icone' => 'fa-briefcase'],
    ['titulo' => 'Coleta de Lixo', 'descricao' => 'Confira aqui os locais e horários das coletas de lixo domiciliar e seletiva.', 'link' => '#', 'icone' => 'fa-trash-can'],
    ['titulo' => 'Concursos e Proc. Seletivos', 'descricao' => 'Acompanhe editais, inscrições e resultados dos processos seletivos da administração municipal.', 'link' => '#', 'icone' => 'fa-file-circle-check'],
    ['titulo' => 'Multas de Trânsito', 'descricao' => 'Consulte infrações e como realizar pagamento ou recurso de multas.', 'link' => '#', 'icone' => 'fa-car-burst'],
    ['titulo' => 'IPTU', 'descricao' => 'Emita guias, consulte débitos e obtenha informações sobre o IPTU.', 'link' => '#', 'icone' => 'fa-file-invoice-dollar'],
    ['titulo' => 'Iluminação Pública', 'descricao' => 'Solicite troca de lâmpadas queimadas e falhas na iluminação pública.', 'link' => '#', 'icone' => 'fa-lightbulb'],
    ['titulo' => 'Horário de Ônibus', 'descricao' => 'Confira horários e itinerários do transporte coletivo municipal.', 'link' => '#', 'icone' => 'fa-bus'],
    ['titulo' => 'Telefones Úteis', 'descricao' => 'Encontre contatos importantes de serviços públicos e emergenciais da cidade.', 'link' => '#', 'icone' => 'fa-phone'],
    ['titulo' => 'Ouvidoria', 'descricao' => 'Saiba como registrar sugestões, elogios, solicitações ou denúncias.', 'link' => '#', 'icone' => 'fa-circle-info'],
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
         MOBILE SECTION (ESTILO PEDRO LEOPOLDO)
         ========================================== --}}
    <section id="pl-mobile-home" class="lg:hidden">

        {{-- Hero --}}
        <div class="home-hero-mobile">
            <div class="home-hero-content">
                <h1 class="hero-title">O QUE VOCÊ <strong>PRECISA?</strong></h1>
                <form action="{{ route('busca.index') }}" method="GET" class="home-search-bar" role="search">
                    <input class="wp-block-search__input" type="search" name="q" placeholder="Horário ônibus" required>
                    <button class="wp-block-search__button" type="submit" aria-label="Pesquisar">
                        <i class="fa-solid fa-magnifying-glass" aria-hidden="true"></i>
                    </button>
                </form>
            </div>
        </div>

        {{-- Mais Acessados --}}
        <section class="bg-white-section">
            <h2 class="section-title">Mais Acessados</h2>
            <div class="small-cards-grid">

                @if(isset($servicos) && $servicos->count() > 0)
                @foreach($servicos->take(8) as $servicoItem)
                @php
                $ancoraBalão = $loop->odd ? 'left-[-4px]' : 'right-[-4px]';
                @endphp

                <div x-data="{ open: false }" class="small-card group relative" @click.outside="open = false">

                    {{-- Botão de Interrogação --}}
                    <button
                        @click.prevent="open = !open"
                        type="button"
                        class="absolute right-4 top-2 w-8 h-8 flex items-center justify-center text-[#006eb7] text-xl font-medium focus:outline-none z-20 bg-transparent rounded-full"
                        style="font-family: 'Montserrat', sans-serif;"
                        aria-label="Informações sobre o serviço">
                        ?
                    </button>

                    {{-- Balão de Descrição (Sem Seta) --}}
                    <div
                        x-show="open"
                        x-transition:enter="transition ease-out duration-200"
                        x-transition:enter-start="opacity-0 translate-y-2"
                        x-transition:enter-end="opacity-100 translate-y-0"
                        x-transition:leave="transition ease-in duration-150"
                        x-transition:leave-start="opacity-100 translate-y-0"
                        x-transition:leave-end="opacity-0 translate-y-2"
                        class="absolute top-11 {{ $ancoraBalão }} z-30 w-[220px] p-3.5 text-[0.8rem] leading-relaxed text-left text-white bg-[#11181d] rounded-xl shadow-2xl pointer-events-none"
                        style="display: none;">
                        {{ $servicoItem->descricao ?? 'Acesse este serviço para obter mais detalhes e informações úteis ao cidadão.' }}
                    </div>

                    {{-- Link do Card --}}
                    <a href="{{ $servicoItem->url_acesso ?? $servicoItem->link ?? '#' }}" target="_blank" rel="noopener" class="flex flex-col items-center w-full mt-2 px-1 z-0">
                        @php
                        $iconeServico = !empty($servicoItem->icone) ? str_replace(['fa-', 'fas ', 'fa-solid '], '', $servicoItem->icone) : 'file-lines';
                        @endphp
                        <i class="fa-solid fa-{{ $iconeServico }} service-icon" aria-hidden="true"></i>
                        <h4 class="small-card-title">{{ $servicoItem->titulo }}</h4>
                    </a>
                </div>
                @endforeach

                @else
                {{-- Bloco Secundário (Fallback de Dados) --}}
                @foreach(collect($servicosPlMobile)->take(8) as $servicoItem)
                @php
                $ancoraBalão = $loop->odd ? 'left-[-4px]' : 'right-[-4px]';
                @endphp

                <div x-data="{ open: false }" class="small-card group relative" @click.outside="open = false">

                    {{-- Botão de Interrogação --}}
                    <button
                        @click.prevent="open = !open"
                        type="button"
                        class="absolute right-4 top-2 w-8 h-8 flex items-center justify-center text-[#006eb7] text-xl font-medium focus:outline-none z-20 bg-transparent rounded-full"
                        style="font-family: 'Montserrat', sans-serif;"
                        aria-label="Informações">
                        ?
                    </button>

                    {{-- Balão de Descrição (Sem Seta) --}}
                    <div
                        x-show="open"
                        x-transition
                        class="absolute top-11 {{ $ancoraBalão }} z-30 w-[220px] p-3.5 text-[0.8rem] leading-relaxed text-left text-white bg-[#11181d] rounded-xl shadow-2xl pointer-events-none"
                        style="display: none;">
                        {{ $servicoItem['descricao'] }}
                    </div>

                    <a href="{{ $servicoItem['link'] }}" target="_blank" rel="noopener" class="flex flex-col items-center w-full mt-2 px-1 z-0">
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

        {{-- Fique Ligado --}}
        <section class="bg-white-section" style="padding-top: 0; padding-bottom: 1.5rem;">
            <h2 class="section-title">Fique ligado</h2>
            @if(isset($programas) && $programas->count() > 0)
            <div class="glide__slides">
                @foreach($programas->take(3) as $programa)
                <a href="{{ $programa->link ?? '#' }}" class="glide__slide relative h-[320px] overflow-hidden rounded-2xl group bg-slate-100 shadow-md">
                    <img src="{{ $programa->imagem ? asset('storage/' . $programa->imagem) : asset('img/Assai.jpg') }}" alt="" loading="lazy" class="absolute inset-0 object-cover w-full h-full transition-transform duration-700 ease-out group-hover:scale-105">
                    <div class="absolute inset-0 bg-gradient-to-t from-black/80 via-black/20 to-transparent opacity-80 pointer-events-none"></div>
                    <span class="absolute bottom-0 left-0 w-full p-5 bg-white/10 backdrop-blur-lg border-t border-white/30 z-10 block text-sm font-bold leading-snug text-white font-heading drop-shadow-md">{{ Str::limit(ucfirst(Str::lower($programa->titulo)), 66) }}</span>
                </a>
                @endforeach
            </div>
            <div class="all-btn-wrapper">
                <a href="{{ route('programas.index') }}" class="all-btn">
                    <i class="fa-solid fa-bullhorn"></i> Ver Todos Programas
                </a>
            </div>
            @endif

        </section>

        {{-- Últimas Notícias --}}
        <section class="bg-gray-section">
            <h2 class="section-title">Últimas Notícias</h2>
            <div class="mobile-news-grid">
                @if(isset($noticias))
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
                @endif
            </div>
            <div class="all-btn-wrapper">
                <a href="{{ route('noticias.index') }}" class="all-btn">
                    <i class="fa-regular fa-newspaper" aria-hidden="true"></i> Ver Todas Notícias
                </a>
            </div>
        </section>

        {{-- Calendário --}}
        <section class="bg-gray-section" style="padding-top: 0;">
            <h2 class="section-title">Calendário de Eventos</h2>

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
         DESKTOP SECTION (ALINHADO COM MOBILE)
         ========================================== --}}

    {{-- HERO DESKTOP (MANTIDO INTACTO) --}}
    <section id="hero-oficial" class="hidden lg:block relative w-full overflow-hidden bg-slate-950">

        <div class="absolute inset-0 z-0 pointer-events-none overflow-hidden bg-slate-950">
            <video id="hero-video-lazy"
                class="hero-video-layer absolute inset-0 w-full h-full object-cover opacity-0 transition-opacity duration-1000"
                autoplay muted loop playsinline preload="none">
                <source data-src="{{ asset('videos/panorama.mp4') }}" type="video/mp4">
            </video>
        </div>

        <div class="absolute inset-0 z-10 pointer-events-none" style="background-color: rgba(2, 6, 23, 0.70) !important; opacity: 1 !important;"></div>

        <div id="hero-video-loader" class="fixed inset-0 z-[120] flex items-center justify-center bg-gradient-to-b from-slate-950 via-blue-950 to-slate-900 text-white transition-opacity duration-500" aria-live="polite">
            <div class="flex flex-col items-center gap-5 px-6 text-center">
                <img src="{{ asset('img/logo_branca.png') }}" alt="Prefeitura de Assaí" loading="eager" decoding="sync" fetchpriority="high" class="w-56 max-w-[80vw] h-auto object-contain">
                <div class="flex items-center gap-3 text-xs sm:text-sm font-semibold tracking-[0.18em] uppercase text-blue-100">
                    <span class="inline-block h-5 w-5 rounded-full border-2 border-white/35 border-t-white animate-spin" aria-hidden="true"></span>
                    Preparando experiência
                </div>
            </div>
        </div>

        <div class="relative z-30 w-full flex flex-col items-center justify-center pt-24 pb-20 md:pt-[196px] md:pb-[160px] px-4 sm:px-6 h-full">
            <div class="w-full max-w-5xl flex flex-col justify-center">
                @if(isset($banners) && $banners->count() > 0)
                <div class="swiper swiper-hero-banners w-full">
                    <div class="swiper-wrapper">
                        @foreach($banners as $banner)
                        <div class="swiper-slide bg-transparent flex flex-col items-center text-center justify-center px-1">
                            <h2 class="w-full max-w-4xl mx-auto mb-2 sm:mb-4 text-lg sm:text-3xl md:text-5xl max-[360px]:text-base font-extrabold text-white break-words drop-shadow-lg font-heading leading-tight text-center">
                                {{ $banner->titulo }}
                            </h2>
                            @if($banner->subtitulo)
                            <p class="w-full max-w-2xl mx-auto mt-1 mb-5 text-xs sm:text-base md:text-lg font-medium text-blue-100 break-words drop-shadow font-sans max-[360px]:hidden line-clamp-3 leading-relaxed text-center">
                                {{ $banner->subtitulo }}
                            </p>
                            @endif
                            @if($banner->link)
                            <a href="{{ $banner->link }}" class="inline-flex items-center px-6 py-2.5 text-sm md:text-base font-bold bg-blue-600 hover:bg-blue-50 text-white rounded-full transition-all shadow-lg hover:-translate-y-0.5 font-heading">
                                Saiba mais
                                <svg class="w-5 h-5 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M14 5l7 7m0 0l-7 7m7-7H3"></path>
                                </svg>
                            </a>
                            @endif
                        </div>
                        @endforeach
                    </div>
                </div>

                <div class="w-full max-w-3xl mx-auto mt-10 md:mt-14 shrink-0">
                    <form action="{{ route('busca.index') }}" method="GET" onsubmit="return this.q.value.trim() !== ''" class="relative flex items-center w-full bg-white/95 focus-within:bg-white backdrop-blur-md shadow-2xl rounded-full border border-white/60 transition-all duration-300 p-1" role="search">
                        <label for="busca-portal-fixo" class="sr-only">Buscar no portal</label>
                        <div class="flex items-center justify-center pl-4 md:pl-5 pr-2 text-slate-400 shrink-0 hidden md:flex" aria-hidden="true">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                            </svg>
                        </div>
                        <input id="busca-portal-fixo" type="text" name="q" placeholder="O que você procura?" required class="flex-1 min-w-0 px-3 py-2.5 text-sm text-gray-800 bg-transparent border-none md:px-2 md:py-4 md:text-base focus:ring-0 focus:outline-none font-sans placeholder:text-slate-400 w-full">
                        <button type="submit" class="m-1.5 px-3.5 max-[360px]:px-3 py-2.5 max-[360px]:py-2 font-bold text-sm text-blue-900 transition-all bg-yellow-400 rounded-full shrink-0 md:px-6 md:py-3 hover:bg-yellow-500 hover:shadow-lg font-heading">
                            Buscar
                        </button>
                    </form>

                    @if($sugestoesBusca->count() > 0)
                    <div class="flex flex-wrap items-center justify-center gap-2 mt-3 md:mt-4 max-w-xs sm:max-w-2xl lg:max-w-4xl px-2 sm:px-4 mx-auto">
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
                @else
                <div class="text-center flex flex-col items-center justify-center">
                    <span class="inline-flex items-center px-4 py-1.5 rounded-full bg-white/20 backdrop-blur-sm text-white text-[10px] md:text-xs font-bold uppercase tracking-widest mb-6 border border-white/30 shadow-sm">Portal Oficial</span>
                    <h2 class="mb-3 text-2xl sm:text-3xl md:text-5xl max-[360px]:text-[1.6rem] font-extrabold text-white drop-shadow-md font-heading leading-tight max-w-4xl mx-auto text-center break-words">Prefeitura de <span class="text-yellow-400">Assaí</span></h2>
                    <p class="text-sm sm:text-base md:text-lg text-slate-100 font-medium max-w-3xl mx-auto drop-shadow-md mb-4 leading-relaxed text-center">Acesse serviços públicos, acompanhe ações da Prefeitura e encontre informações oficiais com rapidez.</p>
                    <a href="{{ route('busca.index') }}" class="inline-flex items-center px-6 py-2.5 mb-10 text-sm md:text-base font-bold bg-blue-600 hover:bg-blue-500 text-white rounded-full transition-all shadow-lg hover:-translate-y-0.5 font-heading mx-auto">Saiba mais<svg class="w-5 h-5 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M14 5l7 7m0 0l-7 7m7-7H3"></path>
                        </svg></a>
                </div>
                @endif
            </div>
        </div>

        <div class="absolute bottom-6 md:bottom-10 left-1/2 -translate-x-1/2 z-30 flex flex-col items-center">
            <span class="hidden md:block mb-3 text-[10px] font-bold tracking-[0.2em] text-white/70 uppercase">Role para explorar</span>
            <a href="#servicos-desktop" class="inline-flex items-center justify-center w-10 h-10 md:w-12 md:h-12 text-white transition-all duration-300 border border-white/20 rounded-full bg-white/10 backdrop-blur-md hover:bg-white/20 hover:scale-110 animate-bounce focus:outline-none focus:ring-2 focus:ring-yellow-400 shadow-lg"><svg class="w-5 h-5 md:w-6 md:h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 14l-7 7m0 0l-7-7m7 7V3"></path>
                </svg></a>
        </div>
    </section>

    {{-- SERVIÇOS (DESKTOP) --}}
    <section id="servicos-desktop" class="hidden lg:block py-16 bg-white border-b border-[#e2e8f0]" style="scroll-margin-top: calc(var(--site-header-height, 130px) + 16px);">
        <div class="container px-4 mx-auto max-w-6xl font-sans">
            <h2 class="text-[1.72rem] font-light text-[#4a5c6a] text-center mb-10" style="font-family: 'Montserrat', sans-serif;">Mais Acessados</h2>

            @if(isset($servicos) && $servicos->count() > 0)
            <div class="grid grid-cols-4 lg:grid-cols-5 gap-4">
                @foreach($servicos->take(10) as $servico)
                <a href="{{ $servico->url_acesso ?? $servico->link ?? '#' }}" target="_blank" rel="noopener" class="bg-white rounded-[22px] border border-[#edf2f7] p-5 flex flex-col items-center text-center relative shadow-[0_6px_14px_rgba(15,23,42,0.07)] hover:-translate-y-1 transition-transform duration-300 group">

                    {{-- Tooltip Escuro (Surge no Hover) --}}
                    <div class="absolute bottom-full left-1/2 -translate-x-1/2 mb-3 w-56 bg-[#11181d] text-white text-xs font-normal text-left p-3 rounded-lg opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all duration-300 z-20 pointer-events-none shadow-xl leading-relaxed">
                        {{ $servico->descricao ?? 'Acesse este serviço para obter mais detalhes e informações úteis ao cidadão.' }}
                        <div class="absolute top-full left-1/2 -translate-x-1/2 border-[6px] border-transparent border-t-[#11181d]"></div>
                    </div>

                    <span class="absolute right-4 top-2 text-[#006eb7] text-xl font-medium" style="font-family: 'Montserrat', sans-serif;">?</span>

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
                <a href="{{ $servico['link'] }}" target="_blank" rel="noopener" class="bg-white rounded-[22px] border border-[#edf2f7] p-5 flex flex-col items-center text-center relative shadow-[0_6px_14px_rgba(15,23,42,0.07)] hover:-translate-y-1 transition-transform duration-300 group">

                    {{-- Tooltip Escuro (Surge no Hover) --}}
                    <div class="absolute bottom-full left-1/2 -translate-x-1/2 mb-3 w-56 bg-[#11181d] text-white text-xs font-normal text-left p-3 rounded-lg opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all duration-300 z-20 pointer-events-none shadow-xl leading-relaxed">
                        {{ $servico['descricao'] }}
                        <div class="absolute top-full left-1/2 -translate-x-1/2 border-[6px] border-transparent border-t-[#11181d]"></div>
                    </div>

                    <span class="absolute right-4 top-2 text-[#006eb7] text-xl font-medium" style="font-family: 'Montserrat', sans-serif;">?</span>
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

    {{-- PROGRAMAS E AÇÕES (DESKTOP) --}}
    <section id="programas-desktop" class="hidden lg:block pb-16 pt-4 bg-white">
        <div class="container px-4 mx-auto max-w-6xl font-sans">
            <h2 class="text-[1.72rem] font-light text-[#4a5c6a] text-center mb-10" style="font-family: 'Montserrat', sans-serif;">Fique ligado</h2>

            @if(isset($programas) && $programas->count() > 0)
            <div class="grid grid-cols-3 gap-6">
                @foreach($programas->take(3) as $programa)
                <a href="{{ $programa->link ?? '#' }}" class="relative rounded-[16px] overflow-hidden shadow-[0_4px_10px_rgba(0,0,0,0.08)] group h-[340px] bg-white">
                    <img src="{{ $programa->imagem ? asset('storage/' . $programa->imagem) : asset('img/Assai.jpg') }}" class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-105" alt="{{ $programa->titulo }}">
                    <div class="absolute inset-0 bg-gradient-to-t from-[#020617]/80 via-[#020617]/10 to-transparent pointer-events-none"></div>
                    <div class="absolute bottom-0 left-0 w-full p-6 bg-white/10 backdrop-blur-md border-t border-white/30 z-10">
                        <h3 class="text-lg font-semibold text-white leading-snug drop-shadow-md" style="font-family: 'Montserrat', sans-serif;">{{ $programa->titulo }}</h3>
                    </div>
                </a>
                @endforeach
            </div>

            <div class="mt-10 flex justify-center">
                <a href="{{ route('programas.index') }}" class="bg-[#006eb7] text-white rounded-full px-8 py-3 text-base font-bold flex items-center gap-2 hover:bg-blue-800 transition shadow-md">
                    <i class="fa-solid fa-bullhorn"></i> Ver Todos Programas
                </a>
            </div>
            @endif
        </div>
    </section>

    {{-- NOTÍCIAS (DESKTOP) --}}
    <section id="noticias-desktop" class="hidden lg:block py-16 bg-[#eef1f5]">
        <div class="container px-4 mx-auto max-w-6xl font-sans">
            <h2 class="text-[1.72rem] font-light text-[#4a5c6a] text-center mb-10" style="font-family: 'Montserrat', sans-serif;">Últimas Notícias</h2>

            @if(isset($noticias) && $noticias->count() > 0)
            <div class="grid grid-cols-3 gap-6">
                @foreach($noticias->take(3) as $noticia)
                <article class="relative rounded-[16px] overflow-hidden shadow-[0_4px_10px_rgba(0,0,0,0.08)] group h-[460px] bg-white">
                    <a href="{{ route('noticias.show', $noticia->slug) }}" class="block w-full h-full outline-none focus-within:ring-4 focus-within:ring-blue-500 focus-within:ring-inset">
                        <img src="{{ $noticia->imagem_capa ? asset('storage/' . $noticia->imagem_capa) : asset('img/Assai.jpg') }}" class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-105" alt="{{ $noticia->titulo }}">
                        <div class="absolute inset-0 bg-gradient-to-t from-[#020617]/80 via-[#020617]/10 to-transparent pointer-events-none"></div>

                        {{-- Caixa de Vidro Inferior com a transição sanfona no hover --}}
                        <div class="absolute bottom-0 left-0 w-full p-6 bg-white/10 backdrop-blur-md border-t border-white/30 z-10 flex flex-col justify-end transition-all duration-500">
                            <h3 class="text-[1.05rem] font-semibold text-white leading-snug drop-shadow-md" style="font-family: 'Montserrat', sans-serif;">{{ ucfirst(Str::lower($noticia->titulo)) }}</h3>

                            {{-- Conteúdo Revelado no Hover --}}
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
            <h2 class="text-[1.72rem] font-light text-[#4a5c6a] text-center mb-10" style="font-family: 'Montserrat', sans-serif;">Calendário de Eventos</h2>

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
</main>
@endsection