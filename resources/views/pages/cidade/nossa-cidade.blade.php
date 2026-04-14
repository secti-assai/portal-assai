@extends('layouts.app')
@section('title', 'Nossa Cidade - Prefeitura Municipal de Assaí')

@section('content')
<style>
    body, html { overflow-x: hidden !important; }
</style>

{{-- ===== HERO ===== --}}
<section class="relative pt-[calc(var(--site-header-height,72px)+1.5rem)] pb-16 sm:pt-[calc(var(--site-header-height,72px)+2.5rem)] sm:pb-20 md:pt-[calc(var(--site-header-height,72px)+3.5rem)] md:pb-24 lg:pt-24 lg:pb-24 overflow-hidden bg-blue-900 w-full max-w-full">
    <div class="absolute inset-0">
        <svg class="absolute w-full h-full opacity-10" xmlns="http://www.w3.org/2000/svg">
            <defs>
                <pattern id="grid" width="60" height="60" patternUnits="userSpaceOnUse">
                    <path d="M 60 0 L 0 0 0 60" fill="none" stroke="white" stroke-width="1" />
                </pattern>
            </defs>
            <rect width="100%" height="100%" fill="url(#grid)" />
        </svg>
        <div class="absolute bottom-0 left-0 right-0 h-64 bg-gradient-to-t from-blue-950 to-transparent"></div>
    </div>
    <div class="container relative z-10 px-4 sm:px-6 md:px-8 mx-auto text-left max-w-5xl w-full overflow-x-hidden">
        <div class="relative z-20">
            <x-breadcrumb :items="[
                ['name' => 'Início', 'url' => route('home')],
                ['name' => 'Cidade'],
                ['name' => 'Nossa Cidade']
            ]" dark />
        </div>
        <span class="inline-flex items-center gap-2 px-5 py-2 mb-8 md:mb-10 text-xs font-bold tracking-widest text-blue-900 uppercase bg-yellow-400 rounded-full shadow-md">
            Conheça a Nossa História
        </span>
        <h1 class="text-3xl sm:text-4xl md:text-5xl font-extrabold font-heading mb-5 text-white drop-shadow-sm leading-none" style="font-family: 'Montserrat', sans-serif;">
            Assaí <span class="text-yellow-400">— PR</span>
        </h1>
        <p class="max-w-3xl text-base sm:text-lg md:text-xl lg:text-2xl text-blue-100 leading-relaxed font-light mb-6">
            Do "Sol Nascente" (朝日) plantado pelos pioneiros japoneses em 1932 ao reconhecimento como uma das <strong class="text-white font-bold">Top 7 Comunidades mais Inteligentes do Mundo</strong>.
        </p>
    </div>
</section>

