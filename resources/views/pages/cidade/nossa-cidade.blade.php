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
                <pattern id="grid-city" width="60" height="60" patternUnits="userSpaceOnUse">
                    <path d="M 60 0 L 0 0 0 60" fill="none" stroke="white" stroke-width="1" />
                </pattern>
            </defs>
            <rect width="100%" height="100%" fill="url(#grid-city)" />
        </svg>
        <div class="absolute bottom-0 left-0 right-0 h-64 bg-gradient-to-t from-slate-950/80 to-transparent"></div>
    </div>

    <div class="container relative z-10 px-4 sm:px-6 md:px-8 mx-auto text-left max-w-6xl w-full">
        <div class="relative z-20">
            <x-breadcrumb :items="[
                ['name' => 'Início', 'url' => route('home')],
                ['name' => 'Cidade', 'url' => null],
                ['name' => 'Nossa Cidade', 'url' => null]
            ]" dark />
        </div>
        
        <div class="mt-8 md:mt-10 max-w-4xl">
            <span class="inline-flex items-center gap-2 px-4 py-1.5 mb-6 text-xs font-bold tracking-widest text-blue-900 uppercase bg-yellow-400 rounded-full shadow-sm">
                Conheça a Nossa História
            </span>
            <h1 class="text-4xl sm:text-5xl md:text-6xl font-extrabold font-heading mb-6 text-white drop-shadow-md leading-tight" style="font-family: 'Montserrat', sans-serif;">
                Assaí <span class="text-yellow-400">— PR</span>
            </h1>
            <p class="text-lg sm:text-xl md:text-2xl text-blue-50 leading-relaxed font-light">
                Do solo fértil de "Terra Roxa" às conquistas globais em inovação, Assaí é o marco da imigração japonesa e o futuro do Vale do Sol no Paraná.
            </p>
        </div>
    </div>
</section>

{{-- ===== PERFIL RÁPIDO (Estatísticas) ===== --}}
<section class="bg-white border-b border-slate-200 py-10">
    <div class="container px-4 mx-auto max-w-6xl">
        <div class="grid grid-cols-2 md:grid-cols-4 gap-6">
            <div class="text-center md:border-r border-slate-100 last:border-0">
                <span class="block text-2xl md:text-3xl font-black text-[#006eb7]">13.797</span>
                <span class="text-[10px] font-bold uppercase text-slate-400 tracking-wider">Habitantes (IBGE 2022)</span>
            </div>
            <div class="text-center md:border-r border-slate-100 last:border-0">
                <span class="block text-2xl md:text-3xl font-black text-[#006eb7]">0,728</span>
                <span class="text-[10px] font-bold uppercase text-slate-400 tracking-wider">IDH-M (Alto)</span>
            </div>
            <div class="text-center md:border-r border-slate-100 last:border-0">
                <span class="block text-2xl md:text-3xl font-black text-[#006eb7]">440,3 km²</span>
                <span class="text-[10px] font-bold uppercase text-slate-400 tracking-wider">Área Territorial</span>
            </div>
            <div class="text-center">
                <span class="block text-2xl md:text-3xl font-black text-[#006eb7]">520m</span>
                <span class="text-[10px] font-bold uppercase text-slate-400 tracking-wider">Altitude Média</span>
            </div>
        </div>
    </div>
</section>

