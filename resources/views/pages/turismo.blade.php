@extends('layouts.app')

@section('title', 'Visite Assaí - Portal de Turismo Municipal')

@section('content')

<style>
    html { scroll-behavior: smooth; }
    .hide-scrollbar::-webkit-scrollbar { display: none; }
    .hide-scrollbar { -ms-overflow-style: none; scrollbar-width: none; }
</style>

{{-- ===== 1. HERO IMMERSIVO ===== --}}
<section class="relative pt-24 pb-32 md:pt-32 md:pb-48 lg:pt-40 lg:pb-56 overflow-hidden bg-slate-900">
    <img src="{{ asset('img/hero_assai.jpg') }}" alt="Vista panorâmica de Assaí" class="absolute inset-0 w-full h-full object-cover opacity-40" loading="lazy">
    <div class="absolute inset-0 bg-gradient-to-b from-blue-950/80 via-blue-900/40 to-slate-50"></div>

    <div class="container relative z-10 px-4 mx-auto text-center max-w-5xl">
        <x-breadcrumb :items="[
            ['name' => 'Início', 'url' => route('home')],
            ['name' => 'Turismo'],
        ]" dark />
        
        <span class="inline-flex items-center gap-2 px-5 py-2 mb-6 text-xs font-bold tracking-widest text-blue-900 uppercase bg-yellow-400 rounded-full shadow-lg">
            Destino Norte do Paraná
        </span>
        <h1 class="text-5xl font-extrabold text-white md:text-7xl font-heading tracking-tight mb-6 drop-shadow-lg">
            Visite <span class="text-yellow-400">Assaí</span>
        </h1>
        <p class="max-w-3xl mx-auto text-lg text-white/90 md:text-2xl leading-relaxed font-light drop-shadow">
            Natureza, tranquilidade e o maior polo da autêntica cultura nipônica no Paraná. Descubra uma cidade onde a tradição e o acolhimento se encontram.
        </p>
    </div>
</section>

{{-- ===== 2. MENU RÁPIDO DE EXPERIÊNCIAS (Overlapping Hero) ===== --}}
<section class="relative z-20 -mt-20 md:-mt-24 mb-16">
    <div class="container px-4 mx-auto max-w-6xl">
        <div class="grid grid-cols-2 md:grid-cols-4 gap-4 shadow-2xl bg-white p-3 rounded-3xl border border-slate-100">
            <a href="#o-que-fazer" class="flex flex-col items-center justify-center gap-3 p-6 bg-slate-50 rounded-2xl hover:bg-blue-50 hover:-translate-y-1 transition-all duration-300 group text-center border border-transparent hover:border-blue-100">
                <span class="text-3xl lg:text-4xl group-hover:scale-110 transition-transform">🏯</span>
                <span class="text-xs lg:text-sm font-extrabold text-slate-700 uppercase tracking-wide group-hover:text-blue-700">O Que Fazer</span>
            </a>
            <a href="#gastronomia" class="flex flex-col items-center justify-center gap-3 p-6 bg-slate-50 rounded-2xl hover:bg-emerald-50 hover:-translate-y-1 transition-all duration-300 group text-center border border-transparent hover:border-emerald-100">
                <span class="text-3xl lg:text-4xl group-hover:scale-110 transition-transform">🍣</span>
                <span class="text-xs lg:text-sm font-extrabold text-slate-700 uppercase tracking-wide group-hover:text-emerald-700">Gastronomia</span>
            </a>
            <a href="#hospedagem" class="flex flex-col items-center justify-center gap-3 p-6 bg-slate-50 rounded-2xl hover:bg-amber-50 hover:-translate-y-1 transition-all duration-300 group text-center border border-transparent hover:border-amber-100">
                <span class="text-3xl lg:text-4xl group-hover:scale-110 transition-transform">🛌</span>
                <span class="text-xs lg:text-sm font-extrabold text-slate-700 uppercase tracking-wide group-hover:text-amber-700">Onde Ficar</span>
            </a>
            <a href="#eventos" class="flex flex-col items-center justify-center gap-3 p-6 bg-slate-50 rounded-2xl hover:bg-pink-50 hover:-translate-y-1 transition-all duration-300 group text-center border border-transparent hover:border-pink-100">
                <span class="text-3xl lg:text-4xl group-hover:scale-110 transition-transform">🎋</span>
                <span class="text-xs lg:text-sm font-extrabold text-slate-700 uppercase tracking-wide group-hover:text-pink-700">Eventos</span>
            </a>
        </div>
    </div>
</section>

