@extends('layouts.app')

@section('title', 'LGPD - Proteção de Dados - Prefeitura de Assaí')

@section('content')

{{-- ===== CABEÇALHO (HERO) ===== --}}
<section class="relative py-8 overflow-hidden bg-blue-900 md:py-6 lg:py-8" style="padding-top: calc(var(--site-header-height, 100px));">
    <div class="absolute inset-0 pointer-events-none">
        <svg class="absolute w-full h-full opacity-30 text-blue-800" xmlns="http://www.w3.org/2000/svg">
            <defs>
                <pattern id="lgpd-pattern" width="40" height="40" patternUnits="userSpaceOnUse">
                    <path d="M 40 0 L 0 0 0 40" fill="none" stroke="currentColor" stroke-width="0.5"/>
                </pattern>
            </defs>
            <rect width="100%" height="100%" fill="url(#lgpd-pattern)"/>
        </svg>
        {{-- Fade removido --}}
    </div>

    <div class="container relative z-10 px-4 mx-auto max-w-5xl text-left">
        <x-breadcrumb :items="[
            ['name' => 'Início', 'url' => route('home')],
            ['name' => 'LGPD'],
        ]" dark />
        
        <h1 class="text-3xl font-extrabold text-white md:text-5xl font-heading mb-4 leading-tight">
            Lei Geral de Proteção <br class="hidden md:block"> de Dados <span class="text-blue-300">(LGPD)</span>
        </h1>
        <p class="text-lg text-blue-100 max-w-2xl leading-relaxed font-light">
            Compromisso com a privacidade, transparência e a segurança no tratamento dos seus dados pessoais.
        </p>
    </div>
</section>

