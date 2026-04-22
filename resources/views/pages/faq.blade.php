@extends('layouts.app')

@section('title', 'FAQ & Ajuda - Prefeitura de Assaí')

@section('content')

{{-- ===== CABEÇALHO PADRONIZADO (HERO) ===== --}}
<section class="relative py-8 overflow-hidden bg-blue-900 md:py-6 lg:py-8" style="padding-top: calc(var(--site-header-height, 100px));">
    {{-- Padrão Visual de Fundo --}}
    <div class="absolute inset-0 pointer-events-none">
        <svg class="absolute w-full h-full opacity-20 text-blue-300" xmlns="http://www.w3.org/2000/svg">
            <defs>
                <pattern id="faq-pattern" width="60" height="60" patternUnits="userSpaceOnUse">
                    <path d="M 60 0 L 0 0 0 60" fill="none" stroke="currentColor" stroke-width="0.5"/>
                    <circle cx="30" cy="30" r="1.5" fill="currentColor"/>
                </pattern>
            </defs>
            <rect width="100%" height="100%" fill="url(#faq-pattern)"/>
        </svg>
        {{-- Fade removido --}}
    </div>

    <div class="container relative z-10 px-4 mx-auto max-w-4xl text-center md:text-left">
        <nav aria-label="Breadcrumb" class="mb-4 flex justify-center md:justify-start">
            <ol class="flex items-center gap-2 text-sm text-blue-200">
                <li><a href="{{ route('home') }}" class="hover:text-white transition-colors"><i class="fa-solid fa-house text-xs"></i> Início</a></li>
                <li><i class="fa-solid fa-chevron-right text-[10px] opacity-50"></i></li>
                <li class="text-white font-semibold" aria-current="page">FAQ & Ajuda</li>
            </ol>
        </nav>
        
        <h1 class="text-3xl font-extrabold text-white md:text-5xl font-heading mb-4 tracking-tight" style="font-family: 'Montserrat', sans-serif;">
            Dúvidas <span class="text-yellow-400">Frequentes</span>
        </h1>
        <p class="text-lg text-blue-100 max-w-2xl leading-relaxed font-light mx-auto md:mx-0">
            Respostas rápidas e diretas para as perguntas mais comuns sobre os serviços digitais e o atendimento da Prefeitura Municipal.
        </p>
    </div>
</section>

