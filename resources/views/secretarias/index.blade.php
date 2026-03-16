@extends('layouts.app')

@section('title', 'Secretarias Municipais - Prefeitura Municipal de Assaí')

@section('content')
    <section class="py-12 bg-blue-900 md:py-16">
        <div class="container px-4 mx-auto max-w-7xl">
            <x-breadcrumb :items="[
                ['name' => 'Início', 'url' => route('home')],
                ['name' => 'Secretarias'],
            ]" dark />
            <h1 class="text-3xl font-extrabold text-white md:text-5xl font-heading">Secretarias Municipais</h1>
            <p class="mt-4 text-lg text-blue-100 max-w-2xl">Conheça a equipa que trabalha todos os dias para fazer de Assaí uma cidade cada vez melhor e mais inteligente.</p>

            <div class="relative mt-8 w-full md:max-w-md">
                <span class="absolute inset-y-0 left-4 flex items-center pointer-events-none text-white/50">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                    </svg>
                </span>
                <input
                    id="busca-secretaria"
                    type="text"
                    placeholder="Buscar secretaria..."
                    class="w-full py-3 pl-12 pr-4 text-sm text-white bg-white/10 border border-white/20 rounded-xl placeholder-white/50 focus:outline-none focus:ring-2 focus:ring-white/30 focus:bg-white/15 transition"
                >
            </div>
        </div>
    </section>

    <section class="py-12 bg-slate-50 md:py-16 min-h-[50vh]">
        <div class="container px-4 mx-auto max-w-7xl">

            <div id="grid-secretarias" class="grid grid-cols-1 gap-6 md:grid-cols-2 lg:grid-cols-3">
                @forelse($secretarias as $secretaria)
                    <a href="{{ route('secretarias.show', $secretaria->id) }}"
                       class="flex flex-col bg-white border border-slate-100 rounded-3xl shadow-sm hover:shadow-xl transition-all duration-300 overflow-hidden group">

                        {{-- Cabeçalho do Card: Avatar + Nome --}}
                        <div class="bg-slate-50/50 p-6 border-b border-slate-100 flex items-center gap-4">
                            @if($secretaria->foto)
                                <img src="{{ asset('storage/' . $secretaria->foto) }}"
                                     alt="{{ $secretaria->nome_secretario }}"
                                     class="w-16 h-16 rounded-full object-cover shadow-sm ring-4 ring-white shrink-0"
                                     loading="lazy" decoding="async">
                            @else
                                @php
                                    $partes = explode(' ', trim($secretaria->nome_secretario ?? ''));
                                    $iniciais = count($partes) >= 2
                                        ? mb_strtoupper(mb_substr($partes[0], 0, 1) . mb_substr(end($partes), 0, 1))
                                        : mb_strtoupper(mb_substr($partes[0] ?? 'S', 0, 2));
                                @endphp
                                <div class="w-16 h-16 rounded-full bg-blue-100 text-blue-600 font-bold text-xl flex items-center justify-center shrink-0 ring-4 ring-white shadow-sm">
                                    {{ $iniciais }}
                                </div>
                            @endif

                            <div class="min-w-0">
                                <h2 class="text-lg md:text-xl font-black text-slate-800 leading-tight group-hover:text-blue-700 transition line-clamp-2">
                                    {{ $secretaria->nome }}
                                </h2>
                                @if($secretaria->nome_secretario)
                                    <p class="text-sm font-semibold text-blue-600 mt-0.5 truncate">{{ $secretaria->nome_secretario }}</p>
                                @endif
                            </div>
                        </div>

                        {{-- Corpo do Card: Contatos --}}
                        <div class="p-6 flex-1 flex flex-col gap-3">
                            @if($secretaria->telefone)
                                <div class="flex items-start gap-3 text-sm text-slate-600">
                                    <svg class="w-4 h-4 mt-0.5 text-slate-400 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/></svg>
                                    <span>{{ $secretaria->telefone }}</span>
                                </div>
                            @endif

                            @if($secretaria->email)
                                <div class="flex items-start gap-3 text-sm text-slate-600">
                                    <svg class="w-4 h-4 mt-0.5 text-slate-400 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
                                    <span class="truncate">{{ $secretaria->email }}</span>
                                </div>
                            @endif

                            @if($secretaria->endereco)
                                <div class="flex items-start gap-3 text-sm text-slate-600">
                                    <svg class="w-4 h-4 mt-0.5 text-slate-400 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                                    <span>{{ $secretaria->endereco }}</span>
                                </div>
                            @endif
                        </div>

                        {{-- Rodapé: CTA --}}
                        <div class="px-6 pb-6 mt-auto">
                            <span class="flex items-center justify-center gap-2 w-full py-2.5 text-sm font-bold text-blue-700 bg-blue-50 rounded-xl group-hover:bg-blue-600 group-hover:text-white transition-colors">
                                Ver Detalhes e Serviços
                                <svg class="w-4 h-4 transition-transform group-hover:translate-x-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                            </span>
                        </div>

                    </a>
                @empty
                    <div class="flex flex-col overflow-hidden transition bg-white border shadow-sm rounded-2xl border-slate-200">
                        <div class="relative flex flex-col items-center p-6 text-center bg-slate-100 border-b border-slate-200">
                            <div class="flex items-center justify-center w-24 h-24 mb-4 bg-white border-2 border-dashed rounded-full text-slate-300 border-slate-300">
                                <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                            </div>
                            <h2 class="text-xl font-bold text-slate-800 font-heading">Secretaria de Ciência, Tecnologia e Inovação</h2>
                            <p class="text-sm font-bold text-blue-600 uppercase tracking-wide mt-1">Rodrigo</p>
                        </div>

                        <div class="flex flex-col flex-1 p-6">
                            <p class="mb-6 text-sm text-slate-500">Responsável por impulsionar o desenvolvimento tecnológico, modernizar os serviços da prefeitura e gerir projetos inovadores como o Hub Vale do Sol.</p>

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

        </div>
    </section>

@endsection