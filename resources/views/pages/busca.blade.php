@extends('layouts.app')

@section('title', 'Resultados da Busca: ' . ($termo ?? 'Pesquisa') . ' - Prefeitura Municipal de Assaí')

@section('content')
<main id="conteudo-principal" accesskey="1" tabindex="-1" class="min-h-screen bg-gray-50 pb-20">

    {{-- Hero Section com Breadcrumb --}}
    <section class="bg-blue-900 pt-10 pb-16 md:pt-16 md:pb-24 relative overflow-hidden">
        <div class="absolute inset-0 opacity-10 pointer-events-none">
            <svg class="w-full h-full" fill="currentColor" viewBox="0 0 100 100" preserveAspectRatio="none">
                <path d="M0 100 C 20 0 50 0 100 100 Z"></path>
            </svg>
        </div>

        <div class="container px-4 mx-auto max-w-4xl relative z-10">
            <x-breadcrumb :items="[
                ['name' => 'Início', 'url' => route('home')],
                ['name' => 'Busca no Portal'],
            ]" dark />

            <h1 class="text-3xl md:text-4xl font-black text-white font-heading mb-8 leading-tight">
                @if($termo)
                    Resultados para: <span class="text-yellow-400">"{{ $termo }}"</span>
                @else
                    O que você está procurando?
                @endif
            </h1>

            <form action="{{ route('busca.index') }}" method="GET" class="relative group" role="search" aria-label="Busca no portal">
                <div class="flex items-center bg-white rounded-2xl shadow-2xl overflow-hidden focus-within:ring-4 focus-within:ring-blue-500/20 transition-all duration-300">
                    <div class="pl-5 text-gray-400">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                    </div>
                    <label for="campo-busca-portal" class="sr-only">Pesquisar no portal</label>
                    <input id="campo-busca-portal" type="text" name="q" value="{{ $termo }}" placeholder="Digite serviços, notícias, leis ou eventos..." class="flex-1 px-4 py-5 text-base md:text-lg text-gray-800 bg-transparent border-none focus:outline-none font-sans">
                    <button type="submit" class="m-2 px-7 md:px-8 py-3 md:py-3.5 text-sm md:text-base font-bold text-white bg-blue-600 hover:bg-blue-700 rounded-xl transition-all font-heading shrink-0 shadow-lg">
                        Pesquisar
                    </button>
                </div>
            </form>
        </div>
    </section>

    {{-- Sistema de Abas e Filtros --}}
    <div id="sec-all" class="container px-4 mx-auto max-w-5xl -mt-8 relative z-20">
        
        <div class="bg-white p-2 rounded-2xl shadow-xl border border-gray-100 mb-10 overflow-x-auto">
            <div class="flex items-center gap-1 min-w-max" role="tablist" aria-label="Filtrar resultados da busca">
                <button id="tab-all" role="tab" aria-selected="true" aria-controls="sec-all" onclick="filterResults('all')" class="tab-btn active px-6 py-3 rounded-xl font-bold text-sm transition-all" data-target="all">
                    Tudo <span class="ml-2 opacity-50 text-xs">{{ $noticias->count() + $servicos->count() + $eventos->count() + $programas->count() + $secretarias->count() }}</span>
                </button>
                @if($noticias->isNotEmpty())
                <button id="tab-noticias" role="tab" aria-selected="false" aria-controls="sec-noticias" onclick="filterResults('noticias')" class="tab-btn px-6 py-3 rounded-xl font-bold text-sm transition-all text-gray-500 hover:bg-gray-50" data-target="noticias">
                    Notícias <span class="ml-2 opacity-50 text-xs">{{ $noticias->count() }}</span>
                </button>
                @endif
                @if($servicos->isNotEmpty())
                <button id="tab-servicos" role="tab" aria-selected="false" aria-controls="sec-servicos" onclick="filterResults('servicos')" class="tab-btn px-6 py-3 rounded-xl font-bold text-sm transition-all text-gray-500 hover:bg-gray-50" data-target="servicos">
                    Serviços <span class="ml-2 opacity-50 text-xs">{{ $servicos->count() }}</span>
                </button>
                @endif
                @if($eventos->isNotEmpty())
                <button id="tab-eventos" role="tab" aria-selected="false" aria-controls="sec-eventos" onclick="filterResults('eventos')" class="tab-btn px-6 py-3 rounded-xl font-bold text-sm transition-all text-gray-500 hover:bg-gray-50" data-target="eventos">
                    Eventos <span class="ml-2 opacity-50 text-xs">{{ $eventos->count() }}</span>
                </button>
                @endif
                @if($programas->isNotEmpty())
                <button id="tab-programas" role="tab" aria-selected="false" aria-controls="sec-programas" onclick="filterResults('programas')" class="tab-btn px-6 py-3 rounded-xl font-bold text-sm transition-all text-gray-500 hover:bg-gray-50" data-target="programas">
                    Programas <span class="ml-2 opacity-50 text-xs">{{ $programas->count() }}</span>
                </button>
                @endif
                @if($secretarias->isNotEmpty())
                <button id="tab-secretarias" role="tab" aria-selected="false" aria-controls="sec-secretarias" onclick="filterResults('secretarias')" class="tab-btn px-6 py-3 rounded-xl font-bold text-sm transition-all text-gray-500 hover:bg-gray-50" data-target="secretarias">
                    Secretarias <span class="ml-2 opacity-50 text-xs">{{ $secretarias->count() }}</span>
                </button>
                @endif
            </div>
        </div>

        @if(strlen(trim($termo)) < 2)
            <div class="text-center py-20 bg-white rounded-3xl border border-dashed border-gray-300">
                <div class="w-20 h-20 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-6">
                    <svg class="w-10 h-10 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                </div>
                <h3 class="text-xl font-bold text-gray-800 font-heading">Busca Insuficiente</h3>
                <p class="text-gray-500 mt-2">Por favor, digite ao menos 2 caracteres para realizar a varredura no portal.</p>
            </div>
        @elseif($noticias->isEmpty() && $servicos->isEmpty() && $eventos->isEmpty() && $programas->isEmpty() && $secretarias->isEmpty())
            <div class="text-center py-20 bg-white rounded-3xl border border-gray-100 shadow-sm">
                <img src="{{ asset('img/no-results.svg') }}" class="w-48 mx-auto mb-8 opacity-50" alt="Nenhum resultado" loading="lazy" decoding="async">
                <h3 class="text-2xl font-bold text-gray-800 font-heading">Nenhum resultado para "{{ $termo }}"</h3>
                <p class="text-gray-500 mt-2 max-w-md mx-auto">Não encontramos informações correspondentes. Tente termos mais genéricos ou verifique se há erros de digitação.</p>
                <div class="mt-8">
                    <a href="{{ route('home') }}" class="text-blue-600 font-bold hover:underline">Voltar para a página inicial</a>
                </div>
            </div>
        @else

            {{-- Resultados: Notícias --}}
            @if($noticias->isNotEmpty())
            <section id="sec-noticias" role="tabpanel" aria-labelledby="tab-noticias" class="result-section mb-12">
                <div class="flex items-center gap-3 mb-6">
                    <div class="w-1.5 h-8 bg-blue-600 rounded-full"></div>
                    <h2 class="text-2xl font-black text-gray-900 font-heading">Notícias Encontradas</h2>
                </div>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    @foreach($noticias as $noticia)
                    <article class="bg-white rounded-2xl p-4 border border-gray-100 shadow-sm hover:shadow-xl transition-all flex gap-5 group">
                        <div class="w-24 h-24 md:w-32 md:h-32 shrink-0 rounded-xl overflow-hidden bg-gray-100">
                            @if($noticia->imagem_capa)
                                <img src="{{ asset('storage/' . $noticia->imagem_capa) }}" class="w-full h-full object-cover group-hover:scale-105 transition duration-500" alt="{{ $noticia->titulo }}" loading="lazy" decoding="async">
                            @else
                                <div class="w-full h-full flex items-center justify-center bg-blue-50 text-blue-200">
                                    <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z"/></svg>
                                </div>
                            @endif
                        </div>
                        <div class="flex flex-col justify-center py-1">
                            <span class="text-[10px] font-bold text-blue-600 uppercase tracking-widest mb-1">{{ $noticia->categoria }}</span>
                            <a href="{{ route('noticias.show', $noticia->slug) }}" class="text-base md:text-lg font-bold text-gray-900 group-hover:text-blue-600 transition leading-tight line-clamp-2 font-heading">
                                {{ $noticia->titulo }}
                            </a>
                            <p class="text-xs text-gray-500 mt-2">
                                Publicado em {{ \Carbon\Carbon::parse($noticia->data_publicacao)->format('d/m/Y') }}
                            </p>
                        </div>
                    </article>
                    @endforeach
                </div>
            </section>
            @endif

            {{-- Resultados: Serviços --}}
            @if($servicos->isNotEmpty())
            <section id="sec-servicos" role="tabpanel" aria-labelledby="tab-servicos" class="result-section mb-12">
                <div class="flex items-center gap-3 mb-6">
                    <div class="w-1.5 h-8 bg-emerald-500 rounded-full"></div>
                    <h2 class="text-2xl font-black text-gray-900 font-heading">Serviços e Consultas</h2>
                </div>
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
                    @foreach($servicos as $servico)
                    <a href="{{ $servico->url_acesso ?? $servico->link ?? '#' }}" target="_blank" rel="noopener noreferrer" class="flex items-center p-5 bg-white border border-gray-100 rounded-2xl shadow-sm hover:border-emerald-400 hover:shadow-lg transition-all group">
                        <div class="w-12 h-12 flex items-center justify-center bg-emerald-50 text-emerald-600 rounded-xl mr-4 group-hover:bg-emerald-600 group-hover:text-white transition-colors">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/></svg>
                        </div>
                        <div class="min-w-0">
                            <h3 class="text-sm font-bold text-gray-800 truncate font-heading group-hover:text-emerald-700 transition-colors">{{ $servico->titulo }}</h3>
                            <span class="text-[10px] font-medium text-gray-500 uppercase tracking-tighter">Acesso Direto &rarr;</span>
                        </div>
                    </a>
                    @endforeach
                </div>
            </section>
            @endif

            {{-- Resultados: Eventos --}}
            @if($eventos->isNotEmpty())
            <section id="sec-eventos" role="tabpanel" aria-labelledby="tab-eventos" class="result-section mb-12">
                <div class="flex items-center gap-3 mb-6">
                    <div class="w-1.5 h-8 bg-yellow-500 rounded-full"></div>
                    <h2 class="text-2xl font-black text-gray-900 font-heading">Agenda e Eventos</h2>
                </div>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                    @foreach($eventos as $evento)
                    <div class="flex items-center gap-5 bg-white p-5 border border-gray-100 rounded-2xl shadow-sm hover:shadow-md transition-all">
                        <div class="flex flex-col items-center justify-center w-16 h-16 bg-blue-900 rounded-2xl text-white shrink-0 shadow-inner">
                            <span class="text-[10px] font-bold tracking-wider uppercase opacity-70">{{ $evento->data_inicio->translatedFormat('M') }}</span>
                            <span class="text-2xl font-black leading-none">{{ $evento->data_inicio->format('d') }}</span>
                        </div>
                        <div class="min-w-0">
                            <h3 class="text-base font-bold text-gray-900 font-heading leading-tight truncate">{{ $evento->titulo }}</h3>
                            <div class="flex items-center gap-3 mt-1 text-xs text-gray-500 font-medium">
                                <span class="flex items-center gap-1">
                                    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                    {{ $evento->data_inicio->format('H:i') }}
                                </span>
                                <span class="flex items-center gap-1">
                                    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path></svg>
                                    {{ $evento->local ?? 'Assaí, PR' }}
                                </span>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </section>
            @endif

            {{-- Resultados: Programas --}}
            @if($programas->isNotEmpty())
            <section id="sec-programas" role="tabpanel" aria-labelledby="tab-programas" class="result-section mb-12">
                <div class="flex items-center gap-3 mb-6">
                    <div class="w-1.5 h-8 bg-purple-500 rounded-full"></div>
                    <h2 class="text-2xl font-black text-gray-900 font-heading">Programas Municipais</h2>
                </div>
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
                    @foreach($programas as $programa)
                    <a href="{{ $programa->link ?? '#' }}" @if($programa->link) target="_blank" rel="noopener noreferrer" @endif
                       class="flex items-center p-5 bg-white border border-gray-100 rounded-2xl shadow-sm hover:border-purple-400 hover:shadow-lg transition-all group">
                        <div class="w-12 h-12 flex items-center justify-center bg-purple-50 text-purple-600 rounded-xl mr-4 group-hover:bg-purple-600 group-hover:text-white transition-colors shrink-0">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/>
                            </svg>
                        </div>
                        <div class="min-w-0">
                            <h3 class="text-sm font-bold text-gray-800 line-clamp-2 font-heading group-hover:text-purple-700 transition-colors">{{ $programa->titulo }}</h3>
                            <span class="text-[10px] font-medium text-gray-500 uppercase tracking-tighter">Programa Municipal</span>
                        </div>
                    </a>
                    @endforeach
                </div>
            </section>
            @endif

            {{-- Resultados: Secretarias --}}
            @if($secretarias->isNotEmpty())
            <section id="sec-secretarias" role="tabpanel" aria-labelledby="tab-secretarias" class="result-section mb-12">
                <div class="flex items-center gap-3 mb-6">
                    <div class="w-1.5 h-8 bg-slate-500 rounded-full"></div>
                    <h2 class="text-2xl font-black text-gray-900 font-heading">Secretarias</h2>
                </div>
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
                    @foreach($secretarias as $secretaria)
                    @php
                        $iniciais = collect(explode(' ', $secretaria->nome))
                            ->filter(fn($p) => strlen($p) > 2)
                            ->take(2)
                            ->map(fn($p) => strtoupper($p[0]))
                            ->implode('');
                    @endphp
                    <a href="{{ route('secretarias.show', $secretaria->id) }}"
                       class="flex items-center gap-4 p-5 bg-white border border-gray-100 rounded-2xl shadow-sm hover:border-slate-400 hover:shadow-lg transition-all group">
                        <div class="w-12 h-12 shrink-0 rounded-xl overflow-hidden">
                            @if($secretaria->foto)
                                <img src="{{ asset('storage/' . $secretaria->foto) }}" class="w-full h-full object-cover" alt="Foto de {{ $secretaria->nome }}" loading="lazy" decoding="async">
                            @else
                                <div class="w-full h-full flex items-center justify-center bg-slate-100 text-slate-600 font-black text-sm group-hover:bg-slate-600 group-hover:text-white transition-colors">
                                    {{ $iniciais ?: 'SM' }}
                                </div>
                            @endif
                        </div>
                        <div class="min-w-0">
                            <h3 class="text-sm font-bold text-gray-800 leading-snug line-clamp-2 font-heading group-hover:text-slate-700 transition-colors">{{ $secretaria->nome }}</h3>
                            @if($secretaria->nome_secretario)
                                <p class="text-[11px] text-gray-500 mt-0.5 truncate">{{ $secretaria->nome_secretario }}</p>
                            @endif
                        </div>
                    </a>
                    @endforeach
                </div>
            </section>
            @endif

        @endif
    </div>
</main>

@endsection