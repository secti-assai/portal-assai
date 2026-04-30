@extends('layouts.app')

@section('title', 'Transparência e Acesso à Informação - Prefeitura Municipal de Assaí')

@section('content')

{{-- ===== HERO ===== --}}
<section class="relative py-16 overflow-hidden bg-blue-900 md:py-24">
    <div class="absolute inset-0">
        <svg class="absolute w-full h-full opacity-5" xmlns="http://www.w3.org/2000/svg">
            <defs>
                <pattern id="grid-transp" width="60" height="60" patternUnits="userSpaceOnUse">
                    <path d="M 60 0 L 0 0 0 60" fill="none" stroke="white" stroke-width="1"/>
                </pattern>
            </defs>
            <rect width="100%" height="100%" fill="url(#grid-transp)"/>
        </svg>
        <div class="absolute bottom-0 left-0 right-0 h-32 bg-gradient-to-t from-blue-950 to-transparent"></div>
    </div>

    <div class="container relative z-10 px-4 mx-auto max-w-6xl">
        <x-breadcrumb :items="[
            ['name' => 'Início', 'url' => route('home')],
            ['name' => 'Transparência'],
        ]" dark />
        <div class="flex flex-col gap-6 md:flex-row md:items-end md:justify-between">
            <div>
                <span class="inline-flex items-center gap-2 px-4 py-1.5 mb-5 text-xs font-bold tracking-widest text-blue-900 uppercase bg-yellow-400 rounded-full shadow-md">
                    <svg class="w-3.5 h-3.5" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 2a1 1 0 011 1v1a1 1 0 11-2 0V3a1 1 0 011-1zm4 8a4 4 0 11-8 0 4 4 0 018 0zm-.464 4.95l.707.707a1 1 0 001.414-1.414l-.707-.707a1 1 0 00-1.414 1.414zm2.12-10.607a1 1 0 010 1.414l-.706.707a1 1 0 11-1.414-1.414l.707-.707a1 1 0 011.414 0zM17 11a1 1 0 100-2h-1a1 1 0 100 2h1zm-7 4a1 1 0 011 1v1a1 1 0 11-2 0v-1a1 1 0 011-1zM5.05 6.464A1 1 0 106.465 5.05l-.708-.707a1 1 0 00-1.414 1.414l.707.707zm1.414 8.486l-.707.707a1 1 0 01-1.414-1.414l.707-.707a1 1 0 011.414 1.414zM4 11a1 1 0 100-2H3a1 1 0 000 2h1z" clip-rule="evenodd"/>
                    </svg>
                    Governo Aberto
                </span>
                <h1 class="text-3xl font-extrabold text-white md:text-5xl font-heading leading-tight mb-4">
                    Transparência e<br class="hidden md:block"> Acesso à Informação
                </h1>
                <p class="max-w-2xl text-base text-blue-100 leading-relaxed">
                    A Prefeitura Municipal de Assaí cumpre integralmente a <strong class="text-white">Lei de Acesso à Informação (Lei nº 12.527/2011)</strong>,
                    garantindo ao cidadão o direito de acesso a dados públicos, atos administrativos, execução orçamentária e demais informações de interesse coletivo.
                </p>
            </div>
            <div class="shrink-0 flex flex-col gap-2 md:text-right">
                <span class="text-xs text-blue-300 font-medium">Atualizado em</span>
                <span class="text-sm font-bold text-white">{{ now()->format('d/m/Y') }}</span>
                <span class="inline-flex items-center gap-1.5 px-3 py-1 mt-1 text-xs font-bold text-emerald-700 bg-emerald-100 rounded-full self-start md:self-end">
                    <span class="w-2 h-2 rounded-full bg-emerald-500 animate-pulse"></span>
                    Portal Ativo
                </span>
            </div>
        </div>

        {{-- Linha de legislação --}}
        <div class="flex flex-wrap items-center gap-2 mt-8 pt-8 border-t border-white/10">
            <span class="text-xs text-blue-300 font-medium mr-1">Amparo Legal:</span>
            @foreach(['Lei nº 12.527/2011 — LAI', 'LC nº 131/2009 — Lei da Transparência', 'Decreto nº 7.724/2012', 'CF/88 — Art. 37'] as $lei)
            <span class="px-2.5 py-1 bg-white/10 border border-white/20 text-white text-xs font-medium rounded-full">{{ $lei }}</span>
            @endforeach
        </div>
    </div>
</section>

