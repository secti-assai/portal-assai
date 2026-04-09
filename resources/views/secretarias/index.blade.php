@extends('layouts.app')

@section('title', 'Secretarias Municipais - Prefeitura Municipal de Assaí')

@section('content')
    @php
        $termoBusca = trim((string) request('search'));
    @endphp

    {{-- ===== CABEÇALHO PADRONIZADO ===== --}}
    <section class="relative overflow-hidden bg-gradient-to-br from-blue-950 via-blue-900 to-blue-800 py-8 sm:py-12 shadow-inner">
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

                    <h1 class="text-3xl sm:text-4xl font-extrabold text-white mt-4 tracking-tight drop-shadow-sm" style="font-family: 'Montserrat', sans-serif;">
                        Secretarias Municipais
                    </h1>
                    <p class="text-sm sm:text-base text-blue-100 max-w-2xl mt-3 leading-relaxed">
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
                                class="flex-1 min-w-0 px-1 sm:px-2 py-2 text-sm md:text-base text-slate-700 bg-transparent border-none outline-none focus:ring-0 focus:outline-none font-sans placeholder:text-slate-400 placeholder:italic w-full truncate"
                            >

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

    <section class="py-12 max-[360px]:py-10 bg-[#edf5ff] md:py-16 min-h-[50vh] border-y border-blue-100/70">
        <div class="container px-4 mx-auto max-w-7xl">

            <div class="portal-section-title">
                <h2>Secretarias e Responsáveis</h2>
                <div class="bar"></div>
            </div>

            <div id="grid-secretarias" class="grid grid-cols-1 gap-6 md:grid-cols-2 lg:grid-cols-3">
                @forelse($secretarias as $secretaria)
                          <a href="{{ route('secretarias.show', $secretaria->id) }}"
                              class="flex flex-col bg-white border border-slate-300/80 ring-1 ring-slate-200/80 rounded-3xl shadow-[0_10px_24px_rgba(15,23,42,0.12)] hover:shadow-[0_16px_34px_rgba(15,23,42,0.16)] transition-all duration-300 overflow-hidden group">

                        {{-- Cabeçalho do Card: Avatar + Nome --}}
                        <div class="bg-slate-100/70 p-6 border-b border-slate-200 flex items-center gap-4">
                            @if($secretaria->foto)
                                <img src="{{ asset('storage/' . $secretaria->foto) }}"
                                     alt="{{ $secretaria->nome_secretario }}"
                                     class="w-16 h-16 rounded-full object-cover shadow-md ring-4 ring-white shrink-0"
                                     loading="lazy" decoding="async">
                            @else
                                @php
                                    $partes = explode(' ', trim($secretaria->nome_secretario ?? ''));
                                    $iniciais = count($partes) >= 2
                                        ? mb_strtoupper(mb_substr($partes[0], 0, 1) . mb_substr(end($partes), 0, 1))
                                        : mb_strtoupper(mb_substr($partes[0] ?? 'S', 0, 2));
                                @endphp
                                <div class="w-16 h-16 rounded-full bg-blue-100 text-blue-600 font-bold text-xl flex items-center justify-center shrink-0 ring-4 ring-white shadow-md">
                                    {{ $iniciais }}
                                </div>
                            @endif

                            <div class="min-w-0">
                                <h2 class="text-lg md:text-xl font-black text-slate-800 leading-tight group-hover:text-blue-700 transition line-clamp-3 break-words" title="{{ $secretaria->nome }}">
                                    {{ $secretaria->nome }}
                                </h2>
                                @if($secretaria->nome_secretario)
                                    <p class="text-sm font-semibold text-blue-600 mt-2 truncate" title="{{ $secretaria->nome_secretario }}">{{ \Illuminate\Support\Str::limit($secretaria->nome_secretario, 70) }}</p>
                                @endif
                            </div>
                        </div>

                        {{-- Corpo do Card: Contatos --}}
                        <div class="p-6 flex-1 flex flex-col gap-3">
                            @if($secretaria->telefone)
                                <div class="flex items-start gap-3 text-sm text-slate-700">
                                    <svg class="w-4 h-4 mt-0.5 text-slate-600 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/></svg>
                                    <span>{{ $secretaria->telefone }}</span>
                                </div>
                            @endif

                            @if($secretaria->email)
                                <div class="flex items-start gap-3 text-sm text-slate-700 min-w-0">
                                    <svg class="w-4 h-4 mt-0.5 text-slate-600 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
                                    <span class="truncate block min-w-0" title="{{ $secretaria->email }}">{{ $secretaria->email }}</span>
                                </div>
                            @endif

                            @if($secretaria->endereco)
                                <div class="flex items-start gap-3 text-sm text-slate-700">
                                    <svg class="w-4 h-4 mt-0.5 text-slate-600 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                                    <span>{{ $secretaria->endereco }}</span>
                                </div>
                            @endif
                        </div>

                        {{-- Rodapé: CTA --}}
                        <div class="px-6 pb-6 mt-auto">
                            <span class="flex items-center justify-center gap-2 w-full py-2.5 text-sm font-bold text-white bg-blue-700 border border-blue-700 rounded-xl group-hover:bg-blue-800 group-hover:border-blue-800 transition-colors">
                                Ver Detalhes e Serviços
                                <svg class="w-4 h-4 transition-transform group-hover:translate-x-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                            </span>
                        </div>

                    </a>
                @empty
                    <div class="flex flex-col overflow-hidden transition-all duration-300 bg-slate-50 border shadow-md hover:shadow-xl rounded-2xl border-slate-300/70 ring-1 ring-slate-200/70">
                        <div class="relative flex flex-col items-center p-6 text-center bg-slate-100 border-b border-slate-200">
                            <div class="flex items-center justify-center w-24 h-24 mb-4 bg-white border-2 border-dashed rounded-full text-slate-300 border-slate-300">
                                <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                            </div>
                            <h2 class="text-xl font-bold text-slate-800 font-heading">Secretaria de Ciência, Tecnologia e Inovação</h2>
                            <p class="text-sm font-bold text-blue-600 uppercase tracking-wide mt-1">Rodrigo</p>
                        </div>

                        <div class="flex flex-col flex-1 p-6">
                            <p class="mb-6 text-sm text-slate-700">Responsável por impulsionar o desenvolvimento tecnológico, modernizar os serviços da prefeitura e gerir projetos inovadores como o Hub Vale do Sol.</p>

                            <div class="mt-auto space-y-3 text-sm text-slate-600 font-medium">
                                <div class="flex items-start gap-3">
                                    <svg class="w-5 h-5 text-yellow-500 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path></svg>
                                    <span>(43) 3262-XXXX</span>
                                </div>
                                <div class="flex items-start gap-3">
                                    <svg class="w-5 h-5 text-yellow-500 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
                                    <span>tecnologia@assai.pr.gov.br</span>
                                </div>
                                <div class="flex items-start gap-3">
                                    <svg class="w-5 h-5 text-yellow-500 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                                    <span>Paço Municipal - Assaí, PR</span>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforelse
            </div>

            @if($secretarias instanceof \Illuminate\Contracts\Pagination\Paginator || $secretarias instanceof \Illuminate\Contracts\Pagination\LengthAwarePaginator)
                <div class="mt-10">
                    {{ $secretarias->links('components.pagination.agenda-style') }}
                </div>
            @endif

        </div>
    </section>

@endsection