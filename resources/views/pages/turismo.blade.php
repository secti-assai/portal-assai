@extends('layouts.app')

@section('title', 'Turismo - Prefeitura Municipal de Assaí')

@section('content')

<style>
    html { scroll-behavior: smooth; }
    .hide-scrollbar::-webkit-scrollbar { display: none; }
    .hide-scrollbar { -ms-overflow-style: none; scrollbar-width: none; }
</style>

{{-- ===== 1. HERO IMMERSIVO (Estilo Monte Verde) ===== --}}
<section class="relative h-[75vh] min-h-[600px] flex items-center justify-center overflow-hidden bg-slate-900">
    <img src="{{ asset('img/hero_assai.jpg') }}" alt="Vista panorâmica de Assaí" class="absolute inset-0 w-full h-full object-cover opacity-50" loading="lazy">
    <div class="absolute inset-0 bg-gradient-to-b from-blue-950/80 via-blue-900/40 to-transparent"></div>

    <div class="container relative z-10 px-4 mx-auto text-center max-w-4xl mt-10">
        <span class="inline-block px-5 py-1.5 mb-6 text-[11px] font-extrabold tracking-[0.2em] text-blue-900 uppercase bg-yellow-400 rounded-full shadow-lg">
            Norte Pioneiro do Paraná
        </span>
        <h1 class="text-5xl md:text-7xl font-black text-white font-heading tracking-tight mb-6 drop-shadow-lg leading-tight">
            Descubra o encanto de<br><span class="text-yellow-400">Assaí</span>
        </h1>
        <p class="max-w-2xl mx-auto text-lg md:text-xl text-white/90 leading-relaxed font-light drop-shadow-md">
            Tradição da imigração japonesa, natureza exuberante e a gastronomia nipônica mais autêntica do estado.
        </p>
    </div>
</section>

{{-- ===== 2. MENU FLUTUANTE (Overlapping Hero) ===== --}}
<section class="relative z-20 -mt-20 md:-mt-24 mb-16 lg:mb-24">
    <div class="container px-4 mx-auto max-w-5xl">
        <div class="grid grid-cols-2 md:grid-cols-4 gap-3 md:gap-5 bg-white p-4 md:p-5 rounded-[2rem] shadow-[0_20px_50px_-10px_rgba(0,0,0,0.15)] border border-slate-100">
            <a href="#o-que-fazer" class="flex flex-col items-center justify-center gap-3 md:gap-4 p-6 md:p-8 bg-slate-50 rounded-2xl hover:bg-blue-50 hover:-translate-y-1 transition-all duration-300 group border border-transparent hover:border-blue-100">
                <span class="text-4xl group-hover:scale-110 transition-transform duration-300 drop-shadow-sm">🏯</span>
                <span class="text-xs md:text-sm font-extrabold text-slate-700 uppercase tracking-widest group-hover:text-blue-700 text-center">O Que Fazer</span>
            </a>
            <a href="#gastronomia" class="flex flex-col items-center justify-center gap-3 md:gap-4 p-6 md:p-8 bg-slate-50 rounded-2xl hover:bg-emerald-50 hover:-translate-y-1 transition-all duration-300 group border border-transparent hover:border-emerald-100">
                <span class="text-4xl group-hover:scale-110 transition-transform duration-300 drop-shadow-sm">🍣</span>
                <span class="text-xs md:text-sm font-extrabold text-slate-700 uppercase tracking-widest group-hover:text-emerald-700 text-center">Gastronomia</span>
            </a>
            <a href="#onde-ficar" class="flex flex-col items-center justify-center gap-3 md:gap-4 p-6 md:p-8 bg-slate-50 rounded-2xl hover:bg-amber-50 hover:-translate-y-1 transition-all duration-300 group border border-transparent hover:border-amber-100">
                <span class="text-4xl group-hover:scale-110 transition-transform duration-300 drop-shadow-sm">🛌</span>
                <span class="text-xs md:text-sm font-extrabold text-slate-700 uppercase tracking-widest group-hover:text-amber-700 text-center">Onde Ficar</span>
            </a>
            <a href="#eventos" class="flex flex-col items-center justify-center gap-3 md:gap-4 p-6 md:p-8 bg-slate-50 rounded-2xl hover:bg-pink-50 hover:-translate-y-1 transition-all duration-300 group border border-transparent hover:border-pink-100">
                <span class="text-4xl group-hover:scale-110 transition-transform duration-300 drop-shadow-sm">🎋</span>
                <span class="text-xs md:text-sm font-extrabold text-slate-700 uppercase tracking-widest group-hover:text-pink-700 text-center">Eventos</span>
            </a>
        </div>
    </div>
