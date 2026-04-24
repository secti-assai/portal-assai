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
<meta property="og:image" content="{{ asset('img/Assai.jpg') }}" />
@endif

<meta name="twitter:card" content="summary_large_image">
@endsection

@section('content')

<main id="conteudo-principal" accesskey="1" tabindex="-1" class="flex flex-col min-h-screen bg-white pt-[96px] lg:pt-[160px] pb-20" x-data="{ openImage: false }">
    <div class="container px-4 py-8 max-[360px]:py-5 mx-auto max-w-4xl font-sans">

        {{-- Breadcrumb --}}
        <x-breadcrumb :items="[
            ['name' => 'Início', 'url' => route('home')],
            ['name' => 'Notícias', 'url' => route('noticias.index')],
            ['name' => 'Artigo'],
        ]" />

        <article class="mt-8">

            {{-- Header da Notícia --}}
            <header class="mb-10 text-center md:text-left">
                <div class="flex flex-wrap items-center justify-center md:justify-start gap-3 mb-5">
                    <span class="px-3 py-1 text-[10px] font-bold text-blue-900 uppercase bg-yellow-400 rounded-md tracking-widest shadow-sm">
                        {{ $noticia->categoria }}
                    </span>
                    <span class="text-xs font-semibold text-gray-500 uppercase tracking-wider">
                        Publicado em {{ \Carbon\Carbon::parse($noticia->data_publicacao)->translatedFormat('d \d\e F \d\e Y') }}
                    </span>
                </div>

                <h1 class="text-3xl max-[360px]:text-2xl font-black leading-tight text-blue-900 md:text-5xl font-heading mb-6 break-words">
                    {{ $noticia->titulo }}
                </h1>

                @if($noticia->resumo)
                <p class="text-lg max-[360px]:text-base text-gray-600 font-medium italic leading-relaxed border-l-4 border-yellow-400 pl-4 md:pl-6 text-left">
                    {{ $noticia->resumo }}
                </p>
                @endif
            </header>

            {{-- Barra de Compartilhamento --}}
            <div class="flex flex-wrap items-center justify-center md:justify-start gap-2 mb-10 pb-6 border-b border-gray-100">
                <span class="text-[10px] font-bold text-gray-400 uppercase tracking-widest mr-2">Compartilhar:</span>

                <a href="https://api.whatsapp.com/send?text={{ urlencode($noticia->titulo . ' — ' . url()->current()) }}"
                    target="_blank" rel="noopener noreferrer"
                    class="inline-flex items-center gap-1.5 px-4 py-2 text-xs font-bold text-white bg-green-600 rounded-full hover:bg-green-700 hover:-translate-y-0.5 transition-all shadow-sm">
                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347z" />
                        <path d="M12.004 2C6.477 2 2 6.477 2 12.004c0 1.77.46 3.432 1.268 4.876L2 22l5.27-1.25A9.953 9.953 0 0012.004 22C17.53 22 22 17.523 22 12.004 22 6.477 17.53 2 12.004 2zm0 18.15a8.117 8.117 0 01-4.136-1.131l-.297-.176-3.128.74.77-3.055-.196-.314A8.112 8.112 0 013.85 12.004c0-4.499 3.657-8.154 8.154-8.154 4.498 0 8.154 3.655 8.154 8.154 0 4.498-3.656 8.146-8.154 8.146z" />
                    </svg>
                    WhatsApp
                </a>

                <a href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode(url()->current()) }}"
                    target="_blank" rel="noopener noreferrer"
                    class="inline-flex items-center gap-1.5 px-4 py-2 text-xs font-bold text-white bg-blue-600 rounded-full hover:bg-blue-700 hover:-translate-y-0.5 transition-all shadow-sm">
                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z" />
                    </svg>
                    Facebook
                </a>

                <button onclick="copyToClipboard('{{ url()->current() }}', 'Link copiado! Compartilhe no seu Instagram!')"
                    class="inline-flex items-center gap-1.5 px-4 py-2 text-xs font-bold text-white bg-gradient-to-tr from-[#f9ce34] via-[#ee2a7b] to-[#6228d7] rounded-full hover:opacity-90 hover:-translate-y-0.5 transition-all shadow-sm">
                    <i class="fa-brands fa-instagram text-base"></i>
                    Instagram
                </button>

                <button onclick="navigator.clipboard.writeText(window.location.href).then(()=>{ this.textContent='✓ Link copiado!'; setTimeout(()=>{ this.innerHTML='<svg class=\'w-4 h-4\' fill=\'none\' stroke=\'currentColor\' viewBox=\'0 0 24 24\'><path stroke-linecap=\'round\' stroke-linejoin=\'round\' stroke-width=\'2\' d=\'M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z\'></path></svg> Copiar'; },2000) })"
                    class="inline-flex items-center gap-1.5 px-4 py-2 text-xs font-bold text-gray-700 bg-gray-100 rounded-full hover:bg-gray-200 transition cursor-pointer border border-gray-200">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z"></path>
                    </svg>
                    Copiar
                </button>
            </div>

            {{-- Imagem de Capa Clicável --}}
            @if($noticia->imagem_capa)
            <div class="mb-10 flex justify-center">
                <figure
                    @click="openImage = true"
                    class="w-full max-w-3xl bg-slate-50 rounded-2xl overflow-hidden border border-slate-100 shadow-sm transition-all hover:shadow-md cursor-zoom-in group relative"
                    title="Clique para ampliar">
                    <img src="{{ asset('storage/' . $noticia->imagem_capa) }}"
                        alt="{{ $noticia->titulo }}"
                        class="w-full h-auto max-h-[300px] md:max-h-[450px] object-contain mx-auto transition-transform duration-500 group-hover:scale-[1.02]"
                        loading="lazy" decoding="async">

                    {{-- Ícone visual de ampliação no hover --}}
                    <div class="absolute inset-0 bg-black/5 opacity-0 group-hover:opacity-100 transition-opacity flex items-center justify-center">
                        <div class="bg-white/90 p-3 rounded-full shadow-lg">
                            <svg class="w-6 h-6 text-blue-900" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0zM10 7v3m0 0v3m0-3h3m-3 0H7"></path>
                            </svg>
                        </div>
                    </div>
                </figure>
            </div>
            @endif

            {{-- Conteúdo Editorial --}}
            <div class="editor-content prose prose-slate prose-lg max-w-none text-gray-700">
                {!! $noticia->conteudo !!}
            </div>

            {{-- Rodapé do artigo --}}
            <div class="mt-16 pt-8 border-t border-gray-200 flex flex-col sm:flex-row items-center justify-between gap-4">
                <a href="{{ route('noticias.index') }}"
                    class="inline-flex items-center justify-center w-full sm:w-auto gap-2 px-6 py-3 text-sm font-bold text-gray-600 bg-white border border-gray-300 rounded-full hover:bg-gray-50 transition">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                    </svg>
                    Voltar às notícias
                </a>

                <a href="{{ route('home') }}"
                    class="inline-flex items-center justify-center w-full sm:w-auto gap-2 px-6 py-3 text-sm font-bold text-white bg-blue-800 rounded-full hover:bg-blue-900 shadow-md hover:-translate-y-0.5 transition">
                    Página inicial
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7m-9 5v6h4v-6m-4 0H9m6 0h-2" />
                    </svg>
                </a>
            </div>

            {{-- Widget Feedback --}}
            <div class="mt-20 p-8 bg-slate-50 rounded-3xl border border-slate-100 text-center" x-data="{ feedbackSent: false }">
                <div x-show="!feedbackSent">
                    <h3 class="text-xl font-bold text-slate-800 mb-2">Esta página foi útil?</h3>
                    <p class="text-sm text-slate-500 mb-6">Sua opinião é importante para melhorarmos nosso portal.</p>
                    <div class="flex items-center justify-center gap-4">
                        <button @click="feedbackSent = true" class="flex items-center gap-2 px-6 py-2 bg-white border border-slate-200 rounded-full text-sm font-bold text-slate-700 hover:border-blue-500 hover:text-blue-600 transition shadow-sm">
                            <i class="fa-regular fa-thumbs-up text-blue-500"></i> Sim
                        </button>
                        <button @click="feedbackSent = true" class="flex items-center gap-2 px-6 py-2 bg-white border border-slate-200 rounded-full text-sm font-bold text-slate-700 hover:border-red-500 hover:text-red-600 transition shadow-sm">
                            <i class="fa-regular fa-thumbs-down text-red-500"></i> Não
                        </button>
                    </div>
                </div>
                <div x-show="feedbackSent" x-cloak class="animate-bounce">
                    <i class="fa-solid fa-circle-check text-green-500 text-3xl mb-3"></i>
                    <h3 class="text-lg font-bold text-slate-800">Obrigado pelo seu feedback!</h3>
                </div>
            </div>

            {{-- Notícias Relacionadas --}}
            @if(isset($relacionadas) && $relacionadas->count() > 0)
            <div class="mt-24">
                <div class="flex items-center gap-3 mb-10">
                    <div class="w-2 h-8 bg-blue-900 rounded-full"></div>
                    <h2 class="text-2xl font-black text-blue-900 uppercase tracking-tight" style="font-family: 'Montserrat', sans-serif;">Notícias Relacionadas</h2>
                </div>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                    @foreach($relacionadas as $rel)
                    <article class="flex flex-col bg-white rounded-2xl overflow-hidden border border-slate-100 shadow-sm hover:shadow-md transition-all group">
                        <a href="{{ route('noticias.show', $rel->slug) }}" class="block h-40 overflow-hidden">
                            <img src="{{ $rel->imagem_capa ? asset('storage/' . $rel->imagem_capa) : asset('img/Assai.jpg') }}" 
                                 class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-105" 
                                 alt="{{ $rel->titulo }}">
                        </a>
                        <div class="p-5 flex-1 flex flex-col">
                            <h4 class="text-base font-bold text-slate-800 leading-snug mb-4 group-hover:text-blue-700 transition-colors line-clamp-3">{{ $rel->titulo }}</h4>
                            <div class="mt-auto text-[10px] text-slate-400 font-bold uppercase tracking-wide">
                                {{ \Carbon\Carbon::parse($rel->data_publicacao)->format('d/m/Y') }}
                            </div>
                        </div>
                    </article>
                    @endforeach
                </div>
            </div>
            @endif

        </article>
    </div>

    {{-- Modal Lightbox para Imagem Cheia (Fecha ao clicar fora) --}}
    <div
        x-show="openImage"
        x-transition:enter="transition ease-out duration-300"
        x-transition:enter-start="opacity-0"
        x-transition:enter-end="opacity-100"
        x-transition:leave="transition ease-in duration-200"
        x-transition:leave-start="opacity-100"
        x-transition:leave-end="opacity-0"
        @keydown.escape.window="openImage = false"

        {{-- O SEGREDO ESTÁ AQUI: @click.self fecha o modal apenas se clicar no fundo --}}
        @click.self="openImage = false"

        class="fixed inset-0 z-[200] flex items-center justify-center p-4 bg-slate-950/95 backdrop-blur-sm cursor-pointer"
        style="display: none;">
        {{-- Botão Fechar (Opcional, mas bom manter para acessibilidade) --}}
        <button @click="openImage = false" class="absolute top-6 right-6 text-white/50 hover:text-yellow-400 transition-colors z-[210] p-2 bg-white/5 hover:bg-white/10 rounded-full">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M6 18L18 6M6 6l12 12"></path>
            </svg>
        </button>

        {{-- Imagem em Tamanho Real --}}
        <div class="relative max-w-5xl max-h-[90vh] flex items-center justify-center pointer-events-none">
            <img
                src="{{ asset('storage/' . $noticia->imagem_capa) }}"
                class="max-w-full max-h-full object-contain shadow-2xl rounded-lg pointer-events-auto cursor-default"
                alt="Imagem ampliada">
        </div>
    </div>
</main>
@endsection