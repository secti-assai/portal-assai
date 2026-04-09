@extends('layouts.app')

@section('title', 'Programas - Prefeitura Municipal de Assaí')

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
            ['name' => 'Programas'],
        ]" dark />
        <h1 class="text-3xl font-extrabold text-white md:text-5xl font-heading mb-4">Programas</h1>
        <p class="text-lg text-blue-100 max-w-2xl leading-relaxed font-light">Acompanhe as principais iniciativas, obras e ações estratégicas em desenvolvimento no município.</p>
    </div>
</section>

{{-- ===== GRID DE PROGRAMAS ===== --}}
<main id="conteudo-principal" accesskey="1" tabindex="-1" class="bg-[#edf5ff] py-14 max-[360px]:py-10 pb-20">
    <div class="container max-w-6xl mx-auto px-4">

        <div class="portal-section-title">
            <h2>Programas em Destaque</h2>
            <div class="bar"></div>
        </div>

        @forelse ($programas as $programa)
            @if ($loop->first)
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            @endif

            <article class="portal-card rounded-3xl flex flex-col overflow-hidden group hover:-translate-y-1">

                {{-- Imagem / Ícone de Capa --}}
                <div class="relative h-48 bg-gradient-to-br from-blue-800 to-blue-600 flex items-center justify-center overflow-hidden">
                    @if ($programa->icone)
                        <img
                            src="{{ asset('storage/' . $programa->icone) }}"
                            alt="Imagem de capa: {{ $programa->titulo }}"
                            class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500"
                            loading="lazy"
                            decoding="async"
                        >
                    @else
                        {{-- Placeholder com ícone genérico --}}
                        <svg class="w-16 h-16 text-blue-300 opacity-60" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-2 10v-5a1 1 0 00-1-1h-2a1 1 0 00-1 1v5m4 0H9" />
                        </svg>
                    @endif

                    {{-- Badge de ativo --}}
                    <span class="absolute top-3 left-3 bg-green-500 text-white text-xs font-bold uppercase tracking-wide px-3 py-1 rounded-full shadow">
                        Ativo
                    </span>
                </div>

                {{-- Corpo do Card --}}
                <div class="flex flex-col flex-1 p-6">
                    <p class="text-xs text-gray-500 mb-2 flex items-center gap-1.5">
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                        </svg>
                        {{ $programa->created_at->translatedFormat('d \d\e F \d\e Y') }}
                    </p>

                    <h2 class="font-heading font-black text-xl text-blue-900 leading-snug mb-3 group-hover:text-blue-700 transition-colors line-clamp-2 break-words" title="{{ $programa->titulo }}">
                        {{ \Illuminate\Support\Str::limit($programa->titulo, 100) }}
                    </h2>

                    <p class="text-sm text-gray-600 leading-relaxed line-clamp-3 break-words flex-1">
                        {{ \Illuminate\Support\Str::limit(strip_tags((string) $programa->descricao), 160) }}
                    </p>

                    {{-- Rodapé do Card --}}
                    <div class="mt-6 pt-4 border-t border-gray-100 flex flex-col gap-2">
                        <a
                            href="{{ route('programas.show', $programa) }}"
                            class="inline-flex items-center gap-2 w-full justify-center bg-blue-900 hover:bg-blue-800 text-white text-sm font-semibold px-5 py-2.5 rounded-xl transition-colors duration-200 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2"
                            aria-label="Ver detalhes do programa {{ $programa->titulo }}"
                        >
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                            </svg>
                            Ver Detalhes
                        </a>
                        @if ($programa->link)
                            <a
                                href="{{ $programa->link }}"
                                target="_blank"
                                rel="noopener noreferrer"
                                class="inline-flex items-center gap-2 w-full justify-center bg-white hover:bg-gray-50 text-blue-900 border border-blue-200 text-sm font-semibold px-5 py-2.5 rounded-xl transition-colors duration-200 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2"
                                aria-label="Acessar site externo do programa {{ $programa->titulo }}"
                            >
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14" />
                                </svg>
                                Acessar o Programa
                            </a>
                        @endif
                    </div>
                </div>

                {{-- Barra de cor inferior --}}
                <div class="h-1 bg-gradient-to-r from-blue-600 to-blue-400 rounded-b-3xl"></div>
            </article>

            @if ($loop->last)
                </div>
            @endif

        @empty
            {{-- Empty State --}}
            <div class="flex flex-col items-center justify-center text-center py-24 px-4">
                <div class="bg-blue-50 rounded-full p-6 mb-6">
                    <svg class="w-14 h-14 text-blue-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                            d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                    </svg>
                </div>
                <h2 class="font-heading font-black text-2xl text-blue-900 mb-2">Nenhum programa encontrado</h2>
                <p class="text-gray-500 max-w-md">
                    No momento não há programas ou projetos ativos cadastrados. Volte em breve para acompanhar as iniciativas municipais.
                </p>
                <a href="{{ route('home') }}" class="mt-8 inline-flex items-center gap-2 bg-blue-900 hover:bg-blue-800 text-white text-sm font-semibold px-6 py-3 rounded-xl transition-colors">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                    </svg>
                    Voltar ao Início
                </a>
            </div>
        @endforelse

        {{-- Paginação --}}
        @if ($programas->hasPages())
            <div class="mt-12 flex justify-center">
                {{ $programas->links() }}
            </div>
        @endif

    </div>
</main>

@endsection
