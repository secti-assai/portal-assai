@extends('layouts.app')

@section('title', 'FAQ & Ajuda - Prefeitura de Assaí')

@section('content')

{{-- ===== CABEÇALHO PADRONIZADO (HERO) ===== --}}
<section class="relative py-12 overflow-hidden bg-gradient-to-br from-blue-900 via-blue-800 to-blue-700 md:py-16 lg:py-20" style="padding-top: calc(var(--site-header-height, 100px) + 2rem);">
    <div class="absolute inset-0 pointer-events-none">
        <svg class="absolute w-full h-full opacity-10 text-blue-300" xmlns="http://www.w3.org/2000/svg">
            <defs>
                <pattern id="faq-pattern" width="60" height="60" patternUnits="userSpaceOnUse">
                    <path d="M 60 0 L 0 0 0 60" fill="none" stroke="currentColor" stroke-width="0.5"/>
                    <circle cx="30" cy="30" r="1.5" fill="currentColor"/>
                </pattern>
            </defs>
            <rect width="100%" height="100%" fill="url(#faq-pattern)"/>
        </svg>
        <div class="absolute top-0 right-0 w-96 h-96 bg-blue-400/20 rounded-full blur-3xl -mr-48 -mt-48"></div>
        <div class="absolute bottom-0 left-0 w-64 h-64 bg-yellow-400/10 rounded-full blur-3xl -ml-32 -mb-32"></div>
    </div>
    
    <div class="container relative z-10 px-4 mx-auto max-w-5xl text-center">
        <nav aria-label="Breadcrumb" class="mb-6 flex justify-center">
            <ol class="flex items-center gap-2 text-sm text-blue-200/80">
                <li><a href="{{ route('home') }}" class="hover:text-white transition-colors flex items-center gap-1"><i class="fa-solid fa-house text-[10px]"></i> Início</a></li>
                <li><i class="fa-solid fa-chevron-right text-[8px] opacity-50"></i></li>
                <li class="text-white font-medium" aria-current="page">FAQ & Ajuda</li>
            </ol>
        </nav>
        
        <h1 class="text-4xl md:text-6xl font-black text-white font-heading mb-6 tracking-tight drop-shadow-sm" style="font-family: 'Montserrat', sans-serif;">
            Como podemos <span class="text-yellow-300">ajudar?</span>
        </h1>
        
        <p class="text-xl text-blue-50 max-w-2xl leading-relaxed font-light mx-auto mb-10">
            Encontre respostas rápidas e orientações sobre os serviços, tributos e projetos da Prefeitura de Assaí.
        </p>

        {{-- Barra de Busca --}}
        <div class="max-w-2xl mx-auto relative group" x-data="{ searchFocus: false }">
            <div class="absolute inset-y-0 left-5 flex items-center pointer-events-none transition-colors" :class="searchFocus ? 'text-blue-600' : 'text-gray-400'">
                <i class="fa-solid fa-magnifying-glass text-lg"></i>
            </div>
            <input 
                type="text" 
                id="faq-search-input"
                placeholder="Busque por 'IPTU', 'Saúde', 'Matrícula'..." 
                class="w-full pl-14 pr-6 py-5 bg-white rounded-2xl shadow-2xl shadow-blue-900/20 border-none focus:ring-4 focus:ring-yellow-400/50 text-gray-800 text-lg font-medium placeholder-gray-400 transition-all outline-none"
                @focus="searchFocus = true"
                @blur="searchFocus = false"
                x-model="searchQuery"
            >
            <div class="absolute right-4 inset-y-0 flex items-center">
                <span class="px-2 py-1 bg-gray-100 text-[10px] font-bold text-gray-400 rounded uppercase tracking-tighter" x-show="!searchQuery">ESC para limpar</span>
                <button @click="searchQuery = ''" x-show="searchQuery" class="p-2 text-gray-400 hover:text-red-500 transition-colors">
                    <i class="fa-solid fa-circle-xmark text-lg"></i>
                </button>
            </div>
        </div>
    </div>
</section>

