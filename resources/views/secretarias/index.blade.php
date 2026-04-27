@extends('layouts.app')

@section('title', 'Secretarias Municipais - Prefeitura Municipal de Assaí')

@section('content')
@php
$termoBusca = trim((string) request('search'));
@endphp

{{-- ===== CABEÇALHO PADRONIZADO ===== --}}
<section class="relative overflow-hidden bg-gradient-to-br from-blue-950 via-blue-900 to-blue-800 py-12 md:py-20 lg:py-24 shadow-inner">
    {{-- Elementos de fundo subtis --}}
    <div class="absolute inset-0 pointer-events-none">
        <div class="absolute inset-0 bg-[radial-gradient(circle_at_top_right,rgba(255,255,255,0.08),transparent_60%)]"></div>
        <div class="absolute -top-40 -right-32 w-96 h-96 bg-blue-800/30 rounded-full blur-3xl"></div>
        <div class="absolute -bottom-40 -left-32 w-96 h-96 bg-indigo-800/25 rounded-full blur-3xl"></div>
    </div>

    <div class="container relative z-10 px-4 sm:px-6 mx-auto max-w-7xl">
        <div class="flex flex-col md:flex-row md:items-end justify-between gap-6">
            <div class="flex-1 text-left">
                <x-breadcrumb :items="[
                        ['name' => 'Início', 'url' => route('home')],
                        ['name' => 'Secretarias'],
                    ]" dark />

                <h1 class="text-3xl font-extrabold md:text-5xl font-heading mb-4 text-white drop-shadow-sm" style="font-family: 'Montserrat', sans-serif;">
                    Secretarias Municipais
                </h1>
                <p class="text-lg text-blue-100 max-w-2xl leading-relaxed font-light">
                    Conheça a equipa que trabalha todos os dias para fazer de Assaí uma cidade cada vez melhor e mais inteligente.
                </p>
            </div>

            <div class="w-full md:w-96 lg:w-[30rem] shrink-0">
                <form action="{{ route('secretarias.index') }}" method="GET">
                    <div class="relative flex items-center w-full bg-white rounded-full border border-slate-400 hover:border-slate-500 focus-within:border-blue-500 focus-within:ring-4 focus-within:ring-blue-500/10 transition-all duration-300 p-1 h-[52px] sm:h-[58px] md:h-16">
                        <div class="flex items-center justify-center pl-3 sm:pl-4 md:pl-5 pr-1 sm:pr-2 text-slate-400 shrink-0">
                            <svg class="w-4 h-4 sm:w-5 sm:h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                            </svg>
                        </div>

                        <input
                            id="busca-secretaria"
                            type="text"
                            name="search"
                            value="{{ $termoBusca }}"
                            placeholder="Busque por secretaria ou responsável..."
                            class="flex-1 min-w-0 px-1 sm:px-2 py-2 text-sm md:text-base text-slate-700 bg-transparent border-none outline-none focus:ring-0 focus:outline-none font-sans placeholder:text-slate-400 placeholder:italic w-full truncate">

                        <button
                            type="submit"
                            class="h-full px-4 sm:px-6 md:px-8 font-bold text-xs sm:text-sm md:text-base text-blue-950 transition-all duration-200 bg-yellow-400 hover:bg-yellow-500 active:bg-yellow-600 active:scale-95 rounded-full shrink-0 font-heading select-none touch-manipulation">
                            Buscar
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</section>

<section class="py-12 max-[360px]:py-10 bg-[#edf5ff] md:py-16 min-h-[50vh] border-y border-blue-100/70">
    <div class="container px-4 mx-auto max-w-7xl">

        {{-- ===== GESTÃO EXECUTIVA DINÂMICA ===== --}}
        @if($prefeito || $vicePrefeito)
        <div class="mb-16">
            <div class="portal-section-title">
                <h2>Gestão Executiva</h2>
                <div class="bar"></div>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                {{-- Card Prefeito --}}
                @if($prefeito)
                <div class="flex flex-col sm:flex-row bg-white border border-slate-200/80 ring-1 ring-slate-100 rounded-3xl shadow-md hover:shadow-xl transition-all duration-300 overflow-hidden group">
                    <div class="w-full sm:w-48 h-72 sm:h-auto bg-slate-100 shrink-0 relative overflow-hidden">
                        <div class="absolute inset-0 bg-blue-900/10 z-10 group-hover:bg-transparent transition-colors duration-300"></div>
                        {{-- Se não houver foto cadastrada, cai para o fallback do asset --}}
                        <img src="{{ $prefeito->foto ? asset('img/' . $prefeito->foto) : asset('img/executivos/default.jpg') }}" alt="Prefeito {{ $prefeito->nome }}" class="w-full h-full object-cover object-top group-hover:scale-105 transition-transform duration-500" loading="lazy" decoding="async">
                    </div>
                    <div class="p-6 sm:p-8 flex flex-col justify-center flex-1">
                        <span class="inline-flex items-center gap-1.5 px-3 py-1 mb-4 text-xs font-bold tracking-wider uppercase text-yellow-800 bg-yellow-100 rounded-full w-max">
                            <svg class="w-3.5 h-3.5" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 2a1 1 0 011 1v1.323l3.954 1.582 1.599-.8a1 1 0 01.894 1.79l-1.233.616 1.738 5.42a1 1 0 01-.285 1.05A3.989 3.989 0 0115 15a3.989 3.989 0 01-2.667-1.019 1 1 0 01-.285-1.05l1.715-5.349L11 6.477V16h2a1 1 0 110 2H7a1 1 0 110-2h2V6.477L6.237 7.582l1.715 5.349a1 1 0 01-.285 1.05A3.989 3.989 0 015 15a3.989 3.989 0 01-2.667-1.019 1 1 0 01-.285-1.05l1.738-5.42-1.233-.617a1 1 0 01.894-1.788l1.599.799L9 4.323V3a1 1 0 011-1z" clip-rule="evenodd"></path>
                            </svg>
                            Prefeito Municipal
                        </span>
                        {{-- Nome Dinâmico --}}
                        <h3 class="text-2xl font-black text-slate-800 font-heading mb-2 group-hover:text-blue-700 transition-colors">{{ $prefeito->nome }}</h3>
                        {{-- Descrição Estática --}}
                        <p class="text-sm text-slate-600 leading-relaxed">Chefe do Poder Executivo. Responsável pela administração do município, planejamento estratégico e execução das políticas públicas.</p>
                    </div>
                </div>
                @endif

                {{-- Card Vice-Prefeito --}}
                @if($vicePrefeito)
                <div class="flex flex-col sm:flex-row bg-white border border-slate-200/80 ring-1 ring-slate-100 rounded-3xl shadow-md hover:shadow-xl transition-all duration-300 overflow-hidden group">
                    <div class="w-full sm:w-48 h-72 sm:h-auto bg-slate-100 shrink-0 relative overflow-hidden">
                        <div class="absolute inset-0 bg-blue-900/10 z-10 group-hover:bg-transparent transition-colors duration-300"></div>
                        {{-- Se não houver foto cadastrada, cai para o fallback do asset --}}
                        <img src="{{ $vicePrefeito->foto ? asset('img/' . $vicePrefeito->foto) : asset('img/executivos/default.jpg') }}" alt="Vice-Prefeito {{ $vicePrefeito->nome }}" class="w-full h-full object-cover object-top group-hover:scale-105 transition-transform duration-500" loading="lazy" decoding="async">
                    </div>
                    <div class="p-6 sm:p-8 flex flex-col justify-center flex-1">
                        <span class="inline-flex items-center gap-1.5 px-3 py-1 mb-4 text-xs font-bold tracking-wider uppercase text-blue-800 bg-blue-100 rounded-full w-max">
                            <svg class="w-3.5 h-3.5" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M13 6a3 3 0 11-6 0 3 3 0 016 0zM18 8a2 2 0 11-4 0 2 2 0 014 0zM14 15a4 4 0 00-8 0v3h8v-3zM6 8a2 2 0 11-4 0 2 2 0 014 0zM16 18v-3a5.972 5.972 0 00-.75-2.906A3.005 3.005 0 0119 15v3h-3zM4.75 12.094A5.973 5.973 0 004 15v3H1v-3a3 3 0 013.75-2.906z"></path>
                            </svg>
                            Vice-Prefeito
                        </span>
                        {{-- Nome Dinâmico --}}
                        <h3 class="text-2xl font-black text-slate-800 font-heading mb-2 group-hover:text-blue-700 transition-colors">{{ $vicePrefeito->nome }}</h3>
                        {{-- Descrição Estática --}}
                        <p class="text-sm text-slate-600 leading-relaxed">Substituto legal do Prefeito. Atua no auxílio à coordenação da administração municipal e representação institucional de Assaí.</p>
                    </div>
                </div>
                @endif
            </div>
        </div>
        @endif


    </div>
</section>

@endsection