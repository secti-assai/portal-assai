@extends('layouts.app')

@section('title', 'Fale Conosco - Prefeitura Municipal de Assaí')

@section('content')

{{-- ===== CABEÇALHO PADRONIZADO ===== --}}
<section class="relative py-12 overflow-hidden bg-blue-900 md:py-20 lg:py-24">
    {{-- Textura Vetorial e Gradiente de Profundidade --}}
    <div class="absolute inset-0 pointer-events-none">
        <svg class="absolute w-full h-full opacity-40 text-blue-800" xmlns="http://www.w3.org/2000/svg">
            <defs>
                <pattern id="grid-pattern" width="40" height="40" patternUnits="userSpaceOnUse">
                    <path d="M 40 0 L 0 0 0 40" fill="none" stroke="currentColor" stroke-width="0.5" />
                </pattern>
            </defs>
            <rect width="100%" height="100%" fill="url(#grid-pattern)" />
        </svg>
        <div class="absolute bottom-0 left-0 right-0 h-32 bg-gradient-to-t from-blue-950 to-transparent"></div>
    </div>

    <div class="container relative z-10 px-4 mx-auto max-w-7xl text-left">
        <x-breadcrumb :items="[
            ['name' => 'Início', 'url' => route('home')],
            ['name' => 'Fale Conosco'],
        ]" dark />
        <h1 class="text-3xl font-extrabold text-white md:text-5xl font-heading mb-4">Canais de Atendimento</h1>
        <p class="text-lg text-blue-100 max-w-2xl leading-relaxed font-light">Encontre os telefones, e-mails oficiais e a localização dos órgãos da Prefeitura Municipal de Assaí.</p>
    </div>
</section>