{{-- ===== CONTEÚDO PRINCIPAL (ACCORDIONS) ===== --}}
<main id="conteudo-principal" accesskey="1" tabindex="-1" class="bg-[#edf5ff] pb-24">
    <div class="container max-w-4xl mx-auto px-4 mt-5 relative z-20">
        
        <div class="space-y-4">
            
            {{-- Pergunta 1 --}}
            <details class="group bg-white border border-slate-200 rounded-2xl shadow-sm overflow-hidden hover:border-blue-300 transition-colors [&_summary::-webkit-details-marker]:hidden">
                <summary class="flex cursor-pointer items-center justify-between gap-4 p-5 md:p-6 bg-white group-open:bg-blue-50/50 transition-colors select-none focus:outline-none focus:bg-blue-50">
                    <div class="flex items-center gap-4">
                        <div class="w-12 h-12 rounded-xl bg-blue-100 text-[#006eb7] flex items-center justify-center shrink-0 group-open:bg-[#006eb7] group-open:text-white transition-colors shadow-inner">
                            <i class="fa-solid fa-file-invoice-dollar text-xl"></i>
                        </div>
                        <h2 class="text-base md:text-lg font-extrabold text-slate-800 group-open:text-[#006eb7] transition-colors" style="font-family: 'Rawline', 'Open Sans', sans-serif;">
                            Como emito a Nota Fiscal Eletrônica?
                        </h2>
                    </div>
                    <div class="w-8 h-8 rounded-full bg-slate-50 flex items-center justify-center shrink-0 group-open:bg-blue-100 transition-colors border border-slate-200 group-open:border-blue-200">
                        <i class="fa-solid fa-chevron-down text-slate-400 group-open:text-[#006eb7] transition-transform duration-300 group-open:-rotate-180"></i>
                    </div>
                </summary>
                <div class="px-5 md:px-6 pb-6 pt-2 text-slate-600 leading-relaxed bg-blue-50/50 text-[15px]">
                    <div class="pl-16">
                        A emissão é feita através do portal <strong>e-Nota</strong>. Acesse o menu "Serviços" e clique em "Nota Fiscal Eletrônica". É necessário possuir cadastro prévio (login e senha) junto ao departamento de tributação municipal. Caso não tenha, o primeiro acesso deve ser solicitado presencialmente ou via protocolo digital.
                    </div>
                </div>
            </details>

            {{-- Pergunta 2 --}}
            <details class="group bg-white border border-slate-200 rounded-2xl shadow-sm overflow-hidden hover:border-blue-300 transition-colors [&_summary::-webkit-details-marker]:hidden">
                <summary class="flex cursor-pointer items-center justify-between gap-4 p-5 md:p-6 bg-white group-open:bg-blue-50/50 transition-colors select-none focus:outline-none focus:bg-blue-50">
                    <div class="flex items-center gap-4">
                        <div class="w-12 h-12 rounded-xl bg-emerald-100 text-emerald-700 flex items-center justify-center shrink-0 group-open:bg-emerald-600 group-open:text-white transition-colors shadow-inner">
                            <i class="fa-solid fa-house-chimney text-xl"></i>
                        </div>
                        <h2 class="text-base md:text-lg font-extrabold text-slate-800 group-open:text-emerald-700 transition-colors" style="font-family: 'Rawline', 'Open Sans', sans-serif;">
                            Como consultar e emitir a guia do IPTU?
                        </h2>
                    </div>
                    <div class="w-8 h-8 rounded-full bg-slate-50 flex items-center justify-center shrink-0 group-open:bg-emerald-100 transition-colors border border-slate-200 group-open:border-emerald-200">
                        <i class="fa-solid fa-chevron-down text-slate-400 group-open:text-emerald-700 transition-transform duration-300 group-open:-rotate-180"></i>
                    </div>
                </summary>
                <div class="px-5 md:px-6 pb-6 pt-2 text-slate-600 leading-relaxed bg-blue-50/50 text-[15px]">
                    <div class="pl-16">
                        Acesse o portal de serviços, selecione a opção <strong>"IPTU Digital"</strong> e insira o número do cadastro do imóvel ou o CPF/CNPJ do proprietário. O sistema irá gerar imediatamente o boleto atualizado para pagamento, incluindo opções para cota única com desconto ou parcelamento.
                    </div>
                </div>
            </details>

            {{-- Pergunta 3 --}}
            <details class="group bg-white border border-slate-200 rounded-2xl shadow-sm overflow-hidden hover:border-blue-300 transition-colors [&_summary::-webkit-details-marker]:hidden">
                <summary class="flex cursor-pointer items-center justify-between gap-4 p-5 md:p-6 bg-white group-open:bg-blue-50/50 transition-colors select-none focus:outline-none focus:bg-blue-50">
                    <div class="flex items-center gap-4">
                        <div class="w-12 h-12 rounded-xl bg-amber-100 text-amber-600 flex items-center justify-center shrink-0 group-open:bg-amber-500 group-open:text-white transition-colors shadow-inner">
                            <i class="fa-solid fa-bullhorn text-xl"></i>
                        </div>
                        <h2 class="text-base md:text-lg font-extrabold text-slate-800 group-open:text-amber-600 transition-colors" style="font-family: 'Rawline', 'Open Sans', sans-serif;">
                            Como registrar uma solicitação na Ouvidoria?
                        </h2>
                    </div>
                    <div class="w-8 h-8 rounded-full bg-slate-50 flex items-center justify-center shrink-0 group-open:bg-amber-100 transition-colors border border-slate-200 group-open:border-amber-200">
                        <i class="fa-solid fa-chevron-down text-slate-400 group-open:text-amber-600 transition-transform duration-300 group-open:-rotate-180"></i>
                    </div>
                </summary>
                <div class="px-5 md:px-6 pb-6 pt-2 text-slate-600 leading-relaxed bg-blue-50/50 text-[15px]">
                    <div class="pl-16">
                        Utilize o botão <strong>"Ouvidoria"</strong> localizado no menu principal ou no rodapé do site. Você será redirecionado para a plataforma oficial <em>GovFácil Cidadão</em>, onde poderá registrar denúncias, reclamações, sugestões ou elogios. É possível escolher entre abrir um chamado anônimo ou identificado (com acompanhamento de protocolo).
                    </div>
                </div>
            </details>

        </div>

        {{-- CALL TO ACTION (CTA) FINAL --}}
        <div class="mt-16 bg-white border border-slate-200 rounded-3xl p-8 md:p-10 flex flex-col md:flex-row items-center justify-between gap-6 shadow-sm">
            <div>
                <h3 class="text-2xl font-black text-slate-800 mb-2" style="font-family: 'Montserrat', sans-serif;">Ainda com dúvidas?</h3>
                <p class="text-slate-600">A nossa equipa está pronta para ajudar a resolver o seu problema.</p>
            </div>
            <div class="flex flex-col sm:flex-row gap-3 w-full md:w-auto shrink-0">
                <a href="{{ route('contato.index') }}" class="px-6 py-3 bg-[#006eb7] text-white font-bold rounded-xl hover:bg-blue-800 transition-colors text-center shadow-md shadow-blue-900/10 flex items-center justify-center gap-2">
                    <i class="fa-regular fa-envelope"></i> Fale Conosco
                </a>
                <a href="https://www.govfacilcidadao.com.br/login" target="_blank" rel="noopener" class="px-6 py-3 bg-slate-100 text-slate-700 font-bold rounded-xl hover:bg-slate-200 transition-colors text-center border border-slate-200 flex items-center justify-center gap-2">
                    <i class="fa-solid fa-headset"></i> Ouvidoria
                </a>
            </div>
        </div>

    </div>
</main>
@endsection