</section>

{{-- ===== 3. O QUE FAZER (Grid Assimétrico Estilo MV) ===== --}}
<section id="o-que-fazer" class="py-16 md:py-24 bg-slate-50">
    <div class="container px-4 mx-auto max-w-6xl">
        <div class="mb-12 border-l-4 border-blue-700 pl-5">
            <span class="text-blue-700 font-extrabold tracking-[0.2em] uppercase text-[11px]">Passeios e Aventura</span>
            <h2 class="text-3xl font-black text-slate-900 md:text-4xl mt-1">O Que Fazer</h2>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-12 gap-6">
            {{-- Destaque Principal (Esquerda - 2/3) --}}
            <article class="lg:col-span-8 group relative overflow-hidden rounded-[2rem] shadow-lg border border-slate-200 cursor-pointer min-h-[450px] lg:min-h-[550px]">
                <img src="{{ asset('img/assai_1.jpg') }}" alt="Castelo Japonês" class="absolute inset-0 w-full h-full object-cover transition-transform duration-1000 group-hover:scale-105">
                <div class="absolute inset-0 bg-gradient-to-t from-black/90 via-black/40 to-transparent"></div>
                <div class="absolute bottom-0 left-0 right-0 p-8 md:p-10">
                    <span class="bg-yellow-400 text-blue-900 text-[10px] font-black uppercase tracking-widest px-3 py-1 rounded-md mb-3 inline-block">Monumento</span>
                    <h3 class="text-3xl md:text-4xl font-black text-white mb-3 font-heading leading-tight">Castelo Japonês<br>(Memorial da Imigração)</h3>
                    <p class="text-slate-200 text-sm md:text-base max-w-xl line-clamp-2 md:line-clamp-none font-light">Primeiro castelo nipônico do país, com 25 metros de altura e 4 pavimentos. Inspirado no Castelo de Himeji, abriga exposições históricas e oferece vista panorâmica de 360° da cidade.</p>
                </div>
            </article>

            {{-- Menores (Direita - 1/3 Empilhados) --}}
            <div class="lg:col-span-4 flex flex-col gap-6">
                {{-- Parque Ikeda --}}
                <article class="flex-1 group relative overflow-hidden rounded-[2rem] shadow-lg border border-slate-200 cursor-pointer min-h-[250px]">
                    <img src="{{ asset('img/assai_2.JPG') }}" alt="Parque Ikeda" class="absolute inset-0 w-full h-full object-cover transition-transform duration-1000 group-hover:scale-105">
                    <div class="absolute inset-0 bg-gradient-to-t from-black/90 via-black/30 to-transparent"></div>
                    <div class="absolute bottom-0 left-0 p-6 right-0">
                        <span class="bg-emerald-500 text-white text-[10px] font-black uppercase tracking-widest px-3 py-1 rounded-md mb-2 inline-block">Natureza</span>
                        <h3 class="text-xl md:text-2xl font-black text-white mb-1 font-heading">Parque Municipal Ikeda</h3>
                        <p class="text-slate-300 text-xs md:text-sm line-clamp-2 font-light">Oásis verde de 27 mil m² no coração da cidade com lago, pista de caminhada e um majestoso portal Torii.</p>
                    </div>
                </article>

                {{-- Templo Shoshinji --}}
                <article class="flex-1 group relative overflow-hidden rounded-[2rem] shadow-lg border border-slate-200 cursor-pointer min-h-[250px]">
                    <img src="{{ asset('img/assai_3.JPG') }}" alt="Templo Budista Shoshinji" class="absolute inset-0 w-full h-full object-cover transition-transform duration-1000 group-hover:scale-105">
                    <div class="absolute inset-0 bg-gradient-to-t from-black/90 via-black/30 to-transparent"></div>
                    <div class="absolute bottom-0 left-0 p-6 right-0">
                        <span class="bg-indigo-600 text-white text-[10px] font-black uppercase tracking-widest px-3 py-1 rounded-md mb-2 inline-block">Espiritualidade</span>
                        <h3 class="text-xl md:text-2xl font-black text-white mb-1 font-heading">Templo Shoshinji</h3>
                        <p class="text-slate-300 text-xs md:text-sm line-clamp-2 font-light">Templo budista em atividade mais antigo do Paraná, inaugurado em 1948, construído em madeira pelos fiéis.</p>
                    </div>
                </article>
            </div>
        </div>
    </div>
