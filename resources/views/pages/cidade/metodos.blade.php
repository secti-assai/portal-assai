@extends('layouts.app')

@section('title', 'Método Assaiense - Prefeitura de Assaí')

@section('content')

{{-- ===== HERO SECTION ===== --}}
<section class="relative py-12 overflow-hidden bg-gradient-to-br from-indigo-900 via-blue-900 to-blue-800 md:py-16 lg:py-20" style="padding-top: calc(var(--site-header-height, 100px) + 2rem);">
    <div class="absolute inset-0 pointer-events-none">
        <svg class="absolute w-full h-full opacity-10 text-white" xmlns="http://www.w3.org/2000/svg">
            <defs>
                <pattern id="metodo-pattern" width="80" height="80" patternUnits="userSpaceOnUse">
                    <circle cx="40" cy="40" r="1.5" fill="currentColor"/>
                </pattern>
            </defs>
            <rect width="100%" height="100%" fill="url(#metodo-pattern)"/>
        </svg>
        <div class="absolute top-0 right-0 w-full h-full bg-[radial-gradient(circle_at_70%_30%,rgba(255,255,255,0.1),transparent)]"></div>
    </div>
    
    <div class="container relative z-10 px-4 mx-auto max-w-5xl text-center">
        <nav aria-label="Breadcrumb" class="mb-6 flex justify-center">
            <ol class="flex items-center gap-2 text-sm text-blue-200/80">
                <li><a href="{{ route('home') }}" class="hover:text-white transition-colors flex items-center gap-1"><i class="fa-solid fa-house text-[10px]"></i> Início</a></li>
                <li><i class="fa-solid fa-chevron-right text-[8px] opacity-50"></i></li>
                <li class="text-white font-medium" aria-current="page">Método Assaiense</li>
            </ol>
        </nav>
        
        <h1 class="text-4xl md:text-6xl font-black text-white font-heading mb-6 tracking-tight drop-shadow-lg" style="font-family: 'Montserrat', sans-serif;">
            Método <span class="text-yellow-400">Assaiense</span>
        </h1>
        
        <p class="text-xl text-blue-50 max-w-3xl leading-relaxed font-light mx-auto">
            A metodologia de gestão inovadora que transformou Assaí na Smart City de maior impacto no Paraná.
        </p>
    </div>
</section>

{{-- ===== CONTEÚDO PRINCIPAL ===== --}}
<main id="conteudo-principal" accesskey="1" tabindex="-1" class="bg-white pb-24">
    <div class="container max-w-5xl mx-auto px-4 -mt-10 relative z-20">
        
        <div class="bg-white rounded-[2.5rem] shadow-2xl border border-slate-100 p-8 md:p-12 lg:p-16">
            
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 items-center mb-20">
                <div>
                    <h2 class="text-3xl font-black text-slate-900 mb-6 leading-tight" style="font-family: 'Montserrat', sans-serif;">
                        Inovação com foco em <span class="text-blue-600 underline decoration-yellow-400 decoration-4 underline-offset-4">Pessoas</span>
                    </h2>
                    <div class="prose prose-slate prose-lg text-slate-600">
                        <p>O Método Assaiense não é apenas sobre tecnologia, mas sobre como as ferramentas digitais podem servir para humanizar o atendimento público e acelerar o desenvolvimento econômico e social.</p>
                        <p>Baseado nos pilares de <strong>Eficiência, Transparência e Agilidade</strong>, nossa metodologia foca em desburocratizar processos para que o cidadão gaste menos tempo com filas e mais tempo com o que realmente importa.</p>
                    </div>
                </div>
                <div class="relative group">
                    <div class="absolute -inset-4 bg-gradient-to-tr from-blue-600 to-indigo-600 rounded-3xl opacity-10 blur-2xl transition-all group-hover:opacity-20"></div>
                    <img src="{{ asset('img/Assai.jpg') }}" alt="Assaí Smart City" class="relative rounded-2xl shadow-xl w-full h-[400px] object-cover">
                </div>
            </div>

            {{-- Os 3 Pilares --}}
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <div class="p-8 bg-blue-50 rounded-3xl border border-blue-100 hover:shadow-lg transition-all duration-300">
                    <div class="w-14 h-14 bg-blue-600 rounded-2xl flex items-center justify-center text-white mb-6 shadow-lg shadow-blue-600/20">
                        <i class="fa-solid fa-rocket text-2xl"></i>
                    </div>
                    <h3 class="text-xl font-bold text-slate-800 mb-3">Aceleração</h3>
                    <p class="text-slate-600 text-sm leading-relaxed">Redução drástica no tempo de resposta para protocolos, alvarás e solicitações via portal digital.</p>
                </div>

                <div class="p-8 bg-emerald-50 rounded-3xl border border-emerald-100 hover:shadow-lg transition-all duration-300">
                    <div class="w-14 h-14 bg-emerald-600 rounded-2xl flex items-center justify-center text-white mb-6 shadow-lg shadow-emerald-600/20">
                        <i class="fa-solid fa-users-viewfinder text-2xl"></i>
                    </div>
                    <h3 class="text-xl font-bold text-slate-800 mb-3">Inclusão</h3>
                    <p class="text-slate-600 text-sm leading-relaxed">Garantia de que a tecnologia chegue a todos, com Wi-Fi gratuito e alfabetização digital para a comunidade.</p>
                </div>

                <div class="p-8 bg-purple-50 rounded-3xl border border-purple-100 hover:shadow-lg transition-all duration-300">
                    <div class="w-14 h-14 bg-purple-600 rounded-2xl flex items-center justify-center text-white mb-6 shadow-lg shadow-purple-600/20">
                        <i class="fa-solid fa-chart-line text-2xl"></i>
                    </div>
                    <h3 class="text-xl font-bold text-slate-800 mb-3">Resultado</h3>
                    <p class="text-slate-600 text-sm leading-relaxed">Gestão baseada em dados reais para investimentos precisos em saúde, educação e infraestrutura.</p>
                </div>
            </div>

            {{-- CTA --}}
            <div class="mt-20 p-10 bg-slate-900 rounded-[2rem] text-center relative overflow-hidden">
                <div class="absolute top-0 right-0 p-8 opacity-10 pointer-events-none">
                    <i class="fa-solid fa-brain text-9xl text-white"></i>
                </div>
                <h3 class="text-2xl md:text-3xl font-black text-white mb-4 relative z-10">Quer saber mais sobre como <br> Assaí se tornou uma Smart City?</h3>
                <p class="text-slate-400 mb-8 max-w-xl mx-auto relative z-10">Conheça nossos programas e como eles estão transformando o dia a dia de cada assaiense.</p>
                <div class="flex justify-center gap-4 relative z-10">
                    <a href="{{ route('programas.index') }}" class="px-8 py-3 bg-yellow-400 text-blue-950 font-bold rounded-xl hover:bg-yellow-300 transition-all shadow-lg shadow-yellow-400/20">Ver Programas</a>
                </div>
            </div>

        </div>
    </div>
</main>

@endsection
