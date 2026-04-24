@extends('layouts.app')

@section('title', 'Resultados da Busca: ' . ($termo ?? 'Pesquisa') . ' - Prefeitura Municipal de Assaí')

@section('meta_tags')
<link rel="icon" type="image/x-icon" href="{{ asset('favicon.ico') }}?v=3-busca">
<link rel="shortcut icon" type="image/x-icon" href="{{ asset('favicon.ico') }}?v=3-busca">
<link rel="icon" type="image/png" sizes="32x32" href="{{ asset('img/brasao.png') }}?v=3-busca">
<link rel="icon" type="image/png" sizes="192x192" href="{{ asset('img/brasao.png') }}?v=3-busca">
<link rel="apple-touch-icon" href="{{ asset('img/brasao.png') }}?v=3-busca">
@endsection

@section('content')
<main id="conteudo-principal" accesskey="1" tabindex="-1" class="min-h-screen bg-[#edf5ff] pb-20 font-sans pt-6">

    {{-- =================
         HERO SECTION (Busca - Padrão Gov.br)
         ================= --}}
    <section class="relative overflow-hidden bg-gradient-to-br from-blue-950 via-blue-900 to-blue-800 pt-12 pb-16 sm:pt-16 sm:pb-20 shadow-inner min-h-[360px] sm:min-h-[420px]">
        {{-- Elementos de fundo subtis --}}
        <div class="absolute inset-0 pointer-events-none">
            <div class="absolute inset-0 bg-[radial-gradient(circle_at_top_right,rgba(255,255,255,0.08),transparent_60%)]"></div>
            <div class="absolute -top-40 -right-32 w-96 h-96 bg-blue-800/30 rounded-full blur-3xl"></div>
            <div class="absolute -bottom-40 -left-32 w-96 h-96 bg-indigo-800/25 rounded-full blur-3xl"></div>
        </div>

        <div class="container relative z-10 px-4 sm:px-6 mx-auto max-w-5xl text-left">
            <x-breadcrumb :items="[
                ['name' => 'Início', 'url' => route('home')],
                ['name' => 'Busca no Portal'],
            ]" dark />

            <div class="mt-5 flex flex-col gap-8 sm:gap-10">
                <div class="max-w-3xl">
                    <h1 class="text-4xl sm:text-5xl font-black text-white font-heading leading-tight tracking-tight drop-shadow-sm">
                        @if($termo)
                        Resultados para: <span class="text-yellow-300 break-words">"{{ $termo }}"</span>
                        @else
                        O que você está procurando?
                        @endif
                    </h1>
                    <p class="mt-3 text-sm sm:text-base text-blue-100 leading-relaxed">
                        Encontre notícias, serviços, eventos, programas e secretarias em um único lugar.
                    </p>
                </div>

                {{-- Barra de Busca --}}
                <div class="w-full mt-8 sm:mt-10 md:mt-12" x-data="{ advanced: {{ (request('data_inicio') || request('data_fim') || request('categoria')) ? 'true' : 'false' }} }">
                    <form action="{{ route('busca.index') }}" method="GET" onsubmit="return this.q.value.trim() !== ''" class="relative bg-white/95 backdrop-blur-md shadow-2xl rounded-3xl border border-white/60 transition-all duration-300 p-2" role="search">
                        <div class="flex items-center w-full">
                            <label for="campo-busca-portal" class="sr-only">Pesquisar no portal</label>
                            <div class="flex items-center justify-center pl-4 pr-2 text-slate-400 hidden md:flex">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                                </svg>
                            </div>
                            <input id="campo-busca-portal" type="text" name="q" value="{{ $termo }}" placeholder="O que você procura?" required
                                class="flex-1 px-3 py-3 text-sm text-gray-800 bg-transparent border-none md:text-base focus:ring-0 focus:outline-none font-sans placeholder:text-slate-400"
                                autofocus>
                            
                            <div class="flex items-center gap-2 pr-2">
                                <button type="button" @click="advanced = !advanced" 
                                    class="p-2.5 text-blue-900/60 hover:text-blue-900 hover:bg-blue-50 rounded-full transition-colors flex items-center gap-2"
                                    :class="advanced ? 'bg-blue-50 text-blue-900' : ''"
                                    title="Filtros Avançados">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6V4m0 2a2 2 0 100 4m0-4a2 2 0 110 4m-6 8a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4m6 6v10m6-2a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4"></path>
                                    </svg>
                                    <span class="hidden md:inline text-xs font-bold uppercase tracking-wider">Filtros</span>
                                </button>
                                <button type="submit" class="px-6 py-2.5 font-bold text-sm text-blue-900 transition-all bg-yellow-400 rounded-full hover:bg-yellow-500 shadow-md font-heading">
                                    Buscar
                                </button>
                            </div>
                        </div>

                        {{-- Painel de Filtros Avançados --}}
                        <div x-show="advanced" x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0 -translate-y-2" x-transition:enter-end="opacity-100 translate-y-0" class="mt-4 p-4 border-t border-slate-100 grid grid-cols-1 md:grid-cols-3 gap-4" x-cloak>
                            <div class="flex flex-col gap-1.5">
                                <label class="text-[10px] font-bold text-slate-500 uppercase tracking-widest ml-1">Data Início</label>
                                <input type="date" name="data_inicio" value="{{ request('data_inicio') }}" 
                                    class="w-full px-4 py-2 text-sm border border-slate-200 rounded-xl focus:ring-2 focus:ring-blue-500 outline-none transition-all">
                            </div>
                            <div class="flex flex-col gap-1.5">
                                <label class="text-[10px] font-bold text-slate-500 uppercase tracking-widest ml-1">Data Fim</label>
                                <input type="date" name="data_fim" value="{{ request('data_fim') }}" 
                                    class="w-full px-4 py-2 text-sm border border-slate-200 rounded-xl focus:ring-2 focus:ring-blue-500 outline-none transition-all">
                            </div>
                            <div class="flex flex-col gap-1.5">
                                <label class="text-[10px] font-bold text-slate-500 uppercase tracking-widest ml-1">Tema / Categoria</label>
                                <select name="categoria" class="w-full px-4 py-2 text-sm border border-slate-200 rounded-xl focus:ring-2 focus:ring-blue-500 outline-none transition-all appearance-none bg-white">
                                    <option value="">Todos os Temas</option>
                                    @foreach($categorias as $cat)
                                        <option value="{{ $cat }}" {{ request('categoria') == $cat ? 'selected' : '' }}>{{ $cat }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>

    {{-- =================
         SISTEMA DE RESULTADOS E ABAS
         ================= --}}
    {{-- =================
         SISTEMA DE RESULTADOS E ABAS
         ================= --}}
    <div id="resultados-busca" class="container px-4 mx-auto max-w-5xl -mt-6 sm:-mt-8 pt-0 relative z-20">

        {{-- Filtros de conteúdo (mobile-first) --}}
        <div class="mb-10 sm:mb-12">
            @php
            $totalResults = $noticias->count() + $servicos->count() + $eventos->count() + $programas->count() + $secretarias->count() + $paginas->count();
            $tabBaseClass = 'tab-btn group flex w-full items-center justify-between gap-2 rounded-2xl border border-slate-200 bg-white px-4 py-3 text-left text-sm font-bold text-slate-700 shadow-sm transition-all hover:-translate-y-0.5 hover:border-slate-300 hover:shadow-md focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-[#FFCD00] focus-visible:ring-offset-1 sm:w-auto sm:min-w-[155px] sm:justify-center sm:rounded-full sm:px-5 sm:py-2.5';
            $availableTabs = [
                'all' => $totalResults > 0,
                'servicos' => $servicos->isNotEmpty(),
                'paginas' => $paginas->isNotEmpty(),
                'eventos' => $eventos->isNotEmpty(),
                'programas' => $programas->isNotEmpty(),
                'secretarias' => $secretarias->isNotEmpty(),
                'noticias' => $noticias->isNotEmpty(),
            ];
            $requestedTab = strtolower((string) request('tipo', 'all'));
            $activeTab = (array_key_exists($requestedTab, $availableTabs) && $availableTabs[$requestedTab]) ? $requestedTab : 'all';
            @endphp

            <style>
                .tab-btn.is-active {
                    background: #071d41;
                    border-color: #071d41;
                    color: #fff;
                }

                .tab-btn .tab-count {
                    background: #f1f5f9;
                    color: #475569;
                }

                .tab-btn {
                    letter-spacing: 0.01em;
                }

                .tab-btn.is-active .tab-count {
                    background: rgba(255, 255, 255, 0.2);
                    color: #fff;
                }
            </style>

            <nav id="tab-filter-nav" data-active-tab="{{ $activeTab }}" aria-label="Filtrar categorias de busca" class="w-full rounded-3xl border border-slate-400 bg-slate-50/95 backdrop-blur-sm p-3 sm:p-4 ring-1 ring-slate-300/90 shadow-[0_10px_24px_rgba(15,23,42,0.16)]">
                <p class="mb-3 text-center text-sm sm:text-base font-black uppercase tracking-[0.12em] text-slate-800 sm:mb-4">Filtrar resultados por tipo</p>

                <ul role="tablist" aria-label="Categorias de resultados" class="grid grid-cols-2 gap-2.5 sm:flex sm:flex-wrap sm:items-center sm:justify-center sm:gap-3">
                    <li>
                        <button id="tab-all" type="button" role="tab" onclick="filterResults('all', true)" data-target="all" aria-selected="{{ $activeTab === 'all' ? 'true' : 'false' }}" aria-controls="resultados-busca"
                            class="{{ $tabBaseClass }} {{ $activeTab === 'all' ? 'is-active' : '' }}">
                            Tudo
                            <span class="tab-count inline-flex min-w-7 items-center justify-center rounded-full px-2 py-0.5 text-[11px] font-black transition-colors">{{ $totalResults }}</span>
                        </button>
                    </li>

                    @if($servicos->isNotEmpty())
                    <li>
                        <button id="tab-servicos" type="button" role="tab" onclick="filterResults('servicos', true)" data-target="servicos" aria-selected="{{ $activeTab === 'servicos' ? 'true' : 'false' }}" aria-controls="sec-servicos"
                            class="{{ $tabBaseClass }} {{ $activeTab === 'servicos' ? 'is-active' : '' }}">
                            Serviços
                            <span class="tab-count inline-flex min-w-7 items-center justify-center rounded-full px-2 py-0.5 text-[11px] font-black transition-colors">{{ $servicos->count() }}</span>
                        </button>
                    </li>
                    @endif

                    @if($paginas->isNotEmpty())
                    <li>
                        <button id="tab-paginas" type="button" role="tab" onclick="filterResults('paginas', true)" data-target="paginas" aria-selected="{{ $activeTab === 'paginas' ? 'true' : 'false' }}" aria-controls="sec-paginas"
                            class="{{ $tabBaseClass }} {{ $activeTab === 'paginas' ? 'is-active' : '' }}">
                            Portal
                            <span class="tab-count inline-flex min-w-7 items-center justify-center rounded-full px-2 py-0.5 text-[11px] font-black transition-colors">{{ $paginas->count() }}</span>
                        </button>
                    </li>
                    @endif

                    @if($eventos->isNotEmpty())
                    <li>
                        <button id="tab-eventos" type="button" role="tab" onclick="filterResults('eventos', true)" data-target="eventos" aria-selected="{{ $activeTab === 'eventos' ? 'true' : 'false' }}" aria-controls="sec-eventos"
                            class="{{ $tabBaseClass }} {{ $activeTab === 'eventos' ? 'is-active' : '' }}">
                            Eventos
                            <span class="tab-count inline-flex min-w-7 items-center justify-center rounded-full px-2 py-0.5 text-[11px] font-black transition-colors">{{ $eventos->count() }}</span>
                        </button>
                    </li>
                    @endif

                    @if($programas->isNotEmpty())
                    <li>
                        <button id="tab-programas" type="button" role="tab" onclick="filterResults('programas', true)" data-target="programas" aria-selected="{{ $activeTab === 'programas' ? 'true' : 'false' }}" aria-controls="sec-programas"
                            class="{{ $tabBaseClass }} {{ $activeTab === 'programas' ? 'is-active' : '' }}">
                            Programas
                            <span class="tab-count inline-flex min-w-7 items-center justify-center rounded-full px-2 py-0.5 text-[11px] font-black transition-colors">{{ $programas->count() }}</span>
                        </button>
                    </li>
                    @endif

                    @if($secretarias->isNotEmpty())
                    <li>
                        <button id="tab-secretarias" type="button" role="tab" onclick="filterResults('secretarias', true)" data-target="secretarias" aria-selected="{{ $activeTab === 'secretarias' ? 'true' : 'false' }}" aria-controls="sec-secretarias"
                            class="{{ $tabBaseClass }} {{ $activeTab === 'secretarias' ? 'is-active' : '' }}">
                            Secretarias
                            <span class="tab-count inline-flex min-w-7 items-center justify-center rounded-full px-2 py-0.5 text-[11px] font-black transition-colors">{{ $secretarias->count() }}</span>
                        </button>
                    </li>
                    @endif

                    @if($noticias->isNotEmpty())
                    <li>
                        <button id="tab-noticias" type="button" role="tab" onclick="filterResults('noticias', true)" data-target="noticias" aria-selected="{{ $activeTab === 'noticias' ? 'true' : 'false' }}" aria-controls="sec-noticias"
                            class="{{ $tabBaseClass }} {{ $activeTab === 'noticias' ? 'is-active' : '' }}">
                            Notícias
                            <span class="tab-count inline-flex min-w-7 items-center justify-center rounded-full px-2 py-0.5 text-[11px] font-black transition-colors">{{ $noticias->count() }}</span>
                        </button>
                    </li>
                    @endif
                </ul>
            </nav>
        </div>

        {{-- Fallbacks (Erros e Vazios) --}}
        @if(strlen(trim($termo)) < 2)
            <div class="text-center py-20 bg-white rounded-3xl shadow-sm border border-slate-200 px-4">
            <div class="w-20 h-20 bg-yellow-50 rounded-full flex items-center justify-center mx-auto mb-6">
                <svg class="w-10 h-10 text-yellow-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                </svg>
            </div>
            <h3 class="text-2xl font-black text-slate-800 font-heading mb-2">Busca Insuficiente</h3>
            <p class="text-slate-600">Por favor, digite ao menos <strong class="text-slate-800">2 caracteres</strong> para realizar a varredura no portal.</p>
    </div>
    @elseif($totalResults === 0 && !isset($respostaInteligente))
    <div class="text-center py-24 bg-white rounded-3xl shadow-sm border border-slate-200 px-4">
        <div class="w-24 h-24 bg-slate-50 rounded-full flex items-center justify-center mx-auto mb-6 border border-slate-100">
            <svg class="w-12 h-12 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0zM10 14v-4m0 0V6m0 4h4m-4 0H6"></path>
            </svg>
        </div>
        <h3 class="text-2xl md:text-3xl font-black text-blue-900 font-heading mb-3">Nenhum resultado encontrado</h3>
        <p class="text-slate-600 max-w-md mx-auto mb-8">
            Não encontramos informações para <strong class="text-slate-800">"{{ $termo }}"</strong>.
            @if(request('data_inicio') || request('data_fim') || request('categoria'))
                <br>Tente <span class="text-blue-600 font-bold">limpar os filtros</span> para ampliar sua busca.
            @else
                <br>Tente utilizar termos mais genéricos ou verifique a ortografia.
            @endif
        </p>
        
        <div class="flex flex-col sm:flex-row items-center justify-center gap-4">
            @if(request('data_inicio') || request('data_fim') || request('categoria'))
                <a href="{{ route('busca.index', ['q' => $termo]) }}" class="inline-flex items-center px-8 py-3.5 font-bold text-sm text-blue-900 uppercase tracking-wider bg-yellow-400 rounded-full hover:bg-yellow-500 hover:-translate-y-0.5 transition-all">
                    Limpar Filtros
                </a>
            @endif
            <a href="{{ route('home') }}" class="inline-flex items-center px-8 py-3.5 font-bold text-sm text-white uppercase tracking-wider bg-[#071D41] rounded-full hover:bg-blue-800 hover:-translate-y-0.5 transition-all focus:ring-2 focus:ring-offset-2 focus:ring-[#FFCD00]">
                Voltar à Página Inicial
            </a>
        </div>
    </div>
    @else

    {{-- 0. RESPOSTA INTELIGENTE (IA) --}}
    @if(isset($respostaInteligente))
    <section id="sec-ia" class="result-section mb-14 {{ $activeTab !== 'all' ? 'hidden' : '' }}">
        <div class="bg-gradient-to-br from-blue-50 to-indigo-50 rounded-3xl border-2 border-blue-200 p-6 md:p-8 shadow-lg relative overflow-hidden">
            <div class="absolute top-0 right-0 p-4 opacity-10">
                <svg class="w-24 h-24 text-blue-900" fill="currentColor" viewBox="0 0 24 24">
                    <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm0 18c-4.41 0-8-3.59-8-8s3.59-8 8-8 8 3.59 8 8-3.59 8-8 8zm-1-13h2v6h-2zm0 8h2v2h-2z"/>
                </svg>
            </div>
            <div class="relative z-10">
                <div class="flex items-center gap-2 mb-4">
                    <span class="bg-blue-600 text-white text-[10px] font-black uppercase tracking-widest px-2.5 py-1 rounded-full flex items-center gap-1.5 shadow-sm">
                        <span class="relative flex h-2 w-2">
                            <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-white opacity-75"></span>
                            <span class="relative inline-flex rounded-full h-2 w-2 bg-white"></span>
                        </span>
                        Resposta Inteligente
                    </span>
                    <span class="text-xs font-bold text-blue-400">Beta</span>
                </div>
                <div class="prose prose-blue max-w-none">
                    <p class="text-lg md:text-xl font-medium text-slate-800 leading-relaxed">
                        {!! $respostaInteligente['resposta'] !!}
                    </p>
                </div>
                <div class="mt-6 pt-6 border-t border-blue-100 flex items-center justify-between">
                    <p class="text-[11px] text-blue-500 font-bold uppercase tracking-wider">Esta resposta foi gerada automaticamente para ajudar você mais rápido.</p>
                </div>
            </div>
        </div>
    </section>
    @endif

    {{-- 1. Resultados: Serviços (PRIORIDADE 1) --}}
    @if($servicos->isNotEmpty())
    <section id="sec-servicos" role="tabpanel" aria-labelledby="tab-servicos" class="result-section mb-14 {{ $activeTab !== 'all' && $activeTab !== 'servicos' ? 'hidden' : '' }}">
        <div class="flex items-center gap-3 mb-8">
            <div class="w-2 h-8 bg-emerald-500 rounded-sm"></div>
            <h2 class="text-2xl font-black text-[#071D41] font-heading uppercase tracking-tight">Serviços</h2>
        </div>
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4 md:gap-5">
            @foreach($servicos as $servico)
            <a href="{{ $servico->url_acesso ?? $servico->link ?? '#' }}" target="_blank" rel="noopener noreferrer" class="flex items-start p-5 bg-white border border-slate-200 rounded-2xl shadow-sm hover:border-emerald-500 hover:shadow-md transition-all duration-300 group outline-none focus-visible:ring-4 focus-visible:ring-emerald-400">
                <div class="w-12 h-12 flex items-center justify-center bg-slate-50 text-emerald-600 rounded-xl mr-4 group-hover:bg-emerald-500 group-hover:text-white transition-colors shrink-0 border border-slate-100 group-hover:border-transparent">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z" />
                    </svg>
                </div>
                <div class="min-w-0 flex-1 pt-0.5">
                    <h3 class="text-sm md:text-base font-bold text-slate-800 line-clamp-2 font-heading group-hover:text-[#071D41] transition-colors mb-1">{{ $servico->titulo }}</h3>
                    <span class="text-[11px] font-bold text-emerald-600 uppercase tracking-wider flex items-center gap-1.5 opacity-80 group-hover:opacity-100 transition-opacity">
                        Acessar <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"></path>
                        </svg>
                    </span>
                </div>
            </a>
            @endforeach
        </div>
    </section>
    @endif

    {{-- 2. Resultados: Páginas do Portal (PRIORIDADE 2) --}}
    @if($paginas->isNotEmpty())
    <section id="sec-paginas" role="tabpanel" aria-labelledby="tab-paginas" class="result-section mb-14 {{ $activeTab !== 'all' && $activeTab !== 'paginas' ? 'hidden' : '' }}">
        <div class="flex items-center gap-3 mb-8">
            <div class="w-2 h-8 bg-indigo-600 rounded-sm"></div>
            <h2 class="text-2xl font-black text-[#071D41] font-heading uppercase tracking-tight">Onde Encontrar</h2>
        </div>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            @foreach($paginas as $pagina)
            <a href="{{ $pagina['url'] }}" class="flex flex-col p-5 bg-white border border-slate-200 rounded-2xl shadow-sm hover:border-indigo-400 hover:shadow-md transition-all group outline-none focus-visible:ring-4 focus-visible:ring-indigo-300">
                <div class="flex items-center justify-between mb-2">
                    <h3 class="text-lg font-bold text-slate-800 group-hover:text-indigo-700 transition-colors font-heading">{{ $pagina['titulo'] }}</h3>
                    <svg class="w-5 h-5 text-slate-300 group-hover:text-indigo-500 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                    </svg>
                </div>
                <p class="text-sm text-slate-500 line-clamp-2 leading-relaxed">{{ $pagina['descricao'] }}</p>
            </a>
            @endforeach
        </div>
    </section>
    @endif

    {{-- 3. Resultados: Eventos --}}
    @if($eventos->isNotEmpty())
    <section id="sec-eventos" role="tabpanel" aria-labelledby="tab-eventos" class="result-section mb-14 {{ $activeTab !== 'all' && $activeTab !== 'eventos' ? 'hidden' : '' }}">
        <div class="flex items-center gap-3 mb-8">
            <div class="w-2 h-8 bg-yellow-500 rounded-sm"></div>
            <h2 class="text-2xl font-black text-[#071D41] font-heading uppercase tracking-tight">Eventos</h2>
        </div>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
            @foreach($eventos as $evento)
            <div class="flex items-start gap-4 sm:gap-5 bg-white p-4 sm:p-5 border border-slate-200 rounded-2xl shadow-sm hover:shadow-md transition-all">
                <div class="flex flex-col items-center justify-center w-16 h-16 sm:w-20 sm:h-20 bg-[#071D41] rounded-xl text-white shrink-0 border-b-4 border-[#FFCD00]">
                    <span class="text-[10px] sm:text-xs font-bold tracking-widest uppercase opacity-90">{{ $evento->data_inicio->translatedFormat('M') }}</span>
                    <span class="text-2xl sm:text-3xl font-black leading-none">{{ $evento->data_inicio->format('d') }}</span>
                </div>
                <div class="min-w-0 flex-1 pt-1">
                    <h3 class="text-sm sm:text-base font-bold text-slate-800 font-heading leading-tight line-clamp-2 mb-2">{{ $evento->titulo }}</h3>
                    <div class="flex flex-col sm:flex-row sm:items-center gap-2 sm:gap-4 text-[11px] sm:text-xs text-slate-600 font-medium">
                        <span class="flex items-center gap-1.5 bg-slate-50 px-2 py-1 rounded w-fit">
                            <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            {{ $evento->data_inicio->format('H:i') }}
                        </span>
                        <span class="flex items-center gap-1.5 truncate">
                            <svg class="w-4 h-4 text-slate-400 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                            </svg>
                            <span class="truncate">{{ $evento->local ?? 'Assaí, PR' }}</span>
                        </span>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </section>
    @endif

    {{-- 4. Resultados: Programas --}}
    @if($programas->isNotEmpty())
    <section id="sec-programas" role="tabpanel" aria-labelledby="tab-programas" class="result-section mb-14 {{ $activeTab !== 'all' && $activeTab !== 'programas' ? 'hidden' : '' }}">
        <div class="flex items-center gap-3 mb-8">
            <div class="w-2 h-8 bg-purple-600 rounded-sm"></div>
            <h2 class="text-2xl font-black text-[#071D41] font-heading uppercase tracking-tight">Programas</h2>
        </div>
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4 md:gap-5">
            @foreach($programas as $programa)
            <a href="{{ $programa->link ?? '#' }}" @if($programa->link) target="_blank" rel="noopener noreferrer" @endif
                class="flex items-center p-5 bg-white border border-slate-200 rounded-2xl shadow-sm hover:border-purple-400 hover:shadow-md hover:-translate-y-1 transition-all duration-300 group outline-none focus-visible:ring-4 focus-visible:ring-purple-400">
                <div class="w-12 h-12 flex items-center justify-center bg-slate-50 text-purple-600 rounded-xl mr-4 group-hover:bg-purple-600 group-hover:text-white transition-colors shrink-0 border border-slate-100 group-hover:border-transparent">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" />
                    </svg>
                </div>
                <div class="min-w-0 flex-1">
                    <h3 class="text-sm font-bold text-slate-800 line-clamp-2 font-heading group-hover:text-[#071D41] transition-colors">{{ $programa->titulo }}</h3>
                </div>
            </a>
            @endforeach
        </div>
    </section>
    @endif

    {{-- 5. Resultados: Secretarias --}}
    @if($secretarias->isNotEmpty())
    <section id="sec-secretarias" role="tabpanel" aria-labelledby="tab-secretarias" class="result-section mb-14 {{ $activeTab !== 'all' && $activeTab !== 'secretarias' ? 'hidden' : '' }}">
        <div class="flex items-center gap-3 mb-8">
            <div class="w-2 h-8 bg-slate-600 rounded-sm"></div>
            <h2 class="text-2xl font-black text-[#071D41] font-heading uppercase tracking-tight">Secretarias</h2>
        </div>
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4 md:gap-5">
            @foreach($secretarias as $secretaria)
            @php
            $iniciais = collect(explode(' ', $secretaria->nome))
            ->filter(fn($p) => strlen($p) > 2)
            ->take(2)
            ->map(fn($p) => strtoupper($p[0]))
            ->implode('');
            @endphp
            <a href="{{ route('secretarias.show', $secretaria->id) }}"
                class="flex items-start gap-4 p-5 bg-white border border-slate-200 rounded-2xl shadow-sm hover:border-[#FFCD00] hover:shadow-md hover:-translate-y-1 transition-all duration-300 group outline-none focus-visible:ring-4 focus-visible:ring-[#FFCD00]">
                <div class="w-14 h-14 shrink-0 rounded-xl overflow-hidden border border-slate-200">
                    @if($secretaria->foto)
                    <img src="{{ asset('storage/' . $secretaria->foto) }}" class="w-full h-full object-cover" alt="Foto" loading="lazy" decoding="async">
                    @else
                    <div class="w-full h-full flex items-center justify-center bg-slate-100 text-slate-500 font-black text-sm group-hover:bg-[#071D41] group-hover:text-[#FFCD00] transition-colors">
                        {{ $iniciais ?: 'SM' }}
                    </div>
                    @endif
                </div>
                <div class="min-w-0 flex-1 pt-0.5">
                    <h3 class="text-sm font-bold text-slate-800 leading-snug line-clamp-2 font-heading group-hover:text-[#071D41] transition-colors mb-1">{{ $secretaria->nome }}</h3>
                    @if($secretaria->nome_secretario)
                    <p class="text-[11px] text-slate-500 truncate font-medium flex items-center gap-1">
                        <svg class="w-3 h-3 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                        </svg>
                        {{ $secretaria->nome_secretario }}
                    </p>
                    @endif
                </div>
            </a>
            @endforeach
        </div>
    </section>
    @endif

    {{-- 6. Resultados: Notícias (PRIORIDADE BAIXA) --}}
    @if($noticias->isNotEmpty())
    <section id="sec-noticias" role="tabpanel" aria-labelledby="tab-noticias" class="result-section mb-14 {{ $activeTab !== 'all' && $activeTab !== 'noticias' ? 'hidden' : '' }}">
        <div class="flex items-center gap-3 mb-8">
            <div class="w-2 h-8 bg-blue-600 rounded-sm"></div>
            <h2 class="text-2xl font-black text-[#071D41] font-heading uppercase tracking-tight">Notícias</h2>
        </div>
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
            @foreach($noticias as $noticia)
            <article class="relative bg-white rounded-2xl p-5 border border-slate-200 shadow-sm hover:shadow-lg hover:border-blue-300 transition-all duration-300 flex flex-col sm:flex-row gap-5 group outline-none focus-within:ring-4 focus-within:ring-[#FFCD00]">
                <a href="{{ route('noticias.show', $noticia->slug) }}" class="absolute inset-0 z-10 rounded-2xl outline-none" aria-label="Ler notícia: {{ $noticia->titulo }}"></a>

                <div class="w-full h-48 sm:w-32 sm:h-32 shrink-0 rounded-xl overflow-hidden bg-slate-100 relative">
                    @if($noticia->imagem_capa)
                    <img src="{{ asset('storage/' . $noticia->imagem_capa) }}" class="w-full h-full object-cover group-hover:scale-105 transition transform duration-700" alt="" loading="lazy">
                    @else
                    <div class="w-full h-full flex items-center justify-center text-slate-300">
                        <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z" />
                        </svg>
                    </div>
                    @endif
                </div>

                <div class="flex flex-col justify-center flex-1 min-w-0">
                    <span class="text-[10px] sm:text-xs font-bold text-blue-700 uppercase tracking-widest mb-2">{{ $noticia->categoria }}</span>
                    <h3 class="text-base sm:text-lg font-bold text-slate-800 group-hover:text-[#071D41] transition-colors leading-snug line-clamp-2 font-heading mb-2">
                        {{ $noticia->titulo }}
                    </h3>
                    <time class="text-xs text-slate-500 font-medium mt-auto flex items-center gap-1.5">
                        <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                        </svg>
                        {{ \Carbon\Carbon::parse($noticia->data_publicacao)->format('d/m/Y') }}
                    </time>
                </div>
            </article>
            @endforeach
        </div>
    </section>
    @endif

    @endif
    </div>

    {{-- Script limpo para lidar com as abas via atributo data-state do Tailwind --}}
    @if($totalResults > 0)
    <script>
        function filterResults(category, syncUrl = false) {
            const allTargets = Array.from(document.querySelectorAll('.tab-btn')).map(btn => btn.dataset.target);
            const resolvedCategory = allTargets.includes(category) ? category : 'all';

            // Atualiza estado visual dos botões
            document.querySelectorAll('.tab-btn').forEach(btn => {
                if (btn.dataset.target === resolvedCategory) {
                    btn.setAttribute('aria-selected', 'true');
                    btn.classList.add('is-active');
                } else {
                    btn.setAttribute('aria-selected', 'false');
                    btn.classList.remove('is-active');
                }
            });

            // Mostra/Esconde as seções
            document.querySelectorAll('.result-section').forEach(section => {
                if (resolvedCategory === 'all') {
                    // Na aba "Tudo", mostramos tudo inclusive IA se houver
                    section.classList.remove('hidden');
                    section.style.opacity = '1';
                    section.style.transition = 'opacity 0.2s ease';
                } else {
                    // Nas abas específicas, escondemos a IA (sec-ia)
                    if (section.id === 'sec-' + resolvedCategory) {
                        section.classList.remove('hidden');
                        section.style.opacity = '0';
                        setTimeout(() => {
                            section.style.opacity = '1';
                            section.style.transition = 'opacity 0.2s ease';
                        }, 50);
                    } else {
                        section.classList.add('hidden');
                    }
                }
            });

            if (syncUrl) {
                const url = new URL(window.location.href);
                if (resolvedCategory === 'all') {
                    url.searchParams.delete('tipo');
                } else {
                    url.searchParams.set('tipo', resolvedCategory);
                }
                window.history.replaceState({}, '', url.toString());
            }
        }

        document.addEventListener('DOMContentLoaded', function() {
            const nav = document.getElementById('tab-filter-nav');
            const initialTab = nav?.dataset.activeTab || 'all';
            filterResults(initialTab, false);
        });
    </script>
    @endif

</main>
@endsection