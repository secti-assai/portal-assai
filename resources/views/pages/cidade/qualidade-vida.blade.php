@extends('layouts.app')
@section('title', 'Qualidade de Vida - Prefeitura Municipal de Assaí')

@section('content')
<style>
    body,
    html {
        overflow-x: hidden !important;
    }
</style>

<section class="relative pt-[calc(var(--site-header-height,72px)+1.5rem)] pb-16 md:pt-[calc(var(--site-header-height,72px)+3.5rem)] md:pb-24 overflow-hidden bg-blue-900 w-full max-w-full">
    <div class="container relative z-10 px-4 mx-auto text-left max-w-5xl">
        <x-breadcrumb :items="[['name' => 'Início', 'url' => route('home')], ['name' => 'A Cidade'], ['name' => 'Qualidade de Vida']]" dark />
        <h1 class="text-4xl md:text-5xl font-extrabold text-white mb-5">Inovação e <span class="text-yellow-400">Futuro</span></h1>
        <p class="text-xl text-blue-100 mb-6">Reconhecida globalmente, Assaí constrói uma sociedade baseada em tecnologia, educação e bem-estar.</p>
    </div>
</section>

{{-- ===== SMART CITY / VALE DO SOL ===== --}}
<section class="py-12 sm:py-14 md:py-20 lg:py-28 bg-[#f8fbff] w-full max-w-full overflow-x-hidden">
    <div class="container px-4 sm:px-6 md:px-8 mx-auto max-w-6xl w-full overflow-x-hidden">
        <div class="grid items-center grid-cols-1 gap-10 md:grid-cols-2 w-full">
            <div class="space-y-5">
                <span class="inline-block text-emerald-700 font-bold tracking-wider uppercase text-xs border border-emerald-200 bg-emerald-50 px-3 py-1 rounded-full">Inovação & Futuro</span>
                <h2 class="text-3xl font-extrabold text-slate-800 font-heading md:text-4xl leading-tight">
                    Top 7 Comunidades<br><span class="text-emerald-600">Mais Inteligentes do Mundo</span>
                </h2>
                <p class="text-slate-600 text-[15px] md:text-base leading-7">Assaí foi reconhecida pelo <strong>Intelligent Community Forum (ICF)</strong> como uma das 7 comunidades mais inteligentes do planeta.</p>
                <div class="grid grid-cols-2 gap-4 pt-2">
                    <div class="p-4 bg-slate-100/50 rounded-xl border border-slate-100">
                        <div class="text-2xl font-black text-emerald-600 mb-1">0,748</div>
                        <p class="text-xs text-slate-700">IDH Municipal — PNUD</p>
                    </div>
                    <div class="p-4 bg-slate-100/50 rounded-xl border border-slate-100">
                        <div class="text-2xl font-black text-emerald-600 mb-1">Top 7</div>
                        <p class="text-xs text-slate-700">ICF Smart Communities</p>
                    </div>
                </div>
            </div>
            <div class="relative">
                <div class="relative z-10 p-6 md:p-10 bg-blue-900 rounded-3xl shadow-2xl text-white text-center">
                    <div class="inline-flex items-center justify-center w-20 h-20 mb-6 bg-yellow-400 rounded-2xl text-blue-900 mx-auto">
                        <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z" />
                        </svg>
                    </div>
                    <p class="text-yellow-400 font-bold text-xs tracking-widest uppercase mb-3">Intelligent Community Forum</p>
                    <p class="text-4xl font-black text-white mb-2">Top 7</p>
                    <p class="text-blue-100 text-sm mb-6">Assaí integra o seleto grupo mundial de cidades inteligentes.</p>
                </div>
            </div>
        </div>
    </div>
</section>

{{-- ===== AGÊNCIA DE INOVAÇÃO VALE DO SOL ===== --}}
<section class="py-12 md:py-20 bg-white w-full max-w-full overflow-x-hidden border-t border-slate-200">
    <div class="container px-4 sm:px-6 md:px-8 mx-auto max-w-6xl w-full">
        <h2 class="text-3xl font-extrabold text-slate-800 font-heading mb-8">Infraestrutura Tecnológica</h2>
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-10">
            <div class="space-y-6 text-slate-700 text-[15px] leading-relaxed">
                <p>Assaí é a <strong>única cidade brasileira e latino-americana</strong> na lista Top 7 do <em>Intelligent Community Forum (ICF)</em>. O núcleo desta transformação é a <strong>Agência de Inovação Vale do Sol</strong>, inaugurada em dezembro de 2023 com apoio da Secretaria Estadual de Inovação (SEI).</p>
                <p>Localizado nas dependências do Colégio Estadual de Ensino Profissionalizante (CEEP) — que atende mais de 800 alunos de 9 municípios —, o complexo funciona como um laboratório prático para o desenvolvimento de startups, sistemas e aplicativos focados no agronegócio, engenharia elétrica, mecânica e automação.</p>

                <h3 class="text-lg font-bold text-slate-800 mt-6 mb-3">Aparelhagem do Hub de Inovação</h3>
                <ul class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                    <li class="flex items-center gap-2 p-3 bg-slate-50 border border-slate-100 rounded-lg">
                        <span class="text-blue-600">🎙️</span> Estúdio de Podcast
                    </li>
                    <li class="flex items-center gap-2 p-3 bg-slate-50 border border-slate-100 rounded-lg">
                        <span class="text-blue-600">🥽</span> Auditório Virtual (Metaverso)
                    </li>
                    <li class="flex items-center gap-2 p-3 bg-slate-50 border border-slate-100 rounded-lg">
                        <span class="text-blue-600">💻</span> Espaço de Coworking
                    </li>
                    <li class="flex items-center gap-2 p-3 bg-slate-50 border border-slate-100 rounded-lg">
                        <span class="text-blue-600">⚙️</span> Produção de Protótipos
                    </li>
                </ul>
            </div>
            <div class="bg-blue-900 rounded-3xl p-8 text-white flex flex-col justify-center">
                <span class="text-yellow-400 font-bold tracking-widest uppercase text-xs mb-4">Meta Estratégica 2022-2032</span>
                <h3 class="text-2xl font-extrabold font-heading mb-4">A Primeira "Cidade-Laboratório" do Brasil</h3>
                <p class="text-blue-100 text-sm leading-relaxed mb-6">
                    A estratégia de Convergência Digital almeja integrar setores público e privado para testar soluções em tempo real. O modelo é financiado por editais estaduais e pelo Sistema Estadual de Parques Tecnológicos do Paraná (Separtec).
                </p>
            </div>
        </div>
    </div>
</section>

<section class="py-12 bg-gradient-to-br from-blue-900 to-indigo-900 text-center">
    <h2 class="text-4xl font-extrabold text-white">Construindo o Amanhã</h2>
</section>
@endsection