{{-- ===== CONTATOS E E-MAILS (MOVIDO PARA O TOPO) ===== --}}
<section class="py-12 bg-[#f8fbff] md:py-16 border-y border-blue-100/70">
    <div class="container px-4 mx-auto max-w-7xl">

        <div class="portal-section-title">
            <h2>Contatos Oficiais</h2>
            <div class="bar"></div>
        </div>

        {{-- ── TIER 1: Institucional ── --}}
        <div class="mb-10">
            <div class="flex items-center gap-3 mb-5">
                <span class="inline-flex items-center gap-1.5 px-3 py-1 text-xs font-bold tracking-wider uppercase text-yellow-700 bg-yellow-100 rounded-full">
                    <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                    </svg>
                    Institucional
                </span>
                <div class="flex-1 h-px bg-yellow-200"></div>
            </div>
            <div class="grid grid-cols-1 gap-6 sm:grid-cols-2 xl:grid-cols-3">

                {{-- Prefeitura Municipal --}}
                <div class="group relative flex flex-col p-6 bg-white border border-yellow-200 rounded-xl shadow-md hover:shadow-xl hover:-translate-y-1 transition-all duration-300 overflow-hidden">
                    <div class="absolute top-0 left-0 w-full h-1.5 bg-yellow-400"></div>
                    <div class="flex items-center justify-center w-12 h-12 mb-4 bg-yellow-500 rounded-2xl ring-2 ring-yellow-100 shadow-sm shrink-0 group-hover:scale-110 transition-transform duration-300">
                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                        </svg>
                    </div>
                    <h3 class="text-lg font-bold text-slate-800 mb-1 font-heading transition-colors duration-300 group-hover:text-yellow-700">Prefeitura Municipal</h3>
                    <p class="text-sm text-slate-600 mb-3 flex-1">Para dúvidas gerais e encaminhamentos da Prefeitura de Assaí.</p>
                    <a href="mailto:assai@assai.pr.gov.br" class="text-sm font-medium text-blue-600 hover:text-blue-800 hover:underline break-all transition-colors">
                        assai@assai.pr.gov.br
                    </a>
                    <div class="flex items-center gap-1.5 mt-2">
                        <svg class="w-4 h-4 text-blue-500 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" />
                        </svg>
                        <a href="tel:+554332621313" class="text-sm font-medium text-blue-600 hover:text-blue-800 hover:underline break-all transition-colors">(43) 3262-1313</a>
                    </div>
                </div>

                {{-- Gabinete do Prefeito --}}
                <div class="group relative flex flex-col p-6 bg-white border border-yellow-200 rounded-xl shadow-md hover:shadow-xl hover:-translate-y-1 transition-all duration-300 overflow-hidden">
                    <div class="absolute top-0 left-0 w-full h-1.5 bg-yellow-400"></div>
                    <div class="flex items-center justify-center w-12 h-12 mb-4 bg-yellow-500 rounded-2xl ring-2 ring-yellow-100 shadow-sm shrink-0 group-hover:scale-110 transition-transform duration-300">
                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                        </svg>
                    </div>
                    <h3 class="text-lg font-bold text-slate-800 mb-1 font-heading transition-colors duration-300 group-hover:text-yellow-700">Gabinete do Prefeito</h3>
                    <p class="text-sm text-slate-600 mb-3 flex-1">Comunicação direta com a Chefia do Executivo Municipal.</p>
                    <a href="mailto:gabinete@assai.pr.gov.br" class="text-sm font-medium text-blue-600 hover:text-blue-800 hover:underline break-all transition-colors">
                        gabinete@assai.pr.gov.br
                    </a>
                    <div class="flex items-center gap-1.5 mt-2">
                        <svg class="w-4 h-4 text-blue-500 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" />
                        </svg>
                        <a href="tel:+554332621313" class="text-sm font-medium text-blue-600 hover:text-blue-800 hover:underline break-all transition-colors">(43) 3262-1313</a>
                    </div>
                </div>

                {{-- Ouvidoria Municipal --}}
                <div class="group relative flex flex-col p-6 bg-white border border-yellow-200 rounded-xl shadow-md hover:shadow-xl hover:-translate-y-1 transition-all duration-300 overflow-hidden">
                    <div class="absolute top-0 left-0 w-full h-1.5 bg-yellow-400"></div>
                    <div class="flex items-center justify-center w-12 h-12 mb-4 bg-yellow-500 rounded-2xl ring-2 ring-yellow-100 shadow-sm shrink-0 group-hover:scale-110 transition-transform duration-300">
                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                        </svg>
                    </div>
                    <h3 class="text-lg font-bold text-slate-800 mb-1 font-heading transition-colors duration-300 group-hover:text-yellow-700">Ouvidoria Municipal</h3>
                    <p class="text-sm text-slate-600 mb-3 flex-1">Reclamações, sugestões, elogios e denúncias sobre serviços públicos.</p>
                    <a href="mailto:ouvidoria@assai.pr.gov.br" class="text-sm font-medium text-blue-600 hover:text-blue-800 hover:underline break-all transition-colors">
                        ouvidoria@assai.pr.gov.br
                    </a>
                    <div class="flex items-center gap-1.5 mt-2">
                        <svg class="w-4 h-4 text-blue-500 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" />
                        </svg>
                        <a href="tel:+554332621313" class="text-sm font-medium text-blue-600 hover:text-blue-800 hover:underline break-all transition-colors">(43) 3262-1313</a>
                    </div>
                </div>

            </div>
        </div>

        {{-- ── TIER 2: Departamentos Administrativos ── --}}
        <div class="mb-10">
            <div class="flex items-center gap-3 mb-5">
                <span class="inline-flex items-center gap-1.5 px-3 py-1 text-xs font-bold tracking-wider uppercase text-slate-600 bg-slate-200 rounded-full">
                    <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M6 2a2 2 0 00-2 2v12a2 2 0 002 2h8a2 2 0 002-2V7.414A2 2 0 0015.414 6L12 2.586A2 2 0 0010.586 2H6zm2 10a1 1 0 10-2 0v3a1 1 0 102 0v-3zm2-3a1 1 0 011 1v5a1 1 0 11-2 0v-5a1 1 0 011-1zm4-1a1 1 0 10-2 0v6a1 1 0 102 0V8z" clip-rule="evenodd" />
                    </svg>
                    Departamentos Administrativos
                </span>
                <div class="flex-1 h-px bg-slate-300"></div>
            </div>
            <div class="grid grid-cols-1 gap-6 sm:grid-cols-2 xl:grid-cols-3">

                {{-- Procuradoria Geral --}}
                <div class="group relative flex flex-col p-6 bg-white border border-slate-300/70 ring-1 ring-slate-200/70 rounded-xl shadow-md hover:shadow-xl hover:-translate-y-1 transition-all duration-300 overflow-hidden">
                    <div class="absolute top-0 left-0 w-full h-1.5 bg-slate-500"></div>
                    <div class="flex items-center justify-center w-12 h-12 mb-4 bg-slate-600 rounded-2xl ring-2 ring-slate-100 shadow-sm shrink-0 group-hover:scale-110 transition-transform duration-300">
                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                        </svg>
                    </div>
                    <h3 class="text-lg font-bold text-slate-800 mb-1 font-heading transition-colors duration-300 group-hover:text-slate-700">Procuradoria Geral</h3>
                    <p class="text-sm text-slate-600 mb-3 flex-1">Assessoria jurídica e questões legais do município de Assaí.</p>
                    <a href="mailto:juridico@assai.pr.gov.br" class="text-sm font-medium text-blue-600 hover:text-blue-800 hover:underline break-all transition-colors">
                        juridico@assai.pr.gov.br
                    </a>
                    <div class="flex items-center gap-1.5 mt-2">
                        <svg class="w-4 h-4 text-blue-500 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" />
                        </svg>
                        <a href="tel:+554332621313" class="text-sm font-medium text-blue-600 hover:text-blue-800 hover:underline break-all transition-colors">(43) 3262-1313</a>
                    </div>
                </div>

                {{-- Administração e RH --}}
                <div class="group relative flex flex-col p-6 bg-white border border-slate-300/70 ring-1 ring-slate-200/70 rounded-xl shadow-md hover:shadow-xl hover:-translate-y-1 transition-all duration-300 overflow-hidden">
                    <div class="absolute top-0 left-0 w-full h-1.5 bg-slate-500"></div>
                    <div class="flex items-center justify-center w-12 h-12 mb-4 bg-slate-600 rounded-2xl ring-2 ring-slate-100 shadow-sm shrink-0 group-hover:scale-110 transition-transform duration-300">
                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                        </svg>
                    </div>
                    <h3 class="text-lg font-bold text-slate-800 mb-1 font-heading transition-colors duration-300 group-hover:text-slate-700">Secretaria de Administração e Recursos Humanos</h3>
                    <p class="text-sm text-slate-600 mb-3 flex-1">Gestão de pessoas e processos administrativos da Prefeitura.</p>
                    <a href="mailto:adm@assai.pr.gov.br" class="text-sm font-medium text-blue-600 hover:text-blue-800 hover:underline break-all transition-colors">
                        adm@assai.pr.gov.br
                    </a>
                    <div class="flex items-center gap-1.5 mt-2">
                        <svg class="w-4 h-4 text-blue-500 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" />
                        </svg>
                        <a href="tel:+554332621313" class="text-sm font-medium text-blue-600 hover:text-blue-800 hover:underline break-all transition-colors">(43) 3262-1313</a>
                    </div>
                </div>

            </div>
        </div>

        {{-- ── TIER 3: Secretarias Municipais ── --}}
        <div class="mb-2">
            <div class="flex items-center gap-3 mb-5">
                <span class="inline-flex items-center gap-1.5 px-3 py-1 text-xs font-bold tracking-wider uppercase text-blue-700 bg-blue-100 rounded-full">
                    <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M10.394 2.08a1 1 0 00-.788 0l-7 3a1 1 0 000 1.84L5.25 8.051a.999.999 0 01.356-.257l4-1.714a1 1 0 11.788 1.838L7.667 9.088l1.94.831a1 1 0 00.787 0l7-3a1 1 0 000-1.838l-7-3zM3.31 9.397L5 10.12v4.102a8.969 8.969 0 00-1.05-.174 1 1 0 01-.89-.89 11.115 11.115 0 01.25-3.762zM9.3 16.573A9.026 9.026 0 007 14.935v-3.957l1.818.78a3 3 0 002.364 0l5.508-2.361a11.026 11.026 0 01.25 3.762 1 1 0 01-.89.89 8.968 8.968 0 00-5.35 2.524 1 1 0 01-1.4 0zM6 18a1 1 0 001-1v-2.065a8.935 8.935 0 00-2-.712V17a1 1 0 001 1z" />
                    </svg>
                    Secretarias Municipais
                </span>
                <div class="flex-1 h-px bg-blue-200"></div>
            </div>
            <div class="grid grid-cols-1 gap-6 sm:grid-cols-2 xl:grid-cols-3">

                {{-- Secretaria de Educação --}}
                <div class="group relative flex flex-col p-6 bg-white border border-slate-300/70 ring-1 ring-slate-200/70 rounded-xl shadow-md hover:shadow-xl hover:-translate-y-1 transition-all duration-300 overflow-hidden">
                    <div class="absolute top-0 left-0 w-full h-1.5 bg-blue-500"></div>
                    <div class="flex items-center justify-center w-12 h-12 mb-4 bg-blue-600 rounded-2xl ring-2 ring-blue-100 shadow-sm shrink-0 group-hover:scale-110 transition-transform duration-300">
                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                        </svg>
                    </div>
                    <h3 class="text-lg font-bold text-slate-800 mb-1 font-heading transition-colors duration-300 group-hover:text-blue-700">Secretaria de Educação</h3>
                    <p class="text-sm text-slate-600 mb-3 flex-1">Ensino, matrículas e programas educacionais do município.</p>
                    <a href="mailto:educacao@assai.pr.gov.br" class="text-sm font-medium text-blue-600 hover:text-blue-800 hover:underline break-all transition-colors">
                        educacao@assai.pr.gov.br
                    </a>
                    <div class="flex items-center gap-1.5 mt-2">
                        <svg class="w-4 h-4 text-blue-500 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" />
                        </svg>
                        <a href="tel:+554332628451" class="text-sm font-medium text-blue-600 hover:text-blue-800 hover:underline break-all transition-colors">(43) 3262-8451</a>
                    </div>
                </div>

                {{-- Secretaria de Saúde --}}
                <div class="group relative flex flex-col p-6 bg-white border border-slate-300/70 ring-1 ring-slate-200/70 rounded-xl shadow-md hover:shadow-xl hover:-translate-y-1 transition-all duration-300 overflow-hidden">
                    <div class="absolute top-0 left-0 w-full h-1.5 bg-blue-500"></div>
                    <div class="flex items-center justify-center w-12 h-12 mb-4 bg-blue-600 rounded-2xl ring-2 ring-blue-100 shadow-sm shrink-0 group-hover:scale-110 transition-transform duration-300">
                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                        </svg>
                    </div>
                    <h3 class="text-lg font-bold text-slate-800 mb-1 font-heading transition-colors duration-300 group-hover:text-blue-700">Secretaria de Saúde</h3>
                    <p class="text-sm text-slate-600 mb-3 flex-1">Saúde pública, UBS e programas de saúde para a população.</p>
                    <a href="mailto:saude@assai.pr.gov.br" class="text-sm font-medium text-blue-600 hover:text-blue-800 hover:underline break-all transition-colors">
                        saude@assai.pr.gov.br
                    </a>
                    <div class="flex items-center gap-1.5 mt-2">
                        <svg class="w-4 h-4 text-blue-500 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" />
                        </svg>
                        <a href="tel:+554332628405" class="text-sm font-medium text-blue-600 hover:text-blue-800 hover:underline break-all transition-colors">(43) 3262-8405</a>
                    </div>
                </div>

                {{-- Assistência Social --}}
                <div class="group relative flex flex-col p-6 bg-white border border-slate-300/70 ring-1 ring-slate-200/70 rounded-xl shadow-md hover:shadow-xl hover:-translate-y-1 transition-all duration-300 overflow-hidden">
                    <div class="absolute top-0 left-0 w-full h-1.5 bg-blue-500"></div>
                    <div class="flex items-center justify-center w-12 h-12 mb-4 bg-blue-600 rounded-2xl ring-2 ring-blue-100 shadow-sm shrink-0 group-hover:scale-110 transition-transform duration-300">
                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                        </svg>
                    </div>
                    <h3 class="text-lg font-bold text-slate-800 mb-1 font-heading transition-colors duration-300 group-hover:text-blue-700">Secretaria de Assistência Social</h3>
                    <p class="text-sm text-slate-600 mb-3 flex-1">Programas sociais e atendimento ao cidadão em situação de vulnerabilidade.</p>
                    <a href="mailto:smas@assai.pr.gov.br" class="text-sm font-medium text-blue-600 hover:text-blue-800 hover:underline break-all transition-colors">
                        smas@assai.pr.gov.br
                    </a>
                    <div class="flex items-center gap-1.5 mt-2">
                        <svg class="w-4 h-4 text-blue-500 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" />
                        </svg>
                        <a href="tel:+554332621223" class="text-sm font-medium text-blue-600 hover:text-blue-800 hover:underline break-all transition-colors">(43) 3262-1223</a>
                    </div>
                </div>

                {{-- Agricultura e Meio Ambiente --}}
                <div class="group relative flex flex-col p-6 bg-white border border-slate-300/70 ring-1 ring-slate-200/70 rounded-xl shadow-md hover:shadow-xl hover:-translate-y-1 transition-all duration-300 overflow-hidden">
                    <div class="absolute top-0 left-0 w-full h-1.5 bg-blue-500"></div>
                    <div class="flex items-center justify-center w-12 h-12 mb-4 bg-blue-600 rounded-2xl ring-2 ring-blue-100 shadow-sm shrink-0 group-hover:scale-110 transition-transform duration-300">
                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                        </svg>
                    </div>
                    <h3 class="text-lg font-bold text-slate-800 mb-1 font-heading transition-colors duration-300 group-hover:text-blue-700">Secretaria de Agricultura e Meio Ambiente</h3>
                    <p class="text-sm text-slate-600 mb-3 flex-1">Agropecuária, meio ambiente e abastecimento alimentar.</p>
                    <a href="mailto:agricultura@assai.pr.gov.br" class="text-sm font-medium text-blue-600 hover:text-blue-800 hover:underline break-all transition-colors">
                        agricultura@assai.pr.gov.br
                    </a>
                    <div class="flex items-center gap-1.5 mt-2">
                        <svg class="w-4 h-4 text-blue-500 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" />
                        </svg>
                        <a href="tel:+554332620089" class="text-sm font-medium text-blue-600 hover:text-blue-800 hover:underline break-all transition-colors">(43) 3262-0089</a>
                    </div>
                </div>

                {{-- Secretaria de Finanças --}}
                <div class="group relative flex flex-col p-6 bg-white border border-slate-300/70 ring-1 ring-slate-200/70 rounded-xl shadow-md hover:shadow-xl hover:-translate-y-1 transition-all duration-300 overflow-hidden">
                    <div class="absolute top-0 left-0 w-full h-1.5 bg-blue-500"></div>
                    <div class="flex items-center justify-center w-12 h-12 mb-4 bg-blue-600 rounded-2xl ring-2 ring-blue-100 shadow-sm shrink-0 group-hover:scale-110 transition-transform duration-300">
                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                        </svg>
                    </div>
                    <h3 class="text-lg font-bold text-slate-800 mb-1 font-heading transition-colors duration-300 group-hover:text-blue-700">Secretaria de Finanças</h3>
                    <p class="text-sm text-slate-600 mb-3 flex-1">Tributação, IPTU, ISS e demais assuntos fiscais do município.</p>
                    <a href="mailto:financas@assai.pr.gov.br" class="text-sm font-medium text-blue-600 hover:text-blue-800 hover:underline break-all transition-colors">
                        financas@assai.pr.gov.br
                    </a>
                    <div class="flex items-center gap-1.5 mt-2">
                        <svg class="w-4 h-4 text-blue-500 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" />
                        </svg>
                        <a href="tel:+554332621313" class="text-sm font-medium text-blue-600 hover:text-blue-800 hover:underline break-all transition-colors">(43) 3262-1313</a>
                    </div>
                </div>

                {{-- Secretaria de Cultura e Turismo --}}
                <div class="group relative flex flex-col p-6 bg-white border border-slate-300/70 ring-1 ring-slate-200/70 rounded-xl shadow-md hover:shadow-xl hover:-translate-y-1 transition-all duration-300 overflow-hidden">
                    <div class="absolute top-0 left-0 w-full h-1.5 bg-blue-500"></div>
                    <div class="flex items-center justify-center w-12 h-12 mb-4 bg-blue-600 rounded-2xl ring-2 ring-blue-100 shadow-sm shrink-0 group-hover:scale-110 transition-transform duration-300">
                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                        </svg>
                    </div>
                    <h3 class="text-lg font-bold text-slate-800 mb-1 font-heading transition-colors duration-300 group-hover:text-blue-700">Secretaria de Cultura e Turismo</h3>
                    <p class="text-sm text-slate-600 mb-3 flex-1">Eventos culturais, turismo e preservação do patrimônio histórico.</p>
                    <a href="mailto:cultura@assai.pr.gov.br" class="text-sm font-medium text-blue-600 hover:text-blue-800 hover:underline break-all transition-colors">
                        cultura@assai.pr.gov.br
                    </a>
                    <div class="flex items-center gap-1.5 mt-2">
                        <svg class="w-4 h-4 text-blue-500 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" />
                        </svg>
                        <a href="tel:+554332623232" class="text-sm font-medium text-blue-600 hover:text-blue-800 hover:underline break-all transition-colors">(43) 3262-3232</a>
                    </div>
                </div>

                {{-- SECTI --}}
                <div class="group relative flex flex-col p-6 bg-white border border-slate-300/70 ring-1 ring-slate-200/70 rounded-xl shadow-md hover:shadow-xl hover:-translate-y-1 transition-all duration-300 overflow-hidden">
                    <div class="absolute top-0 left-0 w-full h-1.5 bg-blue-500"></div>
                    <div class="flex items-center justify-center w-12 h-12 mb-4 bg-blue-600 rounded-2xl ring-2 ring-blue-100 shadow-sm shrink-0 group-hover:scale-110 transition-transform duration-300">
                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                        </svg>
                    </div>
                    <h3 class="text-lg font-bold text-slate-800 mb-1 font-heading transition-colors duration-300 group-hover:text-blue-700">Sec. de Ciência, Tecnologia e Inovação</h3>
                    <p class="text-sm text-slate-600 mb-3 flex-1">Inovação, tecnologia e projetos de cidade inteligente.</p>
                    <a href="mailto:secti@assai.pr.gov.br" class="text-sm font-medium text-blue-600 hover:text-blue-800 hover:underline break-all transition-colors">
                        secti@assai.pr.gov.br
                    </a>
                    <div class="flex items-center gap-1.5 mt-2">
                        <svg class="w-4 h-4 text-blue-500 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" />
                        </svg>
                        <a href="tel:+554332620516" class="text-sm font-medium text-blue-600 hover:text-blue-800 hover:underline break-all transition-colors">(43) 3262-0516</a>
                    </div>
                </div>

                {{-- Secretaria de Obras e Serviços --}}
                <div class="group relative flex flex-col p-6 bg-white border border-slate-300/70 ring-1 ring-slate-200/70 rounded-xl shadow-md hover:shadow-xl hover:-translate-y-1 transition-all duration-300 overflow-hidden">
                    <div class="absolute top-0 left-0 w-full h-1.5 bg-blue-500"></div>
                    <div class="flex items-center justify-center w-12 h-12 mb-4 bg-blue-600 rounded-2xl ring-2 ring-blue-100 shadow-sm shrink-0 group-hover:scale-110 transition-transform duration-300">
                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                        </svg>
                    </div>
                    <h3 class="text-lg font-bold text-slate-800 mb-1 font-heading transition-colors duration-300 group-hover:text-blue-700">Secretaria de Obras e Serviços</h3>
                    <p class="text-sm text-slate-600 mb-3 flex-1">Infraestrutura urbana, manutenção e serviços públicos municipais.</p>
                    <a href="mailto:obras@assai.pr.gov.br" class="text-sm font-medium text-blue-600 hover:text-blue-800 hover:underline break-all transition-colors">
                        obras@assai.pr.gov.br
                    </a>
                    <div class="flex items-center gap-1.5 mt-2">
                        <svg class="w-4 h-4 text-blue-500 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" />
                        </svg>
                        <a href="tel:+554332620089" class="text-sm font-medium text-blue-600 hover:text-blue-800 hover:underline break-all transition-colors">(43) 3262-0089</a>
                    </div>
                </div>

                {{-- Secretaria de Esporte e Lazer --}}
                <div class="group relative flex flex-col p-6 bg-white border border-slate-300/70 ring-1 ring-slate-200/70 rounded-xl shadow-md hover:shadow-xl hover:-translate-y-1 transition-all duration-300 overflow-hidden">
                    <div class="absolute top-0 left-0 w-full h-1.5 bg-blue-500"></div>
                    <div class="flex items-center justify-center w-12 h-12 mb-4 bg-blue-600 rounded-2xl ring-2 ring-blue-100 shadow-sm shrink-0 group-hover:scale-110 transition-transform duration-300">
                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                        </svg>
                    </div>
                    <h3 class="text-lg font-bold text-slate-800 mb-1 font-heading transition-colors duration-300 group-hover:text-blue-700">Secretaria de Esporte e Lazer</h3>
                    <p class="text-sm text-slate-600 mb-3 flex-1">Promoção de esportes, lazer e atividades recreativas municipais.</p>
                    <a href="mailto:esporte@assai.pr.gov.br" class="text-sm font-medium text-blue-600 hover:text-blue-800 hover:underline break-all transition-colors">
                        esporte@assai.pr.gov.br
                    </a>
                    <div class="flex items-center gap-1.5 mt-2">
                        <svg class="w-4 h-4 text-blue-500 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" />
                        </svg>
                        <a href="tel:+554332621964" class="text-sm font-medium text-blue-600 hover:text-blue-800 hover:underline break-all transition-colors">(43) 3262-1964</a>
                    </div>
                </div>

                {{-- Secretaria de Desenvolvimento Local --}}
                <div class="group relative flex flex-col p-6 bg-white border border-slate-300/70 ring-1 ring-slate-200/70 rounded-xl shadow-md hover:shadow-xl hover:-translate-y-1 transition-all duration-300 overflow-hidden">
                    <div class="absolute top-0 left-0 w-full h-1.5 bg-blue-500"></div>
                    <div class="flex items-center justify-center w-12 h-12 mb-4 bg-blue-600 rounded-2xl ring-2 ring-blue-100 shadow-sm shrink-0 group-hover:scale-110 transition-transform duration-300">
                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                        </svg>
                    </div>
                    <h3 class="text-lg font-bold text-slate-800 mb-1 font-heading transition-colors duration-300 group-hover:text-blue-700">Secretaria de Desenvolvimento Local</h3>
                    <p class="text-sm text-slate-600 mb-3 flex-1">Fomento ao desenvolvimento econômico, empreendedorismo e geração de emprego.</p>
                    <a href="mailto:desenvolvimento@assai.pr.gov.br" class="text-sm font-medium text-blue-600 hover:text-blue-800 hover:underline break-all transition-colors">
                        desenvolvimento@assai.pr.gov.br
                    </a>
                    <div class="flex items-center gap-1.5 mt-2">
                        <svg class="w-4 h-4 text-blue-500 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" />
                        </svg>
                        <a href="tel:+554332621313" class="text-sm font-medium text-blue-600 hover:text-blue-800 hover:underline break-all transition-colors">(43) 3262-1313</a>
                    </div>
                </div>

                {{-- Secretaria Municipal de Segurança Alimentar e Nutrição --}}
                <div class="group relative flex flex-col p-6 bg-white border border-slate-300/70 ring-1 ring-slate-200/70 rounded-xl shadow-md hover:shadow-xl hover:-translate-y-1 transition-all duration-300 overflow-hidden">
                    <div class="absolute top-0 left-0 w-full h-1.5 bg-blue-500"></div>
                    <div class="flex items-center justify-center w-12 h-12 mb-4 bg-blue-600 rounded-2xl ring-2 ring-blue-100 shadow-sm shrink-0 group-hover:scale-110 transition-transform duration-300">
                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                        </svg>
                    </div>
                    <h3 class="text-lg font-bold text-slate-800 mb-1 font-heading transition-colors duration-300 group-hover:text-blue-700">Secretaria Municipal de Segurança Alimentar e Nutrição</h3>
                    <p class="text-sm text-slate-600 mb-3 flex-1">Políticas de segurança alimentar, nutrição e combate à fome.</p>
                    <a href="mailto:ouvidoria@assai.pr.gov.br" class="text-sm font-medium text-blue-600 hover:text-blue-800 hover:underline break-all transition-colors">
                        ouvidoria@assai.pr.gov.br
                    </a>
                    <div class="flex items-center gap-1.5 mt-2">
                        <svg class="w-4 h-4 text-blue-500 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" />
                        </svg>
                        <a href="tel:+554332624349" class="text-sm font-medium text-blue-600 hover:text-blue-800 hover:underline break-all transition-colors">(43) 3262-4349</a>
                    </div>
                </div>

                {{-- Secretaria de Trabalho, Emprego e Geração de Renda --}}
                <div class="group relative flex flex-col p-6 bg-white border border-slate-300/70 ring-1 ring-slate-200/70 rounded-xl shadow-md hover:shadow-xl hover:-translate-y-1 transition-all duration-300 overflow-hidden">
                    <div class="absolute top-0 left-0 w-full h-1.5 bg-blue-500"></div>
                    <div class="flex items-center justify-center w-12 h-12 mb-4 bg-blue-600 rounded-2xl ring-2 ring-blue-100 shadow-sm shrink-0 group-hover:scale-110 transition-transform duration-300">
                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                        </svg>
                    </div>
                    <h3 class="text-lg font-bold text-slate-800 mb-1 font-heading transition-colors duration-300 group-hover:text-blue-700">Secretaria de Trabalho, Emprego e Geração de Renda</h3>
                    <p class="text-sm text-slate-600 mb-3 flex-1">Intermediação de mão de obra, qualificação e políticas de emprego.</p>
                    <a href="mailto:trabalho@assai.pr.gov.br" class="text-sm font-medium text-blue-600 hover:text-blue-800 hover:underline break-all transition-colors">
                        trabalho@assai.pr.gov.br
                    </a>
                    <div class="flex items-center gap-1.5 mt-2">
                        <svg class="w-4 h-4 text-blue-500 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" />
                        </svg>
                        <a href="tel:+554332624958" class="text-sm font-medium text-blue-600 hover:text-blue-800 hover:underline break-all transition-colors">(43) 3262-4958</a>
                    </div>
                </div>

            </div>
        </div>

        {{-- ── TIER 4: Telefones Úteis e Emergência ── --}}
        <div class="mt-12 mb-4">
            <div class="flex items-center gap-3 mb-5">
                <span class="inline-flex items-center gap-1.5 px-3 py-1 text-xs font-bold tracking-wider uppercase text-red-700 bg-red-100 rounded-full shadow-sm">
                    <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd" />
                    </svg>
                    Telefones Úteis e Emergência
                </span>
                <div class="flex-1 h-px bg-red-200"></div>
            </div>

            <div class="grid grid-cols-1 gap-4 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4">
                {{-- URGÊNCIA/EMERGÊNCIA --}}
                <a href="tel:192" class="group flex items-center gap-4 p-4 bg-white border border-red-200 ring-1 ring-red-50 rounded-xl shadow-sm hover:shadow-md hover:-translate-y-1 transition-all duration-300">
                    {{-- Alterado: A cor padrão do SVG é definida explicitamente na própria tag SVG via classe text-* --}}
                    <span class="flex items-center justify-center w-14 h-14 rounded-full bg-red-100 text-red-600 text-2xl">
                        <i class="fa-solid fa-triangle-exclamation"></i>
                    </span>
                    <div>
                        <h3 class="font-bold text-slate-800 text-sm group-hover:text-red-700 transition-colors">SAMU (Ambulância)</h3>
                        <p class="text-lg font-black text-red-600 font-heading">192</p>
                    </div>
                </a>

                <a href="tel:193" class="group flex items-center gap-4 p-4 bg-white border border-red-200 ring-1 ring-red-50 rounded-xl shadow-sm hover:shadow-md hover:-translate-y-1 transition-all duration-300">
                    <span class="flex items-center justify-center w-14 h-14 rounded-full bg-red-100 text-red-600 text-2xl">
                        <i class="fa-solid fa-fire"></i>
                    </span>
                    <div>
                        <h3 class="font-bold text-slate-800 text-sm group-hover:text-red-700 transition-colors">Corpo de Bombeiros</h3>
                        <p class="text-lg font-black text-red-600 font-heading">193</p>
                    </div>
                </a>

                <a href="tel:32621234" class="group flex items-center gap-4 p-4 bg-white border border-red-200 ring-1 ring-red-50 rounded-xl shadow-sm hover:shadow-md hover:-translate-y-1 transition-all duration-300">
                    <span class="flex items-center justify-center w-14 h-14 rounded-full bg-red-100 text-red-600 text-2xl">
                        <i class="fa-solid fa-heart-pulse"></i>
                    </span>
                    <div>
                        <h3 class="font-bold text-slate-800 text-sm group-hover:text-red-700 transition-colors">Pronto Socorro</h3>
                        <p class="text-lg font-black text-red-600 font-heading">3262-1234</p>
                    </div>
                </a>

                <a href="tel:190" class="group flex items-center gap-4 p-4 bg-white border border-red-200 ring-1 ring-red-50 rounded-xl shadow-sm hover:shadow-md hover:-translate-y-1 transition-all duration-300">
                    <span class="flex items-center justify-center w-14 h-14 rounded-full bg-red-100 text-red-600 text-2xl">
                        <i class="fa-solid fa-shield-halved"></i>
                    </span>
                    <div>
                        <h3 class="font-bold text-slate-800 text-sm group-hover:text-red-700 transition-colors">Polícia Militar</h3>
                        <p class="text-lg font-black text-red-600 font-heading">190</p>
                    </div>
                </a>

                <a href="tel:32621441" class="group flex items-center gap-4 p-4 bg-white border border-red-200 ring-1 ring-red-50 rounded-xl shadow-sm hover:shadow-md hover:-translate-y-1 transition-all duration-300">
                    <span class="flex items-center justify-center w-14 h-14 rounded-full bg-red-100 text-red-600 text-2xl">
                        <i class="fa-solid fa-user-shield"></i>
                    </span>
                    <div>
                        <h3 class="font-bold text-slate-800 text-sm group-hover:text-red-700 transition-colors">Polícia Civil</h3>
                        <p class="text-lg font-black text-red-600 font-heading">3262-1441</p>
                    </div>
                </a>
                
                {{-- SERVIÇOS PÚBLICOS --}}
                <a href="tel:08005100116" class="group flex items-center gap-4 p-4 bg-white border border-yellow-200 ring-1 ring-yellow-50 rounded-xl shadow-sm hover:shadow-md hover:-translate-y-1 transition-all duration-300">
                    <span class="flex items-center justify-center w-14 h-14 rounded-full bg-yellow-100 text-yellow-700 text-2xl">
                        <i class="fa-solid fa-bolt"></i>
                    </span>
                    <div>
                        <h3 class="font-bold text-slate-800 text-sm group-hover:text-yellow-700 transition-colors">COPEL</h3>
                        <p class="text-lg font-black text-yellow-600 font-heading">0800 51 00 116</p>
                    </div>
                </a>

                <a href="tel:32621202" class="group flex items-center gap-4 p-4 bg-white border border-blue-200 ring-1 ring-blue-50 rounded-xl shadow-sm hover:shadow-md hover:-translate-y-1 transition-all duration-300">
                    <span class="flex items-center justify-center w-14 h-14 rounded-full bg-blue-100 text-blue-600 text-2xl">
                        <i class="fa-solid fa-droplet"></i>
                    </span>
                    <div>
                        <h3 class="font-bold text-slate-800 text-sm group-hover:text-blue-700 transition-colors">SANEPAR</h3>
                        <p class="text-lg font-black text-blue-600 font-heading">3262-1202</p>
                    </div>
                </a>

                <a href="tel:32621155" class="group flex items-center gap-4 p-4 bg-white border border-blue-200 ring-1 ring-blue-50 rounded-xl shadow-sm hover:shadow-md hover:-translate-y-1 transition-all duration-300">
                    <span class="flex items-center justify-center w-14 h-14 rounded-full bg-blue-100 text-blue-600 text-2xl">
                        <i class="fa-solid fa-id-card-clip"></i>
                    </span>
                    <div>
                        <h3 class="font-bold text-slate-800 text-sm group-hover:text-blue-700 transition-colors">DETRAN</h3>
                        <p class="text-lg font-black text-blue-600 font-heading">3262-1155</p>
                    </div>
                </a>

                <a href="tel:32621156" class="group flex items-center gap-4 p-4 bg-white border border-blue-200 ring-1 ring-blue-50 rounded-xl shadow-sm hover:shadow-md hover:-translate-y-1 transition-all duration-300">
                    <span class="flex items-center justify-center w-14 h-14 rounded-full bg-blue-100 text-blue-600 text-2xl">
                        <i class="fa-solid fa-bus"></i>
                    </span>
                    <div>
                        <h3 class="font-bold text-slate-800 text-sm group-hover:text-blue-700 transition-colors">Terminal Rodoviário</h3>
                        <p class="text-lg font-black text-blue-600 font-heading">3262-1156</p>
                    </div>
                </a>

                <a href="tel:32621313" class="group flex items-center gap-4 p-4 bg-white border border-blue-200 ring-1 ring-blue-50 rounded-xl shadow-sm hover:shadow-md hover:-translate-y-1 transition-all duration-300">
                    <span class="flex items-center justify-center w-14 h-14 rounded-full bg-blue-100 text-blue-600 text-2xl">
                        <i class="fa-solid fa-landmark"></i>
                    </span>
                    <div>
                        <h3 class="font-bold text-slate-800 text-sm group-hover:text-blue-700 transition-colors">Prefeitura Municipal</h3>
                        <p class="text-lg font-black text-blue-600 font-heading">3262-1313</p>
                    </div>
                </a>

                <a href="tel:32621414" class="group flex items-center gap-4 p-4 bg-white border border-blue-200 ring-1 ring-blue-50 rounded-xl shadow-sm hover:shadow-md hover:-translate-y-1 transition-all duration-300">
                    <span class="flex items-center justify-center w-14 h-14 rounded-full bg-blue-100 text-blue-600 text-2xl">
                        <i class="fa-solid fa-gavel"></i>
                    </span>
                    <div>
                        <h3 class="font-bold text-slate-800 text-sm group-hover:text-blue-700 transition-colors">Câmara Municipal</h3>
                        <p class="text-lg font-black text-blue-600 font-heading">3262-1414</p>
                    </div>
                </a>

                <a href="tel:32623201" class="group flex items-center gap-4 p-4 bg-white border border-blue-200 ring-1 ring-blue-50 rounded-xl shadow-sm hover:shadow-md hover:-translate-y-1 transition-all duration-300">
                    <span class="flex items-center justify-center w-14 h-14 rounded-full bg-blue-100 text-blue-600 text-2xl">
                        <i class="fa-solid fa-scale-balanced"></i>
                    </span>
                    <div>
                        <h3 class="font-bold text-slate-800 text-sm group-hover:text-blue-700 transition-colors">Fórum</h3>
                        <p class="text-lg font-black text-blue-600 font-heading">3262-3201</p>
                    </div>
                </a>
            </div>
        </div>
    </div>
