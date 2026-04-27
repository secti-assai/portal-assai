@extends('layouts.app')

@section('title', 'Notícias - Prefeitura Municipal de Assaí')

@section('content')
    <section id="conteudo-principal" accesskey="1" tabindex="-1"
        class="relative flex flex-col min-h-screen bg-white pt-24 md:pt-24 lg:pt-[170px] pb-20 lg:pb-24"
        x-data="{ 
            loading: false,
            async navigate(url) {
                if (!url || url === '#' || this.loading) return;
                this.loading = true;
                try {
                    const response = await fetch(url, { headers: { 'X-Requested-With': 'XMLHttpRequest' } });
                    const html = await response.text();
                    const parser = new DOMParser();
                    const doc = parser.parseFromString(html, 'text/html');

                    // Atualiza as partes da página
                    document.getElementById('filters-container').innerHTML = doc.getElementById('filters-container').innerHTML;
                    document.getElementById('news-grid-container').innerHTML = doc.getElementById('news-grid-container').innerHTML;
                    document.getElementById('pagination-container').innerHTML = doc.getElementById('pagination-container').innerHTML;

                    // Atualiza a URL sem recarregar
                    window.history.pushState({}, '', url);
                } catch (error) {
                    window.location.href = url;
                } finally {
                    this.loading = false;
                    {{-- Scroll suave de volta para os filtros --}}
                    const filters = document.getElementById('filters-container');
                    window.scrollTo({ top: filters.offsetTop - 120, behavior: 'smooth' });
                }
            }
        }">

        {{-- Overlay de Carregamento --}}
        <div x-show="loading" x-transition:enter="transition opacity-0 duration-300" x-transition:enter-end="opacity-100"
            x-transition:leave="transition opacity-100 duration-300" x-transition:leave-end="opacity-0"
            class="fixed inset-0 z-[100] bg-white/60 backdrop-blur-sm flex items-center justify-center"
            style="display: none;">
            <div class="flex flex-col items-center gap-4">
                <div class="w-12 h-12 border-4 border-blue-100 border-t-blue-600 rounded-full animate-spin"></div>
                <p class="text-sm font-bold text-blue-900 animate-pulse">Atualizando notícias...</p>
            </div>
        </div>

        <div class="container max-w-6xl px-4 mx-auto font-sans">

            {{-- Breadcrumb --}}
            <x-breadcrumb :items="[
            ['name' => 'Início', 'url' => route('home')],
            ['name' => 'Notícias'],
        ]" />

            {{-- Header --}}
            <div class="mb-10 text-center md:text-left">
                <h1
                    class="text-3xl max-[360px]:text-2xl font-black text-blue-900 md:text-4xl font-heading leading-tight uppercase tracking-tight">
                    Últimas Notícias
                </h1>
                <div class="w-12 h-1 mt-3 bg-yellow-400 mx-auto md:mx-0"></div>
                <p class="mt-4 text-sm md:text-base text-gray-500">Acompanhe as ações, projetos e informativos da Prefeitura
                    de Assaí.</p>
            </div>

            {{-- Barra de Filtros Unificada --}}
            <form action="{{ route('noticias.index') }}" method="GET" class="mb-12" id="filters-form"
                @submit.prevent="navigate($event.target.action + '?' + new URLSearchParams(new FormData($event.target)).toString())">
                
                <div id="filters-container" class="flex flex-col lg:flex-row gap-4 bg-gray-50 p-4 md:p-6 rounded-3xl border border-gray-200 shadow-sm">
                    
                    {{-- Busca por Texto --}}
                    <div class="flex-1">
                        <label for="q" class="block text-xs font-bold text-gray-400 uppercase tracking-wider mb-2 ml-1">Palavra-chave</label>
                        <div class="relative flex items-center bg-white rounded-2xl border border-gray-300 focus-within:border-blue-500 focus-within:ring-4 focus-within:ring-blue-500/10 transition-all duration-300 h-14 px-4">
                            <svg class="w-5 h-5 text-gray-400 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                            </svg>
                            <input type="text" id="q" name="q" value="{{ request()->query('q') }}"
                                placeholder="O que você procura?"
                                class="flex-1 min-w-0 px-3 py-2 text-sm md:text-base text-gray-700 bg-transparent border-none outline-none focus:ring-0 placeholder:text-gray-400">
                        </div>
                    </div>

                    {{-- Seleção de Categoria --}}
                    <div class="w-full lg:w-64">
                        <label for="categoria" class="block text-xs font-bold text-gray-400 uppercase tracking-wider mb-2 ml-1">Categoria</label>
                        <div class="relative">
                            <select name="categoria" id="categoria" 
                                @change="$event.target.form.dispatchEvent(new Event('submit'))"
                                class="w-full h-14 pl-4 pr-10 text-sm bg-white border border-gray-300 rounded-2xl appearance-none focus:border-blue-500 focus:ring-4 focus:ring-blue-500/10 transition-all cursor-pointer text-gray-700 font-medium">
                                <option value="">Todas as Categorias</option>
                                @foreach($categorias as $cat)
                                    <option value="{{ $cat->id }}" {{ request('categoria') == $cat->id ? 'selected' : '' }}>
                                        {{ $cat->nome }}
                                    </option>
                                @endforeach
                            </select>
                            <div class="absolute inset-y-0 right-0 flex items-center px-4 pointer-events-none text-gray-400">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                                </svg>
                            </div>
                        </div>
                    </div>

                    {{-- Filtro por Período --}}
                    <div class="w-full lg:w-60">
                        <label for="periodo" class="block text-xs font-bold text-gray-400 uppercase tracking-wider mb-2 ml-1">Período</label>
                        <div class="relative">
                            <select name="periodo" id="periodo" 
                                @change="$event.target.form.dispatchEvent(new Event('submit'))"
                                class="w-full h-14 pl-4 pr-10 text-sm bg-white border border-gray-300 rounded-2xl appearance-none focus:border-blue-500 focus:ring-4 focus:ring-blue-500/10 transition-all cursor-pointer text-gray-700 font-medium">
                                <option value="" {{ !request('periodo') ? 'selected' : '' }}>Qualquer data</option>
                                <option value="7d" {{ request('periodo') == '7d' ? 'selected' : '' }}>Últimos 7 dias</option>
                                <option value="30d" {{ request('periodo') == '30d' ? 'selected' : '' }}>Últimos 30 dias</option>
                                <option value="90d" {{ request('periodo') == '90d' ? 'selected' : '' }}>Últimos 90 dias</option>
                                <option value="ano" {{ request('periodo') == 'ano' ? 'selected' : '' }}>Este ano</option>
                            </select>
                            <div class="absolute inset-y-0 right-0 flex items-center px-4 pointer-events-none text-gray-400">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                                </svg>
                            </div>
                        </div>
                    </div>

                    {{-- Botão Buscar (Principalmente para mobile/acessibilidade) --}}
                    <div class="flex items-end">
                        <button type="submit"
                            class="h-14 w-full lg:w-auto px-8 bg-yellow-400 hover:bg-yellow-500 active:scale-95 text-blue-950 font-black rounded-2xl transition-all duration-200 shadow-md hover:shadow-lg flex items-center justify-center gap-2">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                            </svg>
                            <span class="lg:hidden">Buscar</span>
                        </button>
                    </div>
                </div>
            </form>



            {{-- Grid de Notícias --}}
            <div id="news-grid-container">
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 lg:gap-8 justify-center">
                    @forelse($noticias as $noticia)
                        <article
                            class="relative h-[350px] md:h-[430px] overflow-hidden rounded-2xl group bg-slate-100 shadow-md hover:shadow-xl transition-shadow duration-300">
                            <a href="{{ route('noticias.show', $noticia->slug) }}"
                                class="block w-full h-full outline-none focus-within:ring-4 focus-within:ring-blue-500 focus-within:ring-inset">

                                <img src="{{ $noticia->imagem_capa ? asset('storage/' . $noticia->imagem_capa) : asset('img/Assai.jpg') }}"
                                    alt=""
                                    class="absolute inset-0 object-cover w-full h-full transition-transform duration-700 ease-out group-hover:scale-110"
                                    loading="lazy" decoding="async">

                                <div
                                    class="absolute inset-0 bg-gradient-to-t from-black/80 via-black/20 to-transparent opacity-80">
                                </div>

                                <div
                                    class="absolute bottom-0 left-0 w-full p-5 lg:p-6 bg-white/10 backdrop-blur-lg border-t border-white/30 flex flex-col justify-end transition-all duration-500">

                                    @if($noticia->categorias->count() > 0)
                                        <span
                                            class="inline-block px-2 py-0.5 mb-2 bg-yellow-400 text-blue-900 text-[10px] font-black rounded uppercase tracking-tighter w-fit shadow-sm">
                                            {{ $noticia->categorias->first()->nome }}
                                        </span>
                                    @endif
                                    <h3
                                        class="text-sm sm:text-base font-bold leading-snug text-white font-heading drop-shadow-md">
                                        {{ ucfirst(Str::lower($noticia->titulo)) }}
                                    </h3>

                                    <div
                                        class="grid grid-rows-[0fr] group-hover:grid-rows-[1fr] transition-all duration-500 ease-in-out mt-2">
                                        <div
                                            class="overflow-hidden opacity-0 group-hover:opacity-100 transition-opacity duration-500 delay-100">

                                            <p
                                                class="pt-2 text-[13px] leading-relaxed text-gray-100 font-sans line-clamp-4 lg:line-clamp-5 mb-4">
                                                {{ $noticia->resumo ?? Str::limit(strip_tags($noticia->conteudo), 160) }}
                                            </p>

                                            <div class="flex items-center justify-between border-t border-white/20 pt-4">
                                                <span
                                                    class="text-[10px] font-bold text-yellow-400 uppercase tracking-widest drop-shadow-sm flex items-center gap-1">
                                                    Ler mais <i class="fas fa-arrow-right text-[8px]"></i>
                                                </span>
                                                <time class="text-[10px] font-medium text-gray-300">
                                                    {{ \Carbon\Carbon::parse($noticia->data_publicacao)->format('d/m/Y') }}
                                                </time>
                                            </div>
                                        </div>
                                    </div>

                                </div>
                            </a>
                        </article>
                    @empty
                        <div
                            class="flex flex-col items-center justify-center gap-4 p-12 text-center border-2 border-gray-200 border-dashed bg-gray-50 rounded-2xl col-span-full">
                            <svg class="w-12 h-12 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                    d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10l4 4v10a2 2 0 01-2 2z" />
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12h6M9 16h4" />
                            </svg>
                            <div>
                                <p class="text-base font-bold text-gray-500 font-heading">Nenhuma notícia encontrada</p>
                                <p class="mt-1 text-sm text-gray-400">
                                    @if(request('q'))
                                        Tente procurar por outro termo.
                                    @else
                                        Nenhuma notícia publicada no momento.
                                    @endif
                                </p>
                            </div>
                        </div>
                    @endforelse
                </div>
            </div>

            {{-- Paginação --}}
            <div class="mt-12" id="pagination-container"
                @click.prevent="if($event.target.closest('a')) navigate($event.target.closest('a').href)">
                {{ $noticias->appends(request()->query())->links('components.pagination.agenda-style') }}
            </div>

        </div>
    </section>
@endsection