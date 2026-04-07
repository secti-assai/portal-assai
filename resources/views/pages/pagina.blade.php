@extends('layouts.app')

@section('title', 'Portal - Prefeitura de Assaí')

@section('content')
<main>

    @php
    $heroVideos = [
    asset('videos/panorama.mp4'),
    ];

    $sugestoesBusca = collect($sugestoesIA ?? [
    'Emitir nota fiscal eletronica',
    'Consultar protocolo digital',
    'Agendar atendimento administrativo',
    'Solicitar matricula na rede municipal',
    ])->take(3);
    @endphp

    {{-- =================
           HERO SECTION
           ================= --}}
    <section id="hero-oficial" class="relative w-full overflow-hidden bg-slate-950">

        {{-- 1. Camada de Fundo (Vídeo) --}}
        <div class="absolute inset-0 z-0 pointer-events-none overflow-hidden" data-hero-videos='@json($heroVideos)'>
            <video autoplay muted playsinline preload="auto" src="{{ $heroVideos[0] }}"
                class="hero-video-layer absolute inset-0 h-full w-full object-cover opacity-100 transition-opacity duration-1000 ease-in-out"
                aria-hidden="true"></video>
            <video muted playsinline preload="auto"
                class="hero-video-layer absolute inset-0 h-full w-full object-cover opacity-0 transition-opacity duration-1000 ease-in-out"
                aria-hidden="true"></video>
        </div>

        {{-- 2. Camada de Contraste (Sombra) --}}
        <div class="absolute inset-0 z-10 pointer-events-none" style="background-color: rgba(2, 6, 23, 0.70) !important; opacity: 1 !important;"></div>

        {{-- 3. Camada de Conteúdo Interativo (AQUI FOI AUMENTADO O pb-[130px] e md:pb-[160px]) --}}
        <div class="relative z-20 w-full flex flex-col items-center justify-center pt-[140px] pb-[130px] md:pt-[196px] md:pb-[160px] px-4 sm:px-6">

            {{-- Banners Dinâmicos (Swiper) --}}
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
                            <a href="{{ $banner->link }}" class="inline-flex items-center px-6 py-2.5 text-sm md:text-base font-bold bg-blue-600 hover:bg-blue-500 text-white rounded-full transition-all shadow-lg hover:-translate-y-0.5 font-heading">
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

                {{-- Barra de Pesquisa Fixa --}}
                <div class="w-full max-w-3xl mx-auto mt-10 md:mt-14 shrink-0">

                    <form action="{{ route('busca.index') }}" method="GET" onsubmit="return this.q.value.trim() !== ''" class="relative flex items-center w-full bg-white/95 focus-within:bg-white backdrop-blur-md shadow-2xl rounded-full border border-white/60 transition-all duration-300 p-1" role="search" aria-label="Buscar informações no portal">
                        <label for="busca-portal-fixo" class="sr-only">Buscar no portal</label>

                        <div class="flex items-center justify-center pl-4 md:pl-5 pr-2 text-slate-400 shrink-0 hidden md:flex" aria-hidden="true">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                            </svg>
                        </div>

                        <input id="busca-portal-fixo" type="text" name="q" placeholder="O que você procura?" required
                            class="flex-1 min-w-0 px-3 py-2.5 text-sm text-gray-800 bg-transparent border-none md:px-2 md:py-4 md:text-base focus:ring-0 focus:outline-none font-sans placeholder:text-slate-400 w-full">

                        <button type="submit" class="m-1.5 px-3.5 max-[360px]:px-3 py-2.5 max-[360px]:py-2 font-bold text-sm text-blue-900 transition-all bg-yellow-400 rounded-full shrink-0 md:px-6 md:py-3 hover:bg-yellow-500 hover:shadow-lg font-heading">
                            Buscar
                        </button>
                    </form>

                    @if($sugestoesBusca->count() > 0)
                    <div class="flex flex-wrap items-center justify-center gap-2 mt-3 md:mt-4 max-w-xs sm:max-w-2xl lg:max-w-4xl px-2 sm:px-4 mx-auto">
                        @foreach($sugestoesBusca as $sugestao)
                        <a href="{{ route('busca.index', ['q' => $sugestao]) }}"
                            aria-label="Sugestão de busca: {{ $sugestao }}"
                            class="inline-flex items-center gap-1.5 px-3 py-1.5 text-[11px] sm:text-xs font-semibold text-white cursor-pointer select-none transition-all duration-200 bg-white/10 border border-white/25 backdrop-blur-sm rounded-full hover:bg-blue-600 hover:text-white hover:border-transparent hover:shadow-md active:scale-95 focus:outline-none focus:ring-2 focus:ring-white/60 font-sans whitespace-nowrap">
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
                {{-- Fallback Estático Melhorado se não existirem banners no DB --}}
                <div class="text-center flex flex-col items-center justify-center">
                    <span class="inline-flex items-center px-4 py-1.5 rounded-full bg-white/20 backdrop-blur-sm text-white text-[10px] md:text-xs font-bold uppercase tracking-widest mb-6 border border-white/30 shadow-sm">
                        Portal Oficial
                    </span>

                    <h2 class="mb-3 text-2xl sm:text-3xl md:text-5xl max-[360px]:text-[1.6rem] font-extrabold text-white drop-shadow-md font-heading leading-tight max-w-4xl mx-auto text-center break-words">
                        Prefeitura de <span class="text-yellow-400">Assaí</span>
                    </h2>

                    <p class="text-sm sm:text-base md:text-lg text-slate-100 font-medium max-w-3xl mx-auto drop-shadow-md mb-4 leading-relaxed text-center">
                        Acesse serviços públicos, acompanhe ações da Prefeitura e encontre informações oficiais com rapidez.
                    </p>

                    <a href="{{ route('busca.index') }}" class="inline-flex items-center px-6 py-2.5 mb-10 text-sm md:text-base font-bold bg-blue-600 hover:bg-blue-500 text-white rounded-full transition-all shadow-lg hover:-translate-y-0.5 font-heading mx-auto">
                        Saiba mais
                        <svg class="w-5 h-5 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M14 5l7 7m0 0l-7 7m7-7H3"></path>
                        </svg>
                    </a>

                    {{-- Barra de Pesquisa Integrada (Fallback) --}}
                    <div class="w-full max-w-3xl mx-auto mt-4 shrink-0">
                        <form action="{{ route('busca.index') }}" method="GET" onsubmit="return this.q.value.trim() !== ''" class="relative flex items-center w-full bg-white/95 focus-within:bg-white backdrop-blur-md shadow-2xl rounded-full border border-white/60 transition-all duration-300 p-1" role="search" aria-label="Buscar informações no portal">
                            <label for="busca-portal-fallback" class="sr-only">Buscar no portal</label>

                            <div class="flex items-center justify-center pl-4 md:pl-5 pr-2 text-slate-400 shrink-0 hidden md:flex" aria-hidden="true">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                                </svg>
                            </div>

                            <input id="busca-portal-fallback" type="text" name="q" placeholder="O que você procura?" required
                                class="flex-1 min-w-0 px-3 py-2.5 text-sm text-gray-800 bg-transparent border-none md:px-2 md:py-4 md:text-base focus:ring-0 focus:outline-none font-sans placeholder:text-slate-400 w-full">

                            <button type="submit" class="m-1.5 px-3.5 max-[360px]:px-3 py-2.5 max-[360px]:py-2 font-bold text-sm text-blue-900 transition-all bg-yellow-400 rounded-full shrink-0 md:px-6 md:py-3 hover:bg-yellow-500 hover:shadow-lg font-heading">
                                Buscar
                            </button>
                        </form>

                        {{-- Chips de Sugestão --}}
                        @if($sugestoesBusca->count() > 0)
                        <div class="flex flex-wrap items-center justify-center gap-2 mt-3 md:mt-4 max-w-xs sm:max-w-2xl lg:max-w-4xl px-2 sm:px-4 mx-auto">
                            @foreach($sugestoesBusca as $sugestao)
                            <a href="{{ route('busca.index', ['q' => $sugestao]) }}"
                                aria-label="Sugestão de busca: {{ $sugestao }}"
                                class="inline-flex items-center gap-1.5 px-3 py-1.5 text-[11px] sm:text-xs font-semibold text-white cursor-pointer select-none transition-all duration-200 bg-white/10 border border-white/25 backdrop-blur-sm rounded-full hover:bg-blue-600 hover:text-white hover:border-transparent hover:shadow-md active:scale-95 focus:outline-none focus:ring-2 focus:ring-white/60 font-sans whitespace-nowrap">
                                <svg class="w-3 h-3 opacity-70" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                                </svg>
                                {{ $sugestao }}
                            </a>
                            @endforeach
                        </div>
                        @endif
                    </div>
                </div>
                @endif
            </div>

        </div>

        {{-- Indicador de rolagem para próxima seção --}}
        <div class="absolute bottom-6 md:bottom-10 left-1/2 -translate-x-1/2 z-30 flex flex-col items-center">
            {{-- Texto auxiliar visível apenas no desktop --}}
            <span class="hidden md:block mb-3 text-[10px] font-bold tracking-[0.2em] text-white/70 uppercase">
                Role para explorar
            </span>

            {{-- Botão com efeito de vidro e animação suave --}}
            <a href="#noticias" class="inline-flex items-center justify-center w-10 h-10 md:w-12 md:h-12 text-white transition-all duration-300 border border-white/20 rounded-full bg-white/10 backdrop-blur-md hover:bg-white/20 hover:scale-110 animate-bounce focus:outline-none focus:ring-2 focus:ring-yellow-400 shadow-lg" aria-label="Ir para a próxima seção">
                <svg class="w-5 h-5 md:w-6 md:h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 14l-7 7m0 0l-7-7m7 7V3"></path>
                </svg>
            </a>
        </div>
    </section>

    {{-- ═══════════════════════════════════════════════
             3. NOTÍCIAS (Estilo Glassmorphism Claro - Igual à pág de Notícias)
        ════════════════════════════════════════════════ --}}
    <section id="noticias" class="py-16 bg-white scroll-mt-20 md:scroll-mt-24" aria-labelledby="titulo-noticias">
        <div class="container px-4 mx-auto max-w-6xl font-sans">

            {{-- Cabeçalho --}}
            <div class="flex flex-col items-center mb-12 text-center">
                <h2 id="titulo-noticias" class="text-2xl font-extrabold text-blue-900 sm:text-3xl font-heading uppercase tracking-tight">
                    Últimas Notícias
                </h2>
                <div class="w-10 h-1 mt-3 bg-yellow-400"></div>
            </div>

            @if($noticias->count() > 0)
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 lg:gap-8 justify-center">
                @foreach($noticias->take(3) as $noticia)
                <article class="relative h-[350px] md:h-[430px] overflow-hidden rounded-2xl group bg-slate-100 shadow-md hover:shadow-xl transition-shadow duration-300">
                    <a href="{{ route('noticias.show', $noticia->slug) }}" class="block w-full h-full outline-none focus-within:ring-4 focus-within:ring-blue-500 focus-within:ring-inset">

                        {{-- Foto (Estilo object-cover da página de notícias) --}}
                        <img src="{{ $noticia->imagem_capa ? asset('storage/' . $noticia->imagem_capa) : asset('img/Assaí.jpg') }}"
                            alt=""
                            class="absolute inset-0 object-cover w-full h-full transition-transform duration-700 ease-out group-hover:scale-110"
                            loading="lazy" decoding="async">

                        {{-- Overlay de Gradiente --}}
                        <div class="absolute inset-0 bg-gradient-to-t from-black/80 via-black/20 to-transparent opacity-80"></div>

                        {{-- Barra de Vidro Clara (Com Expansão Automática corrigida) --}}
                        <div class="absolute bottom-0 left-0 w-full p-5 lg:p-6 bg-white/10 backdrop-blur-lg border-t border-white/30 flex flex-col justify-end transition-all duration-500">

                            <h3 class="text-sm sm:text-base font-bold leading-snug text-white font-heading drop-shadow-md">
                                {{ ucfirst(Str::lower($noticia->titulo)) }}
                            </h3>

                            {{-- Conteúdo Revelado (Grid Animado para não sobrar espaço vazio) --}}
                            <div class="grid grid-rows-[0fr] group-hover:grid-rows-[1fr] transition-all duration-500 ease-in-out mt-2">
                                <div class="overflow-hidden opacity-0 group-hover:opacity-100 transition-opacity duration-500 delay-100">

                                    <p class="pt-2 text-[13px] leading-relaxed text-gray-100 font-sans line-clamp-4 lg:line-clamp-5 mb-4">
                                        {{ $noticia->resumo ?? Str::limit(strip_tags($noticia->conteudo), 160) }}
                                    </p>

                                    <div class="flex items-center justify-between border-t border-white/20 pt-4">
                                        <span class="text-[10px] font-bold text-yellow-400 uppercase tracking-widest drop-shadow-sm">
                                            Ler mais
                                        </span>
                                        <time class="text-[10px] font-medium text-gray-300">
                                            {{ \Carbon\Carbon::parse($noticia->data_publicacao)->format('d/m/Y') }}
                                        </time>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </a>
                </article>
                @endforeach
            </div>

            {{-- Botão Ver Mais --}}
            <div class="mt-12 text-center">
                <a href="{{ route('noticias.index') }}" class="inline-flex items-center gap-3 px-10 py-4 text-sm font-bold text-white transition-all bg-blue-800 rounded-full shadow-xl hover:bg-blue-900 hover:shadow-2xl hover:-translate-y-1 group">
                    <i class="fas fa-newspaper transition-transform group-hover:rotate-12"></i>
                    Ver todas as Notícias
                </a>
            </div>
            @endif
        </div>
    </section>
</main>
@endsection