</section>

{{-- ===== FORMULÁRIO + SIDEBAR ===== --}}
<section class="py-12 bg-[#eaf3ff] border-y border-blue-100/70 md:py-16">
    <div class="container px-4 mx-auto max-w-7xl">

        {{-- Cabeçalho da seção --}}
        <div class="portal-section-title !items-start !text-left mb-10">
            <h2 class="flex items-center gap-3 mb-2 text-2xl font-bold text-slate-800 font-heading">
                <span class="flex items-center justify-center w-10 h-10 text-blue-600 bg-blue-100 rounded-full shrink-0">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8" />
                    </svg>
                </span>
                Envie uma Mensagem
            </h2>
            <div class="bar !mt-1"></div>
            <p class="text-sm text-slate-500 ml-[52px]">Preencha o formulário abaixo e nossa equipe retornará o contato em breve.</p>
        </div>

        <div class="grid grid-cols-1 gap-10 lg:grid-cols-3">

            {{-- FORMULÁRIO (coluna principal) --}}
            <div class="lg:col-span-2">

                {{-- Alerta de sucesso --}}
                @if (session('success'))
                <div class="flex items-start gap-3 p-4 mb-6 text-green-800 bg-green-50 border border-green-200 rounded-2xl">
                    <svg class="w-5 h-5 mt-0.5 text-green-600 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                    </svg>
                    <p class="text-sm font-medium">{{ session('success') }}</p>
                </div>
                @endif

                {{-- Alerta de erro --}}
                @if (session('error'))
                <div class="flex items-start gap-3 p-4 mb-6 text-red-800 bg-red-50 border border-red-200 rounded-2xl">
                    <svg class="w-5 h-5 mt-0.5 text-red-600 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0" />
                    </svg>
                    <p class="text-sm font-medium">{{ session('error') }}</p>
                </div>
                @endif

                <div class="p-8 bg-white border border-slate-200 shadow-md hover:shadow-xl transition-all duration-300 rounded-3xl">
                    <form method="POST" action="{{ route('contato.store') }}" novalidate>
                        @csrf

                        {{-- Nome + Email --}}
                        <div class="grid grid-cols-1 gap-5 sm:grid-cols-2 mb-5">
                            <div>
                                <label for="nome" class="block mb-1.5 text-xs font-semibold text-slate-600 uppercase tracking-wider">
                                    Seu nome <span class="text-red-500">*</span>
                                </label>
                                <input
                                    type="text"
                                    id="nome"
                                    name="nome"
                                    value="{{ old('nome') }}"
                                    placeholder="Ex: João da Silva"
                                    class="w-full px-4 py-3 text-sm text-slate-800 bg-slate-100/50 border rounded-xl transition focus:outline-none focus:ring-2 focus:ring-blue-600 focus:border-blue-600 focus:ring-offset-2 focus:bg-white {{ $errors->has('nome') ? 'border-red-400 bg-red-50' : 'border-slate-200' }}">
                                @error('nome')
                                <p class="mt-1.5 text-xs text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                            <div>
                                <label for="email" class="block mb-1.5 text-xs font-semibold text-slate-600 uppercase tracking-wider">
                                    Seu e-mail <span class="text-red-500">*</span>
                                </label>
                                <input
                                    type="email"
                                    id="email"
                                    name="email"
                                    value="{{ old('email') }}"
                                    placeholder="seu@email.com"
                                    class="w-full px-4 py-3 text-sm text-slate-800 bg-slate-100/50 border rounded-xl transition focus:outline-none focus:ring-2 focus:ring-blue-600 focus:border-blue-600 focus:ring-offset-2 focus:bg-white {{ $errors->has('email') ? 'border-red-400 bg-red-50' : 'border-slate-200' }}">
                                @error('email')
                                <p class="mt-1.5 text-xs text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        {{-- Setor de Destino (Novo Campo) --}}
                        <div class="mb-5">
                            <label for="destinatario" class="block mb-1.5 text-xs font-semibold text-slate-600 uppercase tracking-wider">
                                Setor de Destino <span class="text-red-500">*</span>
                            </label>
                            <div class="relative">
                                <select
                                    id="destinatario"
                                    name="destinatario"
                                    required
                                    class="w-full px-4 py-3 text-sm text-slate-800 bg-slate-100/50 border appearance-none rounded-xl transition focus:outline-none focus:ring-2 focus:ring-blue-600 focus:border-blue-600 focus:ring-offset-2 focus:bg-white {{ $errors->has('destinatario') ? 'border-red-400 bg-red-50' : 'border-slate-200' }}">
                                    <option value="" disabled {{ old('destinatario') ? '' : 'selected' }}>Selecione o setor desejado...</option>

                                    {{-- Ouvidoria como opção primária estática --}}
                                    <option value="ouvidoria@assai.pr.gov.br" {{ old('destinatario') == 'ouvidoria@assai.pr.gov.br' ? 'selected' : '' }}>
                                        Ouvidoria Municipal (Padrão)
                                    </option>

                                    {{-- Iteração de Secretarias Dinâmicas --}}
                                    @if(isset($secretarias))
                                    @foreach($secretarias as $secretaria)
                                    @if($secretaria->email)
                                    <option value="{{ $secretaria->email }}" {{ old('destinatario') == $secretaria->email ? 'selected' : '' }}>
                                        {{ $secretaria->nome }}
                                    </option>
                                    @endif
                                    @endforeach
                                    @endif
                                </select>
                                {{-- Ícone Customizado para Select --}}
                                <div class="absolute inset-y-0 right-0 flex items-center px-4 pointer-events-none text-slate-500">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                                    </svg>
                                </div>
                            </div>
                            @error('destinatario')
                            <p class="mt-1.5 text-xs text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- Assunto --}}
                        <div class="mb-5">
                            <label for="assunto" class="block mb-1.5 text-xs font-semibold text-slate-600 uppercase tracking-wider">
                                Assunto <span class="text-red-500">*</span>
                            </label>
                            <input
                                type="text"
                                id="assunto"
                                name="assunto"
                                value="{{ old('assunto') }}"
                                placeholder="Ex: Solicitação de manutenção em via pública"
                                class="w-full px-4 py-3 text-sm text-slate-800 bg-slate-100/50 border rounded-xl transition focus:outline-none focus:ring-2 focus:ring-blue-600 focus:border-blue-600 focus:ring-offset-2 focus:bg-white {{ $errors->has('assunto') ? 'border-red-400 bg-red-50' : 'border-slate-200' }}">
                            @error('assunto')
                            <p class="mt-1.5 text-xs text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- Mensagem --}}
                        <div class="mb-6">
                            <label for="mensagem" class="block mb-1.5 text-xs font-semibold text-slate-600 uppercase tracking-wider">
                                Mensagem <span class="text-red-500">*</span>
                            </label>
                            <textarea
                                id="mensagem"
                                name="mensagem"
                                rows="6"
                                placeholder="Descreva sua solicitação, dúvida ou sugestão..."
                                class="w-full px-4 py-3 text-sm text-slate-800 bg-slate-100/50 border rounded-xl resize-none transition focus:outline-none focus:ring-2 focus:ring-blue-600 focus:border-blue-600 focus:ring-offset-2 focus:bg-white {{ $errors->has('mensagem') ? 'border-red-400 bg-red-50' : 'border-slate-200' }}">{{ old('mensagem') }}</textarea>
                            @error('mensagem')
                            <p class="mt-1.5 text-xs text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <button type="submit" class="inline-flex items-center gap-2 px-8 py-3 text-sm font-bold text-white bg-blue-700 rounded-xl hover:bg-blue-800 active:scale-95 transition shadow-md hover:shadow-xl transition-all duration-300">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8" />
                            </svg>
                            Enviar mensagem
                        </button>
                    </form>
                </div>
            </div>

            {{-- SIDEBAR --}}
            <div class="flex flex-col gap-6">

                {{-- Mapa --}}
                <div class="overflow-hidden rounded-3xl shadow-md hover:shadow-xl transition-all duration-300 border border-slate-200">
                    <iframe
                        title="Localização da Prefeitura Municipal de Assaí"
                        src="https://maps.google.com/maps?q=Prefeitura+Municipal+de+Assaí,+Av.+Rio+de+Janeiro,+720,+Assaí,+PR&output=embed"
                        width="100%"
                        height="220"
                        class="border-0"
                        allowfullscreen=""
                        loading="lazy"
                        referrerpolicy="no-referrer-when-downgrade">
                    </iframe>
                </div>

                {{-- Card: Endereço --}}
                <div class="group relative p-6 bg-white border border-slate-300/80 ring-1 ring-slate-200 rounded-3xl shadow-md hover:shadow-xl hover:-translate-y-1 transition-all duration-300 overflow-hidden">
                    <div class="absolute top-0 left-0 w-full h-2 bg-slate-600"></div>
                    <div class="flex items-center gap-3 mb-3">
                        <div class="flex items-center justify-center w-12 h-12 bg-slate-100 border border-slate-200 rounded-2xl shrink-0">
                            <svg class="w-6 h-6 text-slate-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                            </svg>
                        </div>
                        <h3 class="text-lg font-extrabold text-slate-900 font-heading transition-colors duration-300 group-hover:text-slate-800">Endereço</h3>
                    </div>
                    <p class="text-sm font-medium text-slate-700 leading-relaxed">
                        Av. Rio de Janeiro, 720
                    </p>
                    <p class="text-sm text-slate-700 leading-relaxed">
                        Centro - Assaí/PR
                    </p>
                    <p class="mt-1 inline-flex items-center px-2.5 py-1 text-xs font-semibold tracking-wide uppercase text-slate-700 bg-slate-100 rounded-full">
                        CEP 86260-000
                    </p>
                </div>

                {{-- Card: Atendimento --}}
                <div class="group relative p-6 bg-white border border-yellow-300/80 ring-1 ring-yellow-200 rounded-3xl shadow-md hover:shadow-xl hover:-translate-y-1 transition-all duration-300 overflow-hidden">
                    <div class="absolute top-0 left-0 w-full h-2 bg-yellow-500"></div>
                    <div class="flex items-center gap-3 mb-3">
                        <div class="flex items-center justify-center w-12 h-12 bg-yellow-100 border border-yellow-200 rounded-2xl shrink-0">
                            <svg class="w-6 h-6 text-yellow-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </div>
                        <h3 class="text-lg font-extrabold text-slate-900 font-heading transition-colors duration-300 group-hover:text-yellow-800">Horário de Atendimento</h3>
                    </div>
                    <p class="text-sm font-semibold text-slate-700 leading-relaxed">Segunda a Sexta</p>
                    <p class="mt-1 inline-flex items-center px-2.5 py-1 text-xs font-semibold tracking-wide uppercase text-yellow-800 bg-yellow-100 rounded-full">
                        08h às 11h30 e 13h às 17h
                    </p>
                </div>

            </div>
        </div>
    </div>
</section>

@endsection