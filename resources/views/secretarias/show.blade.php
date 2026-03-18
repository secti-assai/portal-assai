@extends('layouts.app')

@section('title', $secretaria->nome . ' - Prefeitura de Assaí')

@section('content')
<main class="min-h-screen pb-20 bg-slate-100/50">

    {{-- ===== HERO HEADER ===== --}}
    <section class="bg-blue-900 py-12 max-[360px]:py-10 md:py-16">
        <div class="container px-4 mx-auto max-w-6xl">

            {{-- Breadcrumb --}}
            <nav class="flex items-center gap-1.5 mb-6 text-sm text-blue-300 flex-wrap" aria-label="Breadcrumb">
                <a href="{{ route('home') }}" class="hover:text-white transition">Início</a>
                <svg class="w-3.5 h-3.5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                <a href="{{ route('secretarias.index') }}" class="hover:text-white transition">Secretarias</a>
                <svg class="w-3.5 h-3.5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                <span class="font-medium text-white truncate max-w-[180px] sm:max-w-xs">{{ $secretaria->nome }}</span>
            </nav>

            <h1 class="text-3xl max-[360px]:text-2xl md:text-4xl font-black text-white leading-tight break-words">
                {{ $secretaria->nome }}
            </h1>
            @if($secretaria->nome_secretario)
                <p class="mt-2 text-blue-200 text-base font-medium">
                    Secretário(a): <span class="text-yellow-400 font-bold">{{ $secretaria->nome_secretario }}</span>
                </p>
            @endif

        </div>
    </section>

    {{-- ===== GRID PRINCIPAL ===== --}}
    <div class="container px-4 mx-auto max-w-6xl py-10 max-[360px]:py-7">
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">

            {{-- ============================================================ --}}
            {{-- COLUNA PRINCIPAL (esquerda)                                   --}}
            {{-- ============================================================ --}}
            <div class="lg:col-span-2 space-y-8">

                {{-- Bloco: Sobre a Secretaria --}}
                @if($secretaria->descricao)
                <div class="bg-white border border-slate-100 rounded-2xl shadow-md hover:shadow-xl transition-all duration-300 p-8 max-[360px]:p-5">
                    <h2 class="text-lg font-black text-slate-800 mb-5 flex items-center gap-2">
                        <span class="flex items-center justify-center w-8 h-8 bg-blue-50 rounded-lg text-blue-600 shrink-0">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                        </span>
                        Apresentação
                    </h2>
                    <div class="prose prose-blue max-w-none text-slate-600 leading-relaxed text-sm">
                        {!! $secretaria->descricao !!}
                    </div>
                </div>
                @endif

                {{-- Bloco: Serviços Vinculados --}}
                <div class="bg-white border border-slate-100 rounded-2xl shadow-md hover:shadow-xl transition-all duration-300 p-8 max-[360px]:p-5">
                    <h2 class="text-lg font-black text-slate-800 mb-6 flex items-center gap-2">
                        <span class="flex items-center justify-center w-8 h-8 bg-blue-50 rounded-lg text-blue-600 shrink-0">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/></svg>
                        </span>
                        Serviços desta Secretaria
                    </h2>

                    @if($secretaria->servicos->isEmpty())
                        <div class="flex flex-col items-center justify-center py-12 text-center bg-slate-100/50 border-2 border-dashed border-slate-200 rounded-xl">
                            <svg class="w-12 h-12 text-slate-300 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"/></svg>
                            <p class="text-sm font-medium text-slate-500">Nenhum serviço vinculado a esta secretaria no momento.</p>
                        </div>
                    @else
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            @foreach($secretaria->servicos as $servico)
                                <a href="{{ route('servicos.acessar', $servico->id) }}"
                                   target="_blank" rel="noopener noreferrer"
                                   class="flex flex-col items-start p-5 bg-white border border-slate-200 rounded-xl hover:shadow-md hover:-translate-y-1 hover:border-blue-300 transition-all duration-200 group">

                                    <svg class="w-8 h-8 text-blue-600 mb-3 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        @switch($servico->icone)
                                        @case('saude')
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/>
                                        @break
                                        @case('vagas')
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                                        @break
                                        @case('documentos')
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                                        @break
                                        @case('ouvidoria')
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M11 5.882V19.24a1.76 1.76 0 01-3.417.592l-2.147-6.15M18 13a3 3 0 100-6M5.436 13.683A4.001 4.001 0 017 6h1.832c4.1 0 7.625-1.234 9.168-3v14c-1.543-1.766-5.067-3-9.168-3H7a3.988 3.988 0 01-1.564-.317z"/>
                                        @break
                                        @case('alvara')
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"/>
                                        @break
                                        @case('educacao')
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 14l9-5-9-5-9 5 9 5z"/>
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 14l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0012 20.055a11.952 11.952 0 00-6.824-2.998 12.078 12.078 0 01.665-6.479L12 14z"/>
                                        @break
                                        @default
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M15 15l-2 5L9 9l11 4-5 2zm0 0l5 5M7.188 2.239l.777 2.897M5.136 7.965l-2.898-.777M13.95 4.05l-2.122 2.122m-5.657 5.656l-2.12 2.122"/>
                                        @endswitch
                                    </svg>

                                    <span class="font-bold text-slate-800 text-sm leading-snug group-hover:text-blue-700 transition">
                                        {{ $servico->titulo }}
                                    </span>
                                    <span class="mt-1.5 inline-flex items-center gap-1 text-xs font-semibold text-slate-500 group-hover:text-blue-600 transition">
                                        <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/></svg>
                                        Acessar serviço
                                    </span>
                                </a>
                            @endforeach
                        </div>
                    @endif
                </div>

            </div>

            {{-- ============================================================ --}}
            {{-- SIDEBAR (direita)                                              --}}
            {{-- ============================================================ --}}
            <aside class="lg:col-span-1">
                <div class="lg:sticky lg:top-8 space-y-6">

                    {{-- Card do Secretário --}}
                    <div class="bg-white border border-slate-100 rounded-2xl shadow-md hover:shadow-xl transition-all duration-300 overflow-visible pt-14 relative">
                        {{-- Avatar flutuante --}}
                        <div class="absolute -top-10 left-1/2 -translate-x-1/2">
                            @if($secretaria->foto)
                                <img src="{{ asset('storage/' . $secretaria->foto) }}"
                                     alt="{{ $secretaria->nome_secretario }}"
                                     class="w-24 h-24 rounded-full object-cover border-4 border-white shadow-md" loading="lazy" decoding="async">
                            @else
                                @php
                                    $partes = explode(' ', trim($secretaria->nome_secretario ?? ''));
                                    $iniciais = count($partes) >= 2
                                        ? mb_strtoupper(mb_substr($partes[0], 0, 1) . mb_substr(end($partes), 0, 1))
                                        : mb_strtoupper(mb_substr($partes[0] ?? 'S', 0, 2));
                                @endphp
                                <div class="w-24 h-24 rounded-full bg-blue-100 text-blue-600 font-bold text-2xl flex items-center justify-center border-4 border-white shadow-md">
                                    {{ $iniciais }}
                                </div>
                            @endif
                        </div>

                        <div class="px-6 pb-6 text-center">
                            <p class="text-xs font-bold uppercase tracking-widest text-slate-500 mb-1">Secretário(a)</p>
                            <p class="text-lg font-black text-slate-800 leading-tight">
                                {{ $secretaria->nome_secretario ?? '—' }}
                            </p>
                            <p class="text-sm text-blue-600 font-semibold mt-1 leading-snug">
                                {{ $secretaria->nome }}
                            </p>
                        </div>
                    </div>

                    {{-- Card de Contatos --}}
                    <div class="bg-white border border-slate-100 rounded-2xl shadow-md hover:shadow-xl transition-all duration-300 p-6 max-[360px]:p-5">
                        <h3 class="text-sm font-black text-slate-700 uppercase tracking-wider mb-4 flex items-center gap-2">
                            <svg class="w-4 h-4 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                            Contato e Localização
                        </h3>

                        <dl class="space-y-4 text-sm">
                            @if($secretaria->telefone)
                            <div class="flex items-start gap-3">
                                <svg class="w-4 h-4 mt-0.5 text-blue-400 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/></svg>
                                <div>
                                    <dt class="text-xs font-bold uppercase tracking-wide text-slate-500 mb-0.5">Telefone</dt>
                                    <dd>
                                        <a href="tel:{{ preg_replace('/\D/', '', $secretaria->telefone) }}"
                                           class="font-medium text-slate-700 hover:text-blue-600 transition">
                                            {{ $secretaria->telefone }}
                                        </a>
                                    </dd>
                                </div>
                            </div>
                            @endif

                            @if($secretaria->email)
                            <div class="flex items-start gap-3">
                                <svg class="w-4 h-4 mt-0.5 text-blue-400 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
                                <div>
                                    <dt class="text-xs font-bold uppercase tracking-wide text-slate-500 mb-0.5">E-mail</dt>
                                    <dd>
                                        <a href="mailto:{{ $secretaria->email }}"
                                           class="font-medium text-blue-600 hover:text-blue-800 transition break-all">
                                            {{ $secretaria->email }}
                                        </a>
                                    </dd>
                                </div>
                            </div>
                            @endif

                            @if($secretaria->endereco)
                            <div class="flex items-start gap-3">
                                <svg class="w-4 h-4 mt-0.5 text-blue-400 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                                <div>
                                    <dt class="text-xs font-bold uppercase tracking-wide text-slate-500 mb-0.5">Endereço</dt>
                                    <dd class="text-slate-700 leading-snug">{{ $secretaria->endereco }}</dd>
                                </div>
                            </div>
                            @endif
                        </dl>
                    </div>

                    {{-- Voltar --}}
                    <a href="{{ route('secretarias.index') }}"
                       class="flex items-center justify-center gap-2 w-full px-4 py-3 text-sm font-bold text-blue-700 bg-blue-50 border border-blue-100 rounded-xl hover:bg-blue-100 transition">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
                        Ver todas as Secretarias
                    </a>

                </div>
            </aside>

        </div>
    </div>

</main>
@endsection