@extends('layouts.app')

@section('title', 'Agenda - Prefeitura Municipal de Assaí')

@section('content')

{{-- ===== CABEÇALHO PADRONIZADO ===== --}}
<section class="relative py-12 overflow-hidden bg-blue-900 md:py-20 lg:py-24">
    {{-- Textura Vetorial e Gradiente de Profundidade --}}
    <div class="absolute inset-0 pointer-events-none">
        <svg class="absolute w-full h-full opacity-40 text-blue-800" xmlns="http://www.w3.org/2000/svg">
            <defs>
                <pattern id="grid-pattern" width="40" height="40" patternUnits="userSpaceOnUse">
                    <path d="M 40 0 L 0 0 0 40" fill="none" stroke="currentColor" stroke-width="0.5"/>
                </pattern>
            </defs>
            <rect width="100%" height="100%" fill="url(#grid-pattern)"/>
        </svg>
        <div class="absolute bottom-0 left-0 right-0 h-32 bg-gradient-to-t from-blue-950 to-transparent"></div>
    </div>

    <div class="container relative z-10 px-4 mx-auto max-w-7xl text-left">
        <x-breadcrumb :items="[
            ['name' => 'Início', 'url' => route('home')],
            ['name' => 'Agenda'],
        ]" dark />
        <h1 class="text-3xl font-extrabold text-white md:text-5xl font-heading mb-4">Agenda</h1>
        <p class="text-lg text-blue-100 max-w-2xl leading-relaxed font-light">Acompanhe os eventos, feiras, inaugurações, campanhas de saúde e atividades culturais programadas pela Prefeitura de Assaí.</p>
    </div>
</section>