{{-- ===== CAPÍTULO I: FUNDAÇÃO ===== --}}
<section id="historia" class="py-16 md:py-24 bg-white overflow-x-hidden">
    <div class="container px-4 sm:px-6 md:px-8 mx-auto max-w-6xl w-full">
        <div class="grid items-start grid-cols-1 md:grid-cols-2 gap-12 lg:gap-16">
            
            {{-- Coluna 1: Imagem e Selos --}}
            <div class="relative group lg:sticky lg:top-24">
                <div class="overflow-hidden shadow-2xl rounded-[2.5rem] bg-slate-200 relative aspect-video lg:aspect-square w-full">
                    <img src="{{ asset('img/Assai.jpg') }}" alt="Pioneiros de Assailand" class="object-cover w-full h-full transition duration-700 group-hover:scale-105" loading="lazy">
                    <div class="absolute inset-0 ring-1 ring-inset ring-black/10 rounded-[2.5rem]"></div>
                </div>
                
                <div class="absolute -bottom-6 -right-2 sm:-right-6 p-6 shadow-2xl bg-[#006eb7] text-white rounded-3xl transform group-hover:-translate-y-2 transition-transform duration-300 z-10">
                    <p class="mb-1 text-[10px] font-extrabold tracking-[0.2em] uppercase text-yellow-400">Aniversário</p>
                    <p class="text-3xl font-black font-heading leading-none" style="font-family: 'Montserrat', sans-serif;">1º de Maio</p>
                    <p class="text-blue-200 text-sm mt-2 font-medium">Desde 1932</p>
                </div>

                {{-- Selo BRATAC --}}
                <div class="absolute -top-6 -left-6 w-32 h-32 bg-white rounded-full shadow-lg border-8 border-slate-50 flex items-center justify-center p-4 z-10 transform -rotate-12 hidden md:flex">
                    <div class="text-center">
                        <span class="block text-[8px] font-black text-slate-400 uppercase leading-none mb-1">Colonizadora</span>
                        <span class="block text-xl font-black text-blue-900 leading-none">BRATAC</span>
                    </div>
                </div>
            </div>
            
            {{-- Coluna 2: Narrativa --}}
            <div class="space-y-8 text-slate-700">
                <div class="space-y-4">
                    <div class="inline-flex items-center gap-2">
                        <span class="w-8 h-1 bg-[#006eb7] rounded-full"></span>
                        <span class="text-[#006eb7] font-bold tracking-widest uppercase text-xs">Capítulo I: A Fundação</span>
                    </div>
                    
                    <h2 class="text-3xl sm:text-4xl md:text-5xl font-extrabold text-slate-800 font-heading leading-tight" style="font-family: 'Montserrat', sans-serif;">
                        O Nascimento do <br><span class="text-[#006eb7]">Sol Nascente</span>
                    </h2>
                </div>
                
                <div class="prose prose-slate prose-lg max-w-none text-slate-600 space-y-6">
                    <p class="leading-relaxed">
                        A história de Assaí começa oficialmente em <strong>1º de maio de 1932</strong>, com a chegada de um grupo liderado por <strong>Miyuki Saito</strong>. Eles partiram de Jataizinho para desbravar a vasta <strong>Fazenda Três Barras</strong>, uma área de 13.600 alqueires adquirida pela <strong>BRATAC</strong>.
                    </p>
                    
                    <p class="leading-relaxed">
                        Diferente de outras colonizações, a BRATAC implementou um modelo planejado: os imigrantes não eram apenas trabalhadores, mas <strong>colonos-proprietários</strong>. A empresa oferecia suporte técnico e infraestrutura, transformando a mata virgem em núcleos agrícolas produtivos em tempo recorde.
                    </p>

                    <div class="bg-blue-50 border-l-4 border-[#006eb7] p-6 rounded-r-2xl shadow-sm italic text-slate-800 text-base relative overflow-hidden group">
                        <i class="fa-solid fa-quote-right absolute top-4 right-4 text-blue-100 text-4xl group-hover:scale-110 transition-transform"></i>
                        O nome original da colônia era <strong>Assailand</strong> — uma fusão poética de <em>Asahi</em> (Sol Nascente em japonês) e <em>Land</em> (Terra em inglês).
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

