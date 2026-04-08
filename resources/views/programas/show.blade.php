@extends('layouts.app')

@section('title', $programa->titulo . ' - Prefeitura Municipal de Assaí')

@section('content')

{{-- ===== HERO / CABEÇALHO ===== --}}
<section class="bg-blue-900 py-14 max-[360px]:py-10 md:py-20">
    <div class="container max-w-5xl mx-auto px-4 text-center text-white">
        <x-breadcrumb :items="[
            ['name' => 'Início',              'url' => route('home')],
            ['name' => 'Programas', 'url' => route('programas.index')],
            ['name' => $programa->titulo],
        ]" dark />

        {{-- Badge de status --}}
        <div class="mt-6 mb-4 inline-flex items-center gap-2 bg-green-500 text-white text-xs font-bold uppercase tracking-widest px-4 py-1.5 rounded-full shadow">
            <span class="w-2 h-2 bg-white rounded-full inline-block"></span>
            Em andamento
        </div>

        <h1 class="font-heading font-black text-3xl max-[360px]:text-2xl md:text-5xl leading-tight mb-4 break-words">
            {{ $programa->titulo }}
        </h1>

        <p class="text-blue-200 text-base md:text-lg max-w-2xl mx-auto leading-relaxed">
            {{ Str::limit($programa->descricao, 180) }}
        </p>
    </div>
</section>

{{-- ===== CONTEÚDO PRINCIPAL ===== --}}
<main id="conteudo-principal" accesskey="1" tabindex="-1" class="bg-[#edf5ff] py-14 max-[360px]:py-10 pb-20">
    <div class="container max-w-5xl mx-auto px-4">

        <div class="portal-card rounded-3xl overflow-hidden">

            {{-- Imagem de capa --}}
            @if ($programa->icone)
                <div class="h-56 sm:h-72 md:h-96 overflow-hidden">
                    <img
                        src="{{ asset('storage/' . $programa->icone) }}"
                        alt="Imagem de capa: {{ $programa->titulo }}"
                        class="w-full h-full object-cover"
                        loading="eager"
                    >
                </div>
            @else
                <div class="h-40 bg-gradient-to-r from-blue-800 to-blue-600 flex items-center justify-center">
                    <svg class="w-20 h-20 text-blue-300 opacity-50" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                            d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                    </svg>
                </div>
            @endif

            {{-- Metadados --}}
            <div class="flex flex-wrap items-center gap-4 px-5 max-[360px]:px-4 sm:px-8 py-5 border-b border-gray-100 bg-gray-50 text-sm text-gray-500">
                {{-- Data --}}
                <span class="flex items-center gap-1.5">
                    <svg class="w-4 h-4 text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                    </svg>
                    Publicado em {{ $programa->created_at->translatedFormat('d \d\e F \d\e Y') }}
                </span>

                {{-- Status ativo --}}
                <span class="flex items-center gap-1.5">
                    <span class="w-2 h-2 rounded-full {{ $programa->ativo ? 'bg-green-500' : 'bg-red-400' }}"></span>
                    {{ $programa->ativo ? 'Ativo' : 'Inativo' }}
                </span>

                @if ($programa->destaque)
                    {{-- Destaque --}}
                    <span class="flex items-center gap-1.5 text-yellow-600 font-semibold">
                        <svg class="w-4 h-4 fill-yellow-400 stroke-yellow-500" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z" />
                        </svg>
                        Programa em Destaque
                    </span>
                @endif
            </div>

            {{-- Descrição completa --}}
            <div class="px-5 max-[360px]:px-4 sm:px-8 py-8 max-[360px]:py-6 sm:py-10">
                <div class="prose prose-sm md:prose-base prose-blue max-w-none text-gray-700 leading-7 md:leading-relaxed text-[15px] md:text-base">
                    {!! nl2br(e($programa->descricao)) !!}
                </div>
            </div>

            {{-- Rodapé do card: botão de link externo --}}
            @if ($programa->link)
                <div class="px-5 sm:px-8 pb-8 sm:pb-10">
                    <a
                        href="{{ $programa->link }}"
                        target="_blank"
                        rel="noopener noreferrer"
                        class="inline-flex items-center gap-2 bg-blue-900 hover:bg-blue-800 text-white font-semibold px-6 py-3 rounded-xl transition-colors duration-200 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2"
                        aria-label="Acessar site oficial do programa {{ $programa->titulo }}"
                    >
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14" />
                        </svg>
                        Acessar Programa
                    </a>
                </div>
            @endif

        </div>

        {{-- Voltar à listagem --}}
        <div class="mt-8">
            <a
                href="{{ route('programas.index') }}"
                class="inline-flex items-center gap-2 text-sm font-semibold text-blue-700 hover:text-blue-900 transition-colors"
            >
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                </svg>
                Voltar a Programas
            </a>
        </div>

    </div>
</main>

@endsection