{{-- ===== CONTEÚDO PRINCIPAL (INTERATIVO) ===== --}}
<main 
    id="conteudo-principal" 
    accesskey="1" 
    tabindex="-1" 
    class="bg-[#f8fbff] pb-24 min-h-screen"
    x-data="{ 
        searchQuery: '', 
        activeCategory: 'all',
        categories: [
            { id: 'all', label: 'Tudo', icon: 'fa-layer-group' },
            { id: 'tributos', label: 'Tributos', icon: 'fa-file-invoice-dollar' },
            { id: 'saude', label: 'Saúde', icon: 'fa-heart-pulse' },
            { id: 'educacao', label: 'Educação', icon: 'fa-graduation-cap' },
            { id: 'servicos', label: 'Serviços', icon: 'fa-faucet-drip' },
            { id: 'smart', label: 'Smart City', icon: 'fa-microchip' }
        ],
        faqs: [
            { id: 1, cat: 'tributos', q: 'Como emitir a Nota Fiscal Eletrônica?', a: 'Acesse o portal e-Nota no menu Serviços &rarr; Nota Fiscal Eletrônica. É necessário cadastro prévio junto ao setor de tributação municipal.', icon: 'fa-file-invoice-dollar', color: 'blue' },
            { id: 2, cat: 'tributos', q: 'Como consultar e emitir a guia do IPTU?', a: 'No portal de serviços, selecione IPTU Digital e informe o número do cadastro do imóvel ou CPF/CNPJ do proprietário.', icon: 'fa-house-chimney', color: 'emerald' },
            { id: 3, cat: 'tributos', q: 'Existe isenção de IPTU para idosos?', a: 'Sim, para idosos com renda limitada e único imóvel. A solicitação deve ser feita anualmente no balcão de atendimento da Prefeitura.', icon: 'fa-user-clock', color: 'indigo' },
            { id: 4, cat: 'saude', q: 'Como agendar consultas pelo aplicativo?', a: 'Baixe o App GovAssaí, acesse a aba Saúde e utilize sua conta Sou Assaiense para escolher a especialidade e horário disponível.', icon: 'fa-mobile-screen-button', color: 'red' },
            { id: 5, cat: 'saude', q: 'Onde encontro o calendário de vacinação?', a: 'O calendário atualizado fica disponível na seção Saúde do portal e também é divulgado em nossas redes sociais oficiais.', icon: 'fa-syringe', color: 'sky' },
            { id: 6, cat: 'educacao', q: 'Como realizar a matrícula escolar?', a: 'As matrículas para a rede municipal ocorrem geralmente em novembro. Fique atento aos editais publicados no Diário Oficial e no portal.', icon: 'fa-school', color: 'amber' },
            { id: 7, cat: 'servicos', q: 'Como solicitar reparo na iluminação pública?', a: 'Você pode solicitar pelo telefone 156 ou diretamente no App GovAssaí, informando o endereço e o número do poste se possível.', icon: 'fa-lightbulb', color: 'yellow' },
            { id: 8, cat: 'smart', q: 'O que é o projeto Assaí Smart City?', a: 'É o conjunto de iniciativas tecnológicas que visam melhorar a vida do cidadão, como Wi-Fi grátis, iluminação inteligente e desburocratização digital.', icon: 'fa-brain', color: 'purple' },
            { id: 9, cat: 'smart', q: 'Como utilizar o Wi-Fi público gratuito?', a: 'Conecte-se à rede Assai_Smart_City e faça o login usando seu CPF ou conta das redes sociais para navegar gratuitamente.', icon: 'fa-wifi', color: 'cyan' },
            { id: 10, cat: 'servicos', q: 'Qual o cronograma da coleta seletiva?', a: 'O cronograma completo por bairro está disponível em Serviços &rarr; Meio Ambiente. A coleta seletiva ocorre em dias alternados à coleta comum.', icon: 'fa-recycle', color: 'green' },
            { id: 11, cat: 'saude', q: 'Como solicitar medicamentos de alto custo?', a: 'Dirija-se à Farmácia Municipal com a receita médica e documentos pessoais para abertura do processo administrativo.', icon: 'fa-pills', color: 'rose' },
            { id: 12, cat: 'educacao', q: 'Como solicitar o transporte universitário?', a: 'A prefeitura oferece auxílio e linhas específicas. O cadastro é feito semestralmente na Secretaria de Educação.', icon: 'fa-bus', color: 'orange' },
            { id: 13, cat: 'smart', q: 'Quais os benefícios do cartão Sou Assaiense?', a: 'O cartão unifica o acesso a serviços municipais, oferece descontos em eventos locais e agiliza atendimentos em postos de saúde.', icon: 'fa-id-card', color: 'blue' },
            { id: 14, cat: 'tributos', q: 'Como obter a Certidão Negativa de Débitos?', a: 'A CND pode ser emitida instantaneamente no Portal da Transparência, informando o CPF ou CNPJ do contribuinte.', icon: 'fa-stamp', color: 'slate' },
            { id: 15, cat: 'servicos', q: 'Como solicitar a poda de árvores?', a: 'A poda em áreas públicas deve ser solicitada à Secretaria de Meio Ambiente via Protocolo Digital no portal.', icon: 'fa-leaf', color: 'emerald' }
        ],
        get filteredFaqs() {
            return this.faqs.filter(i => {
                const matchSearch = i.q.toLowerCase().includes(this.searchQuery.toLowerCase()) || 
                                    i.a.toLowerCase().includes(this.searchQuery.toLowerCase());
                const matchCat = this.activeCategory === 'all' || i.cat === this.activeCategory;
                return matchSearch && matchCat;
            });
        }
    }"
