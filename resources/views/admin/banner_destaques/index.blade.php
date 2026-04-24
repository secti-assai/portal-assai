@extends('layouts.admin')

@section('content')
<div class="flex flex-col gap-6">
    <x-admin.page-header title="Banners de Destaque (Página Inicial)" :breadcrumbs="[['label' => 'Dashboard', 'url' => route('admin.dashboard')], ['label' => 'Banners Destaque']]">
        <x-slot:action>
            <a href="{{ route('admin.banner-destaques.create') }}" class="inline-flex items-center gap-2 px-5 py-2.5 text-sm font-bold text-white transition bg-blue-600 rounded-lg hover:bg-blue-700 shadow-sm">
                Novo Banner
            </a>
        </x-slot:action>
    </x-admin.page-header>

    @if(session('sucesso'))
        <div class="p-4 text-emerald-800 bg-emerald-50 border border-emerald-200 rounded-xl">{{ session('sucesso') }}</div>
    @endif

    <div class="bg-white border shadow-sm rounded-xl border-slate-200 overflow-hidden">
        <table class="w-full text-left border-collapse table-fixed">
            <thead>
                <tr class="bg-slate-50 text-slate-500 text-xs uppercase border-b border-slate-200">
                    <th class="p-4 w-32">Imagem</th>
                    <th class="p-4">Título & Link</th>
                    <th class="p-4 w-24">Ordem</th>
                    <th class="p-4 w-32">Status</th>
                    <th class="p-4 w-32 text-center">Ações</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-100 text-sm">
                @foreach($banners as $banner)
                <tr class="hover:bg-slate-50">
                    <td class="p-4">
                        <img src="{{ asset($banner->imagem) }}" class="w-24 h-12 object-cover rounded border border-slate-200">
                    </td>
                    <td class="p-4 font-bold text-slate-800 truncate">
                        {{ $banner->titulo }}<br>
                        <a href="{{ $banner->link }}" target="_blank" class="text-xs font-normal text-blue-500 hover:underline">{{ $banner->link ?? 'Sem link' }}</a>
                    </td>
                    <td class="p-4">{{ $banner->ordem }}</td>
                    <td class="p-4">
                        @if($banner->ativo) <span class="px-2 py-0.5 bg-emerald-100 text-emerald-800 rounded text-[11px] font-bold">Ativo</span>
                        @else <span class="px-2 py-0.5 bg-rose-100 text-rose-800 rounded text-[11px] font-bold">Inativo</span> @endif
                    </td>
                    <td class="p-4 text-center flex items-center justify-center gap-2">
                        <x-admin.icon-action href="{{ route('admin.banner-destaques.edit', $banner->id) }}" color="blue" title="Editar">
                            <i class="fa-solid fa-pen"></i>
                        </x-admin.icon-action>
                        <form action="{{ route('admin.banner-destaques.destroy', $banner->id) }}" method="POST" onsubmit="return confirm('Excluir este banner?');">
                            @csrf @method('DELETE')
                            <x-admin.icon-action type="submit" color="red" title="Excluir"><i class="fa-solid fa-trash"></i></x-admin.icon-action>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection
