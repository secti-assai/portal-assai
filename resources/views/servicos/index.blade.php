@extends('layouts.app')

@section('title', 'Serviços ao Cidadão - Prefeitura Municipal de Assaí')

@section('content')
@php
    $termoBusca = trim((string) request('search'));
    $secretariaAtiva = request('secretaria');
    $totalServicos = $servicos->total();
@endphp

{{-- ==========================================
    HERO SECTION (Cores originais Tailwind)
    ========================================== --}}
<section class="relative overflow-hidden bg-gradient-to-br from-blue-950 via-blue-900 to-blue-800 py-12 md:py-20 lg:py-24 shadow-inner">
        {{-- Elementos de Fundo Subtis --}}
        <div class="absolute inset-0 pointer-events-none">
            <div class="absolute inset-0 bg-[radial-gradient(circle_at_top_right,rgba(255,255,255,0.08),transparent_60%)]"></div>
            <div class="absolute -top-40 -right-32 w-96 h-96 bg-blue-800/30 rounded-full blur-3xl"></div>
            <div class="absolute -bottom-40 -left-32 w-96 h-96 bg-indigo-800/25 rounded-full blur-3xl"></div>
        </div>

        <div class="container relative z-10 px-4 sm:px-6 mx-auto max-w-7xl">
            
            <div class="flex flex-col md:flex-row md:items-end justify-between gap-6">
                
                {{-- Título e Breadcrumb --}}
                <div class="flex-1">
                    <x-breadcrumb :items="[
                        ['name' => 'Início', 'url' => route('home')],
                        ['name' => 'Serviços'],
                    ]" dark />

                    <h1 class="text-3xl font-extrabold md:text-5xl font-heading mb-4 text-white drop-shadow-sm" style="font-family: 'Montserrat', sans-serif;">
                        Serviços ao Cidadão
                    </h1>
                    <p class="text-lg text-blue-100 max-w-2xl leading-relaxed font-light">
                        Consulte os serviços disponíveis da Prefeitura de Assaí, encontre informações rápidas e acesse os canais oficiais de atendimento.
                    </p>
                </div>

                {{-- Barra de Pesquisa --}}
                <div class="w-full md:w-96 lg:w-[30rem] shrink-0">
                    <form method="GET" action="{{ route('servicos.index') }}">
                        @if($secretariaAtiva)
                        <input type="hidden" name="secretaria" value="{{ $secretariaAtiva }}">
                        @endif

                        <div class="relative flex items-center w-full bg-white rounded-full border border-slate-400 hover:border-slate-500 focus-within:border-blue-500 focus-within:ring-4 focus-within:ring-blue-500/10 transition-all duration-300 p-1 h-[52px] sm:h-[58px] md:h-16">

                            <div class="flex items-center justify-center pl-3 sm:pl-4 md:pl-5 pr-1 sm:pr-2 text-slate-400 shrink-0">
                                <svg class="w-4 h-4 sm:w-5 sm:h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                                </svg>
                            </div>
                            
                            <input 
                                id="search-servicos" 
                                type="text" 
                                name="search" 
                                value="{{ $termoBusca }}" 
                                placeholder="Busque por serviço, secretaria ou tema..." 
                                class="flex-1 min-w-0 px-1 sm:px-2 py-2 text-sm md:text-base text-slate-700 bg-transparent border-none outline-none focus:ring-0 focus:outline-none font-sans placeholder:text-slate-400 placeholder:italic w-full truncate"
                            />

                            <button 
                                type="submit" 
                                class="h-full px-4 sm:px-6 md:px-8 font-bold text-xs sm:text-sm md:text-base text-blue-950 transition-all duration-200 bg-yellow-400 hover:bg-yellow-500 active:bg-yellow-600 active:scale-95 rounded-full shrink-0 font-heading select-none touch-manipulation"
                            >
                                Buscar
                            </button>
                        </div>
                    </form>
                </div>
            </div>
            
        </div>
    </section>

    {{-- ==========================================
         FILTROS HORIZONTAIS COMPACTOS
         ========================================== --}}
    <section class="border-b border-slate-200 bg-white z-30 shadow-sm">
        <div class="container px-4 sm:px-6 py-4 mx-auto max-w-7xl">
            
            <form method="GET" action="{{ route('servicos.index') }}" class="flex flex-col sm:flex-row sm:items-center gap-4">
                {{-- Manter o termo de busca se existir --}}
                @if($termoBusca)
                <input type="hidden" name="search" value="{{ $termoBusca }}">
                @endif

                <div class="flex items-center gap-3 shrink-0">
                    <div class="w-9 h-9 rounded-full bg-blue-100 ring-1 ring-blue-200 flex items-center justify-center text-blue-700">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M7 12h10M10 18h4" />
                        </svg>
                    </div>
                    <label for="filtro-secretaria" class="text-sm font-bold text-slate-700 uppercase tracking-wider hidden sm:block" style="font-family: 'Montserrat', sans-serif;">
                        Filtrar por secretaria:
                    </label>
                </div>

                {{-- Caixa de Seleção das Secretarias --}}
                <div class="flex-1 flex items-center gap-3">
                    <div class="relative w-full sm:w-80 lg:w-96">
                        <select 
                            id="filtro-secretaria" 
                            name="secretaria" 
                            class="appearance-none w-full bg-slate-50 border border-slate-200 text-slate-700 py-2.5 pl-4 pr-10 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-600 focus:border-blue-600 text-sm font-medium transition-colors cursor-pointer"
                            onchange="this.form.submit()"
                        >
                            <option value="" class="font-bold">Todos os Serviços</option>
                            @foreach($secretarias as $sec)
                                <option value="{{ $sec->id }}" {{ $secretariaAtiva == $sec->id ? 'selected' : '' }}>
                                    {{ $sec->nome }}
                                </option>
                            @endforeach
                        </select>
                        <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-4 text-slate-500">
                            <i class="fa-solid fa-chevron-down text-xs"></i>
                        </div>
                    </div>
                </div>

                {{-- Mostrar resumo de filtros ativos / Limpar --}}
                @if($termoBusca || $secretariaAtiva)
                <div class="flex items-center shrink-0">
                    <a 
                        href="{{ route('servicos.index') }}" 
                        class="inline-flex items-center gap-1.5 text-xs font-bold text-red-600 bg-red-50 hover:bg-red-100 px-4 py-2.5 rounded-xl transition-colors border border-red-100"
                    >
                        <i class="fa-solid fa-xmark"></i>
                        Limpar Filtros
                    </a>
                </div>
                @endif
            </form>

        </div>
    </section>

    {{-- ==========================================
         GRID PRINCIPAL DE SERVIÇOS
         ========================================== --}}
    <section class="container px-4 sm:px-6 py-10 mx-auto max-w-7xl">
        
        <div class="mb-8">
            <p class="text-sm font-medium text-slate-500">
                <strong class="text-2xl text-blue-900" style="font-family: 'Montserrat', sans-serif;">{{ $totalServicos }}</strong>
                <span class="ml-1 text-slate-600">serviço(s) encontrado(s)</span>
                @if($termoBusca)
                <span class="block sm:inline text-sm font-normal text-slate-500 mt-1 sm:mt-0">
                    para a busca <span class="font-bold text-blue-800">"{{ $termoBusca }}"</span>
                </span>
                @endif
            </p>
        </div>

        @if($servicos->isEmpty())
        <div class="bg-white rounded-3xl border border-slate-200 py-20 px-6 text-center flex flex-col items-center shadow-sm max-w-3xl mx-auto mt-10">
            <div class="flex h-20 w-20 items-center justify-center rounded-2xl bg-blue-50 text-blue-400 text-3xl mb-6">
                <i class="fa-solid fa-magnifying-glass-minus"></i>
            </div>
            <h2 class="text-xl lg:text-2xl font-bold text-slate-800 mb-2" style="font-family: 'Montserrat', sans-serif;">Nenhum serviço encontrado</h2>
            <p class="text-slate-500 max-w-md mx-auto">
                Não encontrámos serviços correspondentes aos filtros aplicados. Tente usar outros termos de busca ou selecione "Todos os Serviços".
            </p>
            <a href="{{ route('servicos.index') }}" class="mt-8 bg-blue-700 text-white px-8 py-3 rounded-xl font-bold hover:bg-blue-800 transition-colors shadow-md">
                Ver Todos os Serviços
            </a>
        </div>
        @else
        
        {{-- Alterado para lg:grid-cols-3 para exibir 3 colunas em ecrãs grandes --}}
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 lg:gap-8">
            @foreach($servicos as $servico)
            
            @php
                $iconeBruto = trim((string) ($servico->icone ?? ''));
                $temPrefixoFa = Str::contains($iconeBruto, ['fa-solid', 'fa-regular', 'fa-brands', 'fas', 'far', 'fab', 'fal', 'fad']);
                $iconeClasse = '';

                if ($iconeBruto !== '') {
                    if ($temPrefixoFa) {
                        $iconeClasse = $iconeBruto;
                    } elseif (Str::startsWith($iconeBruto, 'fa-')) {
                        $iconeClasse = 'fa-solid ' . $iconeBruto;
                    } else {
                        $iconeClasse = 'fa-solid fa-' . $iconeBruto;
                    }
                } else {
                    $iconeClasse = 'fa-solid fa-file-lines';
                }
            @endphp

            <article class="group bg-white rounded-2xl border border-slate-300/80 ring-1 ring-slate-200/80 p-6 flex flex-col h-full shadow-md hover:shadow-xl hover:-translate-y-1 hover:border-blue-400 transition-all duration-300 relative">
                
                <div class="flex items-start gap-4 mb-4">
                    <div class="flex h-14 w-14 items-center justify-center rounded-2xl bg-blue-100 text-blue-700 ring-1 ring-blue-200 shrink-0 group-hover:scale-110 group-hover:bg-blue-700 group-hover:text-white transition-all duration-300">
                        <i class="{{ $iconeClasse }} text-[1.35rem]"></i>
                    </div>
                    
                    <div class="flex-1 min-w-0 pt-1">
                        {{-- Removido o line-clamp-2 do título --}}
                        <h3 class="text-lg font-extrabold text-slate-900 leading-tight mb-2 group-hover:text-blue-700 transition-colors" style="font-family: 'Montserrat', sans-serif;">
                            {{ $servico->titulo }}
                        </h3>
                        @if($servico->secretaria)
                        <span class="inline-block bg-slate-100 text-slate-600 text-[10px] font-bold uppercase tracking-widest px-2.5 py-1 rounded w-fit border border-slate-200">
                            {{ $servico->secretaria->nome }}
                        </span>
                        @endif
                    </div>
                </div>

                {{-- Removido o line-clamp-3 e o Str::limit da descrição --}}
                <p class="text-sm text-slate-700 leading-relaxed mb-6 flex-grow">
                    {{ $servico->descricao ? strip_tags($servico->descricao) : 'Informações e acesso para este serviço oferecido ao cidadão.' }}
                </p>

                <div class="mt-auto border-t border-slate-200 pt-4 flex justify-between items-center">
                    <span class="text-[10px] font-bold uppercase tracking-widest text-slate-500">Acesso Rápido</span>
                    
                    <a 
                        href="{{ $servico->url_acesso ?? $servico->link ?? '#' }}" 
                        target="_blank" 
                        rel="noopener noreferrer" 
                        class="inline-flex items-center justify-center w-9 h-9 rounded-full bg-slate-50 text-blue-700 border border-slate-300 hover:bg-blue-700 hover:text-white transition-all duration-300 group/btn"
                        aria-label="Acessar {{ $servico->titulo }}"
                    >
                        <i class="fa-solid fa-arrow-right transition-transform group-hover/btn:translate-x-0.5"></i>
                    </a>
                </div>
            </article>
            @endforeach
        </div>

        @if($servicos->hasPages())
        <div class="mt-12 pt-8 border-t border-slate-200">
            <div class="flex justify-center">
                {{ $servicos->links('components.pagination.agenda-style') }}
            </div>
        </div>
        @endif
        
        @endif

    </section>
</div>
@endsection