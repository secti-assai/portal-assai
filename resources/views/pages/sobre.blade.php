@extends('layouts.app')

@section('title', 'Nossa História e Perfil - Prefeitura Municipal de Assaí')

@section('content')

{{-- ===== HERO ===== --}}
<section class="relative pt-8 pb-20 overflow-hidden bg-blue-900 md:pt-12 md:pb-28 lg:pt-20 lg:pb-40">
    <div class="absolute inset-0">
        <svg class="absolute w-full h-full opacity-5" xmlns="http://www.w3.org/2000/svg">
            <defs>
                <pattern id="grid" width="60" height="60" patternUnits="userSpaceOnUse">
                    <path d="M 60 0 L 0 0 0 60" fill="none" stroke="white" stroke-width="1" />
                </pattern>
            </defs>
            <rect width="100%" height="100%" fill="url(#grid)" />
        </svg>
        <div class="absolute bottom-0 left-0 right-0 h-64 bg-gradient-to-t from-blue-950 to-transparent"></div>
    </div>

    <div class="container relative z-10 px-4 mx-auto text-center max-w-5xl">
        <x-breadcrumb :items="[
            ['name' => 'Início', 'url' => route('home')],
            ['name' => 'A Cidade'],
        ]" dark />
        <span class="inline-flex items-center gap-2 px-5 py-2 mb-8 text-xs font-bold tracking-widest text-blue-900 uppercase bg-yellow-400 rounded-full shadow-md">
            <svg class="w-3.5 h-3.5" fill="currentColor" viewBox="0 0 20 20">
                <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path>
            </svg>
            Conheça a Nossa História
        </span>
        <h1 class="text-4xl font-extrabold text-white md:text-6xl lg:text-7xl font-heading tracking-tight mb-6 leading-none">
            Assaí <span class="text-yellow-400">— PR</span>
        </h1>
        <p class="max-w-3xl mx-auto text-lg text-blue-100 md:text-xl lg:text-2xl leading-relaxed font-light">
            Do "Sol Nascente" (朝日) plantado pelos pioneiros japoneses em 1932 ao reconhecimento como uma das <strong class="text-white font-bold">Top 7 Comunidades mais Inteligentes do Mundo</strong>.
        </p>
        <div class="flex flex-col sm:flex-row flex-wrap items-center justify-center gap-3 sm:gap-4 mt-10 w-full">
            <a href="{{ route('pages.turismo') }}" class="inline-flex items-center justify-center gap-2 w-full sm:w-auto px-6 py-3 font-bold text-blue-900 transition bg-yellow-400 rounded-full hover:bg-yellow-300 hover:-translate-y-0.5 shadow-lg text-sm md:text-base">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                </svg>
                Turismo & Pontos Turísticos
            </a>
            <a href="#historia" class="inline-flex items-center justify-center gap-2 w-full sm:w-auto px-6 py-3 font-bold text-white transition border-2 border-white/40 rounded-full hover:border-white hover:bg-white/10 text-sm md:text-base">
                Explorar a História
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                </svg>
            </a>
        </div>
    </div>
</section>

{{-- ===== CARDS DE DADOS ===== --}}
<section class="relative z-20 -mt-24">
    <div class="container px-4 mx-auto max-w-6xl">
        <div class="grid grid-cols-2 gap-3 md:grid-cols-5 md:gap-5">
            {{-- Card Individual --}}
            <div class="flex flex-col overflow-hidden bg-white border rounded-2xl border-slate-300 shadow-[0_12px_32px_rgba(15,23,42,0.12)] col-span-1 group hover:border-blue-400 transition-colors">
                <div class="h-1.5 bg-slate-200 group-hover:bg-blue-500 transition-colors"></div>
                <div class="flex flex-col items-center justify-center p-5 text-center">
                    <span class="text-2xl md:text-3xl font-black text-blue-700 font-heading mb-1 transition-transform group-hover:scale-110 duration-300">1932</span>
                    <span class="text-xs font-bold text-slate-800 uppercase tracking-wider">Fundação</span>
                </div>
            </div>

            <div class="flex flex-col overflow-hidden bg-white border rounded-2xl border-slate-300 shadow-[0_12px_32px_rgba(15,23,42,0.12)] col-span-1 group hover:border-blue-400 transition-colors">
                <div class="h-1.5 bg-slate-200 group-hover:bg-blue-500 transition-colors"></div>
                <div class="flex flex-col items-center justify-center p-5 text-center">
                    <span class="text-2xl md:text-3xl font-black text-blue-700 font-heading mb-1 transition-transform group-hover:scale-110 duration-300">13.797</span>
                    <span class="text-xs font-bold text-slate-800 uppercase tracking-wider">Habitantes (2022)</span>
                </div>
            </div>

            <div class="flex flex-col overflow-hidden bg-white border rounded-2xl border-slate-300 shadow-[0_12px_32px_rgba(15,23,42,0.12)] col-span-1 group hover:border-blue-400 transition-colors">
                <div class="h-1.5 bg-slate-200 group-hover:bg-blue-500 transition-colors"></div>
                <div class="flex flex-col items-center justify-center p-5 text-center">
                    <span class="text-2xl md:text-3xl font-black text-blue-700 font-heading mb-1 transition-transform group-hover:scale-110 duration-300">440 km²</span>
                    <span class="text-xs font-bold text-slate-800 uppercase tracking-wider">Área Territorial</span>
                </div>
            </div>

            <div class="flex flex-col overflow-hidden bg-white border rounded-2xl border-slate-300 shadow-[0_12px_32px_rgba(15,23,42,0.12)] col-span-1 group hover:border-blue-400 transition-colors">
                <div class="h-1.5 bg-slate-200 group-hover:bg-blue-500 transition-colors"></div>
                <div class="flex flex-col items-center justify-center p-5 text-center">
                    <span class="text-2xl md:text-3xl font-black text-blue-700 font-heading mb-1 transition-transform group-hover:scale-110 duration-300">15%</span>
                    <span class="text-xs font-bold text-slate-800 uppercase tracking-wider">Descendência</span>
                </div>
            </div>

            <div class="flex flex-col overflow-hidden bg-yellow-400 border rounded-2xl border-yellow-500 shadow-[0_12px_32px_rgba(234,179,8,0.2)] col-span-2 md:col-span-1 group hover:bg-yellow-300 transition-colors">
                <div class="h-1.5 bg-blue-900/10"></div>
                <div class="flex flex-col items-center justify-center p-5 text-center">
                    <span class="text-2xl md:text-3xl font-black text-blue-900 font-heading mb-1">Top 7</span>
                    <span class="text-xs font-bold text-blue-900 uppercase tracking-wider">Smart Communities</span>
                </div>
            </div>
        </div>
    </div>
