@extends('layouts.admin')

@section('content')
<div class="flex flex-col gap-6 max-w-6xl mx-auto">
    <x-admin.page-header
        title="Categorias (Temas) das Notícias"
        :breadcrumbs="[
            ['label' => 'Dashboard', 'url' => route('admin.dashboard'), 'class' => 'hover:text-blue-600'],
            ['label' => 'Notícias', 'url' => route('admin.noticias.index'), 'class' => 'hover:text-blue-600'],
            ['label' => 'Categorias'],
        ]"
    >
        <x-slot:action>
            <a href="{{ route('admin.categorias.create') }}" class="px-5 py-2.5 text-sm font-bold text-white bg-[#006eb7] rounded-lg hover:bg-blue-800 transition shadow-md inline-flex items-center gap-2">
                <i class="fa-solid fa-plus" aria-hidden="true"></i> Nova Categoria
            </a>
        </x-slot:action>
    </x-admin.page-header>

    @if(session('sucesso'))
        <div class="p-4 bg-emerald-50 border border-emerald-200 rounded-xl text-emerald-700 font-medium">
            {{ session('sucesso') }}
        </div>
    @endif

    <div class="bg-white border border-slate-200 rounded-xl shadow-sm overflow-hidden">
        <div class="p-5 border-b border-slate-200 bg-slate-50/50 flex flex-col sm:flex-row sm:items-center justify-between gap-4">
            <h3 class="font-bold text-slate-800">Filtros</h3>
            <form action="{{ route('admin.categorias.index') }}" method="GET" class="flex flex-col sm:flex-row gap-3 sm:w-2/3 lg:w-1/2">
                <div class="flex-1 relative">
                    <i class="fa-solid fa-magnifying-glass absolute left-3 top-1/2 -translate-y-1/2 text-slate-400"></i>
                    <input type="text" name="search" value="{{ request('search') }}" placeholder="Buscar por nome..." class="w-full pl-9 pr-4 py-2 bg-white border border-slate-300 rounded-lg text-sm focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 outline-none transition-all">
                </div>
                <div class="sm:w-48">
                    <select name="perfil" class="w-full px-3 py-2 bg-white border border-slate-300 rounded-lg text-sm focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 outline-none transition-all">
                        <option value="">Todos os perfis</option>
                        <option value="Cidadão" {{ request('perfil') === 'Cidadão' ? 'selected' : '' }}>Cidadão</option>
                        <option value="Turista" {{ request('perfil') === 'Turista' ? 'selected' : '' }}>Turista</option>
                        <option value="Empresário" {{ request('perfil') === 'Empresário' ? 'selected' : '' }}>Empresário</option>
                        <option value="Servidor Público" {{ request('perfil') === 'Servidor Público' ? 'selected' : '' }}>Servidor Público</option>
                    </select>
                </div>
                <button type="submit" class="px-4 py-2 bg-slate-100 border border-slate-300 text-slate-700 font-bold text-sm rounded-lg hover:bg-slate-200 transition">
                    Filtrar
                </button>
                @if(request()->anyFilled(['search', 'perfil']))
                <a href="{{ route('admin.categorias.index') }}" class="px-4 py-2 bg-white border border-slate-300 text-slate-600 font-bold text-sm rounded-lg hover:bg-slate-50 transition text-center">
                    Limpar
                </a>
                @endif
            </form>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-slate-50 border-b border-slate-200 text-slate-500 text-xs uppercase tracking-wider">
                        <th class="p-4 font-bold">Nome / Tema</th>
                        <th class="p-4 font-bold">Perfil Vinculado</th>
                        <th class="p-4 font-bold">Status</th>
                        <th class="p-4 font-bold text-right">Ações</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse($categorias as $categoria)
                    <tr class="hover:bg-slate-50 transition-colors">
                        <td class="p-4 font-bold text-slate-800">
                            {{ $categoria->nome }}
                        </td>
                        <td class="p-4">
                            @php
                                $badgeColor = match($categoria->perfil) {
                                    'Cidadão' => 'bg-blue-100 text-blue-700 border-blue-200',
                                    'Turista' => 'bg-amber-100 text-amber-700 border-amber-200',
                                    'Empresário' => 'bg-purple-100 text-purple-700 border-purple-200',
                                    'Servidor Público' => 'bg-emerald-100 text-emerald-700 border-emerald-200',
                                    default => 'bg-slate-100 text-slate-700 border-slate-200'
                                };
                            @endphp
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-bold border {{ $badgeColor }}">
                                {{ $categoria->perfil }}
                            </span>
                        </td>
                        <td class="p-4">
                            @if($categoria->ativo)
                            <span class="inline-flex items-center px-2 py-1 rounded text-xs font-bold bg-emerald-50 text-emerald-700 border border-emerald-200">
                                Ativo
                            </span>
                            @else
                            <span class="inline-flex items-center px-2 py-1 rounded text-xs font-bold bg-slate-100 text-slate-600 border border-slate-200">
                                Inativo
                            </span>
                            @endif
                        </td>
                        <td class="p-4 text-right space-x-2">
                            <a href="{{ route('admin.categorias.edit', $categoria->id) }}" class="inline-flex items-center justify-center w-8 h-8 rounded-lg bg-white border border-slate-200 text-slate-600 hover:text-blue-600 hover:bg-blue-50 transition-colors" title="Editar">
                                <i class="fa-solid fa-pen" aria-hidden="true"></i>
                            </a>
                            <form action="{{ route('admin.categorias.destroy', $categoria->id) }}" method="POST" class="inline-block" onsubmit="return confirm('Tem certeza que deseja apagar permanentemente este tema?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="inline-flex items-center justify-center w-8 h-8 rounded-lg bg-white border border-slate-200 text-slate-600 hover:text-red-600 hover:bg-red-50 transition-colors" title="Apagar">
                                    <i class="fa-solid fa-trash" aria-hidden="true"></i>
                                </button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="4" class="p-8 text-center text-slate-500 font-medium">
                            <i class="fa-solid fa-folder-open text-4xl mb-3 text-slate-300 block" aria-hidden="true"></i>
                            Nenhuma categoria encontrada.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        @if($categorias->hasPages())
        <div class="p-4 border-t border-slate-200">
            {{ $categorias->links() }}
        </div>
        @endif
    </div>
</div>
@endsection
