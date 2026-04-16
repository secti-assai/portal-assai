@extends('layouts.app')
@section('title', 'Nossa Cidade - Prefeitura Municipal de Assaí')

@section('content')
<style>
    body, html { overflow-x: hidden !important; }
</style>

{{-- ===== HERO ===== --}}
<section class="relative pt-[calc(var(--site-header-height,72px)+1.5rem)] pb-16 sm:pt-[calc(var(--site-header-height,72px)+2.5rem)] sm:pb-20 md:pt-[calc(var(--site-header-height,72px)+3.5rem)] md:pb-24 lg:pt-24 lg:pb-24 overflow-hidden bg-[#006eb7] w-full max-w-full">
    <div class="absolute inset-0 pointer-events-none">
        <svg class="absolute w-full h-full opacity-10" xmlns="http://www.w3.org/2000/svg">
            <defs>
                <pattern id="grid" width="60" height="60" patternUnits="userSpaceOnUse">
                    <path d="M 60 0 L 0 0 0 60" fill="none" stroke="white" stroke-width="1" />
                </pattern>
            </defs>
            <rect width="100%" height="100%" fill="url(#grid)" />
        </svg>
        <div class="absolute bottom-0 left-0 right-0 h-64 bg-gradient-to-t from-slate-950/80 to-transparent"></div>
    </div>

    <div class="container relative z-10 px-4 sm:px-6 md:px-8 mx-auto text-left max-w-6xl w-full">
        
        <x-breadcrumb :items="[
            ['name' => 'Início', 'url' => route('home')],
            ['name' => 'Cidade', 'url' => null],
            ['name' => 'Nossa Cidade', 'url' => null]
        ]" dark />
        
        <div class="mt-8 md:mt-10 max-w-3xl">
            <span class="inline-flex items-center gap-2 px-4 py-1.5 mb-6 text-xs font-bold tracking-widest text-blue-900 uppercase bg-yellow-400 rounded-full shadow-sm">
                Conheça a Nossa História
            </span>
            <h1 class="text-4xl sm:text-5xl md:text-6xl font-extrabold font-heading mb-6 text-white drop-shadow-md leading-tight" style="font-family: 'Montserrat', sans-serif;">
                Assaí <span class="text-yellow-400">— PR</span>
            </h1>
            <p class="text-lg sm:text-xl md:text-2xl text-blue-50 leading-relaxed font-light">
                Do "Sol Nascente" (朝日) plantado pelos pioneiros japoneses em 1932 ao reconhecimento como uma das <strong class="text-white font-bold border-b-2 border-yellow-400 pb-0.5">Top 7 Comunidades mais Inteligentes do Mundo</strong>.
            </p>
        </div>
    </div>
</section>

