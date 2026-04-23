@extends('layouts.app')
@section('title', 'Oportunidades de Trabalho - Prefeitura Municipal de Assaí')

@section('content')
<style>
    body, html { overflow-x: hidden !important; }

    /* ---- Jobs Page Custom Styles ---- */
    .jobs-hero {
        background: linear-gradient(135deg, #004f8b 0%, #006eb7 50%, #0085d4 100%);
        position: relative;
        overflow: hidden;
    }
    .jobs-hero::before {
        content: '';
        position: absolute;
        inset: 0;
        background:
            radial-gradient(ellipse at 20% 50%, rgba(255,255,255,0.06) 0%, transparent 60%),
            radial-gradient(ellipse at 80% 20%, rgba(255,255,255,0.04) 0%, transparent 50%);
        pointer-events: none;
    }
    .jobs-hero-pattern {
        position: absolute;
        inset: 0;
        background-image:
            linear-gradient(rgba(255,255,255,0.03) 1px, transparent 1px),
            linear-gradient(90deg, rgba(255,255,255,0.03) 1px, transparent 1px);
        background-size: 40px 40px;
        pointer-events: none;
    }

    /* Search bar */
    .search-sticky-bar {
        position: sticky;
        top: 0;
        z-index: 40;
        background: #fff;
        border-bottom: 2px solid #e2e8f0;
        box-shadow: 0 2px 12px rgba(0,110,183,0.08);
    }

    /* Job card list style */
    .job-card {
        border-bottom: 1px solid #e2e8f0;
        padding: 1.75rem 0;
        transition: background 0.15s;
    }
    .job-card:first-child {
        border-top: 1px solid #e2e8f0;
    }
    .job-card:hover {
        background: #f8faff;
        border-radius: 8px;
        margin-left: -1rem;
        margin-right: -1rem;
        padding-left: 1rem;
        padding-right: 1rem;
    }
    .job-title-link {
        color: #006eb7;
        font-weight: 700;
        font-size: 1.15rem;
        line-height: 1.35;
        text-decoration: underline;
        text-decoration-color: transparent;
        transition: text-decoration-color 0.2s, color 0.2s;
    }
    .job-title-link:hover {
        text-decoration-color: #006eb7;
        color: #004f8b;
    }
    .job-meta-pill {
        display: inline-flex;
        align-items: center;
        gap: 0.3rem;
        font-size: 0.78rem;
        color: #475569;
        font-weight: 500;
    }
    .job-meta-pill i { color: #94a3b8; }

    .share-btn {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        width: 28px;
        height: 28px;
        border-radius: 50%;
        border: 1px solid #cbd5e1;
        color: #64748b;
        font-size: 0.7rem;
        transition: all 0.2s;
        text-decoration: none;
    }
    .share-btn:hover {
        border-color: #006eb7;
        color: #006eb7;
        background: #eff6ff;
    }

    .filter-btn {
        display: inline-flex;
        align-items: center;
        gap: 0.4rem;
        padding: 0.45rem 1rem;
        border: 1px solid #cbd5e1;
        border-radius: 6px;
        font-size: 0.82rem;
        font-weight: 600;
        color: #475569;
        background: #fff;
        cursor: pointer;
        transition: all 0.2s;
    }
    .filter-btn:hover {
        border-color: #006eb7;
        color: #006eb7;
        background: #eff6ff;
    }
    .filter-btn.active {
        border-color: #006eb7;
        color: #006eb7;
        background: #eff6ff;
    }

    .view-toggle-btn {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        width: 34px;
        height: 34px;
        border: 1px solid #cbd5e1;
        border-radius: 6px;
        color: #94a3b8;
        font-size: 0.85rem;
        background: #fff;
        cursor: pointer;
        transition: all 0.2s;
    }
    .view-toggle-btn.active {
        border-color: #006eb7;
        color: #006eb7;
        background: #eff6ff;
    }

    .badge-status {
        display: inline-flex;
        align-items: center;
        padding: 0.2rem 0.65rem;
        border-radius: 999px;
        font-size: 0.72rem;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.04em;
    }
    .badge-open { background: #dcfce7; color: #166534; }
    .badge-continuous { background: #dbeafe; color: #1e40af; }
    .badge-closing { background: #fef3c7; color: #92400e; }

    /* Benefits collapsible */
    .benefits-section {
        background: #fff;
        border-bottom: 1px solid #e2e8f0;
    }

    /* Search input */
    .jobs-search-input {
        border: 1px solid #cbd5e1;
        border-radius: 8px;
        padding: 0.6rem 1rem 0.6rem 2.75rem;
        font-size: 0.9rem;
        width: 100%;
        outline: none;
        transition: border-color 0.2s, box-shadow 0.2s;
        background: #f8fafc;
    }
    .jobs-search-input:focus {
        border-color: #006eb7;
        box-shadow: 0 0 0 3px rgba(0,110,183,0.12);
        background: #fff;
    }

    /* Empty state */
    .empty-state-icon {
        width: 80px;
        height: 80px;
        background: #eff6ff;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto 1.5rem;
    }

    @media (max-width: 640px) {
        .job-card:hover {
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
<section class="jobs-hero pt-[calc(var(--site-header-height,72px))] pb-12 sm:pb-16 md:pb-20 w-full">
    <div class="jobs-hero-pattern"></div>
    <div class="container relative z-10 px-4 sm:px-6 md:px-8 mx-auto max-w-6xl">
        <div class="mt-6 md:mt-10">
            {{-- Badge --}}
            <span class="inline-flex items-center gap-2 px-4 py-1.5 mb-5 text-xs font-bold tracking-widest text-blue-900 uppercase bg-yellow-400 rounded-full shadow-sm">
                <i class="fa-solid fa-building-columns"></i>
                Trabalhe Conosco
            </span>
            {{-- Title --}}
            <h1 class="text-4xl sm:text-5xl md:text-6xl font-extrabold text-white drop-shadow-sm leading-tight mb-4" style="font-family: 'Montserrat', sans-serif;">
                Oportunidades de<br class="hidden sm:block"> Trabalho
            </h1>
            <p class="text-lg sm:text-xl text-blue-100 leading-relaxed font-light max-w-2xl">
                Faça parte da equipe da Prefeitura Municipal de Assaí. Veja as vagas abertas e concorra a uma oportunidade de servir à nossa comunidade.
            </p>
            {{-- Quick stats --}}
            <div class="flex flex-wrap gap-6 mt-8">
                <div class="flex items-center gap-2 text-white/90 text-sm font-medium">
                    <i class="fa-solid fa-briefcase text-yellow-400"></i>
                    <span><strong class="text-white text-base font-extrabold">{{ $vagas->count() }}</strong> vagas abertas</span>
                </div>
                <div class="flex items-center gap-2 text-white/90 text-sm font-medium">
                    <i class="fa-solid fa-map-marker-alt text-yellow-400"></i>
                    <span>Assaí, Paraná</span>
                </div>
                <div class="flex items-center gap-2 text-white/90 text-sm font-medium">
                    <i class="fa-solid fa-shield-halved text-yellow-400"></i>
                    <span>Emprego público estável</span>
                </div>
            </div>
        </div>
    </div>
</section>

{{-- ======================================================= --}}
{{--   BENEFITS COLLAPSIBLE SECTION                          --}}
{{-- ======================================================= --}}
<section class="benefits-section" x-data="{ open: false }">
    <div class="container px-4 sm:px-6 mx-auto max-w-6xl py-6">
        <p class="text-sm font-bold text-slate-700 uppercase tracking-wider mb-3">
            A PREFEITURA DE ASSAÍ OFERECE AOS SEUS SERVIDORES:
        </p>
        <ul class="space-y-1 text-sm text-slate-600" :class="open ? '' : 'max-h-[4.5rem] overflow-hidden relative'">
            <li class="flex items-center gap-2"><i class="fa-solid fa-check text-blue-500 text-xs"></i> Remuneração compatível com o mercado regional</li>
            <li class="flex items-center gap-2"><i class="fa-solid fa-check text-blue-500 text-xs"></i> Plano de saúde e odontológico (IPREM)</li>
            <li class="flex items-center gap-2"><i class="fa-solid fa-check text-blue-500 text-xs"></i> Estabilidade e segurança no emprego público</li>
            <li class="flex items-center gap-2"><i class="fa-solid fa-check text-blue-500 text-xs"></i> Vale-transporte e alimentação</li>
            <li class="flex items-center gap-2"><i class="fa-solid fa-check text-blue-500 text-xs"></i> Capacitação e treinamento contínuo</li>
            <li class="flex items-center gap-2"><i class="fa-solid fa-check text-blue-500 text-xs"></i> 13.º salário e férias remuneradas</li>
            <li class="flex items-center gap-2"><i class="fa-solid fa-check text-blue-500 text-xs"></i> Ambiente de trabalho focado no bem-estar da comunidade</li>
        </ul>
        <div x-show="!open" class="absolute bottom-0 left-0 right-0 h-8 bg-gradient-to-t from-white to-transparent pointer-events-none" style="display: block;"></div>
        <button @click="open = !open"
            class="mt-3 text-xs font-bold uppercase tracking-widest text-[#006eb7] border-b-2 border-[#006eb7] hover:text-blue-800 hover:border-blue-800 transition-colors focus:outline-none">
            <span x-text="open ? '↑ VER MENOS' : '↓ VER MAIS'">↓ VER MAIS</span>
        </button>
    </div>
</section>

{{-- ======================================================= --}}
{{--   STICKY SEARCH BAR + FILTERS                           --}}
{{-- ======================================================= --}}
<div class="search-sticky-bar"
    x-data="{
        search: '',
        sort: 'default',
        showFilters: false,
        filterSetor: '',
        get vagas() {
            return Array.from(document.querySelectorAll('[data-vaga]'));
        },
        get count() {
            return document.querySelectorAll('[data-vaga]:not([hidden])').length;
        }
    }"
    x-init="
        $watch('search', () => filterJobs());
        $watch('sort', () => sortJobs());
        $watch('filterSetor', () => filterJobs());

        function filterJobs() {
            const q = search.toLowerCase();
            const s = filterSetor.toLowerCase();
            document.querySelectorAll('[data-vaga]').forEach(card => {
                const title = (card.dataset.titulo || '').toLowerCase();
                const setor = (card.dataset.setor || '').toLowerCase();
                const desc = (card.dataset.descricao || '').toLowerCase();
                const matchQ = !q || title.includes(q) || setor.includes(q) || desc.includes(q);
                const matchS = !s || setor.includes(s);
                card.hidden = !(matchQ && matchS);
            });
            updateCount();
        }

        function sortJobs() {
            const container = document.getElementById('jobs-list');
            const cards = Array.from(container.querySelectorAll('[data-vaga]'));
            if (sort === 'az') {
                cards.sort((a, b) => (a.dataset.titulo || '').localeCompare(b.dataset.titulo || ''));
            } else if (sort === 'za') {
                cards.sort((a, b) => (b.dataset.titulo || '').localeCompare(a.dataset.titulo || ''));
            } else if (sort === 'recent') {
                cards.sort((a, b) => parseInt(b.dataset.ts || 0) - parseInt(a.dataset.ts || 0));
            }
            cards.forEach(c => container.appendChild(c));
            updateCount();
        }

        function updateCount() {
            const el = document.getElementById('jobs-count');
            if (el) el.textContent = document.querySelectorAll('[data-vaga]:not([hidden])').length;
        }
    ">

    <div class="container px-4 sm:px-6 mx-auto max-w-6xl py-3">
        <div class="flex flex-col sm:flex-row items-stretch sm:items-center gap-3">
            {{-- Search --}}
            <div class="relative flex-1">
                <i class="fa-solid fa-magnifying-glass absolute left-3 top-1/2 -translate-y-1/2 text-slate-400 text-sm pointer-events-none"></i>
                <input
                    type="text"
                    class="jobs-search-input"
                    placeholder="Buscar vagas..."
                    x-model="search"
                    id="jobs-search-input">
            </div>

            {{-- Count + Controls --}}
            <div class="flex items-center gap-2 shrink-0">
                <span class="text-sm text-slate-500 font-medium whitespace-nowrap">
                    <span id="jobs-count" class="font-bold text-slate-800">{{ $vagas->count() }}</span>
                    vagas encontradas
                </span>

                <div class="h-4 w-px bg-slate-200 mx-1"></div>

                {{-- Sort --}}
                <select x-model="sort"
                    class="filter-btn text-xs cursor-pointer border-0 focus:outline-none pr-6 bg-white border border-slate-200 rounded-md px-3 py-2"
                    style="appearance: none; background-image: url('data:image/svg+xml;charset=utf-8,<svg xmlns=%22http://www.w3.org/2000/svg%22 viewBox=%220 0 16 16%22><path fill=%22%2364748b%22 d=%22M8 11L3 6h10z%22/></svg>'); background-repeat: no-repeat; background-position: right 8px center; background-size: 12px;">
                    <option value="default">↕ Ordenar</option>
                    <option value="recent">Mais Recentes</option>
                    <option value="az">A → Z</option>
                    <option value="za">Z → A</option>
                </select>

                {{-- Filter toggle --}}
                <button @click="showFilters = !showFilters" :class="showFilters ? 'active' : ''" class="filter-btn">
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
            class="pt-3 border-t border-slate-100 mt-3" style="display: none;">
            <div class="flex flex-wrap gap-2 items-center">
                <span class="text-xs font-semibold text-slate-500 uppercase tracking-wider mr-2">Setor:</span>
                @php
                    $setores = $vagas->pluck('setor_ou_contato')->filter()->unique()->sort()->values();
                @endphp
                <button @click="filterSetor = ''" :class="filterSetor === '' ? 'bg-[#006eb7] text-white border-[#006eb7]' : 'bg-white text-slate-600 border-slate-200'"
                    class="px-3 py-1 text-xs font-semibold border rounded-full transition-colors hover:border-[#006eb7]">
                    Todos
                </button>
                @foreach($setores as $setor)
                <button @click="filterSetor = '{{ Str::lower($setor) }}'"
                    :class="filterSetor === '{{ Str::lower($setor) }}' ? 'bg-[#006eb7] text-white border-[#006eb7]' : 'bg-white text-slate-600 border-slate-200'"
                    class="px-3 py-1 text-xs font-semibold border rounded-full transition-colors hover:border-[#006eb7]">
                    {{ $setor }}
                </button>
                @endforeach
            </div>
        </div>
    </div>
</div>

{{-- ======================================================= --}}
{{--   JOB LISTINGS                                           --}}
{{-- ======================================================= --}}
<section class="bg-white py-4 w-full overflow-x-hidden">
    <div class="container px-4 sm:px-6 mx-auto max-w-6xl">

        @if($vagas->isEmpty())
        {{-- ---- EMPTY STATE ---- --}}
        <div class="py-24 text-center">
            <div class="empty-state-icon">
                <i class="fa-solid fa-briefcase text-3xl text-blue-300"></i>
            </div>
            <h2 class="text-xl font-bold text-slate-700 mb-2">Nenhuma vaga disponível no momento</h2>
            <p class="text-slate-500 max-w-md mx-auto mb-6">
                Continue acompanhando nosso portal. Novas oportunidades são publicadas regularmente.
            </p>
            <a href="{{ url('/') }}" class="inline-flex items-center gap-2 px-5 py-2.5 bg-[#006eb7] text-white font-semibold rounded-lg hover:bg-blue-800 transition-colors text-sm">
                <i class="fa-solid fa-house"></i> Voltar ao início
            </a>
        </div>
        @else
        {{-- ---- LIST ---- --}}
        <div id="jobs-list" class="divide-y divide-transparent">
            @foreach($vagas as $vaga)
            @php
                $ts = $vaga->created_at ? $vaga->created_at->timestamp : 0;
                $hasDeadline = !empty($vaga->data_limite);
                $isClosingSoon = $hasDeadline && \Carbon\Carbon::parse($vaga->data_limite)->diffInDays(now()) <= 7 && \Carbon\Carbon::parse($vaga->data_limite)->isFuture();
                $isClosed = $hasDeadline && \Carbon\Carbon::parse($vaga->data_limite)->isPast();
                $shareUrl = urlencode(request()->url() . '#vaga-' . $vaga->id);
                $shareTitle = urlencode('Vaga: ' . $vaga->titulo . ' - Prefeitura de Assaí');
            @endphp
            <div class="job-card"
                id="vaga-{{ $vaga->id }}"
                data-vaga
                data-titulo="{{ strtolower($vaga->titulo) }}"
                data-setor="{{ strtolower($vaga->setor_ou_contato ?? '') }}"
                data-descricao="{{ strtolower(Str::limit($vaga->descricao ?? '', 300)) }}"
                data-ts="{{ $ts }}">

                <div class="flex flex-col md:flex-row md:items-start gap-4">
                    {{-- Content --}}
                    <div class="flex-1 min-w-0">
                        {{-- Title --}}
                        @if($vaga->link_acao)
                            <a href="{{ $vaga->link_acao }}" target="_blank" rel="noopener noreferrer" class="job-title-link block mb-1">
                                {{ $vaga->titulo }}
                            </a>
                        @else
                            <h2 class="job-title-link block mb-1 cursor-default">{{ $vaga->titulo }}</h2>
                        @endif

                        {{-- Meta row --}}
                        <div class="flex flex-wrap gap-x-4 gap-y-1.5 mt-2 mb-3">
                            @if($vaga->setor_ou_contato)
                            <span class="job-meta-pill">
                                <i class="fa-solid fa-sitemap fa-xs"></i>
                                {{ $vaga->setor_ou_contato }}
                            </span>
                            @endif
                            @if($hasDeadline)
                            <span class="job-meta-pill">
                                <i class="fa-regular fa-calendar fa-xs"></i>
                                Inscrições até {{ \Carbon\Carbon::parse($vaga->data_limite)->format('d/m/Y') }}
                            </span>
                            @endif
                            @if($vaga->created_at)
                            <span class="job-meta-pill">
                                <i class="fa-regular fa-clock fa-xs"></i>
                                Publicado {{ $vaga->created_at->diffForHumans() }}
                            </span>
                            @endif
                        </div>

                        {{-- Description --}}
                        @if($vaga->descricao)
                        <p class="text-slate-600 text-sm leading-relaxed line-clamp-3">
                            {{ $vaga->descricao }}
                        </p>
                        @endif

                        {{-- Bottom row: Share + Badge --}}
                        <div class="flex items-center justify-between flex-wrap gap-3 mt-4">
                            {{-- Share icons --}}
                            <div class="flex items-center gap-1.5">
                                <span class="text-xs text-slate-400 mr-1">Compartilhar:</span>
                                <a href="https://www.linkedin.com/shareArticle?mini=true&url={{ $shareUrl }}&title={{ $shareTitle }}"
                                    target="_blank" rel="noopener noreferrer" class="share-btn" title="Compartilhar no LinkedIn">
                                    <i class="fa-brands fa-linkedin-in"></i>
                                </a>
                                <a href="https://twitter.com/intent/tweet?url={{ $shareUrl }}&text={{ $shareTitle }}"
                                    target="_blank" rel="noopener noreferrer" class="share-btn" title="Compartilhar no X">
                                    <i class="fa-brands fa-x-twitter"></i>
                                </a>
                                <a href="https://wa.me/?text={{ $shareTitle }}%20{{ $shareUrl }}"
                                    target="_blank" rel="noopener noreferrer" class="share-btn" title="Compartilhar no WhatsApp">
                                    <i class="fa-brands fa-whatsapp"></i>
                                </a>
                                <a href="mailto:?subject={{ $shareTitle }}&body={{ $shareUrl }}" class="share-btn" title="Compartilhar por e-mail">
                                    <i class="fa-solid fa-envelope"></i>
                                </a>
                            </div>

                            {{-- Status badges --}}
                            <div class="flex items-center gap-2">
                                @if($isClosed)
                                    <span class="badge-status" style="background:#fee2e2;color:#991b1b;">
                                        <i class="fa-solid fa-circle-xmark mr-1 text-xs"></i> Encerrada
                                    </span>
                                @elseif($isClosingSoon)
                                    <span class="badge-status badge-closing">
                                        <i class="fa-solid fa-fire mr-1 text-xs"></i> Encerrando em breve
                                    </span>
                                @elseif(!$hasDeadline)
                                    <span class="badge-status badge-continuous">
                                        <i class="fa-solid fa-infinity mr-1 text-xs"></i> Contínua
                                    </span>
                                @else
                                    <span class="badge-status badge-open">
                                        <i class="fa-solid fa-circle-check mr-1 text-xs"></i> Aberta
                                    </span>
                                @endif

                                @if($vaga->link_acao)
                                <a href="{{ $vaga->link_acao }}" target="_blank" rel="noopener noreferrer"
                                    class="inline-flex items-center gap-1.5 px-4 py-1.5 bg-[#006eb7] text-white text-xs font-bold rounded-lg hover:bg-blue-800 transition-colors whitespace-nowrap">
                                    Ver detalhes <i class="fa-solid fa-arrow-right fa-xs"></i>
                                </a>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach

            {{-- No results after filter --}}
            <div id="jobs-no-results" class="hidden py-16 text-center">
                <div class="empty-state-icon">
                    <i class="fa-solid fa-magnifying-glass text-2xl text-blue-200"></i>
                </div>
                <p class="text-slate-500 font-medium">Nenhuma vaga encontrada para a busca.</p>
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
// Watch for hidden cards and show/hide no-results
document.addEventListener('DOMContentLoaded', function () {
    const observer = new MutationObserver(function () {
        const visible = document.querySelectorAll('[data-vaga]:not([hidden])').length;
        const noResults = document.getElementById('jobs-no-results');
        if (noResults) {
            noResults.classList.toggle('hidden', visible > 0);
        }
        const countEl = document.getElementById('jobs-count');
        if (countEl) countEl.textContent = visible;
    });

    document.querySelectorAll('[data-vaga]').forEach(el => {
        observer.observe(el, { attributes: true, attributeFilter: ['hidden'] });
    });
});
</script>

@endsection