{{-- ===== CAPÍTULO II: ERA DO OURO BRANCO ===== --}}
<section class="py-16 md:py-24 bg-slate-950 text-white overflow-hidden relative border-y border-white/5">
    <div class="absolute inset-0 opacity-10">
        <img src="{{ asset('img/Assai.jpg') }}" class="w-full h-full object-cover blur-sm scale-110" alt="Background">
    </div>
    <div class="absolute inset-0 bg-gradient-to-r from-slate-950 via-slate-950/90 to-transparent"></div>

    <div class="container px-4 sm:px-6 md:px-8 mx-auto max-w-6xl w-full relative z-10">
        <div class="w-full text-center">
            <div class="inline-flex items-center gap-2 mb-6">
                <span class="w-8 h-1 bg-yellow-400 rounded-full"></span>
                <span class="text-yellow-400 font-bold tracking-widest uppercase text-xs">Capítulo II: O Ouro Branco</span>
            </div>
            
            <h2 class="text-3xl sm:text-4xl md:text-5xl font-black mb-8 leading-tight" style="font-family: 'Montserrat', sans-serif;">
                A Capital Mundial <br>do <span class="text-yellow-400">Algodão</span>
            </h2>

            <div class="space-y-12">
                {{-- Narrativa --}}
                <div class="space-y-6 text-slate-300 text-lg leading-relaxed">
                    <p>
                        Entre as décadas de 1940 e 1960, Assaí viveu seu maior apogeu econômico. Graças ao solo fértil de terra roxa, a cidade tornou-se um dos maiores centros produtores de <strong>algodão</strong> do mundo. 
                    </p>
                    <p>
                        Nesta fase, gigantes globais como a <strong>Anderson Clayton</strong> e a <strong>Sanbra</strong> instalaram usinas de beneficiamento na cidade, que pulsava dia e noite com o movimento das colheitas e o vaivém das máquinas.
                    </p>
                    <p>
                        Foi este ciclo que atraiu milhares de famílias de todo o Brasil, especialmente do Nordeste, criando o caldeirão cultural que hoje define a identidade única do povo assaiense.
                    </p>
                </div>
                
                {{-- Grid de Cards --}}
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6 text-left">
                    {{-- Card 1: Usinas --}}
                    <div class="bg-white/10 backdrop-blur-md border border-white/20 p-8 rounded-[2.5rem] hover:bg-white/15 transition-all">
                        <div class="flex items-center gap-4 mb-6">
                            <div class="w-14 h-14 bg-yellow-400 rounded-2xl flex items-center justify-center text-slate-950 text-2xl shadow-[0_0_20px_rgba(250,204,21,0.3)]">
                                <i class="fa-solid fa-industry"></i>
                            </div>
                            <div>
                                <h4 class="text-xl font-bold text-white leading-tight">Usinas Globais</h4>
                                <p class="text-[10px] text-slate-400 uppercase font-black tracking-tighter">Impacto Industrial</p>
                            </div>
                        </div>
                        <p class="text-blue-100/70 text-sm leading-relaxed italic">
                            A cidade atraiu os maiores nomes da indústria têxtil global, com usinas que operavam ininterruptamente, alimentando o comércio internacional.
                        </p>
                    </div>

                    {{-- Card 2: Ouro Branco --}}
                    <div class="bg-white/10 backdrop-blur-md border border-white/20 p-8 rounded-[2.5rem] hover:bg-white/15 transition-all">
                        <div class="flex items-center gap-4 mb-6">
                            <div class="w-14 h-14 bg-emerald-500/20 text-emerald-400 rounded-2xl flex items-center justify-center text-2xl">
                                <i class="fa-solid fa-seedling"></i>
                            </div>
                            <div>
                                <h4 class="text-xl font-bold text-white leading-tight">Ouro Branco</h4>
                                <p class="text-[10px] text-slate-400 uppercase font-black tracking-tighter">Produção Agrícola</p>
                            </div>
                        </div>
                        <p class="text-blue-100/70 text-sm leading-relaxed italic">
                            O solo de Terra Roxa proporcionou a maior produtividade de algodão do mundo, atraindo investimentos internacionais.
                        </p>
                    </div>

                    {{-- Card 3: Migração --}}
                    <div class="bg-white/10 backdrop-blur-md border border-white/20 p-8 rounded-[2.5rem] hover:bg-white/15 transition-all">
                        <div class="flex items-center gap-4 mb-6">
                            <div class="w-14 h-14 bg-blue-500/20 text-blue-300 rounded-2xl flex items-center justify-center text-2xl">
                                <i class="fa-solid fa-users-rays"></i>
                            </div>
                            <div>
                                <h4 class="text-xl font-bold text-white leading-tight">Caldeirão Cultural</h4>
                                <p class="text-[10px] text-slate-400 uppercase font-black tracking-tighter">População</p>
                            </div>
                        </div>
                        <p class="text-blue-100/70 text-sm leading-relaxed italic">
                            A fusão única entre imigrantes japoneses e migrantes de todo o Brasil criou a identidade vibrante de Assaí.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

