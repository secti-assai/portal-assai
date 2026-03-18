@extends('layouts.app')

@section('title', 'Serviços ao Cidadão - Prefeitura Municipal de Assaí')

@section('content')

{{-- ===== CABEÇALHO PADRONIZADO ===== --}}
<section class="relative py-12 overflow-hidden bg-blue-900 md:py-20 lg:py-24">
    {{-- Textura Vetorial e Gradiente de Profundidade --}}
    <div class="absolute inset-0 pointer-events-none">
        <svg class="absolute w-full h-full opacity-40 text-blue-800" xmlns="http://www.w3.org/2000/svg">
            <defs>
                <pattern id="grid-pattern" width="40" height="40" patternUnits="userSpaceOnUse">
                    <path d="M 40 0 L 0 0 0 40" fill="none" stroke="currentColor" stroke-width="0.5" />
                </pattern>
            </defs>
            <rect width="100%" height="100%" fill="url(#grid-pattern)" />
        </svg>
        <div class="absolute inset-y-0 right-0 w-full bg-gradient-to-l from-blue-950/70 via-blue-900/35 to-transparent"></div>
        <div class="absolute bottom-0 left-0 right-0 h-32 bg-gradient-to-t from-blue-950 to-transparent"></div>
    </div>

    <div class="container relative z-10 px-4 mx-auto max-w-7xl text-left">
        <div class="flex flex-col gap-8 lg:flex-row lg:items-end lg:justify-between">
            <div>
                <x-breadcrumb :items="[
                        ['name' => 'Início', 'url' => route('home')],
                        ['name' => 'Serviços'],
                    ]" dark />

                <h1 class="text-3xl font-extrabold text-white md:text-5xl font-heading mb-4">Serviços ao Cidadão</h1>
                <p class="text-lg text-blue-100 max-w-2xl leading-relaxed font-light mb-8">Encontre rapidamente os serviços digitais e presenciais oferecidos pela Prefeitura de Assaí.</p>

                {{-- Barra de busca --}}
                <form method="GET" action="{{ route('servicos.index') }}" class="flex flex-col sm:flex-row gap-2 max-w-xl">
                    @if(request('secretaria'))
                    <input type="hidden" name="secretaria" value="{{ request('secretaria') }}">
                    @endif
                    <div class="relative flex-1">
                        <span class="absolute inset-y-0 left-4 flex items-center pointer-events-none text-white/40">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                            </svg>
                        </span>
                        <input type="text" name="search" value="{{ request('search') }}"
                            placeholder="Buscar serviço..."
                            class="w-full py-3 pl-12 pr-4 text-sm text-white bg-white/10 border border-white/20 rounded-xl placeholder-white/40 focus:outline-none focus:ring-2 focus:ring-white/30 focus:bg-white/15 transition">
                    </div>
                    <button type="submit"
                        class="px-5 py-3 text-sm font-bold text-blue-900 bg-yellow-400 rounded-xl hover:bg-yellow-300 transition shrink-0 w-full sm:w-auto">
                        Buscar
                    </button>
                </form>
            </div>

            <div class="inline-flex w-fit self-start lg:self-auto flex-col items-center justify-center gap-1 px-3 py-2 rounded-xl bg-white border border-white/80 shadow-xl text-center">
                <span class="text-[10px] font-semibold text-slate-500 uppercase tracking-widest">Powered by</span>
                <img src="{{ asset('img/conecta.png') }}" alt="Conecta Assaí" class="w-36 md:w-32 h-auto" loading="lazy" decoding="async">
            </div>
        </div>
    </div>
</section>

