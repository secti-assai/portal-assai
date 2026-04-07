@extends('layouts.app')

@section('title', 'Resultados da Busca: ' . ($termo ?? 'Pesquisa') . ' - Prefeitura Municipal de Assaí')

@section('content')
<main id="conteudo-principal" accesskey="1" tabindex="-1" class="min-h-screen bg-slate-50 pb-20">

    {{-- =================
         HERO SECTION (Busca)
         ================= --}}
    <section class="bg-blue-900 pt-24 pb-20 md:pt-32 md:pb-28 relative overflow-hidden">
        {{-- Efeito de Fundo (Onda/Onda de luz) --}}
        <div class="absolute inset-0 opacity-10 pointer-events-none">
            <svg class="w-full h-full" fill="currentColor" viewBox="0 0 100 100" preserveAspectRatio="none">
                <path d="M0 100 C 20 0 50 0 100 100 Z"></path>
            </svg>
        </div>

        <div class="container px-4 mx-auto max-w-5xl relative z-10">
            <x-breadcrumb :items="[
                ['name' => 'Início', 'url' => route('home')],
                ['name' => 'Busca no Portal'],
            ]" dark />

            <h1 class="text-3xl md:text-5xl font-black text-white font-heading mb-8 leading-tight drop-shadow-md">
                @if($termo)
                    Resultados para: <span class="text-yellow-400">"{{ $termo }}"</span>
                @else
                    O que você está procurando?
                @endif
            </h1>

            {{-- Barra de Busca (Mesmo padrão visual da Home) --}}
            <div class="w-full max-w-3xl">
                <form action="{{ route('busca.index') }}" method="GET" onsubmit="return this.q.value.trim() !== ''" class="relative flex items-center w-full bg-white/95 focus-within:bg-white backdrop-blur-md shadow-2xl rounded-full border border-white/60 transition-all duration-300 p-1" role="search" aria-label="Buscar informações no portal">
                    <label for="campo-busca-portal" class="sr-only">Pesquisar no portal</label>

                    <div class="flex items-center justify-center pl-4 md:pl-5 pr-2 text-slate-400 shrink-0 hidden md:flex" aria-hidden="true">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                        </svg>
                    </div>

                    <input id="campo-busca-portal" type="text" name="q" value="{{ $termo }}" placeholder="O que você procura?" required
                        class="flex-1 min-w-0 px-3 py-2.5 text-sm text-gray-800 bg-transparent border-none md:px-2 md:py-4 md:text-base focus:ring-0 focus:outline-none font-sans placeholder:text-slate-400 w-full"
                        autofocus>

                    <button type="submit" class="m-1.5 px-3.5 max-[360px]:px-3 py-2.5 max-[360px]:py-2 font-bold text-sm text-blue-900 transition-all bg-yellow-400 rounded-full shrink-0 md:px-6 md:py-3 hover:bg-yellow-500 hover:shadow-lg font-heading">
                        Buscar
                    </button>
                </form>
            </div>
        </div>
    </section>

    {{-- =================
         SISTEMA DE RESULTADOS E ABAS
         ================= --}}
    <div id="resultados-busca" class="container px-4 mx-auto max-w-5xl -mt-8 relative z-20">
        
        {{-- Filtros (Estilo Pílulas Interativas) --}}
        <div class="bg-white/95 backdrop-blur-md p-2.5 sm:p-3 rounded-2xl shadow-2xl border border-slate-200/80 mb-8 sm:mb-10 overflow-x-auto md:overflow-visible scrollbar-hide [scrollbar-width:none] [-ms-overflow-style:none] [scroll-behavior:smooth]">
            <div class="flex items-center justify-start md:justify-center gap-2 min-w-max md:min-w-0 md:flex-wrap pb-1" role="tablist" aria-label="Filtrar resultados da busca">
                <button id="tab-all" role="tab" aria-selected="true" aria-controls="sec-all" onclick="filterResults('all')" class="tab-btn active snap-start whitespace-nowrap px-4 sm:px-6 py-2 sm:py-2.5 rounded-full font-bold text-xs sm:text-sm transition-all border touch-manipulation" data-target="all">
                    Tudo <span class="ml-1.5 text-[10px] font-bold text-slate-600 bg-slate-100 px-2 py-0.5 rounded-full">{{ $noticias->count() + $servicos->count() + $eventos->count() + $programas->count() + $secretarias->count() }}</span>
                </button>
                @if($noticias->isNotEmpty())
                <button id="tab-noticias" role="tab" aria-selected="false" aria-controls="sec-noticias" onclick="filterResults('noticias')" class="tab-btn snap-start whitespace-nowrap px-4 sm:px-6 py-2 sm:py-2.5 rounded-full font-bold text-xs sm:text-sm transition-all border touch-manipulation" data-target="noticias">
                    Notícias <span class="ml-1.5 text-[10px] font-bold text-slate-600 bg-slate-100 px-2 py-0.5 rounded-full">{{ $noticias->count() }}</span>
                </button>
                @endif
                @if($servicos->isNotEmpty())
                <button id="tab-servicos" role="tab" aria-selected="false" aria-controls="sec-servicos" onclick="filterResults('servicos')" class="tab-btn snap-start whitespace-nowrap px-4 sm:px-6 py-2 sm:py-2.5 rounded-full font-bold text-xs sm:text-sm transition-all border touch-manipulation" data-target="servicos">
                    Serviços <span class="ml-1.5 text-[10px] font-bold text-slate-600 bg-slate-100 px-2 py-0.5 rounded-full">{{ $servicos->count() }}</span>
                </button>
                @endif
                @if($eventos->isNotEmpty())
                <button id="tab-eventos" role="tab" aria-selected="false" aria-controls="sec-eventos" onclick="filterResults('eventos')" class="tab-btn snap-start whitespace-nowrap px-4 sm:px-6 py-2 sm:py-2.5 rounded-full font-bold text-xs sm:text-sm transition-all border touch-manipulation" data-target="eventos">
                    Eventos <span class="ml-1.5 text-[10px] font-bold text-slate-600 bg-slate-100 px-2 py-0.5 rounded-full">{{ $eventos->count() }}</span>
                </button>
                @endif
                @if($programas->isNotEmpty())
                <button id="tab-programas" role="tab" aria-selected="false" aria-controls="sec-programas" onclick="filterResults('programas')" class="tab-btn snap-start whitespace-nowrap px-4 sm:px-6 py-2 sm:py-2.5 rounded-full font-bold text-xs sm:text-sm transition-all border touch-manipulation" data-target="programas">
                    Programas <span class="ml-1.5 text-[10px] font-bold text-slate-600 bg-slate-100 px-2 py-0.5 rounded-full">{{ $programas->count() }}</span>
                </button>
                @endif
                @if($secretarias->isNotEmpty())
                <button id="tab-secretarias" role="tab" aria-selected="false" aria-controls="sec-secretarias" onclick="filterResults('secretarias')" class="tab-btn snap-start whitespace-nowrap px-4 sm:px-6 py-2 sm:py-2.5 rounded-full font-bold text-xs sm:text-sm transition-all border touch-manipulation" data-target="secretarias">
                    Secretarias <span class="ml-1.5 text-[10px] font-bold text-slate-600 bg-slate-100 px-2 py-0.5 rounded-full">{{ $secretarias->count() }}</span>
                </button>
                @endif
            </div>
        </div>

        {{-- Fallbacks (Erros e Vazios) --}}
        @if(strlen(trim($termo)) < 2)
            <div class="text-center py-20 bg-white rounded-[2rem] shadow-sm border border-slate-200">
                <div class="w-20 h-20 bg-slate-50 rounded-full flex items-center justify-center mx-auto mb-6">
                    <svg class="w-10 h-10 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                </div>
                <h3 class="text-2xl font-black text-slate-800 font-heading">Busca Insuficiente</h3>
                <p class="text-slate-500 mt-2">Por favor, digite ao menos 2 caracteres para realizar a varredura no portal.</p>
            </div>
        @elseif($noticias->isEmpty() && $servicos->isEmpty() && $eventos->isEmpty() && $programas->isEmpty() && $secretarias->isEmpty())
            <div class="text-center py-24 bg-white rounded-[2rem] shadow-sm border border-slate-200">
                <div class="w-24 h-24 bg-slate-50 rounded-full flex items-center justify-center mx-auto mb-6">
                    <svg class="w-12 h-12 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                </div>
                <h3 class="text-2xl font-black text-slate-800 font-heading">Nenhum resultado para "{{ $termo }}"</h3>
                <p class="text-slate-500 mt-2 max-w-md mx-auto">Não encontramos informações correspondentes. Tente termos mais genéricos ou verifique a ortografia.</p>
                <div class="mt-8">
                    <a href="{{ route('home') }}" class="inline-flex items-center px-6 py-3 font-bold text-sm text-blue-900 bg-blue-50 rounded-full hover:bg-blue-100 transition-colors">
                        Voltar para a página inicial
                    </a>
                </div>
            </div>
        @else

            {{-- 1. Resultados: Notícias (Estilo Horizontal Moderno) --}}
            @if($noticias->isNotEmpty())
            <section id="sec-noticias" role="tabpanel" aria-labelledby="tab-noticias" class="result-section mb-14">
                <div class="flex items-center gap-3 mb-6">
                    <div class="w-1.5 h-8 bg-blue-600 rounded-full"></div>
                    <h2 class="text-2xl font-black text-slate-800 font-heading uppercase tracking-tight">Notícias</h2>
                </div>
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                    @foreach($noticias as $noticia)
                    <article class="relative bg-white rounded-[1.5rem] p-4 border border-slate-100 shadow-sm hover:shadow-xl transition-all duration-300 flex gap-5 group">
                        <a href="{{ route('noticias.show', $noticia->slug) }}" class="absolute inset-0 z-10 rounded-[1.5rem] outline-none focus-visible:ring-4 focus-visible:ring-blue-400"></a>
                        
                        <div class="w-28 h-28 sm:w-36 sm:h-36 shrink-0 rounded-xl overflow-hidden bg-slate-100 relative">
                            @if($noticia->imagem_capa)
                                <img src="{{ asset('storage/' . $noticia->imagem_capa) }}" class="w-full h-full object-cover group-hover:scale-110 transition duration-700 ease-out" alt="" loading="lazy">
                            @else
                                <div class="w-full h-full flex items-center justify-center bg-slate-100 text-slate-300">
                                    <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z"/></svg>
                                </div>
                            @endif
                        </div>
                        
                        <div class="flex flex-col justify-center py-1 flex-1 min-w-0">
                            <span class="text-[10px] font-bold text-blue-600 uppercase tracking-widest mb-1.5">{{ $noticia->categoria }}</span>
                            <h3 class="text-base sm:text-lg font-bold text-slate-800 group-hover:text-blue-700 transition-colors leading-tight line-clamp-2 font-heading mb-2">
                                {{ $noticia->titulo }}
                            </h3>
                            <p class="text-[12px] sm:text-[13px] text-slate-500 line-clamp-2 font-sans mb-3 hidden sm:block">
                                {{ $noticia->resumo ?? Str::limit(strip_tags($noticia->conteudo), 100) }}
                            </p>
                            <time class="text-[10px] sm:text-xs text-slate-400 font-medium mt-auto flex items-center gap-1.5">
                                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
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
                <div class="flex items-center gap-3 mb-6">
                    <div class="w-1.5 h-8 bg-emerald-500 rounded-full"></div>
                    <h2 class="text-2xl font-black text-slate-800 font-heading uppercase tracking-tight">Serviços</h2>
                </div>
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-5">
                    @foreach($servicos as $servico)
                    <a href="{{ $servico->url_acesso ?? $servico->link ?? '#' }}" target="_blank" rel="noopener noreferrer" class="flex items-center p-5 bg-white border border-slate-100 rounded-2xl shadow-sm hover:border-emerald-400 hover:shadow-lg hover:-translate-y-1 transition-all duration-300 group">
                        <div class="w-12 h-12 flex items-center justify-center bg-emerald-50 text-emerald-600 rounded-xl mr-4 group-hover:bg-emerald-500 group-hover:text-white transition-colors shrink-0">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/></svg>
                        </div>
                        <div class="min-w-0 flex-1">
                            <h3 class="text-sm md:text-base font-bold text-slate-800 truncate font-heading group-hover:text-emerald-700 transition-colors">{{ $servico->titulo }}</h3>
                            <span class="text-[10px] font-medium text-emerald-600 uppercase tracking-tighter flex items-center gap-1 mt-0.5">Acessar Serviço <i class="fas fa-external-link-alt text-[8px]"></i></span>
                        </div>
                    </a>
                    @endforeach
                </div>
            </section>
            @endif

            {{-- 3. Resultados: Eventos --}}
            @if($eventos->isNotEmpty())
            <section id="sec-eventos" role="tabpanel" aria-labelledby="tab-eventos" class="result-section mb-14">
                <div class="flex items-center gap-3 mb-6">
                    <div class="w-1.5 h-8 bg-yellow-400 rounded-full"></div>
                    <h2 class="text-2xl font-black text-slate-800 font-heading uppercase tracking-tight">Eventos</h2>
                </div>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                    @foreach($eventos as $evento)
                    <div class="flex items-center gap-5 bg-white p-5 border border-slate-100 rounded-2xl shadow-sm hover:shadow-md transition-all">
                        <div class="flex flex-col items-center justify-center w-16 h-16 bg-blue-900 rounded-2xl text-white shrink-0 shadow-inner">
                            <span class="text-[10px] font-bold tracking-wider uppercase opacity-70">{{ $evento->data_inicio->translatedFormat('M') }}</span>
                            <span class="text-2xl font-black leading-none">{{ $evento->data_inicio->format('d') }}</span>
                        </div>
                        <div class="min-w-0 flex-1">
                            <h3 class="text-base font-bold text-slate-800 font-heading leading-tight truncate mb-1.5">{{ $evento->titulo }}</h3>
                            <div class="flex items-center gap-3 text-xs text-slate-500 font-medium">
                                <span class="flex items-center gap-1 bg-slate-50 px-2 py-1 rounded-md">
                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                    {{ $evento->data_inicio->format('H:i') }}
                                </span>
                                <span class="flex items-center gap-1 truncate">
                                    <svg class="w-3.5 h-3.5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path></svg>
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
                <div class="flex items-center gap-3 mb-6">
                    <div class="w-1.5 h-8 bg-purple-500 rounded-full"></div>
                    <h2 class="text-2xl font-black text-slate-800 font-heading uppercase tracking-tight">Programas</h2>
                </div>
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-5">
                    @foreach($programas as $programa)
                    <a href="{{ $programa->link ?? '#' }}" @if($programa->link) target="_blank" rel="noopener noreferrer" @endif
                       class="flex items-center p-5 bg-white border border-slate-100 rounded-2xl shadow-sm hover:border-purple-400 hover:shadow-lg hover:-translate-y-1 transition-all duration-300 group">
                        <div class="w-12 h-12 flex items-center justify-center bg-purple-50 text-purple-600 rounded-xl mr-4 group-hover:bg-purple-600 group-hover:text-white transition-colors shrink-0">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/>
                            </svg>
                        </div>
                        <div class="min-w-0 flex-1">
                            <h3 class="text-sm font-bold text-slate-800 line-clamp-2 font-heading group-hover:text-purple-700 transition-colors">{{ $programa->titulo }}</h3>
                        </div>
                    </a>
                    @endforeach
                </div>
            </section>
            @endif

            {{-- 5. Resultados: Secretarias --}}
            @if($secretarias->isNotEmpty())
            <section id="sec-secretarias" role="tabpanel" aria-labelledby="tab-secretarias" class="result-section mb-14">
                <div class="flex items-center gap-3 mb-6">
                    <div class="w-1.5 h-8 bg-slate-500 rounded-full"></div>
                    <h2 class="text-2xl font-black text-slate-800 font-heading uppercase tracking-tight">Secretarias</h2>
                </div>
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-5">
                    @foreach($secretarias as $secretaria)
                    @php
                        $iniciais = collect(explode(' ', $secretaria->nome))
                            ->filter(fn($p) => strlen($p) > 2)
                            ->take(2)
                            ->map(fn($p) => strtoupper($p[0]))
                            ->implode('');
                    @endphp
                    <a href="{{ route('secretarias.show', $secretaria->id) }}"
                       class="flex items-center gap-4 p-5 bg-white border border-slate-100 rounded-2xl shadow-sm hover:border-blue-400 hover:shadow-lg hover:-translate-y-1 transition-all duration-300 group">
                        <div class="w-12 h-12 shrink-0 rounded-xl overflow-hidden border border-slate-100">
                            @if($secretaria->foto)
                                <img src="{{ asset('storage/' . $secretaria->foto) }}" class="w-full h-full object-cover" alt="Foto de {{ $secretaria->nome }}" loading="lazy" decoding="async">
                            @else
                                <div class="w-full h-full flex items-center justify-center bg-slate-50 text-slate-400 font-black text-sm group-hover:bg-blue-600 group-hover:text-white transition-colors">
                                    {{ $iniciais ?: 'SM' }}
                                </div>
                            @endif
                        </div>
                        <div class="min-w-0 flex-1">
                            <h3 class="text-sm font-bold text-slate-800 leading-snug line-clamp-2 font-heading group-hover:text-blue-700 transition-colors">{{ $secretaria->nome }}</h3>
                            @if($secretaria->nome_secretario)
                                <p class="text-[11px] text-slate-500 mt-1 truncate font-medium">Resp: {{ $secretaria->nome_secretario }}</p>
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