</section>

{{-- ===== 4. GASTRONOMIA (Layout Dividido Estilo MV) ===== --}}
<section id="gastronomia" class="py-16 md:py-24 bg-white border-t border-slate-100">
    <div class="container px-4 mx-auto max-w-6xl">
        <div class="flex flex-col lg:flex-row items-center gap-12 lg:gap-20">
            
            {{-- Textos e Ícones (Esquerda) --}}
            <div class="lg:w-1/2 w-full">
                <div class="mb-8 border-l-4 border-amber-500 pl-5">
                    <span class="text-amber-600 font-extrabold tracking-[0.2em] uppercase text-[11px]">Onde Comer</span>
                    <h2 class="text-3xl font-black text-slate-900 md:text-4xl mt-1">Sabores Inesquecíveis</h2>
                </div>
                
                <p class="text-slate-600 text-base md:text-lg leading-relaxed font-light mb-10">
                    Sendo a cidade com a maior proporção de descendentes japoneses do Brasil, Assaí é um verdadeiro Polo Gastronômico Nipônico. Receitas familiares originais e ingredientes frescos garantem uma experiência autêntica.
                </p>

                <div class="grid grid-cols-2 gap-4 md:gap-6">
                    <div class="bg-slate-50 p-6 rounded-2xl border border-slate-100 hover:border-amber-200 hover:shadow-md transition">
                        <span class="text-3xl mb-3 block">🍣</span>
                        <h4 class="text-slate-800 font-bold mb-1">Sushi & Sashimi</h4>
                        <p class="text-slate-500 text-xs">Cortes precisos e peixes frescos.</p>
                    </div>
                    <div class="bg-slate-50 p-6 rounded-2xl border border-slate-100 hover:border-amber-200 hover:shadow-md transition">
                        <span class="text-3xl mb-3 block">🍜</span>
                        <h4 class="text-slate-800 font-bold mb-1">Ramen Artesanal</h4>
                        <p class="text-slate-500 text-xs">Caldos originais de cocção lenta.</p>
                    </div>
                    <div class="bg-slate-50 p-6 rounded-2xl border border-slate-100 hover:border-amber-200 hover:shadow-md transition">
                        <span class="text-3xl mb-3 block">🍡</span>
                        <h4 class="text-slate-800 font-bold mb-1">Wagashi</h4>
                        <p class="text-slate-500 text-xs">Doces finos tradicionais do Japão.</p>
                    </div>
                    <div class="bg-slate-50 p-6 rounded-2xl border border-slate-100 hover:border-amber-200 hover:shadow-md transition">
                        <span class="text-3xl mb-3 block">🍢</span>
                        <h4 class="text-slate-800 font-bold mb-1">Yakitori</h4>
                        <p class="text-slate-500 text-xs">Espetinhos asiáticos com tarê.</p>
                    </div>
                </div>
            </div>

            {{-- Imagem Destaque (Direita) --}}
            <div class="lg:w-1/2 w-full relative">
                <div class="aspect-[4/5] rounded-[2rem] overflow-hidden shadow-2xl relative">
                    {{-- Usando um placeholder elegante caso não tenha a imagem exata de comida --}}
                    <div class="absolute inset-0 bg-amber-600 flex flex-col items-center justify-center text-white p-8 text-center">
                        <span class="text-8xl mb-6 drop-shadow-md">🥢</span>
                        <h3 class="text-3xl font-black font-heading mb-2">Polo Gastronômico</h3>
                        <p class="font-light text-amber-100">O sabor ancestral do Japão profundo no Norte do Paraná.</p>
                    </div>
                </div>
                <div class="absolute -bottom-6 -left-6 bg-white p-4 rounded-2xl shadow-xl hidden md:block border border-slate-100">
                    <div class="flex items-center gap-3">
                        <div class="w-12 h-12 bg-amber-100 rounded-full flex items-center justify-center text-amber-600 text-xl">👨‍🍳</div>
                        <div>
                            <p class="font-black text-slate-800 text-sm">Receitas Familiares</p>
                            <p class="text-xs text-slate-500">Tradição de 1932</p>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</section>

