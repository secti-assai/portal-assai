@extends('layouts.app')

@section('title', 'Notícias - Prefeitura Municipal de Assaí')

@section('content')
<main id="conteudo-principal" accesskey="1" tabindex="-1" class="flex flex-col min-h-screen pt-8 pb-16 bg-gray-50">
    <div class="container max-w-6xl px-4 mx-auto font-sans">

        {{-- Breadcrumb --}}
        <x-breadcrumb :items="[
            ['name' => 'Início', 'url' => route('home')],
            ['name' => 'Notícias'],
        ]" />

        {{-- Header --}}
        <div class="mb-8 text-center md:text-left">
            <h1 class="text-3xl font-black text-blue-900 md:text-4xl font-heading leading-tight">
                Últimas Notícias
            </h1>
            <p class="mt-1 text-sm text-gray-500">Fique por dentro de tudo que acontece em Assaí.</p>
        </div>

        {{-- Barra de Busca --}}
        <form action="{{ route('noticias.index') }}" method="GET" class="mb-6">
            @if(request('categoria'))
                <input type="hidden" name="categoria" value="{{ request('categoria') }}">
            @endif
            <div class="flex items-center w-full bg-white border border-gray-200 rounded-2xl shadow-md overflow-hidden focus-within:border-blue-500 focus-within:ring-2 focus-within:ring-blue-100 transition">
                <span class="pl-5 pr-3 text-gray-400 shrink-0">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                    </svg>
                </span>
                <input
                    type="text"
                    name="q"
                    value="{{ request('q') }}"
                    placeholder="Busque por título, tema ou palavra-chave..."
                    class="flex-1 py-4 text-sm text-gray-700 bg-transparent outline-none focus:outline-none focus:ring-0 border-transparent focus:border-transparent placeholder-gray-400"
                >
                <button type="submit" class="m-2 px-6 py-2.5 text-sm font-bold text-white bg-blue-700 rounded-xl hover:bg-blue-800 transition shrink-0">
                    Buscar
                </button>
            </div>
        </form>

        {{-- Filtros por Pills --}}
        <div class="mb-10 -mx-4 px-4">
            <div class="flex items-center gap-2 overflow-x-auto flex-nowrap pb-2 scrollbar-hide">
                <a
                    href="{{ route('noticias.index', array_filter(['q' => request('q')])) }}"
                    class="shrink-0 px-4 py-1.5 text-xs font-bold rounded-full transition whitespace-nowrap
                        {{ !request('categoria') ? 'bg-blue-700 text-white shadow-md' : 'bg-gray-100 text-gray-600 hover:bg-gray-200' }}"
                >
                    Todas
                </a>
                @foreach($categorias as $cat)
                    <a
                        href="{{ route('noticias.index', array_filter(['categoria' => $cat, 'q' => request('q')])) }}"
                        class="shrink-0 px-4 py-1.5 text-xs font-bold rounded-full transition whitespace-nowrap
                            {{ request('categoria') === $cat ? 'bg-blue-700 text-white shadow-md' : 'bg-gray-100 text-gray-600 hover:bg-gray-200' }}"
                    >
                        {{ $cat }}
                    </a>
                @endforeach
            </div>
        </div>

        {{-- Grid de Notícias --}}
        <div class="grid grid-cols-1 gap-6 md:grid-cols-2 lg:grid-cols-3">
            @forelse($noticias as $noticia)

                @if($loop->first)
                    {{-- Manchete / Notícia Destaque --}}
                    <article class="flex flex-col overflow-hidden transition-shadow duration-300 bg-white border border-gray-100 cursor-pointer rounded-3xl shadow-sm group hover:shadow-xl md:col-span-2 lg:col-span-2">
                        <a href="{{ route('noticias.show', $noticia->slug) }}" class="flex flex-col h-full">
                            <div class="relative overflow-hidden bg-gray-200 h-64 md:h-80 shrink-0">
                                <span class="absolute z-10 px-3 py-1 text-xs font-bold tracking-wider text-blue-900 uppercase bg-yellow-400 rounded-md shadow top-4 left-4">
                                    {{ $noticia->categoria }}
                                </span>
                                <span class="absolute z-10 px-3 py-1 text-xs font-bold tracking-wider text-white uppercase bg-blue-700 rounded-md shadow top-4 right-4">
                                    Destaque
                                </span>
                                @if($noticia->imagem_capa)
                                    <img src="{{ asset('storage/' . $noticia->imagem_capa) }}" alt="{{ $noticia->titulo }}" class="object-cover w-full h-full transition duration-700 ease-in-out group-hover:scale-105" loading="lazy" decoding="async">
                                @else
                                    <img src="{{ asset('img/Assaí.jpg') }}" alt="Prefeitura de Assaí" class="object-cover w-full h-full transition duration-700 ease-in-out opacity-80 group-hover:scale-105" loading="lazy" decoding="async">
                                @endif
                                <div class="absolute inset-0 bg-gradient-to-t from-black/50 to-transparent"></div>
                            </div>
                            <div class="flex flex-col flex-1 p-6">
                                <div class="mb-3 text-xs font-bold tracking-widest text-blue-500 uppercase">
                                    {{ \Carbon\Carbon::parse($noticia->data_publicacao)->translatedFormat('d \d\e F \d\e Y') }}
                                </div>
                                <h2 class="mb-3 text-2xl font-black leading-tight text-gray-900 transition duration-200 font-heading group-hover:text-blue-700 md:text-3xl">
                                    {{ $noticia->titulo }}
                                </h2>
                                <p class="mt-auto text-sm leading-relaxed text-gray-600 line-clamp-3">
                                    {{ $noticia->resumo ?? Str::limit(strip_tags($noticia->conteudo), 160) }}
                                </p>
                                <span class="inline-flex items-center gap-1 mt-4 text-sm font-bold text-blue-600 group-hover:text-blue-800 transition">
                                    Ler matéria completa
                                    <svg class="w-4 h-4 transition-transform group-hover:translate-x-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                                </span>
                            </div>
                        </a>
                    </article>
                @else
                    {{-- Cards normais --}}
                    <article class="flex flex-col overflow-hidden transition-shadow duration-300 bg-white border border-gray-100 cursor-pointer rounded-3xl shadow-sm group hover:shadow-lg">
                        <a href="{{ route('noticias.show', $noticia->slug) }}" class="flex flex-col flex-1 h-full">
                            <div class="relative overflow-hidden bg-gray-200 h-48 shrink-0">
                                <span class="absolute z-10 px-2.5 py-1 text-xs font-bold tracking-wider text-blue-900 uppercase bg-yellow-400 rounded-md shadow top-3 left-3">
                                    {{ $noticia->categoria }}
                                </span>
                                @if($noticia->imagem_capa)
                                    <img src="{{ asset('storage/' . $noticia->imagem_capa) }}" alt="{{ $noticia->titulo }}" class="object-cover w-full h-full transition duration-500 ease-in-out group-hover:scale-105" loading="lazy" decoding="async">
                                @else
                                    <img src="{{ asset('img/Assaí.jpg') }}" alt="Prefeitura de Assaí" class="object-cover w-full h-full transition duration-500 ease-in-out opacity-80 group-hover:scale-105" loading="lazy" decoding="async">
                                @endif
                            </div>
                            <div class="flex flex-col flex-1 p-5">
                                <div class="mb-2 text-xs font-bold tracking-widest text-blue-500 uppercase">
                                    {{ \Carbon\Carbon::parse($noticia->data_publicacao)->translatedFormat('d \d\e F \d\e Y') }}
                                </div>
                                <h3 class="mb-2 text-base font-bold leading-snug text-gray-900 transition duration-200 font-heading group-hover:text-blue-700">
                                    {{ $noticia->titulo }}
                                </h3>
                                <p class="mt-auto text-sm text-gray-500 line-clamp-2">
                                    {{ $noticia->resumo ?? Str::limit(strip_tags($noticia->conteudo), 100) }}
                                </p>
                                <span class="inline-flex items-center gap-1 mt-4 text-xs font-bold text-blue-500 group-hover:text-blue-700 transition">
                                    Ler mais
                                    <svg class="w-3.5 h-3.5 transition-transform group-hover:translate-x-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                                </span>
                            </div>
                        </a>
                    </article>
                @endif

            @empty
                <div class="flex flex-col items-center justify-center gap-4 p-12 text-center border-2 border-gray-200 border-dashed bg-white col-span-full rounded-3xl">
                    <svg class="w-16 h-16 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10l4 4v10a2 2 0 01-2 2z"/>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12h6M9 16h4"/>
                    </svg>
                    <div>
                        <p class="text-base font-bold text-gray-500 font-heading">Nenhuma notícia encontrada</p>
                        <p class="mt-1 text-sm text-gray-400">
                            @if(request('q'))
                                Tente buscar por outro termo ou <a href="{{ route('noticias.index') }}" class="text-blue-500 hover:underline">veja todas as notícias</a>.
                            @else
                                Nenhuma notícia publicada no momento. Volte em breve!
                            @endif
                        </p>
                    </div>
                </div>
            @endforelse
        </div>

        {{-- Paginação --}}
        <div class="mt-12">
            {{ $noticias->appends(request()->query())->links() }}
        </div>

    </div>
</main>
@endsection