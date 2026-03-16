@extends('layouts.app')

@section('content')
<main id="conteudo-principal" accesskey="1" tabindex="-1" class="flex flex-col min-h-screen bg-gray-50">

    <section class="relative w-full bg-blue-900 h-[400px] md:h-[480px]">

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
                        @if($loop->first) fetchpriority="high" loading="eager" @else loading="lazy" decoding="async" @endif>
                    <div class="absolute inset-0 mix-blend-multiply bg-blue-900/70"></div>

                    <div class="absolute inset-0 flex flex-col items-center justify-center px-4 text-center z-10 pb-36 md:pb-[180px]">

                        <h1 class="w-full max-w-4xl mb-2 text-3xl font-extrabold text-white break-words drop-shadow-lg md:text-5xl font-heading leading-tight">
                            {{ $banner->titulo }}
                        </h1>

                        @if($banner->subtitulo)
                        <p class="w-full max-w-2xl mb-4 text-base font-medium text-blue-100 break-words drop-shadow md:text-lg font-sans">
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
                        fetchpriority="high" loading="eager">

                    <div class="absolute inset-0 mix-blend-multiply bg-blue-900/70"></div>

                    <div class="absolute inset-0 flex flex-col items-center justify-center px-4 text-center z-10 pb-20 md:pb-[100px]">
                        <h1 class="mb-3 text-3xl font-extrabold text-white drop-shadow-md md:text-5xl font-heading leading-tight">
                            Bem-vindo ao Portal da<br>Prefeitura de Assaí
                        </h1>
                    </div>
                </div>
                @endforelse

            </div>

            @if($banners->count() > 1)
            <div class="text-white swiper-button-next after:!text-2xl drop-shadow hidden md:flex !z-30"></div>
            <div class="text-white swiper-button-prev after:!text-2xl drop-shadow hidden md:flex !z-30"></div>
            <div class="swiper-pagination !bottom-4 !z-30"></div>
            @endif
        </div>

        <div class="absolute bottom-10 md:bottom-[80px] left-0 right-0 z-40 flex flex-col items-center justify-center w-full px-5 md:px-4 pointer-events-none">

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
                        placeholder="Buscar serviços, notícias ou informações..."
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
                    <button type="submit" aria-label="Pesquisar" class="m-1.5 px-5 py-2.5 font-bold text-sm text-white transition-all bg-blue-600 rounded-full shrink-0 md:px-6 md:py-3 hover:bg-blue-700 hover:shadow-lg font-heading">
                        Buscar
                    </button>

                    {{-- Dropdown de Autocomplete --}}
                    <div id="autocomplete-results"
                        class="absolute left-0 right-0 top-full mt-2 bg-white border border-slate-100 rounded-2xl shadow-2xl overflow-hidden z-[70] hidden opacity-0 transition-opacity duration-200">
                    </div>
                </form>
            </div>

            {{-- Chips de Sugestão --}}
            <div id="ia-suggestions" class="flex flex-wrap items-center justify-center gap-2 mt-3 pointer-events-auto">
                @forelse($sugestoesIA as $sugestao)
                <button
                    type="button"
                    role="button"
                    tabindex="0"
                    aria-label="Sugestão de busca: {{ $sugestao }}"
                    onclick="preencherBusca('{{ addslashes($sugestao) }}')"
                    onkeydown="if(event.key==='Enter'||event.key===' ')preencherBusca('{{ addslashes($sugestao) }}')"
                    class="inline-flex items-center gap-1.5 px-3.5 py-1.5 text-xs font-semibold text-white cursor-pointer select-none transition-all duration-200 bg-white/10 border border-white/25 backdrop-blur-sm rounded-full hover:bg-blue-600 hover:text-white hover:border-transparent hover:shadow-md active:scale-95 focus:outline-none focus:ring-2 focus:ring-white/60 font-sans">
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


    <div class="container relative z-10 grid grid-cols-1 gap-8 px-4 py-10 mx-auto -mt-4 lg:grid-cols-12">
        <div class="flex flex-col gap-16 lg:col-span-9">
            {{-- ═══════════════════════════════════════════════
                 1. HUB DE SERVIÇOS
            ════════════════════════════════════════════════ --}}
            <div id="hub-servicos" class="flex flex-col gap-10 scroll-mt-24">

                <div class="grid grid-cols-1 gap-6 md:grid-cols-2 font-sans">
                    <div class="p-6 bg-white border border-gray-100 shadow-sm rounded-2xl border-t-4 border-t-yellow-400">
                        <h2 class="mb-5 text-lg font-bold text-gray-800 font-heading">Acesso Rápido a Serviços Fiscais</h2>
                        <div class="grid grid-cols-2 gap-3">
                            <a href="https://conecta.assai.pr.gov.br/servico/99" target="_blank" rel="noopener noreferrer" class="group flex flex-col items-center justify-center p-5 text-center transition-all bg-gray-50 border border-gray-100 rounded-xl hover:bg-blue-600 hover:border-blue-600 hover:shadow-lg hover:-translate-y-0.5">
                                <svg class="w-9 h-9 mx-auto mb-2.5 text-blue-600 transition-colors group-hover:text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path>
                                </svg>
                                <div class="font-bold text-sm text-gray-800 font-heading transition-colors group-hover:text-white">IPTU</div>
                                <div class="text-xs text-gray-500 font-sans transition-colors group-hover:text-blue-100">Consultar Taxas</div>
                            </a>
                            <a href="https://conecta.assai.pr.gov.br/servico/112" target="_blank" rel="noopener noreferrer" class="group flex flex-col items-center justify-center p-5 text-center transition-all bg-gray-50 border border-gray-100 rounded-xl hover:bg-blue-600 hover:border-blue-600 hover:shadow-lg hover:-translate-y-0.5">
                                <svg class="w-9 h-9 mx-auto mb-2.5 text-blue-600 transition-colors group-hover:text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                </svg>
                                <div class="font-bold text-sm text-gray-800 font-heading transition-colors group-hover:text-white">Nota Fiscal</div>
                                <div class="text-xs text-gray-500 font-sans transition-colors group-hover:text-blue-100">Emitir Documentos</div>
                            </a>
                        </div>
                    </div>
                    <div class="flex flex-col p-6 bg-white border border-gray-100 shadow-sm rounded-2xl font-sans">
                        <h2 class="text-lg font-bold text-gray-800 font-heading">Protocolo Digital</h2>
                        <p class="mb-4 text-sm text-gray-500 font-sans">Faça solicitações e acompanhe online.</p>
                        <div class="flex flex-col gap-2 mb-5 font-sans">
                            <a href="#" class="flex items-center gap-2.5 p-3 text-sm font-medium text-gray-700 rounded-xl bg-gray-50 hover:bg-blue-50 hover:text-blue-600 transition-colors">
                                <span class="text-base">➕</span> Abrir protocolo
                            </a>
                            <a href="https://conecta.assai.pr.gov.br/servico/27" target="_blank" rel="noopener noreferrer" class="flex items-center gap-2.5 p-3 text-sm font-medium text-gray-700 rounded-xl bg-gray-50 hover:bg-blue-50 hover:text-blue-600 transition-colors">
                                <span class="text-base">🔍</span> Consultar andamento
                            </a>
                        </div>
                        <a href="https://conecta.assai.pr.gov.br/servicos/categoria/2" target="_blank" rel="noopener noreferrer" class="mt-auto w-full py-3 font-bold text-blue-900 transition-all bg-yellow-400 rounded-xl font-heading hover:bg-yellow-500 hover:shadow-md text-center">Acessar Protocolo</a>
                    </div>
                </div>

                <div>
                    <div class="flex items-center justify-between mb-6">
                        <h2 class="text-2xl font-bold text-slate-800 font-heading">Serviços mais Acessados</h2>
                        <a href="{{ route('servicos.index') }}" class="text-sm font-semibold text-blue-600 hover:text-blue-800 transition-colors flex items-center gap-1">
                            Ver todos os serviços
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                            </svg>
                        </a>
                    </div>
                    <div class="grid grid-cols-2 gap-4 md:grid-cols-3 lg:grid-cols-4 md:gap-6">

                        @forelse($servicos as $servico)
                        <a href="{{ $servico->url_acesso ?? $servico->link ?? '#' }}" target="_blank" rel="noopener noreferrer" class="flex flex-col items-center p-6 text-center bg-white border border-slate-100 rounded-2xl shadow-sm hover:shadow-md hover:-translate-y-1 transition-all group">

                            <div class="flex items-center justify-center w-14 h-14 mb-4 text-blue-600 bg-blue-50 rounded-xl group-hover:bg-blue-600 group-hover:text-white transition-colors">
                                <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    @switch($servico->icone)
                                    @case('saude')
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path>
                                    @break
                                    @case('vagas')
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                                    @break
                                    @case('documentos')
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                    @break
                                    @case('ouvidoria')
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M11 5.882V19.24a1.76 1.76 0 01-3.417.592l-2.147-6.15M18 13a3 3 0 100-6M5.436 13.683A4.001 4.001 0 017 6h1.832c4.1 0 7.625-1.234 9.168-3v14c-1.543-1.766-5.067-3-9.168-3H7a3.988 3.988 0 01-1.564-.317z"></path>
                                    @break
                                    @case('alvara')
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"></path>
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

                            <h3 class="text-sm font-bold text-slate-800 line-clamp-3 group-hover:text-blue-700 transition-colors font-heading" title="{{ $servico->titulo }}">
                                {{ $servico->titulo }}
                            </h3>
                        </a>
                        @empty
                        <p class="text-sm text-gray-500 col-span-full">Nenhum serviço em destaque no momento.</p>
                        @endforelse

                    </div>
                </div>

            </div>
            {{-- /HUB DE SERVIÇOS --}}

            {{-- ═══════════════════════════════════════════════
                 2. ASSAÍ EM AÇÃO
            ════════════════════════════════════════════════ --}}
            <div class="p-8 md:p-10 bg-slate-200 border border-slate-300 rounded-[2rem] shadow-inner">
                <div class="flex flex-col items-start mb-10">
                    <span class="px-3 py-1 mb-3 text-xs font-bold tracking-wider text-blue-700 uppercase bg-blue-100 rounded-full">Acontecendo Agora</span>
                    <h2 class="text-3xl font-extrabold text-slate-800 font-heading">Assaí em Ação</h2>
                    <p class="mt-2 text-slate-500 max-w-2xl">Acompanhe os principais programas, obras e iniciativas que estão transformando a nossa cidade todos os dias.</p>
                </div>

                <div class="grid grid-cols-1 gap-6 md:grid-cols-2 lg:grid-cols-3">

                    @if(isset($inscricoesAbertas) && count($inscricoesAbertas) > 0)
                    @foreach($inscricoesAbertas as $inscricao)
                    <a href="https://conecta.assai.pr.gov.br/editais/{{ $inscricao['slug'] ?? $inscricao['id'] }}" target="_blank" class="relative flex flex-col p-6 overflow-hidden transition bg-blue-50 border shadow-sm border-blue-200 rounded-2xl hover:shadow-xl hover:-translate-y-1 group hover:border-blue-400">

                        <div class="absolute top-0 right-0 px-3 py-1 text-[10px] font-bold text-white bg-green-500 rounded-bl-lg rounded-tr-xl flex items-center gap-1">
                            <div class="w-1.5 h-1.5 bg-white rounded-full animate-pulse"></div>
                            INSCRIÇÕES ABERTAS
                        </div>

                        <div class="flex items-center justify-center w-14 h-14 mb-6 text-blue-600 bg-white rounded-xl shadow-sm group-hover:scale-110 transition-transform overflow-hidden">
                            <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                            </svg>
                        </div>

                        <h3 class="mb-2 text-xl font-bold text-slate-800 font-heading line-clamp-2">{{ $inscricao['title'] ?? $inscricao['titulo'] }}</h3>
                        <p class="text-sm text-slate-600 mb-6 flex-1 line-clamp-3">{{ $inscricao['description'] ?? $inscricao['descricao'] }}</p>

                        <span class="flex items-center gap-1 text-sm font-bold text-blue-600 group-hover:text-blue-800">Inscreva-se &rarr;</span>
                    </a>
                    @endforeach
                    @endif

                    @forelse($programas as $programa)
                    <a href="{{ route('programas.show', $programa) }}" class="relative flex flex-col overflow-hidden transition bg-white border shadow-sm border-slate-200 rounded-2xl hover:shadow-xl hover:-translate-y-1 group hover:border-blue-300">

                        @if($programa->icone)
                        {{-- Layout com Imagem de Capa (Edge-to-Edge) --}}
                        <div class="relative overflow-hidden h-48 bg-gray-200 shrink-0">
                            <img src="{{ asset('storage/' . $programa->icone) }}" alt="{{ $programa->titulo }}" class="object-cover w-full h-full transition duration-500 group-hover:scale-105" loading="lazy" decoding="async">
                        </div>
                        <div class="flex flex-col flex-1 p-6">
                            <h3 class="mb-2 text-xl font-bold text-slate-800 font-heading line-clamp-2">{{ $programa->titulo }}</h3>
                            <p class="text-sm text-slate-500 mb-6 flex-1 line-clamp-3">{{ $programa->descricao }}</p>
                            <span class="flex items-center gap-1 text-sm font-bold text-blue-600 group-hover:text-blue-700 mt-auto">Saiba mais &rarr;</span>
                        </div>
                        @else
                        {{-- Layout com Ícone Vetorial (Fallback) --}}
                        <div class="flex flex-col flex-1 p-6">
                            <div class="flex items-center justify-center w-14 h-14 mb-6 text-blue-600 bg-blue-50 rounded-xl group-hover:scale-110 transition-transform overflow-hidden shrink-0">
                                <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                                </svg>
                            </div>
                            <h3 class="mb-2 text-xl font-bold text-slate-800 font-heading line-clamp-2">{{ $programa->titulo }}</h3>
                            <p class="text-sm text-slate-500 mb-6 flex-1 line-clamp-3">{{ $programa->descricao }}</p>
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
                    <a href="{{ route('programas.index') }}" class="inline-flex items-center gap-2 px-6 py-3 text-sm font-bold text-blue-700 bg-white border border-blue-200 rounded-xl hover:bg-blue-50 hover:border-blue-300 transition-all shadow-sm group">
                        Ver todos os programas
                        <svg class="w-4 h-4 text-blue-500 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3" />
                        </svg>
                    </a>
                </div>
            </div>
            {{-- /ASSAÍ EM AÇÃO --}}

            {{-- ═══════════════════════════════════════════════
                 3. NOTÍCIAS
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

                <div class="grid grid-cols-1 gap-6 md:grid-cols-6 font-sans">
                    @forelse($noticias as $noticia)
                    <article class="flex flex-col overflow-hidden transition-all bg-white border border-gray-100 cursor-pointer rounded-2xl shadow-sm group hover:shadow-xl hover:-translate-y-1 {{ $loop->iteration <= 2 ? 'md:col-span-3' : 'md:col-span-2' }}">

                        <div class="relative overflow-hidden bg-gray-200 shrink-0 {{ $loop->iteration <= 2 ? 'h-52' : 'h-40' }}">
                            <span class="absolute z-10 px-3 py-1 text-xs font-bold tracking-wider text-blue-900 uppercase bg-yellow-400 rounded-md shadow-sm top-3 left-3">
                                {{ $noticia->categoria }}
                            </span>

                            <a href="{{ route('noticias.show', $noticia->slug) }}" class="block w-full h-full">
                                @if($noticia->imagem_capa)
                                <img src="{{ asset('storage/' . $noticia->imagem_capa) }}" alt="{{ $noticia->titulo }}" class="object-cover w-full h-full transition duration-500 group-hover:scale-105" loading="lazy" decoding="async">
                                @else
                                <img src="{{ asset('img/Assaí.jpg') }}" alt="Prefeitura de Assaí" class="object-cover w-full h-full opacity-80 transition duration-500 group-hover:scale-105" loading="lazy" decoding="async">
                                @endif
                            </a>
                        </div>

                        <div class="flex flex-col flex-1 p-5">
                            <div class="inline-flex items-center gap-1.5 mb-2 text-xs font-bold tracking-wide text-blue-600 uppercase">
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                </svg>
                                {{ \Carbon\Carbon::parse($noticia->data_publicacao)->format('d/m/Y') }}
                            </div>

                            <a href="{{ route('noticias.show', $noticia->slug) }}">
                                <h3 class="mb-2 font-bold leading-tight text-gray-900 transition font-heading group-hover:text-blue-600 {{ $loop->iteration <= 2 ? 'text-xl' : 'text-lg' }}">
                                    {{ $noticia->titulo }}
                                </h3>
                            </a>

                            <p class="mt-auto text-sm text-gray-600 line-clamp-2">
                                {{ $noticia->resumo ?? Str::limit(strip_tags($noticia->conteudo), 100) }}
                            </p>
                        </div>
                    </article>
                    @empty
                    <div class="p-8 text-center border border-gray-300 border-dashed bg-gray-50 col-span-full rounded-2xl">
                        <p class="font-medium text-gray-500">Nenhuma notícia publicada no momento.</p>
                    </div>
                    @endforelse
                </div>
            </div>
            {{-- /NOTÍCIAS --}}

            {{-- ═══════════════════════════════════════════════
                 4. AGENDA DA CIDADE
            ════════════════════════════════════════════════ --}}
            <div class="p-8 md:p-12 bg-blue-950 rounded-[2rem] shadow-xl relative overflow-hidden">
                <div class="flex flex-col items-start justify-between mb-10 md:flex-row md:items-end">
                    <div>
                        <h2 class="text-3xl font-extrabold text-white font-heading">Agenda da Cidade</h2>
                        <p class="mt-2 text-blue-200">Fique por dentro dos próximos eventos, feiras e inaugurações em Assaí.</p>
                    </div>
                </div>

                <div class="grid grid-cols-1 gap-6 md:grid-cols-6">
                    @forelse($eventos as $evento)
                    <a href="{{ route('agenda.show', $evento->id) }}"
                        class="flex flex-col overflow-hidden transition-all bg-white border shadow-sm rounded-2xl border-slate-100 hover:shadow-xl hover:-translate-y-1 group cursor-pointer {{ $loop->iteration <= 2 ? 'md:col-span-3' : 'md:col-span-2' }} {{ $evento->status === 'cancelado' ? 'opacity-75' : '' }}">

                        <div class="relative">
                            @if($evento->imagem)
                            <img src="{{ asset('storage/' . $evento->imagem) }}" alt="{{ $evento->titulo }}" class="object-cover w-full border-b border-slate-100 {{ $loop->iteration <= 2 ? 'h-52' : 'h-40' }}" loading="lazy" decoding="async">
                            @else
                            <div class="flex items-center justify-center w-full bg-blue-50 border-b border-slate-100 {{ $loop->iteration <= 2 ? 'h-52' : 'h-40' }}">
                                <svg class="w-12 h-12 text-blue-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                </svg>
                            </div>
                            @endif
                            @if($evento->status === 'cancelado')
                            <span class="absolute top-2 left-2 px-2 py-0.5 text-[10px] font-bold text-white bg-red-600 rounded-full shadow">CANCELADO</span>
                            @elseif($evento->status === 'adiado')
                            <span class="absolute top-2 left-2 px-2 py-0.5 text-[10px] font-bold text-white bg-amber-500 rounded-full shadow">ADIADO</span>
                            @endif
                        </div>

                        <div class="flex flex-col flex-1 p-5">

                            <div class="flex items-center gap-4 mb-4">
                                <div class="flex flex-col items-center justify-center w-14 h-14 bg-blue-900 rounded-xl text-white shrink-0 shadow-inner">
                                    <span class="text-[10px] font-bold tracking-wider uppercase opacity-80">{{ $evento->data_inicio->format('M') }}</span>
                                    <span class="text-xl font-extrabold leading-none">{{ $evento->data_inicio->format('d') }}</span>
                                </div>

                                <div>
                                    <div class="flex items-center gap-1.5 text-sm font-bold text-blue-600">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                        </svg>
                                        {{ $evento->data_inicio->format('H:i') }}
                                    </div>
                                    <div class="flex items-center gap-1.5 text-xs font-medium text-slate-500 mt-0.5 line-clamp-1">
                                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                        </svg>
                                        {{ $evento->local ?? 'Assaí, PR' }}
                                    </div>
                                </div>
                            </div>

                            <h3 class="font-bold leading-tight text-slate-800 break-words line-clamp-2 group-hover:text-blue-700 transition-colors {{ $loop->iteration <= 2 ? 'text-xl' : 'text-lg' }}" title="{{ $evento->titulo }}">
                                {{ $evento->titulo }}
                            </h3>

                            @if($evento->descricao)
                            <p class="text-sm text-slate-500 line-clamp-2">{{ $evento->descricao }}</p>
                            @endif

                        </div>
                    </a>
                    @empty
                    <div class="flex flex-col items-center justify-center col-span-full py-12 bg-white border border-dashed rounded-2xl border-slate-300">
                        <svg class="w-12 h-12 mb-3 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                        </svg>
                        <h3 class="text-lg font-bold text-slate-700">Nenhum evento agendado</h3>
                        <p class="text-sm text-slate-500">Acompanhe nossas redes sociais para mais novidades.</p>
                    </div>
                    @endforelse
                </div>

                <div class="flex justify-center mt-10 md:mt-12">
                    <a href="{{ route('agenda.index') }}" class="inline-flex items-center gap-2 px-8 py-3.5 text-base font-bold text-white transition bg-transparent border-2 border-white/30 rounded-full hover:bg-white hover:text-blue-950 hover:border-white hover:-translate-y-1">
                        Ver calendário completo
                        <svg class="w-5 h-5 transition-transform group-hover:translate-x-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
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
                <div class="p-6 text-center bg-white border border-gray-100 shadow-sm rounded-2xl">
                    <img src="{{ asset('img/conecta.png') }}" class="w-auto h-12 mx-auto mb-4 object-contain" alt="Conecta Assaí" loading="lazy" decoding="async">
                    <h3 class="text-lg font-bold text-gray-800 font-heading">Serviços ao Cidadão e Inscrições Online</h3>
                    <a href="https://conecta.assai.pr.gov.br/" target="_blank" class="block w-full py-2 mt-4 font-bold text-center text-blue-600 transition border border-blue-600 rounded-lg hover:bg-yellow-500 hover:text-blue-900 hover:border-yellow-500 font-heading">Acessar Conecta Assaí</a>
                </div>

                <div class="p-6 text-center shadow-sm bg-blue-50 border-blue-100 rounded-2xl">
                    <img src="{{ asset('img/gov.assai.png') }}" class="w-auto h-12 mx-auto mb-4 object-contain" alt="Gov.Assaí" loading="lazy" decoding="async">
                    <h3 class="text-lg font-bold text-blue-900 font-heading">Sua identidade digital unificada em Assaí.</h3>
                    <a href="https://gov.assai.pr.gov.br/" target="_blank" class="block w-full py-2 mt-4 font-bold text-center text-white transition bg-blue-600 rounded-lg hover:bg-blue-700 font-heading">Acessar Gov.Assaí</a>
                </div>

                <div class="p-6 bg-gray-100 rounded-3xl font-sans">
                    <h3 class="mb-4 text-base font-bold text-gray-800 uppercase font-heading">Participação & Transparência</h3>
                    <div class="flex flex-col gap-2.5 font-sans">
                        <a href="#" class="flex justify-between p-4 text-base font-medium text-gray-700 transition bg-white shadow-sm rounded-xl hover:text-blue-600">Ouvidoria Municipal <span>></span></a>
                        <a href="https://transparencia.betha.cloud/#/yyGw8hIiYdv6bs-avrzVUg==" class="flex justify-between p-4 text-base font-medium text-gray-700 transition bg-white shadow-sm rounded-xl hover:text-blue-600">Portal da Transparência <span>></span></a>
                        <a href="https://transparencia.betha.cloud/#/yyGw8hIiYdv6bs-avrzVUg==/consulta/95802" class="flex justify-between p-4 text-base font-medium text-gray-700 transition bg-white shadow-sm rounded-xl hover:text-blue-600">Licitações <span>></span></a>
                        <a href="https://www.doemunicipal.com.br/prefeituras/4" class="flex justify-between p-4 text-base font-medium text-gray-700 transition bg-white shadow-sm rounded-xl hover:text-blue-600">Diário Oficial <span>></span></a>
                    </div>
                </div>
            </div>
            {{-- /BLOCOS MOBILE --}}

        </div>
        {{-- /lg:col-span-9 --}}

        {{-- ═══════════════════════════════════════════════
             BARRA LATERAL (lg:col-span-3)
        ════════════════════════════════════════════════ --}}
        <aside class="hidden lg:flex flex-col gap-8 lg:col-span-3 sticky top-6 h-fit font-sans">
            <div class="p-6 text-center bg-white border border-gray-100 shadow-sm rounded-2xl">
                <img src="{{ asset('img/conecta.png') }}" class="w-auto h-14 object-contain mx-auto mb-4" alt="Conecta Assaí" loading="lazy" decoding="async">
                <h3 class="text-lg font-bold text-gray-800 font-heading">Serviços ao Cidadão e Inscrições Online</h3>
                <a href="https://conecta.assai.pr.gov.br/" target="_blank" class="block w-full py-2 mt-4 font-bold text-center text-blue-600 transition border border-blue-600 rounded-lg hover:bg-yellow-500 hover:text-blue-900 hover:border-yellow-500 font-heading">Acessar Conecta Assaí</a>
            </div>

            <div class="p-6 text-center shadow-sm bg-blue-50 border-blue-100 rounded-2xl">
                <img src="{{ asset('img/gov.assai.png') }}" class="w-auto h-14 object-contain mx-auto mb-4" alt="Gov.Assaí" loading="lazy" decoding="async">
                <h3 class="text-lg font-bold text-blue-900 font-heading">Sua identidade digital unificada em Assaí.</h3>
                <a href="https://gov.assai.pr.gov.br/" target="_blank" class="block w-full py-2 mt-4 font-bold text-center text-white transition bg-blue-600 rounded-lg hover:bg-blue-700 font-heading">Acessar Gov.Assaí</a>
            </div>

            <div class="p-6 bg-gray-100 rounded-3xl font-sans">
                <h3 class="mb-4 text-base font-bold text-gray-800 uppercase font-heading">Participação & Transparência</h3>
                <div class="flex flex-col gap-2.5 font-sans">
                    <a href="#" class="flex justify-between p-4 text-base font-medium text-gray-700 transition bg-white shadow-sm rounded-xl hover:text-blue-600">Ouvidoria Municipal <span>></span></a>
                    <a href="https://transparencia.betha.cloud/#/yyGw8hIiYdv6bs-avrzVUg==" class="flex justify-between p-4 text-base font-medium text-gray-700 transition bg-white shadow-sm rounded-xl hover:text-blue-600">Portal da Transparência <span>></span></a>
                    <a href="https://transparencia.betha.cloud/#/yyGw8hIiYdv6bs-avrzVUg==/consulta/95802" class="flex justify-between p-4 text-base font-medium text-gray-700 transition bg-white shadow-sm rounded-xl hover:text-blue-600">Licitações <span>></span></a>
                    <a href="https://www.doemunicipal.com.br/prefeituras/4" class="flex justify-between p-4 text-base font-medium text-gray-700 transition bg-white shadow-sm rounded-xl hover:text-blue-600">Diário Oficial <span>></span></a>
                </div>
            </div>
        </aside>
        {{-- /BARRA LATERAL --}}

    </div>
    {{-- /.container --}}

</main>

@endsection