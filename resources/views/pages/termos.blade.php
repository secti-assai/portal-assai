@extends('layouts.app')

@section('title', 'Termos de Uso - Prefeitura de Assaí')

@section('content')

{{-- ===== SEÇÃO HERO (PADRÃO GOV.BR) ===== --}}
<section class="relative py-8 overflow-hidden bg-blue-900 md:py-6 lg:py-8" style="padding-top: calc(var(--site-header-height, 100px));">
    {{-- Padrão Geométrico de Fundo --}}
    <div class="absolute inset-0 pointer-events-none">
        <svg class="absolute w-full h-full opacity-20 text-blue-400" xmlns="http://www.w3.org/2000/svg">
            <defs>
                <pattern id="terms-pattern" width="50" height="50" patternUnits="userSpaceOnUse">
                    <circle cx="2" cy="2" r="1" fill="currentColor"/>
                </pattern>
            </defs>
            <rect width="100%" height="100%" fill="url(#terms-pattern)"/>
        </svg>
        {{-- Fade removido --}}
    </div>

    <div class="container relative z-10 px-4 mx-auto max-w-5xl">
        {{-- Breadcrumb --}}
        <nav aria-label="Você está aqui" class="mb-6">
            <ol class="flex items-center gap-2 text-sm text-blue-200">
                <li><a href="{{ route('home') }}" class="hover:text-white transition-colors flex items-center gap-1.5"><i class="fa-solid fa-house text-xs"></i> Início</a></li>
                <li><i class="fa-solid fa-chevron-right text-[10px] opacity-50"></i></li>
                <li class="text-white font-semibold" aria-current="page">Termos de Uso</li>
            </ol>
        </nav>
        
        <h1 class="text-3xl font-black text-white md:text-5xl font-heading mb-4 tracking-tight">
            Termos de <span class="text-blue-300">Uso</span>
        </h1>
        <p class="text-lg text-blue-100 max-w-2xl leading-relaxed font-light">
            Regras e diretrizes para o acesso seguro e transparente às informações e serviços do Portal Municipal.
        </p>
    </div>
</section>

