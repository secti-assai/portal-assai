@extends('layouts.admin')
@section('content')
<div class="max-w-4xl mx-auto flex flex-col gap-6">
    <x-admin.page-header title="Editar Portal" :breadcrumbs="[['label' => 'Portais', 'url' => route('admin.portais.index')], ['label' => 'Editar']]">
        <x-slot:action><a href="{{ route('admin.portais.index') }}" class="px-4 py-2 border rounded-lg hover:bg-slate-50">Cancelar</a></x-slot:action>
    </x-admin.page-header>

    <form action="{{ route('admin.portais.update', $portal->id) }}" method="POST" class="bg-white p-6 rounded-xl border border-slate-200 shadow-sm space-y-6">
        @csrf
        @method('PUT')
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div class="space-y-1">
                <label class="text-sm font-bold text-slate-700">Título do Portal</label>
                <input type="text" name="titulo" value="{{ $portal->titulo }}" required class="bg-slate-50 border-slate-200 rounded-lg px-4 py-2 w-full focus:ring-2 focus:ring-blue-500 outline-none transition">
            </div>
            <div class="space-y-1">
                <label class="text-sm font-bold text-slate-700">Ícone (FontAwesome)</label>
                <input type="text" name="icone" value="{{ $portal->icone }}" class="bg-slate-50 border-slate-200 rounded-lg px-4 py-2 w-full focus:ring-2 focus:ring-blue-500 outline-none transition">
                <p class="text-[10px] text-slate-500">Ex: fa-magnifying-glass. Consulte em <a href="https://fontawesome.com/search?o=r&m=free" target="_blank" class="text-blue-500 underline">FontAwesome</a></p>
            </div>
        </div>

        <div class="space-y-1">
            <label class="text-sm font-bold text-slate-700">URL de Destino</label>
            <input type="url" name="url" value="{{ $portal->url }}" required class="bg-slate-50 border-slate-200 rounded-lg px-4 py-2 w-full focus:ring-2 focus:ring-blue-500 outline-none transition">
        </div>

        <div class="flex items-center">
            <label class="relative inline-flex items-center cursor-pointer">
                <input type="checkbox" name="ativo" value="1" class="sr-only peer" {{ $portal->ativo ? 'checked' : '' }}>
                <div class="w-11 h-6 bg-slate-200 peer-focus:outline-none rounded-full peer-checked:bg-blue-600 peer-checked:after:translate-x-full after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all"></div>
                <span class="ml-3 text-sm font-bold text-slate-700">Ativo no site</span>
            </label>
        </div>

        <div class="flex justify-end pt-4 border-t border-slate-100">
            <button type="submit" class="px-6 py-2.5 bg-blue-600 text-white font-bold rounded-lg shadow-md hover:bg-blue-700 transition">Salvar Alterações</button>
        </div>
    </form>
</div>
@endsection
