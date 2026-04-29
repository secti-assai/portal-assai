@extends('layouts.app')

@section('content')
<section class="pt-24 pb-12 bg-slate-50 min-h-screen"
    x-data="{ 
        loading: false, 
        q: '{{ request('q') }}',
        data_inicio: '{{ request('data_inicio') }}',
        data_fim: '{{ request('data_fim') }}',
        updateList() {
            this.loading = true;
            const params = new URLSearchParams({
                q: this.q,
                data_inicio: this.data_inicio,
                data_fim: this.data_fim
            });
            
            setTimeout(() => {
                fetch(`{{ route('diarios.index') }}?${params.toString()}`, {
                    headers: { 'X-Requested-With': 'XMLHttpRequest' }
                })
                .then(res => res.text())
                .then(html => {
                    document.getElementById('list-container').innerHTML = html;
                    window.history.pushState({}, '', `{{ route('diarios.index') }}?${params.toString()}`);
                })
                .finally(() => { 
                    setTimeout(() => { this.loading = false; }, 300);
                });
            }, 200);
        },
        clearFilters() {
            this.q = '';
            this.data_inicio = '';
            this.data_fim = '';
            this.updateList();
        }
    }"
    x-init="
        window.clearFilters = () => clearFilters();
        document.getElementById('list-container').addEventListener('click', (e) => {
            const link = e.target.closest('a');
            if (link && link.href && link.href.includes('page=')) {
                e.preventDefault();
                loading = true;
                setTimeout(() => {
                    fetch(link.href, { headers: { 'X-Requested-With': 'XMLHttpRequest' } })
                        .then(res => res.text())
                        .then(html => {
                            document.getElementById('list-container').innerHTML = html;
                            window.scrollTo({ top: 0, behavior: 'smooth' });
                            window.history.pushState({}, '', link.href);
                        })
                        .finally(() => { setTimeout(() => { loading = false; }, 300); });
                }, 200);
            }
        });
    ">

    {{-- Overlay de Recarregamento --}}
    <div x-show="loading" 
         x-transition:enter="transition ease-out duration-200"
         x-transition:enter-start="opacity-0"
         x-transition:enter-end="opacity-100"
         x-transition:leave="transition ease-in duration-300"
         x-transition:leave-start="opacity-100"
         x-transition:leave-end="opacity-0"
         class="fixed inset-0 bg-slate-50/80 backdrop-blur-md z-[999] flex items-center justify-center" 
         x-cloak>
        <div class="flex flex-col items-center">
            <div class="relative">
                <div class="w-16 h-16 border-4 border-blue-600/10 border-t-blue-600 rounded-full animate-spin"></div>
                <div class="absolute inset-0 flex items-center justify-center">
                    <i class="fa-solid fa-newspaper text-blue-600 animate-pulse"></i>
                </div>
            </div>
            <p class="mt-4 text-blue-900 font-extrabold tracking-tight animate-pulse uppercase text-xs">Atualizando Diários...</p>
        </div>
    </div>

    <div class="container mx-auto px-4">
        
        <div class="mb-10">
            <x-breadcrumb :items="[
                ['name' => 'Início', 'url' => route('home')],
                ['name' => 'Transparência', 'url' => route('pages.transparencia')],
                ['name' => 'Diário Oficial']
            ]" />
            <h1 class="text-4xl font-extrabold text-blue-900 mb-2">Diário Oficial Eletrônico</h1>
            <p class="text-slate-500">Transparência e acesso à informação oficial da Prefeitura de Assaí.</p>
            <div class="h-1.5 w-24 bg-yellow-400 rounded-full mt-4"></div>
        </div>

        {{-- Filtros --}}
        <div class="bg-white rounded-2xl shadow-sm border border-slate-200 p-6 mb-8 relative">
            <form @submit.prevent="updateList()" class="grid grid-cols-1 md:grid-cols-5 gap-4 items-end">
                <div class="md:col-span-2">
                    <label for="q" class="block text-sm font-bold text-slate-700 mb-2">Edição ou Assinante</label>
                    <input type="text" x-model="q" placeholder="Número da edição ou nome do assinante..." 
                        class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none transition-all">
                </div>
                <div>
                    <label for="data_inicio" class="block text-sm font-bold text-slate-700 mb-2">De</label>
                    <input type="date" x-model="data_inicio" @change="updateList()" 
                        class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl focus:ring-2 focus:ring-blue-500 outline-none transition-all">
                </div>
                <div>
                    <label for="data_fim" class="block text-sm font-bold text-slate-700 mb-2">Até</label>
                    <input type="date" x-model="data_fim" @change="updateList()" 
                        class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl focus:ring-2 focus:ring-blue-500 outline-none transition-all">
                </div>
                <div class="flex gap-2">
                    <button type="submit" class="flex-1 bg-blue-600 hover:bg-blue-700 text-white font-bold py-3 px-6 rounded-xl transition shadow-md shadow-blue-200">
                        Filtrar
                    </button>
                    <button type="button" @click="clearFilters()" x-show="q || data_inicio || data_fim" x-cloak
                        class="bg-slate-100 hover:bg-slate-200 text-slate-600 font-bold py-3 px-4 rounded-xl transition">
                        <i class="fa-solid fa-xmark"></i>
                    </button>
                </div>
            </form>
        </div>

        {{-- Listagem Container --}}
        <div id="list-container" class="min-h-[400px]">
             @include('pages.partials.diarios-list')
        </div>

    </div>
</section>
@endsection
