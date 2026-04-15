@extends('layouts.app')
@section('title', 'Nossa Cultura - Prefeitura Municipal de Assaí')

@section('content')
<style> body, html { overflow-x: hidden !important; } </style>

<section class="relative pt-[calc(var(--site-header-height,72px)+1.5rem)] pb-16 md:pt-[calc(var(--site-header-height,72px)+3.5rem)] md:pb-24 overflow-hidden bg-blue-900 w-full max-w-full">
    <div class="container relative z-10 px-4 sm:px-6 md:px-8 mx-auto text-left max-w-5xl w-full overflow-x-hidden">
        <div class="relative z-20">
            <x-breadcrumb :items="[
                ['name' => 'Início', 'url' => route('home')],
                ['name' => 'A Cidade'],
                ['name' => 'Nossa Cultura']
            ]" dark />
        </div>
        <h1 class="text-3xl sm:text-4xl md:text-5xl font-extrabold font-heading mb-5 text-white drop-shadow-sm leading-none" style="font-family: 'Montserrat', sans-serif;">
            Nossa <span class="text-yellow-400">Cultura</span>
        </h1>
        <p class="max-w-3xl text-base sm:text-lg md:text-xl lg:text-2xl text-blue-100 leading-relaxed font-light mb-6">
            A preservação viva das tradições dos pioneiros e a herança do maior colégio eleitoral nipônico proporcional do Brasil.
        </p>
    </div>
</section>

{{-- ===== CULTURA JAPONESA ===== --}}
<section class="py-12 sm:py-14 md:py-20 lg:py-28 bg-blue-950 relative overflow-hidden w-full max-w-full">
    <div class="container relative z-10 px-4 sm:px-6 md:px-8 mx-auto max-w-6xl w-full overflow-x-hidden">
        <div class="grid items-center grid-cols-1 gap-10 md:grid-cols-2 w-full">
            <div class="space-y-5 text-white">
                <span class="inline-block text-blue-900 font-bold tracking-wider uppercase text-xs border border-yellow-500 bg-yellow-400 px-3 py-1 rounded-full">Tradição Viva</span>
                <h2 class="text-3xl font-extrabold font-heading md:text-4xl leading-tight text-white">
                    O Coração <span class="text-yellow-300">Japonês</span> do Paraná
                </h2>
                <p class="text-white text-[15px] md:text-base leading-7 md:leading-relaxed">A cultura nipônica não está apenas no nome de Assaí — ela pulsa nas ruas arborizadas com <strong>Sakura (cerejeiras)</strong> e Ipês, na arquitetura do imponente <strong>Castelo Japonês (Memorial da Imigração Japonesa)</strong> e no calendário de festividades ao longo do ano.</p>
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
            </div>
            <div class="grid grid-cols-2 gap-4 mt-8 w-full">
                <div class="rounded-2xl overflow-hidden shadow-lg aspect-square bg-blue-800 flex flex-col items-center justify-center p-8 text-center border border-blue-700">
                    <span class="text-6xl mb-4">🏯</span><p class="font-extrabold text-white text-sm">Castelo Japonês</p>
                </div>
                <div class="rounded-2xl overflow-hidden shadow-lg aspect-square bg-pink-600 flex flex-col items-center justify-center p-8 text-center border border-pink-700">
                    <span class="text-6xl mb-4">🌸</span><p class="font-extrabold text-white text-sm">Sakura</p>
                </div>
            </div>
        </div>
    </div>
</section>

{{-- ===== MEMORIAL DA IMIGRAÇÃO (CASTELO JAPONÊS) ===== --}}
<section class="py-12 md:py-20 bg-white w-full max-w-full overflow-x-hidden border-t border-slate-200">
    <div class="container px-4 sm:px-6 md:px-8 mx-auto max-w-6xl w-full">
        <h2 class="text-3xl font-extrabold text-slate-800 font-heading mb-8 text-center">Memorial da Imigração Japonesa</h2>
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-10 items-center">
            <div class="space-y-6 text-slate-700 text-[15px] leading-relaxed">
                <p>O <strong>Castelo Japonês de Assaí</strong> é o maior símbolo arquitetônico da imigração nipônica na região. Erguido com um investimento de R$ 3 milhões, a estrutura possui <strong>25 metros de altura</strong> e sua arquitetura foi diretamente inspirada no histórico <strong>Castelo de Himeji</strong>, localizado na província de Hyōgo, no Japão.</p>
                <p>O edifício é totalmente acessível, equipado com elevadores, e funciona como um núcleo cultural vivo. Em seu interior, o memorial abriga exposições permanentes sobre o ciclo do <strong>café e do algodão</strong> ("Era do Ouro Branco"), além do famoso <strong>Mosaico de Arroz</strong>.</p>
                <div class="p-5 bg-blue-50 border border-blue-100 rounded-xl mt-4">
                    <h3 class="font-bold text-blue-900 mb-2">Informações de Visitação</h3>
                    <ul class="list-disc list-inside space-y-1 text-sm text-blue-800">
                        <li><strong>Localização:</strong> Rua Presidente Kennedy, 480.</li>
                        <li><strong>Atividades:</strong> Contação de histórias via <em>Kamishibai</em> (teatro de papel japonês), exposições históricas.</li>
                        <li><strong>Acesso:</strong> Gratuito ao público em geral.</li>
                    </ul>
                </div>
            </div>
            <div class="relative rounded-3xl overflow-hidden shadow-xl aspect-square lg:aspect-auto lg:h-full min-h-[300px] bg-slate-200">
                <div class="absolute inset-0 flex items-center justify-center text-slate-400 font-bold">
                    [Imagem do Castelo Japonês: Inserir via asset('img/castelo.jpg')]
                </div>
            </div>
        </div>
    </div>
</section>

<section class="py-12 bg-gradient-to-br from-blue-900 to-indigo-900 text-center"><div class="container mx-auto"><h2 class="text-4xl font-extrabold text-white">Nossa Herança Viva</h2></div></section>
@endsection