{{-- ===== CONTEÚDO PRINCIPAL ===== --}}
<div class="container px-4 mx-auto max-w-6xl py-10">
    <div class="grid grid-cols-1 lg:grid-cols-4 gap-8">

        {{-- ===== SIDEBAR: FILTROS ===== --}}
        <aside class="lg:col-span-1">
            <div class="lg:sticky lg:top-8 bg-white border border-slate-100 rounded-2xl shadow-md hover:shadow-xl transition-all duration-300 p-6">
                <h2 class="text-xs font-black uppercase tracking-widest text-slate-500 mb-4">Filtrar por Secretaria</h2>

                <ul class="space-y-1 text-sm">
                    <li>
                        <a href="{{ route('servicos.index', request()->only('search')) }}"
                            class="flex items-center gap-2 px-3 py-2 rounded-lg transition
                                      {{ !request('secretaria') ? 'bg-blue-50 font-bold text-blue-700' : 'text-slate-600 hover:bg-slate-100/50' }}">
                            <svg class="w-4 h-4 shrink-0 {{ !request('secretaria') ? 'text-blue-500' : 'text-slate-300' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                            </svg>
                            Todos os Serviços
                        </a>
                    </li>
                    @foreach($secretarias as $sec)
                    <li>
                        <a href="{{ route('servicos.index', array_merge(request()->only('search'), ['secretaria' => $sec->id])) }}"
                            class="flex items-center gap-2 px-3 py-2 rounded-lg transition
                                      {{ request('secretaria') == $sec->id ? 'bg-blue-50 font-bold text-blue-700' : 'text-slate-600 hover:bg-slate-100/50' }}">
                            <svg class="w-4 h-4 shrink-0 {{ request('secretaria') == $sec->id ? 'text-blue-500' : 'text-slate-300' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                            </svg>
                            {{ $sec->nome }}
                        </a>
                    </li>
                    @endforeach
                </ul>
            </div>
        </aside>

        {{-- ===== FEED DE SERVIÇOS ===== --}}
        <section class="lg:col-span-3">

            {{-- Cabeçalho do feed --}}
            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3 mb-6">
                <p class="text-sm text-slate-500">
                    <span class="font-bold text-slate-700">{{ $servicos->total() }}</span> serviço(s) encontrado(s)
                    @if(request('search'))
                    para <span class="font-semibold text-blue-700">"{{ request('search') }}"</span>
                    @endif
                </p>
                @if(request('search') || request('secretaria'))
                <a href="{{ route('servicos.index') }}" class="text-xs font-semibold text-slate-500 hover:text-red-500 transition flex items-center gap-1">
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                    Limpar filtros
                </a>
                @endif
            </div>

            @if($servicos->isEmpty())
            {{-- Empty state --}}
            <div class="flex flex-col items-center justify-center py-20 text-center bg-white border-2 border-dashed border-slate-200 rounded-2xl">
                <svg class="w-16 h-16 text-slate-300 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                </svg>
                <h3 class="text-lg font-bold text-slate-600 mb-1">Nenhum serviço encontrado</h3>
                <p class="text-sm text-slate-500 max-w-xs">Tente outros termos ou remova os filtros ativos.</p>
                <a href="{{ route('servicos.index') }}" class="mt-5 px-5 py-2.5 text-sm font-bold text-blue-700 bg-blue-50 rounded-xl hover:bg-blue-100 transition">
                    Ver todos os serviços
                </a>
            </div>
            @else
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach($servicos as $servico)
                <div class="flex flex-col h-full bg-white border border-slate-100 rounded-2xl shadow-md hover:shadow-xl hover:-translate-y-1 transition-all duration-300">
                    <div class="flex flex-col flex-1 p-6">

                        {{-- Ícone --}}
                        <svg class="w-10 h-10 text-blue-600 mb-4 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            @switch($servico->icone)
                            @case('saude')
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z" />
                            @break
                            @case('vagas')
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                            @break
                            @case('documentos')
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                            @break
                            @case('ouvidoria')
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M11 5.882V19.24a1.76 1.76 0 01-3.417.592l-2.147-6.15M18 13a3 3 0 100-6M5.436 13.683A4.001 4.001 0 017 6h1.832c4.1 0 7.625-1.234 9.168-3v14c-1.543-1.766-5.067-3-9.168-3H7a3.988 3.988 0 01-1.564-.317z" />
                            @break
                            @case('alvara')
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4" />
                            @break
                            @case('educacao')
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 14l9-5-9-5-9 5 9 5z" />
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 14l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0012 20.055a11.952 11.952 0 00-6.824-2.998 12.078 12.078 0 01.665-6.479L12 14z" />
                            @break
                            @default
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M15 15l-2 5L9 9l11 4-5 2zm0 0l5 5M7.188 2.239l.777 2.897M5.136 7.965l-2.898-.777M13.95 4.05l-2.122 2.122m-5.657 5.656l-2.12 2.122" />
                            @endswitch
                        </svg>

                        {{-- Secretaria badge --}}
                        <span class="text-xs font-semibold text-slate-500 mb-1 uppercase tracking-wide block truncate w-full" title="{{ $servico->secretaria->nome ?? 'Administração Geral' }}">
                            {{ \Illuminate\Support\Str::limit($servico->secretaria->nome ?? 'Administração Geral', 55) }}
                        </span>

                        {{-- Título --}}
                        <h3 class="text-lg font-bold text-slate-800 leading-snug mb-2 line-clamp-2 break-words" title="{{ $servico->titulo }}">
                            {{ \Illuminate\Support\Str::limit($servico->titulo, 100) }}
                        </h3>

                        {{-- Botão CTA --}}
                        <div class="mt-auto pt-4 border-t border-slate-100">
                            <a href="{{ $servico->url_acesso ?? $servico->link ?? '#' }}"
                                target="_blank" rel="noopener noreferrer"
                                class="flex items-center justify-center gap-2 w-full py-2 text-sm font-bold text-blue-700 bg-blue-50 rounded-xl hover:bg-blue-600 hover:text-white transition">
                                Acessar Serviço
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14" />
                                </svg>
                            </a>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>

            {{-- Paginação --}}
            @if($servicos->hasPages())
            <div class="mt-10">
                {{ $servicos->links() }}
            </div>
            @endif
            @endif

        </section>

    </div>
</div>

@endsection