{{-- ===== CAPÍTULO III: CULTURA E TRADIÇÃO ===== --}}
<section class="py-16 md:py-24 bg-white relative overflow-hidden">
    <div class="container px-4 mx-auto max-w-6xl relative z-10">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-12 items-center">
            <div class="order-2 md:order-1">
                <div class="inline-flex items-center gap-2 mb-4">
                    <span class="w-8 h-1 bg-[#006eb7] rounded-full"></span>
                    <span class="text-[#006eb7] font-bold tracking-widest uppercase text-xs">Capítulo III: O Legado Cultural</span>
                </div>
                <h2 class="text-3xl sm:text-4xl font-black text-slate-800 font-heading mb-6" style="font-family: 'Montserrat', sans-serif;">
                    Onde a Tradição <br><span class="text-[#006eb7]">Cruza Fronteiras</span>
                </h2>
                <div class="prose prose-slate prose-lg text-slate-600 space-y-6">
                    <p>
                        Assaí carrega o orgulho de ser o berço do <strong>primeiro Tanabata Matsuri do Brasil</strong>, realizado em 1978. O Festival das Estrelas, que celebra a milenar lenda japonesa, tornou-se uma das maiores manifestações culturais do estado.
                    </p>
                    <p>
                        A fusão das raízes nipônicas com a alegria brasileira criou uma identidade vibrante, manifestada no <strong>Bon Odori</strong>, na culinária típica e nas associações que mantêm viva a língua e a disciplina dos antepassados.
                    </p>
                </div>
            </div>
            <div class="order-1 md:order-2">
                <div class="relative group">
                    <div class="absolute -inset-4 bg-blue-50 rounded-[3rem] -rotate-3 transition-transform group-hover:rotate-0 duration-500"></div>
                    <div class="relative overflow-hidden rounded-[2.5rem] shadow-xl aspect-[4/3] bg-slate-100">
                        <img src="{{ asset('img/assai_1.jpg') }}" alt="Castelo de Assaí" class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-110">
                        <div class="absolute inset-0 bg-gradient-to-t from-black/40 to-transparent"></div>
                        <div class="absolute bottom-6 left-6 text-white">
                            <span class="px-3 py-1 bg-white/20 backdrop-blur-md rounded-lg text-xs font-bold uppercase tracking-widest">Patrimônio</span>
                            <h4 class="text-lg font-bold mt-1">Memorial da Imigração</h4>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

