@extends('layouts.admin')

@section('content')
<div class="flex flex-col gap-6">

    <x-admin.page-header
        title="Gerenciar Notícias"
        :breadcrumbs="[
            ['label' => 'Dashboard', 'url' => route('admin.dashboard'), 'class' => 'hover:text-blue-600'],
            ['label' => 'Notícias'],
        ]"
    >
        <x-slot:action>
            <a href="{{ route('admin.noticias.create') }}" class="inline-flex items-center gap-2 px-5 py-2.5 text-sm font-bold text-white transition bg-blue-600 rounded-lg hover:bg-blue-700 shadow-sm">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                Nova Notícia
            </a>
        </x-slot:action>
    </x-admin.page-header>

    @if(session('sucesso'))
        <div class="flex items-center gap-3 p-4 text-emerald-800 bg-emerald-50 border border-emerald-200 rounded-xl" role="alert">
            <svg class="w-5 h-5 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
            <p class="font-medium">{{ session('sucesso') }}</p>
        </div>
    @endif

    {{-- Tabela de Dados --}}
    <div class="bg-white border shadow-sm rounded-xl border-slate-200 overflow-hidden">
        
        <div class="p-4 border-b border-slate-100 bg-slate-50/50 flex flex-wrap items-center gap-3">
            <h2 class="font-semibold text-slate-700 mr-auto">Registros Cadastrados</h2>
            <form method="GET" action="{{ route('admin.noticias.index') }}" class="flex flex-col sm:flex-row sm:items-center gap-2 w-full sm:w-auto">
                <x-admin.filter-search name="search" value="{{ request('search') }}" placeholder="Pesquisar por título..." />
                <x-admin.filter-select
                    name="categoria"
                    :options="['' => 'Todas as categorias'] + $categorias"
                    :value="request('categoria')"
                    placeholder="Todas as categorias"
                />
                <x-admin.filter-select
                    name="status"
                    :options="['' => 'Qualquer status', 'publicado' => 'Ativo', 'rascunho' => 'Oculto/Inativo']"
                    :value="request('status')"
                    placeholder="Qualquer status"
                />
                <button type="submit" class="px-3 py-1.5 text-sm font-bold text-white bg-blue-600 rounded-lg hover:bg-blue-700 transition">Buscar</button>
                @if(request()->hasAny(['search', 'categoria', 'status']))
                    <a href="{{ route('admin.noticias.index') }}" class="px-3 py-1.5 text-sm font-bold text-slate-600 bg-white border border-slate-200 rounded-lg hover:bg-slate-50 transition">Limpar</a>
                @endif
            </form>
            <span class="px-2.5 py-1 text-xs font-bold rounded-full bg-slate-200 text-slate-600">{{ $noticias->total() }}</span>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse table-fixed">
                <thead>
                    <tr class="bg-slate-50 text-slate-500 text-xs uppercase tracking-wider border-b border-slate-200">
                        <th class="p-4 font-semibold w-24">Capa</th>
                        <th class="p-4 font-semibold">Título</th>
                        <th class="p-4 font-semibold w-48">Info / Status</th>
                        <th class="p-4 font-semibold text-center w-40">Ações</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 text-sm">
                    @forelse($noticias as $noticia)
                        <tr class="transition hover:bg-slate-50 group">
                            <td class="p-4">
                                <a href="{{ route('noticias.show', $noticia->slug) }}" target="_blank" class="block group">
                                    @if($noticia->imagem_capa)
                                        <img src="{{ asset('storage/' . $noticia->imagem_capa) }}" class="object-cover w-16 h-12 rounded border border-slate-200 shadow-sm">
                                    @else
                                        <div class="flex items-center justify-center w-16 h-12 text-[10px] font-bold text-slate-400 bg-slate-100 rounded border border-slate-200">S/ FOTO</div>
                                    @endif
                                </a>
                            </td>
                            <td class="p-4 max-w-0 overflow-hidden">
                                <p class="font-bold text-slate-800 truncate" title="{{ $noticia->titulo }}">{{ \Illuminate\Support\Str::limit($noticia->titulo, 100) }}</p>
                                <p class="text-xs text-slate-400 mt-1">Data: {{ \Carbon\Carbon::parse($noticia->data_publicacao)->format('d/m/Y') }}</p>
                            </td>
                            <td class="p-4 flex flex-col items-start gap-1.5">
                                @if($noticia->ativo)
                                    <span class="inline-flex items-center px-2 py-0.5 rounded text-[11px] font-bold bg-emerald-100 text-emerald-800">Ativa no Site</span>
                                @else
                                    <span class="inline-flex items-center px-2 py-0.5 rounded text-[11px] font-bold bg-rose-100 text-rose-800">Oculta/Inativa</span>
                                @endif
                                
                                @if($noticia->categoria)
                                    <span class="inline-flex items-center px-2 py-0.5 rounded text-[10px] font-bold bg-blue-50 text-blue-700 border border-blue-200">{{ $noticia->categoria }}</span>
                                @endif
                            </td>
                            <td class="p-4">
                                <div class="flex items-center justify-center gap-2">
                                    <x-admin.icon-action href="{{ route('noticias.show', $noticia->slug) }}" target="_blank" color="slate" title="Visualizar no Portal">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                                    </x-admin.icon-action>
                                    <x-admin.icon-action href="{{ route('admin.noticias.edit', $noticia->id) }}" color="blue" title="Editar Registro">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                                    </x-admin.icon-action>
                                    <form action="{{ route('admin.noticias.destroy', $noticia->id) }}" method="POST" class="inline-block" onsubmit="return confirm('Excluir este registro é uma ação irreversível. Confirmar?');">
                                        @csrf
                                        @method('DELETE')
                                        <x-admin.icon-action type="submit" color="red" title="Excluir Registro">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                        </x-admin.icon-action>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="p-8 text-center text-slate-500">
                                Nenhum registro encontrado. Utilize o botão "Nova Notícia" para iniciar.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($noticias->hasPages())
            <div class="p-4 border-t border-slate-100 bg-slate-50/50">
                {{ $noticias->links() }}
            </div>
        @endif
    </div>

</div>
@endsection