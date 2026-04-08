@extends('layouts.app')

@section('title', 'Acessibilidade - Prefeitura Municipal de Assaí')

@section('content')
{{-- Cabeçalho da Página (Hero Section) --}}
<section class="relative py-12 overflow-hidden bg-[#071D41] md:py-20 lg:py-24 border-b-4 border-[#FFCD00]">
    <div class="absolute inset-0 pointer-events-none">
        <svg class="absolute w-full h-full opacity-20 text-blue-400" xmlns="http://www.w3.org/2000/svg">
            <defs>
                <pattern id="grid-pattern-a11y" width="40" height="40" patternUnits="userSpaceOnUse">
                    <path d="M 40 0 L 0 0 0 40" fill="none" stroke="currentColor" stroke-width="1"/>
                </pattern>
            </defs>
            <rect width="100%" height="100%" fill="url(#grid-pattern-a11y)"/>
        </svg>
        <div class="absolute bottom-0 left-0 right-0 h-32 bg-gradient-to-t from-[#041229] to-transparent"></div>
    </div>

    <div class="container relative z-10 px-4 mx-auto max-w-5xl text-center font-sans">
        <div class="flex justify-center mb-6">
            <x-breadcrumb :items="[
                ['name' => 'Início', 'url' => route('home')],
                ['name' => 'Acessibilidade'],
            ]" dark />
        </div>
        <h1 class="text-3xl font-black text-white md:text-5xl font-heading tracking-tight">
            Acessibilidade Digital
        </h1>
        <p class="mt-5 text-base md:text-lg text-blue-100 max-w-2xl mx-auto font-medium leading-relaxed">
            Diretrizes, atalhos e recursos de tecnologia assistiva para garantir acesso universal ao portal oficial da Prefeitura de Assaí.
        </p>
    </div>
</section>