>
    <div class="container max-w-5xl mx-auto px-4">
        
        {{-- Filtros de Categoria --}}
        <div class="flex flex-wrap justify-center gap-3 -mt-8 mb-12 relative z-30">
            <template x-for="cat in categories" :key="cat.id">
                <button 
                    @click="activeCategory = cat.id"
                    class="flex items-center gap-2 px-5 py-3 rounded-2xl font-bold text-sm transition-all shadow-sm border border-transparent"
                    :class="activeCategory === cat.id 
                        ? 'bg-yellow-400 text-blue-950 shadow-yellow-400/20 scale-105' 
                        : 'bg-white text-gray-500 hover:bg-gray-50 hover:text-blue-700'"
                >
                    <i class="fa-solid" :class="cat.icon"></i>
                    <span x-text="cat.label"></span>
                </button>
            </template>
        </div>

        {{-- Info Box --}}
        <div class="mb-10" x-show="!searchQuery && activeCategory === 'all'">
            <div class="flex items-center gap-4 bg-white border-l-4 border-blue-500 rounded-xl px-6 py-5 shadow-sm">
                <div class="w-10 h-10 rounded-full bg-blue-50 flex items-center justify-center text-blue-500 shrink-0">
                    <i class="fa-solid fa-circle-info text-lg"></i>
                </div>
                <p class="text-gray-600 text-[15px] leading-relaxed font-medium">
                    As respostas abaixo são orientações gerais. Para casos específicos, recomendamos o uso do <strong class="text-blue-700">Protocolo Digital</strong> ou atendimento presencial na Prefeitura.
                </p>
            </div>
        </div>

        {{-- Lista de FAQs --}}
        <div class="space-y-4 min-h-[400px]">
            
            {{-- Empty State --}}
            <div x-show="filteredFaqs.length === 0" x-cloak class="py-20 text-center">
                <div class="w-24 h-24 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-6">
                    <i class="fa-solid fa-face-frown text-4xl text-gray-300"></i>
                </div>
                <h3 class="text-2xl font-bold text-gray-800 mb-2">Nenhum resultado encontrado</h3>
                <p class="text-gray-500">Tente buscar por termos diferentes ou selecione outra categoria.</p>
                <button @click="searchQuery = ''; activeCategory = 'all'" class="mt-6 text-blue-600 font-bold hover:underline">Limpar todos os filtros</button>
            </div>

            <template x-for="item in filteredFaqs" :key="item.id">
                <details 
                    class="group bg-white border border-slate-200 rounded-2xl shadow-sm overflow-hidden hover:border-blue-300 hover:shadow-md transition-all [&_summary::-webkit-details-marker]:hidden"
                    :open="searchQuery.length > 2"
                >
                    <summary class="flex cursor-pointer items-center justify-between gap-4 p-5 md:p-6 bg-white group-open:bg-blue-50/50 transition-colors select-none focus:outline-none">
                        <div class="flex items-center gap-5">
                            <div 
                                class="w-12 h-12 rounded-xl flex items-center justify-center shrink-0 shadow-inner group-open:shadow-none transition-all"
                                :class="`bg-${item.color}-100 text-${item.color}-600 group-open:bg-${item.color}-600 group-open:text-white`"
                            >
                                <i class="fa-solid text-xl" :class="item.icon"></i>
                            </div>
                            <h2 class="text-base md:text-lg font-bold text-slate-800 group-open:text-blue-700 transition-colors" x-text="item.q"></h2>
                        </div>
                        <div class="w-8 h-8 rounded-full bg-slate-50 flex items-center justify-center shrink-0 group-open:bg-blue-100 transition-colors border border-slate-200">
                            <i class="fa-solid fa-chevron-down text-slate-400 group-open:text-blue-600 transition-transform duration-300 group-open:-rotate-180 text-xs"></i>
                        </div>
                    </summary>
                    <div class="px-5 md:px-6 pb-6 pt-2 text-slate-600 leading-relaxed bg-blue-50/30">
                        <div class="md:pl-[4.25rem] text-[16px] border-l-2 border-gray-200 md:border-none pl-4">
                            <span x-html="item.a"></span>
                        </div>
                    </div>
                </details>
            </template>
        </div>

        {{-- CALL TO ACTION (CTA) FINAL --}}
        <div class="mt-20 bg-white border border-slate-200 rounded-[2.5rem] p-8 md:p-14 flex flex-col md:flex-row items-center justify-between gap-10 shadow-2xl shadow-blue-900/5 relative overflow-hidden">
            <div class="absolute top-0 right-0 p-8 opacity-[0.03] pointer-events-none">
                <i class="fa-solid fa-headset text-[12rem]"></i>
            </div>
            <div class="relative z-10 text-center md:text-left">
                <span class="inline-block px-4 py-1 bg-blue-50 text-blue-600 text-[10px] font-black uppercase tracking-[0.2em] rounded-full mb-4">Ainda com dúvidas?</span>
                <h3 class="text-3xl md:text-4xl font-black text-slate-900 mb-4" style="font-family: 'Montserrat', sans-serif;">Nossa equipe está <br class="hidden md:block"> aqui para você.</h3>
                <p class="text-slate-500 text-lg max-w-md">Se você não encontrou o que procurava, utilize nossos canais oficiais de atendimento direto.</p>
            </div>
            <div class="flex flex-col sm:flex-row gap-4 w-full md:w-auto shrink-0 relative z-10">
                <a href="https://www.govfacilcidadao.com.br/login" target="_blank" rel="noopener" class="px-8 py-4 bg-blue-600 text-white font-bold rounded-2xl hover:bg-blue-700 hover:-translate-y-1 transition-all text-center shadow-lg shadow-blue-600/20 flex items-center justify-center gap-3 w-full sm:w-auto">
                    <i class="fa-solid fa-headset text-lg"></i> Ouvidoria Digital
                </a>
            </div>
        </div>
    </div>
