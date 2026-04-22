@extends('layouts.admin')

@section('content')
<div class="flex flex-col gap-6">

    <x-admin.page-header
        title="Gerenciar Programas"
        :breadcrumbs="[
            ['label' => 'Dashboard', 'url' => route('admin.dashboard'), 'class' => 'hover:text-emerald-600'],
            ['label' => 'Assaí em Ação'],
        ]">
        <x-slot:action>
            <a href="{{ route('admin.programas.create') }}" class="inline-flex items-center gap-2 px-5 py-2.5 text-sm font-bold text-white transition bg-emerald-600 rounded-lg hover:bg-emerald-700 shadow-sm">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                </svg>
                Novo Programa
            </a>
        </x-slot:action>
    </x-admin.page-header>

    @if(session('sucesso'))
    <div class="flex items-center gap-3 p-4 text-emerald-800 bg-emerald-50 border border-emerald-200 rounded-xl" role="alert">
        <svg class="w-5 h-5 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
        </svg>
        <p class="font-medium">{{ session('sucesso') }}</p>
    </div>
    @endif

    {{-- Tabela de Dados --}}
    <div class="overflow-hidden bg-white border shadow-sm rounded-xl border-slate-200">
        <div class="p-4 border-b border-slate-100 bg-slate-50/50 flex flex-wrap items-center gap-3">
            <h2 class="font-semibold text-slate-700 mr-auto">Programas Cadastrados</h2>
            <form method="GET" action="{{ route('admin.programas.index') }}" class="flex flex-col sm:flex-row sm:items-center gap-2 w-full sm:w-auto">
                <x-admin.filter-search value="{{ request('q') }}" placeholder="Pesquisar por título ou descrição..." class="focus:ring-emerald-500 focus:border-emerald-500" />
                <x-admin.filter-select
                    name="ativo"
                    :options="['1' => 'Ativo', '0' => 'Inativo']"
                    :value="request('ativo')"
                    placeholder="Todos os status"
                    class="focus:ring-emerald-500 focus:border-emerald-500" />
                <button type="submit" class="px-3 py-1.5 text-sm font-bold text-white bg-emerald-600 rounded-lg hover:bg-emerald-700 transition">Buscar</button>
                @if(request()->hasAny(['q', 'ativo']))
                <a href="{{ route('admin.programas.index') }}" class="px-3 py-1.5 text-sm font-bold text-slate-600 bg-white border border-slate-200 rounded-lg hover:bg-slate-50 transition">Limpar</a>
                @endif
            </form>
            <span class="px-2.5 py-1 text-xs font-bold rounded-full bg-slate-200 text-slate-600">{{ $programas->total() }}</span>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse table-fixed">
                <thead>
                    <tr class="text-xs tracking-wider uppercase border-b bg-slate-50 text-slate-500 border-slate-200">
                        <th class="p-4 font-semibold w-24">Ícone</th>
                        <th class="p-4 font-semibold">Programa / Projeto</th>
                        <th class="p-4 font-semibold w-64">Link de Acesso</th>
                        <th class="p-4 font-semibold text-center w-28">Status</th>
                        <th class="p-4 font-semibold text-center w-24">Destaque</th>
                        <th class="p-4 font-semibold text-center w-36">Ações</th>
                    </tr>
                </thead>
                <tbody class="text-sm divide-y divide-slate-100">
                    @forelse($programas as $programa)
                    <tr class="transition group hover:bg-slate-50">
                        <td class="p-4">
                            <a href="{{ route('admin.programas.edit', $programa->id) }}" class="block group">
                                <div class="flex items-center justify-center w-12 h-12 rounded-lg bg-emerald-50 text-emerald-600 border border-emerald-100">
                                    @if($programa->icone)
                                    <img src="{{ str_starts_with($programa->icone, 'img/') ? asset($programa->icone) : asset('storage/' . $programa->icone) }}" class="object-cover w-full h-full rounded-lg">
                                    @else
                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path>
                                    </svg>
                                    @endif
                                </div>
                            </a>
                        </td>
                        <td class="p-4 overflow-hidden" style="max-width:0">
                            <p class="font-bold text-slate-800 truncate" title="{{ $programa->titulo }}">{{ \Illuminate\Support\Str::limit($programa->titulo, 80) }}</p>
                            <p class="text-xs text-slate-500 mt-0.5 truncate">{{ \Illuminate\Support\Str::limit(strip_tags((string) $programa->descricao), 120) }}</p>
                        </td>
                        <td class="p-4 text-slate-500 font-medium overflow-hidden">
                            @if($programa->link)
                            <a href="{{ $programa->link }}" target="_blank" class="inline-flex items-center gap-1 hover:text-emerald-600 transition truncate w-full" title="{{ $programa->link }}">
                                <span class="truncate">{{ $programa->link }}</span>
                                <svg class="w-3 h-3 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"></path>
                                </svg>
                            </a>
                            @else
                            <span class="text-slate-400">Sem link externo</span>
                            @endif
                        </td>
                        <td class="p-4 text-center">
                            <x-admin.status-toggle
                                :checked="$programa->ativo"
                                :url="route('admin.programas.toggle-status', $programa->id)"
                                tone="emerald"
                                title-on="Desativar programa"
                                title-off="Ativar programa" />
                        </td>
                        <td class="p-4 text-center">
                            <button
                                type="button"
                                class="btn-toggle-destaque inline-flex items-center justify-center p-2 rounded-lg transition-colors hover:bg-yellow-50 focus:outline-none focus:ring-2 focus:ring-yellow-400 focus:ring-offset-1"
                                data-id="{{ $programa->id }}"
                                data-url="{{ route('admin.programas.toggle-destaque', $programa->id) }}"
                                title="{{ $programa->destaque ? 'Remover destaque' : 'Adicionar destaque' }}">
                                <svg class="w-5 h-5 {{ $programa->destaque ? 'text-yellow-500 fill-yellow-500' : 'text-slate-300 fill-slate-300' }}" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z" />
                                </svg>
                            </button>
                        </td>
                        <td class="p-4">
                            <div class="flex items-center justify-end gap-2">
                                <x-admin.icon-action href="{{ route('admin.programas.edit', $programa->id) }}" color="blue" title="Editar Programa">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                    </svg>
                                </x-admin.icon-action>
                                <form action="{{ route('admin.programas.destroy', $programa->id) }}" method="POST" class="inline-block" onsubmit='return confirm("Tem certeza que deseja excluir este programa?");'>
                                    @csrf
                                    @method('DELETE')
                                    <x-admin.icon-action type="submit" color="red" title="Excluir Programa">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                        </svg>
                                    </x-admin.icon-action>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="p-8 text-center text-slate-500">
                            Nenhum programa cadastrado. Clique em "Novo Programa" para adicionar.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($programas->hasPages())
        <div class="p-4 border-t border-slate-100 bg-slate-50/50">
            {{ $programas->links('components.pagination.agenda-style') }}
        </div>
        @endif
    </div>

</div>

@endsection