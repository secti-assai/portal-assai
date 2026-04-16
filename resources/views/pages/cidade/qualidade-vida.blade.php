@extends('layouts.app')
@section('title', 'Qualidade de Vida & Inovação - Prefeitura Municipal de Assaí')

@section('content')
<style> body, html { overflow-x: hidden !important; } </style>

{{-- ===== CABEÇALHO (HERO) ===== --}}
<section class="relative pt-[calc(var(--site-header-height,72px)+1.5rem)] pb-16 sm:pt-[calc(var(--site-header-height,72px)+2.5rem)] sm:pb-20 md:pt-[calc(var(--site-header-height,72px)+3.5rem)] md:pb-24 lg:pt-24 lg:pb-24 overflow-hidden bg-[#006eb7] w-full max-w-full">
    <div class="absolute inset-0 pointer-events-none">
        <svg class="absolute w-full h-full opacity-10" xmlns="http://www.w3.org/2000/svg">
            <defs>
                <pattern id="grid-innovation" width="60" height="60" patternUnits="userSpaceOnUse">
                    <path d="M 60 0 L 0 0 0 60" fill="none" stroke="white" stroke-width="1" />
                </pattern>
            </defs>
            <rect width="100%" height="100%" fill="url(#grid-innovation)" />
        </svg>
        <div class="absolute bottom-0 left-0 right-0 h-64 bg-gradient-to-t from-slate-950/80 to-transparent"></div>
    </div>

    <div class="container relative z-10 px-4 sm:px-6 md:px-8 mx-auto text-left max-w-6xl w-full">
        <div class="relative z-20">
            <x-breadcrumb :items="[
                ['name' => 'Início', 'url' => route('home')],
                ['name' => 'Cidade', 'url' => null],
                ['name' => 'Qualidade de Vida', 'url' => null]
            ]" dark />
        </div>
        
        <div class="mt-8 md:mt-10 max-w-3xl">
            <span class="inline-flex items-center gap-2 px-4 py-1.5 mb-6 text-xs font-bold tracking-widest text-blue-900 uppercase bg-yellow-400 rounded-full shadow-sm">
                Uma das 7 Cidades mais Inteligentes do Mundo
            </span>
            <h1 class="text-4xl sm:text-5xl md:text-6xl font-extrabold font-heading mb-6 text-white drop-shadow-md leading-tight" style="font-family: 'Montserrat', sans-serif;">
                Inovação e <span class="text-yellow-400">Futuro</span>
            </h1>
            <p class="text-lg sm:text-xl md:text-2xl text-blue-50 leading-relaxed font-light mb-6">
                Reconhecida globalmente, Assaí constrói todos os dias uma sociedade fundamentada em tecnologia, educação profissionalizante e bem-estar.
            </p>
        </div>
    </div>
</section>