{{-- ===== FUNDAÇÃO ===== --}}
<section id="historia" class="py-12 sm:py-14 md:py-20 lg:py-28 bg-white w-full max-w-full overflow-x-hidden">
    <div class="container px-4 sm:px-6 md:px-8 mx-auto max-w-6xl w-full overflow-x-hidden">
        <div class="grid items-center grid-cols-1 gap-10 md:grid-cols-2 w-full">
            <div class="relative group">
                <div class="overflow-hidden shadow-2xl rounded-3xl bg-slate-200 relative aspect-[4/3] sm:aspect-square w-full max-w-full">
                    <img src="{{ asset('img/Assai.jpg') }}" alt="Fundação de Assaí — pioneiros japoneses em 1932" class="object-cover w-full h-full transition duration-700 group-hover:scale-105 max-w-full" loading="lazy" decoding="async">
                    <div class="absolute inset-0 ring-1 ring-inset ring-black/10 rounded-3xl"></div>
                </div>
                <div class="absolute -bottom-5 -right-5 p-5 shadow-2xl bg-blue-900 text-white rounded-2xl md:-bottom-8 md:-right-8 md:p-7">
                    <p class="mb-1 text-xs font-bold tracking-widest uppercase text-yellow-400">Aniversário</p>
                    <p class="text-3xl font-extrabold font-heading leading-none text-white">1º de Maio</p>
                    <p class="text-blue-100 text-sm mt-0.5">desde 1932</p>
                </div>
            </div>
            <div class="space-y-5 text-[15px] sm:text-base leading-7 md:leading-relaxed text-slate-800 md:pl-6 mt-8 md:mt-0">
                <span class="inline-block text-white font-bold tracking-wider uppercase text-xs border border-blue-700 bg-blue-700 px-3 py-1 rounded-full">Raízes Históricas</span>
                <h2 class="text-3xl font-extrabold text-slate-800 font-heading md:text-4xl leading-tight">
                    O Nascimento de <span class="text-blue-700">Assailand</span>
                </h2>
                <p>Em 1927, o cônsul japonês em São Paulo, Noriyuki Akamatsu, incentivou a emigração para o Paraná após agrônomos confirmarem a fertilidade excepcional das terras da região de Três Barras. Uma gleba de <strong>12 mil alqueires</strong> foi adquirida em 14 de novembro de 1928 pela Companhia Colonizadora Bratac.</p>
                <p>No dia <strong>1º de maio de 1932</strong>, um grupo liderado por <strong>Miyuki Saito</strong> — acompanhado por Itissuke Nishimura, Utaro Katsuda, Tokujiro Tsutsui e Junzo Nagai — embrenhou-se mata adentro e fundou a nova colônia.</p>
                <p>A sede, já bastante povoada, recebeu o nome de <strong>"Assailand"</strong>: uma fusão de <em>Asahi</em> (朝日 — "Sol Nascente", em japonês) com a palavra inglesa <em>land</em> (terra), em homenagem aos colonizadores japoneses que ali se estabeleceram.</p>
            </div>
        </div>
    </div>
</section>

{{-- ===== LINHA DO TEMPO ===== --}}
<section class="py-12 sm:py-14 md:py-20 lg:py-24 bg-[#eaf3ff] border-y border-blue-100/70 w-full max-w-full overflow-x-hidden">
    <div class="container px-4 sm:px-6 md:px-8 mx-auto max-w-5xl w-full overflow-x-hidden">
        <div class="text-center mb-14">
            <span class="inline-block text-white font-bold tracking-wider uppercase text-xs border border-blue-700 bg-blue-700 px-3 py-1 rounded-full mb-4">Linha do Tempo</span>
            <h2 class="text-3xl font-extrabold text-slate-800 font-heading md:text-4xl">Marcos da Nossa História</h2>
        </div>
        <div class="relative">
            <div class="absolute left-5 top-0 bottom-0 w-0.5 bg-slate-200 md:left-1/2 md:-translate-x-1/2"></div>
            <div class="space-y-8 w-full">
                @php
                $eventos = [
                        ['ano' => '1927', 'cor' => 'blue', 'titulo' => 'Cooperativa de Emigração', 'desc' => 'O cônsul japonês Noriyuki Akamatsu funda a Cooperativa de Imigração...'],
                        ['ano' => '1928', 'cor' => 'blue', 'titulo' => 'Compra das Terras', 'desc' => 'Em 14 de novembro, a Companhia Colonizadora Bratac firma contrato...'],
                        ['ano' => '1932', 'cor' => 'yellow', 'titulo' => 'Fundação — 1º de Maio', 'desc' => 'Miyuki Saito e seu grupo fundam o núcleo que ficaria conhecido como Assailand...'],
                        ['ano' => '1934', 'cor' => 'green', 'titulo' => 'A "Era do Ouro Branco"', 'desc' => 'Heiju Akagui colhe 360 arrobas de algodão por alqueire...'],
                        ['ano' => '1944', 'cor' => 'blue', 'titulo' => 'Instalação do Município', 'desc' => 'Em 28 de janeiro, Assaí é solenemente instalada como município...'],
                        ['ano' => '1978', 'cor' => 'pink', 'titulo' => '1º Tanabata Matsuri do Brasil', 'desc' => 'Assaí realiza o primeiro festival de Tanabata do Brasil...'],
                        ['ano' => 'Hoje', 'cor' => 'blue', 'titulo' => 'Top 7 Comunidades Inteligentes', 'desc' => 'Impulsionada pelo ecossistema Vale do Sol, Assaí é eleita pelo ICF...'],
                ];
                @endphp
                @foreach($eventos as $index => $evento)
                @php $direita = $index % 2 === 0; @endphp
                <div class="relative flex flex-col md:flex-row items-start gap-6 pl-14 md:pl-0 {{ $direita ? 'md:flex-row' : 'md:flex-row-reverse' }}">
                    <div class="absolute left-5 top-1.5 md:left-1/2 md:-translate-x-1/2 w-4 h-4 rounded-full border-2 border-white shadow-md {{ $evento['ano'] === 'Hoje' ? 'animate-pulse ring-4 ring-emerald-300/50' : '' }} {{ $evento['cor'] === 'yellow' ? 'bg-yellow-400' : ($evento['cor'] === 'green' ? 'bg-green-500' : ($evento['cor'] === 'pink' ? 'bg-pink-500' : 'bg-blue-500')) }}"></div>
                    <div class="w-full md:w-5/12 {{ $direita ? 'md:pr-10' : 'md:pl-10' }}">
                        <div class="relative p-6 md:p-8 bg-white border border-slate-200 shadow-sm rounded-2xl hover:shadow-md hover:-translate-y-1 transition-all duration-300 group overflow-hidden text-left">
                            <h3 class="text-xl font-extrabold text-slate-800 font-heading mb-3">{{ $evento['titulo'] }}</h3>
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

