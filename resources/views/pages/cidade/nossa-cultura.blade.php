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
    <section class="relative pt-[calc(var(--site-header-height,72px)+1.5rem)] pb-16 sm:pt-[calc(var(--site-header-height,72px)+2.5rem)] md:pt-[calc(var(--site-header-height,72px)+3.5rem)] md:pb-24 lg:pt-24 lg:pb-24 overflow-hidden bg-[#006eb7] w-full max-w-full">
        {{-- Background Elements --}}
        <div class="absolute inset-0 pointer-events-none" aria-hidden="true">
            <svg class="absolute w-full h-full opacity-10" xmlns="http://www.w3.org/2000/svg">
                <defs>
                    <pattern id="culture-grid" width="60" height="60" patternUnits="userSpaceOnUse">
                        <path d="M 60 0 L 0 0 0 60" fill="none" stroke="white" stroke-width="1" />
                    </pattern>
                </defs>
                <rect width="100%" height="100%" fill="url(#culture-grid)" />
            </svg>
            <div class="absolute bottom-0 left-0 right-0 h-64 bg-gradient-to-t from-slate-950/80 to-transparent"></div>
        </div>

        <div class="container relative z-10 px-4 sm:px-6 md:px-8 mx-auto text-left max-w-6xl w-full">
            <div class="max-w-4xl">
                <x-breadcrumb :items="[
                    ['name' => 'Início', 'url' => route('home')],
                    ['name' => 'Cidade', 'url' => null],
                    ['name' => 'Nossa Cultura', 'url' => null]
                ]" dark />

                <div class="mt-8 md:mt-10">
                    <span class="inline-flex items-center gap-2 px-4 py-1.5 mb-6 text-xs font-bold tracking-widest text-blue-900 uppercase bg-yellow-400 rounded-full shadow-sm">
                        Identidade & Diversidade
                    </span>
                    
                    <h1 class="text-4xl sm:text-5xl md:text-7xl font-extrabold font-heading mb-6 text-white drop-shadow-md leading-tight" style="font-family: 'Montserrat', sans-serif;">
                        Nossa <span class="text-yellow-400 relative">Cultura</span>
                    </h1>
                    
                    <p class="text-lg sm:text-xl md:text-2xl text-blue-50 leading-relaxed font-light opacity-90">
                        O inventário do patrimônio material e imaterial de Assaí, resultante da convergência entre a imigração oriental, a força nordestina e a tradição paranaense.
                    </p>
                </div>
            </div>
        </div>
    </section>

    {{-- ===== AS RAÍZES (A TRÍADE FORMADORA) ===== --}}
    <section class="py-20 md:py-32 bg-white relative overflow-hidden">
        <div class="container px-4 mx-auto max-w-6xl relative z-10">
            <div class="grid grid-cols-1 lg:grid-cols-12 gap-12 items-end mb-20">
                <div class="lg:col-span-7">
                    <div class="inline-flex items-center gap-2 mb-4">
                        <span class="w-8 h-1 bg-[#006eb7] rounded-full"></span>
                        <span class="text-[#006eb7] font-bold tracking-widest uppercase text-xs">As Raízes</span>
                    </div>
                    <h2 class="text-4xl md:text-5xl font-black text-slate-900 leading-tight font-heading" style="font-family: 'Montserrat', sans-serif;">
                        O Encontro de <br><span class="text-blue-700">Três Mundos</span>
                    </h2>
                </div>
                <div class="lg:col-span-5">
                    <p class="text-slate-600 text-lg leading-relaxed">
                        Nossa identidade não é apenas uma mistura, é uma convergência. Três pilares fundamentais sustentam o que significa ser assaiense hoje.
                    </p>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                {{-- Card 1: Japonês --}}
                <div class="group relative bg-slate-50 rounded-[2.5rem] p-10 transition-all duration-500 hover:bg-[#006eb7] hover:-translate-y-2 border border-slate-100 overflow-hidden">
                    <div class="absolute -right-8 -top-8 w-32 h-32 bg-blue-100/50 rounded-full blur-3xl group-hover:bg-white/10 transition-colors"></div>
                    
                    <div class="relative z-10">
                        <div class="w-16 h-16 bg-white rounded-2xl flex items-center justify-center text-3xl mb-8 shadow-sm group-hover:bg-white/20 group-hover:text-white transition-all text-[#006eb7]">
                            <i class="fa-solid fa-torii-gate"></i>
                        </div>
                        <h3 class="text-2xl font-black text-slate-900 mb-4 font-heading group-hover:text-white transition-colors">Herança Nipônica</h3>
                        <p class="text-slate-600 leading-relaxed mb-8 group-hover:text-blue-50 transition-colors">
                            Assaí detém a maior densidade de descendentes japoneses do país. A disciplina, o respeito e a arte (Taiko, Matsuris) são a alma da nossa cidade.
                        </p>
                        
                        <div class="space-y-4">
                            <div class="flex items-center gap-3 text-sm font-bold group-hover:text-white text-slate-700 transition-colors">
                                <span class="w-2 h-2 rounded-full bg-red-500"></span>
                                Templo Budista Shoshinji
                            </div>
                            <div class="flex items-center gap-3 text-sm font-bold group-hover:text-white text-slate-700 transition-colors">
                                <span class="w-2 h-2 rounded-full bg-red-500"></span>
                                Arte do Taiko (Assahi)
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Card 2: Nordestino --}}
                <div class="group relative bg-slate-50 rounded-[2.5rem] p-10 transition-all duration-500 hover:bg-amber-500 hover:-translate-y-2 border border-slate-100 overflow-hidden">
                    <div class="absolute -right-8 -top-8 w-32 h-32 bg-amber-100/50 rounded-full blur-3xl group-hover:bg-white/10 transition-colors"></div>

                    <div class="relative z-10">
                        <div class="w-16 h-16 bg-white rounded-2xl flex items-center justify-center text-3xl mb-8 shadow-sm group-hover:bg-white/20 group-hover:text-white transition-all text-amber-600">
                            <i class="fa-solid fa-sun-plant-wilt"></i>
                        </div>
                        <h3 class="text-2xl font-black text-slate-900 mb-4 font-heading group-hover:text-white transition-colors">Força Nordestina</h3>
                        <p class="text-slate-600 leading-relaxed mb-8 group-hover:text-amber-50 transition-colors">
                            O motor da nossa história. Milhares de famílias trouxeram o calor do sertão para o sul, fundindo alegria, culinária e fé ao nosso DNA.
                        </p>
                        
                        <div class="space-y-4">
                            <div class="flex items-center gap-3 text-sm font-bold group-hover:text-white text-slate-700 transition-colors">
                                <span class="w-2 h-2 rounded-full bg-amber-600 group-hover:bg-white"></span>
                                Festa Nordestina Anual
                            </div>
                            <div class="flex items-center gap-3 text-sm font-bold group-hover:text-white text-slate-700 transition-colors">
                                <span class="w-2 h-2 rounded-full bg-amber-600 group-hover:bg-white"></span>
                                Gastronomia Sertaneja
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Card 3: Paranaense --}}
                <div class="group relative bg-slate-50 rounded-[2.5rem] p-10 transition-all duration-500 hover:bg-emerald-600 hover:-translate-y-2 border border-slate-100 overflow-hidden">
                    <div class="absolute -right-8 -top-8 w-32 h-32 bg-emerald-100/50 rounded-full blur-3xl group-hover:bg-white/10 transition-colors"></div>

                    <div class="relative z-10">
                        <div class="w-16 h-16 bg-white rounded-2xl flex items-center justify-center text-3xl mb-8 shadow-sm group-hover:bg-white/20 group-hover:text-white transition-all text-emerald-600">
                            <i class="fa-solid fa-tractor"></i>
                        </div>
                        <h3 class="text-2xl font-black text-slate-900 mb-4 font-heading group-hover:text-white transition-colors">Raiz Paranaense</h3>
                        <p class="text-slate-600 leading-relaxed mb-8 group-hover:text-emerald-50 transition-colors">
                            A base de terra roxa e a cultura tropeira. A lida no campo e a agricultura familiar são o alicerce que sustenta nossa economia e costumes.
                        </p>
                        
                        <div class="space-y-4">
                            <div class="flex items-center gap-3 text-sm font-bold group-hover:text-white text-slate-700 transition-colors">
                                <span class="w-2 h-2 rounded-full bg-emerald-600 group-hover:bg-white"></span>
                                Tradição Rural e Feiras
                            </div>
                            <div class="flex items-center gap-3 text-sm font-bold group-hover:text-white text-slate-700 transition-colors">
                                <span class="w-2 h-2 rounded-full bg-emerald-600 group-hover:bg-white"></span>
                                Cavalgadas & Romarias
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- ===== PATRIMÔNIO VIVO (ARQUITETURA) ===== --}}
    <section class="py-20 md:py-32 bg-slate-50 relative">
        <div class="container px-4 mx-auto max-w-6xl relative z-10">
            <div class="text-center mb-16">
                <h2 class="text-4xl font-black text-slate-900 md:text-5xl font-heading mb-6" style="font-family: 'Montserrat', sans-serif;">Patrimônio Vivo</h2>
                <p class="text-slate-600 max-w-2xl mx-auto text-lg leading-relaxed">Monumentos que guardam a história e a alma do nosso povo, do sagrado ao histórico.</p>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 lg:gap-12">
                {{-- O Castelo --}}
                <div class="group bg-white rounded-[3rem] overflow-hidden shadow-sm hover:shadow-2xl transition-all duration-700 border border-slate-100 flex flex-col">
                    <div class="relative h-80 overflow-hidden">
                        <img src="{{ asset('img/assai_1.jpg') }}" alt="Castelo de Assaí" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-1000">
                        <div class="absolute inset-0 bg-gradient-to-t from-slate-900/60 to-transparent"></div>
                        <div class="absolute bottom-6 left-8">
                            <span class="px-3 py-1 bg-yellow-400 text-slate-900 text-[10px] font-black uppercase tracking-widest rounded-lg mb-2 block w-fit">Patrimônio Histórico</span>
                            <h3 class="text-3xl font-black text-white font-heading">Memorial da Imigração</h3>
                        </div>
                    </div>
                    <div class="p-8 md:p-10 flex-1 space-y-6">
                        <p class="text-slate-600 leading-relaxed italic">
                            Inspirado no Castelo de Himeji, este monumento de 25 metros é o guardião das memórias da colonização japonesa e do auge econômico da cidade.
                        </p>
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 pt-6 border-t border-slate-50">
                            <div class="flex items-start gap-3">
                                <div class="w-8 h-8 rounded-lg bg-blue-50 flex items-center justify-center shrink-0 text-[#006eb7]"><i class="fa-solid fa-landmark"></i></div>
                                <div class="text-sm"><strong>Museu:</strong> Acervo histórico dos pioneiros.</div>
                            </div>
                            <div class="flex items-start gap-3">
                                <div class="w-8 h-8 rounded-lg bg-blue-50 flex items-center justify-center shrink-0 text-[#006eb7]"><i class="fa-solid fa-eye"></i></div>
                                <div class="text-sm"><strong>Mirante:</strong> Visão 360º de toda a região.</div>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- A Igreja --}}
                <div class="group bg-white rounded-[3rem] overflow-hidden shadow-sm hover:shadow-2xl transition-all duration-700 border border-slate-100 flex flex-col">
                    <div class="relative h-80 overflow-hidden">
                        <img src="{{ asset('img/igreja_matriz.jpg') }}" alt="Igreja Matriz São José" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-1000">
                        <div class="absolute inset-0 bg-gradient-to-t from-slate-900/60 to-transparent"></div>
                        <div class="absolute bottom-6 left-8">
                            <span class="px-3 py-1 bg-[#006eb7] text-white text-[10px] font-black uppercase tracking-widest rounded-lg mb-2 block w-fit">Patrimônio Religioso</span>
                            <h3 class="text-3xl font-black text-white font-heading">Matriz São José</h3>
                        </div>
                    </div>
                    <div class="p-8 md:p-10 flex-1 space-y-6">
                        <p class="text-slate-600 leading-relaxed italic">
                            Símbolo da fé assaiense, a matriz é o coração espiritual da cidade, onde tradição e comunidade se encontram em celebrações históricas.
                        </p>
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 pt-6 border-t border-slate-50">
                            <div class="flex items-start gap-3">
                                <div class="w-8 h-8 rounded-lg bg-blue-50 flex items-center justify-center shrink-0 text-[#006eb7]"><i class="fa-solid fa-place-of-worship"></i></div>
                                <div class="text-sm"><strong>Santuário:</strong> Devotos de N. Sra. Aparecida.</div>
                            </div>
                            <div class="flex items-start gap-3">
                                <div class="w-8 h-8 rounded-lg bg-blue-50 flex items-center justify-center shrink-0 text-[#006eb7]"><i class="fa-solid fa-calendar-star"></i></div>
                                <div class="text-sm"><strong>Festa:</strong> Evento centenário de São José.</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- ===== ESPÍRITO E DISCIPLINA (DESPORTO) ===== --}}
    <section class="py-20 md:py-32 bg-slate-950 relative overflow-hidden">
        <div class="absolute inset-0 z-0">
            <div class="absolute top-0 right-0 w-1/3 h-full bg-[#006eb7]/5 blur-[120px]"></div>
            <div class="absolute bottom-0 left-0 w-1/4 h-full bg-yellow-400/5 blur-[120px]"></div>
        </div>

        <div class="container px-4 mx-auto max-w-6xl relative z-10">
            <div class="flex flex-col lg:flex-row gap-16 items-center">
                <div class="w-full lg:w-5/12 text-white">
                    <div class="inline-flex items-center gap-2 mb-6">
                        <span class="w-8 h-1 bg-yellow-400 rounded-full"></span>
                        <span class="text-yellow-400 font-bold tracking-widest uppercase text-xs">Espírito de Superação</span>
                    </div>
                    <h2 class="text-4xl md:text-6xl font-black font-heading mb-8 leading-tight" style="font-family: 'Montserrat', sans-serif;">
                        A Força da <br><span class="text-transparent bg-clip-text bg-gradient-to-r from-blue-400 to-[#006eb7]">Disciplina</span>
                    </h2>
                    <p class="text-slate-300 leading-relaxed mb-10 text-xl font-light">
                        Através da Associação Cultural (ACA), o desporto em Assaí é um veículo de transmissão de valores. Resiliência, respeito e foco definem nossos atletas.
                    </p>
                    <div class="flex flex-wrap gap-4">
                        <div class="px-6 py-4 bg-white/5 border border-white/10 rounded-2xl backdrop-blur-md">
                            <span class="block text-2xl font-black text-yellow-400">Celeiro</span>
                            <span class="text-[10px] uppercase tracking-wider text-slate-400 font-bold">Nacional de Atletas</span>
                        </div>
                    </div>
                </div>

                <div class="w-full lg:w-7/12">
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                        {{-- Esporte 1 --}}
                        <div class="bg-white/5 backdrop-blur-md border border-white/10 p-8 rounded-3xl hover:bg-white/10 transition-all group">
                            <div class="w-14 h-14 bg-white/10 rounded-2xl flex items-center justify-center mb-6 text-3xl group-hover:scale-110 transition-transform duration-500">
                                <i class="fa-solid fa-baseball text-yellow-400"></i>
                            </div>
                            <h4 class="text-xl font-bold text-white mb-3">Beisebol & Softbol</h4>
                            <p class="text-slate-400 text-sm leading-relaxed">Sede de campeonatos nacionais e eterna reveladora de talentos para seleções internacionais.</p>
                        </div>
                        {{-- Esporte 2 --}}
                        <div class="bg-white/5 backdrop-blur-md border border-white/10 p-8 rounded-3xl hover:bg-white/10 transition-all group">
                            <div class="w-14 h-14 bg-white/10 rounded-2xl flex items-center justify-center mb-6 text-3xl group-hover:scale-110 transition-transform duration-500">
                                <i class="fa-solid fa-user-ninja text-blue-400"></i>
                            </div>
                            <h4 class="text-xl font-bold text-white mb-3">Artes Marciais</h4>
                            <p class="text-slate-400 text-sm leading-relaxed">Judô e Kendô focados no **Bushido** (caminho do guerreiro), forjando o caráter das novas gerações.</p>
                        </div>
                        {{-- Esporte 3 --}}
                        <div class="bg-white/5 backdrop-blur-md border border-white/10 p-8 rounded-3xl hover:bg-white/10 transition-all group">
                            <div class="w-14 h-14 bg-white/10 rounded-2xl flex items-center justify-center mb-6 text-3xl group-hover:scale-110 transition-transform duration-500">
                                <i class="fa-solid fa-drum text-red-400"></i>
                            </div>
                            <h4 class="text-xl font-bold text-white mb-3">Taiko (Tambores)</h4>
                            <p class="text-slate-400 text-sm leading-relaxed">A força do som ancestral japonês que marca o ritmo das grandes celebrações de Assaí.</p>
                        </div>
                        {{-- Esporte 4 --}}
                        <div class="bg-white/5 backdrop-blur-md border border-white/10 p-8 rounded-3xl hover:bg-white/10 transition-all group">
                            <div class="w-14 h-14 bg-white/10 rounded-2xl flex items-center justify-center mb-6 text-3xl group-hover:scale-110 transition-transform duration-500">
                                <i class="fa-solid fa-table-tennis-paddle-ball text-emerald-400"></i>
                            </div>
                            <h4 class="text-xl font-bold text-white mb-3">Tênis de Mesa</h4>
                            <p class="text-slate-400 text-sm leading-relaxed">Tradição e precisão técnica em um dos centros de treinamento mais respeitados do estado.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- ===== GASTRONOMIA (SABORES) ===== --}}
    <section class="py-20 md:py-32 bg-white relative overflow-hidden">
        <div class="container px-4 mx-auto max-w-6xl relative z-10">
            <div class="grid grid-cols-1 lg:grid-cols-12 gap-12 items-center mb-16">
                <div class="lg:col-span-8">
                    <div class="inline-flex items-center gap-2 mb-4">
                        <span class="w-8 h-1 bg-orange-500 rounded-full"></span>
                        <span class="text-orange-600 font-bold tracking-widest uppercase text-xs">Gastronomia</span>
                    </div>
                    <h2 class="text-4xl md:text-5xl font-black text-slate-900 leading-tight font-heading" style="font-family: 'Montserrat', sans-serif;">
                        Um Banquete de <br><span class="text-orange-600">Sabores Autênticos</span>
                    </h2>
                </div>
                <div class="lg:col-span-4">
                    <p class="text-slate-600 text-lg leading-relaxed">
                        Do Udon caseiro ao Pastel de Feira. A mesa assaiense é onde todas as nossas influências se encontram e se celebram.
                    </p>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                {{-- Gastronomia 1 --}}
                <div class="group bg-orange-50 rounded-[2.5rem] p-10 hover:bg-orange-100 transition-all duration-500 border border-orange-100 flex flex-col items-center text-center">
                    <div class="w-20 h-20 bg-white rounded-full flex items-center justify-center text-3xl mb-8 shadow-sm text-orange-600 group-hover:scale-110 transition-transform">
                        <i class="fa-solid fa-bowl-rice"></i>
                    </div>
                    <h4 class="text-xl font-bold text-slate-900 mb-4">Cozinha Oriental</h4>
                    <p class="text-slate-600 text-sm leading-relaxed">Referência em Udon caseiro, Yakisoba autêntico e o cultivo tradicional do arroz Motigomê para ritos especiais.</p>
                </div>
                {{-- Gastronomia 2 --}}
                <div class="group bg-amber-50 rounded-[2.5rem] p-10 hover:bg-amber-100 transition-all duration-500 border border-amber-100 flex flex-col items-center text-center">
                    <div class="w-20 h-20 bg-white rounded-full flex items-center justify-center text-3xl mb-8 shadow-sm text-amber-700 group-hover:scale-110 transition-transform">
                        <i class="fa-solid fa-mug-hot"></i>
                    </div>
                    <h4 class="text-xl font-bold text-slate-900 mb-4">Ouro Negro (Café)</h4>
                    <p class="text-slate-600 text-sm leading-relaxed">Turismo imersivo em propriedades históricas, com resgate da arquitetura das antigas tulhas e terreiros de café.</p>
                </div>
                {{-- Gastronomia 3 --}}
                <div class="group bg-emerald-50 rounded-[2.5rem] p-10 hover:bg-emerald-100 transition-all duration-500 border border-emerald-100 flex flex-col items-center text-center">
                    <div class="w-20 h-20 bg-white rounded-full flex items-center justify-center text-3xl mb-8 shadow-sm text-emerald-600 group-hover:scale-110 transition-transform">
                        <i class="fa-solid fa-store"></i>
                    </div>
                    <h4 class="text-xl font-bold text-slate-900 mb-4">Feiras de Rua</h4>
                    <p class="text-slate-600 text-sm leading-relaxed">A fusão completa: do Pastel de Feira ao Acarajé, passando pelos raros derivados da Raiz de Lótus (Renkon).</p>
                </div>
            </div>
        </div>
    </section>

    {{-- ===== CALENDÁRIO (AGENDA CULTURAL) ===== --}}
    <section class="py-20 md:py-32 bg-slate-50 relative">
        <div class="container px-4 mx-auto max-w-6xl relative z-10">
            <div class="flex flex-col md:flex-row justify-between items-end gap-8 mb-16">
                <div>
                    <div class="inline-flex items-center gap-2 mb-4">
                        <span class="w-8 h-1 bg-[#006eb7] rounded-full"></span>
                        <span class="text-[#006eb7] font-bold tracking-widest uppercase text-xs">Agenda Viva</span>
                    </div>
                    <h2 class="text-4xl md:text-5xl font-black text-slate-900 leading-tight font-heading" style="font-family: 'Montserrat', sans-serif;">
                        Calendário de <br>Festividades
                    </h2>
                </div>
                <a href="{{ route('agenda.index') }}" class="group flex items-center gap-3 px-6 py-3 bg-white border border-slate-200 rounded-2xl text-[#006eb7] font-bold hover:bg-[#006eb7] hover:text-white transition-all shadow-sm">
                    Ver Agenda Completa
                    <i class="fa-solid fa-arrow-right group-hover:translate-x-1 transition-transform"></i>
                </a>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                {{-- Evento 1 --}}
                <div class="bg-white p-8 rounded-[2rem] border border-slate-100 shadow-sm hover:shadow-xl transition-all group">
                    <div class="flex justify-between items-start mb-6">
                        <span class="px-3 py-1 bg-purple-100 text-purple-700 text-[10px] font-black uppercase tracking-widest rounded-lg">Março</span>
                        <div class="w-10 h-10 bg-slate-50 rounded-xl flex items-center justify-center text-slate-400 group-hover:bg-purple-50 group-hover:text-purple-600 transition-colors">
                            <i class="fa-solid fa-calendar-day"></i>
                        </div>
                    </div>
                    <h3 class="text-xl font-bold text-slate-900 mb-3 font-heading">Festival Japonês</h3>
                    <p class="text-slate-500 text-sm leading-relaxed mb-6">Celebração milenar com danças tradicionais, exposições de artes e o melhor da gastronomia nipônica.</p>
                    <div class="flex items-center gap-2 text-xs font-bold text-slate-400">
                        <i class="fa-solid fa-location-dot"></i>
                        Espaço de Eventos
                    </div>
                </div>

                {{-- Evento 2 --}}
                <div class="bg-white p-8 rounded-[2rem] border border-slate-100 shadow-sm hover:shadow-xl transition-all group">
                    <div class="flex justify-between items-start mb-6">
                        <span class="px-3 py-1 bg-blue-100 text-blue-700 text-[10px] font-black uppercase tracking-widest rounded-lg">Maio</span>
                        <div class="w-10 h-10 bg-slate-50 rounded-xl flex items-center justify-center text-slate-400 group-hover:bg-blue-50 group-hover:text-blue-600 transition-colors">
                            <i class="fa-solid fa-birthday-cake"></i>
                        </div>
                    </div>
                    <h3 class="text-xl font-bold text-slate-900 mb-3 font-heading">Aniversário da Cidade</h3>
                    <p class="text-slate-500 text-sm leading-relaxed mb-6">Desfile cívico monumental, shows nacionais e uma agenda repleta de cultura para toda a família.</p>
                    <div class="flex items-center gap-2 text-xs font-bold text-slate-400">
                        <i class="fa-solid fa-location-dot"></i>
                        Centro de Eventos
                    </div>
                </div>

                {{-- Evento 3 --}}
                <div class="bg-white p-8 rounded-[2rem] border border-slate-100 shadow-sm hover:shadow-xl transition-all group">
                    <div class="flex justify-between items-start mb-6">
                        <span class="px-3 py-1 bg-emerald-100 text-emerald-700 text-[10px] font-black uppercase tracking-widest rounded-lg">Junho</span>
                        <div class="w-10 h-10 bg-slate-50 rounded-xl flex items-center justify-center text-slate-400 group-hover:bg-emerald-50 group-hover:text-emerald-600 transition-colors">
                            <i class="fa-solid fa-wheat-awn"></i>
                        </div>
                    </div>
                    <h3 class="text-xl font-bold text-slate-900 mb-3 font-heading">Exposição Agropecuária</h3>
                    <p class="text-slate-500 text-sm leading-relaxed mb-6">A maior feira de negócios da região, unindo tecnologia no campo, rodeios e grandes atrações musicais.</p>
                    <div class="flex items-center gap-2 text-xs font-bold text-slate-400">
                        <i class="fa-solid fa-location-dot"></i>
                        Parque de Exposições
                    </div>
                </div>

                {{-- Evento 4 --}}
                <div class="bg-white p-8 rounded-[2rem] border border-slate-100 shadow-sm hover:shadow-xl transition-all group">
                    <div class="flex justify-between items-start mb-6">
                        <span class="px-3 py-1 bg-amber-100 text-amber-700 text-[10px] font-black uppercase tracking-widest rounded-lg">Agosto</span>
                        <div class="w-10 h-10 bg-slate-50 rounded-xl flex items-center justify-center text-slate-400 group-hover:bg-amber-50 group-hover:text-amber-600 transition-colors">
                            <i class="fa-solid fa-star"></i>
                        </div>
                    </div>
                    <h3 class="text-xl font-bold text-slate-900 mb-3 font-heading">Tanabata Matsuri</h3>
                    <p class="text-slate-500 text-sm leading-relaxed mb-6">O Festival das Estrelas original de Assaí. Decoração temática deslumbrante e ritos de gratidão.</p>
                    <div class="flex items-center gap-2 text-xs font-bold text-slate-400">
                        <i class="fa-solid fa-location-dot"></i>
                        Praça de Tóquio
                    </div>
                </div>

                {{-- Evento 5 --}}
                <div class="bg-white p-8 rounded-[2rem] border border-slate-100 shadow-sm hover:shadow-xl transition-all group">
                    <div class="flex justify-between items-start mb-6">
                        <span class="px-3 py-1 bg-red-100 text-red-700 text-[10px] font-black uppercase tracking-widest rounded-lg">Outubro</span>
                        <div class="w-10 h-10 bg-slate-50 rounded-xl flex items-center justify-center text-slate-400 group-hover:bg-red-50 group-hover:text-red-600 transition-colors">
                            <i class="fa-solid fa-pepper-hot"></i>
                        </div>
                    </div>
                    <h3 class="text-xl font-bold text-slate-900 mb-3 font-heading">Festa Nordestina</h3>
                    <p class="text-slate-600 text-sm leading-relaxed mb-6">O calor do sertão no norte do Paraná. Gastronomia típica, forró e a alegria contagiante do nosso povo.</p>
                    <div class="flex items-center gap-2 text-xs font-bold text-slate-400">
                        <i class="fa-solid fa-location-dot"></i>
                        Espaço de Eventos
                    </div>
                </div>

                {{-- CTA --}}
                <div class="bg-gradient-to-br from-[#006eb7] to-blue-800 p-8 rounded-[2rem] shadow-lg flex flex-col justify-center items-center text-center group overflow-hidden relative">
                    <div class="absolute inset-0 bg-[url('https://www.transparenttextures.com/patterns/stardust.png')] opacity-10"></div>
                    <div class="relative z-10">
                        <h3 class="text-2xl font-black text-white mb-4 font-heading">Quer saber mais?</h3>
                        <p class="text-blue-100 text-sm mb-8">Acompanhe todos os eventos, datas e locais em nossa agenda oficial sempre atualizada.</p>
                        <a href="{{ route('agenda.index') }}" class="inline-flex items-center gap-2 px-6 py-3 bg-yellow-400 text-slate-900 font-bold rounded-xl hover:scale-105 transition-transform">
                            Acessar Agenda
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </section>

@endsection