{{-- ===== GRID DE MÓDULOS ===== --}}
<section class="py-16 bg-[#f8fbff] md:py-20 border-y border-blue-100/70">
    <div class="container px-4 mx-auto max-w-6xl">

        <div class="portal-section-title mb-10">
            <h2>Portais e Sistemas de Transparência</h2>
            <div class="bar"></div>
            <p class="mt-3 text-sm text-slate-700 max-w-xl mx-auto">Acesse os portais oficiais de prestação de contas e informação pública do município de Assaí.</p>
        </div>

        @php
        $modulos = [
            [
                'titulo'    => 'Portal da Transparência',
                'desc'      => 'Acompanhe em tempo real a execução orçamentária, receitas arrecadadas, despesas realizadas, transferências e relatórios exigidos pela Lei de Responsabilidade Fiscal (LRF).',
                'badge'     => 'LRF',
                'badge_cor' => 'bg-blue-100 text-blue-700',
                'icon_bg'   => 'bg-blue-100 text-blue-700',
                'cta'       => 'Aceder ao Portal',
                'href'      => 'https://transparencia.betha.cloud/#/yyGw8hIiYdv6bs-avrzVUg==',
                'icon'      => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/>',
            ],
            [
                'titulo'    => 'Diário Oficial Eletrônico',
                'desc'      => 'Consulte as publicações oficiais do município: decretos, portarias, leis, atos normativos e demais comunicados com validade jurídica, organizados por data de publicação.',
                'badge'     => 'DOE',
                'badge_cor' => 'bg-indigo-100 text-indigo-700',
                'icon_bg'   => 'bg-indigo-100 text-indigo-700',
                'cta'       => 'Ver Publicações',
                'href'      => route('diarios.index'),
                'icon'      => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z"/>',
            ],
            [
                'titulo'    => 'Portarias Municipais',
                'desc'      => 'Acesse as portarias emitidas pelo poder executivo, contendo nomeações, exonerações, designações de comissões e demais atos administrativos internos e externos.',
                'badge'     => 'Portarias',
                'badge_cor' => 'bg-sky-100 text-sky-700',
                'icon_bg'   => 'bg-sky-100 text-sky-700',
                'cta'       => 'Consultar Portarias',
                'href'      => route('portarias.index'),
                'icon'      => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>',
            ],
            [
                'titulo'    => 'Decretos Municipais',
                'desc'      => 'Consulta aos decretos assinados pelo Prefeito Municipal para regulamentação de leis, nomeações de cargos de confiança, declarações de utilidade pública e outros atos.',
                'badge'     => 'Decretos',
                'badge_cor' => 'bg-rose-100 text-rose-700',
                'icon_bg'   => 'bg-rose-100 text-rose-700',
                'cta'       => 'Consultar Decretos',
                'href'      => route('decretos.index'),
                'icon'      => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>',
            ],
            [
                'titulo'    => 'Licitações e Contratos',
                'desc'      => 'Acompanhe editais em aberto, resultado de pregões, dispensa de licitação, contratos firmados com fornecedores e o acompanhamento de compras públicas do município.',
                'badge'     => 'ComprasNet',
                'badge_cor' => 'bg-yellow-100 text-yellow-700',
                'icon_bg'   => 'bg-yellow-100 text-yellow-700',
                'cta'       => 'Ver Licitações',
                'href'      => 'https://transparencia.betha.cloud/#/yyGw8hIiYdv6bs-avrzVUg==/consulta/95802',
                'icon'      => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"/>',
            ],
            [
                'titulo'    => 'Recursos Humanos',
                'desc'      => 'Transparência na gestão de pessoas: quadro de pessoal ativo e inativo, cargos e funções, remuneração individualizada, folha de pagamento mensal e concursos públicos.',
                'badge'     => 'RH',
                'badge_cor' => 'bg-emerald-100 text-emerald-700',
                'icon_bg'   => 'bg-emerald-100 text-emerald-700',
                'cta'       => 'Ver Quadro de Pessoal',
                'href'      => 'https://transparencia.betha.cloud/#/yyGw8hIiYdv6bs-avrzVUg==/consulta/210242',
                'icon'      => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/>',
            ],
            [
                'titulo'    => 'e-SIC — Informação ao Cidadão',
                'desc'      => 'Registre pedidos de acesso à informação, acompanhe o andamento das solicitações e consulte respostas a demandas anteriores. Canal garantido pela Lei nº 12.527/2011.',
                'badge'     => 'LAI',
                'badge_cor' => 'bg-rose-100 text-rose-700',
                'icon_bg'   => 'bg-rose-100 text-rose-700',
                'cta'       => 'Fazer uma Solicitação',
                'href'      => 'https://e-gov.betha.com.br/e-nota/login.faces',
                'icon'      => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z"/>',
            ],
            [
                'titulo'    => 'Legislação Municipal',
                'desc'      => 'Acesse a Lei Orgânica Municipal, o Código Tributário, o Código de Obras, estatutos, regimentos e toda a legislação produzida pela Câmara Municipal e pelo Executivo de Assaí.',
                'badge'     => 'Legislação',
                'badge_cor' => 'bg-slate-100 text-slate-600',
                'icon_bg'   => 'bg-slate-200 text-slate-700',
                'cta'       => 'Ver Legislação',
                'href'      => 'https://leismunicipais.com.br/prefeitura/pr/assai',
                'icon'      => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>',
            ],
        ];
        @endphp

        <div class="grid grid-cols-1 gap-8 md:grid-cols-2 lg:grid-cols-3">
            @foreach($modulos as $modulo)
            <a href="{{ $modulo['href'] }}"
               class="group flex flex-col bg-slate-50 border border-slate-300/70 ring-1 ring-slate-200/70 rounded-2xl shadow-md hover:shadow-xl hover:-translate-y-1 transition transform overflow-hidden focus:outline-none focus:ring-2 focus:ring-blue-400 focus:ring-offset-2">

                {{-- Cabeçalho do card --}}
                <div class="flex items-start justify-between p-6 pb-4">
                    <div class="flex items-center justify-center w-12 h-12 rounded-xl {{ $modulo['icon_bg'] }} shrink-0">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            {!! $modulo['icon'] !!}
                        </svg>
                    </div>
                    <span class="px-2.5 py-1 text-xs font-bold rounded-full {{ $modulo['badge_cor'] }}">
                        {{ $modulo['badge'] }}
                    </span>
                </div>

                {{-- Corpo do card --}}
                <div class="flex flex-col flex-1 px-6 pb-6">
                    <h3 class="text-lg font-extrabold text-slate-800 font-heading mb-2 group-hover:text-blue-700 transition">
                        {{ $modulo['titulo'] }}
                    </h3>
                    <p class="text-sm text-slate-700 leading-relaxed flex-1">
                        {{ $modulo['desc'] }}
                    </p>

                    {{-- CTA --}}
                    <div class="flex items-center gap-1.5 mt-5 text-sm font-bold text-blue-600 group-hover:text-blue-800 transition">
                        {{ $modulo['cta'] }}
                        <svg class="w-4 h-4 transition-transform group-hover:translate-x-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/>
                        </svg>
                    </div>
                </div>

                {{-- Barra de destaque inferior (cor da categoria) --}}
                <div class="h-0.5 w-0 group-hover:w-full transition-all duration-300
                    {{ str_contains($modulo['icon_bg'], 'blue')    ? 'bg-blue-500'    :
                      (str_contains($modulo['icon_bg'], 'indigo')  ? 'bg-indigo-500'  :
                      (str_contains($modulo['icon_bg'], 'yellow')  ? 'bg-yellow-400'  :
                      (str_contains($modulo['icon_bg'], 'emerald') ? 'bg-emerald-500' :
                      (str_contains($modulo['icon_bg'], 'rose')    ? 'bg-rose-500'    : 'bg-slate-400'))))}}">
                </div>
            </a>
            @endforeach
        </div>
    </div>
