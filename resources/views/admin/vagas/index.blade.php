@extends('layouts.admin')
@section('title', 'Gestão de Oportunidades - Painel Admin')

@section('content')
<div class="flex flex-col gap-6">

    @php
        $breadcrumbsIndex = [
            ['label' => 'Dashboard', 'url' => route('admin.dashboard'), 'class' => 'hover:text-blue-600'],
            ['label' => 'Oportunidades'],
        ];
    @endphp
    <x-admin.page-header title="Oportunidades de Trabalho" :breadcrumbs="$breadcrumbsIndex">
        <x-slot:action>
            <a href="{{ route('admin.vagas.create') }}" class="inline-flex items-center gap-2 px-5 py-2.5 text-sm font-bold text-white transition bg-blue-700 rounded-lg hover:bg-blue-800 shadow-sm">
                <i class="fa-solid fa-plus"></i>
                Nova Oportunidade
            </a>
        </x-slot:action>
    </x-admin.page-header>

    @if(session('success'))
        <div class="flex items-center gap-3 p-4 text-emerald-800 bg-emerald-50 border border-emerald-200 rounded-xl" role="alert">
            <svg class="w-5 h-5 text-emerald-600 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
            <p class="font-medium">{{ session('success') }}</p>
        </div>
    @endif

    <div class="overflow-hidden bg-white border shadow-sm rounded-xl border-slate-200">

        {{-- Toolbar --}}
        <div class="p-4 border-b border-slate-100 bg-slate-50/50 flex flex-wrap items-center gap-3">
            <h2 class="font-semibold text-slate-700 mr-auto">Vagas e Trabalho Informal</h2>
            <form method="GET" action="{{ route('admin.vagas.index') }}" class="flex flex-col sm:flex-row sm:items-center gap-2 w-full sm:w-auto">
                <x-admin.filter-search name="search" value="{{ request('search') }}" placeholder="Buscar por título..." />
                <x-admin.filter-select
                    name="tipo"
                    :options="['' => 'Qualquer tipo', 'formal' => 'Vaga Formal', 'informal' => 'Trabalho Informal']"
                    :value="request('tipo')"
                    placeholder="Qualquer tipo"
                />
                <x-admin.filter-select
                    name="status"
                    :options="['' => 'Qualquer status', '1' => 'Ativo', '0' => 'Inativo']"
                    :value="request('status')"
                    placeholder="Qualquer status"
                />
                <button type="submit" class="px-3 py-1.5 text-sm font-bold text-white bg-blue-700 rounded-lg hover:bg-blue-800 transition">Buscar</button>
                @if(request()->hasAny(['search', 'tipo', 'status']))
                    <a href="{{ route('admin.vagas.index') }}" class="px-3 py-1.5 text-sm font-bold text-slate-600 bg-white border border-slate-200 rounded-lg hover:bg-slate-50 transition">Limpar</a>
                @endif
            </form>
            <span class="px-2.5 py-1 text-xs font-bold rounded-full bg-slate-200 text-slate-600">
                {{ method_exists($vagas, 'total') ? $vagas->total() : $vagas->count() }}
            </span>
        </div>

        {{-- Tabela --}}
        <div class="overflow-x-auto">
            <table class="w-full text-sm text-left text-slate-600">
                <thead class="text-xs text-slate-500 uppercase bg-slate-50 border-b border-slate-200">
                    <tr>
                        <th scope="col" class="px-6 py-4 font-semibold tracking-wide">Título</th>
                        <th scope="col" class="px-6 py-4 font-semibold tracking-wide">Categoria</th>
                        <th scope="col" class="px-6 py-4 font-semibold tracking-wide">Setor / Contato</th>
                        <th scope="col" class="px-6 py-4 font-semibold tracking-wide text-center">Validade</th>
                        <th scope="col" class="px-6 py-4 font-semibold tracking-wide text-center">Status</th>
                        <th scope="col" class="px-6 py-4 font-semibold tracking-wide text-right">Ações</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse($vagas as $vaga)
                        <tr class="bg-white hover:bg-slate-50 transition-colors group">
                            <td class="px-6 py-4 font-medium text-slate-800">
                                {{ $vaga->titulo }}
                                @if($vaga->link_acao)
                                    <a href="{{ $vaga->link_acao }}" target="_blank" class="ml-1 text-blue-500 hover:text-blue-700 transition-opacity opacity-0 group-hover:opacity-100" title="Abrir link de ação">
                                        <i class="fa-solid fa-arrow-up-right-from-square text-xs"></i>
                                    </a>
                                @endif
                            </td>
                            <td class="px-6 py-4">
                                <span class="px-2.5 py-1 text-[11px] font-bold uppercase rounded-full {{ $vaga->tipo === 'formal' ? 'bg-blue-100 text-blue-800' : 'bg-amber-100 text-amber-800' }}">
                                    {{ $vaga->tipo === 'formal' ? 'Formal' : 'Informal' }}
                                </span>
                            </td>
                            <td class="px-6 py-4 text-slate-600 max-w-[200px]">
                                <span class="block truncate" title="{{ $vaga->setor_ou_contato }}">{{ $vaga->setor_ou_contato }}</span>
                            </td>
                            <td class="px-6 py-4 text-center">
                                @if($vaga->data_limite)
                                    <span class="{{ $vaga->data_limite->isPast() ? 'text-red-600 font-semibold' : 'text-slate-600' }}">
                                        {{ $vaga->data_limite->format('d/m/Y') }}
                                    </span>
                                @else
                                    <span class="text-slate-400">—</span>
                                @endif
                            </td>
                            <td class="px-6 py-4 text-center">
                                <x-admin.status-badge
                                    :label="$vaga->status ? 'Ativo' : 'Inativo'"
                                    :tone="$vaga->status ? 'emerald' : 'slate'"
                                />
                            </td>
                            <td class="px-6 py-4 text-right">
                                <div class="flex items-center justify-end gap-2">
                                    <x-admin.icon-action href="{{ route('admin.vagas.edit', $vaga->id) }}" color="blue" title="Editar oportunidade">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                                    </x-admin.icon-action>

                                    <form action="{{ route('admin.vagas.destroy', $vaga->id) }}" method="POST" class="inline-block" onsubmit="return confirm('Confirmar exclusão definitiva desta oportunidade?');">
                                        @csrf
                                        @method('DELETE')
                                        <x-admin.icon-action type="submit" color="red" title="Excluir oportunidade">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                        </x-admin.icon-action>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-6 py-12 text-center">
                                <i class="fa-solid fa-briefcase text-3xl text-slate-300 mb-3 block"></i>
                                <p class="text-slate-500 font-medium">Nenhuma oportunidade encontrada.</p>
                                @if(request()->hasAny(['search', 'tipo', 'status']))
                                    <a href="{{ route('admin.vagas.index') }}" class="mt-2 inline-block text-sm text-blue-600 hover:underline">Limpar filtros</a>
                                @endif
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if(method_exists($vagas, 'hasPages') && $vagas->hasPages())
            <div class="p-4 border-t border-slate-100 bg-slate-50/50">
                {{ $vagas->appends(request()->query())->links() }}
            </div>
        @endif
    </div>

</div>
@endsection
