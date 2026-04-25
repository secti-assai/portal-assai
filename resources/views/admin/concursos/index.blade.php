@extends('layouts.admin')

@section('content')
<div class="flex flex-col gap-6">

    <x-admin.page-header
        title="Gerenciar Concursos"
        :breadcrumbs="[
            ['label' => 'Dashboard', 'url' => route('admin.dashboard'), 'class' => 'hover:text-blue-600'],
            ['label' => 'Concursos'],
        ]"
    >
        <x-slot:action>
            <a href="{{ route('admin.concursos.create') }}" class="inline-flex items-center gap-2 px-5 py-2.5 text-sm font-bold text-white transition bg-blue-600 rounded-lg hover:bg-blue-700 shadow-sm">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                Novo Concurso
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
    <div class="overflow-hidden bg-white border shadow-sm rounded-xl border-slate-200">
        <div class="p-4 border-b border-slate-100 bg-slate-50/50 flex flex-wrap items-center gap-3">
            <h2 class="font-semibold text-slate-700 mr-auto">Concursos Cadastrados</h2>
            <form method="GET" action="{{ route('admin.concursos.index') }}" class="flex flex-col sm:flex-row sm:items-center gap-2 w-full sm:w-auto">
                <x-admin.filter-search name="search" value="{{ request('search') }}" placeholder="Pesquisar concurso..." class="focus:ring-blue-500 focus:border-blue-500" />
                <button type="submit" class="px-3 py-1.5 text-sm font-bold text-white bg-blue-600 rounded-lg hover:bg-blue-700 transition">Buscar</button>
            </form>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse table-fixed">
                <thead>
                    <tr class="text-xs tracking-wider uppercase border-b bg-slate-50 text-slate-500 border-slate-200">
                        <th class="p-4 font-semibold w-16 text-center">ID</th>
                        <th class="p-4 font-semibold">Título</th>
                        <th class="p-4 font-semibold">Link</th>
                        <th class="p-4 font-semibold text-center w-28">Status</th>
                        <th class="p-4 font-semibold text-center w-32">Ações</th>
                    </tr>
                </thead>
                <tbody class="text-sm divide-y divide-slate-100">
                    @forelse($concursos as $concurso)
                        <tr class="transition group hover:bg-slate-50">
                            <td class="p-4 text-center text-slate-400 font-mono text-xs">
                                {{ $concurso->id }}
                            </td>
                            <td class="p-4 max-w-0 overflow-hidden">
                                <p class="font-bold text-slate-800 truncate" title="{{ $concurso->titulo }}">{{ $concurso->titulo }}</p>
                                <p class="text-[10px] text-slate-400 mt-0.5 uppercase tracking-wider">Criado em: {{ $concurso->created_at->format('d/m/Y') }}</p>
                            </td>
                            <td class="p-4 text-slate-500 font-medium overflow-hidden">
                                @if($concurso->link)
                                    <a href="{{ $concurso->link }}" target="_blank" class="inline-flex items-center gap-1 hover:text-blue-600 transition w-full" title="{{ $concurso->link }}">
                                        <span class="truncate">{{ $concurso->link }}</span>
                                        <svg class="w-3 h-3 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"></path></svg>
                                    </a>
                                @else
                                    <span class="text-slate-300 italic">Sem link</span>
                                @endif
                            </td>
                            <td class="p-4 text-center">
                                <x-admin.status-toggle
                                    :checked="$concurso->ativo"
                                    :url="route('admin.concursos.toggle', $concurso->id)"
                                    tone="blue"
                                    title-on="Desativar concurso"
                                    title-off="Ativar concurso"
                                />
                            </td>
                            <td class="p-4">
                                <div class="flex items-center justify-end gap-2">
                                    <x-admin.icon-action href="{{ route('admin.concursos.edit', $concurso->id) }}" color="blue" title="Editar Concurso">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                                    </x-admin.icon-action>
                                    <form action="{{ route('admin.concursos.destroy', $concurso->id) }}" method="POST" class="inline-block" onsubmit="return confirm('Tem certeza que deseja excluir este concurso?');">
                                        @csrf
                                        @method('DELETE')
                                        <x-admin.icon-action type="submit" color="red" title="Excluir Concurso">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                        </x-admin.icon-action>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="p-8 text-center text-slate-500">
                                Nenhum concurso cadastrado.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if(method_exists($concursos, 'hasPages') && $concursos->hasPages())
            <div class="p-4 border-t border-slate-100 bg-slate-50/50">
                {{ $concursos->links() }}
            </div>
        @endif
    </div>

</div>
@endsection
