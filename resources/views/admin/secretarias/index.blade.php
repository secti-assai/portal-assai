@extends('layouts.admin')

@section('content')
<div class="flex flex-col gap-6">

    <x-admin.page-header
        title="Gerenciar Secretarias"
        :breadcrumbs="[
            ['label' => 'Dashboard', 'url' => route('admin.dashboard'), 'class' => 'hover:text-teal-600'],
            ['label' => 'Estrutura Organizacional'],
        ]"
    >
        <x-slot:action>
            <a href="{{ route('admin.secretarias.create') }}" class="inline-flex items-center gap-2 px-5 py-2.5 text-sm font-bold text-white transition bg-teal-600 rounded-lg hover:bg-teal-700 shadow-sm">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                Nova Secretaria
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
            <h2 class="font-semibold text-slate-700 mr-auto">Órgãos Cadastrados</h2>
            <form method="GET" action="{{ route('admin.secretarias.index') }}" class="flex flex-col sm:flex-row sm:items-center gap-2 w-full sm:w-auto">
                <x-admin.filter-search value="{{ request('q') }}" placeholder="Pesquisar por secretaria ou titular..." class="focus:ring-teal-500 focus:border-teal-500" />
                <button type="submit" class="px-3 py-1.5 text-sm font-bold text-white bg-teal-600 rounded-lg hover:bg-teal-700 transition">Buscar</button>
                @if(request('q'))
                    <a href="{{ route('admin.secretarias.index') }}" class="px-3 py-1.5 text-sm font-bold text-slate-600 bg-white border border-slate-200 rounded-lg hover:bg-slate-50 transition">Limpar</a>
                @endif
            </form>
            <span class="px-2.5 py-1 text-xs font-bold rounded-full bg-slate-200 text-slate-600">{{ $secretarias->total() ?? 0 }}</span>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse table-fixed">
                <thead>
                    <tr class="text-xs tracking-wider uppercase border-b bg-slate-50 text-slate-500 border-slate-200">
                        <th class="p-4 font-semibold">Órgão / Secretaria</th>
                        <th class="p-4 font-semibold">Titular (Secretário/a)</th>
                        <th class="p-4 font-semibold w-64">Contatos</th>
                        <th class="p-4 font-semibold text-center w-36">Ações</th>
                    </tr>
                </thead>
                <tbody class="text-sm divide-y divide-slate-100">
                    @forelse($secretarias as $secretaria)
                        <tr class="transition group hover:bg-slate-50">
                            <td class="p-4 max-w-0 overflow-hidden">
                                <div class="flex items-center gap-3">
                                    <a href="{{ route('secretarias.show', $secretaria->id) }}" target="_blank" class="block group">
                                        @if($secretaria->foto)
                                            <img src="{{ asset('storage/' . $secretaria->foto) }}" alt="Foto do(a) Secretário(a)" class="object-cover w-10 h-10 rounded-full border-2 border-teal-200 shadow-sm group-hover:ring-2 group-hover:ring-teal-400 transition">
                                        @else
                                            <img src="https://ui-avatars.com/api/?name={{ urlencode($secretaria->nome_secretario ?: $secretaria->nome) }}&background=e2e8f0&color=94a3b8&size=96" alt="Avatar" class="object-cover w-10 h-10 rounded-full border-2 border-teal-200 shadow-sm group-hover:ring-2 group-hover:ring-teal-400 transition">
                                        @endif
                                    </a>
                                    <p class="font-bold text-slate-800 truncate" title="{{ $secretaria->nome }}">{{ \Illuminate\Support\Str::limit($secretaria->nome, 90) }}</p>
                                </div>
                            </td>
                            <td class="p-4 max-w-0 overflow-hidden">
                                <p class="font-medium text-slate-700 truncate" title="{{ $secretaria->nome_secretario ?? 'Não informado' }}">{{ \Illuminate\Support\Str::limit($secretaria->nome_secretario ?? 'Não informado', 70) }}</p>
                            </td>
                            <td class="p-4 text-slate-500 text-xs space-y-1">
                                @if($secretaria->telefone)
                                <div class="flex items-center gap-1.5">
                                    <svg class="w-3.5 h-3.5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path></svg>
                                    {{ $secretaria->telefone }}
                                </div>
                                @endif
                                @if($secretaria->email)
                                <div class="flex items-center gap-1.5">
                                    <svg class="w-3.5 h-3.5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
                                    <span class="truncate max-w-[180px]">{{ $secretaria->email }}</span>
                                </div>
                                @endif
                            </td>
                            <td class="p-4">
                                <div class="flex items-center justify-end gap-2">
                                    <x-admin.icon-action href="{{ route('secretarias.show', $secretaria->id) }}" target="_blank" color="slate" title="Ver no Portal">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                                    </x-admin.icon-action>
                                    <x-admin.icon-action href="{{ route('admin.secretarias.edit', $secretaria->id) }}" color="blue" title="Editar Registro">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                                    </x-admin.icon-action>
                                    <form action="{{ route('admin.secretarias.destroy', $secretaria->id) }}" method="POST" class="inline-block" onsubmit="return confirm('ATENÇÃO: Excluir uma secretaria pode impactar a exibição de serviços associados a ela. Confirmar?');">
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
                                Nenhuma secretaria cadastrada.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if(method_exists($secretarias, 'hasPages') && $secretarias->hasPages())
            <div class="p-4 border-t border-slate-100 bg-slate-50/50">
                {{ $secretarias->links('components.pagination.agenda-style') }}
            </div>
        @endif
    </div>

</div>
@endsection