{{-- ===== CONTEÚDO PRINCIPAL ===== --}}
<main id="main-content" accesskey="1" class="bg-slate-50 pb-20 mt-7 relative z-20">
    <div class="container max-w-5xl mx-auto px-4">
        
        <div class="bg-white rounded-3xl p-6 md:p-12 shadow-xl shadow-blue-900/5 border border-slate-200">
            
            {{-- Nota de Aceite --}}
            <div class="flex gap-4 items-center bg-amber-50 p-6 rounded-2xl border border-amber-100 mb-12">
                <div class="w-12 h-12 bg-amber-100 text-amber-600 rounded-full flex items-center justify-center shrink-0">
                    <i class="fa-solid fa-handshake-angle text-xl"></i>
                </div>
                <p class="text-slate-700 text-sm md:text-base leading-relaxed">
                    O acesso e uso do Portal da Prefeitura Municipal de Assaí são regulados por estes normativos. A navegação implica na <strong>aceitação integral e automática</strong> destes termos.
                </p>
            </div>

            <div class="prose prose-slate prose-blue max-w-none text-slate-700">
                
                {{-- Seção 1 --}}
                <div class="mb-12">
                    <h2 class="text-2xl font-black text-slate-800 mb-4 flex items-center gap-3 border-b border-slate-100 pb-4">
                        <i class="fa-solid fa-bullseye text-[#006eb7]"></i> 1. Escopo e Propósito
                    </h2>
                    <p class="text-[15px] leading-relaxed italic text-slate-600">
                        O portal tem a finalidade de disponibilizar informações institucionais, serviços eletrônicos, publicações legais e canais de comunicação oficiais para garantir a transparência administrativa ativa e simplificar o acesso do cidadão aos serviços públicos municipais.
                    </p>
                </div>

                {{-- Seção 2 --}}
                <div class="mb-12">
                    <h2 class="text-2xl font-black text-slate-800 mb-6 flex items-center gap-3 border-b border-slate-100 pb-4">
                        <i class="fa-solid fa-user-check text-[#006eb7]"></i> 2. Responsabilidades do Usuário
                    </h2>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 not-prose">
                        <div class="p-5 bg-slate-50 rounded-xl border border-slate-200 flex gap-3">
                            <i class="fa-solid fa-check-circle text-emerald-500 mt-1"></i>
                            <span class="text-sm font-medium">Uso idôneo e respeito à legislação federal e municipal vigente.</span>
                        </div>
                        <div class="p-5 bg-slate-50 rounded-xl border border-slate-200 flex gap-3">
                            <i class="fa-solid fa-check-circle text-emerald-500 mt-1"></i>
                            <span class="text-sm font-medium">Veracidade absoluta dos dados fornecidos em formulários e protocolos.</span>
                        </div>
                        <div class="p-5 bg-slate-50 rounded-xl border border-slate-200 flex gap-3">
                            <i class="fa-solid fa-check-circle text-emerald-500 mt-1"></i>
                            <span class="text-sm font-medium">Sigilo rigoroso de credenciais de acesso (Nota Fiscal, IPTU, etc).</span>
                        </div>
                        <div class="p-5 bg-slate-50 rounded-xl border border-slate-200 flex gap-3">
                            <i class="fa-solid fa-check-circle text-emerald-500 mt-1"></i>
                            <span class="text-sm font-medium">Não utilizar robôs ou scripts para extração massiva de dados sem autorização.</span>
                        </div>
                    </div>
                </div>

                {{-- Seção 3 --}}
                <div class="mb-12">
                    <h2 class="text-2xl font-black text-slate-800 mb-6 flex items-center gap-3 border-b border-slate-100 pb-4">
                        <i class="fa-solid fa-building-shield text-[#006eb7]"></i> 3. Deveres da Administração
                    </h2>
                    <ul class="space-y-4">
                        <li class="flex items-start gap-3">
                            <div class="w-1.5 h-1.5 rounded-full bg-blue-600 mt-2.5"></div>
                            <span>Assegurar a <strong>disponibilidade contínua</strong> do sistema, ressalvadas janelas de manutenção técnica programada.</span>
                        </li>
                        <li class="flex items-start gap-3">
                            <div class="w-1.5 h-1.5 rounded-full bg-blue-600 mt-2.5"></div>
                            <span>Implementar medidas de segurança robustas para a proteção de dados transitados (Criptografia SSL).</span>
                        </li>
                        <li class="flex items-start gap-3">
                            <div class="w-1.5 h-1.5 rounded-full bg-blue-600 mt-2.5"></div>
                            <span>Garantir a fidedignidade e a atualização tempestiva das bases legislativas e fiscais publicadas.</span>
                        </li>
                    </ul>
                </div>

                {{-- Seção 4 --}}
                <div class="mb-12">
                    <h2 class="text-2xl font-black text-slate-800 mb-4 flex items-center gap-3 border-b border-slate-100 pb-4">
                        <i class="fa-solid fa-copyright text-[#006eb7]"></i> 4. Propriedade Intelectual
                    </h2>
                    <div class="bg-blue-50 p-6 rounded-2xl text-[15px] border border-blue-100 leading-relaxed">
                        Todos os elementos visuais, logótipos, fotografias e textos são de propriedade da <strong>Prefeitura de Assaí</strong> ou de terceiros licenciados. A reprodução de textos informativos é permitida exclusivamente para fins educativos, mediante a citação obrigatória da fonte.
                    </div>
                </div>

                {{-- Seção 5 --}}
                <div>
                    <h2 class="text-2xl font-black text-slate-800 mb-4 flex items-center gap-3 border-b border-slate-100 pb-4">
                        <i class="fa-solid fa-clock-rotate-left text-[#006eb7]"></i> 5. Modificações
                    </h2>
                    <p class="text-[15px] leading-relaxed">
                        A Administração Municipal reserva-se o direito de alterar estes termos sem aviso prévio. Recomenda-se a consulta periódica a esta página para verificação de atualizações de conformidade.
                    </p>
                    <p class="text-xs font-bold text-slate-400 mt-8 uppercase tracking-widest text-right">
                        Última atualização: Abril de 2026
                    </p>
                </div>

            </div>
        </div>

    </div>
</main>
@endsection