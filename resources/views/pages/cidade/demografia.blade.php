@extends('layouts.app')
@section('title', 'Demografia - Prefeitura Municipal de Assaí')

@section('content')
<style> body, html { overflow-x: hidden !important; } </style>

<section class="relative pt-[calc(var(--site-header-height,72px)+1.5rem)] pb-16 md:pt-[calc(var(--site-header-height,72px)+3.5rem)] md:pb-24 overflow-hidden bg-blue-900 w-full max-w-full">
    <div class="container relative z-10 px-4 mx-auto text-left max-w-5xl">
        <x-breadcrumb :items="[['name' => 'Início', 'url' => route('home')], ['name' => 'A Cidade'], ['name' => 'Demografia']]" dark />
        <h1 class="text-4xl md:text-5xl font-extrabold text-white mb-5">Perfil <span class="text-yellow-400">Demográfico</span></h1>
        <p class="text-xl text-blue-100 mb-6">Panorama populacional, territorial e geográfico do município.</p>
    </div>
</section>

{{-- ===== INDICADORES DEMOGRÁFICOS - IBGE 2022 ===== --}}
<section class="py-12 md:py-20 bg-white w-full overflow-x-hidden">
    <div class="container px-4 mx-auto max-w-6xl w-full">
        <h2 class="text-3xl font-extrabold text-slate-800 font-heading mb-8 text-center">Indicadores Oficiais (IBGE 2022)</h2>
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-5 w-full mb-10">
            
            <div class="flex flex-col p-6 bg-white border border-slate-200 rounded-2xl shadow-sm hover:border-blue-400 transition-colors">
                <span class="text-3xl font-black text-blue-700 mb-1">13.797</span>
                <span class="text-xs font-bold text-slate-500 uppercase tracking-wider mb-3">População Residente</span>
                <p class="text-sm text-slate-700">A população apresentou uma variação de -15,64% em relação ao Censo de 2010. A média é de 2,66 moradores por residência.</p>
            </div>

            <div class="flex flex-col p-6 bg-white border border-slate-200 rounded-2xl shadow-sm hover:border-blue-400 transition-colors">
                <span class="text-3xl font-black text-blue-700 mb-1">31,33</span>
                <span class="text-xs font-bold text-slate-500 uppercase tracking-wider mb-3">Densidade Demográfica (hab/km²)</span>
                <p class="text-sm text-slate-700">Distribuída em um território de 440,347 km², inserido integralmente no bioma de <strong>Mata Atlântica</strong>.</p>
            </div>

            <div class="flex flex-col p-6 bg-white border border-slate-200 rounded-2xl shadow-sm hover:border-blue-400 transition-colors">
                <span class="text-3xl font-black text-blue-700 mb-1">~15%</span>
                <span class="text-xs font-bold text-slate-500 uppercase tracking-wider mb-3">Ascendência Asiática</span>
                <p class="text-sm text-slate-700">Assaí detém o título de município com a maior proporção de descendentes de japoneses em relação à população total no Brasil.</p>
            </div>

            <div class="flex flex-col p-6 bg-white border border-slate-200 rounded-2xl shadow-sm hover:border-blue-400 transition-colors">
                <span class="text-3xl font-black text-blue-700 mb-1">0,728</span>
                <span class="text-xs font-bold text-slate-500 uppercase tracking-wider mb-3">Índice de Desenvolvimento Humano (IDHM)</span>
                <p class="text-sm text-slate-700">Classificado como Alto Desenvolvimento Humano, impulsionado pelas taxas de escolarização (98% para crianças de 6 a 14 anos).</p>
            </div>

            <div class="flex flex-col p-6 bg-white border border-slate-200 rounded-2xl shadow-sm hover:border-blue-400 transition-colors">
                <span class="text-3xl font-black text-blue-700 mb-1">24,04%</span>
                <span class="text-xs font-bold text-slate-500 uppercase tracking-wider mb-3">População Ocupada</span>
                <p class="text-sm text-slate-700">Com salário médio mensal dos trabalhadores formais registrado em 1,9 salários mínimos.</p>
            </div>

            <div class="flex flex-col p-6 bg-white border border-slate-200 rounded-2xl shadow-sm hover:border-blue-400 transition-colors">
                <span class="text-3xl font-black text-blue-700 mb-1">140ª</span>
                <span class="text-xs font-bold text-slate-500 uppercase tracking-wider mb-3">Posição Estadual</span>
                <p class="text-sm text-slate-700">No ranking populacional, Assaí ocupa a 140ª posição no Paraná e a 369ª na região Sul do Brasil.</p>
            </div>

        </div>
    </div>
</section>

{{-- ===== LOCALIZAÇÃO E GEOGRAFIA ===== --}}
<section class="py-12 bg-slate-50 border-t border-slate-200 w-full overflow-x-hidden">
    <div class="container px-4 mx-auto max-w-6xl w-full">
        <h2 class="text-3xl font-extrabold text-slate-800 mb-8 text-center">Localização Estratégica</h2>
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-10 w-full">
            <div class="overflow-hidden rounded-3xl shadow-sm border border-slate-200 bg-white min-h-[300px]">
                <iframe src="https://maps.google.com/maps?q=Assa%C3%AD,+Paran%C3%A1&output=embed" width="100%" height="460" class="border-0 w-full" loading="lazy"></iframe>
            </div>
            <div class="grid grid-cols-2 gap-3">
                <div class="p-3.5 bg-white border border-slate-100 rounded-xl shadow-sm text-center">
                    <p class="text-xs font-black text-emerald-600 uppercase mb-1">↑ Norte</p><p class="text-sm font-bold text-slate-700">Sertanópolis e Ibiporã</p>
                </div>
                <div class="p-3.5 bg-white border border-slate-100 rounded-xl shadow-sm text-center">
                    <p class="text-xs font-black text-blue-600 uppercase mb-1">↓ Sul</p><p class="text-sm font-bold text-slate-700">São Jerônimo da Serra</p>
                </div>
            </div>
        </div>
    </div>
</section>

<section class="py-12 bg-gradient-to-br from-blue-900 to-indigo-900 text-center"><h2 class="text-4xl font-extrabold text-white">Dados Oficiais</h2></section>
@endsection