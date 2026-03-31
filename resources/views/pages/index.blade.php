@extends('layouts.app')

@section('content')
<main id="conteudo-principal" accesskey="1" tabindex="-1" class="flex flex-col min-h-screen bg-gray-50">

    <section id="home-hero" class="relative w-full bg-blue-900 overflow-hidden">

        <div class="w-full h-full overflow-hidden swiper swiper-banners">
            <div class="swiper-wrapper">

                @forelse($banners as $banner)
                <div class="relative w-full h-full swiper-slide">
                    @php
                    $bannerImage = $banner->imagem
                    ? (\Illuminate\Support\Str::startsWith($banner->imagem, ['http://', 'https://'])
                    ? $banner->imagem
                    : (\Illuminate\Support\Str::startsWith($banner->imagem, 'img/')
                    ? asset($banner->imagem)
                    : asset('storage/' . $banner->imagem)))
                    : asset('img/Assaí.jpg');
                    @endphp
                    <img src="{{ $bannerImage }}" alt="{{ $banner->titulo }}" class="absolute inset-0 object-cover w-full h-full"
                        @if($loop->first) fetchpriority="high" loading="eager" decoding="async" @else loading="lazy" decoding="async" @endif>
                    <div class="absolute inset-0 mix-blend-multiply bg-blue-900/70"></div>

                    <div class="absolute inset-0 flex flex-col items-center justify-center px-4 text-center z-10 pb-64 sm:pb-52 md:pb-[240px]">

                        <h1 class="w-full max-w-4xl mb-2 text-xl max-[360px]:text-lg font-extrabold text-white break-words drop-shadow-lg sm:text-3xl md:text-5xl font-heading leading-tight">
                            {{ $banner->titulo }}
                        </h1>

                        @if($banner->subtitulo)
                        <p class="w-full max-w-2xl mb-4 text-sm font-medium text-blue-100 break-words drop-shadow sm:text-base md:text-lg font-sans max-[360px]:hidden">
                            {{ $banner->subtitulo }}
                        </p>
                        @endif

                        @if($banner->link)
                        <a href="{{ $banner->link }}" class="inline-block px-6 py-2.5 mt-2 text-sm font-bold text-blue-900 transition bg-yellow-400 rounded-full hover:bg-yellow-500 hover:-translate-y-1 shadow-lg font-heading md:text-base">
                            Saiba mais
                        </a>
                        @endif
                    </div>
                </div>
                @empty
                <div class="relative w-full h-full swiper-slide">
                    <img src="{{ asset('img/Assaí.jpg') }}" alt="Prefeitura de Assaí" class="absolute inset-0 object-cover w-full h-full"
                        fetchpriority="high" loading="eager" decoding="async">

                    <div class="absolute inset-0 mix-blend-multiply bg-blue-900/70"></div>

                    <div class="absolute inset-0 flex flex-col items-center justify-center px-4 text-center z-10 pb-52 sm:pb-40 md:pb-[160px]">
                        <h1 class="mb-3 text-3xl font-extrabold text-white drop-shadow-md md:text-5xl font-heading leading-tight">
                            Bem-vindo ao Portal da<br>Prefeitura de Assaí
                        </h1>
                    </div>
                </div>
                @endforelse

            </div>

            @if($banners->count() > 1)
            <button type="button" aria-label="Próximo banner" class="banner-swiper-next absolute right-6 top-1/2 -translate-y-1/2 hidden md:flex items-center justify-center w-11 h-11 rounded-full bg-black/35 text-white hover:bg-black/55 transition-all z-30 shadow-lg backdrop-blur-sm">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 5l7 7-7 7" />
                </svg>
            </button>
            <button type="button" aria-label="Banner anterior" class="banner-swiper-prev absolute left-6 top-1/2 -translate-y-1/2 hidden md:flex items-center justify-center w-11 h-11 rounded-full bg-black/35 text-white hover:bg-black/55 transition-all z-30 shadow-lg backdrop-blur-sm">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M15 19l-7-7 7-7" />
                </svg>
            </button>
            <div class="swiper-pagination !bottom-4 !z-30"></div>
            @endif
        </div>

        <div class="absolute bottom-36 sm:bottom-28 md:bottom-[120px] left-0 right-0 z-40 flex flex-col items-center justify-center w-full px-4 md:px-4 pointer-events-none">

            {{-- Wrapper com efeito scale ao focar --}}
            <div class="w-full max-w-3xl pointer-events-auto transition-all duration-300 focus-within:scale-[1.02]">
                <form
                    id="form-busca"
                    action="{{ route('busca.index') }}"
                    method="GET"
                    data-autocomplete-url="{{ route('busca.autocomplete') }}"
                    class="relative flex items-center w-full bg-white/95 focus-within:bg-white backdrop-blur-md shadow-2xl rounded-full border border-white/60 transition-all duration-300">
                    {{-- Ícone de Busca --}}
                    <svg class="absolute left-4 w-5 h-5 text-slate-400 shrink-0 hidden md:block pointer-events-none" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                    </svg>

                    {{-- Input --}}
                    <input
                        id="input-busca"
                        type="text"
                        name="q"
                        accesskey="3"
                        placeholder="Buscar serviços ou notícias..."
                        autocomplete="off"
                        aria-label="Campo de busca do portal [3]"
                        class="flex-1 min-w-0 px-4 py-3.5 text-sm text-gray-800 bg-transparent border-none md:pl-12 md:py-4 md:text-base focus:outline-none font-sans placeholder:text-slate-400">

                    {{-- Botão Limpar (Clear) - visível apenas ao digitar --}}
                    <button
                        type="button"
                        id="btn-limpar-busca"
                        aria-label="Limpar campo de busca"
                        class="hidden mr-1 p-1.5 text-slate-400 hover:text-slate-700 transition-colors rounded-full hover:bg-slate-100 shrink-0">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>

                    {{-- Botão Pesquisar --}}
                    <button type="submit" aria-label="Pesquisar" class="m-1.5 px-3.5 max-[360px]:px-3 py-2.5 max-[360px]:py-2 font-bold text-sm text-white transition-all bg-blue-600 rounded-full shrink-0 md:px-6 md:py-3 hover:bg-blue-700 hover:shadow-lg font-heading">
                        Buscar
                    </button>

                    {{-- Dropdown de Autocomplete --}}
                    <div id="autocomplete-results"
                        class="absolute left-0 right-0 top-full mt-2 bg-white border border-slate-100 rounded-2xl shadow-2xl overflow-hidden z-[70] hidden opacity-0 transition-opacity duration-200">
                    </div>
                </form>
            </div>

            {{-- Chips de Sugestão --}}
            <div id="ia-suggestions" class="flex flex-wrap items-center justify-center gap-x-2.5 gap-y-2 sm:gap-x-3 sm:gap-y-2.5 mt-4 sm:mt-4 md:mt-5 pointer-events-auto max-w-xs sm:max-w-2xl lg:max-w-4xl px-2 sm:px-4">
                @forelse($sugestoesIA as $sugestao)
                <button
                    type="button"
                    role="button"
                    tabindex="0"
                    aria-label="Sugestão de busca: {{ $sugestao }}"
                    onclick="preencherBusca('{{ addslashes($sugestao) }}')"
                    onkeydown="if(event.key==='Enter'||event.key===' ')preencherBusca('{{ addslashes($sugestao) }}')"
                    class="inline-flex items-center gap-1.5 px-3 py-1.5 text-[11px] sm:text-xs font-semibold text-white cursor-pointer select-none transition-all duration-200 bg-white/10 border border-white/25 backdrop-blur-sm rounded-full hover:bg-blue-600 hover:text-white hover:border-transparent hover:shadow-md active:scale-95 focus:outline-none focus:ring-2 focus:ring-white/60 font-sans whitespace-nowrap">
                    <svg class="w-3 h-3 opacity-70" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                    </svg>
                    {{ $sugestao }}
                </button>
                @empty
                <span class="text-xs text-blue-300/60">Pesquise serviços, notícias ou eventos...</span>
                @endforelse
            </div>

        </div>
        {{-- Indicador de Scroll --}}
        <div class="absolute z-30 hidden transform -translate-x-1/2 bottom-4 left-1/2 md:flex">
            <a href="#hub-servicos" class="p-2 text-white transition-all opacity-70 hover:opacity-100 hover:scale-110 animate-bounce" aria-label="Rolar para serviços">
                <svg class="w-8 h-8 drop-shadow-lg" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 14l-7 7m0 0l-7-7m7 7V3"></path>
                </svg>
            </a>
        </div>
    </section>


    {{-- ═══════════════════════════════════════════════
         SEÇÃO DESTAQUES (ex-barra lateral)
    ════════════════════════════════════════════════ --}}
    <section class="container mx-auto px-4 py-8 font-sans">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 items-stretch">
            <article class="sidebar-interactive-card group relative overflow-hidden border border-gray-100 shadow-sm h-full flex flex-col">
                <div class="absolute inset-0 bg-slate-900"></div>
                <div class="absolute inset-0 bg-gradient-to-t from-black/90 via-black/40 to-black/10"></div>
                <div class="sidebar-cover absolute inset-0 z-10 flex flex-col items-center justify-center px-6 py-8 transition-opacity duration-300 h-full">
                    <img src="{{ asset('img/conecta.png') }}" class="w-auto h-14 md:h-20 object-contain mb-4 drop-shadow-lg" alt="Conecta Assaí" loading="lazy" decoding="async">
                    <span class="text-[11px] font-bold tracking-widest uppercase text-green-300 mb-1">Hub de Serviços</span>
                    <h3 class="text-2xl font-extrabold text-white font-heading leading-tight mb-2">Conecta Assaí</h3>
                    <div class="mt-auto w-full flex flex-col items-center">
                        <button type="button" onclick="toggleSidebarCard(this)" class="w-full border border-white/35 py-2 text-[12px] font-bold uppercase tracking-[0.16em] text-white transition hover:border-yellow-500 hover:bg-yellow-500 hover:text-blue-900">Saiba Mais</button>
                    </div>
                </div>
                <div class="sidebar-details-panel absolute inset-0 z-20 bg-white p-4 flex flex-col justify-between">
                    <div>
                        <div class="flex items-start justify-between">
                            <span class="text-[15px] font-bold uppercase tracking-widest text-green-600">Ecossistema Digital</span>
                            <button type="button" onclick="toggleSidebarCard(this)" class="border-2 border-slate-300 px-3 py-1 text-lg font-bold transition hover:bg-slate-900 hover:text-white shadow-sm">—</button>
                        </div>
                        <h3 class="mt-3 text-4xl font-extrabold text-slate-900 font-heading">Conecta Assaí</h3>
                        <p class="mt-3 text-5x leading-relaxed text-slate-600">Portal central de serviços e inscrições online da prefeitura em um só lugar.</p>
                    </div>
                    <a href="https://conecta.assai.pr.gov.br/" target="_blank" class="text-[15px] font-black uppercase tracking-[0.18em] border-b-2 border-green-600 pb-1 self-start text-green-700 hover:text-blue-700 hover:border-blue-700 transition-all">Acessar Plataforma</a>
                </div>
            </article>
            <article class="sidebar-interactive-card group relative overflow-hidden border border-blue-100 shadow-sm h-full flex flex-col">
                <div class="absolute inset-0 bg-blue-900"></div>
                <div class="absolute inset-0 bg-gradient-to-t from-blue-950/95 via-blue-900/60 to-blue-700/20"></div>
                <div class="sidebar-cover absolute inset-0 z-10 flex flex-col items-center justify-center px-6 py-8 transition-opacity duration-300 h-full">
                    <img src="{{ asset('img/gov.assai.png') }}" class="w-auto h-16 md:h-20 object-contain mb-4 drop-shadow-lg" alt="Gov.Assaí" loading="lazy" decoding="async">
                    <span class="text-[11px] font-bold tracking-widest uppercase text-blue-200 mb-1">Cidade Digital</span>
                    <h3 class="text-2xl font-extrabold text-white font-heading leading-tight mb-2">gov.assaí</h3>
                    <div class="mt-auto w-full flex flex-col items-center">
                        <button type="button" onclick="toggleSidebarCard(this)" class="w-full border border-white/35 py-2 text-[12px] font-bold uppercase tracking-[0.16em] text-white transition hover:border-yellow-500 hover:bg-yellow-500 hover:text-blue-900">Saiba Mais</button>
                    </div>
                </div>
                <div class="sidebar-details-panel absolute inset-0 z-20 bg-white p-2 flex flex-col justify-between">
                    <div>
                        <div class="flex items-start justify-between">
                            <span class="text-[15px] font-bold uppercase tracking-widest text-blue-600">Identidade Única</span>
                            <button type="button" onclick="toggleSidebarCard(this)" class="border-2 border-slate-300 px-3 py-1 text-lg font-bold transition hover:bg-slate-900 hover:text-white shadow-sm">—</button>
                        </div>
                        <h3 class="mt-3 text-4xl font-extrabold text-slate-900 font-heading">Gov.Assaí</h3>
                        <p class="mt-3 text-4x leading-relaxed text-slate-600">Acesse sua identidade municipal com login único e acompanhamento online.</p>
                    </div>
                    <a href="https://gov.assai.pr.gov.br/" target="_blank" class="text-[15px] font-black uppercase tracking-[0.18em] border-b-2 border-blue-600 pb-1 self-start text-blue-700 hover:text-green-700 hover:border-green-700 transition-all">Acessar Plataforma</a>
                </div>
            </article>
            <div class="p-2 bg-gray-100 font-sans h-full flex flex-col justify-center">
                <h3 class="mb-4 text-base font-bold text-gray-800 uppercase font-heading">Participação & Transparência</h3>
                <div class="flex flex-col gap-2.5 font-sans">
                    <a href="#" class="flex justify-between p-4 text-base font-medium text-gray-700 transition bg-white shadow-sm hover:text-blue-600">Ouvidoria Municipal <span>></span></a>
                    <a href="https://transparencia.betha.cloud/#/yyGw8hIiYdv6bs-avrzVUg==" class="flex justify-between p-4 text-base font-medium text-gray-700 transition bg-white shadow-sm hover:text-blue-600">Portal da Transparência <span>></span></a>
                    <a href="https://transparencia.betha.cloud/#/yyGw8hIiYdv6bs-avrzVUg==/consulta/95802" class="flex justify-between p-4 text-base font-medium text-gray-700 transition bg-white shadow-sm hover:text-blue-600">Licitações <span>></span></a>
                    <a href="https://www.doemunicipal.com.br/prefeituras/4" class="flex justify-between p-4 text-base font-medium text-gray-700 transition bg-white shadow-sm hover:text-blue-600">Diário Oficial <span>></span></a>
                </div>
            </div>
        </div>
    </section>

    <div class="container relative z-10 flex flex-col gap-14 px-4 py-10 mx-auto -mt-4">
        {{-- ═══════════════════════════════════════════════
                 1. DASHBOARD DE SERVIÇOS (Estilo Plataforma)
            ════════════════════════════════════════════════ --}}
        <div id="hub-servicos" class="flex flex-col scroll-mt-24">

            <div class="flex items-end justify-between mb-6">
                <div>
                    <h2 class="text-2xl font-extrabold text-slate-800 font-heading tracking-tight">Plataforma de Serviços</h2>
                    <p class="text-sm text-slate-500 mt-1">Acesso rápido aos principais atendimentos digitais.</p>
                </div>
                <a href="{{ route('servicos.index') }}" class="hidden sm:flex items-center gap-1.5 px-4 py-2 text-sm font-bold text-blue-700 bg-blue-50 hover:bg-blue-100 transition-colors">
                    Ver todos
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 5l7 7-7 7" />
                    </svg>
                </a>
            </div>

            {{-- Bento Grid de Serviços (Padrão App Tile) --}}
            <div class="grid grid-cols-2 gap-3 sm:gap-4 md:grid-cols-3 lg:grid-cols-4 xl:grid-cols-5 font-sans">


                {{-- Card Fixo: IPTU --}}
                <a href="https://conecta.assai.pr.gov.br/servico/99" target="_blank" rel="noopener noreferrer" class="group relative flex flex-col items-center justify-center p-5 bg-white border border-gray-100 shadow-lg hover:shadow-xl hover:-translate-y-1 transition-all duration-300 min-h-[320px] overflow-hidden text-center">
                    <div class="absolute inset-0 bg-gradient-to-tr from-white/0 via-white/0 to-white/10 opacity-0 group-hover:opacity-100 transition-opacity duration-500 pointer-events-none"></div>

                    <div class="text-blue-600 mb-3 group-hover:scale-110 group-hover:text-blue-800 transition-all duration-300">
                        <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path>
                        </svg>
                    </div>
                    <h3 class="text-base sm:text-lg font-extrabold text-gray-900 font-heading leading-tight px-1">IPTU</h3>
                    <p class="text-xs text-slate-600 mt-1.5 uppercase tracking-wider font-semibold">Guias e Certidões</p>
                </a>


                {{-- Card Fixo: Nota Fiscal --}}
                <a href="https://conecta.assai.pr.gov.br/servico/112" target="_blank" rel="noopener noreferrer" class="group relative flex flex-col items-center justify-center p-5 bg-white border border-gray-100 shadow-lg hover:shadow-xl hover:-translate-y-1 transition-all duration-300 min-h-[320px] overflow-hidden text-center">
                    <div class="absolute inset-0 bg-gradient-to-tr from-white/0 via-white/0 to-white/10 opacity-0 group-hover:opacity-100 transition-opacity duration-500 pointer-events-none"></div>

                    <div class="text-blue-600 mb-3 group-hover:scale-110 group-hover:text-blue-800 transition-all duration-300">
                        <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                        </svg>
                    </div>
                    <h3 class="text-base sm:text-lg font-extrabold text-gray-900 font-heading leading-tight px-1">Nota Fiscal</h3>
                    <p class="text-xs text-slate-600 mt-1.5 uppercase tracking-wider font-semibold">Emissão Eletrônica</p>
                </a>


                {{-- Card Fixo: Protocolo --}}
                <a href="https://conecta.assai.pr.gov.br/servicos/categoria/2" target="_blank" rel="noopener noreferrer" class="group relative flex flex-col items-center justify-center p-5 bg-white border border-gray-100 shadow-lg hover:shadow-xl hover:-translate-y-1 transition-all duration-300 min-h-[320px] overflow-hidden text-center">
                    <div class="absolute inset-0 bg-gradient-to-tr from-white/0 via-white/0 to-white/10 opacity-0 group-hover:opacity-100 transition-opacity duration-500 pointer-events-none"></div>

                    <div class="text-blue-600 mb-3 group-hover:scale-110 group-hover:text-blue-800 transition-all duration-300">
                        <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"></path>
                        </svg>
                    </div>
                    <h3 class="text-base sm:text-lg font-extrabold text-gray-900 font-heading leading-tight px-1">Protocolo</h3>
                    <p class="text-xs text-slate-600 mt-1.5 uppercase tracking-wider font-semibold">Abertura e Consulta</p>
                </a>

                {{-- Cards Dinâmicos: Mais Acessados --}}
                @forelse($servicos as $servico)
                <a href="{{ $servico->url_acesso ?? $servico->link ?? '#' }}" target="_blank" rel="noopener noreferrer" class="group relative flex flex-col items-center justify-center p-5 bg-white border border-gray-100 shadow-lg hover:shadow-xl hover:-translate-y-1 transition-all duration-300 min-h-[320px] overflow-hidden text-center">
                    <div class="absolute inset-0 bg-gradient-to-tr from-white/0 via-white/0 to-white/10 opacity-0 group-hover:opacity-100 transition-opacity duration-500 pointer-events-none"></div>

                    <div class="text-blue-600 mb-3 group-hover:scale-110 group-hover:text-blue-800 transition-all duration-300 shrink-0">
                        <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            @switch($servico->icone)
                            @case('saude')
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path>
                            @break
                            @case('vagas')
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                            @break
                            @case('ouvidoria')
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M11 5.882V19.24a1.76 1.76 0 01-3.417.592l-2.147-6.15M18 13a3 3 0 100-6M5.436 13.683A4.001 4.001 0 017 6h1.832c4.1 0 7.625-1.234 9.168-3v14c-1.543-1.766-5.067-3-9.168-3H7a3.988 3.988 0 01-1.564-.317z"></path>
                            @break
                            @case('educacao')
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 14l9-5-9-5-9 5 9 5z"></path>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 14l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0012 20.055a11.952 11.952 0 00-6.824-2.998 12.078 12.078 0 01.665-6.479L12 14z"></path>
                            @break
                            @default
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M15 15l-2 5L9 9l11 4-5 2zm0 0l5 5M7.188 2.239l.777 2.897M5.136 7.965l-2.898-.777M13.95 4.05l-2.122 2.122m-5.657 5.656l-2.12 2.122"></path>
                            @endswitch
                        </svg>
                    </div>

                    {{-- Título (limitado a 1 ou 2 linhas para dar espaço à descrição) --}}
                    <h3 class="text-base sm:text-lg font-extrabold text-gray-900 font-heading leading-tight px-1 line-clamp-2" title="{{ $servico->titulo }}">
                        {{ $servico->titulo }}
                    </h3>

                    {{-- Descrição Adicionada --}}
                    @if($servico->descricao)
                    <p class="text-sm text-slate-600 mt-2 leading-tight font-medium line-clamp-8 break-words hyphens-auto" title="{{ strip_tags($servico->descricao) }}">
                        {{ \Illuminate\Support\Str::limit(strip_tags($servico->descricao), 350) }}
                    </p>
                    @endif
                </a>
                @empty
                @endforelse
            </div>

            {{-- Botão Mobile para Ver Todos --}}
            <a href="{{ route('servicos.index') }}" class="mt-6 flex sm:hidden justify-center items-center gap-1.5 px-4 py-3 text-sm font-bold text-blue-700 border border-blue-100 bg-white shadow-sm active:bg-blue-50">
                Acessar Carta de Serviços
            </a>

        </div>
        {{-- /DASHBOARD DE SERVIÇOS --}}

        {{-- ═══════════════════════════════════════════════
                 2. ASSAÍ EM AÇÃO
            ════════════════════════════════════════════════ --}}
        <div class="p-8 max-[360px]:p-5 md:p-10 bg-slate-200 border border-slate-300 shadow-inner">
            <div class="flex flex-col items-start mb-10">
                <span class="px-3 py-1 mb-3 text-xs font-bold tracking-wider text-blue-700 uppercase bg-blue-100">Acontecendo Agora</span>
                <h2 class="text-3xl font-extrabold text-slate-800 font-heading">Assaí em Ação</h2>
                <p class="mt-2 text-slate-500 max-w-2xl">Acompanhe os principais programas, obras e iniciativas que estão transformando a nossa cidade todos os dias.</p>
            </div>

            <div class="grid grid-cols-1 gap-6 md:grid-cols-2 lg:grid-cols-3">

                @if(isset($inscricoesAbertas) && count($inscricoesAbertas) > 0)
                @foreach($inscricoesAbertas as $inscricao)
                <a href="https://conecta.assai.pr.gov.br/editais/{{ $inscricao['slug'] ?? $inscricao['id'] }}" target="_blank" class="relative flex flex-col p-6 max-[360px]:p-5 overflow-hidden transition bg-blue-50 border shadow-sm border-blue-200 hover:shadow-xl hover:-translate-y-1 group hover:border-blue-400">

                    <div class="absolute top-0 right-0 px-3 py-1 text-[10px] font-bold text-white bg-green-500 flex items-center gap-1">
                        <div class="w-1.5 h-1.5 bg-white rounded-full animate-pulse"></div>
                        INSCRIÇÕES ABERTAS
                    </div>

                    <div class="flex items-center justify-center w-14 h-14 mb-6 text-blue-600 bg-white shadow-sm group-hover:scale-110 transition-transform overflow-hidden">
                        <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                        </svg>
                    </div>

                    <h3 class="mb-2 text-xl font-bold text-slate-800 font-heading line-clamp-2 break-words">{{ \Illuminate\Support\Str::limit($inscricao['title'] ?? $inscricao['titulo'], 95) }}</h3>
                    <p class="text-sm text-slate-600 mb-6 flex-1 line-clamp-3 break-words">{{ \Illuminate\Support\Str::limit(strip_tags((string) ($inscricao['description'] ?? $inscricao['descricao'])), 150) }}</p>

                    <span class="flex items-center gap-1 text-sm font-bold text-blue-600 group-hover:text-blue-800">Inscreva-se &rarr;</span>
                </a>
                @endforeach
                @endif

                @forelse($programas as $programa)
                <a href="{{ route('programas.show', $programa) }}" class="relative flex flex-col overflow-hidden transition bg-white border shadow-sm border-slate-200 hover:shadow-xl hover:-translate-y-1 group hover:border-blue-300">

                    @if($programa->icone)
                    {{-- Layout com Imagem de Capa (Edge-to-Edge) --}}
                    <div class="relative overflow-hidden h-48 bg-gray-200 shrink-0">
                        <img src="{{ asset('storage/' . $programa->icone) }}" alt="{{ $programa->titulo }}" class="object-cover w-full h-full transition duration-500 group-hover:scale-105" loading="lazy" decoding="async">
                    </div>
                    <div class="flex flex-col flex-1 p-6 max-[360px]:p-5">
                        <h3 class="mb-2 text-xl font-bold text-slate-800 font-heading line-clamp-2 break-words" title="{{ $programa->titulo }}">{{ \Illuminate\Support\Str::limit($programa->titulo, 95) }}</h3>
                        <p class="text-sm text-slate-500 mb-6 flex-1 line-clamp-3 break-words">{{ \Illuminate\Support\Str::limit(strip_tags((string) $programa->descricao), 150) }}</p>
                        <span class="flex items-center gap-1 text-sm font-bold text-blue-600 group-hover:text-blue-700 mt-auto">Saiba mais &rarr;</span>
                    </div>
                    @else
                    {{-- Layout com Ícone Vetorial (Fallback) --}}
                    <div class="flex flex-col flex-1 p-6 max-[360px]:p-5">
                        <div class="flex items-center justify-center w-14 h-14 mb-6 text-blue-600 bg-blue-50 group-hover:scale-110 transition-transform overflow-hidden shrink-0">
                            <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                            </svg>
                        </div>
                        <h3 class="mb-2 text-xl font-bold text-slate-800 font-heading line-clamp-2 break-words" title="{{ $programa->titulo }}">{{ \Illuminate\Support\Str::limit($programa->titulo, 95) }}</h3>
                        <p class="text-sm text-slate-500 mb-6 flex-1 line-clamp-3 break-words">{{ \Illuminate\Support\Str::limit(strip_tags((string) $programa->descricao), 150) }}</p>
                        <span class="flex items-center gap-1 text-sm font-bold text-blue-600 group-hover:text-blue-700 mt-auto">Saiba mais &rarr;</span>
                    </div>
                    @endif
                </a>
                @empty
                @if(empty($inscricoesAbertas))
                <div class="col-span-full text-center py-8 text-slate-500">
                    Nenhum programa em destaque no momento.
                </div>
                @endif
                @endforelse

            </div>

            <div class="flex justify-center mt-10">
                <a href="{{ route('programas.index') }}" class="inline-flex items-center gap-2 px-6 py-3 text-sm font-bold text-blue-700 bg-white border border-blue-200 hover:bg-blue-50 hover:border-blue-300 transition-all shadow-sm group">
                    Ver todos os programas
                    <svg class="w-4 h-4 text-blue-500 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3" />
                    </svg>
                </a>
            </div>
        </div>
        {{-- /ASSAÍ EM AÇÃO --}}

        {{-- ═══════════════════════════════════════════════
                 3. NOTÍCIAS (Estilo Mosaico: 1 Destaque + Lista Lateral)
            ════════════════════════════════════════════════ --}}
        <div>
            <div class="flex items-center justify-between mb-7">
                <div>
                    <h2 class="text-2xl font-extrabold text-gray-800 font-heading">Notícias</h2>
                    <p class="text-sm text-slate-400 mt-0.5">As últimas da Prefeitura de Assaí</p>
                </div>
                <a href="{{ route('noticias.index') }}" class="inline-flex items-center gap-1 text-sm font-bold text-blue-600 transition hover:text-blue-800">
                    Ver todas
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                    </svg>
                </a>
            </div>

            @if($noticias->count() > 0)
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

                {{-- DESTAQUE (Lado Esquerdo - Ocupa 2 colunas em telas grandes) --}}
                <div class="lg:col-span-2">
                    @php $noticiaDestaque = $noticias->first(); @endphp
                    <a href="{{ route('noticias.show', $noticiaDestaque->slug) }}" class="group relative flex flex-col justify-end overflow-hidden shadow-sm hover:shadow-xl transition-all duration-300 h-[400px] lg:h-full min-h-[400px]">
                        <div class="absolute inset-0 bg-slate-900">
                            @if($noticiaDestaque->imagem_capa)
                            <img src="{{ asset('storage/' . $noticiaDestaque->imagem_capa) }}" alt="{{ $noticiaDestaque->titulo }}" class="object-cover w-full h-full transition-transform duration-700 group-hover:scale-105 opacity-90" loading="lazy" decoding="async">
                            @else
                            <img src="{{ asset('img/Assaí.jpg') }}" alt="Prefeitura de Assaí" class="object-cover w-full h-full transition-transform duration-700 group-hover:scale-105 opacity-80" loading="lazy" decoding="async">
                            @endif
                        </div>

                        {{-- Gradiente escuro --}}
                        <div class="absolute inset-0 bg-gradient-to-t from-black/95 via-black/40 to-transparent pointer-events-none"></div>

                        <div class="relative z-20 p-6 md:p-8">
                            <div class="flex items-center gap-3 mb-4">
                                <span class="px-3 py-1 text-[10px] font-extrabold tracking-wider text-blue-900 uppercase bg-yellow-400 shadow-sm">
                                    {{ $noticiaDestaque->categoria ?? 'Geral' }}
                                </span>
                                <span class="flex items-center gap-1.5 text-xs font-bold tracking-wide text-gray-300 uppercase">
                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                    </svg>
                                    {{ \Carbon\Carbon::parse($noticiaDestaque->data_publicacao)->format('d/m/Y') }}
                                </span>
                            </div>
                            <h3 class="mb-3 text-2xl sm:text-3xl font-extrabold leading-tight text-white transition font-heading group-hover:text-yellow-400 line-clamp-3">
                                {{ $noticiaDestaque->titulo }}
                            </h3>
                            <p class="text-sm text-gray-300 line-clamp-2 md:w-5/6">
                                {{ $noticiaDestaque->resumo ?? Str::limit(strip_tags($noticiaDestaque->conteudo), 120) }}
                            </p>
                        </div>
                    </a>
                </div>

                {{-- LISTA LATERAL (Lado Direito - Ocupa 1 coluna com 3 itens empilhados) --}}
                <div class="flex flex-col gap-4">
                    @foreach($noticias->skip(1)->take(3) as $noticia)
                    <a href="{{ route('noticias.show', $noticia->slug) }}" class="group flex gap-4 bg-white border border-gray-100 p-3 shadow-sm hover:shadow-md hover:border-blue-200 transition-all duration-300">

                        {{-- Imagem Miniatura --}}
                        <div class="relative w-28 h-28 sm:w-32 sm:h-32 shrink-0 overflow-hidden bg-gray-200">
                            @if($noticia->imagem_capa)
                            <img src="{{ asset('storage/' . $noticia->imagem_capa) }}" alt="{{ $noticia->titulo }}" class="object-cover w-full h-full transition-transform duration-500 group-hover:scale-110" loading="lazy" decoding="async">
                            @else
                            <img src="{{ asset('img/Assaí.jpg') }}" alt="Prefeitura" class="object-cover w-full h-full opacity-80 transition-transform duration-500 group-hover:scale-110" loading="lazy" decoding="async">
                            @endif
                        </div>

                        {{-- Conteúdo --}}
                        <div class="flex flex-col flex-1 py-1 pr-2">
                            <div class="inline-flex items-center gap-1.5 mb-1.5 text-[10px] font-bold tracking-wider text-blue-600 uppercase">
                                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                </svg>
                                {{ \Carbon\Carbon::parse($noticia->data_publicacao)->format('d/m/Y') }}
                            </div>
                            <h3 class="text-sm font-bold leading-snug text-gray-900 font-heading group-hover:text-blue-600 transition-colors line-clamp-3">
                                {{ $noticia->titulo }}
                            </h3>
                            <span class="mt-auto text-[11px] font-bold text-slate-400 group-hover:text-blue-500 transition-colors flex items-center gap-1">
                                Ler mais <span class="text-lg leading-none">&rsaquo;</span>
                            </span>
                        </div>
                    </a>
                    @endforeach
                </div>
            </div>
            @else
            <div class="p-8 text-center border border-gray-300 border-dashed bg-gray-50">
                <p class="font-medium text-gray-500">Nenhuma notícia publicada no momento.</p>
            </div>
            @endif
        </div>
        {{-- /NOTÍCIAS --}}

        {{-- ═══════════════════════════════════════════════
                 4. AGENDA DA CIDADE (Estilo Mosaico)
            ════════════════════════════════════════════════ --}}
        <div class="p-8 md:p-12 bg-blue-950 shadow-xl relative overflow-hidden mt-6">
            <div class="flex flex-col items-start justify-between mb-8 md:flex-row md:items-end">
                <div>
                    <h2 class="text-3xl font-extrabold text-white font-heading">Agenda da Cidade</h2>
                    <p class="mt-2 text-blue-200">Próximos eventos, feiras e inaugurações em Assaí.</p>
                </div>
            </div>

            @if($eventos->count() > 0)
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

                {{-- EVENTO DESTAQUE (Lado Esquerdo) --}}
                <div class="lg:col-span-2">
                    @php $eventoDestaque = $eventos->first(); @endphp
                    <a href="{{ route('agenda.show', $eventoDestaque->id) }}" class="group relative flex flex-col justify-end overflow-hidden shadow-sm hover:shadow-xl transition-all duration-300 h-[400px] lg:h-full min-h-[400px] {{ $eventoDestaque->status === 'cancelado' ? 'opacity-75' : '' }}">
                        <div class="absolute inset-0 bg-blue-900">
                            @if($eventoDestaque->imagem)
                            <img src="{{ asset('storage/' . $eventoDestaque->imagem) }}" alt="{{ $eventoDestaque->titulo }}" class="object-cover w-full h-full transition duration-700 group-hover:scale-105 opacity-80" loading="lazy" decoding="async">
                            @else
                            <div class="absolute inset-0 flex items-center justify-center bg-blue-950/80">
                                <svg class="w-32 h-32 text-blue-500/20" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                </svg>
                            </div>
                            @endif
                        </div>

                        <div class="absolute inset-0 bg-gradient-to-t from-blue-950/95 via-blue-900/40 to-transparent pointer-events-none"></div>

                        @if($eventoDestaque->status === 'cancelado')
                        <span class="absolute z-20 top-6 left-6 px-3 py-1.5 text-[10px] font-bold text-white bg-red-600 shadow">CANCELADO</span>
                        @endif

                        {{-- Bloco de Data Flutuante --}}
                        <div class="absolute z-20 top-6 right-6 flex flex-col items-center justify-center w-16 h-16 bg-white/10 backdrop-blur-md border border-white/20 text-white shadow-xl">
                            <span class="text-[11px] font-bold tracking-wider uppercase opacity-80">{{ $eventoDestaque->data_inicio->format('M') }}</span>
                            <span class="text-2xl font-extrabold leading-none">{{ $eventoDestaque->data_inicio->format('d') }}</span>
                        </div>

                        <div class="relative z-20 p-6 md:p-8">
                            <div class="flex flex-wrap items-center gap-4 mb-4 text-sm font-bold text-blue-300">
                                <span class="flex items-center gap-1.5">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                    {{ $eventoDestaque->data_inicio->format('H:i') }}
                                </span>
                                <span class="flex items-center gap-1.5 line-clamp-1">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                    </svg>
                                    {{ $eventoDestaque->local ?? 'Assaí, PR' }}
                                </span>
                            </div>
                            <h3 class="mb-3 text-2xl sm:text-3xl font-extrabold leading-tight text-white transition font-heading group-hover:text-blue-300 line-clamp-3">
                                {{ $eventoDestaque->titulo }}
                            </h3>
                        </div>
                    </a>
                </div>

                {{-- LISTA LATERAL DE EVENTOS (Lado Direito) --}}
                <div class="flex flex-col gap-4">
                    @foreach($eventos->skip(1)->take(4) as $evento)
                    <a href="{{ route('agenda.show', $evento->id) }}" class="group flex items-center gap-4 bg-white/10 backdrop-blur-sm border border-white/10 p-4 hover:bg-white/20 transition-all duration-300 {{ $evento->status === 'cancelado' ? 'opacity-75' : '' }}">

                        {{-- Bloco de Data --}}
                        <div class="flex flex-col items-center justify-center w-14 h-14 bg-white text-blue-950 shrink-0 shadow-sm">
                            <span class="text-[9px] font-extrabold tracking-wider uppercase opacity-70">{{ $evento->data_inicio->format('M') }}</span>
                            <span class="text-xl font-black leading-none -mt-0.5">{{ $evento->data_inicio->format('d') }}</span>
                        </div>

                        {{-- Detalhes --}}
                        <div class="flex flex-col flex-1 min-w-0">
                            @if($evento->status === 'cancelado')
                            <span class="text-[9px] font-bold text-red-400 mb-0.5">CANCELADO</span>
                            @endif
                            <h3 class="text-sm font-bold leading-tight text-white group-hover:text-yellow-400 transition-colors line-clamp-2 mb-1.5">
                                {{ $evento->titulo }}
                            </h3>
                            <div class="flex items-center gap-3 text-[11px] font-medium text-blue-200/80 truncate">
                                <span class="flex items-center gap-1 shrink-0"><svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg> {{ $evento->data_inicio->format('H:i') }}</span>
                                <span class="flex items-center gap-1 truncate"><svg class="w-3 h-3 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                    </svg> {{ $evento->local ?? 'Assaí' }}</span>
                            </div>
                        </div>
                    </a>
                    @endforeach
                </div>
            </div>
            @else
            <div class="flex flex-col items-center justify-center col-span-full py-12 bg-white/10 border border-dashed border-white/20">
                <svg class="w-12 h-12 mb-3 text-white/30" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                </svg>
                <h3 class="text-lg font-bold text-white">Nenhum evento agendado</h3>
                <p class="text-sm text-blue-200">Acompanhe nossas redes sociais para mais novidades.</p>
            </div>
            @endif

            <div class="flex justify-center mt-10 md:mt-12 relative z-10">
                <a href="{{ route('agenda.index') }}" class="inline-flex items-center gap-2 px-7 py-3 text-sm font-bold text-white transition bg-transparent border border-white/30 hover:bg-white hover:text-blue-950 hover:border-white group">
                    Ver calendário completo
                    <svg class="w-4 h-4 transition-transform group-hover:translate-x-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"></path>
                    </svg>
                </a>
            </div>
        </div>
        {{-- /AGENDA DA CIDADE --}}

        {{-- ═══════════════════════════════════════════════
                 5. BLOCOS MOBILE (Conecta / Gov / Transparência)
            ════════════════════════════════════════════════ --}}
        <div class="flex flex-col gap-6 lg:hidden font-sans">
            <div class="p-6 text-center bg-white border border-gray-100 shadow-sm">
                <img src="{{ asset('img/conecta.png') }}" class="w-auto h-12 mx-auto mb-4 object-contain" alt="Conecta Assaí" loading="lazy" decoding="async">
                <h3 class="text-lg font-bold text-gray-800 font-heading">Serviços ao Cidadão e Inscrições Online</h3>
                <a href="https://conecta.assai.pr.gov.br/" target="_blank" class="block w-full py-2 mt-4 font-bold text-center text-blue-600 transition border border-blue-600 hover:bg-yellow-500 hover:text-blue-900 hover:border-yellow-500 font-heading">Acessar Conecta Assaí</a>
            </div>

            <div class="p-6 text-center shadow-sm bg-blue-50 border-blue-100">
                <img src="{{ asset('img/gov.assai.png') }}" class="w-auto h-12 mx-auto mb-4 object-contain" alt="Gov.Assaí" loading="lazy" decoding="async">
                <h3 class="text-lg font-bold text-blue-900 font-heading">Sua identidade digital unificada em Assaí.</h3>
                <a href="https://gov.assai.pr.gov.br/" target="_blank" class="block w-full py-2 mt-4 font-bold text-center text-white transition bg-blue-600 hover:bg-blue-700 font-heading">Acessar Gov.Assaí</a>
            </div>

            <div class="p-6 bg-gray-100 font-sans">
                <h3 class="mb-4 text-base font-bold text-gray-800 uppercase font-heading">Participação & Transparência</h3>
                <div class="flex flex-col gap-2.5 font-sans">
                    <a href="#" class="flex justify-between p-4 text-base font-medium text-gray-700 transition bg-white shadow-sm hover:text-blue-600">Ouvidoria Municipal <span>></span></a>
                    <a href="https://transparencia.betha.cloud/#/yyGw8hIiYdv6bs-avrzVUg==" class="flex justify-between p-4 text-base font-medium text-gray-700 transition bg-white shadow-sm hover:text-blue-600">Portal da Transparência <span>></span></a>
                    <a href="https://transparencia.betha.cloud/#/yyGw8hIiYdv6bs-avrzVUg==/consulta/95802" class="flex justify-between p-4 text-base font-medium text-gray-700 transition bg-white shadow-sm hover:text-blue-600">Licitações <span>></span></a>
                    <a href="https://www.doemunicipal.com.br/prefeituras/4" class="flex justify-between p-4 text-base font-medium text-gray-700 transition bg-white shadow-sm hover:text-blue-600">Diário Oficial <span>></span></a>
                </div>
            </div>
        </div>
        {{-- /BLOCOS MOBILE --}}

    </div>
    {{-- /lg:col-span-9 --}}



    </div>
    {{-- /.container --}}

