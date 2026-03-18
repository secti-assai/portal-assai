@extends('layouts.admin')

@section('content')
<div class="flex flex-col gap-6">

    <x-admin.page-header
        title="Gerenciar Serviços"
        :breadcrumbs="[
            ['label' => 'Dashboard', 'url' => route('admin.dashboard'), 'class' => 'hover:text-orange-600'],
            ['label' => 'Serviços'],
        ]"
    >
        <x-slot:action>
            <a href="{{ route('admin.servicos.create') }}" class="inline-flex items-center gap-2 px-5 py-2.5 text-sm font-bold text-white transition bg-orange-500 rounded-lg hover:bg-orange-600 shadow-sm">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                Novo Serviço
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
            <h2 class="font-semibold text-slate-700 mr-auto">Serviços Cadastrados</h2>
            <form method="GET" action="{{ route('admin.servicos.index') }}" class="flex flex-col sm:flex-row sm:items-center gap-2 w-full sm:w-auto">
                <x-admin.filter-search name="search" value="{{ request('search') }}" placeholder="Pesquisar por título ou link..." class="focus:ring-orange-500 focus:border-orange-500" />
                <x-admin.filter-select
                    name="status"
                    :options="['' => 'Qualquer status', 'ativo' => 'Ativo', 'inativo' => 'Inativo']"
                    :value="request('status')"
                    placeholder="Qualquer status"
                    class="focus:ring-orange-500 focus:border-orange-500"
                />
                <x-admin.filter-select
                    name="icone"
                    :options="['' => 'Todos os tipos'] + $icones"
                    :value="request('icone')"
                    placeholder="Todos os tipos"
                    class="focus:ring-orange-500 focus:border-orange-500"
                />
                <x-admin.filter-select
                    name="ordenacao"
                    :options="['' => 'Ordem padrão', 'mais_acessados' => 'Mais acessados', 'menos_acessados' => 'Menos acessados']"
                    :value="request('ordenacao')"
                    placeholder="Ordem padrão"
                    class="focus:ring-orange-500 focus:border-orange-500"
                />
                <button type="submit" class="px-3 py-1.5 text-sm font-bold text-white bg-orange-500 rounded-lg hover:bg-orange-600 transition">Buscar</button>
                @if(request()->hasAny(['search', 'status', 'icone', 'ordenacao']))
                    <a href="{{ route('admin.servicos.index') }}" class="px-3 py-1.5 text-sm font-bold text-slate-600 bg-white border border-slate-200 rounded-lg hover:bg-slate-50 transition">Limpar</a>
                @endif
            </form>
            <span class="px-2.5 py-1 text-xs font-bold rounded-full bg-slate-200 text-slate-600">{{ $servicos->total() ?? 0 }}</span>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse table-fixed">
                <thead>
                    <tr class="text-xs tracking-wider uppercase border-b bg-slate-50 text-slate-500 border-slate-200">
                        <th class="p-4 font-semibold w-24 text-center">Ícone</th>
                        <th class="p-4 font-semibold">Título do Serviço</th>
                        <th class="p-4 font-semibold w-64">Link Destino</th>
                        <th class="p-4 font-semibold text-right w-24">Acessos</th>
                        <th class="p-4 font-semibold text-center w-28">Status</th>
                        <th class="p-4 font-semibold text-center w-32">Ações</th>
                    </tr>
                </thead>
                <tbody class="text-sm divide-y divide-slate-100">
                    @forelse($servicos as $servico)
                        <tr class="transition group hover:bg-slate-50">
                            <td class="p-4">
                                <a href="{{ route('admin.servicos.edit', $servico->id) }}" class="block group">
                                    <div class="flex items-center justify-center w-10 h-10 mx-auto rounded-lg bg-orange-50 text-orange-600 border border-orange-100">
                                        <svg class="w-10 h-10 mb-0 text-orange-600 transition-colors group-hover:text-orange-800" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            @switch($servico->icone)
                                            @case('saude')
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path>
                                            @break
                                            @case('vagas')
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                                            @break
                                            @case('documentos')
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                            @break
                                            @case('ouvidoria')
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M11 5.882V19.24a1.76 1.76 0 01-3.417.592l-2.147-6.15M18 13a3 3 0 100-6M5.436 13.683A4.001 4.001 0 017 6h1.832c4.1 0 7.625-1.234 9.168-3v14c-1.543-1.766-5.067-3-9.168-3H7a3.988 3.988 0 01-1.564-.317z"></path>
                                            @break
                                            @case('alvara')
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"></path>
                                            @break
                                            @case('educacao')
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 14l9-5-9-5-9 5 9 5z"></path>
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 14l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0012 20.055a11.952 11.952 0 00-6.824-2.998 12.078 12.078 0 01.665-6.479L12 14z"></path>
                                            @break
                                            @default
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M15 15l-2 5L9 9l11 4-5 2zm0 0l5 5M7.188 2.239l.777 2.897M5.136 7.965l-2.898-.777M13.95 4.05l-2.122 2.122m-5.657 5.656l-2.12 2.122"></path>
                                            @endswitch
                                        </svg>
                                    </div>
                                </a>
                            </td>
                            <td class="p-4 max-w-0 overflow-hidden">
                                <p class="font-bold text-slate-800 truncate" title="{{ $servico->titulo }}">{{ \Illuminate\Support\Str::limit($servico->titulo, 90) }}</p>
                                <p class="text-[10px] font-mono text-slate-400 mt-0.5 uppercase tracking-wider">Ref: {{ $servico->icone ?? 'padrao' }}</p>
                            </td>
                            <td class="p-4 text-slate-500 font-medium overflow-hidden">
                                <a href="{{ $servico->url_acesso ?? $servico->link }}" target="_blank" class="inline-flex items-center gap-1 hover:text-orange-600 transition w-full" title="{{ $servico->url_acesso ?? $servico->link }}">
                                    <span class="truncate">{{ $servico->url_acesso ?? $servico->link }}</span>
                                    <svg class="w-3 h-3 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"></path></svg>
                                </a>
                            </td>
                            <td class="p-4 text-right">
                                <span class="font-black text-slate-700">{{ number_format($servico->acessos, 0, ',', '.') }}</span>
                            </td>
                            <td class="p-4 text-center">
                                <x-admin.status-toggle
                                    :checked="$servico->ativo"
                                    :url="route('admin.servicos.toggle-status', $servico->id)"
                                    tone="orange"
                                    title-on="Desativar serviço"
                                    title-off="Ativar serviço"
                                />
                            </td>
                            <td class="p-4">
                                <div class="flex items-center justify-end gap-2">
                                    <x-admin.icon-action href="{{ route('admin.servicos.edit', $servico->id) }}" color="blue" title="Editar Serviço">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                                    </x-admin.icon-action>
                                    <form action="{{ route('admin.servicos.destroy', $servico->id) }}" method="POST" class="inline-block" onsubmit="return confirm('Tem certeza que deseja excluir este serviço?');">
                                        @csrf
                                        @method('DELETE')
                                        <x-admin.icon-action type="submit" color="red" title="Excluir Serviço">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                        </x-admin.icon-action>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="p-8 text-center text-slate-500">
                                Nenhum serviço cadastrado. Clique em "Novo Serviço" para adicionar.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if(method_exists($servicos, 'hasPages') && $servicos->hasPages())
            <div class="p-4 border-t border-slate-100 bg-slate-50/50">
                {{ $servicos->links() }}
            </div>
        @endif
    </div>

</div>

@endsection