</section>

{{-- ===== FUNDAÇÃO ===== --}}
<section id="historia" class="py-16 bg-white md:py-24 lg:py-32">
    <div class="container px-4 mx-auto max-w-6xl">
        <div class="grid items-center grid-cols-1 gap-16 md:grid-cols-2">
            <div class="relative group">
                <div class="overflow-hidden shadow-2xl rounded-3xl bg-slate-200 relative aspect-square">
                    <img src="{{ asset('img/Assai.jpg') }}" alt="Fundação de Assaí — pioneiros japoneses em 1932" class="object-cover w-full h-full transition duration-700 group-hover:scale-105" loading="lazy" decoding="async">
                    <div class="absolute inset-0 ring-1 ring-inset ring-black/10 rounded-3xl"></div>
                </div>
                <div class="absolute -bottom-5 -right-5 p-5 shadow-2xl bg-blue-900 text-white rounded-2xl md:-bottom-8 md:-right-8 md:p-7">
                    <p class="mb-1 text-xs font-bold tracking-widest uppercase text-yellow-400">Aniversário</p>
                    <p class="text-3xl font-extrabold font-heading leading-none text-white">1º de Maio</p>
                    <p class="text-blue-100 text-sm mt-0.5">desde 1932</p>
                </div>
            </div>

            <div class="space-y-5 text-[15px] md:text-base leading-7 md:leading-relaxed text-slate-800 md:pl-6">
                <span class="inline-block text-white font-bold tracking-wider uppercase text-xs border border-blue-700 bg-blue-700 px-3 py-1 rounded-full">Raízes Históricas</span>
                <h2 class="text-3xl font-extrabold text-slate-800 font-heading md:text-4xl leading-tight">
                    O Nascimento de <span class="text-blue-700">Assailand</span>
                </h2>
                <p>Em 1927, o cônsul japonês em São Paulo, Noriyuki Akamatsu, incentivou a emigração para o Paraná após agrônomos confirmarem a fertilidade excepcional das terras da região de Três Barras. Uma gleba de <strong>12 mil alqueires</strong> foi adquirida em 14 de novembro de 1928 pela Companhia Colonizadora Bratac.</p>
                <p>No dia <strong>1º de maio de 1932</strong>, um grupo liderado por <strong>Miyuki Saito</strong> — acompanhado por Itissuke Nishimura, Utaro Katsuda, Tokujiro Tsutsui e Junzo Nagai — embrenhou-se mata adentro e fundou a nova colônia.</p>
                <p>A sede, já bastante povoada, recebeu o nome de <strong>"Assailand"</strong>: uma fusão de <em>Asahi</em> (朝日 — "Sol Nascente", em japonês) com a palavra inglesa <em>land</em> (terra), em homenagem aos colonizadores japoneses que ali se estabeleceram.</p>
                <div class="flex items-start gap-4 p-5 bg-blue-700 rounded-xl border border-blue-600 shadow-sm mt-4">
                    <span class="flex items-center justify-center w-8 h-8 rounded-lg bg-white/20 text-white shrink-0 mt-0.5">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </span>
                    <p class="text-sm text-white leading-relaxed"><strong>Curiosidade:</strong> Assaí é a cidade com a <strong>maior proporção de descendentes japoneses do Brasil</strong>, cerca de 15% da população com origem nipônica, segundo o Censo 2022 do IBGE.</p>
                </div>
            </div>
        </div>
    </div>
</section>