{{-- ===== 5. ONDE FICAR (Cards Centralizados) ===== --}}
<section id="onde-ficar" class="py-16 md:py-24 bg-slate-50 border-t border-slate-200">
    <div class="container px-4 mx-auto max-w-5xl">
        <div class="text-center mb-14">
            <span class="inline-block text-emerald-600 font-extrabold tracking-[0.2em] uppercase text-[11px] mb-2">Hospedagem</span>
            <h2 class="text-3xl font-black text-slate-900 md:text-4xl">Onde Ficar</h2>
            <p class="mt-4 text-base text-slate-600 max-w-2xl mx-auto font-light">Descanse no Norte Pioneiro. Assaí oferece infraestrutura acolhedora, desde hotéis no centro comercial a opções rurais para relaxamento.</p>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-3 gap-6 md:gap-8">
            <div class="bg-white rounded-3xl p-8 md:p-10 border border-slate-100 shadow-[0_10px_30px_-15px_rgba(0,0,0,0.1)] hover:-translate-y-2 hover:shadow-xl transition-all duration-300 text-center group">
                <div class="w-20 h-20 mx-auto bg-blue-50 rounded-full flex items-center justify-center text-4xl mb-6 group-hover:bg-blue-600 transition-colors">
                    <span class="group-hover:scale-110 transition-transform group-hover:brightness-200">🏨</span>
                </div>
                <h3 class="text-xl font-bold text-slate-900 mb-3">Hotéis Centrais</h3>
                <p class="text-sm text-slate-600 font-light">Praticidade e conforto perto de restaurantes, praças e do intenso comércio local.</p>
            </div>
            
            <div class="bg-white rounded-3xl p-8 md:p-10 border border-slate-100 shadow-[0_10px_30px_-15px_rgba(0,0,0,0.1)] hover:-translate-y-2 hover:shadow-xl transition-all duration-300 text-center group">
                <div class="w-20 h-20 mx-auto bg-emerald-50 rounded-full flex items-center justify-center text-4xl mb-6 group-hover:bg-emerald-600 transition-colors">
                    <span class="group-hover:scale-110 transition-transform group-hover:brightness-200">🌳</span>
                </div>
                <h3 class="text-xl font-bold text-slate-900 mb-3">Turismo Rural</h3>
                <p class="text-sm text-slate-600 font-light">Estadias em fazendas e sítios para acordar com o canto dos pássaros e ar puro.</p>
            </div>

            <div class="bg-white rounded-3xl p-8 md:p-10 border border-slate-100 shadow-[0_10px_30px_-15px_rgba(0,0,0,0.1)] hover:-translate-y-2 hover:shadow-xl transition-all duration-300 text-center group">
                <div class="w-20 h-20 mx-auto bg-amber-50 rounded-full flex items-center justify-center text-4xl mb-6 group-hover:bg-amber-500 transition-colors">
                    <span class="group-hover:scale-110 transition-transform group-hover:brightness-200">🏡</span>
                </div>
                <h3 class="text-xl font-bold text-slate-900 mb-3">Pousadas</h3>
                <p class="text-sm text-slate-600 font-light">Ambiente familiar e acolhimento tipicamente interiorano para relaxar com a família.</p>
            </div>
        </div>
    </div>