</section>

{{-- ===== AVISO / NOTA LEGAL ===== --}}
<section class="py-10 bg-[#eaf3ff] border-y border-blue-100/70">
    <div class="container px-4 mx-auto max-w-6xl">
        <div class="flex flex-col gap-6 md:flex-row md:items-start md:gap-10">

            {{-- Prazo de resposta --}}
            <div class="flex items-start gap-4 flex-1 p-5 bg-blue-700 border border-blue-800 rounded-2xl shadow-sm">
                <div class="flex items-center justify-center w-10 h-10 bg-blue-100/20 rounded-xl shrink-0">
                    <svg class="w-5 h-5 text-blue-100" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                </div>
                <div>
                    <p class="text-sm font-bold text-white mb-0.5">Prazo de Resposta</p>
                    <p class="text-xs text-blue-100 leading-relaxed">Os pedidos de acesso à informação via e-SIC são respondidos em até <strong class="text-white">20 dias úteis</strong>, prorrogáveis por mais 10 dias, conforme o Art. 11 da Lei nº 12.527/2011.</p>
                </div>
            </div>

            {{-- Responsável --}}
            <div class="flex items-start gap-4 flex-1 p-5 bg-yellow-700 border border-yellow-800 rounded-2xl shadow-sm">
                <div class="flex items-center justify-center w-10 h-10 bg-yellow-100/20 rounded-xl shrink-0">
                    <svg class="w-5 h-5 text-yellow-100" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                    </svg>
                </div>
                <div>
                    <p class="text-sm font-bold text-white mb-0.5">Autoridade de Monitoramento</p>
                    <p class="text-xs text-yellow-100 leading-relaxed">Em caso de negativa ou omissão, o cidadão pode interpor <strong class="text-white">recurso administrativo</strong> à autoridade hierarquicamente superior ou acionar a CGU, nos termos do Art. 15 da LAI.</p>
                </div>
            </div>

            {{-- Contato --}}
            <div class="flex items-start gap-4 flex-1 p-5 bg-slate-100/70 border border-slate-300/70 rounded-2xl">
                <div class="flex items-center justify-center w-10 h-10 bg-slate-200 rounded-xl shrink-0">
                    <svg class="w-5 h-5 text-slate-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                    </svg>
                </div>
                <div>
                    <p class="text-sm font-bold text-slate-700 mb-0.5">Dúvidas e Contato</p>
                    <p class="text-xs text-slate-700 leading-relaxed">Entre em contato com a Ouvidoria ou Setor de Transparência pelo e-mail <a href="mailto:ouvidoria@assai.pr.gov.br" class="font-bold text-blue-700 hover:underline">ouvidoria@assai.pr.gov.br</a> ou presencialmente na Prefeitura Municipal.</p>
                </div>
            </div>

        </div>
    </div>
</section>

@endsection
