@extends('layouts.admin')

@section('content')
<div class="flex flex-col gap-6">

    <x-admin.page-header
        title="Gerenciar Alertas"
        :breadcrumbs="[
            ['label' => 'Dashboard', 'url' => route('admin.dashboard'), 'class' => 'hover:text-red-600'],
            ['label' => 'Alertas da página inicial'],
        ]"
    >
        <x-slot:action>
            <a href="{{ route('admin.alertas.create') }}" class="inline-flex items-center gap-2 px-5 py-2.5 text-sm font-bold text-white transition bg-red-600 rounded-lg hover:bg-red-700 shadow-sm">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                Novo Alerta
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
            <h2 class="font-semibold text-slate-700 mr-auto">Alertas Cadastrados</h2>
            <form method="GET" action="{{ route('admin.alertas.index') }}" class="flex flex-col sm:flex-row sm:items-center gap-2 w-full sm:w-auto">
                <x-admin.filter-search name="search" value="{{ request('search') }}" placeholder="Pesquisar por título ou mensagem..." class="focus:ring-red-500 focus:border-red-500" />
                <x-admin.filter-select
                    name="status"
                    :options="['' => 'Qualquer status', 'ativo' => 'Ativo', 'inativo' => 'Inativo']"
                    :value="request('status')"
                    placeholder="Qualquer status"
                    class="focus:ring-red-500 focus:border-red-500"
                />
                <button type="submit" class="px-3 py-1.5 text-sm font-bold text-white bg-red-600 rounded-lg hover:bg-red-700 transition">Buscar</button>
                @if(request()->hasAny(['search', 'status']))
                    <a href="{{ route('admin.alertas.index') }}" class="px-3 py-1.5 text-sm font-bold text-slate-600 bg-white border border-slate-200 rounded-lg hover:bg-slate-50 transition">Limpar</a>
                @endif
            </form>
            <span class="px-2.5 py-1 text-xs font-bold rounded-full bg-slate-200 text-slate-600">{{ method_exists($alertas, 'total') ? $alertas->total() : $alertas->count() }}</span>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse table-fixed">
                <thead>
                    <tr class="text-xs tracking-wider uppercase border-b bg-slate-50 text-slate-500 border-slate-200">
                        <th class="p-4 font-semibold w-16 text-center">Ícone</th>
                        <th class="p-4 font-semibold">Alerta</th>
                        <th class="p-4 font-semibold w-64">Ação (Link)</th>
                        <th class="p-4 font-semibold text-center w-28">Status</th>
                        <th class="p-4 font-semibold text-center w-32">Ações</th>
                    </tr>
                </thead>
                <tbody class="text-sm divide-y divide-slate-100">
                    @forelse($alertas as $alerta)
                        <tr class="transition group hover:bg-slate-50">
                            <td class="p-4">
                                <a href="{{ route('admin.alertas.edit', $alerta->id) }}" class="block group">
                                    <div class="flex items-center justify-center w-10 h-10 mx-auto rounded-lg bg-red-50 text-red-600 border border-red-100">
                                        @if($alerta->icone)
                                            <img src="{{ asset('storage/' . $alerta->icone) }}" alt="Ícone do Alerta" class="object-cover w-10 h-10 rounded-lg">
                                        @else
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
                                        @endif
                                    </div>
                                </a>
                            </td>
                            <td class="p-4 max-w-0 overflow-hidden">
                                <p class="font-bold text-slate-800 truncate" title="{{ $alerta->titulo }}">{{ \Illuminate\Support\Str::limit($alerta->titulo, 90) }}</p>
                                <p class="text-xs text-slate-500 mt-0.5 truncate">{{ \Illuminate\Support\Str::limit(strip_tags((string) $alerta->mensagem), 120) }}</p>
                            </td>
                            <td class="p-4 text-slate-500 font-medium overflow-hidden">
                                @if($alerta->link)
                                    <a href="{{ $alerta->link }}" target="_blank" class="inline-flex items-center gap-1 hover:text-red-600 transition w-full" title="{{ $alerta->link }}">
                                        <span class="truncate">{{ $alerta->link }}</span>
                                        <svg class="w-3 h-3 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"></path></svg>
                                    </a>
                                @else
                                    <span class="text-slate-400 text-xs">Sem botão de ação</span>
                                @endif
                            </td>
                            <td class="p-4 text-center">
                                <x-admin.status-toggle
                                    :checked="$alerta->ativo"
                                    :url="route('admin.alertas.toggle-status', $alerta->id)"
                                    tone="red"
                                    title-on="Desativar alerta"
                                    title-off="Ativar alerta"
                                />
                            </td>
                            <td class="p-4">
                                <div class="flex items-center justify-end gap-2">
                                    <x-admin.icon-action href="{{ route('admin.alertas.edit', $alerta->id) }}" color="blue" title="Editar Alerta">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                                    </x-admin.icon-action>
                                    <form action="{{ route('admin.alertas.destroy', $alerta->id) }}" method="POST" class="inline-block" onsubmit="return confirm('Tem certeza que deseja excluir este alerta definitivamente?');">
                                        @csrf
                                        @method('DELETE')
                                        <x-admin.icon-action type="submit" color="red" title="Excluir Alerta">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                        </x-admin.icon-action>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="p-8 text-center text-slate-500">
                                Nenhum alerta cadastrado.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if(method_exists($alertas, 'hasPages') && $alertas->hasPages())
            <div class="p-4 border-t border-slate-100 bg-slate-50/50">
                {{ $alertas->links('components.pagination.agenda-style') }}
            </div>
        @endif
    </div>

</div>

@endsection