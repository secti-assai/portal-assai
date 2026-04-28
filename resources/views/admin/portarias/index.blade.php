@extends('layouts.admin')

@section('content')
<div class="flex flex-col gap-6">

    <x-admin.page-header
        title="Gerenciar Portarias"
        :breadcrumbs="[
            ['label' => 'Dashboard', 'url' => route('admin.dashboard'), 'class' => 'hover:text-blue-600'],
            ['label' => 'Portarias'],
        ]"
    >
        <x-slot:action>
            <a href="{{ route('admin.portarias.create') }}" class="inline-flex items-center gap-2 px-5 py-2.5 text-sm font-bold text-white transition bg-blue-600 rounded-lg hover:bg-blue-700 shadow-sm">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                Nova Portaria
            </a>
        </x-slot:action>
    </x-admin.page-header>

    @if(session('success'))
        <div class="flex items-center gap-3 p-4 text-emerald-800 bg-emerald-50 border border-emerald-200 rounded-xl" role="alert">
            <svg class="w-5 h-5 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
            <p class="font-medium">{{ session('success') }}</p>
        </div>
    @endif

    <div class="bg-white border shadow-sm rounded-xl border-slate-200 overflow-hidden">
        
        <div class="p-4 border-b border-slate-100 bg-slate-50/50 flex flex-wrap items-center gap-3">
            <h2 class="font-semibold text-slate-700 mr-auto">Portarias Cadastradas</h2>
            <form method="GET" action="{{ route('admin.portarias.index') }}" class="flex flex-col sm:flex-row sm:items-center gap-2 w-full sm:w-auto">
                <x-admin.filter-search name="search" value="{{ request('search') }}" placeholder="Número ou súmula..." />
                <button type="submit" class="px-3 py-1.5 text-sm font-bold text-white bg-blue-600 rounded-lg hover:bg-blue-700 transition">Buscar</button>
                @if(request()->filled('search'))
                    <a href="{{ route('admin.portarias.index') }}" class="px-3 py-1.5 text-sm font-bold text-slate-600 bg-white border border-slate-200 rounded-lg hover:bg-slate-50 transition">Limpar</a>
                @endif
            </form>
            <span class="px-2.5 py-1 text-xs font-bold rounded-full bg-slate-200 text-slate-600">{{ $portarias->total() }}</span>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse table-fixed">
                <thead>
                    <tr class="bg-slate-50 text-slate-500 text-xs uppercase tracking-wider border-b border-slate-200">
                        <th class="p-4 font-semibold w-32">Número</th>
                        <th class="p-4 font-semibold">Súmula</th>
                        <th class="p-4 font-semibold w-32">Data</th>
                        <th class="p-4 font-semibold w-24">PDF</th>
                        <th class="p-4 font-semibold text-center w-32">Ações</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 text-sm">
                    @forelse($portarias as $portaria)
                        <tr class="transition hover:bg-slate-50 group">
                            <td class="p-4 font-bold text-slate-800">
                                {{ $portaria->numero }}
                            </td>
                            <td class="p-4">
                                <p class="text-slate-600 truncate" title="{{ $portaria->sumula }}">{{ $portaria->sumula }}</p>
                            </td>
                            <td class="p-4 text-slate-500">
                                {{ $portaria->data_publicacao->format('d/m/Y') }}
                            </td>
                            <td class="p-4 text-center">
                                @if($portaria->caminho_local)
                                    <a href="{{ asset('storage/' . $portaria->caminho_local) }}" target="_blank" class="text-blue-600 hover:text-blue-800" title="Ver PDF Local">
                                        <i class="fa-solid fa-file-pdf text-xl"></i>
                                    </a>
                                @elseif($portaria->pdf_url)
                                    <a href="{{ $portaria->pdf_url }}" target="_blank" class="text-slate-400 hover:text-slate-600" title="Ver PDF Externo">
                                        <i class="fa-solid fa-link text-xl"></i>
                                    </a>
                                @else
                                    <span class="text-slate-300">-</span>
                                @endif
                            </td>
                            <td class="p-4">
                                <div class="flex items-center justify-center gap-2">
                                    <x-admin.icon-action href="{{ route('admin.portarias.edit', $portaria->id) }}" color="blue" title="Editar Registro">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                                    </x-admin.icon-action>
                                    <form action="{{ route('admin.portarias.destroy', $portaria->id) }}" method="POST" class="inline-block" onsubmit="return confirm('Excluir este registro é uma ação irreversível. Confirmar?');">
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
                            <td colspan="5" class="p-8 text-center text-slate-500">
                                Nenhum registro encontrado.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($portarias->hasPages())
            <div class="p-4 border-t border-slate-100 bg-slate-50/50">
                {{ $portarias->links() }}
            </div>
        @endif
    </div>

</div>
@endsection