{{-- ===== CAPÍTULO IV: SMART CITY ===== --}}
<section class="py-16 md:py-24 bg-gradient-to-br from-blue-700 to-indigo-900 text-white relative overflow-hidden">
    {{-- Elementos Decorativos Tech --}}
    <div class="absolute inset-0 opacity-10 pointer-events-none">
        <svg class="w-full h-full" viewBox="0 0 100 100" preserveAspectRatio="none">
            <path d="M0,10 L100,10 M0,20 L100,20 M0,30 L100,30" stroke="white" stroke-width="0.1" fill="none" />
            <path d="M10,0 L10,100 M20,0 L20,100 M30,0 L30,100" stroke="white" stroke-width="0.1" fill="none" />
        </svg>
    </div>

    <div class="container px-4 mx-auto max-w-6xl relative z-10">
        <div class="text-center max-w-3xl mx-auto mb-16">
            <div class="inline-flex items-center gap-2 mb-4">
                <span class="w-8 h-1 bg-cyan-400 rounded-full"></span>
                <span class="text-cyan-400 font-bold tracking-widest uppercase text-xs">Capítulo IV: O Futuro Agora</span>
            </div>
            <h2 class="text-3xl sm:text-4xl md:text-5xl font-black mb-6 leading-tight" style="font-family: 'Montserrat', sans-serif;">
                Do Campo ao <br><span class="text-cyan-400 underline decoration-cyan-400/30">Top 7 Global</span>
            </h2>
            <p class="text-lg text-blue-100 leading-relaxed font-light">
                Assaí não apenas preserva o passado, mas desenha o amanhã. Reconhecida internacionalmente, a cidade tornou-se um modelo de desenvolvimento inteligente e tecnológico.
            </p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            <div class="bg-white/10 backdrop-blur-xl border border-white/20 p-8 rounded-[2.5rem] hover:-translate-y-2 transition-all duration-300 group">
                <div class="w-14 h-14 bg-cyan-400/20 text-cyan-400 rounded-2xl flex items-center justify-center text-2xl mb-6 group-hover:bg-cyan-400 group-hover:text-slate-950 transition-colors shadow-lg">
                    <i class="fa-solid fa-microchip"></i>
                </div>
                <h4 class="text-xl font-bold mb-3">Inovação e Tech</h4>
                <p class="text-blue-100/70 text-sm leading-relaxed">
                    Eleita uma das <strong>7 Comunidades Mais Inteligentes do Mundo</strong> (Top 7 Global) pelo ICF, superando grandes metrópoles globais.
                </p>
            </div>

            <div class="bg-white/10 backdrop-blur-xl border border-white/20 p-8 rounded-[2.5rem] hover:-translate-y-2 transition-all duration-300 group">
                <div class="w-14 h-14 bg-emerald-400/20 text-emerald-400 rounded-2xl flex items-center justify-center text-2xl mb-6 group-hover:bg-emerald-400 group-hover:text-slate-950 transition-colors shadow-lg">
                    <i class="fa-solid fa-graduation-cap"></i>
                </div>
                <h4 class="text-xl font-bold mb-3">Educação do Futuro</h4>
                <p class="text-blue-100/70 text-sm leading-relaxed">
                    Investimentos massivos em robótica, ensino trilíngue e qualificação técnica para reter talentos locais no Vale do Sol.
                </p>
            </div>

            <div class="bg-white/10 backdrop-blur-xl border border-white/20 p-8 rounded-[2.5rem] hover:-translate-y-2 transition-all duration-300 group">
                <div class="w-14 h-14 bg-amber-400/20 text-amber-400 rounded-2xl flex items-center justify-center text-2xl mb-6 group-hover:bg-amber-400 group-hover:text-slate-950 transition-colors shadow-lg">
                    <i class="fa-solid fa-rocket"></i>
                </div>
                <h4 class="text-xl font-bold mb-3">Vale do Sol</h4>
                <p class="text-blue-100/70 text-sm leading-relaxed">
                    Um ecossistema de startups e agrotecnologia que conecta Assaí às principais redes globais de inovação e investimento.
                </p>
            </div>
        </div>
    </div>
</section>

