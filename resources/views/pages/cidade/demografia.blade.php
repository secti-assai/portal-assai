@extends('layouts.app')
@section('title', 'Demografia - Prefeitura Municipal de Assaí')

@section('content')
<style> body, html { overflow-x: hidden !important; } </style>

{{-- ===== CABEÇALHO (HERO) ===== --}}
<section class="relative pt-[calc(var(--site-header-height,72px)+1.5rem)] pb-16 sm:pt-[calc(var(--site-header-height,72px)+2.5rem)] sm:pb-20 md:pt-[calc(var(--site-header-height,72px)+3.5rem)] md:pb-24 lg:pt-24 lg:pb-24 overflow-hidden bg-[#006eb7] w-full max-w-full">
    <div class="absolute inset-0 pointer-events-none">
        <svg class="absolute w-full h-full opacity-10" xmlns="http://www.w3.org/2000/svg">
            <defs>
                <pattern id="grid" width="60" height="60" patternUnits="userSpaceOnUse">
                    <path d="M 60 0 L 0 0 0 60" fill="none" stroke="white" stroke-width="1" />
                </pattern>
            </defs>
            <rect width="100%" height="100%" fill="url(#grid)" />
        </svg>
        <div class="absolute bottom-0 left-0 right-0 h-64 bg-gradient-to-t from-slate-950/80 to-transparent"></div>
    </div>

    <div class="container relative z-10 px-4 sm:px-6 md:px-8 mx-auto text-left max-w-6xl w-full">
        <div class="relative z-20">
            <x-breadcrumb :items="[
                ['name' => 'Início', 'url' => route('home')],
                ['name' => 'Cidade', 'url' => null],
                ['name' => 'Demografia', 'url' => null]
            ]" dark />
        </div>
        
        <div class="mt-8 md:mt-10 max-w-3xl">
            <span class="inline-flex items-center gap-2 px-4 py-1.5 mb-6 text-xs font-bold tracking-widest text-blue-900 uppercase bg-yellow-400 rounded-full shadow-sm">
                Perfil do Município
            </span>
            <h1 class="text-4xl sm:text-5xl md:text-6xl font-extrabold font-heading mb-6 text-white drop-shadow-md leading-tight" style="font-family: 'Montserrat', sans-serif;">
                Dados <span class="text-yellow-400">Demográficos</span>
            </h1>
            <p class="text-lg sm:text-xl md:text-2xl text-blue-50 leading-relaxed font-light mb-6">
                Um panorama populacional, territorial e econômico baseado nos indicadores oficiais do Instituto Brasileiro de Geografia e Estatística (IBGE).
            </p>
        </div>
    </div>
</section>

