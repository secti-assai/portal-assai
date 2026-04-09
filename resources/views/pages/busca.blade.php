@extends('layouts.app')

@section('title', 'Resultados da Busca: ' . ($termo ?? 'Pesquisa') . ' - Prefeitura Municipal de Assaí')

@section('meta_tags')
<link rel="icon" type="image/png" sizes="32x32" href="{{ asset('img/brasao.png') }}?v=3-busca">
<link rel="icon" type="image/png" sizes="192x192" href="{{ asset('img/brasao.png') }}?v=3-busca">
<link rel="shortcut icon" href="{{ asset('img/brasao.png') }}?v=3-busca">
<link rel="apple-touch-icon" href="{{ asset('img/brasao.png') }}?v=3-busca">
<script>
    (function () {
        var href = "{{ asset('img/brasao.png') }}?v=3-busca";
        var links = document.querySelectorAll('link[rel="icon"], link[rel="shortcut icon"], link[rel="apple-touch-icon"]');
        links.forEach(function (el) { el.parentNode.removeChild(el); });

        ['icon', 'shortcut icon', 'apple-touch-icon'].forEach(function (rel) {
            var link = document.createElement('link');
            link.setAttribute('rel', rel);
            link.setAttribute('href', href);
            if (rel === 'icon') {
                link.setAttribute('type', 'image/png');
            }
            document.head.appendChild(link);
        });
    })();
</script>
@endsection