{{-- Script para o Sistema de Abas (Filtros) --}}
<script>
    const TAB_BASE_CLASS = 'tab-btn whitespace-nowrap px-4 sm:px-6 py-2 sm:py-2.5 rounded-full font-bold text-xs sm:text-sm transition-all border touch-manipulation';
    const TAB_ACTIVE_CLASS = 'border-blue-800 bg-blue-800 text-white shadow-md';
    const TAB_INACTIVE_CLASS = {
        all: 'border-slate-300 bg-slate-50 text-slate-800 hover:bg-white hover:border-blue-300 hover:text-blue-700',
        noticias: 'border-slate-300 bg-slate-50 text-slate-800 hover:bg-white hover:border-blue-300 hover:text-blue-700',
        servicos: 'border-slate-300 bg-slate-50 text-slate-800 hover:bg-white hover:border-emerald-300 hover:text-emerald-700',
        eventos: 'border-slate-300 bg-slate-50 text-slate-800 hover:bg-white hover:border-yellow-300 hover:text-yellow-700',
        programas: 'border-slate-300 bg-slate-50 text-slate-800 hover:bg-white hover:border-purple-300 hover:text-purple-700',
        secretarias: 'border-slate-300 bg-slate-50 text-slate-800 hover:bg-white hover:border-slate-400 hover:text-slate-900'
    };

    function filterResults(target) {
        // 1. Atualizar estilo dos botões (Abas)
        document.querySelectorAll('.tab-btn').forEach(btn => {
            const buttonTarget = btn.dataset.target;
            const isActive = buttonTarget === target;
            const inactiveClass = TAB_INACTIVE_CLASS[buttonTarget] || TAB_INACTIVE_CLASS.all;

            btn.className = `${TAB_BASE_CLASS} ${isActive ? TAB_ACTIVE_CLASS : inactiveClass}`;
            btn.setAttribute('aria-selected', isActive ? 'true' : 'false');
            btn.setAttribute('tabindex', isActive ? '0' : '-1');

            if (isActive) {
                btn.scrollIntoView({ behavior: 'smooth', inline: 'center', block: 'nearest' });
                
                // badge ativa
                let badge = btn.querySelector('span');
                if(badge) {
                    badge.classList.remove('bg-slate-100', 'text-slate-600');
                    badge.classList.add('bg-white', 'text-blue-900');
                }
            } else {
                // badge inativa
                let badge = btn.querySelector('span');
                if(badge) {
                    badge.classList.add('bg-slate-100', 'text-slate-600');
                    badge.classList.remove('bg-white', 'text-blue-900');
                }
            }
        });

        // 2. Mostrar/Ocultar as seções (Sections)
        document.querySelectorAll('.result-section').forEach(sec => {
            if (target === 'all' || sec.id === 'sec-' + target) {
                sec.style.display = 'block';
                sec.setAttribute('aria-hidden', 'false');
            } else {
                sec.style.display = 'none';
                sec.setAttribute('aria-hidden', 'true');
            }
        });
    }

    document.addEventListener('DOMContentLoaded', () => filterResults('all'));
</script>
@endsection