{{-- ===== 3. O QUE FAZER (Atrativos & Passeios) ===== --}}
<section id="o-que-fazer" class="py-16 bg-slate-50">
    <div class="container px-4 mx-auto max-w-6xl">
        <div class="flex flex-col md:flex-row justify-between items-end mb-12 gap-6">
            <div>
                <span class="text-blue-600 font-bold tracking-widest uppercase text-xs mb-2 block">Passeios e Cultura</span>
                <h2 class="text-3xl font-extrabold text-slate-900 font-heading md:text-5xl">O Que Fazer</h2>
            </div>
            <p class="text-slate-600 max-w-lg md:text-right">Explore monumentos históricos, parques arborizados e mergulhe na rica herança dos pioneiros de Assailand.</p>
        </div>

        {{-- Destaque Principal --}}
        <div class="mb-8 rounded-3xl overflow-hidden bg-white shadow-lg border border-slate-200 group flex flex-col lg:flex-row">
            <div class="lg:w-7/12 relative min-h-[300px] overflow-hidden">
                <img src="{{ asset('img/assai_1.jpg') }}" alt="Castelo Japonês" class="absolute inset-0 w-full h-full object-cover transition duration-1000 group-hover:scale-105">
                <div class="absolute top-4 left-4 bg-yellow-400 text-blue-900 font-bold text-xs uppercase px-3 py-1 rounded-full">Cartão Postal</div>
            </div>
            <div class="lg:w-5/12 p-8 lg:p-12 flex flex-col justify-center">
                <h3 class="text-3xl font-extrabold text-slate-900 font-heading mb-4">Castelo Japonês</h3>
                <p class="text-slate-600 mb-6 leading-relaxed">Único no Brasil, o Castelo Japonês é um majestoso Memorial da Imigração. Com 25 metros de altura e inspirado no Castelo de Himeji, oferece uma vista panorâmica de 360° e um museu histórico fascinante.</p>
                <ul class="space-y-3 mb-8">
                    <li class="flex items-center gap-3 text-sm font-bold text-slate-700"><i class="fa-solid fa-check text-emerald-500"></i> Entrada Gratuita</li>
                    <li class="flex items-center gap-3 text-sm font-bold text-slate-700"><i class="fa-solid fa-check text-emerald-500"></i> Museu e Cultura</li>
                    <li class="flex items-center gap-3 text-sm font-bold text-slate-700"><i class="fa-solid fa-check text-emerald-500"></i> Ponto mais alto de Assaí</li>
                </ul>
            </div>
        </div>

        {{-- Grid Secundário --}}
        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
            <div class="rounded-3xl overflow-hidden bg-white shadow-md border border-slate-200 group">
                <div class="relative h-64 overflow-hidden">
                    <img src="{{ asset('img/assai_2.JPG') }}" alt="Parque Ikeda" class="w-full h-full object-cover transition duration-1000 group-hover:scale-105">
                    <div class="absolute top-4 left-4 bg-emerald-100 text-emerald-800 font-bold text-xs uppercase px-3 py-1 rounded-full">Natureza</div>
                </div>
                <div class="p-8">
                    <h4 class="text-2xl font-extrabold text-slate-900 font-heading mb-3">Parque Ikeda</h4>
                    <p class="text-slate-600 leading-relaxed">Um oásis verde de 27 mil m² no coração da cidade. Com seu icônico portal Torii e um belo lago, é o cenário ideal para caminhadas, piqueniques e momentos em família ao ar livre.</p>
                </div>
            </div>

            <div class="rounded-3xl overflow-hidden bg-white shadow-md border border-slate-200 group">
                <div class="relative h-64 overflow-hidden">
                    <img src="{{ asset('img/assai_3.JPG') }}" alt="Templo Shoshinji" class="w-full h-full object-cover transition duration-1000 group-hover:scale-105">
                    <div class="absolute top-4 left-4 bg-indigo-100 text-indigo-800 font-bold text-xs uppercase px-3 py-1 rounded-full">Tradição</div>
                </div>
                <div class="p-8">
                    <h4 class="text-2xl font-extrabold text-slate-900 font-heading mb-3">Templo Shoshinji</h4>
                    <p class="text-slate-600 leading-relaxed">O templo budista em atividade mais antigo do Paraná. Construído em 1948 com arquitetura original em madeira, é um refúgio de paz, silêncio e meditação.</p>
                </div>
            </div>
        </div>
    </div>
</section>