{{-- ===== LINHA DO TEMPO ===== --}}
<section class="py-16 bg-[#eaf3ff] md:py-24 lg:py-28 border-y border-blue-100/70">
    <div class="container px-4 mx-auto max-w-5xl">
        <div class="text-center mb-14">
            <span class="inline-block text-white font-bold tracking-wider uppercase text-xs border border-blue-700 bg-blue-700 px-3 py-1 rounded-full mb-4">Linha do Tempo</span>
            <h2 class="text-3xl font-extrabold text-slate-800 font-heading md:text-4xl">Marcos da Nossa História</h2>
        </div>

        <div class="relative">
            {{-- linha vertical --}}
            <div class="absolute left-5 top-0 bottom-0 w-0.5 bg-slate-200 md:left-1/2 md:-translate-x-1/2"></div>

            <div class="space-y-8">
                {{-- Item --}}
                @php
                $eventos = [
                        ['ano' => '1927', 'cor' => 'blue', 'titulo' => 'Cooperativa de Emigração', 'desc' => 'O cônsul japonês Noriyuki Akamatsu funda a Cooperativa de Imigração, presidida por Mitusada Umetani, após agrônomos confirmarem a fertilidade excepcional das terras do Norte do Paraná.'],
                ['ano' => '1928', 'cor' => 'blue', 'titulo' => 'Compra das Terras', 'desc' => 'Em 14 de novembro, a Companhia Colonizadora Bratac firma contrato de compra de uma gleba de 12 mil alqueires na localidade então conhecida como Três Barras.'],
                ['ano' => '1932', 'cor' => 'yellow', 'titulo' => 'Fundação — 1º de Maio', 'desc' => 'Miyuki Saito e seu grupo fundam o núcleo que ficaria conhecido como Assailand. As primeiras famílias japonesas chegam e iniciam o desbravamento da mata virgem.'],
                ['ano' => '1934', 'cor' => 'green', 'titulo' => 'A "Era do Ouro Branco"', 'desc' => 'Heiju Akagui colhe 360 arrobas de algodão por alqueire. O resultado impressionante dispara a venda de lotes: de 213 para 2.140 alqueires vendidos em um único ano.'],
                ['ano' => '1944', 'cor' => 'blue', 'titulo' => 'Instalação do Município', 'desc' => 'Em 28 de janeiro, Assaí é solenemente instalada como município, presidida pelo Major José Scheleder. O Decreto Lei nº 199 de 30/12/1943 havia criado o município desmembrado de São Jerônimo da Serra.'],
                ['ano' => '1978', 'cor' => 'pink', 'titulo' => '1º Tanabata Matsuri do Brasil', 'desc' => 'Assaí realiza o primeiro festival de Tanabata do Brasil, consolidando sua identidade como capital da cultura nipônica no país.'],
                        ['ano' => 'Hoje', 'cor' => 'blue', 'titulo' => 'Top 7 Comunidades Inteligentes', 'desc' => 'Impulsionada pelo ecossistema Vale do Sol, Assaí é eleita pelo Intelligent Community Forum (ICF) como uma das 7 comunidades mais inteligentes do planeta, unindo tradição e inovação tecnológica.'],
                ];
                @endphp

                @foreach($eventos as $index => $evento)
                @php $direita = $index % 2 === 0; @endphp
                <div class="relative flex items-start gap-6 pl-14 md:pl-0 {{ $direita ? 'md:flex-row' : 'md:flex-row-reverse' }}">
                    {{-- ponto central --}}
                        <div class="absolute left-5 top-1.5 md:left-1/2 md:-translate-x-1/2 w-4 h-4 rounded-full border-2 border-white shadow-md
                            {{ $evento['ano'] === 'Hoje' ? 'animate-pulse ring-4 ring-emerald-300/50' : '' }}
                            {{ $evento['cor'] === 'yellow' ? 'bg-yellow-400' :
                               ($evento['cor'] === 'green' ? 'bg-green-500' :
                               ($evento['cor'] === 'pink' ? 'bg-pink-500' :
                               ($evento['cor'] === 'emerald' ? 'bg-emerald-500' :
                               ($evento['cor'] === 'indigo' ? 'bg-indigo-500' : 'bg-blue-500'))))}}">
                    </div>
                    {{-- conteúdo --}}
                    <div class="md:w-5/12 {{ $direita ? 'md:pr-10' : 'md:pl-10' }}">
                        <div class="relative p-6 md:p-8 bg-white border border-slate-200 shadow-sm rounded-2xl hover:shadow-md hover:-translate-y-1 transition-all duration-300 group overflow-hidden text-left">
                            {{-- Filete de cor superior --}}
                            <div class="absolute top-0 left-0 w-full h-1.5 
                                {{ $evento['cor'] === 'yellow' ? 'bg-yellow-400' :
                                   ($evento['cor'] === 'green' ? 'bg-green-500' :
                                   ($evento['cor'] === 'pink' ? 'bg-pink-500' :
                                   ($evento['cor'] === 'emerald' ? 'bg-emerald-500' :
                                   ($evento['cor'] === 'indigo' ? 'bg-indigo-500' : 'bg-blue-500')))) }}">
                            </div>

                            <span class="inline-block text-xs font-black tracking-widest uppercase mb-3 px-3 py-1 rounded-full bg-slate-50 border border-slate-100
                                {{ $evento['cor'] === 'yellow' ? 'text-yellow-600' :
                                   ($evento['cor'] === 'green' ? 'text-green-600' :
                                   ($evento['cor'] === 'pink' ? 'text-pink-600' :
                                   ($evento['cor'] === 'emerald' ? 'text-emerald-600' :
                                   ($evento['cor'] === 'indigo' ? 'text-indigo-600' : 'text-blue-600')))) }}">
                                {{ $evento['ano'] }}
                            </span>

                            <h3 class="text-xl font-extrabold text-slate-800 font-heading mb-3 transition-colors duration-300
                                {{ $evento['cor'] === 'yellow' ? 'group-hover:text-yellow-600' :
                                   ($evento['cor'] === 'green' ? 'group-hover:text-green-600' :
                                   ($evento['cor'] === 'pink' ? 'group-hover:text-pink-600' :
                                   ($evento['cor'] === 'emerald' ? 'group-hover:text-emerald-600' :
                                   ($evento['cor'] === 'indigo' ? 'group-hover:text-indigo-600' : 'group-hover:text-blue-600')))) }}">
                                {{ $evento['titulo'] }}
                            </h3>

                            <p class="text-sm text-slate-600 leading-relaxed">{{ $evento['desc'] }}</p>
                        </div>
                    </div>
                    <div class="hidden md:block md:w-5/12"></div>
                </div>
                @endforeach
            </div>
        </div>
    </div>
</section>