{{-- ===== SMART CITY / VALE DO SOL ===== --}}
<section class="py-16 md:py-24 bg-slate-50 w-full overflow-x-hidden border-b border-slate-200">
    <div class="container px-4 sm:px-6 mx-auto max-w-6xl w-full">
        <div class="grid items-center grid-cols-1 lg:grid-cols-2 gap-12 lg:gap-16">
            
            {{-- Texto Esquerda --}}
            <div class="space-y-6">
                <div class="inline-flex items-center gap-2">
                    <span class="w-8 h-1 bg-emerald-500 rounded-full"></span>
                    <span class="text-emerald-700 font-extrabold tracking-widest uppercase text-xs">Smart City Global</span>
                </div>
                
                <h2 class="text-3xl font-extrabold text-slate-800 font-heading md:text-4xl leading-tight" style="font-family: 'Montserrat', sans-serif;">
                    Top 7 Comunidades <br><span class="text-emerald-600">Mais Inteligentes do Mundo</span>
                </h2>
                
                <p class="text-slate-600 text-base md:text-lg leading-relaxed font-medium">
                    Assaí foi avaliada e reconhecida oficialmente pelo <strong>Intelligent Community Forum (ICF)</strong> como uma das 7 comunidades mais inteligentes do planeta, destacando-se pela aplicação de tecnologia na melhoria da qualidade de vida cidadã.
                </p>
                
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 pt-4">
                    <div class="p-6 bg-white rounded-2xl border border-slate-200 shadow-[0_4px_20px_rgba(0,0,0,0.03)] hover:shadow-md hover:-translate-y-1 transition-all duration-300">
                        <div class="text-4xl font-black text-emerald-600 mb-2" style="font-family: 'Montserrat', sans-serif;">0,748</div>
                        <p class="text-xs font-bold text-slate-500 uppercase tracking-wide">IDH Municipal (PNUD)</p>
                        <p class="text-sm text-slate-500 mt-2">Classificação de Alto Desenvolvimento Humano.</p>
                    </div>
                    <div class="p-6 bg-white rounded-2xl border border-slate-200 shadow-[0_4px_20px_rgba(0,0,0,0.03)] hover:shadow-md hover:-translate-y-1 transition-all duration-300">
                        <div class="text-4xl font-black text-[#006eb7] mb-2" style="font-family: 'Montserrat', sans-serif;">Top 7</div>
                        <p class="text-xs font-bold text-slate-500 uppercase tracking-wide">ICF Smart Communities</p>
                        <p class="text-sm text-slate-500 mt-2">Única cidade da América Latina na lista.</p>
                    </div>
                </div>
            </div>
            
            {{-- Card Destaque Direita --}}
            <div class="relative w-full">
                <div class="absolute inset-0 bg-gradient-to-tr from-yellow-400 to-amber-500 rounded-[2.5rem] transform rotate-3 scale-[1.02] opacity-20 blur-xl"></div>
                <div class="relative z-10 p-10 md:p-14 bg-slate-900 rounded-[2.5rem] shadow-2xl text-white text-center border border-slate-800 overflow-hidden group">
                    {{-- Textura de Fundo do Card --}}
                    <div class="absolute inset-0 bg-[url('https://www.transparenttextures.com/patterns/stardust.png')] opacity-10 mix-blend-overlay"></div>
                    
                    <div class="relative z-20">
                        <div class="inline-flex items-center justify-center w-24 h-24 mb-8 bg-gradient-to-br from-yellow-400 to-amber-500 rounded-[1.5rem] text-slate-900 mx-auto shadow-lg shadow-yellow-500/30 group-hover:scale-110 transition-transform duration-500">
                            <i class="fa-solid fa-earth-americas text-4xl"></i>
                        </div>
                        <p class="text-yellow-400 font-black text-[11px] tracking-[0.25em] uppercase mb-4 drop-shadow-md">Intelligent Community Forum</p>
                        <p class="text-6xl font-black text-white mb-4 drop-shadow-lg" style="font-family: 'Montserrat', sans-serif;">Top 7</p>
                        <div class="w-12 h-1 bg-white/20 mx-auto mb-6 rounded-full"></div>
                        <p class="text-slate-300 text-base leading-relaxed font-light">Assaí integra orgulhosamente o seleto grupo mundial de cidades que usam a tecnologia não como um fim, mas como meio para a transformação social.</p>
                    </div>
                </div>
            </div>

        </div>
    </div>
</section>