{{-- ===== 4. GASTRONOMIA ===== --}}
<section id="gastronomia" class="py-20 bg-blue-950 relative overflow-hidden">
    <div class="absolute inset-0 opacity-[0.03] bg-[url('data:image/svg+xml;base64,PHN2ZyB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciIHdpZHRoPSIyMCIgaGVpZ2h0PSIyMCI+PGNpcmNsZSBjeD0iMiIgY3k9IjIiIHI9IjIiIGZpbGw9IiNmZmYiLz48L3N2Zz4=')]"></div>
    <div class="container relative z-10 px-4 mx-auto max-w-6xl">
        <div class="flex flex-col lg:flex-row items-center gap-16">
            <div class="lg:w-1/2 space-y-6">
                <span class="text-yellow-400 font-bold tracking-widest uppercase text-xs">Culinária Local</span>
                <h2 class="text-4xl font-extrabold text-white font-heading md:text-5xl leading-tight">Sabores<br>Inesquecíveis</h2>
                <p class="text-blue-100 text-lg leading-relaxed">Da cozinha caipira do interior paranaense à mais autêntica culinária nipônica. Assaí é um verdadeiro Polo Gastronômico preparado para surpreender paladares.</p>
                
                <div class="grid grid-cols-2 gap-4 pt-6">
                    <div class="bg-blue-900/50 p-5 rounded-2xl border border-blue-800/50">
                        <span class="text-3xl mb-2 block">🍣</span>
                        <h4 class="text-white font-bold mb-1">Cozinha Japonesa</h4>
                        <p class="text-blue-200 text-xs">Receitas familiares originais e ingredientes frescos.</p>
                    </div>
                    <div class="bg-blue-900/50 p-5 rounded-2xl border border-blue-800/50">
                        <span class="text-3xl mb-2 block">🧀</span>
                        <h4 class="text-white font-bold mb-1">Empórios</h4>
                        <p class="text-blue-200 text-xs">Queijos, doces caseiros e produtos do campo.</p>
                    </div>
                    <div class="bg-blue-900/50 p-5 rounded-2xl border border-blue-800/50">
                        <span class="text-3xl mb-2 block">☕</span>
                        <h4 class="text-white font-bold mb-1">Cafés Coloniais</h4>
                        <p class="text-blue-200 text-xs">Bolos e pães servidos no clima da fazenda.</p>
                    </div>
                    <div class="bg-blue-900/50 p-5 rounded-2xl border border-blue-800/50">
                        <span class="text-3xl mb-2 block">🍢</span>
                        <h4 class="text-white font-bold mb-1">Comida de Rua</h4>
                        <p class="text-blue-200 text-xs">Feiras noturnas com Yakitori e lanches artesanais.</p>
                    </div>
                </div>
            </div>
            <div class="lg:w-1/2">
                <div class="grid grid-cols-2 gap-4">
                    <img src="{{ asset('img/sushi_placeholder.jpg') }}" alt="Gastronomia" class="rounded-3xl w-full h-64 object-cover mt-8" loading="lazy">
                    <img src="{{ asset('img/cafe_placeholder.jpg') }}" alt="Café" class="rounded-3xl w-full h-80 object-cover" loading="lazy">
                </div>
            </div>
        </div>
    </div>
</section>

{{-- ===== 5. ONDE FICAR (Hospedagem) ===== --}}
<section id="hospedagem" class="py-20 bg-white">
    <div class="container px-4 mx-auto max-w-6xl text-center">
        <span class="text-amber-600 font-bold tracking-widest uppercase text-xs mb-2 block">Hospedagem</span>
        <h2 class="text-3xl font-extrabold text-slate-900 font-heading md:text-5xl mb-6">Onde Ficar</h2>
        <p class="text-slate-600 max-w-2xl mx-auto mb-12">Descanse nas montanhas e planícies do Norte Pioneiro. Assaí oferece infraestrutura acolhedora, desde hotéis no centro comercial a pousadas mais afastadas para relaxamento.</p>

        <div class="grid grid-cols-1 sm:grid-cols-3 gap-6">
            <div class="bg-amber-50 rounded-3xl p-8 border border-amber-100 hover:-translate-y-1 transition duration-300">
                <span class="text-4xl mb-4 block">🏨</span>
                <h3 class="text-xl font-bold text-slate-800 mb-2">Hotéis Centrais</h3>
                <p class="text-sm text-slate-600">Praticidade e conforto perto de restaurantes, praças e comércio local.</p>
            </div>
            <div class="bg-emerald-50 rounded-3xl p-8 border border-emerald-100 hover:-translate-y-1 transition duration-300">
                <span class="text-4xl mb-4 block">🏡</span>
                <h3 class="text-xl font-bold text-slate-800 mb-2">Pousadas</h3>
                <p class="text-sm text-slate-600">Ambiente familiar e acolhimento tipicamente interiorano para relaxar.</p>
            </div>
            <div class="bg-blue-50 rounded-3xl p-8 border border-blue-100 hover:-translate-y-1 transition duration-300">
                <span class="text-4xl mb-4 block">🌳</span>
                <h3 class="text-xl font-bold text-slate-800 mb-2">Turismo Rural</h3>
                <p class="text-sm text-slate-600">Estadias em fazendas para acordar com o canto dos pássaros e ar puro.</p>
            </div>
        </div>
    </div>