{{-- ===== ECONOMIA ===== --}}
<section class="py-20 bg-white md:py-28">
    <div class="container px-4 mx-auto max-w-6xl">
        <div class="text-center mb-14">
            <span class="inline-block text-white font-bold tracking-wider uppercase text-xs border border-green-700 bg-green-700 px-3 py-1 rounded-full mb-4">A Força do Campo e da Cidade</span>
            <h2 class="text-3xl font-extrabold text-slate-800 font-heading md:text-4xl">Uma Economia em Constante Evolução</h2>
            <p class="mt-4 max-w-2xl mx-auto text-slate-800 text-base">De colônia agrícola de imigrantes a polo industrial do Norte Pioneiro Paranaense.</p>
        </div>

        <div class="grid grid-cols-1 gap-6 md:grid-cols-3">
            <div class="group p-8 rounded-2xl border border-slate-100 shadow-sm hover:shadow-md transition-all duration-300 hover:-translate-y-1 transition bg-white">
                <div class="flex items-center justify-center w-14 h-14 rounded-xl bg-yellow-100 text-yellow-700 mb-6">
                    <svg class="w-7 h-7 transform group-hover:scale-110 group-hover:rotate-3 transition duration-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M3.055 11H5a2 2 0 012 2v1a2 2 0 002 2 2 2 0 012 2v2.945M8 3.935V5.5A2.5 2.5 0 0010.5 8h.5a2 2 0 012 2 2 2 0 104 0 2 2 0 012-2h1.064M15 20.488V18a2 2 0 012-2h3.064" />
                    </svg>
                </div>
                <h3 class="text-lg font-extrabold text-slate-800 font-heading mb-3">Era do Ouro Branco</h3>
                <p class="text-sm text-slate-700 leading-relaxed">No auge da era do algodão, Assaí chegou a ter mais de <strong>200 mil habitantes</strong> e era conhecida como a <strong>"Rainha do Algodão"</strong> ou "Capital do Ouro Branco" — famosa em todo o território nacional pela abundância e qualidade de sua produção.</p>
            </div>

            <div class="group p-8 rounded-2xl border border-slate-100 shadow-sm hover:shadow-md transition-all duration-300 hover:-translate-y-1 transition bg-white">
                <div class="flex items-center justify-center w-14 h-14 rounded-xl bg-green-100 text-green-700 mb-6">
                    <svg class="w-7 h-7 transform group-hover:scale-110 group-hover:rotate-3 transition duration-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                    </svg>
                </div>
                <h3 class="text-lg font-extrabold text-slate-800 font-heading mb-3">Agropecuária Moderna</h3>
                <p class="text-sm text-slate-700 leading-relaxed">Com a modernização do campo, a cidade reinventou-se. Hoje, o município destaca-se na produção de <strong>soja, trigo e café</strong>, além da famosa <strong>Uva Itália</strong> — que coloca Assaí no mapa como referência em fruticultura de qualidade no Paraná.</p>
            </div>

            <div class="group p-8 rounded-2xl border border-slate-100 shadow-sm hover:shadow-md transition-all duration-300 hover:-translate-y-1 transition bg-white">
                <div class="flex items-center justify-center w-14 h-14 rounded-xl bg-blue-100 text-blue-700 mb-6">
                    <svg class="w-7 h-7 transform group-hover:scale-110 group-hover:rotate-3 transition duration-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                    </svg>
                </div>
                <h3 class="text-lg font-extrabold text-slate-800 font-heading mb-3">Polo Industrial</h3>
                <p class="text-sm text-slate-700 leading-relaxed">A instalação de indústrias na cidade gerou mais de <strong>6.000 empregos diretos</strong>, transformando Assaí em um dos municípios mais dinâmicos do Norte Pioneiro Paranaense. Um novo ciclo de crescimento sustentado pela inovação e pelo investimento.</p>
            </div>
        </div>
    </div>
</section>

