<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Portal - Prefeitura de Assaí</title>

    <link rel="icon" type="image/png" href="{{ asset('img/brasao.png') }}">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;600;700;800;900&family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    @vite(['resources/css/app.css', 'resources/js/app.js', 'resources/css/home.css', 'resources/js/home.js'])
</head>

<body class="antialiased text-slate-800 bg-slate-50">
    @include('layouts.navbar')

    <main>

        @php
        $heroVideos = [
            asset('videos/DJI_0661.MP4'),
            asset('videos/DJI_0611.MP4'),
            asset('videos/DJI_0677.MP4'),
            asset('videos/DJI_0633.MP4'),
            asset('videos/' . rawurlencode('DJI_0613 (3).MP4')),
        ];
        @endphp

        {{-- ==============
             HERO SECTION
             ============== --}}
        <section id="hero-oficial" class="relative w-full overflow-hidden bg-slate-950 flex flex-col items-center justify-center">

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
            <div class="absolute inset-0 z-10 pointer-events-none" style="background-color: rgba(2, 6, 23, 0.84) !important; opacity: 1 !important;"></div>

            {{-- 3. Camada de Conteúdo Interativo (Alterado para justify-center para não empurrar a busca pro fundo) --}}
            <div class="relative z-20 w-full flex flex-col items-center justify-center pt-[110px] md:pt-[130px] pb-12 md:pb-16 px-4 sm:px-6">

                {{-- Banners Dinâmicos (Swiper) --}}
                <div class="w-full max-w-5xl flex flex-col justify-center">
                    @if(isset($banners) && $banners->count() > 0)
                    <div class="swiper swiper-banners w-full">
                        <div class="swiper-wrapper">
                            @foreach($banners as $banner)
                            <div class="swiper-slide bg-transparent flex flex-col items-center text-center justify-center pb-8">

                                <h2 class="mt-4 sm:mt-0 text-3xl md:text-5xl lg:text-6xl font-black text-white leading-tight mb-5 drop-shadow-md">
                                    {{ $banner->titulo }}
                                </h2>

                                {{-- Barra de Pesquisa Integrada (entre título e subtítulo) --}}
                                <div class="w-full max-w-4xl mx-auto mt-2 mb-6 shrink-0">

                                    {{-- Form: Bloqueia submissão se estiver vazio (onsubmit) --}}
                                    <form action="{{ route('busca.index') }}" method="GET" onsubmit="return this.q.value.trim() !== ''" class="w-full relative flex items-center bg-white rounded-full p-1.5 md:p-2 shadow-[0_15px_35px_rgba(0,0,0,0.25)] focus-within:ring-4 focus-within:ring-yellow-400/50 transition-all duration-300" role="search" aria-label="Buscar informações no portal">
                                        <label for="busca-portal-{{ $loop->index }}" class="sr-only">Buscar no portal</label>

                                        {{-- Ícone de Lupa --}}
                                        <div class="flex items-center justify-center pl-4 md:pl-5 pr-2 text-slate-400 shrink-0">
                                            <svg class="w-5 h-5 md:w-6 md:h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                                            </svg>
                                        </div>

                                        {{-- Input (min-w-0 adicionado para evitar que empurre o botão) --}}
                                        <input id="busca-portal-{{ $loop->index }}" type="text" name="q" placeholder="O que você procura?" required
                                            class="flex-1 min-w-0 bg-transparent border-none text-slate-900 md:text-slate-800 text-[15px] md:text-lg focus:ring-0 placeholder:text-slate-500 md:placeholder:text-slate-400 px-2 py-3 md:py-4 outline-none font-semibold md:font-medium w-full">

                                        {{-- Botão Redondo com melhor UX (tamanho generoso, feedback visual) --}}
                                        <button type="submit" class="shrink-0 inline-flex items-center justify-center gap-3 w-14 h-14 md:w-auto md:h-14 px-0 md:px-9 py-0 bg-yellow-400 text-blue-950 font-black leading-none text-[11px] md:text-sm rounded-full hover:bg-yellow-300 active:scale-95 focus-visible:ring-4 focus-visible:ring-yellow-300 focus-visible:ring-offset-2 transition-all duration-200 shadow-lg hover:shadow-xl whitespace-nowrap">
                                            <span class="hidden md:inline">BUSCAR</span>
                                            {{-- Ícone de seta no desktop / lupa no mobile --}}
                                            <svg class="shrink-0 w-[16px] h-[16px] md:w-5 md:h-5 md:hidden transition-transform duration-200" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3.5" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                                            </svg>
                                            <svg class="w-5 h-5 hidden md:block transition-transform duration-200" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M13 5l7 7-7 7M5 12h15"></path>
                                            </svg>
                                        </button>
                                    </form>
                                </div>

                                @if($banner->subtitulo)
                                <p class="text-sm md:text-lg lg:text-xl text-slate-100 font-medium max-w-3xl mx-auto drop-shadow mb-6 line-clamp-3 leading-relaxed">
                                    {{ $banner->subtitulo }}
                                </p>
                                @endif

                                @if($banner->link)
                                <a href="{{ $banner->link }}" class="inline-flex items-center px-8 py-3.5 bg-blue-600 hover:bg-blue-500 text-white font-bold rounded-xl transition-all shadow-lg hover:-translate-y-0.5">
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
                    @else
                    {{-- Fallback Estático Melhorado se não existirem banners no DB --}}
                    <div class="text-center flex flex-col items-center justify-center pb-8 md:pb-12">
                        <span class="inline-flex items-center px-4 py-1.5 rounded-full bg-white/20 backdrop-blur-sm text-white text-[10px] md:text-xs font-bold uppercase tracking-widest mb-6 border border-white/30 shadow-sm">
                            Portal Oficial
                        </span>

                        <h2 class="text-4xl md:text-6xl lg:text-7xl font-black text-white leading-tight mb-5 drop-shadow-lg tracking-tight">
                            Prefeitura de <span class="text-yellow-400">Assaí</span>
                        </h2>

                        {{-- Barra de Pesquisa Integrada (entre título e subtítulo) --}}
                        <div class="w-full max-w-4xl mx-auto mt-2 mb-6 shrink-0">

                            {{-- Form: Bloqueia submissão se estiver vazio (onsubmit) --}}
                            <form action="{{ route('busca.index') }}" method="GET" onsubmit="return this.q.value.trim() !== ''" class="w-full relative flex items-center bg-white rounded-full p-1.5 md:p-2 shadow-[0_15px_35px_rgba(0,0,0,0.25)] focus-within:ring-4 focus-within:ring-yellow-400/50 transition-all duration-300" role="search" aria-label="Buscar informações no portal">
                                <label for="busca-portal-fallback" class="sr-only">Buscar no portal</label>

                                {{-- Ícone de Lupa --}}
                                <div class="flex items-center justify-center pl-4 md:pl-5 pr-2 text-slate-400 shrink-0">
                                    <svg class="w-5 h-5 md:w-6 md:h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                                    </svg>
                                </div>

                                {{-- Input (min-w-0 adicionado para evitar que empurre o botão) --}}
                                <input id="busca-portal-fallback" type="text" name="q" placeholder="O que você procura?" required
                                    class="flex-1 min-w-0 bg-transparent border-none text-slate-900 md:text-slate-800 text-[15px] md:text-lg focus:ring-0 placeholder:text-slate-500 md:placeholder:text-slate-400 px-2 py-3 md:py-4 outline-none font-semibold md:font-medium w-full">

                                {{-- Botão Redondo com melhor UX (tamanho generoso, feedback visual) --}}
                                <button type="submit" class="shrink-0 inline-flex items-center justify-center gap-3 w-14 h-14 md:w-auto md:h-14 px-0 md:px-9 py-0 bg-yellow-400 text-blue-950 font-black leading-none text-[11px] md:text-sm rounded-full hover:bg-yellow-300 active:scale-95 focus-visible:ring-4 focus-visible:ring-yellow-300 focus-visible:ring-offset-2 transition-all duration-200 shadow-lg hover:shadow-xl whitespace-nowrap">
                                    <span class="hidden md:inline">BUSCAR</span>
                                    {{-- Ícone de seta no desktop / lupa no mobile --}}
                                    <svg class="shrink-0 w-[16px] h-[16px] md:w-5 md:h-5 md:hidden transition-transform duration-200" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3.5" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                                    </svg>
                                    <svg class="w-5 h-5 hidden md:block" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M13 5l7 7-7 7M5 12h15"></path>
                                    </svg>
                                </button>
                            </form>
                        </div>

                        <p class="text-sm md:text-lg lg:text-xl text-slate-100 font-medium max-w-3xl mx-auto drop-shadow-md mb-2 leading-relaxed">
                            Acesse serviços públicos, acompanhe ações da Prefeitura e encontre informações oficiais com rapidez.
                        </p>
                    </div>
                    @endif
                </div>

            </div>
        </section>

        {{-- Espaçador para testes de scroll --}}
        <div style="height: 80vh; background: #f8fafc;"></div>
    </main>
</body>

</html>