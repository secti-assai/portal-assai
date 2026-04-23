@extends('layouts.app')
@section('title', 'Trabalhos Informais - Prefeitura Municipal de Assaí')

@section('content')
<style>
    body, html { overflow-x: hidden !important; }

    /* ---- Informal Jobs Page Custom Styles ---- */
    .informal-hero {
        background: linear-gradient(135deg, #b45309 0%, #d97706 50%, #f59e0b 100%);
        position: relative;
        overflow: hidden;
    }
    .informal-hero::before {
        content: '';
        position: absolute;
        inset: 0;
        background:
            radial-gradient(ellipse at 20% 50%, rgba(255,255,255,0.07) 0%, transparent 60%),
            radial-gradient(ellipse at 80% 20%, rgba(255,255,255,0.04) 0%, transparent 50%);
        pointer-events: none;
    }
    .informal-hero-pattern {
        position: absolute;
        inset: 0;
        background-image:
            linear-gradient(rgba(255,255,255,0.04) 1px, transparent 1px),
            linear-gradient(90deg, rgba(255,255,255,0.04) 1px, transparent 1px);
        background-size: 40px 40px;
        pointer-events: none;
    }

    /* Search bar */
    .informal-sticky-bar {
        position: sticky;
        top: 0;
        z-index: 40;
        background: #fff;
        border-bottom: 2px solid #fde68a;
        box-shadow: 0 2px 12px rgba(217,119,6,0.1);
    }

    /* Job card list style */
    .informal-card {
        border-bottom: 1px solid #fde68a;
        padding: 1.75rem 0;
        transition: background 0.15s;
    }
    .informal-card:first-child {
        border-top: 1px solid #fde68a;
    }
    .informal-card:hover {
        background: #fffbeb;
        border-radius: 8px;
        margin-left: -1rem;
        margin-right: -1rem;
        padding-left: 1rem;
        padding-right: 1rem;
    }
    .informal-title-link {
        color: #b45309;
        font-weight: 700;
        font-size: 1.15rem;
        line-height: 1.35;
        text-decoration: underline;
        text-decoration-color: transparent;
        transition: text-decoration-color 0.2s, color 0.2s;
    }
    .informal-title-link:hover {
        text-decoration-color: #b45309;
        color: #92400e;
    }
    .informal-meta-pill {
        display: inline-flex;
        align-items: center;
        gap: 0.3rem;
        font-size: 0.78rem;
        color: #78716c;
        font-weight: 500;
    }
    .informal-meta-pill i { color: #d97706; }

    .informal-share-btn {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        width: 28px;
        height: 28px;
        border-radius: 50%;
        border: 1px solid #fcd34d;
        color: #92400e;
        font-size: 0.7rem;
        transition: all 0.2s;
        text-decoration: none;
    }
    .informal-share-btn:hover {
        border-color: #d97706;
        color: #d97706;
        background: #fffbeb;
    }

    .informal-filter-btn {
        display: inline-flex;
        align-items: center;
        gap: 0.4rem;
        padding: 0.45rem 1rem;
        border: 1px solid #fcd34d;
        border-radius: 6px;
        font-size: 0.82rem;
        font-weight: 600;
        color: #78716c;
        background: #fff;
        cursor: pointer;
        transition: all 0.2s;
    }
    .informal-filter-btn:hover {
        border-color: #d97706;
        color: #b45309;
        background: #fffbeb;
    }
    .informal-filter-btn.active {
        border-color: #d97706;
        color: #b45309;
        background: #fffbeb;
    }

    .informal-badge {
        display: inline-flex;
        align-items: center;
        padding: 0.2rem 0.65rem;
        border-radius: 999px;
        font-size: 0.72rem;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.04em;
    }
    .badge-available { background: #dcfce7; color: #166534; }
    .badge-whatsapp { background: #d1fae5; color: #065f46; }
    .badge-temp { background: #fef3c7; color: #92400e; }

    .informal-benefits-section {
        background: #fff;
        border-bottom: 1px solid #fde68a;
    }

    .informal-search-input {
        border: 1px solid #fcd34d;
        border-radius: 8px;
        padding: 0.6rem 1rem 0.6rem 2.75rem;
        font-size: 0.9rem;
        width: 100%;
        outline: none;
        transition: border-color 0.2s, box-shadow 0.2s;
        background: #fffbeb;
    }
    .informal-search-input:focus {
        border-color: #d97706;
        box-shadow: 0 0 0 3px rgba(217,119,6,0.12);
        background: #fff;
    }

    .informal-empty-icon {
        width: 80px;
        height: 80px;
        background: #fef3c7;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto 1.5rem;
    }

    @media (max-width: 640px) {
        .informal-card:hover {
            margin-left: -0.25rem;
            margin-right: -0.25rem;
            padding-left: 0.25rem;
            padding-right: 0.25rem;
        }
    }
</style>

{{-- ======================================================= --}}
{{--   HERO SECTION                                           --}}
{{-- ======================================================= --}}
<section class="informal-hero pt-[calc(var(--site-header-height,72px))] pb-12 sm:pb-16 md:pb-20 w-full">
    <div class="informal-hero-pattern"></div>
    <div class="container relative z-10 px-4 sm:px-6 md:px-8 mx-auto max-w-6xl">
        <div class="mt-6 md:mt-10">
            {{-- Badge --}}
            <span class="inline-flex items-center gap-2 px-4 py-1.5 mb-5 text-xs font-bold tracking-widest text-amber-900 uppercase bg-yellow-200 rounded-full shadow-sm">
                <i class="fa-solid fa-toolbox"></i>
                Bicos, Freelancers e Autônomos
            </span>
            {{-- Title --}}
            <h1 class="text-4xl sm:text-5xl md:text-6xl font-extrabold text-white drop-shadow-sm leading-tight mb-4" style="font-family: 'Montserrat', sans-serif;">
                Trabalhos<br class="hidden sm:block"> Informais
            </h1>
            <p class="text-lg sm:text-xl text-amber-100 leading-relaxed font-light max-w-2xl">
                Serviços temporários, bicos e oportunidades para autônomos em Assaí. Conecte-se com quem precisa do seu talento.
            </p>
            {{-- Quick stats --}}
            <div class="flex flex-wrap gap-6 mt-8">
                <div class="flex items-center gap-2 text-white/90 text-sm font-medium">
                    <i class="fa-solid fa-wrench text-yellow-300"></i>
                    <span><strong class="text-white text-base font-extrabold">{{ $vagas->count() }}</strong> serviços disponíveis</span>
                </div>
                <div class="flex items-center gap-2 text-white/90 text-sm font-medium">
                    <i class="fa-solid fa-map-marker-alt text-yellow-300"></i>
                    <span>Assaí, Paraná</span>
                </div>
                <div class="flex items-center gap-2 text-white/90 text-sm font-medium">
                    <i class="fa-brands fa-whatsapp text-yellow-300"></i>
                    <span>Contato direto pelo WhatsApp</span>
                </div>
            </div>
        </div>
    </div>
</section>

{{-- ======================================================= --}}
{{--   BENEFITS COLLAPSIBLE SECTION                          --}}
{{-- ======================================================= --}}
<section class="informal-benefits-section" x-data="{ open: false }">
    <div class="container px-4 sm:px-6 mx-auto max-w-6xl py-6">
        <p class="text-sm font-bold text-stone-700 uppercase tracking-wider mb-3">
            VANTAGENS DO TRABALHO INFORMAL EM ASSAÍ:
        </p>
        <div class="relative">
            <ul class="space-y-1 text-sm text-stone-600" :class="open ? '' : 'max-h-[4.5rem] overflow-hidden'">
                <li class="flex items-center gap-2"><i class="fa-solid fa-check text-amber-500 text-xs"></i> Flexibilidade de horários e local de trabalho</li>
                <li class="flex items-center gap-2"><i class="fa-solid fa-check text-amber-500 text-xs"></i> Sem necessidade de vínculo empregatício formal</li>
                <li class="flex items-center gap-2"><i class="fa-solid fa-check text-amber-500 text-xs"></i> Contato direto entre contratante e prestador</li>
                <li class="flex items-center gap-2"><i class="fa-solid fa-check text-amber-500 text-xs"></i> Renda extra para complementar seu orçamento</li>
                <li class="flex items-center gap-2"><i class="fa-solid fa-check text-amber-500 text-xs"></i> Oportunidade de mostrar seu trabalho na comunidade</li>
                <li class="flex items-center gap-2"><i class="fa-solid fa-check text-amber-500 text-xs"></i> Pagamento combinado diretamente com o contratante</li>
                <li class="flex items-center gap-2"><i class="fa-solid fa-check text-amber-500 text-xs"></i> Divulgação gratuita pelo portal da prefeitura</li>
            </ul>
            <div x-show="!open" class="absolute bottom-0 left-0 right-0 h-8 bg-gradient-to-t from-white to-transparent pointer-events-none" style="display: block;"></div>
        </div>
        <button @click="open = !open"
            class="mt-3 text-xs font-bold uppercase tracking-widest text-amber-700 border-b-2 border-amber-600 hover:text-amber-900 hover:border-amber-800 transition-colors focus:outline-none">
            <span x-text="open ? '↑ VER MENOS' : '↓ VER MAIS'">↓ VER MAIS</span>
        </button>
    </div>
</section>

{{-- ======================================================= --}}
{{--   STICKY SEARCH BAR + FILTERS                           --}}
{{-- ======================================================= --}}
<div class="informal-sticky-bar"
    x-data="{
        search: '',
        sort: 'default',
        showFilters: false,
        filterContato: ''
    }"
    x-init="
        $watch('search', () => filterInformalJobs());
        $watch('sort', () => sortInformalJobs());
        $watch('filterContato', () => filterInformalJobs());

        function filterInformalJobs() {
            const q = search.toLowerCase();
            const c = filterContato.toLowerCase();
            document.querySelectorAll('[data-informal]').forEach(card => {
                const title = (card.dataset.titulo || '').toLowerCase();
                const contato = (card.dataset.contato || '').toLowerCase();
                const desc = (card.dataset.descricao || '').toLowerCase();
                const matchQ = !q || title.includes(q) || contato.includes(q) || desc.includes(q);
                const matchC = !c || contato.includes(c);
                card.hidden = !(matchQ && matchC);
            });
            updateInformalCount();
        }

        function sortInformalJobs() {
            const container = document.getElementById('informal-list');
            if (!container) return;
            const cards = Array.from(container.querySelectorAll('[data-informal]'));
            if (sort === 'az') {
                cards.sort((a, b) => (a.dataset.titulo || '').localeCompare(b.dataset.titulo || ''));
            } else if (sort === 'za') {
                cards.sort((a, b) => (b.dataset.titulo || '').localeCompare(a.dataset.titulo || ''));
            } else if (sort === 'recent') {
                cards.sort((a, b) => parseInt(b.dataset.ts || 0) - parseInt(a.dataset.ts || 0));
            }
            cards.forEach(c => container.appendChild(c));
            updateInformalCount();
        }

        function updateInformalCount() {
            const el = document.getElementById('informal-count');
            if (el) el.textContent = document.querySelectorAll('[data-informal]:not([hidden])').length;
        }
    ">

    <div class="container px-4 sm:px-6 mx-auto max-w-6xl py-3">
        <div class="flex flex-col sm:flex-row items-stretch sm:items-center gap-3">
            {{-- Search --}}
            <div class="relative flex-1">
                <i class="fa-solid fa-magnifying-glass absolute left-3 top-1/2 -translate-y-1/2 text-amber-400 text-sm pointer-events-none"></i>
                <input
                    type="text"
                    class="informal-search-input"
                    placeholder="Buscar serviços informais..."
                    x-model="search"
                    id="informal-search-input">
            </div>

            {{-- Count + Controls --}}
            <div class="flex items-center gap-2 shrink-0">
                <span class="text-sm text-stone-500 font-medium whitespace-nowrap">
                    <span id="informal-count" class="font-bold text-stone-800">{{ $vagas->count() }}</span>
                    serviços encontrados
                </span>

                <div class="h-4 w-px bg-amber-200 mx-1"></div>

                {{-- Sort --}}
                <select x-model="sort"
                    class="informal-filter-btn text-xs cursor-pointer border-0 focus:outline-none pr-6 bg-white border border-amber-200 rounded-md px-3 py-2"
                    style="appearance: none; background-image: url('data:image/svg+xml;charset=utf-8,<svg xmlns=%22http://www.w3.org/2000/svg%22 viewBox=%220 0 16 16%22><path fill=%22%2392400e%22 d=%22M8 11L3 6h10z%22/></svg>'); background-repeat: no-repeat; background-position: right 8px center; background-size: 12px;">
                    <option value="default">↕ Ordenar</option>
                    <option value="recent">Mais Recentes</option>
                    <option value="az">A → Z</option>
                    <option value="za">Z → A</option>
                </select>

                {{-- Filter toggle --}}
                <button @click="showFilters = !showFilters" :class="showFilters ? 'active' : ''" class="informal-filter-btn">
                    <i class="fa-solid fa-sliders text-xs"></i>
                    <span class="hidden sm:inline">Filtrar</span>
                </button>
            </div>
        </div>

        {{-- Expanded filters --}}
        <div x-show="showFilters" x-transition:enter="transition ease-out duration-200"
            x-transition:enter-start="opacity-0 -translate-y-1" x-transition:enter-end="opacity-100 translate-y-0"
            x-transition:leave="transition ease-in duration-150"
            x-transition:leave-start="opacity-100 translate-y-0" x-transition:leave-end="opacity-0 -translate-y-1"
            class="pt-3 border-t border-amber-100 mt-3" style="display: none;">
            <div class="flex flex-wrap gap-2 items-center">
                <span class="text-xs font-semibold text-stone-500 uppercase tracking-wider mr-2">Contato:</span>
                @php
                    $contatos = $vagas->pluck('setor_ou_contato')->filter()->unique()->sort()->values();
                @endphp
                <button @click="filterContato = ''" :class="filterContato === '' ? 'bg-amber-500 text-white border-amber-500' : 'bg-white text-stone-600 border-amber-200'"
                    class="px-3 py-1 text-xs font-semibold border rounded-full transition-colors hover:border-amber-500">
                    Todos
                </button>
                @foreach($contatos as $contato)
                <button @click="filterContato = '{{ Str::lower($contato) }}'"
                    :class="filterContato === '{{ Str::lower($contato) }}' ? 'bg-amber-500 text-white border-amber-500' : 'bg-white text-stone-600 border-amber-200'"
                    class="px-3 py-1 text-xs font-semibold border rounded-full transition-colors hover:border-amber-500">
                    {{ $contato }}
                </button>
                @endforeach
            </div>
        </div>
    </div>
</div>

{{-- ======================================================= --}}
{{--   INFORMAL JOB LISTINGS                                  --}}
{{-- ======================================================= --}}
<section class="bg-white py-4 w-full overflow-x-hidden">
    <div class="container px-4 sm:px-6 mx-auto max-w-6xl">

        @if($vagas->isEmpty())
        {{-- ---- EMPTY STATE ---- --}}
        <div class="py-24 text-center">
            <div class="informal-empty-icon">
                <i class="fa-solid fa-toolbox text-3xl text-amber-300"></i>
            </div>
            <h2 class="text-xl font-bold text-stone-700 mb-2">Nenhum serviço informal disponível no momento</h2>
            <p class="text-stone-500 max-w-md mx-auto mb-6">
                Continue acompanhando nosso portal. Novas oportunidades são publicadas regularmente.
            </p>
            <a href="{{ url('/') }}" class="inline-flex items-center gap-2 px-5 py-2.5 bg-amber-500 text-white font-semibold rounded-lg hover:bg-amber-600 transition-colors text-sm">
                <i class="fa-solid fa-house"></i> Voltar ao início
            </a>
        </div>
        @else
        {{-- ---- LIST ---- --}}
        <div id="informal-list" class="divide-y divide-transparent">
            @foreach($vagas as $vaga)
            @php
                $ts = $vaga->created_at ? $vaga->created_at->timestamp : 0;
                $shareUrl = urlencode(request()->url() . '#informal-' . $vaga->id);
                $shareTitle = urlencode('Serviço Informal: ' . $vaga->titulo . ' - Portal de Assaí');
                $isWhatsApp = $vaga->link_acao && str_contains($vaga->link_acao, 'wa.me');
            @endphp
            <div class="informal-card"
                id="informal-{{ $vaga->id }}"
                data-informal
                data-titulo="{{ strtolower($vaga->titulo) }}"
                data-contato="{{ strtolower($vaga->setor_ou_contato ?? '') }}"
                data-descricao="{{ strtolower(Str::limit($vaga->descricao ?? '', 300)) }}"
                data-ts="{{ $ts }}">

                <div class="flex flex-col md:flex-row md:items-start gap-4">
                    {{-- Content --}}
                    <div class="flex-1 min-w-0">
                        {{-- Title --}}
                        @if($vaga->link_acao)
                            <a href="{{ $vaga->link_acao }}" target="_blank" rel="noopener noreferrer" class="informal-title-link block mb-1">
                                {{ $vaga->titulo }}
                            </a>
                        @else
                            <h2 class="informal-title-link block mb-1 cursor-default">{{ $vaga->titulo }}</h2>
                        @endif

                        {{-- Meta row --}}
                        <div class="flex flex-wrap gap-x-4 gap-y-1.5 mt-2 mb-3">
                            @if($vaga->setor_ou_contato)
                            <span class="informal-meta-pill">
                                <i class="fa-solid fa-phone fa-xs"></i>
                                {{ $vaga->setor_ou_contato }}
                            </span>
                            @endif
                            @if($vaga->created_at)
                            <span class="informal-meta-pill">
                                <i class="fa-regular fa-clock fa-xs"></i>
                                Publicado {{ $vaga->created_at->diffForHumans() }}
                            </span>
                            @endif
                            @if($isWhatsApp)
                            <span class="informal-meta-pill">
                                <i class="fa-brands fa-whatsapp fa-xs" style="color:#25d366;"></i>
                                <span class="text-green-700">Contato via WhatsApp</span>
                            </span>
                            @endif
                        </div>

                        {{-- Description --}}
                        @if($vaga->descricao)
                        <p class="text-stone-600 text-sm leading-relaxed line-clamp-3">
                            {{ $vaga->descricao }}
                        </p>
                        @endif

                        {{-- Bottom row: Share + Actions --}}
                        <div class="flex items-center justify-between flex-wrap gap-3 mt-4">
                            {{-- Share icons --}}
                            <div class="flex items-center gap-1.5">
                                <span class="text-xs text-stone-400 mr-1">Compartilhar:</span>
                                @if($isWhatsApp)
                                <a href="{{ $vaga->link_acao }}"
                                    target="_blank" rel="noopener noreferrer" class="informal-share-btn" title="Contatar no WhatsApp"
                                    style="border-color: #25d366; color: #25d366;">
                                    <i class="fa-brands fa-whatsapp"></i>
                                </a>
                                @endif
                                <a href="https://wa.me/?text={{ $shareTitle }}%20{{ $shareUrl }}"
                                    target="_blank" rel="noopener noreferrer" class="informal-share-btn" title="Compartilhar no WhatsApp">
                                    <i class="fa-brands fa-whatsapp"></i>
                                </a>
                                <a href="https://www.facebook.com/sharer/sharer.php?u={{ $shareUrl }}"
                                    target="_blank" rel="noopener noreferrer" class="informal-share-btn" title="Compartilhar no Facebook">
                                    <i class="fa-brands fa-facebook-f"></i>
                                </a>
                                <a href="mailto:?subject={{ $shareTitle }}&body={{ $shareUrl }}" class="informal-share-btn" title="Compartilhar por e-mail">
                                    <i class="fa-solid fa-envelope"></i>
                                </a>
                            </div>

                            {{-- Badge + CTA --}}
                            <div class="flex items-center gap-2">
                                <span class="informal-badge badge-available">
                                    <i class="fa-solid fa-circle-check mr-1 text-xs"></i> Disponível
                                </span>

                                @if($vaga->link_acao)
                                <a href="{{ $vaga->link_acao }}" target="_blank" rel="noopener noreferrer"
                                    class="inline-flex items-center gap-1.5 px-4 py-1.5 bg-amber-500 text-white text-xs font-bold rounded-lg hover:bg-amber-600 transition-colors whitespace-nowrap">
                                    @if($isWhatsApp)
                                        <i class="fa-brands fa-whatsapp fa-xs"></i> Entrar em contato
                                    @else
                                        Ver detalhes <i class="fa-solid fa-arrow-right fa-xs"></i>
                                    @endif
                                </a>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach

            {{-- No results after filter --}}
            <div id="informal-no-results" class="hidden py-16 text-center">
                <div class="informal-empty-icon">
                    <i class="fa-solid fa-magnifying-glass text-2xl text-amber-200"></i>
                </div>
                <p class="text-stone-500 font-medium">Nenhum serviço encontrado para a busca.</p>
            </div>
        </div>

        {{-- Pagination --}}
        @if(method_exists($vagas, 'links'))
        <div class="mt-10 flex justify-center">
            {{ $vagas->links() }}
        </div>
        @endif

        @endif
    </div>
</section>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const observer = new MutationObserver(function () {
        const visible = document.querySelectorAll('[data-informal]:not([hidden])').length;
        const noResults = document.getElementById('informal-no-results');
        if (noResults) {
            noResults.classList.toggle('hidden', visible > 0);
        }
        const countEl = document.getElementById('informal-count');
        if (countEl) countEl.textContent = visible;
    });

    document.querySelectorAll('[data-informal]').forEach(el => {
        observer.observe(el, { attributes: true, attributeFilter: ['hidden'] });
    });
});
</script>

@endsection