{{-- ===== LOCALIZAÇÃO E GEOGRAFIA ===== --}}
<section class="py-20 bg-white md:py-28">
    <div class="container px-4 mx-auto max-w-6xl">
        <div class="text-center mb-14">
            <span class="inline-block text-white font-bold tracking-wider uppercase text-xs border border-blue-700 bg-blue-700 px-3 py-1 rounded-full mb-4">Norte Pioneiro do Paraná</span>
            <h2 class="text-3xl font-extrabold text-slate-800 font-heading md:text-4xl">Localização Estratégica</h2>
            <p class="mt-4 max-w-2xl mx-auto text-slate-800 text-base">Assaí está no coração do Norte Pioneiro Paranaense, a poucos quilômetros das principais cidades da região.</p>
        </div>

        <div class="grid grid-cols-1 gap-10 lg:grid-cols-2 items-start">

            {{-- Coluna de dados --}}
            <div class="space-y-8">

                {{-- Distâncias --}}
                <div>
                    <h3 class="flex items-center gap-2 text-xs font-extrabold text-slate-700 uppercase tracking-widest mb-4">
                        <svg class="w-4 h-4 text-blue-500 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 20l-5.447-2.724A1 1 0 013 16.382V5.618a1 1 0 011.447-.894L9 7m0 13l6-3m-6 3V7m6 10l4.553 2.276A1 1 0 0021 18.382V7.618a1 1 0 00-.553-.894L15 4m0 13V4m0 0L9 7" />
                        </svg>
                        Distâncias Rodoviárias
                    </h3>
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                        @php
                        $distancias = [
                        ['cidade' => 'Londrina', 'km' => '46 km', 'info' => 'Aeroporto Internacional', 'cor' => 'slate'],
                        ['cidade' => 'S. Jerônimo da Serra', 'km' => '25 km', 'info' => 'Município de origem', 'cor' => 'slate'],
                        ['cidade' => 'Maringá', 'km' => '127 km', 'info' => 'Hub regional', 'cor' => 'slate'],
                        ['cidade' => 'Curitiba', 'km' => '339 km', 'info' => 'Capital do Paraná', 'cor' => 'slate'],
                        ['cidade' => 'São Paulo', 'km' => '490 km', 'info' => 'Capital Paulista', 'cor' => 'slate'],
                        ['cidade' => 'Porto Alegre', 'km' => '720 km', 'info' => 'Capital Gaúcha', 'cor' => 'slate'],
                        ];
                        @endphp
                        @foreach($distancias as $dist)
                        <div class="flex items-center gap-3 p-3.5 bg-white border border-slate-100 rounded-xl shadow-sm hover:shadow-md transition-all duration-300">
                            <div class="flex items-center justify-center w-10 h-10 rounded-xl shrink-0
                                {{ $dist['cor'] === 'blue' ? 'bg-blue-50 text-blue-700' : ($dist['cor'] === 'indigo' ? 'bg-indigo-50 text-indigo-700' : 'bg-slate-100 text-slate-600') }}">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                                </svg>
                            </div>
                            <div>
                                <p class="text-sm font-black text-slate-800 font-heading">{{ $dist['km'] }}</p>
                                <p class="text-xs text-slate-700 leading-tight">{{ $dist['cidade'] }}</p>
                                <p class="text-xs text-slate-600">{{ $dist['info'] }}</p>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>

                {{-- Limites Territoriais --}}
                <div>
                    <h3 class="flex items-center gap-2 text-xs font-extrabold text-slate-700 uppercase tracking-widest mb-4">
                        <svg class="w-4 h-4 text-emerald-500 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3.055 11H5a2 2 0 012 2v1a2 2 0 002 2 2 2 0 012 2v2.945M8 3.935V5.5A2.5 2.5 0 0010.5 8h.5a2 2 0 012 2 2 2 0 104 0 2 2 0 012-2h1.064M15 20.488V18a2 2 0 012-2h3.064" />
                        </svg>
                        Limites Territoriais
                    </h3>
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                        <div class="p-3.5 bg-white border border-slate-100 rounded-xl shadow-sm hover:shadow-md transition-all duration-300 text-center">
                            <p class="text-xs font-black text-emerald-600 uppercase tracking-widest mb-1">↑ Norte</p>
                            <p class="text-sm font-bold text-slate-700">Sertanópolis</p>
                            <p class="text-xs text-slate-600">e Ibiporã</p>
                        </div>
                        <div class="p-3.5 bg-white border border-slate-100 rounded-xl shadow-sm hover:shadow-md transition-all duration-300 text-center">
                            <p class="text-xs font-black text-blue-600 uppercase tracking-widest mb-1">↓ Sul</p>
                            <p class="text-sm font-bold text-slate-700">São Jerônimo</p>
                            <p class="text-xs text-slate-600">da Serra</p>
                        </div>
                        <div class="p-3.5 bg-white border border-slate-100 rounded-xl shadow-sm hover:shadow-md transition-all duration-300 text-center">
                            <p class="text-xs font-black text-yellow-600 uppercase tracking-widest mb-1">→ Leste</p>
                            <p class="text-sm font-bold text-slate-700">Uraí</p>
                            <p class="text-xs text-slate-600">e Leópolis</p>
                        </div>
                        <div class="p-3.5 bg-white border border-slate-100 rounded-xl shadow-sm hover:shadow-md transition-all duration-300 text-center">
                            <p class="text-xs font-black text-indigo-600 uppercase tracking-widest mb-1">← Oeste</p>
                            <p class="text-sm font-bold text-slate-700">Primeiro de Maio</p>
                            <p class="text-xs text-slate-600">e Sertaneja</p>
                        </div>
                    </div>
                </div>

                {{-- Coordenadas --}}
                <div class="flex items-start gap-4 p-4 bg-blue-800 border border-blue-900 rounded-xl shadow-sm">
                    <svg class="w-5 h-5 text-blue-200 shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    <div>
                        <p class="text-xs font-bold text-blue-100 uppercase tracking-wider mb-1">Coordenadas Geográficas</p>
                        <p class="text-sm text-white font-mono font-bold">23°21'31" S &nbsp;·&nbsp; 50°00'33" O</p>
                        <p class="text-xs text-blue-200 mt-1">Altitude média: 595 m &nbsp;·&nbsp; Fuso: UTC−3</p>
                    </div>
                </div>
            </div>

            {{-- Mapa --}}
            <div class="overflow-hidden rounded-3xl shadow-sm hover:shadow-md transition-all duration-300 border border-slate-200 bg-white">
                <iframe
                    title="Mapa de Assaí"
                    src="https://maps.google.com/maps?q=Assa%C3%AD,+Paran%C3%A1&output=embed"
                    width="100%"
                    height="460"
                    class="border-0"
                    allowfullscreen=""
                    loading="lazy"
                    referrerpolicy="no-referrer-when-downgrade">
                </iframe>
            </div>
        </div>
    </div>
</section>