@section('content')
<main id="conteudo-principal" accesskey="1" tabindex="-1" class="min-h-screen bg-gradient-to-b from-slate-100 via-blue-50/50 to-slate-100 pb-20 font-sans">

    {{-- =================
         HERO SECTION (Busca - Padrão Gov.br)
         ================= --}}
    <section class="bg-[#071D41] pt-32 pb-20 sm:pt-36 md:pt-44 md:pb-28 relative overflow-hidden border-b-4 border-[#FFCD00]">
        {{-- Efeito de Fundo --}}
        <div class="absolute inset-0 opacity-10 pointer-events-none">
            <svg class="w-full h-full" fill="currentColor" viewBox="0 0 100 100" preserveAspectRatio="none">
                <path d="M0 100 C 20 0 50 0 100 100 Z"></path>
            </svg>
        </div>

        <div class="container px-4 mx-auto max-w-5xl relative z-10 text-center md:text-left">
            <div class="flex justify-center md:justify-start mb-6">
                <x-breadcrumb :items="[
                    ['name' => 'Início', 'url' => route('home')],
                    ['name' => 'Busca no Portal'],
                ]" dark />
            </div>

            <h1 class="text-3xl md:text-5xl font-black text-white font-heading mb-8 leading-tight tracking-tight drop-shadow-md">
                @if($termo)
                Resultados para: <span class="text-[#FFCD00]">"{{ $termo }}"</span>
                @else
                O que você está procurando?
                @endif
            </h1>

            {{-- Barra de Busca --}}
            <div class="w-full max-w-3xl mx-auto md:mx-0">
                <form action="{{ route('busca.index') }}" method="GET" onsubmit="return this.q.value.trim() !== ''" class="relative flex items-center w-full bg-white focus-within:ring-4 focus-within:ring-[#FFCD00]/50 shadow-2xl rounded-full transition-all duration-300 p-1 md:p-1.5" role="search" aria-label="Buscar informações no portal">
                    <label for="campo-busca-portal" class="sr-only">Pesquisar no portal</label>

                    <div class="flex items-center justify-center pl-4 md:pl-5 pr-2 text-blue-900 shrink-0 hidden sm:flex" aria-hidden="true">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                        </svg>
                    </div>

                    <input id="campo-busca-portal" type="text" name="q" value="{{ $termo }}" placeholder="Digite termo, serviço ou notícia..." required
                        class="flex-1 min-w-0 px-4 py-3 text-sm sm:text-base text-slate-800 bg-transparent border-none focus:ring-0 focus:outline-none font-sans placeholder:text-slate-400 w-full"
                        autofocus>

                    <button type="submit" class="m-1 px-5 py-3 sm:px-8 sm:py-3.5 font-bold text-sm sm:text-base text-[#071D41] transition-all bg-[#FFCD00] rounded-full shrink-0 hover:bg-yellow-500 hover:shadow-lg focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-[#FFCD00] font-heading uppercase tracking-wide">
                        Buscar
                    </button>
                </form>
            </div>
        </div>
    </section>

    {{-- =================
         SISTEMA DE RESULTADOS E ABAS
         ================= --}}
    <div id="resultados-busca" class="container px-4 mx-auto max-w-5xl -mt-10 sm:-mt-12 pt-0 relative z-20">

        {{-- Filtros de conteúdo (mobile-first) --}}
        <div class="mb-10 sm:mb-12">
            @php
            $totalResults = $noticias->count() + $servicos->count() + $eventos->count() + $programas->count() + $secretarias->count();
            $tabBaseClass = 'tab-btn group flex w-full items-center justify-between gap-2 rounded-2xl border border-slate-200 bg-white px-4 py-3 text-left text-sm font-bold text-slate-700 shadow-sm transition-all hover:-translate-y-0.5 hover:border-slate-300 hover:shadow-md focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-[#FFCD00] focus-visible:ring-offset-1 sm:w-auto sm:min-w-[155px] sm:justify-center sm:rounded-full sm:px-5 sm:py-2.5';
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

                .tab-btn.is-active .tab-count {
                    background: rgba(255, 255, 255, 0.2);
                    color: #fff;
                }
            </style>

            <nav aria-label="Filtrar categorias de busca" class="w-full rounded-2xl border border-blue-100 bg-white/95 backdrop-blur-sm p-3 shadow-lg shadow-blue-100/70 sm:rounded-3xl sm:p-4">
                <p class="mb-3 px-1 text-[11px] font-black uppercase tracking-[0.18em] text-slate-500 sm:mb-4">Filtrar resultados por tipo</p>

                <ul role="tablist" aria-label="Categorias de resultados" class="grid grid-cols-2 gap-2.5 sm:flex sm:flex-wrap sm:items-center sm:justify-center sm:gap-3">
                    <li>
                        <button id="tab-all" type="button" role="tab" onclick="filterResults('all')" data-target="all" aria-selected="true" aria-controls="resultados-busca"
                            class="{{ $tabBaseClass }} is-active">
                            Tudo
                            <span class="tab-count inline-flex min-w-7 items-center justify-center rounded-full px-2 py-0.5 text-[11px] font-black transition-colors">{{ $totalResults }}</span>
                        </button>
                    </li>

                    @if($noticias->isNotEmpty())
                    <li>
                        <button id="tab-noticias" type="button" role="tab" onclick="filterResults('noticias')" data-target="noticias" aria-selected="false" aria-controls="sec-noticias"
                            class="{{ $tabBaseClass }}">
                            Notícias
                            <span class="tab-count inline-flex min-w-7 items-center justify-center rounded-full px-2 py-0.5 text-[11px] font-black transition-colors">{{ $noticias->count() }}</span>
                        </button>
                    </li>
                    @endif

                    @if($servicos->isNotEmpty())
                    <li>
                        <button id="tab-servicos" type="button" role="tab" onclick="filterResults('servicos')" data-target="servicos" aria-selected="false" aria-controls="sec-servicos"
                            class="{{ $tabBaseClass }}">
                            Serviços
                            <span class="tab-count inline-flex min-w-7 items-center justify-center rounded-full px-2 py-0.5 text-[11px] font-black transition-colors">{{ $servicos->count() }}</span>
                        </button>
                    </li>
                    @endif

                    @if($eventos->isNotEmpty())
                    <li>
                        <button id="tab-eventos" type="button" role="tab" onclick="filterResults('eventos')" data-target="eventos" aria-selected="false" aria-controls="sec-eventos"
                            class="{{ $tabBaseClass }}">
                            Eventos
                            <span class="tab-count inline-flex min-w-7 items-center justify-center rounded-full px-2 py-0.5 text-[11px] font-black transition-colors">{{ $eventos->count() }}</span>
                        </button>
                    </li>
                    @endif

                    @if($programas->isNotEmpty())
                    <li>
                        <button id="tab-programas" type="button" role="tab" onclick="filterResults('programas')" data-target="programas" aria-selected="false" aria-controls="sec-programas"
                            class="{{ $tabBaseClass }}">
                            Programas
                            <span class="tab-count inline-flex min-w-7 items-center justify-center rounded-full px-2 py-0.5 text-[11px] font-black transition-colors">{{ $programas->count() }}</span>
                        </button>
                    </li>
                    @endif

                    @if($secretarias->isNotEmpty())
                    <li>
                        <button id="tab-secretarias" type="button" role="tab" onclick="filterResults('secretarias')" data-target="secretarias" aria-selected="false" aria-controls="sec-secretarias"
                            class="{{ $tabBaseClass }}">
                            Secretarias
                            <span class="tab-count inline-flex min-w-7 items-center justify-center rounded-full px-2 py-0.5 text-[11px] font-black transition-colors">{{ $secretarias->count() }}</span>
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
    @elseif($totalResults === 0)
    <div class="text-center py-24 bg-white rounded-3xl shadow-sm border border-slate-200 px-4">
        <div class="w-24 h-24 bg-slate-50 rounded-full flex items-center justify-center mx-auto mb-6 border border-slate-100">
            <svg class="w-12 h-12 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0zM10 14v-4m0 0V6m0 4h4m-4 0H6"></path>
            </svg>
        </div>
        <h3 class="text-2xl md:text-3xl font-black text-blue-900 font-heading mb-3">Nenhum resultado encontrado</h3>
        <p class="text-slate-600 max-w-md mx-auto mb-8">Não encontramos informações para <strong class="text-slate-800">"{{ $termo }}"</strong>. Tente utilizar termos mais genéricos ou verifique a ortografia.</p>
        <a href="{{ route('home') }}" class="inline-flex items-center px-8 py-3.5 font-bold text-sm text-white uppercase tracking-wider bg-[#071D41] rounded-full hover:bg-blue-800 hover:-translate-y-0.5 transition-all focus:ring-2 focus:ring-offset-2 focus:ring-[#FFCD00]">
            Voltar à Página Inicial
        </a>
    </div>
    @else

    {{-- 1. Resultados: Notícias --}}
    @if($noticias->isNotEmpty())
    <section id="sec-noticias" role="tabpanel" aria-labelledby="tab-noticias" class="result-section mb-14">
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

    {{-- 2. Resultados: Serviços --}}
    @if($servicos->isNotEmpty())
    <section id="sec-servicos" role="tabpanel" aria-labelledby="tab-servicos" class="result-section mb-14">
        <div class="flex items-center gap-3 mb-8">
            <div class="w-2 h-8 bg-emerald-500 rounded-sm"></div>
            <h2 class="text-2xl font-black text-[#071D41] font-heading uppercase tracking-tight">Serviços</h2>
        </div>
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4 md:gap-5">
            @foreach($servicos as $servico)
            <a href="{{ $servico->url_acesso ?? $servico->link ?? '#' }}" target="_blank" rel="noopener noreferrer" class="flex items-center p-5 bg-white border border-slate-200 rounded-2xl shadow-sm hover:border-emerald-500 hover:shadow-md transition-all duration-300 group outline-none focus-visible:ring-4 focus-visible:ring-emerald-400">
                <div class="w-12 h-12 flex items-center justify-center bg-slate-50 text-emerald-600 rounded-xl mr-4 group-hover:bg-emerald-500 group-hover:text-white transition-colors shrink-0 border border-slate-100 group-hover:border-transparent">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z" />
                    </svg>
                </div>
                <div class="min-w-0 flex-1">
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

    {{-- 3. Resultados: Eventos --}}
    @if($eventos->isNotEmpty())
    <section id="sec-eventos" role="tabpanel" aria-labelledby="tab-eventos" class="result-section mb-14">
        <div class="flex items-center gap-3 mb-8">
            <div class="w-2 h-8 bg-yellow-500 rounded-sm"></div>
            <h2 class="text-2xl font-black text-[#071D41] font-heading uppercase tracking-tight">Eventos</h2>
        </div>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
            @foreach($eventos as $evento)
            <div class="flex items-center gap-4 sm:gap-5 bg-white p-4 sm:p-5 border border-slate-200 rounded-2xl shadow-sm hover:shadow-md transition-all">
                <div class="flex flex-col items-center justify-center w-16 h-16 sm:w-20 sm:h-20 bg-[#071D41] rounded-xl text-white shrink-0 border-b-4 border-[#FFCD00]">
                    <span class="text-[10px] sm:text-xs font-bold tracking-widest uppercase opacity-90">{{ $evento->data_inicio->translatedFormat('M') }}</span>
                    <span class="text-2xl sm:text-3xl font-black leading-none">{{ $evento->data_inicio->format('d') }}</span>
                </div>
                <div class="min-w-0 flex-1 py-1">
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
    <section id="sec-programas" role="tabpanel" aria-labelledby="tab-programas" class="result-section mb-14">
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
    <section id="sec-secretarias" role="tabpanel" aria-labelledby="tab-secretarias" class="result-section mb-14">
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
                class="flex items-center gap-4 p-5 bg-white border border-slate-200 rounded-2xl shadow-sm hover:border-[#FFCD00] hover:shadow-md hover:-translate-y-1 transition-all duration-300 group outline-none focus-visible:ring-4 focus-visible:ring-[#FFCD00]">
                <div class="w-14 h-14 shrink-0 rounded-xl overflow-hidden border border-slate-200">
                    @if($secretaria->foto)
                    <img src="{{ asset('storage/' . $secretaria->foto) }}" class="w-full h-full object-cover" alt="Foto" loading="lazy" decoding="async">
                    @else
                    <div class="w-full h-full flex items-center justify-center bg-slate-100 text-slate-500 font-black text-sm group-hover:bg-[#071D41] group-hover:text-[#FFCD00] transition-colors">
                        {{ $iniciais ?: 'SM' }}
                    </div>
                    @endif
                </div>
                <div class="min-w-0 flex-1">
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

    @endif
    </div>

    {{-- Script limpo para lidar com as abas via atributo data-state do Tailwind --}}
    @if($totalResults > 0)
    <script>
        function filterResults(category) {
            // Atualiza estado visual dos botões
            document.querySelectorAll('.tab-btn').forEach(btn => {
                if (btn.dataset.target === category) {
                    btn.setAttribute('aria-selected', 'true');
                    btn.classList.add('is-active');
                } else {
                    btn.setAttribute('aria-selected', 'false');
                    btn.classList.remove('is-active');
                }
            });

            // Mostra/Esconde as seções
            document.querySelectorAll('.result-section').forEach(section => {
                if (category === 'all') {
                    section.style.display = 'block';
                    section.style.opacity = '0';
                    setTimeout(() => {
                        section.style.opacity = '1';
                        section.style.transition = 'opacity 0.3s ease';
                    }, 50);
                } else {
                    if (section.id === 'sec-' + category) {
                        section.style.display = 'block';
                        section.style.opacity = '0';
                        setTimeout(() => {
                            section.style.opacity = '1';
                            section.style.transition = 'opacity 0.3s ease';
                        }, 50);
                    } else {
                        section.style.display = 'none';
                    }
                }
            });
        }
    </script>
    @endif