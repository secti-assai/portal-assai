@extends('layouts.admin')

@section('content')
<div class="flex flex-col gap-6">

    <x-admin.page-header
        title="Gerenciar Telefones Úteis"
        :breadcrumbs="[
            ['label' => 'Dashboard', 'url' => route('admin.dashboard'), 'class' => 'hover:text-emerald-600'],
            ['label' => 'Telefones'],
        ]"
    >
        <x-slot:action>
            <a href="{{ route('admin.telefones.create') }}" class="inline-flex items-center gap-2 px-5 py-2.5 text-sm font-bold text-white transition bg-emerald-600 rounded-lg hover:bg-emerald-700 shadow-sm">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                Novo Telefone
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
            <h2 class="font-semibold text-slate-700 mr-auto">Telefones Cadastrados</h2>
            <form method="GET" action="{{ route('admin.telefones.index') }}" class="flex flex-col sm:flex-row sm:items-center gap-2 w-full sm:w-auto">
                <x-admin.filter-search name="search" value="{{ request('search') }}" placeholder="Pesquisar telefone..." class="focus:ring-emerald-500 focus:border-emerald-500" />
                <button type="submit" class="px-3 py-1.5 text-sm font-bold text-white bg-emerald-600 rounded-lg hover:bg-emerald-700 transition">Buscar</button>
            </form>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse table-fixed">
                <thead>
                    <tr class="text-xs tracking-wider uppercase border-b bg-slate-50 text-slate-500 border-slate-200">
                        <th class="p-4 font-semibold w-16 text-center">ID</th>
                        <th class="p-4 font-semibold">Nome / Local</th>
                        <th class="p-4 font-semibold w-48">Número</th>
                        <th class="p-4 font-semibold w-64">Secretaria</th>
                        <th class="p-4 font-semibold text-center w-28">Status</th>
                        <th class="p-4 font-semibold text-center w-32">Ações</th>
                    </tr>
                </thead>
                <tbody class="text-sm divide-y divide-slate-100">
                    @forelse($telefones as $telefone)
                        <tr class="transition group hover:bg-slate-50">
                            <td class="p-4 text-center text-slate-400 font-mono text-xs">
                                {{ $telefone->id }}
                            </td>
                            <td class="p-4 max-w-0 overflow-hidden">
                                <p class="font-bold text-slate-800 truncate" title="{{ $telefone->nome }}">{{ $telefone->nome }}</p>
                            </td>
                            <td class="p-4 text-emerald-700 font-black font-mono">
                                {{ $telefone->numero }}
                            </td>
                            <td class="p-4 text-slate-500">
                                @if($telefone->secretaria)
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-slate-100 text-slate-800">
                                        {{ $telefone->secretaria->nome }}
                                    </span>
                                @else
                                    <span class="text-slate-400 italic">Geral / Emergência</span>
                                @endif
                            </td>
                            <td class="p-4 text-center">
                                <x-admin.status-toggle
                                    :checked="$telefone->ativo"
                                    :url="route('admin.telefones.toggle', $telefone->id)"
                                    tone="emerald"
                                    title-on="Desativar telefone"
                                    title-off="Ativar telefone"
                                />
                            </td>
                            <td class="p-4">
                                <div class="flex items-center justify-end gap-2">
                                    <x-admin.icon-action href="{{ route('admin.telefones.edit', $telefone->id) }}" color="blue" title="Editar Telefone">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                                    </x-admin.icon-action>
                                    <form action="{{ route('admin.telefones.destroy', $telefone->id) }}" method="POST" class="inline-block" onsubmit="return confirm('Tem certeza que deseja excluir este telefone?');">
                                        @csrf
                                        @method('DELETE')
                                        <x-admin.icon-action type="submit" color="red" title="Excluir Telefone">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                        </x-admin.icon-action>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="p-8 text-center text-slate-500">
                                Nenhum telefone cadastrado.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if(method_exists($telefones, 'hasPages') && $telefones->hasPages())
            <div class="p-4 border-t border-slate-100 bg-slate-50/50">
                {{ $telefones->links() }}
            </div>
        @endif
    </div>

</div>
@endsection