{{-- ===== CULTURA JAPONESA ===== --}}
<section class="py-20 bg-blue-950 md:py-28 relative overflow-hidden">
    <div class="absolute inset-0 opacity-[0.04]">
        <svg width="100%" height="100%" xmlns="http://www.w3.org/2000/svg">
            <defs>
                <pattern id="jp" x="0" y="0" width="80" height="80" patternUnits="userSpaceOnUse">
                    <circle cx="40" cy="40" r="30" fill="none" stroke="#fff" stroke-width="1" />
                    <circle cx="40" cy="40" r="20" fill="none" stroke="#fff" stroke-width="0.5" />
                </pattern>
            </defs>
            <rect width="100%" height="100%" fill="url(#jp)" />
        </svg>
    </div>

    <div class="container relative z-10 px-4 mx-auto max-w-6xl">
        <div class="grid items-center grid-cols-1 gap-12 md:grid-cols-2">
            <div class="space-y-5 text-white">
                <span class="inline-block text-blue-900 font-bold tracking-wider uppercase text-xs border border-yellow-500 bg-yellow-400 px-3 py-1 rounded-full">Tradição Viva</span>
                <h2 class="text-3xl font-extrabold font-heading md:text-4xl leading-tight text-white">
                    O Coração <span class="text-yellow-300">Japonês</span> do Paraná
                </h2>
                <p class="text-white text-[15px] md:text-base leading-7 md:leading-relaxed">A cultura nipônica não está apenas no nome de Assaí — ela pulsa nas ruas arborizadas com <strong>Sakura (cerejeiras)</strong> e Ipês, na arquitetura do imponente <strong>Castelo Japonês (Memorial da Imigração Japonesa)</strong> e no calendário de festividades ao longo do ano.</p>
                <p class="text-white text-[15px] md:text-base leading-7 md:leading-relaxed">Em 1978, Assaí realizou o <strong>primeiro festival Tanabata Matsuri do Brasil</strong>. Hoje, o município celebra o Bon Odori, o Tenrankai e a Expoasa, mantendo viva a herança dos pioneiros que cruzaram oceanos para construir um novo lar.</p>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-3 pt-2">
                    @php
                    $festas = [
                    ['nome' => 'Tanabata Matsuri', 'data' => 'Out.', 'icon' => '🌟', 'bg' => 'bg-yellow-100', 'text' => 'text-yellow-700'],
                    ['nome' => 'Bon Odori', 'data' => 'Ago.', 'icon' => '🎶', 'bg' => 'bg-blue-100', 'text' => 'text-blue-700'],
                    ['nome' => 'Tenrankai', 'data' => 'Nov.', 'icon' => '🎨', 'bg' => 'bg-pink-100', 'text' => 'text-pink-700'],
                    ['nome' => 'Expoasa', 'data' => 'Jun.', 'icon' => '🌾', 'bg' => 'bg-green-100', 'text' => 'text-green-700'],
                    ];
                    @endphp
                    @foreach($festas as $festa)
                    <div class="flex items-center gap-3 p-3 rounded-xl border border-white/20 backdrop-blur-sm {{ $festa['bg'] }}">
                        <span class="text-2xl {{ $festa['text'] }}">{{ $festa['icon'] }}</span>
                        <div>
                            <p class="font-bold text-sm font-heading {{ $festa['text'] }}">{{ $festa['nome'] }}</p>
                            <p class="text-xs text-slate-900">{{ $festa['data'] }}</p>
                        </div>
                    </div>
                    @endforeach
                </div>

                <a href="{{ route('pages.turismo') }}" class="inline-flex items-center gap-2 mt-4 px-6 py-3 font-bold text-blue-900 transition bg-yellow-400 rounded-full hover:bg-yellow-300 hover:-translate-y-0.5 shadow-lg text-sm">
                    Conheça os Pontos Turísticos
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3" />
                    </svg>
                </a>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div class="rounded-2xl overflow-hidden shadow-lg aspect-square bg-blue-800 flex flex-col items-center justify-center p-8 text-center border border-blue-700 transform hover:-translate-y-1 transition">
                    <span class="text-6xl mb-4">🏯</span>
                    <p class="font-extrabold font-heading text-white text-sm leading-tight">Castelo Japonês</p>
                    <p class="text-blue-100 text-xs mt-1">Memorial da Imigração</p>
                </div>
                <div class="rounded-2xl overflow-hidden shadow-lg aspect-square bg-pink-600 flex flex-col items-center justify-center p-8 text-center border border-pink-700 transform hover:-translate-y-1 transition">
                    <span class="text-6xl mb-4">🌸</span>
                    <p class="font-extrabold font-heading text-white text-sm leading-tight">Sakura</p>
                    <p class="text-pink-100 text-xs mt-1">Cerejeiras Japonesas</p>
                </div>
                <div class="rounded-2xl overflow-hidden shadow-lg aspect-square bg-yellow-500 flex flex-col items-center justify-center p-8 text-center border border-yellow-600 transform hover:-translate-y-1 transition">
                    <span class="text-6xl mb-4">🎋</span>
                    <p class="font-extrabold font-heading text-white text-sm leading-tight">1º Tanabata</p>
                    <p class="text-yellow-100 text-xs mt-1">do Brasil — 1978</p>
                </div>
                <div class="rounded-2xl overflow-hidden shadow-lg aspect-square bg-blue-700 flex flex-col items-center justify-center p-8 text-center border border-blue-600 transform hover:-translate-y-1 transition">
                    <span class="text-6xl mb-4">⛩️</span>
                    <p class="font-extrabold font-heading text-white text-sm leading-tight">Templo Budista</p>
                    <p class="text-blue-100 text-xs mt-1">Shoshinji</p>
                </div>
            </div>
        </div>
    </div>
</section>

