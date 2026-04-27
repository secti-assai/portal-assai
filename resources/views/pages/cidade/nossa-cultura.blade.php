@extends('layouts.app')
@section('title', 'Nossa Cultura - Prefeitura Municipal de Assaí')

@section('content')
    <style>
        body,
        html {
            overflow-x: hidden !important;
        }
    </style>

    {{-- ===== HERO SECTION ===== --}}
    <section
        class="relative pt-[calc(var(--site-header-height,72px)+1.5rem)] pb-16 sm:pt-[calc(var(--site-header-height,72px)+2.5rem)] md:pt-[calc(var(--site-header-height,72px)+3.5rem)] md:pb-24 lg:pt-24 lg:pb-24 overflow-hidden bg-[#006eb7] w-full max-w-full">
        <div class="absolute inset-0 pointer-events-none" aria-hidden="true">
            <svg class="absolute w-full h-full opacity-10" xmlns="http://www.w3.org/2000/svg">
                <defs>
                    <pattern id="culture-grid" width="80" height="80" patternUnits="userSpaceOnUse">
                        <path d="M 80 0 L 0 0 0 80" fill="none" stroke="white" stroke-width="0.5" />
                        <circle cx="40" cy="40" r="1.5" fill="white" opacity="0.5" />
                    </pattern>
                </defs>
                <rect width="100%" height="100%" fill="url(#culture-grid)" />
            </svg>
            <div class="absolute bottom-0 left-0 right-0 h-64 bg-gradient-to-t from-slate-950/80 to-transparent"></div>
        </div>

        <div class="container relative z-10 px-4 sm:px-6 md:px-8 mx-auto text-left max-w-6xl w-full">
            <div class="relative z-20">
                <x-breadcrumb :items="[
            ['name' => 'Início', 'url' => route('home')],
            ['name' => 'Cidade', 'url' => null],
            ['name' => 'Nossa Cultura', 'url' => null]
        ]" dark />
            </div>

            <div class="mt-8 md:mt-10 max-w-3xl">
                <span
                    class="inline-flex items-center gap-2 px-4 py-1.5 mb-6 text-xs font-bold tracking-[0.2em] text-blue-900 uppercase bg-yellow-400 rounded-full shadow-sm animate-fade-in-up">
                    Identidade & Diversidade
                </span>
                <h1 class="text-4xl sm:text-5xl md:text-6xl font-extrabold font-heading mb-6 text-white drop-shadow-md leading-tight"
                    style="font-family: 'Montserrat', sans-serif;">
                    Nossa <span class="text-yellow-400 relative">
                        Cultura
                        <svg class="absolute w-full h-3 -bottom-1 left-0 text-yellow-400 opacity-60" viewBox="0 0 100 10"
                            preserveAspectRatio="none">
                            <path d="M0 5 Q 50 10 100 5" stroke="currentColor" stroke-width="2" fill="transparent" />
                        </svg>
                    </span>
                </h1>
                <p class="text-lg sm:text-xl md:text-2xl text-blue-50 leading-relaxed font-light mb-6 opacity-90">
                    O inventário do patrimônio material e imaterial de Assaí, resultante da convergência entre a imigração
                    oriental, a força nordestina e a tradição paranaense.
                </p>
            </div>
        </div>
    </section>

    {{-- ===== A TRÍADE FORMADORA ===== --}}
    <section class="py-16 md:py-24 bg-slate-50 border-b border-slate-200 relative">
        {{-- Decoração sutil de fundo --}}
        <div
            class="absolute top-0 right-0 w-64 h-64 bg-blue-100/50 rounded-full blur-3xl -translate-y-1/2 translate-x-1/2 pointer-events-none">
        </div>

        <div class="container px-4 sm:px-6 md:px-8 mx-auto max-w-6xl w-full relative z-10">
            <div class="text-center mb-14">
                <h2 class="text-3xl font-black text-slate-800 md:text-4xl font-heading mb-4"
                    style="font-family: 'Montserrat', sans-serif;">A Matriz Formadora</h2>
                <p class="text-slate-500 max-w-2xl mx-auto text-lg">Os três grandes pilares que ergueram a sociedade
                    assaiense contemporânea.</p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                {{-- Pilar 1: Japonês --}}
                <div
                    class="bg-white rounded-3xl p-8 border-t-4 border-t-[#006eb7] border-x border-b border-slate-200 shadow-sm hover:shadow-xl hover:-translate-y-1 transition-all duration-300 group">
                    <div
                        class="w-14 h-14 bg-blue-50 text-[#006eb7] rounded-2xl flex items-center justify-center text-2xl mb-6 group-hover:bg-[#006eb7] group-hover:text-white transition-colors">
                        <i class="fa-solid fa-torii-gate" aria-hidden="true"></i>
                    </div>
                    <h3 class="text-xl font-extrabold text-slate-800 mb-3 font-heading">Imigração Japonesa</h3>
                    <p class="text-[15px] text-slate-600 leading-relaxed mb-6 flex-1">
                        Assaí abriga a maior proporção de descendentes nipônicos do Brasil. A influência manifesta-se na
                        arquitetura, no paisagismo com Sakuras e na preservação de ritos seculares.
                    </p>
                    <div class="pt-4 border-t border-slate-100 space-y-3">
                        <div class="flex items-center gap-3 text-sm text-slate-700 font-medium">
                            <div class="w-6 h-6 rounded-full bg-blue-50 flex items-center justify-center shrink-0"><i
                                    class="fa-solid fa-check text-[#006eb7] text-[10px]"></i></div>
                            <span>Templo Budista Shoshinji</span>
                        </div>
                        <div class="flex items-center gap-3 text-sm text-slate-700 font-medium">
                            <div class="w-6 h-6 rounded-full bg-blue-50 flex items-center justify-center shrink-0"><i
                                    class="fa-solid fa-check text-[#006eb7] text-[10px]"></i></div>
                            <span>Assahi Wadaiko (Taiko)</span>
                        </div>
                    </div>
                </div>

                {{-- Pilar 2: Nordestino --}}
                <div
                    class="bg-white rounded-3xl p-8 border-t-4 border-t-amber-500 border-x border-b border-slate-200 shadow-sm hover:shadow-xl hover:-translate-y-1 transition-all duration-300 group">
                    <div
                        class="w-14 h-14 bg-amber-50 text-amber-600 rounded-2xl flex items-center justify-center text-2xl mb-6 group-hover:bg-amber-500 group-hover:text-white transition-colors">
                        <i class="fa-solid fa-sun-plant-wilt" aria-hidden="true"></i>
                    </div>
                    <h3 class="text-xl font-extrabold text-slate-800 mb-3 font-heading">Migração Nordestina</h3>
                    <p class="text-[15px] text-slate-600 leading-relaxed mb-6 flex-1">
                        Força motriz do ciclo do algodão, a comunidade nordestina é pilar cofundador do município,
                        introduzindo sincretismo religioso, culinária típica e folclore literário.
                    </p>
                    <div class="pt-4 border-t border-slate-100 space-y-3">
                        <div class="flex items-center gap-3 text-sm text-slate-700 font-medium">
                            <div class="w-6 h-6 rounded-full bg-amber-50 flex items-center justify-center shrink-0"><i
                                    class="fa-solid fa-check text-amber-600 text-[10px]"></i></div>
                            <span>Festa Nordestina de Assaí</span>
                        </div>
                        <div class="flex items-center gap-3 text-sm text-slate-700 font-medium">
                            <div class="w-6 h-6 rounded-full bg-amber-50 flex items-center justify-center shrink-0"><i
                                    class="fa-solid fa-check text-amber-600 text-[10px]"></i></div>
                            <span>Influência no Forró e Baião</span>
                        </div>
                    </div>
                </div>

                {{-- Pilar 3: Paranaense --}}
                <div
                    class="bg-white rounded-3xl p-8 border-t-4 border-t-emerald-500 border-x border-b border-slate-200 shadow-sm hover:shadow-xl hover:-translate-y-1 transition-all duration-300 group">
                    <div
                        class="w-14 h-14 bg-emerald-50 text-emerald-600 rounded-2xl flex items-center justify-center text-2xl mb-6 group-hover:bg-emerald-500 group-hover:text-white transition-colors">
                        <i class="fa-solid fa-tractor" aria-hidden="true"></i>
                    </div>
                    <h3 class="text-xl font-extrabold text-slate-800 mb-3 font-heading">Tradição Sulista</h3>
                    <p class="text-[15px] text-slate-600 leading-relaxed mb-6 flex-1">
                        A cultura sulista e tropeira manifesta-se fortemente na vida rural e nos costumes agropecuários que
                        fundaram o Norte do Paraná, com foco na agricultura familiar.
                    </p>
                    <div class="pt-4 border-t border-slate-100 space-y-3">
                        <div class="flex items-center gap-3 text-sm text-slate-700 font-medium">
                            <div class="w-6 h-6 rounded-full bg-emerald-50 flex items-center justify-center shrink-0"><i
                                    class="fa-solid fa-check text-emerald-600 text-[10px]"></i></div>
                            <span>Cavalgadas e Romarias</span>
                        </div>
                        <div class="flex items-center gap-3 text-sm text-slate-700 font-medium">
                            <div class="w-6 h-6 rounded-full bg-emerald-50 flex items-center justify-center shrink-0"><i
                                    class="fa-solid fa-check text-emerald-600 text-[10px]"></i></div>
                            <span>Feiras Livres do Produtor</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- ===== PATRIMÔNIO ARQUITETÔNICO ===== --}}
    <section class="py-12 md:py-20 bg-white border-b border-slate-200">
        <div class="container px-4 sm:px-6 md:px-8 mx-auto max-w-6xl w-full">
            <h2 class="text-3xl font-black text-slate-800 md:text-4xl font-heading mb-8"
                style="font-family: 'Montserrat', sans-serif;">Patrimônio Arquitetônico e Histórico</h2>

            <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                <div class="flex flex-col rounded-3xl overflow-hidden shadow-lg border border-slate-200 bg-slate-900 group">
                    <div class="relative h-64 overflow-hidden">
                        <img src="{{ asset('img/assai_1.jpg') }}" alt="Memorial da Imigração Japonesa - Castelo"
                            class="w-full h-full object-cover opacity-80 group-hover:scale-105 transition-transform duration-700">
                    </div>
                    <div class="p-6 md:p-8 bg-white flex-1">
                        <span class="text-xs font-bold text-[#006eb7] uppercase tracking-widest mb-2 block">Símbolo
                            Máximo</span>
                        <h3 class="text-2xl font-extrabold text-slate-800 mb-3 font-heading">Memorial da Imigração (Castelo
                            Japonês)</h3>
                        <p class="text-sm text-slate-600 mb-4">
                            Inspirado no Castelo de Himeji. Estrutura monumental de 25 metros de altura dividida em 4
                            pavimentos temáticos, atuando como museu e centro cultural.
                        </p>
                        <ul class="text-sm text-slate-700 space-y-2 bg-slate-50 p-4 rounded-xl border border-slate-100">
                            <li><strong>Térreo:</strong> Salas de exposição itinerante e recepção turística.</li>
                            <li><strong>1º e 2º Pisos:</strong> Acervo histórico da "Era do Ouro Branco" e equipamentos
                                agrícolas dos pioneiros.</li>
                            <li><strong>3º Piso:</strong> Mirante panorâmico com visão 360º da cidade e da Praça de Tóquio.
                            </li>
                        </ul>
                    </div>
                </div>

                <div class="flex flex-col rounded-3xl overflow-hidden shadow-lg border border-slate-200 bg-slate-900 group">
                    <div class="relative h-64 overflow-hidden">
                        <img src="{{ asset('img/igreja_matriz.jpg') }}" alt="Igreja Matriz São José"
                            class="w-full h-full object-cover opacity-80 group-hover:scale-105 transition-transform duration-700">
                    </div>
                    <div class="p-6 md:p-8 bg-white flex-1">
                        <span class="text-xs font-bold text-[#006eb7] uppercase tracking-widest mb-2 block">Patrimônio
                            Religioso</span>
                        <h3 class="text-2xl font-extrabold text-slate-800 mb-3 font-heading">Igreja Matriz São José</h3>
                        <p class="text-sm text-slate-600 mb-4">
                            Centro do catolicismo local e sede das festividades do padroeiro do município (celebrado em 19
                            de março). O projeto arquitetônico marca o desenvolvimento urbano da zona central.
                        </p>
                        <ul class="text-sm text-slate-700 space-y-2 bg-slate-50 p-4 rounded-xl border border-slate-100">
                            <li><strong>Santuário Integrado:</strong> Abriga o Santuário de Nossa Senhora Aparecida.</li>
                            <li><strong>Evento Principal:</strong> Festa de São José (com romarias e quermesses).</li>
                            <li><strong>Vitrais:</strong> Acervo de vitrais que recontam passagens bíblicas.</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- ===== DESPORTO E DISCIPLINA ===== --}}
    <section class="py-16 md:py-24 bg-slate-900 relative overflow-hidden">
        <div
            class="absolute inset-0 bg-[url('https://www.transparenttextures.com/patterns/stardust.png')] opacity-10 mix-blend-overlay">
        </div>
        <div
            class="absolute top-1/2 left-0 w-96 h-96 bg-blue-600/20 rounded-full blur-[120px] -translate-y-1/2 -translate-x-1/2 pointer-events-none">
        </div>

        <div class="container px-4 sm:px-6 md:px-8 mx-auto max-w-6xl w-full relative z-10">
            <div class="flex flex-col lg:flex-row gap-12 items-center">

                <div class="w-full lg:w-5/12 text-white">
                    <span class="text-yellow-400 font-bold tracking-widest uppercase text-xs mb-2 block">Tradição
                        Esportiva</span>
                    <h2 class="text-3xl font-black md:text-5xl font-heading mb-6 leading-tight"
                        style="font-family: 'Montserrat', sans-serif;">A Força do <br>Desporto Local</h2>
                    <p class="text-slate-300 leading-relaxed mb-8 text-lg font-light">
                        O desporto em Assaí transcende a atividade física. Através da Associação Cultural (ACA), é um
                        veículo rigoroso de transmissão de valores morais e disciplina entre as gerações.
                    </p>
                    <div
                        class="inline-flex items-center gap-3 px-5 py-3 bg-white/10 border border-white/20 rounded-xl backdrop-blur-sm">
                        <i class="fa-solid fa-trophy text-yellow-400 text-2xl"></i>
                        <span class="font-bold text-sm">Celeiro Nacional de Atletas</span>
                    </div>
                </div>

                <div class="w-full lg:w-7/12">
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        {{-- Baseball --}}
                        <div
                            class="bg-gradient-to-br from-blue-800 to-blue-900 p-6 rounded-3xl border border-white/10 shadow-xl hover:-translate-y-1 transition-transform">
                            <div class="w-12 h-12 bg-white/10 rounded-xl flex items-center justify-center mb-4">
                                <i class="fa-solid fa-baseball text-xl text-yellow-400"></i>
                            </div>
                            <h4 class="font-extrabold text-white text-lg mb-2">Beisebol & Softbol</h4>
                            <p class="text-sm text-blue-200 leading-relaxed">Sede de grandes campeonatos nacionais e eterna
                                reveladora de talentos para seleções.</p>
                        </div>

                        {{-- Judô --}}
                        <div
                            class="bg-gradient-to-br from-blue-800 to-blue-900 p-6 rounded-3xl border border-white/10 shadow-xl hover:-translate-y-1 transition-transform">
                            <div class="w-12 h-12 bg-white/10 rounded-xl flex items-center justify-center mb-4">
                                <i class="fa-solid fa-user-ninja text-xl text-emerald-400"></i>
                            </div>
                            <h4 class="font-extrabold text-white text-lg mb-2">Judô & Kendô</h4>
                            <p class="text-sm text-blue-200 leading-relaxed">Dojôs tradicionais focados não apenas no
                                combate, mas na disciplina mental (Bushido).</p>
                        </div>

                        {{-- Gateball --}}
                        <div
                            class="bg-gradient-to-br from-blue-800 to-blue-900 p-6 rounded-3xl border border-white/10 shadow-xl hover:-translate-y-1 transition-transform">
                            <div class="w-12 h-12 bg-white/10 rounded-xl flex items-center justify-center mb-4">
                                <i class="fa-solid fa-bowling-ball text-xl text-pink-400"></i>
                            </div>
                            <h4 class="font-extrabold text-white text-lg mb-2">Gateball</h4>
                            <p class="text-sm text-blue-200 leading-relaxed">Esporte tático intergeracional, extremamente
                                respeitado e popular entre a comunidade idosa.</p>
                        </div>

                        {{-- Tênis de Mesa --}}
                        <div
                            class="bg-gradient-to-br from-blue-800 to-blue-900 p-6 rounded-3xl border border-white/10 shadow-xl hover:-translate-y-1 transition-transform">
                            <div class="w-12 h-12 bg-white/10 rounded-xl flex items-center justify-center mb-4">
                                <i class="fa-solid fa-table-tennis-paddle-ball text-xl text-orange-400"></i>
                            </div>
                            <h4 class="font-extrabold text-white text-lg mb-2">Tênis de Mesa</h4>
                            <p class="text-sm text-blue-200 leading-relaxed">Estrutura de ponta com atletas locais
                                disputando regularmente ligas estaduais.</p>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </section>

    {{-- ===== GASTRONOMIA E ROTAS ===== --}}
    <section class="py-16 md:py-24 bg-white">
        <div class="container px-4 sm:px-6 md:px-8 mx-auto max-w-6xl w-full">
            <div
                class="bg-gradient-to-br from-orange-50 via-amber-50 to-orange-100 rounded-[3rem] p-8 md:p-14 border border-orange-200/50 shadow-inner">

                <div class="text-center mb-12">
                    <h2 class="text-3xl font-black text-slate-800 md:text-4xl font-heading mb-4"
                        style="font-family: 'Montserrat', sans-serif;">Roteiro Rural e Gastronômico</h2>
                    <p class="text-orange-900/80 max-w-2xl mx-auto">Uma viagem de sabores autênticos que nascem da terra e
                        da união de continentes.</p>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-6 lg:gap-8">
                    {{-- Card Gastronomia --}}
                    <div
                        class="bg-white/80 backdrop-blur-sm p-8 rounded-3xl shadow-sm border border-white hover:shadow-lg transition-shadow text-center">
                        <div
                            class="w-16 h-16 bg-gradient-to-br from-orange-400 to-red-500 text-white rounded-full flex items-center justify-center text-2xl mb-6 mx-auto shadow-md">
                            <i class="fa-solid fa-bowl-rice"></i>
                        </div>
                        <h3 class="font-extrabold text-slate-800 mb-3 text-lg font-heading">Culinária Oriental</h3>
                        <p class="text-sm text-slate-600 leading-relaxed">Referência estadual na produção e consumo de Udon
                            caseiro, Yakisoba autêntico, Sushi e preservação do cultivo do arroz Motigomê.</p>
                    </div>

                    {{-- Card Café --}}
                    <div
                        class="bg-white/80 backdrop-blur-sm p-8 rounded-3xl shadow-sm border border-white hover:shadow-lg transition-shadow text-center">
                        <div
                            class="w-16 h-16 bg-gradient-to-br from-amber-600 to-amber-800 text-white rounded-full flex items-center justify-center text-2xl mb-6 mx-auto shadow-md">
                            <i class="fa-solid fa-mug-hot"></i>
                        </div>
                        <h3 class="font-extrabold text-slate-800 mb-3 text-lg font-heading">Rota do Café-Forte</h3>
                        <p class="text-sm text-slate-600 leading-relaxed">Turismo imersivo em propriedades rurais
                            históricas, com resgate da arquitetura das antigas tulhas e gigantescos terreiros de café.</p>
                    </div>

                    {{-- Card Feiras --}}
                    <div
                        class="bg-white/80 backdrop-blur-sm p-8 rounded-3xl shadow-sm border border-white hover:shadow-lg transition-shadow text-center">
                        <div
                            class="w-16 h-16 bg-gradient-to-br from-emerald-500 to-green-600 text-white rounded-full flex items-center justify-center text-2xl mb-6 mx-auto shadow-md">
                            <i class="fa-solid fa-store"></i>
                        </div>
                        <h3 class="font-extrabold text-slate-800 mb-3 text-lg font-heading">Feiras Tradicionais</h3>
                        <p class="text-sm text-slate-600 leading-relaxed">A fusão completa: barracas que oferecem desde o
                            tradicional Pastel de Feira até acarajés e os raros produtos derivados da Raiz de Lótus
                            (Renkon).</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- ===== CALENDÁRIO DE EVENTOS (NOVO LAYOUT DE CARDS) ===== --}}
    <section class="py-16 md:py-24 bg-slate-50 border-b border-slate-200">
        <div class="container px-4 sm:px-6 md:px-8 mx-auto max-w-6xl w-full">
            <div class="text-center mb-14">
                <span
                    class="inline-block px-3 py-1 bg-emerald-100 text-emerald-800 text-[10px] font-black uppercase tracking-widest rounded-md mb-3">Agenda
                    Cultural</span>
                <h2 class="text-3xl font-black text-slate-800 md:text-4xl font-heading mb-4"
                    style="font-family: 'Montserrat', sans-serif;">Calendário de Festividades</h2>
                <p class="text-slate-500 max-w-2xl mx-auto text-lg">Os grandes eventos que movimentam a economia e a alegria
                    da cidade durante o ano.</p>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">


                {{-- Festival Japonês --}}
                <div class="bg-white rounded-2xl p-6 border border-slate-200 shadow-sm hover:shadow-md transition-shadow relative overflow-hidden group">
                    <div class="absolute top-0 left-0 w-1.5 h-full bg-purple-500"></div>
                    <div class="pl-3">
                        <span class="text-xs font-bold text-purple-600 uppercase tracking-wider mb-1 block">Março</span>
                        <h3 class="text-lg font-extrabold text-slate-800 mb-2 font-heading">Festival Japonês</h3>
                        <p class="text-sm text-slate-600 mb-4">Celebração da cultura japonesa com apresentações e culinária típica.</p>
                        <span class="inline-flex items-center gap-1.5 px-2.5 py-1 bg-slate-100 text-slate-600 text-[10px] font-bold rounded">
                            <i class="fa-solid fa-location-dot"></i> Espaço de Eventos
                        </span>
                    </div>
                </div>

                {{-- Aniversário da Cidade --}}
                <div class="bg-white rounded-2xl p-6 border border-slate-200 shadow-sm hover:shadow-md transition-shadow relative overflow-hidden group">
                    <div class="absolute top-0 left-0 w-1.5 h-full bg-blue-700"></div>
                    <div class="pl-3">
                        <span class="text-xs font-bold text-blue-700 uppercase tracking-wider mb-1 block">Abril/Maio</span>
                        <h3 class="text-lg font-extrabold text-slate-800 mb-2 font-heading">Aniversário da Cidade</h3>
                        <p class="text-sm text-slate-600 mb-4">Desfile cívico, shows e eventos culturais comemorativos.</p>
                        <span class="inline-flex items-center gap-1.5 px-2.5 py-1 bg-slate-100 text-slate-600 text-[10px] font-bold rounded">
                            <i class="fa-solid fa-location-dot"></i> Centro de Eventos
                        </span>
                    </div>
                </div>

                {{-- Exposição Agropecuária --}}
                <div class="bg-white rounded-2xl p-6 border border-slate-200 shadow-sm hover:shadow-md transition-shadow relative overflow-hidden group">
                    <div class="absolute top-0 left-0 w-1.5 h-full bg-emerald-500"></div>
                    <div class="pl-3">
                        <span class="text-xs font-bold text-emerald-600 uppercase tracking-wider mb-1 block">Junho</span>
                        <h3 class="text-lg font-extrabold text-slate-800 mb-2 font-heading">Exposição Agropecuária</h3>
                        <p class="text-sm text-slate-600 mb-4">Feira agrícola com atrações, negócios e shows nacionais.</p>
                        <span class="inline-flex items-center gap-1.5 px-2.5 py-1 bg-slate-100 text-slate-600 text-[10px] font-bold rounded">
                            <i class="fa-solid fa-location-dot"></i> Centro de Eventos
                        </span>
                    </div>
                </div>

                {{-- Festa Julina --}}
                <div class="bg-white rounded-2xl p-6 border border-slate-200 shadow-sm hover:shadow-md transition-shadow relative overflow-hidden group">
                    <div class="absolute top-0 left-0 w-1.5 h-full bg-yellow-400"></div>
                    <div class="pl-3">
                        <span class="text-xs font-bold text-yellow-600 uppercase tracking-wider mb-1 block">Julho</span>
                        <h3 class="text-lg font-extrabold text-slate-800 mb-2 font-heading">Festa Julina</h3>
                        <p class="text-sm text-slate-600 mb-4">Festa típica com comidas, quadrilhas e apresentações culturais.</p>
                        <span class="inline-flex items-center gap-1.5 px-2.5 py-1 bg-slate-100 text-slate-600 text-[10px] font-bold rounded">
                            <i class="fa-solid fa-location-dot"></i> Espaço de Eventos
                        </span>
                    </div>
                </div>

                {{-- Festival das Estrelas --}}
                <div class="bg-white rounded-2xl p-6 border border-slate-200 shadow-sm hover:shadow-md transition-shadow relative overflow-hidden group">
                    <div class="absolute top-0 left-0 w-1.5 h-full bg-amber-600"></div>
                    <div class="pl-3">
                        <span class="text-xs font-bold text-amber-600 uppercase tracking-wider mb-1 block">Agosto</span>
                        <h3 class="text-lg font-extrabold text-slate-800 mb-2 font-heading">Festival das Estrelas</h3>
                        <p class="text-sm text-slate-600 mb-4">Celebração japonesa com decoração temática e apresentações culturais.</p>
                        <span class="inline-flex items-center gap-1.5 px-2.5 py-1 bg-slate-100 text-slate-600 text-[10px] font-bold rounded">
                            <i class="fa-solid fa-location-dot"></i> Espaço de Eventos
                        </span>
                    </div>
                </div>

                {{-- Show de Prêmios --}}
                <div class="bg-white rounded-2xl p-6 border border-slate-200 shadow-sm hover:shadow-md transition-shadow relative overflow-hidden group">
                    <div class="absolute top-0 left-0 w-1.5 h-full bg-pink-500"></div>
                    <div class="pl-3">
                        <span class="text-xs font-bold text-pink-600 uppercase tracking-wider mb-1 block">Set/Out</span>
                        <h3 class="text-lg font-extrabold text-slate-800 mb-2 font-heading">Show de Prêmios</h3>
                        <p class="text-sm text-slate-600 mb-4">Evento beneficente com sorteios e prêmios para a comunidade.</p>
                        <span class="inline-flex items-center gap-1.5 px-2.5 py-1 bg-slate-100 text-slate-600 text-[10px] font-bold rounded">
                            <i class="fa-solid fa-location-dot"></i> Salão Paroquial
                        </span>
                    </div>
                </div>

            </div>
            <div class="w-full flex justify-center items-center mt-12">
                <a href="{{ route('agenda.index') }}"
                    class="inline-flex items-center gap-2 px-8 py-4 rounded-2xl bg-[#006eb7] hover:bg-blue-800 text-white font-extrabold text-lg shadow-lg transition-all duration-200 focus:outline-none focus:ring-4 focus:ring-blue-300 text-center">
                    <i class="fa-solid fa-calendar-days text-xl"></i>
                    Ver Agenda Completa
                </a>
            </div>
        </div>
    </section>

@endsection