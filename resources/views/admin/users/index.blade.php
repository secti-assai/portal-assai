@extends('layouts.admin')

@section('content')
<div class="flex flex-col gap-6">

    <x-admin.page-header
        title="Gestão de Usuários"
        :breadcrumbs="[
            ['label' => 'Dashboard', 'url' => route('admin.dashboard'), 'class' => 'hover:text-blue-600'],
            ['label' => 'Usuários'],
        ]"
    >
        <x-slot:action>
            <a href="{{ route('admin.users.create') }}" class="inline-flex items-center gap-2 px-5 py-2.5 text-sm font-bold text-white transition bg-blue-600 rounded-lg hover:bg-blue-700 shadow-sm">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                Novo Usuários
            </a>
        </x-slot:action>
    </x-admin.page-header>

    @if(session('success') || session('sucesso'))
        <div class="flex items-center gap-3 p-4 text-emerald-800 bg-emerald-50 border border-emerald-200 rounded-xl" role="alert">
            <svg class="w-5 h-5 text-emerald-600 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
            <p class="font-medium">{{ session('success') ?? session('sucesso') }}</p>
        </div>
    @endif

    @if(session('error') || session('erro'))
        <div class="flex items-center gap-3 p-4 text-red-800 bg-red-50 border border-red-200 rounded-xl" role="alert">
            <svg class="w-5 h-5 text-red-600 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
            <p class="font-medium">{{ session('error') ?? session('erro') }}</p>
        </div>
    @endif

    <div class="overflow-hidden bg-white border shadow-sm rounded-xl border-slate-200">
        <div class="p-4 border-b border-slate-100 bg-slate-50/50 flex flex-wrap items-center gap-3">
            <h2 class="font-semibold text-slate-700 mr-auto">Usuários Cadastrados</h2>
            <form method="GET" action="{{ route('users.index') }}" class="flex flex-col sm:flex-row sm:items-center gap-2 w-full sm:w-auto">
                <x-admin.filter-search name="search" value="{{ request('search') }}" placeholder="Pesquisar por nome ou e-mail..." />
                <x-admin.filter-select
                    name="role"
                    :options="['' => 'Todos os papéis'] + $roles->toArray()"
                    :value="request('role')"
                    placeholder="Todos os papéis"
                />
                <button type="submit" class="px-3 py-1.5 text-sm font-bold text-white bg-blue-600 rounded-lg hover:bg-blue-700 transition">Buscar</button>
                @if(request()->hasAny(['search', 'role']))
                    <a href="{{ route('users.index') }}" class="px-3 py-1.5 text-sm font-bold text-slate-600 bg-white border border-slate-200 rounded-lg hover:bg-slate-50 transition">Limpar</a>
                @endif
            </form>
            <span class="px-2.5 py-1 text-xs font-bold rounded-full bg-slate-200 text-slate-600">{{ $usuarios->total() }}</span>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse table-fixed">
                <thead>
                    <tr class="text-xs tracking-wider uppercase border-b bg-slate-50 text-slate-500 border-slate-200">
                        <th class="p-4 font-semibold">Utilizador</th>
                        <th class="p-4 font-semibold">Papéis</th>
                        <th class="p-4 font-semibold hidden md:table-cell">Permissões Diretas</th>
                        <th class="p-4 font-semibold hidden md:table-cell">Criado em</th>
                        <th class="p-4 font-semibold text-center w-28">Ações</th>
                    </tr>
                </thead>
                <tbody class="text-sm divide-y divide-slate-100">
                    @forelse($usuarios as $usuario)
                        <tr class="transition hover:bg-slate-50 {{ $usuario->id === auth()->id() ? 'bg-blue-50/30' : '' }}">
                            <td class="p-4 max-w-0 overflow-hidden">
                                <div class="flex items-center gap-3">
                                    <div class="flex items-center justify-center w-9 h-9 rounded-full bg-blue-100 text-blue-700 font-bold text-sm shrink-0">
                                        {{ strtoupper(substr($usuario->name, 0, 1)) }}
                                    </div>
                                    <div class="min-w-0">
                                        <p class="font-bold text-slate-800 truncate" title="{{ $usuario->name }}">
                                            {{ $usuario->name }}
                                            @if($usuario->id === auth()->id())
                                                <span class="ml-2 inline-block px-1.5 py-0.5 text-[10px] font-bold rounded bg-blue-100 text-blue-700">Você</span>
                                            @endif
                                        </p>
                                        <p class="text-xs text-slate-500 truncate" title="{{ $usuario->email }}">{{ $usuario->email }}</p>
                                    </div>
                                </div>
                            </td>
                            <td class="p-4">
                                <div class="flex flex-wrap gap-1">
                                    @forelse($usuario->roles as $role)
                                        @php
                                            $tagColor = match($role->name) {
                                                'admin'       => 'bg-red-100 text-red-700',
                                                'comunicacao' => 'bg-purple-100 text-purple-700',
                                                'gestao'      => 'bg-amber-100 text-amber-700',
                                                default       => 'bg-slate-100 text-slate-700',
                                            };
                                        @endphp
                                        <span class="inline-block px-2 py-0.5 text-xs font-bold rounded-full {{ $tagColor }}">
                                            {{ ucfirst($role->name) }}
                                        </span>
                                    @empty
                                        <span class="text-xs text-slate-400 italic">Sem papel</span>
                                    @endforelse
                                </div>
                            </td>
                            <td class="p-4 hidden md:table-cell">
                                <div class="flex flex-wrap gap-1">
                                    @forelse($usuario->permissions as $perm)
                                        <span class="inline-block px-2 py-0.5 text-xs font-medium rounded-full bg-slate-100 text-slate-600">
                                            {{ $perm->name }}
                                        </span>
                                    @empty
                                        <span class="text-xs text-slate-400 italic">Nenhuma</span>
                                    @endforelse
                                </div>
                            </td>
                            <td class="p-4 hidden md:table-cell text-sm text-slate-500">
                                {{ $usuario->created_at->format('d/m/Y') }}
                            </td>
                            <td class="p-4">
                                <div class="flex items-center justify-center gap-2">
                                    <x-admin.icon-action href="{{ route('admin.users.edit', $usuario->id) }}" color="blue" title="Editar Utilizador">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                                    </x-admin.icon-action>
                                    @if($usuario->id !== auth()->id())
                                        <form action="{{ route('admin.users.destroy', $usuario->id) }}" method="POST" class="inline-block" onsubmit="return confirm('Excluir este utilizador? Esta ação é irreversível.');">
                                            @csrf
                                            @method('DELETE')
                                            <x-admin.icon-action type="submit" color="red" title="Excluir Utilizador">
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                            </x-admin.icon-action>
                                        </form>
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="p-8 text-center text-slate-500">
                                Nenhum utilizador encontrado.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($usuarios->hasPages())
            <div class="px-4 py-3 border-t border-slate-100 bg-slate-50/50">
                {{ $usuarios->links() }}
            </div>
        @endif
    </div>
</div>
@endsection