{{-- ===== FUNDAÇÃO ===== --}}
<section id="historia" class="py-16 md:py-24 bg-white">
    <div class="container px-4 sm:px-6 md:px-8 mx-auto max-w-6xl">
        <div class="grid items-center grid-cols-1 lg:grid-cols-2 gap-12 lg:gap-16">
            
            {{-- Imagem com Decorador --}}
            <div class="relative group order-2 lg:order-1">
                <div class="overflow-hidden shadow-2xl rounded-[2rem] bg-slate-200 relative aspect-video sm:aspect-square w-full">
                    <img src="{{ asset('img/Assai.jpg') }}" alt="Fundação de Assaí — pioneiros japoneses em 1932" class="object-cover w-full h-full transition duration-700 group-hover:scale-105" loading="lazy" decoding="async">
                    <div class="absolute inset-0 ring-1 ring-inset ring-black/10 rounded-[2rem] pointer-events-none"></div>
                </div>
                
                {{-- Badge de Data --}}
                <div class="absolute -bottom-6 -right-2 sm:-right-6 p-6 shadow-2xl bg-[#006eb7] text-white rounded-3xl transform group-hover:-translate-y-2 transition-transform duration-300">
                    <p class="mb-1 text-[10px] font-extrabold tracking-[0.2em] uppercase text-yellow-400">Aniversário</p>
                    <p class="text-3xl sm:text-4xl font-black font-heading leading-none" style="font-family: 'Montserrat', sans-serif;">1º de Maio</p>
                    <p class="text-blue-200 text-sm mt-2 font-medium">Desde 1932</p>
                </div>
            </div>
            
            {{-- Texto Descritivo --}}
            <div class="space-y-6 text-slate-700 order-1 lg:order-2 lg:pl-8">
                <div class="inline-flex items-center gap-2">
                    <span class="w-8 h-1 bg-[#006eb7] rounded-full"></span>
                    <span class="text-[#006eb7] font-bold tracking-widest uppercase text-xs">Raízes Históricas</span>
                </div>
                
                <h2 class="text-3xl sm:text-4xl font-extrabold text-slate-800 font-heading leading-tight" style="font-family: 'Montserrat', sans-serif;">
                    O Nascimento de <span class="text-[#006eb7]">Assailand</span>
                </h2>
                
                <div class="prose prose-slate prose-lg max-w-none prose-p:leading-relaxed prose-strong:text-slate-800">
                    <p>Em 1927, o cônsul japonês em São Paulo, Noriyuki Akamatsu, incentivou a emigração para o Paraná após agrônomos confirmarem a fertilidade excepcional das terras da região de Três Barras. Uma gleba de <strong>12 mil alqueires</strong> foi adquirida em 14 de novembro de 1928 pela Companhia Colonizadora Bratac.</p>
                    <p>No dia <strong>1º de maio de 1932</strong>, um grupo liderado por <strong>Miyuki Saito</strong> — acompanhado por Itissuke Nishimura, Utaro Katsuda, Tokujiro Tsutsui e Junzo Nagai — embrenhou-se mata adentro e fundou a nova colônia.</p>
                    <div class="bg-blue-50 border-l-4 border-[#006eb7] p-5 rounded-r-xl mt-6 italic text-slate-800">
                        A sede, já bastante povoada, recebeu o nome de <strong>"Assailand"</strong>: uma fusão de <em>Asahi</em> (朝日 — "Sol Nascente", em japonês) com a palavra inglesa <em>land</em> (terra), em homenagem aos colonizadores japoneses que ali se estabeleceram.
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