</section>

{{-- ===== 6. EVENTOS (Grid de Ícones Grandes) ===== --}}
<section id="eventos" class="py-16 md:py-24 bg-white border-t border-slate-100">
    <div class="container px-4 mx-auto max-w-6xl">
        <div class="flex flex-col md:flex-row justify-between items-end mb-12 border-l-4 border-pink-600 pl-5">
            <div>
                <span class="text-pink-600 font-extrabold tracking-[0.2em] uppercase text-[11px]">Calendário Anual</span>
                <h2 class="text-3xl font-black text-slate-900 md:text-4xl mt-1">Eventos Inesquecíveis</h2>
            </div>
            <a href="{{ route('agenda.index') }}" class="mt-6 md:mt-0 px-8 py-3 bg-slate-900 text-white font-bold rounded-full shadow-lg hover:bg-slate-800 transition text-sm hover:-translate-y-0.5">
                Ver Agenda Completa
            </a>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 md:gap-8">
            {{-- ExpoAsa --}}
            <div class="bg-white rounded-3xl overflow-hidden shadow-md border border-slate-100 group hover:-translate-y-2 transition-all duration-300">
                <div class="h-40 bg-slate-50 flex items-center justify-center text-6xl border-b border-slate-100 relative overflow-hidden">
                    <div class="absolute inset-0 bg-yellow-100 opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
                    <span class="relative z-10 group-hover:scale-110 transition-transform duration-500">🌾</span>
                </div>
                <div class="p-8">
                    <span class="text-[10px] font-bold text-yellow-600 uppercase tracking-widest mb-2 block">Junho</span>
                    <h3 class="text-2xl font-black text-slate-900 mb-3 font-heading">ExpoAsa</h3>
                    <p class="text-sm text-slate-600 font-light leading-relaxed">Exposição agropecuária realizada desde 1943. A mais antiga do Brasil, integra leilões, shows, parque de diversões e gastronomia típica.</p>
                </div>
            </div>

            {{-- Tanabata --}}
            <div class="bg-white rounded-3xl overflow-hidden shadow-md border border-slate-100 group hover:-translate-y-2 transition-all duration-300">
                <div class="h-40 bg-slate-50 flex items-center justify-center text-6xl border-b border-slate-100 relative overflow-hidden">
                    <div class="absolute inset-0 bg-blue-100 opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
                    <span class="relative z-10 group-hover:scale-110 transition-transform duration-500">🎋</span>
                </div>
                <div class="p-8">
                    <span class="text-[10px] font-bold text-blue-600 uppercase tracking-widest mb-2 block">Outubro</span>
                    <h3 class="text-2xl font-black text-slate-900 mb-3 font-heading">Tanabata Matsuri</h3>
                    <p class="text-sm text-slate-600 font-light leading-relaxed">O primeiro Festival das Estrelas do Brasil (desde 1978). Registre seus desejos em Tanzaku e celebre com danças e yukatas nas ruas de Assaí.</p>
                </div>
            </div>

            {{-- Bon Odori --}}
            <div class="bg-white rounded-3xl overflow-hidden shadow-md border border-slate-100 group hover:-translate-y-2 transition-all duration-300">
                <div class="h-40 bg-slate-50 flex items-center justify-center text-6xl border-b border-slate-100 relative overflow-hidden">
                    <div class="absolute inset-0 bg-pink-100 opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
                    <span class="relative z-10 group-hover:scale-110 transition-transform duration-500">🥁</span>
                </div>
                <div class="p-8">
                    <span class="text-[10px] font-bold text-pink-600 uppercase tracking-widest mb-2 block">Agosto e Novembro</span>
                    <h3 class="text-2xl font-black text-slate-900 mb-3 font-heading">Bon Odori</h3>
                    <p class="text-sm text-slate-600 font-light leading-relaxed">Dança sagrada em gratidão aos antepassados. O som vibrante dos tambores Taiko e os movimentos circulares atraem turistas de todo o estado.</p>
                </div>
            </div>
        </div>
    </div>
</section>

@endsection