{{-- ===== GRID DE CURIOSIDADES ===== --}}
<section class="py-16 bg-white border-b border-slate-100">
    <div class="container px-4 mx-auto max-w-6xl">
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
            <div class="p-6 rounded-3xl border border-slate-100 bg-slate-50 hover:bg-white hover:shadow-xl transition-all group">
                <div class="w-12 h-12 bg-blue-100 text-blue-600 rounded-2xl flex items-center justify-center text-xl mb-4 group-hover:bg-blue-600 group-hover:text-white transition-colors">
                    <i class="fa-solid fa-landmark"></i>
                </div>
                <h4 class="font-bold text-slate-800 mb-2">Emancipação</h4>
                <p class="text-sm text-slate-500 leading-relaxed">Em 1944, Assaí conquistou sua soberania administrativa, desmembrando-se de São Jerônimo da Serra.</p>
            </div>
            
            <div class="p-6 rounded-3xl border border-slate-100 bg-slate-50 hover:bg-white hover:shadow-xl transition-all group">
                <div class="w-12 h-12 bg-emerald-100 text-emerald-600 rounded-2xl flex items-center justify-center text-xl mb-4 group-hover:bg-emerald-600 group-hover:text-white transition-colors">
                    <i class="fa-solid fa-tree-city"></i>
                </div>
                <h4 class="font-bold text-slate-800 mb-2">Urbanismo</h4>
                <p class="text-sm text-slate-500 leading-relaxed">O traçado urbano foi planejado para integrar residências e zonas industriais de beneficiamento têxtil.</p>
            </div>

            <div class="p-6 rounded-3xl border border-slate-100 bg-slate-50 hover:bg-white hover:shadow-xl transition-all group">
                <div class="w-12 h-12 bg-amber-100 text-amber-600 rounded-2xl flex items-center justify-center text-xl mb-4 group-hover:bg-amber-600 group-hover:text-white transition-colors">
                    <i class="fa-solid fa-sun"></i>
                </div>
                <h4 class="font-bold text-slate-800 mb-2">Sol Nascente</h4>
                <p class="text-sm text-slate-500 leading-relaxed">O nome Assaí é a tradução fonética de Asahi, homenageando as raízes nipônicas da cidade.</p>
            </div>

            <div class="p-6 rounded-3xl border border-slate-100 bg-slate-50 hover:bg-white hover:shadow-xl transition-all group">
                <div class="w-12 h-12 bg-rose-100 text-rose-600 rounded-2xl flex items-center justify-center text-xl mb-4 group-hover:bg-rose-600 group-hover:text-white transition-colors">
                    <i class="fa-solid fa-people-group"></i>
                </div>
                <h4 class="font-bold text-slate-800 mb-2">Diversidade</h4>
                <p class="text-sm text-slate-500 leading-relaxed">A fusão entre imigrantes japoneses e migrantes nordestinos criou uma cultura única no Paraná.</p>
            </div>
        </div>
    </div>
</section>


