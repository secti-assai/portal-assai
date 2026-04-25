@extends('layouts.app')

@section('title', 'Concursos Públicos - Prefeitura Municipal de Assaí')

@section('content')
    <main id="conteudo-principal" accesskey="1" tabindex="-1"
        class="relative flex flex-col min-h-screen pt-[96px] lg:pt-[160px] pb-16 bg-white">

        <div class="container max-w-6xl px-4 mx-auto font-sans">

            {{-- Breadcrumb --}}
            <x-breadcrumb :items="[
                ['name' => 'Início', 'url' => route('home')],
                ['name' => 'Serviços', 'url' => route('servicos.index')],
                ['name' => 'Concursos Públicos'],
            ]" />

            {{-- Header --}}
            <div class="mb-10 text-center md:text-left">
                <h1
                    class="text-3xl max-[360px]:text-2xl font-black text-blue-900 md:text-4xl font-heading leading-tight uppercase tracking-tight">
                    Concursos Públicos
                </h1>
                <div class="w-12 h-1 mt-3 bg-yellow-400 mx-auto md:mx-0"></div>
                <p class="mt-4 text-sm md:text-base text-gray-500">
                    Acompanhe os editais, seleções e oportunidades de ingresso na carreira pública em Assaí.
                </p>
            </div>

            {{-- Grid de Concursos --}}
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @forelse($concursos as $concurso)
                    <div class="bg-gray-50 rounded-3xl border border-gray-200 p-6 shadow-sm hover:shadow-md transition-all duration-300 flex flex-col h-full">
                        <div class="flex-1">
                            <div class="flex items-center gap-2 mb-4">
                                <span class="bg-blue-100 text-blue-800 text-[10px] font-black px-2 py-1 rounded-lg uppercase">Edital Ativo</span>
                                <span class="text-xs text-gray-400">{{ $concurso->created_at->format('d/m/Y') }}</span>
                            </div>
                            <h3 class="text-lg font-bold text-blue-950 mb-2 leading-tight">
                                {{ $concurso->titulo }}
                            </h3>
                            <p class="text-sm text-gray-600 line-clamp-3 mb-6">
                                {{ $concurso->descricao }}
                            </p>
                        </div>

                        @if($concurso->link)
                            <a href="{{ $concurso->link }}" target="_blank" rel="noopener"
                                class="w-full bg-white border-2 border-blue-600 text-blue-600 hover:bg-blue-600 hover:text-white font-bold py-3 px-6 rounded-2xl transition-all duration-200 text-center text-sm flex items-center justify-center gap-2">
                                Acessar Edital / Inscrição
                                <i class="fas fa-external-link-alt text-[10px]"></i>
                            </a>
                        @endif
                    </div>
                @empty
                    <div class="col-span-full flex flex-col items-center justify-center py-20 text-center border-2 border-dashed border-gray-200 rounded-3xl bg-gray-50">
                        <div class="w-16 h-16 bg-gray-100 rounded-full flex items-center justify-center mb-4">
                            <i class="fas fa-file-contract text-gray-300 text-2xl"></i>
                        </div>
                        <h3 class="text-lg font-bold text-gray-500 uppercase tracking-tight">Nenhum concurso no momento</h3>
                        <p class="text-sm text-gray-400 max-w-xs mt-1">Fique atento ao nosso portal para futuras oportunidades e seleções.</p>
                    </div>
                @endforelse
            </div>

            {{-- Paginação --}}
            <div class="mt-12">
                {{ $concursos->links() }}
            </div>

        </div>
    </main>
@endsection
