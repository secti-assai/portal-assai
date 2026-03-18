@extends('layouts.app')

@section('title', $noticia->titulo . ' - Prefeitura Municipal de Assaí')

@section('meta_tags')
    <meta property="og:type" content="article" />
    <meta property="og:title" content="{{ $noticia->titulo }}" />
    <meta property="og:description" content="{{ $noticia->resumo ?? Str::limit(strip_tags($noticia->conteudo), 150) }}" />
    <meta property="og:url" content="{{ url()->current() }}" />
    
    @if($noticia->imagem_capa)
        <meta property="og:image" content="{{ asset('storage/' . $noticia->imagem_capa) }}" />
    @else
        <meta property="og:image" content="{{ asset('img/Assaí.jpg') }}" />
    @endif
    
    <meta name="twitter:card" content="summary_large_image">
@endsection

@section('content')

<main id="conteudo-principal" accesskey="1" tabindex="-1" class="flex flex-col min-h-screen bg-gray-50 pt-8 max-[360px]:pt-6 pb-16">
    <div class="container px-4 py-10 max-[360px]:py-7 mx-auto max-w-5xl font-sans">

        {{-- Breadcrumb --}}
        <x-breadcrumb :items="[
            ['name' => 'Início', 'url' => route('home')],
            ['name' => 'Notícias', 'url' => route('noticias.index')],
            ['name' => $noticia->titulo],
        ]" />

        <article class="p-8 max-[360px]:p-5 md:p-12 bg-white border border-gray-100 shadow-md hover:shadow-xl transition-all duration-300 rounded-[2rem]">

            {{-- Header --}}
            <header class="mb-8">
                <div class="flex flex-wrap items-center gap-3 mb-5">
                    <span class="px-3 py-1 text-xs font-bold text-blue-900 uppercase bg-yellow-400 rounded-md tracking-wider">
                        {{ $noticia->categoria }}
                    </span>
                    <span class="text-sm text-gray-500">
                        Publicado em {{ \Carbon\Carbon::parse($noticia->data_publicacao)->translatedFormat('d \d\e F \d\e Y') }}
                    </span>
                </div>

                <h1 class="text-3xl max-[360px]:text-2xl font-black leading-tight text-blue-900 md:text-4xl font-heading mb-4 break-words">
                    {{ $noticia->titulo }}
                </h1>

                @if($noticia->resumo)
                    <p class="text-lg max-[360px]:text-base text-gray-600 font-medium leading-relaxed border-l-4 border-yellow-400 pl-4">
                        {{ $noticia->resumo }}
                    </p>
                @endif

                {{-- Barra de Compartilhamento --}}
                <div class="flex flex-wrap items-center gap-2 mt-6 pt-5 border-t border-gray-100">
                    <span class="text-xs font-bold text-gray-400 uppercase tracking-widest mr-1">Compartilhar:</span>

                          <a href="https://api.whatsapp.com/send?text={{ urlencode($noticia->titulo . ' — ' . url()->current()) }}"
                              target="_blank" rel="noopener noreferrer"
                       class="inline-flex items-center gap-1.5 px-3 py-1.5 text-xs font-bold text-green-700 bg-green-50 rounded-full hover:bg-green-100 transition">
                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347z"/>
                            <path d="M12.004 2C6.477 2 2 6.477 2 12.004c0 1.77.46 3.432 1.268 4.876L2 22l5.27-1.25A9.953 9.953 0 0012.004 22C17.53 22 22 17.523 22 12.004 22 6.477 17.53 2 12.004 2zm0 18.15a8.117 8.117 0 01-4.136-1.131l-.297-.176-3.128.74.77-3.055-.196-.314A8.112 8.112 0 013.85 12.004c0-4.499 3.657-8.154 8.154-8.154 4.498 0 8.154 3.655 8.154 8.154 0 4.498-3.656 8.146-8.154 8.146z"/>
                        </svg>
                        WhatsApp
                    </a>

                          <a href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode(url()->current()) }}"
                              target="_blank" rel="noopener noreferrer"
                       class="inline-flex items-center gap-1.5 px-3 py-1.5 text-xs font-bold text-blue-700 bg-blue-50 rounded-full hover:bg-blue-100 transition">
                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/>
                        </svg>
                        Facebook
                    </a>

                    <button onclick="navigator.clipboard.writeText(window.location.href).then(()=>{ this.textContent='✓ Link copiado!'; setTimeout(()=>{ this.innerHTML='<svg class=\'w-4 h-4\' fill=\'none\' stroke=\'currentColor\' viewBox=\'0 0 24 24\'><path stroke-linecap=\'round\' stroke-linejoin=\'round\' stroke-width=\'2\' d=\'M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z\'></path></svg> Copiar link'; },2000) })"
                       class="inline-flex items-center gap-1.5 px-3 py-1.5 text-xs font-bold text-gray-600 bg-gray-100 rounded-full hover:bg-gray-200 transition cursor-pointer">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z"></path></svg>
                        Copiar link
                    </button>
                </div>
            </header>

            {{-- Imagem de Capa --}}
            @if($noticia->imagem_capa)
                <figure class="mb-10">
                    <img src="{{ asset('storage/' . $noticia->imagem_capa) }}"
                         alt="{{ $noticia->titulo }}"
                         class="w-full max-h-[480px] object-cover rounded-2xl shadow-md" loading="lazy" decoding="async">
                </figure>
            @endif

            {{-- Conteúdo Editorial --}}
            <div class="editor-content">
                {!! $noticia->conteudo !!}
            </div>

            {{-- Rodapé do artigo --}}
            <div class="mt-12 pt-6 border-t border-gray-100 flex items-center justify-between flex-wrap gap-4">
                <a href="{{ route('noticias.index') }}"
                   class="inline-flex items-center gap-2 px-4 py-2 text-sm font-semibold text-gray-600 bg-gray-100 rounded-lg hover:bg-gray-200 transition">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
                    Voltar às notícias
                </a>
                <a href="{{ route('home') }}"
                   class="inline-flex items-center gap-2 px-4 py-2 text-sm font-semibold text-blue-700 bg-blue-50 rounded-lg hover:bg-blue-100 transition">
                    Página inicial
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7m-9 5v6h4v-6m-4 0H9m6 0h-2"/></svg>
                </a>
            </div>

        </article>
    </div>
</main>
@endsection