{{-- ===== INDICADORES DEMOGRÁFICOS - IBGE 2022 ===== --}}
<section class="py-16 md:py-24 bg-slate-50 w-full overflow-x-hidden border-b border-slate-200">
    <div class="container px-4 sm:px-6 mx-auto max-w-6xl w-full">
        
        <div class="text-center mb-16">
            <h2 class="text-3xl font-black text-slate-800 md:text-4xl font-heading mb-4" style="font-family: 'Montserrat', sans-serif;">Indicadores Oficiais (IBGE 2022)</h2>
            <p class="text-slate-500 max-w-2xl mx-auto text-lg">Estatísticas consolidadas que refletem a realidade social e estrutural de Assaí.</p>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6 w-full mb-10">
            
            {{-- Card 1: População --}}
            <div class="flex flex-col p-8 bg-white border border-slate-200 rounded-[2rem] shadow-[0_4px_20px_rgba(0,0,0,0.03)] hover:shadow-lg hover:-translate-y-1 transition-all duration-300 group">
                <div class="w-14 h-14 bg-blue-50 text-[#006eb7] rounded-2xl flex items-center justify-center text-2xl mb-6 group-hover:bg-[#006eb7] group-hover:text-white transition-colors">
                    <i class="fa-solid fa-users"></i>
                </div>
                <span class="text-4xl font-black text-slate-800 mb-1" style="font-family: 'Montserrat', sans-serif;">13.797</span>
                <span class="text-xs font-bold text-[#006eb7] uppercase tracking-widest mb-4">População Residente</span>
                <p class="text-[15px] text-slate-600 leading-relaxed">
                    Apresentou uma variação de -15,64% em relação ao Censo de 2010. A média municipal é de exatos 2,66 moradores por residência.
                </p>
            </div>

            {{-- Card 2: Densidade --}}
            <div class="flex flex-col p-8 bg-white border border-slate-200 rounded-[2rem] shadow-[0_4px_20px_rgba(0,0,0,0.03)] hover:shadow-lg hover:-translate-y-1 transition-all duration-300 group">
                <div class="w-14 h-14 bg-emerald-50 text-emerald-600 rounded-2xl flex items-center justify-center text-2xl mb-6 group-hover:bg-emerald-500 group-hover:text-white transition-colors">
                    <i class="fa-solid fa-map"></i>
                </div>
                <span class="text-4xl font-black text-slate-800 mb-1" style="font-family: 'Montserrat', sans-serif;">31,33</span>
                <span class="text-xs font-bold text-emerald-600 uppercase tracking-widest mb-4">Habitantes / km²</span>
                <p class="text-[15px] text-slate-600 leading-relaxed">
                    Densidade demográfica distribuída em um território de 440,347 km², inserido integralmente no bioma de Mata Atlântica.
                </p>
            </div>

            {{-- Card 3: Ascendência --}}
            <div class="flex flex-col p-8 bg-white border border-slate-200 rounded-[2rem] shadow-[0_4px_20px_rgba(0,0,0,0.03)] hover:shadow-lg hover:-translate-y-1 transition-all duration-300 group">
                <div class="w-14 h-14 bg-red-50 text-red-600 rounded-2xl flex items-center justify-center text-2xl mb-6 group-hover:bg-red-500 group-hover:text-white transition-colors">
                    <i class="fa-solid fa-torii-gate"></i>
                </div>
                <span class="text-4xl font-black text-slate-800 mb-1" style="font-family: 'Montserrat', sans-serif;">~15%</span>
                <span class="text-xs font-bold text-red-600 uppercase tracking-widest mb-4">Ascendência Asiática</span>
                <p class="text-[15px] text-slate-600 leading-relaxed">
                    Assaí detém com orgulho o título de município com a <strong>maior proporção</strong> de descendentes de japoneses em relação à população total no Brasil.
                </p>
            </div>

            {{-- Card 4: IDH --}}
            <div class="flex flex-col p-8 bg-white border border-slate-200 rounded-[2rem] shadow-[0_4px_20px_rgba(0,0,0,0.03)] hover:shadow-lg hover:-translate-y-1 transition-all duration-300 group">
                <div class="w-14 h-14 bg-purple-50 text-purple-600 rounded-2xl flex items-center justify-center text-2xl mb-6 group-hover:bg-purple-600 group-hover:text-white transition-colors">
                    <i class="fa-solid fa-chart-line"></i>
                </div>
                <span class="text-4xl font-black text-slate-800 mb-1" style="font-family: 'Montserrat', sans-serif;">0,728</span>
                <span class="text-xs font-bold text-purple-600 uppercase tracking-widest mb-4">IDHM (Alto)</span>
                <p class="text-[15px] text-slate-600 leading-relaxed">
                    Classificado como Alto Desenvolvimento Humano, impulsionado substancialmente pelas taxas de escolarização (98% para crianças de 6 a 14 anos).
                </p>
            </div>

            {{-- Card 5: Trabalho --}}
            <div class="flex flex-col p-8 bg-white border border-slate-200 rounded-[2rem] shadow-[0_4px_20px_rgba(0,0,0,0.03)] hover:shadow-lg hover:-translate-y-1 transition-all duration-300 group">
                <div class="w-14 h-14 bg-amber-50 text-amber-600 rounded-2xl flex items-center justify-center text-2xl mb-6 group-hover:bg-amber-500 group-hover:text-white transition-colors">
                    <i class="fa-solid fa-briefcase"></i>
                </div>
                <span class="text-4xl font-black text-slate-800 mb-1" style="font-family: 'Montserrat', sans-serif;">24,04%</span>
                <span class="text-xs font-bold text-amber-600 uppercase tracking-widest mb-4">População Ocupada</span>
                <p class="text-[15px] text-slate-600 leading-relaxed">
                    Força de trabalho formal ativa, registrando um salário médio mensal para os trabalhadores fixado em 1,9 salários mínimos.
                </p>
            </div>

            {{-- Card 6: Posição --}}
            <div class="flex flex-col p-8 bg-white border border-slate-200 rounded-[2rem] shadow-[0_4px_20px_rgba(0,0,0,0.03)] hover:shadow-lg hover:-translate-y-1 transition-all duration-300 group">
                <div class="w-14 h-14 bg-slate-100 text-slate-700 rounded-2xl flex items-center justify-center text-2xl mb-6 group-hover:bg-slate-800 group-hover:text-white transition-colors">
                    <i class="fa-solid fa-ranking-star"></i>
                </div>
                <span class="text-4xl font-black text-slate-800 mb-1" style="font-family: 'Montserrat', sans-serif;">140ª</span>
                <span class="text-xs font-bold text-slate-500 uppercase tracking-widest mb-4">Posição Estadual</span>
                <p class="text-[15px] text-slate-600 leading-relaxed">
                    No ranking demográfico oficial, o município ocupa a 140ª posição no Estado do Paraná e a 369ª colocação na região Sul do Brasil.
                </p>
            </div>

        </div>
    </div>