{{-- ===== SMART CITY / VALE DO SOL ===== --}}
<section class="py-20 bg-[#f8fbff] md:py-28">
    <div class="container px-4 mx-auto max-w-6xl">
        <div class="grid items-center grid-cols-1 gap-12 md:grid-cols-2">
            <div class="space-y-5">
                <span class="inline-block text-emerald-700 font-bold tracking-wider uppercase text-xs border border-emerald-200 bg-emerald-50 px-3 py-1 rounded-full">Inovação & Futuro</span>
                <h2 class="text-3xl font-extrabold text-slate-800 font-heading md:text-4xl leading-tight">
                    Top 7 Comunidades<br><span class="text-emerald-600">Mais Inteligentes do Mundo</span>
                </h2>
                <p class="text-slate-600 text-[15px] md:text-base leading-7 md:leading-relaxed">Assaí foi reconhecida pelo <strong>Intelligent Community Forum (ICF)</strong> como uma das 7 comunidades mais inteligentes do planeta — uma conquista que coloca nosso município ao lado de metrópoles globais na vanguarda da inovação.</p>
                <p class="text-slate-600 text-[15px] md:text-base leading-7 md:leading-relaxed">O protagonista desta transformação é o ecossistema <strong>Vale do Sol</strong>, um programa que conecta educação, tecnologia e empreendedorismo para criar o que chamamos de "cidade-laboratório". Aqui, o futuro é construído com a mesma determinação com que os pioneiros japoneses desbravaram as matas em 1932.</p>

                <div class="grid grid-cols-2 gap-4 pt-2">
                    <div class="p-4 bg-slate-100/50 rounded-xl border border-slate-100">
                        <div class="text-2xl font-black text-emerald-600 font-heading mb-1">6.000+</div>
                        <p class="text-xs text-slate-700 font-medium">Empregos gerados pela indústria</p>
                    </div>
                    <div class="p-4 bg-slate-100/50 rounded-xl border border-slate-100">
                        <div class="text-2xl font-black text-emerald-600 font-heading mb-1">0,748</div>
                        <p class="text-xs text-slate-700 font-medium">IDH Municipal — PNUD</p>
                    </div>
                    <div class="p-4 bg-slate-100/50 rounded-xl border border-slate-100">
                        <div class="text-2xl font-black text-emerald-600 font-heading mb-1">{{ \Carbon\Carbon::parse('1932-05-01')->diffInYears(now()) }} anos</div>
                        <p class="text-xs text-slate-700 font-medium">De história e resiliência</p>
                    </div>
                    <div class="p-4 bg-slate-100/50 rounded-xl border border-slate-100">
                        <div class="text-2xl font-black text-emerald-600 font-heading mb-1">Top 7</div>
                        <p class="text-xs text-slate-700 font-medium">ICF Smart Communities</p>
                    </div>
                </div>
            </div>

            <div class="relative">
                <div class="relative z-10 p-10 bg-blue-900 rounded-3xl shadow-2xl text-white text-center overflow-hidden">
                    <div class="absolute inset-0 opacity-5">
                        <svg width="100%" height="100%" xmlns="http://www.w3.org/2000/svg">
                            <defs>
                                <pattern id="circuit" x="0" y="0" width="60" height="60" patternUnits="userSpaceOnUse">
                                    <line x1="0" y1="30" x2="60" y2="30" stroke="white" stroke-width="1" />
                                    <line x1="30" y1="0" x2="30" y2="60" stroke="white" stroke-width="1" />
                                    <circle cx="30" cy="30" r="4" fill="none" stroke="white" stroke-width="1" />
                                </pattern>
                            </defs>
                            <rect width="100%" height="100%" fill="url(#circuit)" />
                        </svg>
                    </div>
                    <div class="relative z-10">
                        <div class="inline-flex items-center justify-center w-20 h-20 mb-6 bg-yellow-400 rounded-2xl text-blue-900 shadow-xl mx-auto">
                            <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z" />
                            </svg>
                        </div>
                        <p class="text-yellow-400 font-bold text-xs tracking-widest uppercase mb-3">Intelligent Community Forum</p>
                        <p class="text-4xl font-black font-heading text-white mb-2">Top 7</p>
                        <p class="text-blue-100 text-sm leading-relaxed mb-6">Assaí integra o seleto grupo das 7 comunidades mais inteligentes do mundo, ao lado de cidades de países como EUA, Canadá e Taiwan.</p>
                        <div class="border-t border-white/20 pt-6">
                            <p class="text-white font-extrabold font-heading text-lg mb-1">Ecossistema Vale do Sol</p>
                            <p class="text-blue-100 text-sm">Conectando educação · tecnologia · empreendedorismo</p>
                        </div>
                    </div>
                </div>
                <div class="absolute -bottom-4 -right-4 w-full h-full bg-emerald-500/20 rounded-3xl -z-10"></div>
                <div class="absolute -bottom-8 -right-8 w-full h-full bg-blue-500/10 rounded-3xl -z-20"></div>
            </div>
        </div>
    </div>
</section>