{{-- ===== LINHA DO TEMPO ===== --}}
<section class="py-16 md:py-24 bg-slate-50 border-y border-slate-200">
    <div class="container px-4 sm:px-6 mx-auto max-w-5xl">
        
        <div class="text-center mb-16">
            <h2 class="text-3xl font-black text-slate-800 md:text-4xl mb-4 font-heading" style="font-family: 'Montserrat', sans-serif;">Marcos Cronológicos</h2>
            <p class="text-slate-500 max-w-2xl mx-auto text-lg">A evolução de uma colônia de mata virgem a referência tecnológica.</p>
        </div>

        @php
        $eventosTimeline = [
            ['ano' => '1932', 'titulo' => 'A Fundação', 'desc' => 'Miyuki Saito e pioneiros estabelecem o núcleo inicial em 1º de maio.'],
            ['ano' => '1944', 'titulo' => 'Emancipação', 'desc' => 'Assaí é desmembrada de São Jerônimo da Serra e elevada a município.'],
            ['ano' => '1950', 'titulo' => 'Era do Algodão', 'desc' => 'Auge econômico como um dos maiores centros têxteis do Brasil.'],
            ['ano' => '1978', 'titulo' => 'Tanabata Matsuri', 'desc' => 'Realização do 1º Festival das Estrelas do Brasil, tradição mantida até hoje.'],
            ['ano' => '2022', 'titulo' => 'Smart City', 'desc' => 'Eleita uma das 21 Comunidades mais Inteligentes do Mundo pelo ICF.'],
            ['ano' => 'Hoje', 'titulo' => 'Top 7 Global', 'desc' => 'Reconhecimento mundial como uma das 7 comunidades mais inteligentes do planeta.', 'destaque' => true],
        ];
        @endphp

        <div class="relative wrap overflow-hidden p-4 md:p-10 h-full">
            <div class="hidden md:block absolute border-2 border-opacity-20 border-slate-300 h-full border left-1/2 -translate-x-1/2 top-0"></div>
            <div class="md:hidden absolute border-2 border-opacity-20 border-slate-300 h-full border left-[34px] top-0"></div>

            @foreach($eventosTimeline as $index => $evento)
            @php 
                $isDireita = $index % 2 !== 0; 
                $isDestaque = isset($evento['destaque']) && $evento['destaque'];
            @endphp
            
            <div class="mb-10 flex justify-between items-center w-full {{ $isDireita ? 'md:flex-row-reverse' : 'md:flex-row' }} relative group">
                <div class="hidden md:block order-1 md:w-5/12"></div>

                <div class="z-20 flex items-center order-1 w-10 h-10 rounded-full shadow-xl absolute left-4 md:relative md:left-auto border-2 border-white shrink-0 {{ $isDestaque ? 'bg-yellow-400 text-blue-900 animate-pulse' : 'bg-[#006eb7] text-white' }}">
                    <i class="fa-solid fa-calendar-check mx-auto text-sm"></i>
                </div>

                <div class="order-1 w-full pl-16 md:pl-0 md:w-5/12 {{ $isDireita ? 'md:pl-8 lg:pl-10' : 'md:pr-8 lg:pr-10' }}">
                    <div class="bg-white rounded-2xl shadow-sm border {{ $isDestaque ? 'border-yellow-400 ring-1 ring-yellow-400' : 'border-slate-200' }} p-6 hover:-translate-y-1 transition-transform duration-300 w-full hover:shadow-md">
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

{{-- ===== GEOGRAFIA E CLIMA ===== --}}
<section class="py-16 md:py-24 bg-white border-b border-slate-200">
    <div class="container px-4 mx-auto max-w-6xl">
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 items-center">
            <div>
                <span class="text-[#006eb7] font-extrabold tracking-widest uppercase text-[10px] mb-2 block">Território e Clima</span>
                <h2 class="text-3xl font-black text-slate-800 md:text-4xl font-heading mb-6" style="font-family: 'Montserrat', sans-serif;">Geografia Privilegiada</h2>
                <div class="space-y-4 text-slate-600 leading-relaxed">
                    <p>Localizado na mesorregião do Norte Pioneiro Paranaense, Assaí está assentado sobre um solo de origem basáltica (decomposição de lavas vulcânicas), o que confere à terra uma cor avermelhada característica e altíssima produtividade agrícola.</p>
                    <p>O clima é classificado como <strong>Cfa/Cwa</strong> (Subtropical Úmido), com verões quentes e chuvas bem distribuídas, ideal para o cultivo de grãos, fruticultura e a preservação do bioma original de Mata Atlântica.</p>
                </div>
            </div>
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div class="p-6 bg-slate-50 rounded-3xl border border-slate-100 flex flex-col items-center text-center group hover:bg-white hover:shadow-lg transition-all">
                    <i class="fa-solid fa-temperature-three-quarters text-3xl text-orange-500 mb-4"></i>
                    <h4 class="font-bold text-slate-800 mb-1">21.5°C</h4>
                    <p class="text-xs text-slate-500">Temperatura Média Anual</p>
                </div>
                <div class="p-6 bg-slate-50 rounded-3xl border border-slate-100 flex flex-col items-center text-center group hover:bg-white hover:shadow-lg transition-all">
                    <i class="fa-solid fa-cloud-showers-heavy text-3xl text-blue-500 mb-4"></i>
                    <h4 class="font-bold text-slate-800 mb-1">1.450mm</h4>
                    <p class="text-xs text-slate-500">Precipitação Anual</p>
                </div>
            </div>
        </div>
    </div>
