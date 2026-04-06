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

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" />

    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    @vite(['resources/css/app.css', 'resources/js/app.js', 'resources/css/home.css', 'resources/js/home.js'])
</head>

<body class="antialiased text-slate-800 bg-slate-50">
    @include('layouts.navbar')

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

            {{-- 3. Camada de Conteúdo Interativo --}}
            <div class="relative z-20 w-full flex flex-col items-center justify-center pt-[140px] pb-10 md:pt-[196px] md:pb-24 px-4 sm:px-6">

                {{-- Banners Dinâmicos (Swiper) --}}
                <div class="w-full max-w-5xl flex flex-col justify-center">
                    @if(isset($banners) && $banners->count() > 0)
                    <div class="swiper swiper-banners w-full">
                        <div class="swiper-wrapper">
                            @foreach($banners as $banner)
                            <div class="swiper-slide bg-transparent flex flex-col items-center text-center justify-center px-1">

                                {{-- TÍTULO: Adicionado 'mx-auto' para centralizar corretamente --}}
                                <h2 class="w-full max-w-4xl mx-auto mb-2 sm:mb-4 text-lg sm:text-3xl md:text-5xl max-[360px]:text-base font-extrabold text-white break-words drop-shadow-lg font-heading leading-tight text-center">
                                    {{ $banner->titulo }}
                                </h2>

                                @if($banner->subtitulo)
                                {{-- SUBTÍTULO: Adicionado 'mx-auto' para centralizar corretamente --}}
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

                    {{-- Barra de Pesquisa Fixa (independente do banner ativo) --}}
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

                            {{-- Form: Bloqueia submissão se estiver vazio (onsubmit) --}}
                            <form action="{{ route('busca.index') }}" method="GET" onsubmit="return this.q.value.trim() !== ''" class="relative flex items-center w-full bg-white/95 focus-within:bg-white backdrop-blur-md shadow-2xl rounded-full border border-white/60 transition-all duration-300 p-1" role="search" aria-label="Buscar informações no portal">
                                <label for="busca-portal-fallback" class="sr-only">Buscar no portal</label>

                                {{-- Ícone de Lupa --}}
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
            <div class="z-30 flex justify-center mt-2 mb-2 md:mb-0 md:absolute md:left-1/2 md:-translate-x-1/2 md:bottom-6">
                <a href="#noticias" class="inline-flex p-2 text-white opacity-90 animate-bounce focus:outline-none" aria-label="Ir para a próxima seção">
                    <svg class="w-8 h-8 drop-shadow-lg" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 14l-7 7m0 0l-7-7m7 7V3"></path>
                    </svg>
                </a>
            </div>
        </section>

        {{-- Últimas Notícias --}}
        <section id="noticias" class="bg-slate-100 py-10 md:py-14 scroll-mt-28 md:scroll-mt-28">
            <div class="container mx-auto px-4 sm:px-6 max-w-6xl">
                <header class="text-center mb-7 md:mb-10">
                    <div class="inline-flex items-center gap-3 text-sky-600">
                        <span class="block w-12 md:w-16 h-[2px] bg-sky-400"></span>
                        <span class="text-base sm:text-xl md:text-2xl font-extrabold tracking-wide uppercase font-heading">Últimas Notícias</span>
                        <span class="block w-12 md:w-16 h-[2px] bg-sky-400"></span>
                    </div>
                </header>

                @php
                $noticiasLista = isset($noticias) ? $noticias : collect();
                $noticiaDestaque = $noticiasLista->first();
                $noticiasRecentes = $noticiasLista->skip(1)->take(4);
                $noticiasMobile = $noticiasLista->take(4);
                @endphp

                @if($noticiaDestaque)
                @php
                $imagemDestaque = $noticiaDestaque->imagem_capa
                ? asset('storage/' . $noticiaDestaque->imagem_capa)
                : asset('img/Assaí.jpg');
                @endphp

                {{-- Mobile/Tablet: 4 cards iguais de notícias --}}
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 lg:hidden">
                    @foreach($noticiasMobile as $noticia)
                    @php
                    $imagemMobile = $noticia->imagem_capa
                    ? asset('storage/' . $noticia->imagem_capa)
                    : asset('img/Assaí.jpg');
                    @endphp
                    <a href="{{ route('noticias.show', $noticia->slug) }}" class="group bg-white border border-slate-200 shadow-sm overflow-hidden flex flex-col">
                        <div class="relative overflow-hidden">
                            <img src="{{ $imagemMobile }}" alt="{{ $noticia->titulo }}" class="w-full h-44 object-cover transition-transform duration-500 group-hover:scale-[1.03]" loading="lazy" decoding="async">
                            <div class="absolute inset-0 bg-gradient-to-t from-slate-900/60 via-transparent to-transparent"></div>
                        </div>
                        <div class="p-4">
                            <h3 class="text-base font-extrabold text-slate-800 leading-tight font-heading line-clamp-3 group-hover:text-blue-700 transition-colors duration-200">
                                {{ $noticia->titulo }}
                            </h3>
                            <p class="mt-2 text-xs text-slate-500 font-medium">
                                {{ $noticia->data_publicacao ? \Carbon\Carbon::parse($noticia->data_publicacao)->format('d/m/Y H:i') : '--/--/---- --:--' }}
                            </p>
                        </div>
                    </a>
                    @endforeach
                </div>

                <div class="hidden lg:grid lg:grid-cols-12 gap-5 md:gap-6">

                    {{-- Notícia Destaque Principal --}}
                    <article class="lg:col-span-8 bg-white border border-slate-200 shadow-sm hover:shadow-md transition-shadow duration-300 overflow-hidden">
                        <a href="{{ route('noticias.show', $noticiaDestaque->slug) }}" class="group flex flex-col h-full">
                            {{-- Texto em cima --}}
                            <div class="p-5 md:p-8 flex flex-col flex-1 justify-center">
                                <h2 class="text-2xl md:text-3xl lg:text-4xl font-extrabold text-slate-800 leading-tight font-heading group-hover:text-blue-700 transition-colors duration-200">
                                    {{ $noticiaDestaque->titulo }}
                                </h2>
                                <p class="mt-3 text-xs md:text-sm text-slate-500 font-medium flex items-center gap-1.5">
                                    <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                    </svg>
                                    Data de publicação: {{ $noticiaDestaque->data_publicacao ? \Carbon\Carbon::parse($noticiaDestaque->data_publicacao)->format('d/m/Y H:i') : '--/--/---- --:--' }}
                                </p>
                            </div>

                            {{-- Imagem abaixo --}}
                            <div class="overflow-hidden border-t border-slate-100 relative">
                                <img src="{{ $imagemDestaque }}" alt="{{ $noticiaDestaque->titulo }}" class="w-full h-[240px] sm:h-[320px] md:h-[400px] object-cover transition-transform duration-500 group-hover:scale-[1.03]" loading="lazy" decoding="async">
                                {{-- Badge de Categoria opcional --}}
                                @if($noticiaDestaque->categoria)
                                <span class="absolute top-4 left-4 bg-blue-600 text-white text-xs font-bold px-3 py-1 rounded-full shadow-md uppercase tracking-wider">
                                    {{ $noticiaDestaque->categoria }}
                                </span>
                                @endif
                            </div>
                        </a>
                    </article>

                    {{-- Lista de Notícias Recentes --}}
                    <aside class="lg:col-span-4 bg-white border border-slate-200 shadow-sm flex flex-col h-full">
                        <div class="flex items-center justify-between px-4 md:px-5 pt-4 md:pt-5 mb-4 border-b border-slate-100 pb-3">
                            <h3 class="text-xl md:text-2xl font-extrabold text-slate-700 font-heading">Recentes</h3>
                            <a href="{{ route('noticias.index') }}" class="text-sm font-bold text-blue-600 hover:text-blue-800 hover:underline transition-all">Ver Todas</a>
                        </div>

                        {{-- Grid Responsivo: 1 coluna no mobile, 2 no tablet (sm), 1 no desktop lateral (lg) --}}
                        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-1 gap-4 flex-1 lg:auto-rows-fr px-4 md:px-5">
                            @forelse($noticiasRecentes as $noticia)
                            @php
                            $imagemRecente = $noticia->imagem_capa
                            ? asset('storage/' . $noticia->imagem_capa)
                            : asset('img/Assaí.jpg');
                            @endphp
                            <a href="{{ route('noticias.show', $noticia->slug) }}" class="group relative block overflow-hidden border border-slate-200 shadow-sm h-full">
                                <img src="{{ $imagemRecente }}" alt="{{ $noticia->titulo }}" class="w-full h-32 md:h-36 lg:h-32 object-cover transition-transform duration-500 group-hover:scale-[1.05]" loading="lazy" decoding="async">
                                {{-- Gradiente escuro para garantir leitura do texto --}}
                                <div class="absolute inset-0 bg-gradient-to-t from-slate-900/90 via-slate-900/40 to-transparent transition-opacity duration-300 group-hover:from-blue-900/90"></div>
                                <div class="absolute inset-x-0 bottom-0 p-3">
                                    <p class="text-white text-xs sm:text-sm leading-snug font-semibold line-clamp-2 drop-shadow-md">
                                        {{ $noticia->titulo }}
                                    </p>
                                </div>
                            </a>
                            @empty
                            <div class="col-span-full border border-dashed border-slate-300 p-6 text-center text-sm font-medium text-slate-500 bg-slate-50">
                                Nenhuma notícia recente disponível no momento.
                            </div>
                            @endforelse
                        </div>
                    </aside>
                </div>
                @else
                <div class="border-2 border-dashed border-slate-300 p-10 text-center bg-white shadow-sm">
                    <svg class="w-12 h-12 text-slate-300 mx-auto mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9.5a2 2 0 00-.586-1.414l-4.5-4.5A2 2 0 0015.5 3H15m3 12h-3m3 4h-3"></path>
                    </svg>
                    <p class="text-lg font-semibold text-slate-500">Nenhuma notícia publicada ainda.</p>
                </div>
                @endif
            </div>
        </section>
    </main>
</body>

</html>