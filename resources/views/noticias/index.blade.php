@extends('layouts.app')

@section('title', 'Notícias - Prefeitura Municipal de Assaí')

@section('content')
<main id="conteudo-principal" accesskey="1" tabindex="-1" class="flex flex-col min-h-screen pt-[96px] lg:pt-[160px] pb-16 bg-white">
    <div class="container max-w-6xl px-4 mx-auto font-sans">

        {{-- Breadcrumb --}}
        <x-breadcrumb :items="[
            ['name' => 'Início', 'url' => route('home')],
            ['name' => 'Notícias'],
        ]" />

        {{-- Header --}}
        <div class="mb-10 text-center md:text-left">
            <h1 class="text-3xl max-[360px]:text-2xl font-black text-blue-900 md:text-4xl font-heading leading-tight uppercase tracking-tight">
                Últimas Notícias
            </h1>
            <div class="w-12 h-1 mt-3 bg-yellow-400 mx-auto md:mx-0"></div>
            <p class="mt-4 text-sm md:text-base text-gray-500">Acompanhe as ações, projetos e informativos da Prefeitura de Assaí.</p>
        </div>

        {{-- Barra de Busca --}}
        <div class="mb-10 max-w-4xl mx-auto md:mx-0" x-data="{ advanced: {{ (request('data_inicio') || request('data_fim')) ? 'true' : 'false' }} }">
            <form action="{{ route('noticias.index') }}" method="GET" class="bg-white rounded-[32px] border border-slate-300 shadow-sm transition-all focus-within:shadow-md p-2">
                @if(request('categoria'))
                    <input type="hidden" name="categoria" value="{{ request('categoria') }}">
                @endif

                <div class="flex items-center w-full h-12 md:h-14">
                    {{-- Ícone de Lupa --}}
                    <div class="flex items-center justify-center pl-4 pr-2 text-slate-400 shrink-0">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                        </svg>
                    </div>

                    {{-- Input --}}
                    <input
                        type="text"
                        name="q"
                        value="{{ request('q') }}"
                        placeholder="Busque por título, tema ou palavra-chave..."
                        class="flex-1 min-w-0 px-2 text-sm md:text-base text-slate-700 bg-transparent border-none focus:ring-0 placeholder:text-slate-400 font-sans">

                    {{-- Botão Filtros --}}
                    <button type="button" @click="advanced = !advanced" 
                        class="hidden sm:flex items-center gap-2 px-4 h-full text-slate-500 hover:text-blue-700 transition-colors"
                        :class="advanced ? 'text-blue-700 font-bold' : ''">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6V4m0 2a2 2 0 100 4m0-4a2 2 0 110 4m-6 8a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4m6 6v10m6-2a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4"></path>
                        </svg>
                        <span class="text-xs uppercase tracking-wider">Período</span>
                    </button>

                    {{-- Botão de Buscar --}}
                    <button type="submit" class="h-full px-6 md:px-8 font-bold text-sm text-blue-950 transition-all bg-yellow-400 hover:bg-yellow-500 rounded-full shrink-0 font-heading">
                        Buscar
                    </button>
                </div>

                {{-- Painel Avançado --}}
                <div x-show="advanced" x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0 -translate-y-2" x-transition:enter-end="opacity-100 translate-y-0" class="mt-2 pt-4 border-t border-slate-100 flex flex-wrap gap-4 px-4 pb-2" x-cloak>
                    <div class="flex items-center gap-2">
                        <label class="text-[10px] font-bold text-slate-400 uppercase tracking-widest">Início:</label>
                        <input type="date" name="data_inicio" value="{{ request('data_inicio') }}" class="px-3 py-1.5 text-xs border border-slate-200 rounded-lg focus:ring-2 focus:ring-blue-500 outline-none">
                    </div>
                    <div class="flex items-center gap-2">
                        <label class="text-[10px] font-bold text-slate-400 uppercase tracking-widest">Fim:</label>
                        <input type="date" name="data_fim" value="{{ request('data_fim') }}" class="px-3 py-1.5 text-xs border border-slate-200 rounded-lg focus:ring-2 focus:ring-blue-500 outline-none">
                    </div>
                    @if(request('data_inicio') || request('data_fim'))
                    <a href="{{ route('noticias.index', request()->except(['data_inicio', 'data_fim'])) }}" class="text-[10px] font-bold text-red-500 uppercase hover:underline ml-auto self-center">Limpar Período</a>
                    @endif
                </div>
            </form>
        </div>

        {{-- Filtros por Categoria --}}
        <div class="mb-12">
            <div class="flex items-center gap-2 overflow-x-auto flex-nowrap pb-2 pr-2 scrollbar-hide">
                <a href="{{ route('noticias.index', array_filter(['q' => request('q')])) }}"
                    class="shrink-0 px-5 py-2 text-xs font-bold rounded-full transition-all whitespace-nowrap border
                   {{ !request('categoria') ? 'bg-blue-800 text-white border-blue-800 shadow-md' : 'bg-white text-gray-600 border-gray-200 hover:border-blue-300 hover:text-blue-700' }}">
                    Todas
                </a>
                @foreach($categorias as $cat)
                <a href="{{ route('noticias.index', array_filter(['categoria' => $cat, 'q' => request('q')])) }}"
                    class="shrink-0 px-5 py-2 text-xs font-bold rounded-full transition-all whitespace-nowrap border
                   {{ request('categoria') === $cat ? 'bg-blue-800 text-white border-blue-800 shadow-md' : 'bg-white text-gray-600 border-gray-200 hover:border-blue-300 hover:text-blue-700' }}">
                    {{ $cat }}
                </a>
                @endforeach
            </div>
        </div>

        {{-- Grid de Notícias (Estilo Glassmorphism Claro - Igual à Home) --}}
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 lg:gap-8 justify-center">
            @forelse($noticias as $noticia)
            <article class="relative h-[350px] md:h-[430px] overflow-hidden rounded-2xl group bg-slate-100 shadow-md hover:shadow-xl transition-shadow duration-300">
                <a href="{{ route('noticias.show', $noticia->slug) }}" class="block w-full h-full outline-none focus-within:ring-4 focus-within:ring-blue-500 focus-within:ring-inset">

                    {{-- Foto (Estilo object-cover) --}}
                    <img src="{{ $noticia->imagem_capa ? asset('storage/' . $noticia->imagem_capa) : asset('img/Assai.jpg') }}"
                        alt=""
                        class="absolute inset-0 object-cover w-full h-full transition-transform duration-700 ease-out group-hover:scale-110"
                        loading="lazy" decoding="async">

                    {{-- Overlay de Gradiente --}}
                    <div class="absolute inset-0 bg-gradient-to-t from-black/80 via-black/20 to-transparent opacity-80"></div>

                    {{-- Barra de Vidro Clara (Com Expansão Automática) --}}
                    <div class="absolute bottom-0 left-0 w-full p-5 lg:p-6 bg-white/10 backdrop-blur-lg border-t border-white/30 flex flex-col justify-end transition-all duration-500">

                        <h3 class="text-sm sm:text-base font-bold leading-snug text-white font-heading drop-shadow-md">
                            {{ ucfirst(Str::lower($noticia->titulo)) }}
                        </h3>

                        {{-- Conteúdo Revelado (Grid Animado) --}}
                        <div class="grid grid-rows-[0fr] group-hover:grid-rows-[1fr] transition-all duration-500 ease-in-out mt-2">
                            <div class="overflow-hidden opacity-0 group-hover:opacity-100 transition-opacity duration-500 delay-100">

                                <p class="pt-2 text-[13px] leading-relaxed text-gray-100 font-sans line-clamp-4 lg:line-clamp-5 mb-4">
                                    {{ $noticia->resumo ?? Str::limit(strip_tags($noticia->conteudo), 160) }}
                                </p>

                                <div class="flex items-center justify-between border-t border-white/20 pt-4">
                                    <span class="text-[10px] font-bold text-yellow-400 uppercase tracking-widest drop-shadow-sm flex items-center gap-1">
                                        Ler mais <i class="fas fa-arrow-right text-[8px]"></i>
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
            @empty
            <div class="flex flex-col items-center justify-center gap-4 p-12 text-center border-2 border-gray-200 border-dashed bg-gray-50 rounded-2xl col-span-full">
                <svg class="w-12 h-12 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10l4 4v10a2 2 0 01-2 2z" />
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12h6M9 16h4" />
                </svg>
                <div>
                    <p class="text-base font-bold text-gray-500 font-heading">Nenhuma notícia encontrada</p>
                    <p class="mt-1 text-sm text-gray-400">
                        @if(request('q'))
                        Tente procurar por outro termo.
                        @else
                        Nenhuma notícia publicada no momento.
                        @endif
                    </p>
                </div>
            </div>
            @endforelse
        </div>

        {{-- Paginação --}}
        <div class="mt-12">
            {{ $noticias->appends(request()->query())->links('components.pagination.agenda-style') }}
        </div>

    </div>
</main>
@endsection