{{-- ===== CONTEÚDO PRINCIPAL ===== --}}
<section class="py-10 bg-[#eaf3ff] md:py-14 border-y border-blue-100/70">
    <div class="container px-4 mx-auto max-w-7xl">

        <div class="grid grid-cols-1 gap-8 lg:grid-cols-4">

            {{-- ===== SIDEBAR ===== --}}
            <aside class="flex flex-col gap-6 lg:col-span-1">

                {{-- Mini-Calendário (atualizado via AJAX) --}}
                <div id="calendario-container">
                    @include('partials.calendario-widget')
                </div>

                {{-- Legenda --}}
                <div class="p-5 bg-white border shadow-md hover:shadow-xl transition-all duration-300 rounded-2xl border-slate-200">
                    <h3 class="mb-3 text-xs font-bold tracking-widest text-slate-800 uppercase">Legenda</h3>
                    <ul class="space-y-2.5 text-sm">
                        <li class="flex items-center gap-2.5">
                            <span class="inline-block w-3 h-3 rounded-full bg-blue-900 shrink-0"></span>
                            <span class="text-slate-700">Confirmado</span>
                        </li>
                        <li class="flex items-center gap-2.5">
                            <span class="inline-block w-3 h-3 rounded-full bg-red-600 shrink-0"></span>
                            <span class="text-slate-700">Cancelado</span>
                        </li>
                    </ul>
                </div>

            </aside>

            {{-- ===== FEED DE EVENTOS ===== --}}
            <div class="lg:col-span-3">

                <div class="portal-section-title !items-start !text-left mb-6">
                    <h2>Próximos Eventos</h2>
                    <div class="bar"></div>
                </div>

                @if($eventos->isEmpty())

                    {{-- Empty State --}}
                    <div class="flex flex-col items-center justify-center py-24 text-center bg-white border border-dashed rounded-2xl border-slate-200">
                        <svg class="w-24 h-24 mb-5 text-slate-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 13h6m-3-3v6"/>
                        </svg>
                        <h3 class="text-xl font-bold text-slate-600">Nenhum evento agendado</h3>
                        <p class="mt-2 text-sm text-slate-700 max-w-sm">Não há eventos cadastrados para o período atual. Acompanhe as nossas redes sociais para ficar por dentro das novidades.</p>
                    </div>

                @else

                    <div class="flex flex-col gap-6">
                        @foreach($eventos as $evento)
                            @php
                                $isCancelado = $evento->status === 'cancelado';
                                $gcDateStart = $evento->data_inicio->format('Ymd\THis');
                                $gcDateEnd   = $evento->data_fim
                                    ? $evento->data_fim->format('Ymd\THis')
                                    : $evento->data_inicio->copy()->addHour()->format('Ymd\THis');
                                $gcUrl = 'https://www.google.com/calendar/render?action=TEMPLATE'
                                    . '&text='     . rawurlencode($evento->titulo)
                                    . '&dates='    . $gcDateStart . '/' . $gcDateEnd
                                    . ($evento->local    ? '&location=' . rawurlencode($evento->local)                        : '')
                                    . ($evento->descricao ? '&details='  . rawurlencode(strip_tags($evento->descricao)) : '');
                            @endphp

                            <article class="flex flex-col md:flex-row bg-slate-50 border border-slate-300/70 ring-1 ring-slate-200/70 shadow-sm rounded-2xl overflow-hidden {{ $isCancelado ? 'opacity-70' : '' }} transition-shadow hover:shadow-md">

                                {{-- ── Bloco Esquerdo: Imagem + Data ── --}}
                                <div class="relative w-full md:w-48 shrink-0 bg-slate-100 min-h-[140px] md:min-h-0">

                                    @if($evento->imagem)
                                        <img src="{{ asset('storage/' . $evento->imagem) }}"
                                             alt="{{ $evento->titulo }}"
                                             class="absolute inset-0 object-cover w-full h-full {{ $isCancelado ? 'grayscale opacity-60' : '' }}"
                                             loading="lazy" decoding="async">
                                    @else
                                        <div class="absolute inset-0 flex items-center justify-center bg-blue-100">
                                            <svg class="w-10 h-10 text-blue-600 opacity-90" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                            </svg>
                                        </div>
                                    @endif

                                    {{-- Data flutuante reduzida --}}
                                    <div class="absolute bottom-3 left-3 z-10 flex flex-col items-center justify-center w-12 h-12 bg-white rounded-lg shadow-md ring-1 ring-blue-200 text-blue-900">
                                        <span class="text-[9px] font-extrabold uppercase tracking-wider leading-none opacity-70">{{ $evento->data_inicio->translatedFormat('M') }}</span>
                                        <span class="text-xl font-extrabold leading-none mt-0.5">{{ $evento->data_inicio->format('d') }}</span>
                                    </div>

                                </div>

                                {{-- ── Bloco Direito: Conteúdo ── --}}
                                <div class="flex flex-col flex-1 p-4 md:p-5">

                                    {{-- Badges de status --}}
                                    @if($isCancelado)
                                        <span class="inline-flex items-center self-start gap-1 px-2.5 py-0.5 mb-2 text-[10px] font-bold text-red-700 uppercase bg-red-50 border border-red-200 rounded-full tracking-wide">
                                            <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/></svg>
                                            Cancelado
                                        </span>
                                    @endif

                                    {{-- Título --}}
                                    <h2 class="text-lg md:text-xl font-extrabold leading-tight text-slate-900 mb-2">{{ $evento->titulo }}</h2>

                                    {{-- Metadados --}}
                                    <ul class="flex flex-col gap-1.5 mb-3 text-xs md:text-sm text-slate-700">
                                        <li class="flex items-start gap-2">
                                            <svg class="w-4 h-4 shrink-0 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                                            <span>
                                                {{ $evento->data_inicio->translatedFormat('l, d \d\e F \d\e Y') }}
                                                @if($evento->data_inicio->format('H:i') !== '00:00')
                                                    &mdash; {{ $evento->data_inicio->format('H:i') }}
                                                    @if($evento->data_fim)
                                                        até {{ $evento->data_fim->format('H:i') }}
                                                    @endif
                                                @endif
                                            </span>
                                        </li>
                                        @if($evento->local)
                                        <li class="flex items-start gap-2">
                                            <svg class="w-4 h-4 shrink-0 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                                            <span>{{ $evento->local }}</span>
                                        </li>
                                        @endif
                                    </ul>

                                    {{-- Descrição --}}
                                    @if($evento->descricao)
                                        <div class="prose prose-sm max-w-none text-slate-700 line-clamp-2 mb-4 text-[13px] leading-relaxed">
                                            {!! strip_tags($evento->descricao) !!}
                                        </div>
                                    @endif

                                    {{-- Rodapé do card --}}
                                    <div class="mt-auto flex items-center justify-between gap-3 pt-3 border-t border-slate-100">
                                                     <a href="{{ $gcUrl }}" target="_blank" rel="noopener noreferrer"
                                                         class="inline-flex items-center gap-1.5 px-3 py-1.5 text-xs font-bold text-blue-800 bg-blue-100 border border-blue-200 rounded-md hover:bg-blue-200 transition-colors shrink-0">
                                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                                            Adicionar
                                        </a>
                                        <a href="{{ route('agenda.show', $evento->id) }}"
                                           class="inline-flex items-center gap-1.5 px-4 py-1.5 text-xs font-bold text-white transition bg-blue-600 rounded-lg hover:bg-blue-700 shadow-sm shrink-0">
                                            Detalhes
                                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"/></svg>
                                        </a>
                                    </div>

                                </div>
                            </article>
                        @endforeach
                    </div>

                    @if($eventos->hasPages())
                        <div class="mt-8 rounded-2xl border border-slate-200 bg-white p-4 sm:p-5 shadow-sm">
                            <div class="flex flex-col gap-4 lg:flex-row lg:items-center lg:justify-between">
                                <p class="text-sm text-slate-700">
                                    Mostrando
                                    <span class="font-bold text-slate-900">{{ $eventos->firstItem() }}</span>
                                    a
                                    <span class="font-bold text-slate-900">{{ $eventos->lastItem() }}</span>
                                    de
                                    <span class="font-bold text-slate-900">{{ $eventos->total() }}</span>
                                    resultados
                                </p>

                                <nav class="flex flex-wrap items-center gap-2" aria-label="Paginação da agenda">
                                    @if($eventos->onFirstPage())
                                        <span class="inline-flex items-center rounded-lg border border-slate-200 bg-slate-100 px-3 py-2 text-sm font-semibold text-slate-400 cursor-not-allowed">Anterior</span>
                                    @else
                                        <a href="{{ $eventos->previousPageUrl() }}" class="inline-flex items-center rounded-lg border border-slate-300 bg-white px-3 py-2 text-sm font-semibold text-slate-700 hover:bg-slate-50 transition-colors">Anterior</a>
                                    @endif

                                    @foreach($eventos->getUrlRange(1, $eventos->lastPage()) as $page => $url)
                                        @if($page == $eventos->currentPage())
                                            <span aria-current="page" class="inline-flex min-w-[2.25rem] items-center justify-center rounded-lg border border-blue-700 bg-blue-700 px-3 py-2 text-sm font-bold text-white">{{ $page }}</span>
                                        @else
                                            <a href="{{ $url }}" class="inline-flex min-w-[2.25rem] items-center justify-center rounded-lg border border-slate-300 bg-white px-3 py-2 text-sm font-semibold text-slate-700 hover:bg-blue-50 hover:text-blue-800 hover:border-blue-200 transition-colors">{{ $page }}</a>
                                        @endif
                                    @endforeach

                                    @if($eventos->hasMorePages())
                                        <a href="{{ $eventos->nextPageUrl() }}" class="inline-flex items-center rounded-lg border border-slate-300 bg-white px-3 py-2 text-sm font-semibold text-slate-700 hover:bg-slate-50 transition-colors">Próxima</a>
                                    @else
                                        <span class="inline-flex items-center rounded-lg border border-slate-200 bg-slate-100 px-3 py-2 text-sm font-semibold text-slate-400 cursor-not-allowed">Próxima</span>
                                    @endif
                                </nav>
                            </div>
                        </div>
                    @endif

                @endif

            </div>
        </div>
    </div>
</section>



@endsection