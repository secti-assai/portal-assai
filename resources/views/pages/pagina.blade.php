<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Novo Portal - Prefeitura de Assaí</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;600;700;800;900&family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    @vite(['resources/css/app.css', 'resources/js/app.js', 'resources/css/home.css', 'resources/js/home.js'])
</head>

<body class="bg-slate-50 antialiased text-slate-800">

    @include('layouts.navbar')

    <main>
        <section id="home-hero" class="relative w-full overflow-hidden flex flex-col bg-slate-900">

            {{-- ÁREA DA BARRA DE PESQUISA (Otimizada para Mobile, Tablet e Desktop) --}}
            <div class="relative w-full bg-slate-50 border-b border-slate-200 z-40 py-3 md:py-6 px-5 lg:px-8 shadow-sm">
                <div class="container mx-auto flex flex-col md:flex-row items-center justify-between gap-4 md:gap-8">

                    <div class="hidden md:block w-1/3">
                        <h2 class="text-blue-950 font-bold font-heading text-base lg:text-lg leading-tight">Acesso Rápido</h2>
                        <p class="text-slate-500 text-xs lg:text-sm">Serviços, leis e informações.</p>
                    </div>

                    {{-- Container da Busca: Aumentado em MD (Tablets) --}}
                    <div class="w-full md:w-2/3 lg:w-3/5 transition-transform duration-300 focus-within:scale-[1.01]">
                        <form action="{{ route('busca.index') }}" method="GET" class="relative flex items-center w-full bg-white focus-within:ring-4 ring-yellow-400/30 rounded-xl border border-slate-300 focus-within:border-yellow-400 transition-all duration-300 p-1 md:p-1.5 shadow-sm">

                            <div class="pl-3 pr-2 text-slate-400 focus-within:text-blue-700 hidden sm:block transition-colors">
                                <svg class="w-4 h-4 md:w-5 md:h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                                </svg>
                            </div>

                            <label for="input-busca" class="sr-only">Buscar no portal</label>

                            {{-- Input: text-base em tablets para evitar zoom automático do iOS e melhorar leitura --}}
                            <input id="input-busca"
                                type="text"
                                name="q"
                                placeholder="O que procura? Ex: IPTU, Alvará..."
                                autocomplete="off"
                                class="flex-1 min-w-0 px-3 py-2 sm:py-2.5 md:py-3.5 text-sm md:text-base text-slate-700 focus-within:text-slate-900 bg-transparent border-none focus:outline-none focus:ring-0 font-sans placeholder:text-slate-400 rounded-lg">

                            {{-- Botão: Altura aumentada proporcionalmente ao input em MD --}}
                            <button type="submit" class="px-5 py-2 sm:px-8 sm:py-2.5 md:py-3.5 text-xs sm:text-sm md:text-base font-bold text-slate-900 transition-all bg-yellow-400 rounded-lg shrink-0 hover:bg-yellow-300 focus-visible:ring-2 focus-visible:ring-offset-2 focus-visible:ring-blue-900 font-heading flex items-center gap-2 shadow-sm">
                                <span class="hidden sm:inline">Pesquisar</span>
                                <svg class="w-4 h-4 sm:hidden" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                                </svg>
                            </button>
                        </form>
                    </div>

                    <div class="hidden lg:flex w-1/4 justify-end gap-2 flex-wrap">
                        <span class="px-4 py-2 text-[12px] font-bold text-slate-600 bg-white border border-slate-200 shadow-sm rounded-md whitespace-nowrap cursor-default hover:bg-slate-50 transition-colors">IPTU</span>
                        <span class="px-4 py-2 text-[12px] font-bold text-slate-600 bg-white border border-slate-200 shadow-sm rounded-md whitespace-nowrap cursor-default hover:bg-slate-50 transition-colors">Diário Oficial</span>
                    </div>

                </div>
            </div>

            {{-- ÁREA DO CARROSSEL --}}
            <div class="relative flex-1 w-full min-h-[500px] lg:min-h-[600px]">
                <div class="absolute inset-0 z-0 w-full h-full swiper swiper-banners">
                    <div class="swiper-wrapper">
                        @if(isset($banners) && $banners->count() > 0)
                        @foreach($banners as $index => $banner)
                        {{-- Container do Slide Otimizado --}}
                        <div class="relative w-full h-full swiper-slide overflow-hidden bg-slate-900">
                            @php
                            $bannerImage = $banner->imagem
                            ? (Str::startsWith($banner->imagem, ['http', 'img/', 'storage/']) ? asset($banner->imagem) : asset('storage/' . $banner->imagem))
                            : asset('img/Assaí.jpg');
                            @endphp

                            {{-- Imagem com tratamento para evitar "clipping" bizarro --}}
                            <img src="{{ $bannerImage }}"
                                alt="{{ $banner->titulo }}"
                                class="absolute inset-0 object-cover object-center w-full h-full transform scale-105"
                                fetchpriority="high">

                            {{-- MÁSCARA TÉCNICA: Gradiente duplo para garantir leitura em fotos claras ou complexas --}}
                            {{-- 1. Gradiente lateral (Esquerda p/ Direita) --}}
                            <div class="absolute inset-0 bg-gradient-to-r from-slate-950/90 via-slate-950/40 to-transparent z-10"></div>
                            {{-- 2. Gradiente inferior (Mobile push) --}}
                            <div class="absolute inset-0 bg-gradient-to-t from-slate-950/80 via-transparent to-transparent z-10 md:hidden"></div>

                            <div class="absolute inset-0 z-20 flex flex-col justify-center container mx-auto px-6 md:px-12 lg:px-20 pointer-events-none">
                                <div class="max-w-4xl w-full pointer-events-auto text-left">

                                    {{-- Badge de Categoria --}}
                                    <span class="inline-flex items-center py-1 px-3 rounded-md bg-yellow-400 text-slate-950 text-[10px] md:text-xs font-black uppercase tracking-tighter mb-4 shadow-sm">
                                        Destaque
                                    </span>

                                    {{-- Título: Escalonamento agressivo e leading corrigido --}}
                                    <h1 class="text-3xl sm:text-4xl md:text-5xl lg:text-6xl font-black text-white leading-[1.1] mb-4 tracking-tight drop-shadow-sm uppercase">
                                        {{ $banner->titulo }}
                                    </h1>

                                    {{-- Descrição: Limitada para não poluir a imagem --}}
                                    @if($banner->subtitulo)
                                    <p class="text-sm md:text-lg lg:text-xl text-slate-200 font-medium leading-relaxed max-w-2xl mb-8 drop-shadow-sm line-clamp-3 md:line-clamp-none">
                                        {{ $banner->subtitulo }}
                                    </p>
                                    @endif

                                    {{-- CTA Principal --}}
                                    @if($banner->link)
                                    <div class="flex flex-wrap gap-4">
                                        <a href="{{ $banner->link }}" class="inline-flex justify-center items-center px-8 py-3.5 bg-yellow-400 text-slate-900 font-bold rounded-lg hover:bg-yellow-300 focus:ring-4 focus:ring-yellow-400/50 transition-all shadow-xl hover:-translate-y-0.5 group">
                                            <span class="text-sm md:text-base">Saiba mais</span>
                                            <svg class="w-5 h-5 ml-2 transition-transform group-hover:translate-x-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M14 5l7 7m0 0l-7 7m7-7H3"></path>
                                            </svg>
                                        </a>
                                    </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                        @endforeach
                        @endif
                    </div>

                    {{-- Controles do Swiper Otimizados --}}
                    @if(isset($banners) && $banners->count() > 1)
                    <button type="button" aria-label="Slide anterior" class="banner-prev absolute left-4 lg:left-8 top-1/2 -translate-y-1/2 z-30 w-12 h-12 items-center justify-center rounded-full bg-slate-900/60 border border-white/20 text-white hover:bg-white hover:text-slate-900 focus:outline-none focus-visible:ring-2 focus-visible:ring-yellow-400 transition-all hidden md:flex backdrop-blur-sm group">
                        <svg class="w-6 h-6 transition-transform group-hover:-translate-x-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M15 19l-7-7 7-7"></path>
                        </svg>
                    </button>
                    <button type="button" aria-label="Próximo slide" class="banner-next absolute right-4 lg:right-8 top-1/2 -translate-y-1/2 z-30 w-12 h-12 items-center justify-center rounded-full bg-slate-900/60 border border-white/20 text-white hover:bg-white hover:text-slate-900 focus:outline-none focus-visible:ring-2 focus-visible:ring-yellow-400 transition-all hidden md:flex backdrop-blur-sm group">
                        <svg class="w-6 h-6 transition-transform group-hover:translate-x-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 5l7 7-7 7"></path>
                        </svg>
                    </button>
                    @endif

                    <div class="swiper-pagination !bottom-6 !z-[50]"></div>
                </div>
            </div>

        </section>

        <div style="height: 100vh;"></div>
    </main>

</body>

</html>