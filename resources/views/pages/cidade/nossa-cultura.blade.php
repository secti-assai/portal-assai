@extends('layouts.app')
@section('title', 'Nossa Cultura - Prefeitura Municipal de Assaí')

@section('content')
<style> body, html { overflow-x: hidden !important; } </style>

{{-- ===== HERO ===== --}}
<section class="relative pt-[calc(var(--site-header-height,72px)+1.5rem)] pb-16 sm:pt-[calc(var(--site-header-height,72px)+2.5rem)] sm:pb-20 md:pt-[calc(var(--site-header-height,72px)+3.5rem)] md:pb-24 lg:pt-24 lg:pb-24 overflow-hidden bg-[#006eb7] w-full max-w-full">
    <div class="absolute inset-0 pointer-events-none">
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
        <div class="relative z-20">
            <x-breadcrumb :items="[
                ['name' => 'Início', 'url' => route('home')],
                ['name' => 'Cidade', 'url' => null],
                ['name' => 'Nossa Cultura', 'url' => null]
            ]" dark />
        </div>
        
        <div class="mt-8 md:mt-10 max-w-3xl">
            <span class="inline-flex items-center gap-2 px-4 py-1.5 mb-6 text-xs font-bold tracking-widest text-blue-900 uppercase bg-yellow-400 rounded-full shadow-sm">
                Identidade & Tradição
            </span>
            <h1 class="text-4xl sm:text-5xl md:text-6xl font-extrabold font-heading mb-6 text-white drop-shadow-md leading-tight" style="font-family: 'Montserrat', sans-serif;">
                Nossa <span class="text-yellow-400">Cultura</span>
            </h1>
            <p class="text-lg sm:text-xl md:text-2xl text-blue-50 leading-relaxed font-light mb-6">
                A preservação viva das tradições dos pioneiros e a herança do maior colégio eleitoral nipônico proporcional do Brasil.
            </p>
        </div>
    </div>
</section>

{{-- ===== CULTURA JAPONESA ===== --}}
<section class="py-16 md:py-24 bg-slate-900 relative overflow-hidden w-full max-w-full">
    {{-- Detalhe de Fundo --}}
    <div class="absolute top-0 right-0 -mr-20 -mt-20 w-96 h-96 bg-blue-600/20 rounded-full blur-[100px] pointer-events-none"></div>
    <div class="absolute bottom-0 left-0 -ml-20 -mb-20 w-80 h-80 bg-red-600/10 rounded-full blur-[100px] pointer-events-none"></div>

    <div class="container relative z-10 px-4 sm:px-6 md:px-8 mx-auto max-w-6xl w-full">
        <div class="grid items-center grid-cols-1 gap-12 lg:grid-cols-2 w-full">
            
            {{-- Texto e Festivais --}}
            <div class="space-y-6 text-white">
                <div class="inline-flex items-center gap-2">
                    <span class="w-8 h-1 bg-yellow-400 rounded-full"></span>
                    <span class="text-yellow-400 font-bold tracking-widest uppercase text-xs">Tradição Viva</span>
                </div>
                
                <h2 class="text-3xl font-extrabold font-heading md:text-4xl leading-tight text-white" style="font-family: 'Montserrat', sans-serif;">
                    O Coração <span class="text-yellow-400">Japonês</span> do Paraná
                </h2>
                
                <p class="text-slate-300 text-base md:text-lg leading-relaxed font-light">
                    A cultura nipônica não está apenas no nome de Assaí — ela pulsa nas ruas arborizadas com <strong>Sakura (cerejeiras)</strong>, na arquitetura do imponente <strong>Castelo Japonês</strong> e no rico calendário de festividades que atrai visitantes de todo o estado ao longo do ano.
                </p>

                {{-- Grelha de Festivais --}}
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 pt-6">
                    @php
                    $festas = [
                        ['nome' => 'Tanabata Matsuri', 'desc' => 'Festival das Estrelas (Julho)', 'icon' => 'fa-star', 'color' => 'text-amber-500'],
                        ['nome' => 'Bon Odori', 'desc' => 'Dança tradicional (Agosto)', 'icon' => 'fa-music', 'color' => 'text-blue-500'],
                        ['nome' => 'Tenrankai', 'desc' => 'Exposição de Artes (Novembro)', 'icon' => 'fa-palette', 'color' => 'text-pink-500'],
                        ['nome' => 'Expoasa', 'desc' => 'Expo Agrícola (Junho)', 'icon' => 'fa-seedling', 'color' => 'text-emerald-500'],
                    ];
                    @endphp
                    
                    @foreach($festas as $festa)
                    <div class="flex items-start gap-4 p-4 rounded-2xl bg-white/5 border border-white/10 hover:bg-white/10 transition-colors backdrop-blur-sm group">
                        <div class="w-10 h-10 shrink-0 rounded-full bg-white/10 flex items-center justify-center {{ $festa['color'] }} group-hover:scale-110 transition-transform">
                            <i class="fa-solid {{ $festa['icon'] }} text-lg"></i>
                        </div>
                        <div>
                            <h3 class="font-bold text-base text-white leading-tight mb-1">{{ $festa['nome'] }}</h3>
                            <p class="text-xs text-slate-400">{{ $festa['desc'] }}</p>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>

            {{-- Destaques Visuais (Cards à direita) --}}
            <div class="grid grid-cols-2 gap-4 lg:gap-6 mt-4 lg:mt-0">
                <div class="rounded-[2rem] overflow-hidden shadow-2xl aspect-[4/5] bg-gradient-to-br from-[#006eb7] to-blue-900 flex flex-col items-center justify-center p-6 text-center border border-white/10 relative group">
                    <div class="absolute inset-0 bg-[url('https://www.transparenttextures.com/patterns/cubes.png')] opacity-10 mix-blend-overlay"></div>
                    <i class="fa-solid fa-vihara text-6xl md:text-7xl text-white/90 mb-6 group-hover:scale-110 transition-transform duration-500 relative z-10"></i>
                    <h3 class="font-extrabold text-white text-lg md:text-xl font-heading relative z-10">Castelo<br>Japonês</h3>
                </div>
                
                <div class="rounded-[2rem] overflow-hidden shadow-2xl aspect-[4/5] bg-gradient-to-br from-pink-600 to-rose-800 flex flex-col items-center justify-center p-6 text-center border border-white/10 relative group mt-8">
                    <div class="absolute inset-0 bg-[url('https://www.transparenttextures.com/patterns/cubes.png')] opacity-10 mix-blend-overlay"></div>
                    <i class="fa-solid fa-spa text-6xl md:text-7xl text-white/90 mb-6 group-hover:scale-110 transition-transform duration-500 relative z-10"></i>
                    <h3 class="font-extrabold text-white text-lg md:text-xl font-heading relative z-10">Cerejeiras<br>(Sakura)</h3>
                </div>
            </div>

        </div>
    </div>