</section>

{{-- ===== LOCALIZAÇÃO E GEOGRAFIA ===== --}}
<section class="py-16 md:py-24 bg-white w-full overflow-x-hidden">
    <div class="container px-4 mx-auto max-w-6xl w-full">
        
        <div class="text-center mb-12">
            <h2 class="text-3xl font-black text-slate-800 md:text-4xl font-heading mb-4" style="font-family: 'Montserrat', sans-serif;">Localização Estratégica</h2>
            <p class="text-slate-500 max-w-2xl mx-auto text-lg">Limites geográficos e posicionamento no Estado do Paraná.</p>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-12 gap-10 lg:gap-12 w-full items-start">
            
            {{-- Limites Municipais --}}
            <div class="lg:col-span-4 flex flex-col gap-4 order-2 lg:order-1">
                <h3 class="font-bold text-slate-800 text-xl mb-2">Limites Territoriais</h3>
                
                <div class="flex items-center gap-4 p-5 bg-slate-50 border border-slate-200 rounded-2xl shadow-sm">
                    <div class="w-12 h-12 bg-white rounded-full flex items-center justify-center shadow-sm shrink-0 border border-slate-100">
                        <i class="fa-solid fa-arrow-up text-emerald-600 text-lg"></i>
                    </div>
                    <div>
                        <p class="text-[11px] font-extrabold text-emerald-600 uppercase tracking-widest mb-0.5">Norte</p>
                        <p class="text-base font-bold text-slate-800">Sertanópolis e Ibiporã</p>
                    </div>
                </div>

                <div class="flex items-center gap-4 p-5 bg-slate-50 border border-slate-200 rounded-2xl shadow-sm">
                    <div class="w-12 h-12 bg-white rounded-full flex items-center justify-center shadow-sm shrink-0 border border-slate-100">
                        <i class="fa-solid fa-arrow-down text-[#006eb7] text-lg"></i>
                    </div>
                    <div>
                        <p class="text-[11px] font-extrabold text-[#006eb7] uppercase tracking-widest mb-0.5">Sul</p>
                        <p class="text-base font-bold text-slate-800">São Jerônimo da Serra</p>
                    </div>
                </div>

                <div class="flex items-center gap-4 p-5 bg-slate-50 border border-slate-200 rounded-2xl shadow-sm">
                    <div class="w-12 h-12 bg-white rounded-full flex items-center justify-center shadow-sm shrink-0 border border-slate-100">
                        <i class="fa-solid fa-arrow-right text-amber-600 text-lg"></i>
                    </div>
                    <div>
                        <p class="text-[11px] font-extrabold text-amber-600 uppercase tracking-widest mb-0.5">Leste</p>
                        <p class="text-base font-bold text-slate-800">Nova América da Colina e Uraí</p>
                    </div>
                </div>

                <div class="flex items-center gap-4 p-5 bg-slate-50 border border-slate-200 rounded-2xl shadow-sm">
                    <div class="w-12 h-12 bg-white rounded-full flex items-center justify-center shadow-sm shrink-0 border border-slate-100">
                        <i class="fa-solid fa-arrow-left text-purple-600 text-lg"></i>
                    </div>
                    <div>
                        <p class="text-[11px] font-extrabold text-purple-600 uppercase tracking-widest mb-0.5">Oeste</p>
                        <p class="text-base font-bold text-slate-800">Londrina, Jataizinho e São Sebastião d. Amoreira</p>
                    </div>
                </div>

            </div>

            {{-- Mapa Interativo --}}
            <div class="lg:col-span-8 order-1 lg:order-2">
                <div class="overflow-hidden rounded-3xl shadow-lg border border-slate-200 bg-slate-100 h-[400px] lg:h-full min-h-[400px] relative group">
                    <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d117072.03901416997!2d-50.93297672218843!3d-23.36440263229983!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x94eb38e97f56475d%3A0xe54b9d3a778848f7!2sAssa%C3%AD%2C%20PR!5e0!3m2!1spt-PT!2sbr!4v1713290000000!5m2!1spt-PT!2sbr" width="100%" height="100%" class="absolute inset-0 border-0 w-full h-full mix-blend-luminosity opacity-90 group-hover:mix-blend-normal group-hover:opacity-100 transition-all duration-700" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
                </div>
            </div>

        </div>
    </div>
</section>

@endsection