{{-- ===== SÍMBOLOS CÍVICOS ===== --}}
<section id="simbolos" class="py-20 bg-white md:py-28">
    <div class="container px-4 mx-auto max-w-6xl">
        <div class="text-center mb-14">
            <span class="inline-block text-slate-900 font-bold tracking-wider uppercase text-xs border border-yellow-500 bg-yellow-400 px-3 py-1 rounded-full mb-4">Identidade Municipal</span>
            <h2 class="text-3xl font-extrabold text-slate-800 font-heading md:text-4xl">Símbolos Cívicos</h2>
            <p class="mt-4 max-w-2xl mx-auto text-slate-800 text-base">A bandeira, o brasão e o hino que representam a identidade e os valores do povo assaiense.</p>
        </div>

        <div class="grid grid-cols-1 gap-8 lg:grid-cols-2 items-stretch">

            {{-- Coluna 1: Bandeira + Brasão --}}
            <div class="space-y-6">

                {{-- Bandeira Municipal --}}
                <div class="p-8 bg-white border border-slate-200 rounded-2xl shadow-sm hover:shadow-md transition-all duration-300 group flex flex-col items-center justify-center">
                    <img src="/img/bandeira.png" alt="Bandeira do município" loading="lazy" decoding="async" class="w-full max-w-[280px] h-auto rounded-lg shadow-md group-hover:scale-105 transition duration-500" />
                    <p class="text-base font-extrabold text-slate-700 font-heading mt-6">Bandeira Municipal</p>
                </div>

                {{-- Brasão de Armas --}}
                <div class="p-8 bg-white border border-slate-200 rounded-2xl shadow-sm hover:shadow-md transition-all duration-300 group flex flex-col items-center justify-center">
                    <img src="/img/brasao.png" alt="Brasão de Armas de Assaí" loading="lazy" decoding="async" class="w-full max-w-[220px] h-auto group-hover:scale-105 transition duration-500" />
                    <p class="text-base font-extrabold text-slate-700 font-heading mt-6">Brasão de Armas</p>
                </div>
            </div>

            {{-- Coluna 2: Hino --}}
            <div class="p-8 bg-white border border-slate-200 rounded-2xl shadow-sm hover:shadow-md transition-all duration-300 flex flex-col h-full">

                {{-- Header do card --}}
                <div class="flex items-center gap-3 mb-5">
                    <div class="flex items-center justify-center w-11 h-11 bg-blue-100 rounded-xl shrink-0">
                        <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 19V6l12-3v13M9 19c0 1.105-1.343 2-3 2s-3-.895-3-2 1.343-2 3-2 3 .895 3 2zm12-3c0 1.105-1.343 2-3 2s-3-.895-3-2 1.343-2 3-2 3 .895 3 2zM9 10l12-3" />
                        </svg>
                    </div>
                    <div>
                        <h3 class="text-lg font-extrabold text-slate-800 font-heading leading-tight">Hino de Assaí</h3>
                        <p class="text-xs text-slate-600">Letra e Composição Oficiais</p>
                    </div>
                </div>

                <div class="p-3 bg-slate-100/50 border border-slate-200 rounded-xl mb-6">
                    <audio controls class="w-full rounded-xl" preload="none">
                        <source src="{{ asset('img/hino.mp3') }}" type="audio/mpeg">
                        Seu navegador não suporta o elemento de áudio.
                    </audio>
                </div>

                {{-- Letra do Hino Oficial --}}
                <div class="flex-1 overflow-y-auto scrollbar-hide pr-2 border-t border-slate-100 pt-4 min-h-[320px]">
                    <div class="space-y-5 text-sm text-slate-600 leading-loose">
                        <div>
                            <p class="text-xs font-black text-blue-600 uppercase tracking-widest mb-2">Letra: Walerian Wrosz</p>
                            <p>
                                Salve Assaí garbosa, esplendor do Brasil.<br>
                                A cidade mais querida, entre tantas outras mil.<br>
                                Salve, a terra nutriz, o grande celeiro do sul.<br>
                                O retrato do teu rosto, bandeira ouro-azul.<br><br>
                                Enquanto nós vivermos, Assaí só crescerá<br>
                                Em ritmo de progresso do gigante Paraná.<br>
                                Nossa luta pelo Brasil já começou aqui <span class="font-bold">(BIS)</span><br>
                                Desde que nossos ancestrais fundaram Assaí.<br><br>
                                Salve Assaí garbosa, esplendor do Brasil.<br>
                                A cidade mais querida, entre tantas outras mil.<br>
                                Salve, a terra nutriz, o grande celeiro do sul.<br>
                                O retrato do teu rosto, bandeira ouro-azul.<br><br>
                                Todos unidos lutaremos pelo bem comum<br>
                                O povo da cidade e do campo sempre é um.<br>
                                O trabalho traz bem estar, na luta integral <span class="font-bold">(BIS)</span><br>
                                O assaiense alcançará a glória imortal.<br><br>
                                Salve Assaí garbosa, esplendor do Brasil.<br>
                                A cidade mais querida, entre tantas outras mil.<br>
                                Salve, a terra nutriz, o grande celeiro do sul.<br>
                                O retrato do teu rosto, bandeira ouro-azul.
                            </p>
                        </div>
                    </div>
                </div>
                <p class="mt-5 pt-4 border-t border-slate-100 text-xs text-slate-600 italic text-center">* Letra oficial do Hino de Assaí.</p>
            </div>

        </div>
    </div>
</section>

{{-- ===== CTA FINAL ===== --}}
<section class="py-20 bg-gradient-to-br from-blue-900 via-blue-800 to-indigo-900 md:py-24 text-white relative overflow-hidden">
    <div class="absolute inset-0 opacity-5">
        <svg class="w-full h-full" xmlns="http://www.w3.org/2000/svg">
            <defs>
                <pattern id="dots" width="30" height="30" patternUnits="userSpaceOnUse">
                    <circle cx="2" cy="2" r="1.5" fill="white" />
                </pattern>
            </defs>
            <rect width="100%" height="100%" fill="url(#dots)" />
        </svg>
    </div>
    <div class="container relative z-10 px-4 mx-auto max-w-4xl text-center">
        <p class="text-yellow-400 font-bold tracking-widest uppercase text-xs mb-6">Assaí — Norte Pioneiro do Paraná</p>
        <h2 class="text-4xl font-extrabold font-heading md:text-5xl leading-tight mb-6 text-white">
            Tradição e Inovação<br>caminham lado a lado.
        </h2>
        <p class="text-blue-100 text-lg leading-relaxed max-w-2xl mx-auto mb-10">
            Com {{ \Carbon\Carbon::parse('1932-05-01')->diffInYears(now()) }} anos de história, Assaí segue a saga dos seus fundadores: determinada, resiliente e de olhos voltados para o horizonte. Uma cidade que honra as suas raízes enquanto constrói o futuro.
        </p>
        <div class="flex flex-wrap items-center justify-center gap-4">
            <a href="{{ route('pages.turismo') }}" class="inline-flex items-center gap-2 px-7 py-3 md:py-3.5 font-bold text-blue-900 transition bg-yellow-400 rounded-full hover:bg-yellow-300 hover:-translate-y-0.5 shadow-lg text-sm md:text-base">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                </svg>
                Explore o Turismo
            </a>
            <a href="{{ route('agenda.index') }}" class="inline-flex items-center gap-2 px-7 py-3 md:py-3.5 font-bold text-white transition border-2 border-white/40 rounded-full hover:border-white hover:bg-white/10 text-sm md:text-base">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                </svg>
                Ver Agenda de Eventos
            </a>
        </div>
    </div>
</section>

@endsection