</section>

{{-- ===== MEMORIAL DA IMIGRAÇÃO (CASTELO JAPONÊS) ===== --}}
<section class="py-16 md:py-24 bg-white w-full max-w-full overflow-x-hidden">
    <div class="container px-4 sm:px-6 md:px-8 mx-auto max-w-6xl w-full">
        
        <div class="text-center mb-16">
            <h2 class="text-3xl font-black text-slate-800 md:text-4xl font-heading" style="font-family: 'Montserrat', sans-serif;">Memorial da Imigração Japonesa</h2>
            <p class="text-slate-500 max-w-2xl mx-auto mt-4 text-lg">O maior símbolo arquitetônico da imigração nipônica na região sul do país.</p>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 lg:gap-16 items-center">
            
            {{-- Imagem do Castelo --}}
            <div class="relative group order-2 lg:order-1">
                <div class="overflow-hidden rounded-[2rem] bg-slate-100 relative aspect-[4/3] w-full shadow-lg border border-slate-200 flex items-center justify-center">
                    {{-- Placeholder amigável caso não tenha a imagem exata do castelo ainda --}}
                    <img src="{{ asset('img/Assai.jpg') }}" alt="Castelo Japonês de Assaí" class="object-cover w-full h-full transition duration-700 group-hover:scale-105" loading="lazy">
                    <div class="absolute inset-0 bg-black/10 group-hover:bg-transparent transition-colors duration-500"></div>
                </div>
                {{-- Placa Flutuante --}}
                <div class="absolute -bottom-6 -right-2 sm:-right-6 p-5 sm:p-6 shadow-xl bg-white border border-slate-100 rounded-3xl flex items-center gap-4">
                    <div class="w-12 h-12 bg-blue-50 text-[#006eb7] rounded-full flex items-center justify-center text-xl shrink-0">
                        <i class="fa-solid fa-map-location-dot"></i>
                    </div>
                    <div>
                        <p class="text-xs font-bold text-slate-400 uppercase tracking-wider mb-0.5">Ponto Turístico</p>
                        <p class="font-extrabold text-slate-800">Castelo de Assaí</p>
                    </div>
                </div>
            </div>

            {{-- Texto Informativo --}}
            <div class="space-y-6 text-slate-700 text-[15px] leading-relaxed order-1 lg:order-2">
                <div class="prose prose-slate prose-lg max-w-none prose-p:leading-relaxed prose-strong:text-slate-800">
                    <p>Erguido com um investimento de R$ 3 milhões, a estrutura majestosa possui <strong>25 metros de altura</strong> e sua arquitetura foi diretamente inspirada no histórico <strong>Castelo de Himeji</strong>, localizado na província de Hyōgo, no Japão.</p>
                    <p>O edifício é totalmente acessível, equipado com elevadores panorâmicos, e funciona como um núcleo cultural vivo. Em seu interior, o memorial abriga exposições permanentes que recontam o ciclo do <strong>café e do algodão</strong> (a "Era do Ouro Branco"), além de apresentar o famoso <strong>Mosaico de Arroz</strong>.</p>
                </div>

                {{-- Box de Informações --}}
                <div class="bg-blue-50 border-l-4 border-[#006eb7] p-6 rounded-r-2xl mt-8">
                    <h3 class="font-extrabold text-blue-900 mb-4 flex items-center gap-2">
                        <i class="fa-solid fa-circle-info text-[#006eb7]"></i> Informações de Visitação
                    </h3>
                    <ul class="space-y-3 text-sm text-blue-900/80">
                        <li class="flex items-start gap-3">
                            <i class="fa-solid fa-location-dot mt-1 shrink-0 text-[#006eb7]"></i>
                            <span><strong>Localização:</strong> Rua Presidente Kennedy, 480 - Assaí/PR.</span>
                        </li>
                        <li class="flex items-start gap-3">
                            <i class="fa-solid fa-calendar-day mt-1 shrink-0 text-[#006eb7]"></i>
                            <span><strong>Atividades:</strong> Visitas guiadas, contação de histórias via <em>Kamishibai</em> (teatro de papel japonês) e exposições históricas.</span>
                        </li>
                        <li class="flex items-start gap-3">
                            <i class="fa-solid fa-ticket mt-1 shrink-0 text-[#006eb7]"></i>
                            <span><strong>Acesso:</strong> Gratuito ao público em geral.</span>
                        </li>
                    </ul>
                </div>
            </div>

        </div>
    </div>
</section>

@endsection