</section>

{{-- ===== 6. EVENTOS ===== --}}
<section id="eventos" class="py-20 bg-slate-50 border-t border-slate-200">
    <div class="container px-4 mx-auto max-w-6xl">
        <div class="flex flex-col md:flex-row justify-between items-center mb-12">
            <div>
                <span class="text-pink-600 font-bold tracking-widest uppercase text-xs mb-2 block">Calendário Municipal</span>
                <h2 class="text-3xl font-extrabold text-slate-900 font-heading md:text-5xl">Eventos Culturais</h2>
            </div>
            <a href="{{ route('agenda.index') }}" class="mt-6 md:mt-0 px-6 py-3 bg-white border-2 border-slate-200 text-slate-700 font-bold rounded-full hover:border-slate-300 hover:bg-slate-100 transition">
                Ver Agenda Completa
            </a>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            {{-- ExpoAsa --}}
            <div class="bg-white rounded-3xl overflow-hidden shadow-sm border border-slate-200 group">
                <div class="h-48 bg-yellow-100 flex items-center justify-center text-6xl group-hover:scale-105 transition duration-500">🌾</div>
                <div class="p-6">
                    <span class="text-xs font-bold text-slate-400 uppercase tracking-wider block mb-1">Junho</span>
                    <h3 class="text-xl font-extrabold text-slate-800 font-heading mb-2">ExpoAsa</h3>
                    <p class="text-sm text-slate-600">A exposição agropecuária mais antiga do Brasil (desde 1943). Rodeios, shows, agronegócio e gastronomia.</p>
                </div>
            </div>

            {{-- Tanabata --}}
            <div class="bg-white rounded-3xl overflow-hidden shadow-sm border border-slate-200 group">
                <div class="h-48 bg-blue-100 flex items-center justify-center text-6xl group-hover:scale-105 transition duration-500">🎋</div>
                <div class="p-6">
                    <span class="text-xs font-bold text-slate-400 uppercase tracking-wider block mb-1">Outubro</span>
                    <h3 class="text-xl font-extrabold text-slate-800 font-heading mb-2">Tanabata Matsuri</h3>
                    <p class="text-sm text-slate-600">A primeira festa das estrelas do país. Registre seus desejos em Tanzaku e celebre com danças típicas e yukatas.</p>
                </div>
            </div>

            {{-- Bon Odori --}}
            <div class="bg-white rounded-3xl overflow-hidden shadow-sm border border-slate-200 group">
                <div class="h-48 bg-pink-100 flex items-center justify-center text-6xl group-hover:scale-105 transition duration-500">🥁</div>
                <div class="p-6">
                    <span class="text-xs font-bold text-slate-400 uppercase tracking-wider block mb-1">Agosto / Novembro</span>
                    <h3 class="text-xl font-extrabold text-slate-800 font-heading mb-2">Bon Odori</h3>
                    <p class="text-sm text-slate-600">Dança sagrada em gratidão aos antepassados. O som dos tambores Taiko atrai turistas de todo o estado.</p>
                </div>
            </div>
        </div>
    </div>
</section>

{{-- ===== CTA FINAL ===== --}}
<section class="py-24 bg-blue-900 text-center text-white relative">
    <div class="container px-4 mx-auto max-w-3xl relative z-10">
        <h2 class="text-4xl md:text-5xl font-extrabold font-heading mb-6 text-white">Monte seu roteiro!</h2>
        <p class="text-blue-100 text-lg mb-10">Assaí é um destino completo. Sinta o aconchego do interior, o sabor da tradição e a energia da nossa história.</p>
        <a href="{{ route('pages.contato') }}" class="inline-block px-8 py-4 bg-yellow-400 text-blue-900 font-extrabold rounded-full hover:bg-yellow-300 hover:scale-105 transition-all shadow-xl">
            Fale com a Central de Turismo
        </a>
    </div>
</section>

@endsection