@extends('layouts.app')

@section('title', $evento->titulo . ' - Agenda - Prefeitura Municipal de Assaí')

@section('content')

@php
    $isCancelado = $evento->status === 'cancelado';
    $isAdiado    = $evento->status === 'adiado';

    $gcDateStart = $evento->data_inicio->format('Ymd\THis');
    $gcDateEnd   = $evento->data_fim
        ? $evento->data_fim->format('Ymd\THis')
        : $evento->data_inicio->copy()->addHour()->format('Ymd\THis');
    $gcUrl = 'https://www.google.com/calendar/render?action=TEMPLATE'
        . '&text='     . rawurlencode($evento->titulo)
        . '&dates='    . $gcDateStart . '/' . $gcDateEnd
        . ($evento->local     ? '&location=' . rawurlencode($evento->local)              : '')
        . ($evento->descricao ? '&details='  . rawurlencode(strip_tags($evento->descricao)) : '');
@endphp

{{-- ===== HERO ===== --}}
<section class="relative min-h-[340px] md:min-h-[420px] flex items-end overflow-hidden bg-blue-950">

    {{-- Imagem de fundo --}}
    @if($evento->imagem)
        <img src="{{ asset('storage/' . $evento->imagem) }}"
             alt="{{ $evento->titulo }}"
             class="absolute inset-0 object-cover w-full h-full {{ $isCancelado ? 'grayscale' : '' }} opacity-40">
    @else
        <div class="absolute inset-0 bg-gradient-to-br from-blue-900 to-blue-950"></div>
    @endif

    {{-- Overlay gradiente --}}
    <div class="absolute inset-0 bg-gradient-to-t from-blue-950 via-blue-950/60 to-transparent pointer-events-none"></div>

    <div class="relative z-10 w-full container px-4 mx-auto max-w-5xl pb-10 pt-20">

        {{-- Breadcrumb --}}
        <x-breadcrumb :items="[
            ['name' => 'Início', 'url' => route('home')],
            ['name' => 'Agenda', 'url' => route('agenda.index')],
            ['name' => $evento->titulo],
        ]" dark />

        {{-- Badges de status --}}
        @if($isCancelado)
            <span class="inline-flex items-center gap-1.5 px-3 py-1 mb-3 text-xs font-bold text-red-100 uppercase bg-red-600/80 border border-red-400/40 rounded-full tracking-wide backdrop-blur-sm">
                <svg class="w-3.5 h-3.5" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/>
                </svg>
                Evento Cancelado
            </span>
        @elseif($isAdiado)
            <span class="inline-flex items-center gap-1.5 px-3 py-1 mb-3 text-xs font-bold text-amber-100 uppercase bg-amber-500/80 border border-amber-400/40 rounded-full tracking-wide backdrop-blur-sm">
                <svg class="w-3.5 h-3.5" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                </svg>
                Evento Adiado
            </span>
        @endif

        {{-- Título --}}
        <h1 class="text-3xl font-extrabold text-white md:text-5xl font-heading leading-tight max-w-3xl">
            {{ $evento->titulo }}
        </h1>

        {{-- Meta rápida --}}
        <div class="flex flex-wrap items-center gap-4 mt-4 text-sm text-blue-200">
            <span class="flex items-center gap-1.5">
                <svg class="w-4 h-4 text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                </svg>
                {{ $evento->data_inicio->translatedFormat('l, d \d\e F \d\e Y') }}
            </span>
            @if($evento->local)
                <span class="flex items-center gap-1.5">
                    <svg class="w-4 h-4 text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                    </svg>
                    {{ $evento->local }}
                </span>
            @endif
        </div>

    </div>
</section>

