@extends('layouts.admin')

@section('content')
<div class="flex flex-col gap-6">

    <x-admin.page-header
        title="Gerenciar Banners"
        :breadcrumbs="[
            ['label' => 'Dashboard', 'url' => route('admin.dashboard'), 'class' => 'hover:text-indigo-600'],
            ['label' => 'Banners da Home'],
        ]"
    >
        <x-slot:action>
            <a href="{{ route('admin.banners.create') }}" class="inline-flex items-center gap-2 px-5 py-2.5 text-sm font-bold text-white transition bg-indigo-600 rounded-lg hover:bg-indigo-700 shadow-sm">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                Novo Banner
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
            <h2 class="font-semibold text-slate-700 mr-auto">Imagens em Destaque</h2>
            <form method="GET" action="{{ route('admin.banners.index') }}" class="flex flex-col sm:flex-row sm:items-center gap-2 w-full sm:w-auto">
                <x-admin.filter-search name="search" value="{{ request('search') }}" placeholder="Pesquisar por título ou subtítulo..." class="focus:ring-indigo-500 focus:border-indigo-500" />
                <x-admin.filter-select
                    name="status"
                    :options="['' => 'Qualquer status', 'ativo' => 'Ativo', 'inativo' => 'Inativo']"
                    :value="request('status')"
                    placeholder="Qualquer status"
                    class="focus:ring-indigo-500 focus:border-indigo-500"
                />
                <button type="submit" class="px-3 py-1.5 text-sm font-bold text-white bg-indigo-600 rounded-lg hover:bg-indigo-700 transition">Buscar</button>
                @if(request()->hasAny(['search', 'status']))
                    <a href="{{ route('admin.banners.index') }}" class="px-3 py-1.5 text-sm font-bold text-slate-600 bg-white border border-slate-200 rounded-lg hover:bg-slate-50 transition">Limpar</a>
                @endif
            </form>
            <span class="px-2.5 py-1 text-xs font-bold rounded-full bg-slate-200 text-slate-600">{{ method_exists($banners, 'total') ? $banners->total() : $banners->count() }}</span>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse table-fixed">
                <thead>
                    <tr class="text-xs tracking-wider uppercase border-b bg-slate-50 text-slate-500 border-slate-200">
                        <th class="p-4 font-semibold w-48">Pré-visualização</th>
                        <th class="p-4 font-semibold">Conteúdo (Título e Subtítulo)</th>
                        <th class="p-4 font-semibold w-56">Link de Destino</th>
                        <th class="p-4 font-semibold text-center w-28">Status</th>
                        <th class="p-4 font-semibold text-center w-36">Ações</th>
                    </tr>
                </thead>
                <tbody class="text-sm divide-y divide-slate-100">
                    @forelse($banners as $banner)
                        <tr class="transition group hover:bg-slate-50">
                            <td class="p-4">
                                <a href="{{ route('admin.banners.edit', $banner->id) }}" class="block group">
                                    <div class="w-40 h-20 overflow-hidden bg-slate-100 border border-slate-200 rounded-lg shadow-sm">
                                        @if($banner->imagem)
                                            <img src="{{ asset('storage/' . $banner->imagem) }}" alt="Banner" class="object-cover w-full h-full transition-transform group-hover:scale-105">
                                        @else
                                            <div class="flex items-center justify-center w-full h-full text-xs font-bold text-slate-400">ERRO</div>
                                        @endif
                                    </div>
                                </a>
                            </td>
                            <td class="p-4 max-w-0 overflow-hidden">
                                <p class="font-bold text-slate-800 truncate" title="{{ $banner->titulo }}">{{ \Illuminate\Support\Str::limit($banner->titulo, 90) }}</p>
                                @if($banner->subtitulo)
                                    <p class="text-xs text-slate-500 mt-1 truncate">{{ \Illuminate\Support\Str::limit(strip_tags((string) $banner->subtitulo), 110) }}</p>
                                @endif
                            </td>
                            <td class="p-4 text-slate-500 font-medium overflow-hidden">
                                @if($banner->link)
                                    <a href="{{ $banner->link }}" target="_blank" class="inline-flex items-center gap-1 hover:text-indigo-600 transition w-full" title="{{ $banner->link }}">
                                        <span class="truncate">{{ $banner->link }}</span>
                                        <svg class="w-3 h-3 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"></path></svg>
                                    </a>
                                @else
                                    <span class="text-slate-400 text-xs">Sem link redirecionável</span>
                                @endif
                            </td>
                            <td class="p-4 text-center">
                                <x-admin.status-toggle
                                    :checked="$banner->ativo"
                                    :url="route('admin.banners.toggle-status', $banner->id)"
                                    tone="indigo"
                                    title-on="Desativar banner"
                                    title-off="Ativar banner"
                                />
                            </td>
                            <td class="p-4">
                                <div class="flex items-center justify-end gap-2">
                                    <x-admin.icon-action href="{{ route('admin.banners.edit', $banner->id) }}" color="blue" title="Editar Banner">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                                    </x-admin.icon-action>
                                    <form action="{{ route('admin.banners.destroy', $banner->id) }}" method="POST" class="inline-block" onsubmit='return confirm("Tem certeza que deseja excluir este banner?");'>
                                        @csrf
                                        @method('DELETE')
                                        <x-admin.icon-action type="submit" color="red" title="Excluir Banner">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                        </x-admin.icon-action>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="p-8 text-center text-slate-500">
                                Nenhum banner cadastrado. O portal exibirá a imagem padrão da cidade.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if(method_exists($banners, 'hasPages') && $banners->hasPages())
            <div class="p-4 border-t border-slate-100 bg-slate-50/50">
                {{ $banners->links() }}
            </div>
        @endif
    </div>

</div>

@endsection