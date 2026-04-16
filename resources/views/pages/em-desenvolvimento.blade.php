@extends('layouts.app')

@section('title', 'Página em Construção - Prefeitura de Assaí')

@section('content')
<main class="relative flex flex-col items-center justify-center min-h-[75vh] bg-slate-50 overflow-hidden" style="padding-top: calc(var(--site-header-height, 130px));">
    
    {{-- Padrão de Fundo (Grid subtil) --}}
    <div class="absolute inset-0 pointer-events-none opacity-40 mix-blend-multiply">
        <svg class="absolute w-full h-full text-slate-300" xmlns="http://www.w3.org/2000/svg">
            <defs>
                <pattern id="dev-grid" width="40" height="40" patternUnits="userSpaceOnUse">
                    <path d="M 40 0 L 0 0 0 40" fill="none" stroke="currentColor" stroke-width="0.5"/>
                </pattern>
            </defs>
            <rect width="100%" height="100%" fill="url(#dev-grid)"/>
        </svg>
    </div>

    {{-- Elemento Decorativo (Blur) --}}
    <div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-96 h-96 bg-blue-400/20 rounded-full blur-[100px] pointer-events-none"></div>

    <div class="relative z-10 w-full max-w-2xl px-6 py-12 flex flex-col items-center text-center">
        
        {{-- Ícone Animado --}}
        <div class="relative mb-8">
            <div class="absolute inset-0 bg-yellow-400/20 rounded-full animate-ping blur-xl"></div>
            <div class="w-24 h-24 rounded-full bg-white shadow-xl flex items-center justify-center border border-slate-100 relative z-10">
                <i class="fa-solid fa-person-digging text-5xl text-[#006eb7]"></i>
            </div>
            {{-- Engrenagem a girar (decorativa) --}}
            <i class="fa-solid fa-gear absolute -bottom-2 -right-2 text-3xl text-yellow-500 animate-[spin_4s_linear_infinite] drop-shadow-md"></i>
        </div>

        {{-- Texto --}}
        <span class="text-sm font-extrabold tracking-[0.2em] text-slate-500 uppercase mb-3">Portal Assaí</span>
        
        <h1 class="text-3xl md:text-5xl font-extrabold text-slate-800 mb-6 leading-tight drop-shadow-sm" style="font-family: 'Montserrat', sans-serif;">
            Página em <span class="text-[#006eb7]">Construção</span>
        </h1>
        
        <p class="text-base md:text-lg text-slate-600 mb-10 max-w-lg leading-relaxed font-medium">
            Nossa equipa de tecnologia está a desenvolver esta área para oferecer serviços digitais mais modernos, ágeis e transparentes para si.
        </p>

        {{-- Botões de Ação --}}
        <div class="flex flex-col sm:flex-row items-center gap-4 w-full justify-center">
            <a href="{{ route('home') }}" class="w-full sm:w-auto inline-flex items-center justify-center gap-2.5 px-8 py-3.5 rounded-full bg-[#006eb7] text-white font-bold text-sm md:text-base hover:bg-blue-800 hover:-translate-y-0.5 transition-all shadow-lg focus:outline-none focus:ring-4 focus:ring-blue-500/30">
                <i class="fa-solid fa-house"></i> Voltar ao Início
            </a>
            
            <a href="https://www.govfacilcidadao.com.br/login" target="_blank" rel="noopener" class="w-full sm:w-auto inline-flex items-center justify-center gap-2.5 px-8 py-3.5 rounded-full bg-white border border-slate-300 text-slate-700 font-bold text-sm md:text-base hover:bg-slate-50 hover:text-[#006eb7] hover:-translate-y-0.5 transition-all shadow-sm focus:outline-none focus:ring-4 focus:ring-slate-200">
                <i class="fa-solid fa-headset"></i> Aceder Ouvidoria
            </a>
        </div>
        
    </div>

</main>
@endsection