{{-- ===== AGÊNCIA DE INOVAÇÃO VALE DO SOL ===== --}}
<section class="py-16 md:py-24 bg-white w-full overflow-x-hidden">
    <div class="container px-4 sm:px-6 mx-auto max-w-6xl w-full">
        
        <div class="text-center mb-16">
            <h2 class="text-3xl font-black text-slate-800 md:text-4xl font-heading mb-4" style="font-family: 'Montserrat', sans-serif;">Agência de Inovação Vale do Sol</h2>
            <p class="text-slate-500 max-w-2xl mx-auto text-lg">O epicentro tecnológico e educacional que impulsiona o município.</p>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 lg:gap-16">
            
            {{-- Lado Esquerdo: Descrição e Equipamentos --}}
            <div class="space-y-6">
                <div class="prose prose-slate prose-lg max-w-none text-slate-600 leading-relaxed">
                    <p>O núcleo desta transformação é a <strong>Agência de Inovação Vale do Sol</strong>, inaugurada em dezembro de 2023 com forte apoio da Secretaria Estadual de Inovação (SEI).</p>
                    <p>Localizado nas dependências do Colégio Estadual de Ensino Profissionalizante (CEEP) — que atende mais de 800 alunos de 9 municípios —, o complexo funciona como um laboratório prático formador de talentos para o desenvolvimento de startups, sistemas e aplicativos focados no agronegócio, engenharia elétrica, mecânica e automação integrada.</p>
                </div>

                <h3 class="text-xl font-extrabold text-slate-800 mt-10 mb-6 font-heading">Aparelhagem do Hub de Inovação</h3>
                
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div class="flex items-center gap-4 p-4 bg-slate-50 border border-slate-200 rounded-2xl hover:border-blue-300 hover:bg-blue-50 transition-colors group">
                        <div class="w-10 h-10 bg-white text-[#006eb7] border border-slate-200 rounded-xl flex items-center justify-center shrink-0 shadow-sm group-hover:bg-[#006eb7] group-hover:text-white group-hover:border-[#006eb7] transition-colors">
                            <i class="fa-solid fa-microphone-lines text-lg"></i>
                        </div>
                        <span class="font-bold text-slate-700 text-[15px]">Estúdio de Podcast</span>
                    </div>

                    <div class="flex items-center gap-4 p-4 bg-slate-50 border border-slate-200 rounded-2xl hover:border-blue-300 hover:bg-blue-50 transition-colors group">
                        <div class="w-10 h-10 bg-white text-[#006eb7] border border-slate-200 rounded-xl flex items-center justify-center shrink-0 shadow-sm group-hover:bg-[#006eb7] group-hover:text-white group-hover:border-[#006eb7] transition-colors">
                            <i class="fa-solid fa-vr-cardboard text-lg"></i>
                        </div>
                        <span class="font-bold text-slate-700 text-[15px]">Auditório Virtual</span>
                    </div>

                    <div class="flex items-center gap-4 p-4 bg-slate-50 border border-slate-200 rounded-2xl hover:border-blue-300 hover:bg-blue-50 transition-colors group">
                        <div class="w-10 h-10 bg-white text-[#006eb7] border border-slate-200 rounded-xl flex items-center justify-center shrink-0 shadow-sm group-hover:bg-[#006eb7] group-hover:text-white group-hover:border-[#006eb7] transition-colors">
                            <i class="fa-solid fa-laptop-code text-lg"></i>
                        </div>
                        <span class="font-bold text-slate-700 text-[15px]">Coworking de TI</span>
                    </div>

                    <div class="flex items-center gap-4 p-4 bg-slate-50 border border-slate-200 rounded-2xl hover:border-blue-300 hover:bg-blue-50 transition-colors group">
                        <div class="w-10 h-10 bg-white text-[#006eb7] border border-slate-200 rounded-xl flex items-center justify-center shrink-0 shadow-sm group-hover:bg-[#006eb7] group-hover:text-white group-hover:border-[#006eb7] transition-colors">
                            <i class="fa-solid fa-gears text-lg"></i>
                        </div>
                        <span class="font-bold text-slate-700 text-[15px]">Protótipos Mecânicos</span>
                    </div>
                </div>
            </div>

            {{-- Lado Direito: Meta Estratégica --}}
            <div class="bg-gradient-to-br from-[#006eb7] to-blue-900 rounded-[2.5rem] p-10 md:p-12 text-white flex flex-col justify-center shadow-xl relative overflow-hidden">
                {{-- Efeito de Círculos no Fundo --}}
                <div class="absolute top-0 right-0 w-64 h-64 bg-white/5 rounded-full blur-2xl transform translate-x-1/2 -translate-y-1/2 pointer-events-none"></div>
                <div class="absolute bottom-0 left-0 w-48 h-48 bg-blue-400/20 rounded-full blur-xl transform -translate-x-1/2 translate-y-1/4 pointer-events-none"></div>

                <div class="relative z-10">
                    <div class="inline-flex items-center gap-2 px-4 py-1.5 rounded-full bg-blue-800 border border-blue-700 mb-6 shadow-inner">
                        <i class="fa-regular fa-calendar-check text-yellow-400"></i>
                        <span class="text-[11px] font-extrabold tracking-[0.2em] text-blue-100 uppercase">Meta Estratégica 2022-2032</span>
                    </div>
                    
                    <h3 class="text-3xl lg:text-4xl font-black font-heading mb-6 leading-tight drop-shadow-md" style="font-family: 'Montserrat', sans-serif;">
                        A Primeira <span class="text-yellow-400 border-b-2 border-yellow-400/30 pb-1">"Cidade-Laboratório"</span> do Brasil
                    </h3>
                    
                    <p class="text-blue-100 text-base leading-relaxed font-light mb-8">
                        A audaciosa estratégia de Convergência Digital almeja integrar de forma profunda os setores público e privado para testar e escalar soluções urbanas em tempo real. O modelo visionário é financiado por editais estaduais de fomento e pelo Sistema Estadual de Parques Tecnológicos do Paraná (Separtec).
                    </p>
                </div>
            </div>

        </div>
    </div>
</section>

{{-- ===== CTA FINAL ===== --}}
<section class="py-20 relative overflow-hidden bg-[#006eb7]">
    {{-- Efeito de Fundo --}}
    <div class="absolute inset-0 pointer-events-none">
        <div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-[800px] h-[800px] bg-blue-500/20 rounded-full blur-[120px]"></div>
    </div>

    <div class="container relative z-10 px-4 mx-auto max-w-4xl text-center">
        <h2 class="text-3xl md:text-5xl font-extrabold font-heading leading-tight mb-8 text-white drop-shadow-sm" style="font-family: 'Montserrat', sans-serif;">
            Construindo juntos o <br class="hidden md:block"> amanhã de Assaí.
        </h2>
        <a href="{{ route('contato.index') }}" class="inline-flex items-center gap-3 px-8 py-4 font-bold text-[#006eb7] bg-yellow-400 rounded-full text-lg hover:bg-yellow-300 hover:scale-105 transition-all shadow-xl shadow-yellow-400/20 focus:ring-4 focus:ring-yellow-400/50 outline-none">
            Fale com a Prefeitura <i class="fa-solid fa-arrow-right"></i>
        </a>
    </div>
</section>

@endsection