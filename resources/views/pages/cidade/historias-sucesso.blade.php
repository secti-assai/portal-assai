@extends('layouts.app')
@section('title', 'Histórias de Sucesso - Prefeitura Municipal de Assaí')

@section('content')
<style> body, html { overflow-x: hidden !important; } </style>

{{-- ===== CABEÇALHO (HERO) ===== --}}
<section class="relative pt-[calc(var(--site-header-height,72px)+1.5rem)] pb-16 sm:pt-[calc(var(--site-header-height,72px)+2.5rem)] sm:pb-20 md:pt-[calc(var(--site-header-height,72px)+3.5rem)] md:pb-24 lg:pt-24 lg:pb-24 overflow-hidden bg-[#006eb7] w-full max-w-full">
    <div class="absolute inset-0 pointer-events-none">
        <svg class="absolute w-full h-full opacity-10" xmlns="http://www.w3.org/2000/svg">
            <defs>
                <pattern id="grid-success" width="60" height="60" patternUnits="userSpaceOnUse">
                    <path d="M 60 0 L 0 0 0 60" fill="none" stroke="white" stroke-width="1" />
                </pattern>
            </defs>
            <rect width="100%" height="100%" fill="url(#grid-success)" />
        </svg>
        <div class="absolute bottom-0 left-0 right-0 h-64 bg-gradient-to-t from-slate-950/80 to-transparent"></div>
    </div>

    <div class="container relative z-10 px-4 sm:px-6 md:px-8 mx-auto text-left max-w-6xl w-full">
        <div class="relative z-20">
            <x-breadcrumb :items="[
                ['name' => 'Início', 'url' => route('home')],
                ['name' => 'Cidade', 'url' => null],
                ['name' => 'Histórias de Sucesso', 'url' => null]
            ]" dark />
        </div>
        
        <div class="mt-8 md:mt-10 max-w-3xl">
            <span class="inline-flex items-center gap-2 px-4 py-1.5 mb-6 text-xs font-bold tracking-widest text-blue-900 uppercase bg-yellow-400 rounded-full shadow-sm">
                A Força do Nosso Povo
            </span>
            <h1 class="text-4xl sm:text-5xl md:text-6xl font-extrabold font-heading mb-6 text-white drop-shadow-md leading-tight" style="font-family: 'Montserrat', sans-serif;">
                Economia e <span class="text-yellow-400">Desenvolvimento</span>
            </h1>
            <p class="text-lg sm:text-xl md:text-2xl text-blue-50 leading-relaxed font-light mb-6">
                Da gloriosa Era do Ouro Branco ao nosso moderno e vibrante Polo Industrial. Conheça a evolução económica de Assaí.
            </p>
        </div>
    </div>
</section>

{{-- ===== EVOLUÇÃO ECONÓMICA (CARDS) ===== --}}
<section class="py-16 md:py-24 bg-white w-full overflow-x-hidden">
    <div class="container px-4 sm:px-6 mx-auto max-w-6xl w-full">
        
        <div class="text-center mb-16">
            <span class="inline-block text-[#006eb7] font-extrabold tracking-widest uppercase text-[11px] border border-blue-200 bg-blue-50 px-4 py-1.5 rounded-full mb-4">
                A Força do Campo e da Cidade
            </span>
            <h2 class="text-3xl font-black text-slate-800 font-heading md:text-4xl" style="font-family: 'Montserrat', sans-serif;">
                Uma Economia em Constante Evolução
            </h2>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-8 w-full">
            
            {{-- Card 1: Algodão --}}
            <div class="p-8 md:p-10 rounded-[2rem] bg-slate-50 border border-slate-200 shadow-[0_4px_20px_rgba(0,0,0,0.03)] hover:shadow-xl hover:-translate-y-1 hover:border-blue-300 transition-all duration-300 group flex flex-col h-full">
                <div class="w-16 h-16 bg-white text-slate-700 rounded-2xl flex items-center justify-center text-3xl mb-6 shadow-sm border border-slate-100 group-hover:bg-[#006eb7] group-hover:text-white group-hover:border-[#006eb7] transition-colors">
                    <i class="fa-solid fa-cloud-meatball"></i> {{-- Representação figurativa do algodão --}}
                </div>
                <h3 class="text-xl font-extrabold text-slate-800 mb-4 font-heading">Era do Ouro Branco</h3>
                <p class="text-[15px] text-slate-600 leading-relaxed mt-auto">
                    No auge histórico da era do algodão, Assaí chegou a ter mais de <strong>200 mil habitantes</strong> e era orgulhosamente reconhecida em todo o país como a <strong>"Rainha do Algodão"</strong>.
                </p>
            </div>

            {{-- Card 2: Agropecuária --}}
            <div class="p-8 md:p-10 rounded-[2rem] bg-slate-50 border border-slate-200 shadow-[0_4px_20px_rgba(0,0,0,0.03)] hover:shadow-xl hover:-translate-y-1 hover:border-emerald-300 transition-all duration-300 group flex flex-col h-full">
                <div class="w-16 h-16 bg-white text-slate-700 rounded-2xl flex items-center justify-center text-3xl mb-6 shadow-sm border border-slate-100 group-hover:bg-emerald-600 group-hover:text-white group-hover:border-emerald-600 transition-colors">
                    <i class="fa-solid fa-tractor"></i>
                </div>
                <h3 class="text-xl font-extrabold text-slate-800 mb-4 font-heading">Agropecuária Moderna</h3>
                <p class="text-[15px] text-slate-600 leading-relaxed mt-auto">
                    Hoje, o município destaca-se fortemente na produção mecanizada de <strong>soja, trigo e café</strong>, além do cultivo minucioso e premiado da famosa <strong>Uva Itália</strong>.
                </p>
            </div>

            {{-- Card 3: Indústria --}}
            <div class="p-8 md:p-10 rounded-[2rem] bg-slate-50 border border-slate-200 shadow-[0_4px_20px_rgba(0,0,0,0.03)] hover:shadow-xl hover:-translate-y-1 hover:border-amber-300 transition-all duration-300 group flex flex-col h-full">
                <div class="w-16 h-16 bg-white text-slate-700 rounded-2xl flex items-center justify-center text-3xl mb-6 shadow-sm border border-slate-100 group-hover:bg-amber-500 group-hover:text-white group-hover:border-amber-500 transition-colors">
                    <i class="fa-solid fa-industry"></i>
                </div>
                <h3 class="text-xl font-extrabold text-slate-800 mb-4 font-heading">Polo Industrial</h3>
                <p class="text-[15px] text-slate-600 leading-relaxed mt-auto">
                    A instalação estratégica de grandes indústrias na cidade gerou mais de <strong>6.000 empregos diretos</strong>, transformando Assaí em um dos municípios mais dinâmicos da região.
                </p>
            </div>

        </div>
    </div>
