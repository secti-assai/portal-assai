@extends('layouts.app')

@section('title', 'Telefones Úteis - Prefeitura Municipal de Assaí')

@section('content')
    <main id="conteudo-principal" accesskey="1" tabindex="-1"
        class="relative flex flex-col min-h-screen pt-[96px] lg:pt-[160px] pb-16 bg-white">

        <div class="container max-w-6xl px-4 mx-auto font-sans">

            {{-- Breadcrumb --}}
            <x-breadcrumb :items="[
                ['name' => 'Início', 'url' => route('home')],
                ['name' => 'Serviços', 'url' => route('servicos.index')],
                ['name' => 'Telefones Úteis'],
            ]" />

            {{-- Header --}}
            <div class="mb-10 text-center md:text-left">
                <h1
                    class="text-3xl max-[360px]:text-2xl font-black text-blue-900 md:text-4xl font-heading leading-tight uppercase tracking-tight">
                    Telefones Úteis
                </h1>
                <div class="w-12 h-1 mt-3 bg-yellow-400 mx-auto md:mx-0"></div>
                <p class="mt-4 text-sm md:text-base text-gray-500">
                    Encontre aqui os principais contatos de emergência, secretarias e órgãos públicos do município.
                </p>
            </div>

            {{-- Lista de Telefones Agrupados --}}
            <div class="space-y-12">
                @forelse($telefones as $grupo => $itens)
                    <section>
                        <h2 class="text-xl font-black text-blue-900 uppercase tracking-tight flex items-center gap-3 mb-6">
                            <span class="w-2 h-6 bg-yellow-400 rounded-full"></span>
                            {{ $grupo }}
                        </h2>

                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                            @foreach($itens as $telefone)
                                <div class="bg-gray-50 rounded-2xl p-5 border border-gray-100 flex items-center justify-between group hover:bg-blue-900 transition-all duration-300">
                                    <div class="flex-1">
                                        <h3 class="text-sm font-bold text-gray-900 group-hover:text-white transition-colors">
                                            {{ $telefone->nome }}
                                        </h3>
                                        <a href="tel:{{ preg_replace('/\D/', '', $telefone->numero) }}" 
                                           class="text-lg font-black text-blue-700 group-hover:text-yellow-400 transition-colors flex items-center gap-2 mt-1">
                                            <i class="fas fa-phone-alt text-xs"></i>
                                            {{ $telefone->numero }}
                                        </a>
                                    </div>
                                    <div class="w-10 h-10 rounded-full bg-white flex items-center justify-center text-blue-900 shadow-sm group-hover:bg-yellow-400 group-hover:text-blue-900 transition-all">
                                        <i class="fas fa-phone"></i>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </section>
                @empty
                    <div class="flex flex-col items-center justify-center py-20 text-center border-2 border-dashed border-gray-200 rounded-3xl bg-gray-50">
                        <div class="w-16 h-16 bg-gray-100 rounded-full flex items-center justify-center mb-4">
                            <i class="fas fa-phone-slash text-gray-300 text-2xl"></i>
                        </div>
                        <h3 class="text-lg font-bold text-gray-500 uppercase tracking-tight">Nenhum telefone cadastrado</h3>
                        <p class="text-sm text-gray-400 max-w-xs mt-1">Estamos atualizando nossa lista de contatos.</p>
                    </div>
                @endforelse
            </div>

            {{-- Emergência --}}
            <div class="mt-16 bg-red-50 rounded-3xl p-8 border border-red-100">
                <h3 class="text-red-900 font-black text-xl uppercase mb-6 flex items-center gap-2">
                    <i class="fas fa-exclamation-triangle"></i>
                    Principais Canais de Emergência
                </h3>
                <div class="grid grid-cols-2 md:grid-cols-4 gap-6">
                    <div class="text-center">
                        <p class="text-xs font-bold text-red-700 uppercase mb-1">Polícia Militar</p>
                        <p class="text-3xl font-black text-red-900">190</p>
                    </div>
                    <div class="text-center border-l border-red-200">
                        <p class="text-xs font-bold text-red-700 uppercase mb-1">SAMU</p>
                        <p class="text-3xl font-black text-red-900">192</p>
                    </div>
                    <div class="text-center border-l border-red-200">
                        <p class="text-xs font-bold text-red-700 uppercase mb-1">Bombeiros</p>
                        <p class="text-3xl font-black text-red-900">193</p>
                    </div>
                    <div class="text-center border-l border-red-200">
                        <p class="text-xs font-bold text-red-700 uppercase mb-1">Defesa Civil</p>
                        <p class="text-3xl font-black text-red-900">199</p>
                    </div>
                </div>
            </div>

        </div>
    </main>
@endsection