</main>

{{-- Script para fechar todos ao mudar busca ou categoria --}}
<script>
    document.addEventListener('alpine:init', () => {
        // Alpine já está inicializado via CDN no layout, mas podemos adicionar lógica aqui se necessário
    });
    
    // Adicionar listener para tecla ESC no input de busca
    document.addEventListener('keydown', (e) => {
        if (e.key === 'Escape' && document.activeElement.id === 'faq-search-input') {
            document.activeElement.blur();
        }
    });
</script>

<style>
    /* Estilos personalizados para o editor content (rich text) */
    .editor-content strong {
        color: #1e3a8a;
        font-weight: 800;
    }
    
    [x-cloak] { display: none !important; }

    /* Custom classes for dynamic colors in template loop */
    .bg-blue-100 { background-color: #dbeafe; } .text-blue-600 { color: #2563eb; } .group-open\:bg-blue-600:where(.group[open]) { background-color: #2563eb; }
    .bg-emerald-100 { background-color: #d1fae5; } .text-emerald-600 { color: #059669; } .group-open\:bg-emerald-600:where(.group[open]) { background-color: #059669; }
    .bg-indigo-100 { background-color: #e0e7ff; } .text-indigo-600 { color: #4f46e5; } .group-open\:bg-indigo-600:where(.group[open]) { background-color: #4f46e5; }
    .bg-red-100 { background-color: #fee2e2; } .text-red-600 { color: #dc2626; } .group-open\:bg-red-600:where(.group[open]) { background-color: #dc2626; }
    .bg-sky-100 { background-color: #e0f2fe; } .text-sky-600 { color: #0284c7; } .group-open\:bg-sky-600:where(.group[open]) { background-color: #0284c7; }
    .bg-amber-100 { background-color: #fef3c7; } .text-amber-600 { color: #d97706; } .group-open\:bg-amber-600:where(.group[open]) { background-color: #d97706; }
    .bg-yellow-100 { background-color: #fef9c3; } .text-yellow-600 { color: #ca8a04; } .group-open\:bg-yellow-600:where(.group[open]) { background-color: #ca8a04; }
    .bg-purple-100 { background-color: #f3e8ff; } .text-purple-600 { color: #9333ea; } .group-open\:bg-purple-600:where(.group[open]) { background-color: #9333ea; }
    .bg-cyan-100 { background-color: #cffafe; } .text-cyan-600 { color: #0891b2; } .group-open\:bg-cyan-600:where(.group[open]) { background-color: #0891b2; }
    .bg-green-100 { background-color: #dcfce7; } .text-green-600 { color: #16a34a; } .group-open\:bg-green-600:where(.group[open]) { background-color: #16a34a; }
    .bg-rose-100 { background-color: #ffe4e6; } .text-rose-600 { color: #e11d48; } .group-open\:bg-rose-600:where(.group[open]) { background-color: #e11d48; }
    .bg-orange-100 { background-color: #ffedd5; } .text-orange-600 { color: #ea580c; } .group-open\:bg-orange-600:where(.group[open]) { background-color: #ea580c; }
    .bg-slate-100 { background-color: #f1f5f9; } .text-slate-600 { color: #475569; } .group-open\:bg-slate-600:where(.group[open]) { background-color: #475569; }
</style>
@endsection