</section>

{{-- ===== INDICADORES ECONÔMICOS (PAINEL DE DESTAQUE) ===== --}}
<section class="py-16 md:py-24 bg-slate-50 w-full overflow-x-hidden border-t border-slate-200">
    <div class="container px-4 sm:px-6 mx-auto max-w-6xl w-full">
        
        <div class="bg-white rounded-[2.5rem] p-8 md:p-12 shadow-[0_8px_30px_rgba(0,0,0,0.04)] border border-slate-200 flex flex-col lg:flex-row items-center justify-between gap-12 lg:gap-16">
            
            {{-- Lado Esquerdo: PIB e Texto --}}
            <div class="w-full lg:w-1/2">
                <div class="inline-flex items-center gap-2 px-4 py-1.5 rounded-full bg-emerald-50 border border-emerald-200 mb-6">
                    <i class="fa-solid fa-chart-pie text-emerald-600"></i>
                    <span class="text-[11px] font-extrabold tracking-widest text-emerald-700 uppercase">Produto Interno Bruto</span>
                </div>
                
                <h3 class="text-5xl md:text-6xl font-black text-slate-800 font-heading mb-3 tracking-tight">R$ 36.478,15</h3>
                <p class="text-[13px] font-bold text-slate-400 uppercase tracking-widest mb-8 border-b border-slate-100 pb-4">PIB Per Capita (Ref. IBGE 2021)</p>
                
                <p class="text-slate-600 text-base md:text-lg leading-relaxed font-medium">
                    A matriz econômica assaiense consolidou uma transição do ciclo primário-exportador para uma estrutura altamente diversificada. O PIB reflete a forte injeção de capital via mecanização agrícola, fruticultura avançada e um polo industrial em plena expansão.
                </p>
            </div>

            {{-- Lado Direito: Cards Pequenos --}}
            <div class="w-full lg:w-1/2 grid grid-cols-1 sm:grid-cols-2 gap-5">
                
                {{-- Stat 1 --}}
                <div class="p-8 bg-emerald-50 rounded-3xl border border-emerald-100 text-center flex flex-col items-center justify-center group hover:bg-emerald-600 transition-colors duration-300 shadow-sm">
                    <div class="w-12 h-12 bg-white text-emerald-600 rounded-full flex items-center justify-center text-xl mb-4 shadow-sm group-hover:text-emerald-700">
                        <i class="fa-solid fa-users-gear"></i>
                    </div>
                    <span class="block text-4xl font-black text-emerald-700 mb-2 group-hover:text-white" style="font-family: 'Montserrat', sans-serif;">3.317</span>
                    <span class="text-[13px] font-extrabold uppercase tracking-wide text-emerald-900 group-hover:text-emerald-50">Pessoal Ocupado (Formal)</span>
                </div>

                {{-- Stat 2 --}}
                <div class="p-8 bg-blue-50 rounded-3xl border border-blue-100 text-center flex flex-col items-center justify-center group hover:bg-[#006eb7] transition-colors duration-300 shadow-sm">
                    <div class="w-12 h-12 bg-white text-[#006eb7] rounded-full flex items-center justify-center text-xl mb-4 shadow-sm group-hover:text-[#006eb7]">
                        <i class="fa-solid fa-hospital"></i>
                    </div>
                    <span class="block text-4xl font-black text-[#006eb7] mb-2 group-hover:text-white" style="font-family: 'Montserrat', sans-serif;">6+</span>
                    <span class="text-[13px] font-extrabold uppercase tracking-wide text-blue-900 group-hover:text-blue-50">Estabelecimentos SUS</span>
                </div>

            </div>
        </div>
        
    </div>
</section>

@endsection