@extends('layouts.app')
@section('title', 'Histórias de Sucesso - Prefeitura Municipal de Assaí')

@section('content')
<style>
    body,
    html {
        overflow-x: hidden !important;
    }
</style>

<section class="relative pt-[calc(var(--site-header-height,72px)+1.5rem)] pb-16 md:pt-[calc(var(--site-header-height,72px)+3.5rem)] md:pb-24 overflow-hidden bg-blue-900 w-full max-w-full">
    <div class="container relative z-10 px-4 mx-auto text-left max-w-5xl">
        <x-breadcrumb :items="[['name' => 'Início', 'url' => route('home')], ['name' => 'A Cidade'], ['name' => 'Histórias de Sucesso']]" dark />
        <h1 class="text-4xl md:text-5xl font-extrabold text-white mb-5">Economia e <span class="text-yellow-400">Desenvolvimento</span></h1>
        <p class="text-xl text-blue-100 mb-6">Da Era do Ouro Branco ao moderno Polo Industrial.</p>
    </div>
</section>

{{-- ===== ECONOMIA ===== --}}
<section class="py-12 sm:py-14 md:py-20 lg:py-28 bg-white w-full max-w-full overflow-x-hidden">
    <div class="container px-4 sm:px-6 md:px-8 mx-auto max-w-6xl w-full overflow-x-hidden">
        <div class="text-center mb-14">
            <span class="inline-block text-white font-bold tracking-wider uppercase text-xs border border-green-700 bg-green-700 px-3 py-1 rounded-full mb-4">A Força do Campo e da Cidade</span>
            <h2 class="text-3xl font-extrabold text-slate-800 font-heading md:text-4xl">Uma Economia em Constante Evolução</h2>
        </div>
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-6 w-full">
            <div class="p-8 rounded-2xl border border-slate-100 shadow-sm bg-white">
                <h3 class="text-lg font-extrabold text-slate-800 mb-3">Era do Ouro Branco</h3>
                <p class="text-sm text-slate-700 leading-relaxed">No auge da era do algodão, Assaí chegou a ter mais de <strong>200 mil habitantes</strong> e era conhecida como a <strong>"Rainha do Algodão"</strong>.</p>
            </div>
            <div class="p-8 rounded-2xl border border-slate-100 shadow-sm bg-white">
                <h3 class="text-lg font-extrabold text-slate-800 mb-3">Agropecuária Moderna</h3>
                <p class="text-sm text-slate-700 leading-relaxed">Hoje, o município destaca-se na produção de <strong>soja, trigo e café</strong>, além da famosa <strong>Uva Itália</strong>.</p>
            </div>
            <div class="p-8 rounded-2xl border border-slate-100 shadow-sm bg-white">
                <h3 class="text-lg font-extrabold text-slate-800 mb-3">Polo Industrial</h3>
                <p class="text-sm text-slate-700 leading-relaxed">A instalação de indústrias na cidade gerou mais de <strong>6.000 empregos diretos</strong>, transformando Assaí em um dos municípios mais dinâmicos.</p>
            </div>
        </div>
    </div>
</section>

{{-- ===== INDICADORES ECONÔMICOS ===== --}}
<section class="py-12 bg-slate-50 w-full max-w-full overflow-x-hidden border-t border-slate-200">
    <div class="container px-4 sm:px-6 md:px-8 mx-auto max-w-6xl w-full">
        <div class="bg-white rounded-3xl p-8 border border-slate-200 shadow-sm flex flex-col md:flex-row items-center justify-between gap-8">
            <div class="w-full md:w-1/2">
                <span class="inline-block text-emerald-700 font-bold tracking-wider uppercase text-xs border border-emerald-200 bg-emerald-50 px-3 py-1 rounded-full mb-4">Produto Interno Bruto</span>
                <h3 class="text-4xl font-extrabold text-slate-800 font-heading mb-2">R$ 36.478,15</h3>
                <p class="text-sm font-bold text-slate-500 uppercase tracking-wider mb-4">PIB Per Capita (IBGE 2021)</p>
                <p class="text-slate-700 text-[15px] leading-relaxed">
                    A matriz econômica assaiense consolidou uma transição do ciclo primário-exportador (algodão) para uma estrutura diversificada. O Produto Interno Bruto reflete a forte injeção de capital via mecanização agrícola (soja e trigo), fruticultura avançada (Uva Itália) e um polo industrial em expansão.
                </p>
            </div>
            <div class="w-full md:w-1/2 grid grid-cols-2 gap-4">
                <div class="p-5 bg-emerald-50 rounded-2xl border border-emerald-100 text-center">
                    <span class="block text-2xl font-black text-emerald-700 mb-1">3.317</span>
                    <span class="text-xs font-bold text-emerald-900">Pessoal Ocupado (Formal)</span>
                </div>
                <div class="p-5 bg-blue-50 rounded-2xl border border-blue-100 text-center">
                    <span class="block text-2xl font-black text-blue-700 mb-1">6+</span>
                    <span class="text-xs font-bold text-blue-900">Estabelecimentos SUS</span>
                </div>
            </div>
        </div>
    </div>
</section>
<section class="py-12 bg-gradient-to-br from-blue-900 to-indigo-900 text-center">
    <h2 class="text-4xl font-extrabold text-white">Nosso Desenvolvimento</h2>
</section>
@endsection