</section>

{{-- ===== SÍMBOLOS CÍVICOS ===== --}}
<section id="simbolos" class="py-16 md:py-24 bg-slate-50">
    <div class="container px-4 sm:px-6 mx-auto max-w-6xl">
        <div class="text-center mb-16">
            <h2 class="text-3xl font-black text-slate-800 md:text-4xl mb-4 font-heading" style="font-family: 'Montserrat', sans-serif;">Símbolos Oficiais</h2>
            <p class="text-slate-500">A identidade institucional e o orgulho do povo assaiense.</p>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 items-start">
            <div class="flex flex-col gap-6">
                <div class="bg-white border border-slate-200 rounded-3xl p-8 flex flex-col items-center shadow-sm hover:shadow-lg transition-all duration-300">
                    <div class="w-full flex items-center justify-center min-h-[160px] mb-6">
                        <img src="{{ asset('img/bandeira.png') }}" alt="Bandeira de Assaí" class="w-full max-w-[280px] h-auto drop-shadow-md rounded-sm" loading="lazy"/>
                    </div>
                    <h3 class="text-xl font-bold text-slate-800 font-heading">Bandeira Municipal</h3>
                </div>
                <div class="bg-white border border-slate-200 rounded-3xl p-8 flex flex-col items-center shadow-sm hover:shadow-lg transition-all duration-300">
                    <div class="w-full flex items-center justify-center min-h-[160px] mb-6">
                        <img src="{{ asset('img/brasao.png') }}" alt="Brasão de Assaí" class="w-full max-w-[160px] h-auto drop-shadow-md" loading="lazy" />
                    </div>
                    <h3 class="text-xl font-bold text-slate-800 font-heading">Brasão de Armas</h3>
                </div>
            </div>

            <div class="bg-[#006eb7] rounded-3xl p-8 flex flex-col items-center shadow-xl text-white h-full relative overflow-hidden">
                <div class="absolute inset-0 bg-white/5 opacity-10 pointer-events-none"><i class="fa-solid fa-music text-[200px] absolute -bottom-10 -right-10"></i></div>
                <div class="w-16 h-16 bg-white/20 rounded-2xl flex items-center justify-center text-2xl mb-8 relative z-10">
                    <i class="fa-solid fa-microphone-lines text-yellow-400"></i>
                </div>
                <h3 class="text-2xl font-black font-heading mb-6 relative z-10">Hino Oficial de Assaí</h3>
                
                <div class="w-full bg-white/10 border border-white/20 rounded-2xl p-4 mb-8 backdrop-blur-sm relative z-10">
                    <audio controls class="w-full h-10 outline-none">
                        <source src="{{ asset('img/hino.mp3') }}" type="audio/mpeg">
                        Seu navegador não suporta áudio.
                    </audio>
                </div>
                
                <div class="bg-white/95 rounded-2xl p-6 text-slate-800 text-left w-full h-[300px] overflow-y-auto relative z-10 shadow-inner">
                    <p class="text-[10px] font-bold text-[#006eb7] uppercase tracking-widest mb-4">Letra: Walerian Wrosz</p>
                    <pre class="whitespace-pre-wrap font-mono text-sm leading-relaxed">Salve Assaí garbosa, esplendor do Brasil.
A cidade mais querida, entre tantas outras mil.
Salve, a terra nutriz, o grande celeiro do sul.
O retrato do teu rosto, bandeira ouro-azul.

Enquanto nós vivermos, Assaí só crescerá
Em ritmo de progresso do gigante Paraná.
Nossa luta pelo Brasil já começou aqui
Desde que nossos ancestrais fundaram Assaí.

Todos unidos lutaremos pelo bem comum
O povo da cidade e do campo sempre é um.
O trabalho traz bem estar, na luta integral
O assaiense alcançará a glória imortal.</pre>
                </div>
            </div>
        </div>
    </div>
</section>

@endsection