{{-- ===== LINHA DO TEMPO (CORRIGIDA E INTERCALADA) ===== --}}
<section class="py-16 md:py-24 bg-slate-50 border-y border-slate-200">
    <div class="container px-4 sm:px-6 mx-auto max-w-5xl">
        
        <div class="text-center mb-16">
            <h2 class="text-3xl font-black text-slate-800 md:text-4xl mb-4" style="font-family: 'Montserrat', sans-serif;">Marcos da Nossa História</h2>
            <p class="text-slate-500 max-w-2xl mx-auto text-lg">Uma jornada de trabalho, resiliência e desenvolvimento ao longo das décadas.</p>
        </div>

        @php
        $eventosTimeline = [
            ['ano' => '1927', 'titulo' => 'Cooperativa de Emigração', 'desc' => 'O cônsul japonês Noriyuki Akamatsu funda a Cooperativa de Imigração, incentivando a vinda para o Paraná.'],
            ['ano' => '1928', 'titulo' => 'Compra das Terras', 'desc' => 'Em 14 de novembro, a Companhia Colonizadora Bratac firma a aquisição de 12 mil alqueires.'],
            ['ano' => '1932', 'titulo' => 'Fundação — 1º de Maio', 'desc' => 'Miyuki Saito e seu grupo fundam o núcleo que ficaria conhecido como Assailand, desbravando a mata virgem.'],
            ['ano' => '1934', 'titulo' => 'A "Era do Ouro Branco"', 'desc' => 'O pioneiro Heiju Akagui alcança a marca de colher 360 arrobas de algodão por alqueire, impulsionando a economia local.'],
            ['ano' => '1944', 'titulo' => 'Instalação do Município', 'desc' => 'Em 28 de janeiro, Assaí é solenemente instalada e emancipada politicamente como município.'],
            ['ano' => '1978', 'titulo' => '1º Tanabata Matsuri do Brasil', 'desc' => 'Assaí realiza o primeiro festival do Castelo de Estrelas (Tanabata Matsuri) em solo brasileiro.'],
            ['ano' => 'Hoje', 'titulo' => 'Top 7 Comunidades Inteligentes', 'desc' => 'Impulsionada pelo ecossistema de inovação Vale do Sol, Assaí é reconhecida globalmente pelo Intelligent Community Forum (ICF).', 'destaque' => true],
        ];
        @endphp

        {{-- Container da Timeline --}}
        <div class="relative wrap overflow-hidden p-4 md:p-10 h-full">
            
            {{-- Linha central (Desktop) --}}
            <div class="hidden md:block absolute border-2 border-opacity-20 border-slate-300 h-full border left-1/2 -translate-x-1/2 top-0"></div>
            
            {{-- Linha lateral (Mobile) --}}
            <div class="md:hidden absolute border-2 border-opacity-20 border-slate-300 h-full border left-[34px] top-0"></div>

            @foreach($eventosTimeline as $index => $evento)
            @php 
                // Define os lados (Pares na Esquerda, Ímpares na Direita)
                $isDireita = $index % 2 !== 0; 
                $isDestaque = isset($evento['destaque']) && $evento['destaque'];
            @endphp
            
            <div class="mb-10 flex justify-between items-center w-full {{ $isDireita ? 'md:flex-row-reverse' : 'md:flex-row' }} relative group">
                
                {{-- Espaço Vazio para empurrar o card (Apenas Desktop) --}}
                <div class="hidden md:block order-1 md:w-5/12"></div>

                {{-- Ponto Central (Ícone/Bandeira) --}}
                <div class="z-20 flex items-center order-1 w-10 h-10 rounded-full shadow-xl absolute left-4 md:relative md:left-auto border-2 border-white shrink-0 {{ $isDestaque ? 'bg-yellow-400 shadow-yellow-400/50 ring-4 ring-yellow-400/30 animate-pulse text-blue-900' : 'bg-[#006eb7] text-white' }}">
                    <i class="fa-solid fa-flag mx-auto text-sm"></i>
                </div>

                {{-- Card de Conteúdo --}}
                <div class="order-1 w-full pl-16 md:pl-0 md:w-5/12 {{ $isDireita ? 'md:pl-8 lg:pl-10' : 'md:pr-8 lg:pr-10' }}">
                    <div class="bg-white rounded-2xl shadow-sm border {{ $isDestaque ? 'border-yellow-400 ring-1 ring-yellow-400' : 'border-slate-200' }} p-6 hover:-translate-y-1 transition-transform duration-300 w-full hover:shadow-md relative">
                        
                        {{-- Setinha apontando para a linha (Apenas Desktop) --}}
                        <div class="hidden md:block absolute top-6 w-4 h-4 bg-white border-t border-r border-slate-200 transform rotate-45 {{ $isDireita ? '-left-2 border-l-0 border-b-0' : '-right-2 border-t-0 border-l-0' }} {{ $isDestaque ? 'border-yellow-400' : '' }}"></div>

                        <div class="flex items-center gap-3 mb-3">
                            <span class="px-3 py-1 text-[11px] font-extrabold uppercase rounded-md {{ $isDestaque ? 'bg-yellow-100 text-yellow-800' : 'bg-blue-50 text-[#006eb7]' }} tracking-wider">
                                {{ $evento['ano'] }}
                            </span>
                        </div>
                        
                        <h3 class="font-extrabold text-lg text-slate-800 mb-2 leading-tight" style="font-family: 'Montserrat', sans-serif;">{{ $evento['titulo'] }}</h3>
                        <p class="text-sm leading-relaxed text-slate-600">{{ $evento['desc'] }}</p>
                    </div>
                </div>

            </div>
            @endforeach
        </div>

    </div>
</section>