</main>

<style>
    #home-hero {
        min-height: 560px;
    }

    .sidebar-details-panel {
        transform: translateY(100%);
        transition: transform .45s ease-in-out;
    }

    .sidebar-interactive-card.sidebar-card-open .sidebar-details-panel {
        transform: translateY(0);
    }

    .sidebar-interactive-card.sidebar-card-open .sidebar-cover {
        opacity: 0;
        pointer-events: none;
    }
</style>

<script>
    function updateHomeHeroHeight() {
        const hero = document.getElementById('home-hero');

        if (!hero) {
            return;
        }

        const header = document.getElementById('site-header');
        const alertBar = document.getElementById('site-alert-bar');

        const headerHeight = header ? header.offsetHeight : 0;
        const alertHeight = alertBar ? alertBar.offsetHeight : 0;
        const topOffset = headerHeight + alertHeight;

        hero.style.height = `calc(100dvh - ${topOffset}px)`;
        hero.style.minHeight = `calc(100svh - ${topOffset}px)`;
    }

    function toggleSidebarCard(button) {
        const card = button.closest('.sidebar-interactive-card');

        if (!card) {
            return;
        }

        card.classList.toggle('sidebar-card-open');
    }

    window.addEventListener('load', updateHomeHeroHeight);
    window.addEventListener('resize', updateHomeHeroHeight);
    window.addEventListener('orientationchange', updateHomeHeroHeight);

    const headerElement = document.getElementById('site-header');
    const alertElement = document.getElementById('site-alert-bar');

    if (window.ResizeObserver) {
        const heroObserver = new ResizeObserver(updateHomeHeroHeight);

        if (headerElement) {
            heroObserver.observe(headerElement);
        }

        if (alertElement) {
            heroObserver.observe(alertElement);
        }
    }
</script>

@endsection