{{-- ===== CONTEÚDO PRINCIPAL ===== --}}
<section class="py-10 bg-slate-50 md:py-14">
    <div class="container px-4 mx-auto max-w-5xl">

        <div class="grid grid-cols-1 gap-8 lg:grid-cols-3">

            {{-- ── Coluna Principal: Conteúdo ── --}}
            <main class="lg:col-span-2">
                <div class="bg-white rounded-2xl shadow-sm border border-slate-200 p-6 md:p-8">

                    @if($evento->descricao)
                        <div class="prose prose-blue max-w-none">
                            {!! $evento->descricao !!}
                        </div>
                    @else
                        <p class="text-slate-400 italic">Nenhuma descrição disponível para este evento.</p>
                    @endif

                </div>

                {{-- Botão Voltar (mobile) --}}
                <div class="mt-6 lg:hidden">
                    <a href="{{ route('agenda.index') }}" class="inline-flex items-center gap-2 text-sm font-bold text-blue-700 hover:text-blue-900 transition">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                        </svg>
                        Voltar para a Agenda
                    </a>
                </div>

                {{-- Outros eventos --}}
                @if($outrosEventos->isNotEmpty())
                    <div class="mt-10">
                        <h2 class="text-lg font-bold text-slate-700 mb-5">Outros eventos na Agenda</h2>
                        <div class="flex flex-col gap-4">
                            @foreach($outrosEventos as $outro)
                                <a href="{{ route('agenda.show', $outro->id) }}"
                                   class="flex items-center gap-4 p-4 bg-white rounded-xl border border-slate-200 shadow-sm hover:shadow-md hover:-translate-y-0.5 transition-all group">
                                    <div class="flex flex-col items-center justify-center w-12 h-12 bg-blue-900 rounded-lg text-white shrink-0 shadow-inner">
                                        <span class="text-[9px] font-bold tracking-wider uppercase opacity-70">{{ $outro->data_inicio->translatedFormat('M') }}</span>
                                        <span class="text-lg font-extrabold leading-none">{{ $outro->data_inicio->format('d') }}</span>
                                    </div>
                                    <div class="min-w-0">
                                        <p class="font-bold text-slate-800 line-clamp-1 group-hover:text-blue-700 transition-colors">{{ $outro->titulo }}</p>
                                        @if($outro->local)
                                            <p class="text-xs text-slate-500 mt-0.5 line-clamp-1">{{ $outro->local }}</p>
                                        @endif
                                    </div>
                                    @php
                                        $outroCfg = match($outro->status) {
                                            'adiado'    => 'bg-amber-50 text-amber-700 border-amber-200',
                                            'cancelado' => 'bg-red-50 text-red-700 border-red-200',
                                            default     => 'bg-emerald-50 text-emerald-700 border-emerald-200',
                                        };
                                        $outroLabel = match($outro->status) {
                                            'adiado'    => 'Adiado',
                                            'cancelado' => 'Cancelado',
                                            default     => 'Confirmado',
                                        };
                                    @endphp
                                    <span class="ml-auto shrink-0 px-2.5 py-0.5 text-[10px] font-bold border rounded-full {{ $outroCfg }}">{{ $outroLabel }}</span>
                                </a>
                            @endforeach
                        </div>
                    </div>
                @endif

            </main>

            {{-- ── Coluna Lateral: Metadados e Ações ── --}}
            <aside class="lg:col-span-1">
                <div class="sticky top-8 bg-white border border-gray-200 shadow-sm rounded-2xl p-6 space-y-5">

                    {{-- Data de início --}}
                    <div class="flex items-start gap-3">
                        <div class="flex items-center justify-center w-9 h-9 bg-blue-50 rounded-lg shrink-0 text-blue-600">
                            <svg class="w-4.5 h-4.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                            </svg>
                        </div>
                        <div>
                            <p class="text-[11px] font-bold text-slate-400 uppercase tracking-wider">Início</p>
                            <p class="text-sm font-bold text-slate-700 mt-0.5">
                                {{ $evento->data_inicio->translatedFormat('l') }},
                                {{ $evento->data_inicio->format('d/m/Y') }}
                                @if($evento->data_inicio->format('H:i') !== '00:00')
                                    <span class="font-normal text-slate-500">às {{ $evento->data_inicio->format('H:i') }}</span>
                                @endif
                            </p>
                        </div>
                    </div>

                    {{-- Data de fim (opcional) --}}
                    @if($evento->data_fim)
                        <div class="flex items-start gap-3">
                            <div class="flex items-center justify-center w-9 h-9 bg-red-50 rounded-lg shrink-0 text-red-400">
                                <svg class="w-4.5 h-4.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                            </div>
                            <div>
                                <p class="text-[11px] font-bold text-slate-400 uppercase tracking-wider">Término</p>
                                <p class="text-sm font-bold text-slate-700 mt-0.5">
                                    {{ $evento->data_fim->format('d/m/Y') }}
                                    @if($evento->data_fim->format('H:i') !== '00:00')
                                        <span class="font-normal text-slate-500">às {{ $evento->data_fim->format('H:i') }}</span>
                                    @endif
                                </p>
                            </div>
                        </div>
                    @endif

                    {{-- Local --}}
                    @if($evento->local)
                        <div class="flex items-start gap-3">
                            <div class="flex items-center justify-center w-9 h-9 bg-emerald-50 rounded-lg shrink-0 text-emerald-600">
                                <svg class="w-4.5 h-4.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                                </svg>
                            </div>
                            <div>
                                <p class="text-[11px] font-bold text-slate-400 uppercase tracking-wider">Local</p>
                                <p class="text-sm font-bold text-slate-700 mt-0.5">{{ $evento->local }}</p>
                            </div>
                        </div>
                    @endif

                    {{-- Status --}}
                    <div class="flex items-start gap-3">
                        <div class="flex items-center justify-center w-9 h-9 bg-slate-50 rounded-lg shrink-0 text-slate-400">
                            <svg class="w-4.5 h-4.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                        </div>
                        <div>
                            <p class="text-[11px] font-bold text-slate-400 uppercase tracking-wider">Status</p>
                            @php
                                $statusCfg = match($evento->status) {
                                    'adiado'    => 'bg-amber-50 text-amber-700 border-amber-200',
                                    'cancelado' => 'bg-red-50 text-red-700 border-red-200',
                                    default     => 'bg-emerald-50 text-emerald-700 border-emerald-200',
                                };
                                $statusLabel = match($evento->status) {
                                    'adiado'    => 'Adiado',
                                    'cancelado' => 'Cancelado',
                                    default     => 'Confirmado',
                                };
                            @endphp
                            <span class="inline-flex mt-1 px-2.5 py-0.5 text-xs font-bold border rounded-full {{ $statusCfg }}">{{ $statusLabel }}</span>
                        </div>
                    </div>

                    {{-- Divisor --}}
                    <hr class="border-slate-100">

                    {{-- Botões de ação --}}
                    <div class="flex flex-col gap-2.5">

                        {{-- Adicionar ao Google Agenda --}}
                        <a href="{{ $gcUrl }}" target="_blank" rel="noopener noreferrer"
                           class="inline-flex items-center justify-center gap-2 w-full px-4 py-2.5 text-sm font-bold text-white bg-blue-600 rounded-xl hover:bg-blue-700 transition shadow-sm shadow-blue-500/20">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                            </svg>
                            Adicionar ao Google Agenda
                        </a>

                        {{-- Compartilhar --}}
                        <button type="button" onclick="compartilharEvento()"
                                class="inline-flex items-center justify-center gap-2 w-full px-4 py-2.5 text-sm font-bold text-slate-700 bg-slate-100 rounded-xl hover:bg-slate-200 transition">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.684 13.342C8.886 12.938 9 12.482 9 12c0-.482-.114-.938-.316-1.342m0 2.684a3 3 0 110-2.684m0 2.684l6.632 3.316m-6.632-6l6.632-3.316m0 0a3 3 0 105.367-2.684 3 3 0 00-5.367 2.684zm0 9.316a3 3 0 105.368 2.684 3 3 0 00-5.368-2.684z"/>
                            </svg>
                            Compartilhar
                        </button>

                        {{-- Voltar --}}
                        <a href="{{ route('agenda.index') }}"
                           class="inline-flex items-center justify-center gap-2 w-full px-4 py-2.5 text-sm font-bold text-slate-600 bg-white border border-slate-200 rounded-xl hover:bg-slate-50 transition">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                            </svg>
                            Voltar para a Agenda
                        </a>

                    </div>

                </div>
            </aside>

        </div>
    </div>
</section>

@endsection