{{-- ===== SÍMBOLOS CÍVICOS ===== --}}
<section id="simbolos" class="py-16 md:py-24 bg-white">
    <div class="container px-4 sm:px-6 mx-auto max-w-6xl">
        
        <div class="text-center mb-16">
            <span class="inline-flex items-center gap-2 px-4 py-1.5 mb-4 text-[10px] font-extrabold tracking-[0.2em] text-[#006eb7] uppercase bg-blue-50 rounded-full border border-blue-100">
                Identidade Municipal
            </span>
            <h2 class="text-3xl font-black text-slate-800 md:text-4xl mb-4" style="font-family: 'Montserrat', sans-serif;">Símbolos Cívicos</h2>
        </div>

        {{-- Grid de 3 Colunas --}}
        <div class="grid grid-cols-1 md:grid-cols-2 gap-8 items-start">
            
            <div class="flex flex-col gap-8">
                {{-- Bandeira --}}
                <div class="bg-slate-50 border border-slate-200 rounded-3xl p-8 flex flex-col items-center justify-start min-h-[320px] hover:shadow-lg transition-shadow duration-300">
                    <div class="w-full flex-1 flex items-center justify-center min-h-[160px] mb-6">
                        <img src="{{ asset('img/bandeira.png') }}" alt="Bandeira do Município de Assaí" class="w-full max-w-[240px] h-auto drop-shadow-md rounded-sm" loading="lazy"/>
                    </div>
                    <div class="text-center w-full border-t border-slate-200 pt-6">
                        <h3 class="text-xl font-bold text-slate-800 font-heading">Bandeira Municipal</h3>
                    </div>
                </div>
                {{-- Brasão --}}
                <div class="bg-slate-50 border border-slate-200 rounded-3xl p-8 flex flex-col items-center justify-start min-h-[320px] hover:shadow-lg transition-shadow duration-300">
                    <div class="w-full flex-1 flex items-center justify-center min-h-[160px] mb-6">
                        <img src="{{ asset('img/brasao.png') }}" alt="Brasão de Armas de Assaí" class="w-full max-w-[180px] h-auto drop-shadow-md" loading="lazy" />
                    </div>
                    <div class="text-center w-full border-t border-slate-200 pt-6">
                        <h3 class="text-xl font-bold text-slate-800 font-heading">Brasão de Armas</h3>
                    </div>
                </div>
            </div>
            {{-- Hino --}}
            <div class="bg-[#006eb7] rounded-3xl p-8 flex flex-col items-center justify-start shadow-lg shadow-blue-900/20 text-white h-full">
                <div class="w-20 h-20 bg-white/10 rounded-full flex items-center justify-center text-3xl mb-6 mt-4 ring-1 ring-white/20">
                    <i class="fa-solid fa-music text-yellow-400"></i>
                </div>
                <h3 class="text-xl font-bold font-heading mb-6">Hino Oficial de Assaí</h3>
                <div class="w-full bg-white/5 border border-white/10 rounded-2xl p-4 mb-6 backdrop-blur-sm">
                    <audio controls class="w-full h-10 outline-none">
                        <source src="{{ asset('img/hino.mp3') }}" type="audio/mpeg">
                        O seu navegador não suporta o elemento de áudio.
                    </audio>
                </div>
                <div class="w-full max-w-full">
                    <div class="mx-auto bg-white/90 border border-blue-200 rounded-2xl p-5 md:p-6 shadow-sm text-left max-w-md md:max-w-lg lg:max-w-xl overflow-auto" style="backdrop-filter: blur(2px);">
                        <div class="text-xs font-bold text-blue-700 mb-2 text-center tracking-widest uppercase">Letra: Walerian Wrosz</div>
                        <pre class="whitespace-pre-wrap font-mono text-[15px] leading-5 text-blue-900 bg-transparent m-0 p-0">Salve Assaí garbosa, esplendor do Brasil.
A cidade mais querida, entre tantas outras mil.
Salve, a terra nutriz, o grande celeiro do sul.
O retrato do teu rosto, bandeira ouro-azul.

Enquanto nós vivermos, Assaí só crescerá
Em ritmo de progresso do gigante Paraná.
Nossa luta pelo Brasil já começou aqui (BIS)
Desde que nossos ancestrais fundaram Assaí.

Salve Assaí garbosa, esplendor do Brasil.
A cidade mais querida, entre tantas outras mil.
Salve, a terra nutriz, o grande celeiro do sul.
O retrato do teu rosto, bandeira ouro-azul.

Todos unidos lutaremos pelo bem comum
O povo da cidade e do campo sempre é um.
O trabalho traz bem estar, na luta integral (BIS)
O assaiense alcançará a glória imortal.

Salve Assaí garbosa, esplendor do Brasil.
A cidade mais querida, entre tantas outras mil.
Salve, a terra nutriz, o grande celeiro do sul.
O retrato do teu rosto, bandeira ouro-azul.</pre>
                    </div>
                </div>
            </div>

        </div>
    </div>
</section>

@endsection