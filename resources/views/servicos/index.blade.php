@extends('layouts.app')

@section('title', 'Serviços ao Cidadão - Prefeitura Municipal de Assaí')

@section('content')
@php
    $termoBusca = trim((string) request('search'));
    $secretariaAtiva = request('secretaria');
    $totalServicos = $servicos->total();
@endphp

<main class="min-h-screen bg-gradient-to-b from-slate-50/50 via-white to-blue-50/30">
    <!-- Hero Section -->
    <section class="relative overflow-hidden bg-gradient-to-br from-blue-950 via-blue-900 to-blue-800 py-12 sm:py-16 lg:py-24">
        <!-- Background Effects -->
        <div class="absolute inset-0 pointer-events-none">
            <div class="absolute inset-0 bg-[radial-gradient(circle_at_top_right,rgba(255,255,255,0.08),transparent_60%)]"></div>
            <div class="absolute -top-40 -right-32 w-96 h-96 bg-blue-800/30 rounded-full blur-3xl"></div>
            <div class="absolute -bottom-40 -left-32 w-96 h-96 bg-indigo-800/25 rounded-full blur-3xl"></div>
        </div>

        <!-- Content -->
        <div class="relative z-10 px-4 sm:px-6 mx-auto max-w-7xl">
            <x-breadcrumb :items="[
                ['name' => 'Início', 'url' => route('home')],
                ['name' => 'Serviços'],
            ]" dark />

            <div class="mt-8 max-w-3xl">
                <div class="inline-flex items-center gap-2.5 px-4 py-2 mb-6 text-xs font-bold tracking-wide uppercase rounded-full bg-white/15 ring-1 ring-white/25 text-blue-100 hover:bg-white/20 transition-colors">
                    <span class="w-2.5 h-2.5 rounded-full bg-emerald-300 animate-pulse"></span>
                    <span>Portal de Serviços Públicos</span>
                </div>

                <h1 class="text-5xl sm:text-6xl lg:text-7xl font-black leading-tight text-white mb-4">
                    Serviços ao Cidadão
                </h1>

                <p class="text-lg sm:text-xl leading-relaxed text-blue-50 max-w-2xl">
                    Encontre com rapidez todos os serviços digitais e presenciais oferecidos pela Prefeitura Municipal de Assaí. Busque, filtre e acesse em segundos.
                </p>

                <!-- Search Bar -->
                <form method="GET" action="{{ route('servicos.index') }}" class="mt-10 sm:mt-12">
                    @if($secretariaAtiva)
                    <input type="hidden" name="secretaria" value="{{ $secretariaAtiva }}">
                    @endif

                    <div class="flex flex-col gap-3 sm:gap-4 sm:flex-row">
                        <div class="relative flex-1">
                            <span class="absolute inset-y-0 left-4 flex items-center text-white/50">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                                </svg>
                            </span>
                            <input 
                                id="search-servicos" 
                                type="text" 
                                name="search" 
                                value="{{ $termoBusca }}" 
                                placeholder="Buscar um serviço..." 
                                class="w-full rounded-xl border border-white/20 bg-white/12 px-12 py-4 text-base text-white placeholder:text-blue-100/60 shadow-2xl backdrop-blur-sm outline-none transition-all focus:border-white/40 focus:bg-white/20 focus:ring-2 focus:ring-white/20"
                            />
                        </div>

                        <button 
                            type="submit" 
                            class="portal-btn-primary px-8 py-4 font-bold text-base rounded-xl shadow-xl hover:shadow-2xl transition-all duration-200 transform hover:scale-105 active:scale-95"
                        >
                            <span class="flex items-center justify-center gap-2">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                                </svg>
                                Buscar
                            </span>
                        </button>
                    </div>

                    <!-- Active Filters -->
                    @if($termoBusca || $secretariaAtiva)
                    <div class="mt-6 flex flex-wrap items-center gap-2">
                        <span class="inline-flex items-center gap-1.5 text-xs font-bold uppercase tracking-wider rounded-full bg-white/15 px-3.5 py-2 ring-1 ring-white/25 text-white">
                            <svg class="w-3.5 h-3.5 opacity-70" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                            </svg>
                            Filtros Ativos
                        </span>
                        @if($termoBusca)
                        <span class="inline-flex items-center gap-2 text-xs font-bold rounded-full bg-emerald-500/25 px-3.5 py-2 ring-1 ring-emerald-400/50 text-emerald-100">
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            {{ \Illuminate\Support\Str::limit($termoBusca, 25) }}
                        </span>
                        @endif
                        @if($secretariaAtiva)
                        <span class="inline-flex items-center gap-2 text-xs font-bold rounded-full bg-blue-400/25 px-3.5 py-2 ring-1 ring-blue-400/50 text-blue-100">
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            Secretaria Ativa
                        </span>
                        @endif
                    </div>
                    @endif
                </form>
            </div>
        </div>
    </section>

    <!-- Main Content Section -->
    <section class="relative z-10 px-4 sm:px-6 py-12 sm:py-16 lg:py-20 mx-auto max-w-7xl">
        <div class="grid grid-cols-1 gap-10 lg:grid-cols-[300px_minmax(0,1fr)] xl:grid-cols-[320px_minmax(0,1fr)]">
            <!-- Sidebar Filter -->
            <aside class="lg:sticky lg:top-8 lg:h-fit">
                <div class="portal-card overflow-hidden shadow-sm hover:shadow-md transition-shadow duration-300">
                    <div class="border-b border-slate-200 bg-gradient-to-r from-blue-50 to-indigo-50 px-6 py-5">
                        <p class="text-sm font-black uppercase tracking-widest text-slate-700 flex items-center gap-2">
                            <svg class="w-4 h-4 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z" />
                            </svg>
                            Filtrar por Secretaria
                        </p>
                    </div>

                    <div class="p-5 max-h-[500px] overflow-y-auto lg:max-h-[70vh]">
                        <!-- All Services Option -->
                        <a 
                            href="{{ route('servicos.index', request()->only('search')) }}" 
                            class="flex items-center gap-3.5 rounded-lg px-4 py-3.5 text-sm font-bold transition-all duration-200 {{ !$secretariaAtiva ? 'bg-blue-100 text-blue-900 ring-2 ring-blue-200 shadow-sm' : 'text-slate-600 hover:bg-slate-50 text-slate-700' }}"
                        >
                            <span class="flex h-8 w-8 items-center justify-center rounded-lg {{ !$secretariaAtiva ? 'bg-blue-600 text-white' : 'bg-slate-200 text-slate-500' }}">
                                <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 6V4m0 2a2 2 0 100 4m0-4a2 2 0 110 4m-6 8a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4m6 6v10m6-2a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4" />
                                </svg>
                            </span>
                            <span>Todos os Serviços</span>
                        </a>

                        <!-- Secretarias List -->
                        <div class="mt-4 space-y-2 pt-4 border-t border-slate-200">
                            @foreach($secretarias as $sec)
                            <a 
                                href="{{ route('servicos.index', array_merge(request()->only('search'), ['secretaria' => $sec->id])) }}" 
                                class="flex items-center gap-3 rounded-lg px-4 py-3 text-sm font-medium transition-all duration-200 {{ $secretariaAtiva == $sec->id ? 'bg-blue-100 text-blue-900 ring-2 ring-blue-200 shadow-sm font-bold' : 'text-slate-600 hover:bg-slate-50' }}"
                            >
                                <span class="flex h-8 w-8 items-center justify-center rounded-lg {{ $secretariaAtiva == $sec->id ? 'bg-blue-600 text-white' : 'bg-slate-200 text-slate-500' }}">
                                    <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M13 7h8m0 0v8m0-8L5.586 18.586a2 2 0 01-2.828 0l-2.828-2.828a2 2 0 010-2.828L7.172 9" />
                                    </svg>
                                </span>
                                <span class="flex-1 truncate">{{ $sec->nome }}</span>
                            </a>
                            @endforeach
                        </div>
                    </div>
                </div>
            </aside>

            <!-- Services Grid -->
            <section>
                <!-- Results Header -->
                <div class="pb-6 border-b border-slate-200">
                    <div class="flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
                        <div>
                            <p class="text-base sm:text-lg font-bold text-slate-700">
                                <span class="text-2xl font-black text-blue-900">{{ $totalServicos }}</span>
                                <span class="ml-2">serviço(s) encontrado(s)</span>
                                @if($termoBusca)
                                <span class="block sm:inline text-sm font-normal text-slate-500 mt-1 sm:mt-0">
                                    para <span class="font-bold text-blue-800">"{{ $termoBusca }}"</span>
                                </span>
                                @endif
                            </p>
                        </div>

                        @if($termoBusca || $secretariaAtiva)
                        <a 
                            href="{{ route('servicos.index') }}" 
                            class="inline-flex items-center justify-center gap-2 rounded-lg border-2 border-slate-200 bg-white px-5 py-2.5 text-sm font-bold text-slate-600 transition-all hover:border-red-300 hover:bg-red-50 hover:text-red-600 hover:shadow-md active:scale-95"
                        >
                            <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M6 18L18 6M6 6l12 12" />
                            </svg>
                            Limpar Filtros
                        </a>
                        @endif
                    </div>
                </div>

                <!-- Services Grid or Empty State -->
                @if($servicos->isEmpty())
                <div class="mt-12 flex flex-col items-center justify-center py-20 px-6 text-center">
                    <div class="flex h-20 w-20 items-center justify-center rounded-2xl bg-gradient-to-br from-blue-50 to-indigo-50 ring-1 ring-blue-100">
                        <svg class="h-10 w-10 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                        </svg>
                    </div>
                    <h2 class="mt-6 text-2xl font-black text-slate-900">Nenhum serviço encontrado</h2>
                    <p class="mt-3 max-w-md text-base leading-relaxed text-slate-600">
                        Tente ajustar a busca, mudar a secretaria ou remover os filtros ativos para encontrar o que você procura.
                    </p>
                    <a href="{{ route('servicos.index') }}" class="portal-btn-primary mt-8 px-8 py-3.5 rounded-lg font-bold">
                        Ver Todos os Serviços
                    </a>
                </div>
                @else
                <div class="mt-10 grid grid-cols-1 gap-6 sm:grid-cols-2 xl:grid-cols-3">
                    @foreach($servicos as $servico)
                    <article class="portal-card group overflow-hidden shadow-sm hover:shadow-lg transition-all duration-300 transform hover:scale-105 hover:-translate-y-1">
                        <div class="flex h-full flex-col p-6 sm:p-7">
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
                                }
                            @endphp

                            <!-- Icon and Badge -->
                            <div class="flex items-start justify-between gap-3 mb-4">
                                <div class="flex h-14 w-14 items-center justify-center rounded-xl bg-gradient-to-br from-blue-50 to-indigo-50 text-blue-700 ring-2 ring-blue-100 flex-shrink-0">
                                    @if($iconeClasse !== '')
                                        <i class="{{ $iconeClasse }} text-2xl" aria-hidden="true"></i>
                                    @else
                                        <i class="fa-solid fa-circle-check text-2xl" aria-hidden="true"></i>
                                    @endif
                                </div>

                                @if($servico->secretaria)
                                <span class="inline-flex shrink-0 items-center rounded-lg bg-slate-100 px-3 py-1.5 text-[11px] font-bold uppercase tracking-wide text-slate-600 ring-1 ring-slate-200">
                                    {{ \Illuminate\Support\Str::limit($servico->secretaria->nome, 20) }}
                                </span>
                                @endif
                            </div>

                            <!-- Title -->
                            <h3 class="text-lg font-black leading-snug text-slate-900 group-hover:text-blue-700 transition-colors line-clamp-2 mb-3">
                                {{ \Illuminate\Support\Str::limit($servico->titulo, 90) }}
                            </h3>

                            <!-- Description -->
                            @if($servico->descricao)
                            <p class="text-sm leading-relaxed text-slate-600 line-clamp-3 mb-5 flex-grow">
                                {{ \Illuminate\Support\Str::limit(strip_tags($servico->descricao), 150) }}
                            </p>
                            @endif

                            <!-- Footer with Button -->
                            <div class="mt-auto pt-5 border-t border-slate-100 flex items-center justify-between gap-3">
                                <span class="text-xs font-bold uppercase tracking-wide text-slate-400">Acesse Agora</span>
                                <a 
                                    href="{{ $servico->url_acesso ?? $servico->link ?? '#' }}" 
                                    target="_blank" 
                                    rel="noopener noreferrer" 
                                    class="inline-flex items-center gap-2.5 rounded-lg bg-gradient-to-br from-blue-700 to-blue-900 px-5 py-2.5 text-xs font-bold text-white transition-all hover:from-blue-600 hover:to-blue-800 hover:shadow-lg active:scale-95 focus:outline-none focus:ring-2 focus:ring-blue-300"
                                >
                                    Acessar
                                    <svg class="h-3.5 w-3.5 transition-transform group-hover:translate-x-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14" />
                                    </svg>
                                </a>
                            </div>
                        </div>
                    </article>
                    @endforeach
                </div>

                <!-- Pagination -->
                @if($servicos->hasPages())
                <div class="mt-14 pt-8 border-t border-slate-200">
                    <div class="flex justify-center">
                        {{ $servicos->links() }}
                    </div>
                </div>
                @endif
                @endif
            </section>
        </div>
    </section>
</main>

@endsection