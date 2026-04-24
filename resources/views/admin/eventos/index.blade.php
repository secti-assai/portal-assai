@extends('layouts.admin')

@section('content')
<div class="flex flex-col gap-6">

    <x-admin.page-header
        title="Gerenciar Eventos"
        :breadcrumbs="[
            ['label' => 'Dashboard', 'url' => route('admin.dashboard'), 'class' => 'hover:text-blue-600'],
            ['label' => 'Agenda de Eventos'],
        ]"
    >
        <x-slot:action>
            <a href="{{ route('admin.eventos.create') }}" class="inline-flex items-center gap-2 px-5 py-2.5 text-sm font-bold text-white transition bg-amber-500 rounded-lg hover:bg-amber-600 shadow-sm">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                Novo Evento
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
            <h2 class="font-semibold text-slate-700 mr-auto">Eventos Cadastrados</h2>
            <form method="GET" action="{{ route('admin.eventos.index') }}" class="flex flex-col sm:flex-row sm:items-center gap-2 w-full sm:w-auto">
                <x-admin.filter-search name="search" value="{{ request('search') }}" placeholder="Pesquisar por título ou local..." class="focus:ring-amber-500 focus:border-amber-500" />
                <x-admin.filter-select
                    name="status"
                    :options="['' => 'Qualquer status', 'agendado' => 'Agendado', 'cancelado' => 'Cancelado', 'realizado' => 'Realizado']"
                    :value="request('status')"
                    placeholder="Qualquer status"
                    class="focus:ring-amber-500 focus:border-amber-500"
                />
                <input type="month" name="mes_referencia" value="{{ request('mes_referencia') }}" onchange="this.form.submit()" placeholder="Mês de realização" class="block h-9 px-3 py-2 text-sm text-slate-700 border border-slate-300 rounded-lg transition focus:outline-none focus:ring-2 focus:ring-amber-500 focus:border-amber-500 bg-white placeholder:text-slate-400" />
                <button type="submit" class="px-3 py-1.5 text-sm font-bold text-white bg-amber-500 rounded-lg hover:bg-amber-600 transition">Buscar</button>
                @if(request()->hasAny(['search', 'status', 'mes_referencia']))
                    <a href="{{ route('admin.eventos.index') }}" class="px-3 py-1.5 text-sm font-bold text-slate-600 bg-white border border-slate-200 rounded-lg hover:bg-slate-50 transition">Limpar</a>
                @endif
            </form>
            <span class="px-2.5 py-1 text-xs font-bold rounded-full bg-slate-200 text-slate-600">{{ $eventos->total() }}</span>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse table-fixed">
                <thead>
                    <tr class="text-xs tracking-wider uppercase border-b bg-slate-50 text-slate-500 border-slate-200">
                        <th class="p-4 font-semibold w-24">Imagem</th>
                        <th class="p-4 font-semibold">Evento</th>
                        <th class="p-4 font-semibold">Data / Hora</th>
                        <th class="p-4 font-semibold w-40">Local</th>
                        <th class="p-4 font-semibold text-center w-28">Status</th>
                        <th class="p-4 font-semibold text-center w-36">Ações</th>
                    </tr>
                </thead>
                <tbody class="text-sm divide-y divide-slate-100">
                    @forelse($eventos as $evento)
                        <tr class="transition group hover:bg-slate-50">
                            <td class="p-4">
                                <a href="{{ route('admin.eventos.edit', $evento->id) }}" class="block group">
                                    @if($evento->imagem)
                                        <img src="{{ asset('storage/' . $evento->imagem) }}" class="object-cover w-16 h-12 border rounded shadow-sm border-slate-200">
                                    @else
                                        <div class="flex items-center justify-center w-16 h-12 text-[10px] font-bold text-slate-400 bg-slate-100 rounded border border-slate-200">S/ FOTO</div>
                                    @endif
                                </a>
                            </td>
                            <td class="p-4 max-w-0 overflow-hidden">
                                <p class="font-bold text-slate-800 truncate" title="{{ $evento->titulo }}">{{ \Illuminate\Support\Str::limit($evento->titulo, 90) }}</p>
                            </td>
                            <td class="p-4">
                                <div class="flex flex-col gap-1">
                                    <span class="inline-flex items-center gap-1.5 text-xs font-bold text-slate-700">
                                        <svg class="w-3.5 h-3.5 text-emerald-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                        {{ \Carbon\Carbon::parse($evento->data_inicio)->format('d/m/Y H:i') }}
                                    </span>
                                    @if($evento->data_fim)
                                    <span class="inline-flex items-center gap-1.5 text-xs font-bold text-slate-400">
                                        <svg class="w-3.5 h-3.5 text-red-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                        {{ \Carbon\Carbon::parse($evento->data_fim)->format('d/m/Y H:i') }}
                                    </span>
                                    @endif
                                </div>
                            </td>
                            <td class="p-4 text-slate-500 font-medium overflow-hidden" title="{{ $evento->local }}">
                                <span class="block truncate">{{ $evento->local ?? 'Não informado' }}</span>
                            </td>
                            <td class="p-4 text-center">
                                @php
                                    $statusCfg = match($evento->status) {
                                        'cancelado' => 'bg-red-50 text-red-700 border-red-200',
                                        default     => 'bg-emerald-50 text-emerald-700 border-emerald-200',
                                    };
                                    $statusLabel = match($evento->status) {
                                        'cancelado' => 'CANCELADO',
                                        default     => 'CONFIRMADO',
                                    };
                                @endphp
                                <x-admin.status-badge :label="$statusLabel" size="2xs" class="{{ $statusCfg }}" />
                            </td>
                            <td class="p-4">
                                <div class="flex items-center justify-end gap-2">
                                    <x-admin.icon-action href="{{ route('admin.eventos.edit', $evento->id) }}" color="blue" title="Editar Registro">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                                    </x-admin.icon-action>
                                    <form action="{{ route('admin.eventos.destroy', $evento->id) }}" method="POST" class="inline-block" onsubmit="return confirm('Excluir este evento é uma ação irreversível. Confirmar?');">
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
                            <td colspan="6" class="p-8 text-center text-slate-500">
                                Nenhum evento encontrado. Utilize o botão "Novo Evento" para iniciar.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($eventos->hasPages())
            <div class="p-4 border-t border-slate-100 bg-slate-50/50">
                {{ $eventos->links('components.pagination.agenda-style') }}
            </div>
        @endif
    </div>

</div>
@endsection