<main id="conteudo-principal" accesskey="1" tabindex="-1" class="py-12 bg-slate-50 md:py-20 font-sans focus:outline-none">
    <div class="container px-4 mx-auto max-w-5xl">

        {{-- Título da Seção Padrão --}}
        <div class="flex flex-col items-center mb-10 md:mb-12 text-center">
            <h2 class="text-2xl font-extrabold text-blue-900 md:text-3xl font-heading uppercase tracking-tight">
                Recursos de Inclusão
            </h2>
            <div class="w-10 h-1.5 mt-4 bg-[#FFCD00]"></div>
        </div>

        {{-- Card de Introdução --}}
        <section class="bg-white border border-slate-200 rounded-2xl p-6 md:p-10 mb-8 md:mb-10 shadow-sm">
            <h3 class="text-xl md:text-2xl font-extrabold text-blue-900 font-heading mb-4">Compromisso com a Inclusão</h3>
            <p class="text-slate-700 leading-relaxed md:text-lg">
                Este portal segue as diretrizes do <strong class="text-blue-900">Modelo de Acessibilidade em Governo Eletrônico (eMAG)</strong>, alinhadas à WCAG 2.1. O objetivo é garantir navegação autônoma e acesso à informação pública para todas as pessoas, independentemente de limitações físicas, motoras ou sensoriais.
            </p>
        </section>

        {{-- Grid de Recursos (Cards Individuais) --}}
        <section class="grid grid-cols-1 md:grid-cols-3 gap-5 md:gap-6 mb-10 md:mb-16">
            {{-- Alto Contraste --}}
            <article class="bg-white border border-slate-200 rounded-2xl p-6 shadow-sm hover:shadow-md hover:-translate-y-1 transition-all group">
                <div class="flex items-center justify-center w-12 h-12 mb-5 bg-[#071D41] text-white rounded-xl group-hover:bg-[#FFCD00] group-hover:text-blue-950 transition-colors">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" /><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" /></svg>
                </div>
                <h3 class="text-lg font-bold text-blue-900 font-heading mb-3">Alto Contraste</h3>
                <p class="text-sm text-slate-600 leading-relaxed">Aplica esquema de alto contraste para ampliar a legibilidade de texto e componentes visuais em todas as páginas.</p>
            </article>

            {{-- Ajuste de Fonte --}}
            <article class="bg-white border border-slate-200 rounded-2xl p-6 shadow-sm hover:shadow-md hover:-translate-y-1 transition-all group">
                <div class="flex items-center justify-center w-12 h-12 mb-5 bg-[#071D41] text-white rounded-xl group-hover:bg-[#FFCD00] group-hover:text-blue-950 transition-colors">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h7" /></svg>
                </div>
                <h3 class="text-lg font-bold text-blue-900 font-heading mb-3">Ajuste de Fonte</h3>
                <p class="text-sm text-slate-600 leading-relaxed">Controles fixados no topo do portal permitem aumentar ou reduzir o tamanho base do texto dinamicamente.</p>
            </article>

            {{-- VLibras --}}
            <article class="bg-white border border-slate-200 rounded-2xl p-6 shadow-sm hover:shadow-md hover:-translate-y-1 transition-all group">
                <div class="flex items-center justify-center w-12 h-12 mb-5 bg-[#071D41] text-white rounded-xl group-hover:bg-[#FFCD00] group-hover:text-blue-950 transition-colors">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 8h10M7 12h4m1 8l-4-4H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-3l-4 4z" /></svg>
                </div>
                <h3 class="text-lg font-bold text-blue-900 font-heading mb-3">Tradutor VLibras</h3>
                <p class="text-sm text-slate-600 leading-relaxed">Integração nativa com a suíte VLibras para tradução automática de conteúdos em português para a Língua Brasileira de Sinais.</p>
            </article>
        </section>

        {{-- Atalhos de Teclado --}}
        <section class="bg-white border border-slate-200 rounded-2xl p-6 md:p-10 shadow-sm">
            <h3 class="text-xl md:text-2xl font-extrabold text-blue-900 font-heading mb-3">Atalhos de Teclado (Accesskeys)</h3>
            <p class="text-slate-600 md:text-lg mb-8">
                Padrões de atalho numérico para navegação rápida via teclado. A combinação ativadora depende do navegador e sistema operacional utilizado.
            </p>

            {{-- Tabela Responsiva --}}
            <div class="overflow-x-auto mb-10 border border-slate-200 rounded-xl">
                <table class="w-full text-left border-collapse min-w-[600px]">
                    <thead>
                        <tr class="bg-slate-50 border-b border-slate-200 text-blue-900">
                            <th class="p-4 md:p-5 font-bold uppercase tracking-wider text-xs md:text-sm w-2/3">Âncora de Destino</th>
                            <th class="p-4 md:p-5 font-bold uppercase tracking-wider text-xs md:text-sm">Tecla Numérica</th>
                        </tr>
                    </thead>
                    <tbody class="text-slate-700 divide-y divide-slate-100">
                        <tr class="hover:bg-slate-50 transition-colors">
                            <td class="p-4 md:p-5 font-medium">Ir para o conteúdo principal</td>
                            <td class="p-4 md:p-5"><kbd class="px-3 py-1.5 text-sm md:text-base font-mono bg-slate-800 rounded-md text-[#FFCD00] font-bold shadow-sm">1</kbd></td>
                        </tr>
                        <tr class="hover:bg-slate-50 transition-colors">
                            <td class="p-4 md:p-5 font-medium">Ir para o menu principal de navegação</td>
                            <td class="p-4 md:p-5"><kbd class="px-3 py-1.5 text-sm md:text-base font-mono bg-slate-800 rounded-md text-[#FFCD00] font-bold shadow-sm">2</kbd></td>
                        </tr>
                        <tr class="hover:bg-slate-50 transition-colors">
                            <td class="p-4 md:p-5 font-medium">Ir para a busca do portal</td>
                            <td class="p-4 md:p-5"><kbd class="px-3 py-1.5 text-sm md:text-base font-mono bg-slate-800 rounded-md text-[#FFCD00] font-bold shadow-sm">3</kbd></td>
                        </tr>
                        <tr class="hover:bg-slate-50 transition-colors">
                            <td class="p-4 md:p-5 font-medium">Ir para o rodapé (informações e contatos)</td>
                            <td class="p-4 md:p-5"><kbd class="px-3 py-1.5 text-sm md:text-base font-mono bg-slate-800 rounded-md text-[#FFCD00] font-bold shadow-sm">4</kbd></td>
                        </tr>
                    </tbody>
                </table>
            </div>

            {{-- Grid de Navegadores --}}
            <div class="bg-slate-50 border border-slate-200 rounded-xl p-5 md:p-6">
                <h4 class="text-sm font-bold text-blue-900 uppercase tracking-widest mb-4 font-heading">Combinações Ativadoras por Navegador</h4>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-y-4 gap-x-8 text-sm md:text-base text-slate-700">
                    <div class="flex flex-col sm:flex-row sm:justify-between border-b border-slate-200 pb-2 md:border-none md:pb-0">
                        <strong class="text-slate-900">Chrome / Edge (Windows/Linux)</strong>
                        <span class="mt-1 sm:mt-0"><kbd class="font-mono bg-white border border-slate-300 px-1.5 py-0.5 rounded text-xs">Alt</kbd> + Número</span>
                    </div>
                    <div class="flex flex-col sm:flex-row sm:justify-between border-b border-slate-200 pb-2 md:border-none md:pb-0">
                        <strong class="text-slate-900">Firefox (Windows/Linux)</strong>
                        <span class="mt-1 sm:mt-0"><kbd class="font-mono bg-white border border-slate-300 px-1.5 py-0.5 rounded text-xs">Alt</kbd> + <kbd class="font-mono bg-white border border-slate-300 px-1.5 py-0.5 rounded text-xs">Shift</kbd> + Número</span>
                    </div>
                    <div class="flex flex-col sm:flex-row sm:justify-between border-b border-slate-200 pb-2 md:border-none md:pb-0">
                        <strong class="text-slate-900">Safari / Chrome (macOS)</strong>
                        <span class="mt-1 sm:mt-0"><kbd class="font-mono bg-white border border-slate-300 px-1.5 py-0.5 rounded text-xs">Control</kbd> + <kbd class="font-mono bg-white border border-slate-300 px-1.5 py-0.5 rounded text-xs">Option</kbd> + Número</span>
                    </div>
                </div>
            </div>
        </section>

    </div>
</main>
@endsection