@extends('layouts.app')

@section('title', 'Política de Cookies - Prefeitura de Assaí')

@section('content')

{{-- ===== CABEÇALHO PADRONIZADO ===== --}}
<section class="relative py-8 overflow-hidden bg-blue-900 md:py-6 lg:py-8" style="padding-top: calc(var(--site-header-height, 100px));">
    {{-- Textura Vetorial --}}
    <div class="absolute inset-0 pointer-events-none">
        <svg class="absolute w-full h-full opacity-40 text-blue-800" xmlns="http://www.w3.org/2000/svg">
            <defs>
                <pattern id="grid-pattern-cookies" width="40" height="40" patternUnits="userSpaceOnUse">
                    <path d="M 40 0 L 0 0 0 40" fill="none" stroke="currentColor" stroke-width="0.5"/>
                </pattern>
            </defs>
            <rect width="100%" height="100%" fill="url(#grid-pattern-cookies)"/>
        </svg>
        {{-- Fade removido --}}
    </div>

    <div class="container relative z-10 px-4 mx-auto max-w-5xl text-left">
        <nav aria-label="Breadcrumb" class="mb-4">
            <ol class="flex items-center gap-2 text-sm text-blue-200">
                <li><a href="{{ route('home') }}" class="hover:text-white transition-colors"><i class="fa-solid fa-house text-xs"></i> Início</a></li>
                <li><i class="fa-solid fa-chevron-right text-[10px] opacity-50"></i></li>
                <li class="text-white font-semibold" aria-current="page">Política de Cookies</li>
            </ol>
        </nav>
        <h1 class="text-3xl font-extrabold text-white md:text-5xl font-heading mb-4">Política de Cookies</h1>
        <p class="text-lg text-blue-100 max-w-2xl leading-relaxed font-light">Transparência sobre como recolhemos e utilizamos dados de navegação para melhorar a sua experiência no portal municipal.</p>
    </div>
</section>

{{-- ===== CONTEÚDO PRINCIPAL ===== --}}
<main id="conteudo-principal" accesskey="1" tabindex="-1" class="bg-[#edf5ff] pb-20">
    <div class="container max-w-5xl mx-auto px-4 mt-5 relative z-20">
        
        <div class="bg-white rounded-3xl p-6 md:p-12 shadow-sm border border-slate-200">
            
            {{-- Introdução --}}
            <div class="flex gap-4 items-start bg-blue-50 p-5 rounded-xl border border-blue-100 mb-10">
                <i class="fa-solid fa-circle-info text-2xl text-[#006eb7] shrink-0 mt-1"></i>
                <p class="text-slate-700 leading-relaxed text-[15px]">
                    Este portal utiliza cookies para otimizar o funcionamento técnico, aprimorar a experiência de navegação e coletar dados estatísticos agregados. Ao prosseguir com o uso dos nossos serviços digitais, o utilizador consente com a utilização destas tecnologias de acordo com a legislação vigente (LGPD).
                </p>
            </div>

            <div class="prose prose-slate prose-blue max-w-none text-slate-700">
                
                <h2 class="text-2xl font-extrabold text-slate-800 mb-4 flex items-center gap-3 border-b border-slate-100 pb-4">
                    <i class="fa-solid fa-cookie-bite text-[#006eb7]"></i> 1. Definição Técnica
                </h2>
                <p class="mb-10 text-[15px] leading-relaxed">
                    Cookies são pequenos fragmentos de dados (arquivos de texto) armazenados no navegador do utilizador quando este visita um website. Servem fundamentalmente para gerenciar sessões de acesso, manter preferências de interface (como contraste ou tamanho de fonte) e rastrear padrões de uso analíticos.
                </p>

                <h2 class="text-2xl font-extrabold text-slate-800 mb-6 flex items-center gap-3 border-b border-slate-100 pb-4">
                    <i class="fa-solid fa-layer-group text-[#006eb7]"></i> 2. Tipologia de Cookies Utilizados
                </h2>
                
                {{-- Substituição da Tabela por Cards (Melhor UX/Mobile) --}}
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-10 not-prose">
                    
                    {{-- Card 1 --}}
                    <div class="bg-slate-50 border border-slate-200 p-6 rounded-2xl hover:border-slate-300 transition-colors">
                        <div class="w-12 h-12 bg-red-100 text-red-600 rounded-xl flex items-center justify-center text-xl mb-4">
                            <i class="fa-solid fa-lock"></i>
                        </div>
                        <h3 class="font-bold text-slate-800 text-lg mb-2">Estritamente Necessários</h3>
                        <p class="text-sm text-slate-600 leading-relaxed">
                            Garantem as funções primárias e de segurança do site (login, proteção contra CSRF, integridade da sessão). <strong>Não podem ser desativados</strong> no sistema.
                        </p>
                    </div>

                    {{-- Card 2 --}}
                    <div class="bg-slate-50 border border-slate-200 p-6 rounded-2xl hover:border-slate-300 transition-colors">
                        <div class="w-12 h-12 bg-emerald-100 text-emerald-600 rounded-xl flex items-center justify-center text-xl mb-4">
                            <i class="fa-solid fa-chart-line"></i>
                        </div>
                        <h3 class="font-bold text-slate-800 text-lg mb-2">Desempenho e Analíticos</h3>
                        <p class="text-sm text-slate-600 leading-relaxed">
                            Coletam dados anônimos sobre interações no portal (páginas mais visitadas, tempo de permanência), permitindo a otimização contínua do fluxo de informação.
                        </p>
                    </div>

                    {{-- Card 3 --}}
                    <div class="bg-slate-50 border border-slate-200 p-6 rounded-2xl hover:border-slate-300 transition-colors">
                        <div class="w-12 h-12 bg-amber-100 text-amber-600 rounded-xl flex items-center justify-center text-xl mb-4">
                            <i class="fa-solid fa-sliders"></i>
                        </div>
                        <h3 class="font-bold text-slate-800 text-lg mb-2">Funcionais</h3>
                        <p class="text-sm text-slate-600 leading-relaxed">
                            Armazenam escolhas do utilizador (como preferências de acessibilidade, alto contraste e tamanho da fonte) para evitar a reconfiguração a cada novo acesso.
                        </p>
                    </div>

                </div>

                <h2 class="text-2xl font-extrabold text-slate-800 mb-4 flex items-center gap-3 border-b border-slate-100 pb-4 mt-8">
                    <i class="fa-solid fa-toggle-off text-[#006eb7]"></i> 3. Gestão e Exclusão
                </h2>
                <p class="text-[15px] leading-relaxed">
                    O utilizador tem o poder de, a qualquer momento, configurar o seu navegador de internet para bloquear a instalação de cookies, apagá-los ou alertá-lo quando um cookie estiver a ser enviado. 
                </p>
                <div class="bg-amber-50 border-l-4 border-amber-500 p-4 mt-4 rounded-r-lg">
                    <p class="text-sm text-amber-800 m-0">
                        <strong>Aviso importante:</strong> Observa-se que a desativação de cookies classificados como <em>Estritamente Necessários</em> poderá comprometer ou inviabilizar funções estruturais do portal, como a autenticação em serviços digitais.
                    </p>
                </div>

            </div>

        </div>

    </div>
</main>
@endsection