{{-- ===== CONTEÚDO PRINCIPAL ===== --}}
<main id="conteudo-principal" accesskey="1" tabindex="-1" class="bg-[#edf5ff] pb-20">
    <div class="container max-w-5xl mx-auto px-4 mt-5 relative z-20">
        
        <div class="bg-white rounded-3xl p-6 md:p-12 shadow-sm border border-slate-200">
            
            {{-- Texto Introdutório --}}
            <div class="prose prose-slate prose-blue max-w-none text-slate-700 mb-12">
                <p class="text-lg leading-relaxed">
                    A Prefeitura Municipal de Assaí, em conformidade com a <strong>Lei Federal nº 13.709/2018</strong>, estabelece diretrizes rigorosas para o tratamento de dados pessoais, garantindo proteção e segurança jurídica para cada cidadão.
                </p>
            </div>

            {{-- Seção: Princípios --}}
            <h2 class="text-2xl font-black text-slate-800 mb-8 flex items-center gap-3">
                <i class="fa-solid fa-scale-balanced text-[#006eb7]"></i> Princípios do Tratamento
            </h2>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-16">
                <div class="p-6 rounded-2xl bg-slate-50 border border-slate-100 hover:border-blue-200 transition-colors group">
                    <h3 class="font-bold text-slate-800 mb-2 flex items-center gap-2">
                        <span class="w-2 h-2 rounded-full bg-blue-500"></span> Finalidade e Adequação
                    </h3>
                    <p class="text-sm text-slate-600 leading-relaxed">Tratamento realizado estritamente para propósitos legítimos, específicos e informados ao cidadão.</p>
                </div>

                <div class="p-6 rounded-2xl bg-slate-50 border border-slate-100 hover:border-blue-200 transition-colors">
                    <h3 class="font-bold text-slate-800 mb-2 flex items-center gap-2">
                        <span class="w-2 h-2 rounded-full bg-blue-500"></span> Necessidade
                    </h3>
                    <p class="text-sm text-slate-600 leading-relaxed">Coleta limitada ao mínimo necessário para a realização das finalidades do serviço público.</p>
                </div>

                <div class="p-6 rounded-2xl bg-slate-50 border border-slate-100 hover:border-blue-200 transition-colors">
                    <h3 class="font-bold text-slate-800 mb-2 flex items-center gap-2">
                        <span class="w-2 h-2 rounded-full bg-blue-500"></span> Livre Acesso e Transparência
                    </h3>
                    <p class="text-sm text-slate-600 leading-relaxed">Garantia de informações claras e precisas sobre como seus dados estão sendo utilizados.</p>
                </div>

                <div class="p-6 rounded-2xl bg-slate-50 border border-slate-100 hover:border-blue-200 transition-colors">
                    <h3 class="font-bold text-slate-800 mb-2 flex items-center gap-2">
                        <span class="w-2 h-2 rounded-full bg-blue-500"></span> Segurança
                    </h3>
                    <p class="text-sm text-slate-600 leading-relaxed">Medidas técnicas aptas a proteger os dados de acessos não autorizados ou situações acidentais.</p>
                </div>
            </div>

            {{-- Seção: Direitos --}}
            <div class="bg-blue-900 rounded-3xl p-8 md:p-10 text-white mb-16 shadow-lg shadow-blue-900/20">
                <h2 class="text-2xl font-black mb-6 flex items-center gap-3">
                    <i class="fa-solid fa-user-shield text-blue-300"></i> Seus Direitos como Titular
                </h2>
                <p class="text-blue-100 mb-8">Mediante requisição formal, você pode exercer os seguintes direitos:</p>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-x-12 gap-y-4">
                    <div class="flex items-center gap-3 py-2 border-b border-white/10">
                        <i class="fa-solid fa-check text-blue-400 text-sm"></i> <span>Confirmação de tratamento</span>
                    </div>
                    <div class="flex items-center gap-3 py-2 border-b border-white/10">
                        <i class="fa-solid fa-check text-blue-400 text-sm"></i> <span>Acesso aos dados</span>
                    </div>
                    <div class="flex items-center gap-3 py-2 border-b border-white/10">
                        <i class="fa-solid fa-check text-blue-400 text-sm"></i> <span>Correção de dados incompletos</span>
                    </div>
                    <div class="flex items-center gap-3 py-2 border-b border-white/10">
                        <i class="fa-solid fa-check text-blue-400 text-sm"></i> <span>Anonimização ou bloqueio</span>
                    </div>
                    <div class="flex items-center gap-3 py-2 border-b border-white/10">
                        <i class="fa-solid fa-check text-blue-400 text-sm"></i> <span>Eliminação de dados</span>
                    </div>
                    <div class="flex items-center gap-3 py-2 border-b border-white/10">
                        <i class="fa-solid fa-check text-blue-400 text-sm"></i> <span>Revogação do consentimento</span>
                    </div>
                </div>
            </div>

            {{-- Seção: Encarregado (DPO) --}}
            <div class="border-2 border-dashed border-slate-200 rounded-3xl p-8 flex flex-col md:flex-row items-center gap-8">
                <div class="w-20 h-20 shrink-0 bg-blue-100 text-[#006eb7] rounded-2xl flex items-center justify-center text-3xl">
                    <i class="fa-solid fa-user-tie"></i>
                </div>
                <div>
                    <h2 class="text-xl font-black text-slate-800 mb-2 leading-tight">Encarregado de Proteção de Dados (DPO)</h2>
                    <p class="text-slate-600 text-[15px] leading-relaxed mb-4">
                        Dúvidas sobre o tratamento de seus dados pessoais ou solicitações de direitos devem ser encaminhadas aos nossos canais oficiais de comunicação.
                    </p>
                    <div class="flex flex-wrap gap-4">
                        <a href="https://www.govfacilcidadao.com.br/login" target="_blank" class="px-5 py-2.5 rounded-xl bg-[#006eb7] text-white font-bold text-sm hover:bg-blue-800 transition-all flex items-center gap-2">
                            <i class="fa-solid fa-headset"></i> Ouvidoria Municipal
                        </a>
                        <a href="https://transparencia.betha.cloud/#/yyGw8hIiYdv6bs-avrzVUg==/acesso-informacao" target="_blank" class="px-5 py-2.5 rounded-xl bg-white border border-slate-300 text-slate-700 font-bold text-sm hover:bg-slate-50 transition-all flex items-center gap-2">
                            <i class="fa-solid fa-circle-info"></i> Sistema e-SIC
                        </a>
                    </div>
                </div>
            </div>

        </div>
    </div>
</main>
@endsection