{{-- ===== SÍMBOLOS CÍVICOS ===== --}}
<section id="simbolos" class="py-12 sm:py-14 md:py-20 lg:py-28 bg-white w-full max-w-full overflow-x-hidden">
    <div class="container px-4 sm:px-6 md:px-8 mx-auto max-w-6xl w-full overflow-x-hidden">
        <div class="text-center mb-14">
            <span class="inline-block text-slate-900 font-bold tracking-wider uppercase text-xs border border-yellow-500 bg-yellow-400 px-3 py-1 rounded-full mb-4">Identidade Municipal</span>
            <h2 class="text-3xl font-extrabold text-slate-800 font-heading md:text-4xl">Símbolos Cívicos</h2>
        </div>
        <div class="grid grid-cols-1 gap-8 lg:grid-cols-2 items-stretch w-full">
            <div class="space-y-6">
                <div class="p-6 md:p-8 bg-white border border-slate-200 rounded-2xl shadow-sm flex flex-col items-center justify-center">
                    <img src="/img/bandeira.png" alt="Bandeira do município" class="w-full max-w-[280px] h-auto rounded-lg shadow-md" />
                    <p class="text-base font-extrabold text-slate-700 font-heading mt-6">Bandeira Municipal</p>
                </div>
                <div class="p-6 md:p-8 bg-white border border-slate-200 rounded-2xl shadow-sm flex flex-col items-center justify-center">
                    <img src="/img/brasao.png" alt="Brasão de Armas" class="w-full max-w-[220px] h-auto" />
                    <p class="text-base font-extrabold text-slate-700 font-heading mt-6">Brasão de Armas</p>
                </div>
            </div>
            <div class="p-6 md:p-8 bg-white border border-slate-200 rounded-2xl shadow-sm flex flex-col h-full w-full">
                <h3 class="text-lg font-extrabold text-slate-800 font-heading leading-tight mb-5">Hino de Assaí</h3>
                <div class="p-3 bg-slate-100/50 border border-slate-200 rounded-xl mb-6">
                    <audio controls class="w-full rounded-xl"><source src="{{ asset('img/hino.mp3') }}" type="audio/mpeg"></audio>
                </div>
            </div>
        </div>
    </div>
</section>

{{-- ===== CTA FINAL ===== --}}
<section class="py-12 sm:py-14 md:py-20 lg:py-28 bg-gradient-to-br from-blue-900 via-blue-800 to-indigo-900 text-white relative overflow-hidden w-full max-w-full">
    <div class="container relative z-10 px-4 sm:px-6 md:px-8 mx-auto max-w-4xl text-center w-full overflow-x-hidden">
        <h2 class="text-4xl font-extrabold font-heading md:text-5xl leading-tight mb-6 text-white">
            Tradição e Inovação caminham lado a lado.
        </h2>
        <a href="{{ route('pages.turismo') }}" class="inline-flex items-center gap-2 px-7 py-3 font-bold text-blue-900 bg-yellow-400 rounded-full">Explore o Turismo</a>
    </div>
</section>
@endsection