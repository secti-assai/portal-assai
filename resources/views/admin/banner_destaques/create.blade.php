@extends('layouts.admin')
@section('content')
<div class="max-w-4xl mx-auto flex flex-col gap-6">
    <x-admin.page-header title="Criar Banner Destaque" :breadcrumbs="[['label' => 'Banners', 'url' => route('admin.banner-destaques.index')], ['label' => 'Novo']]">
        <x-slot:action><a href="{{ route('admin.banner-destaques.index') }}" class="px-4 py-2 border rounded-lg hover:bg-slate-50">Cancelar</a></x-slot:action>
    </x-admin.page-header>

    <form action="{{ route('admin.banner-destaques.store') }}" method="POST" enctype="multipart/form-data" class="bg-white p-6 rounded-xl border border-slate-200 shadow-sm space-y-6">
        @csrf
        <x-admin.input name="titulo" label="Título (Uso interno)" required="true" class="bg-slate-50 border-slate-200 rounded-lg px-4 py-2 w-full" />
        <x-admin.input name="link" label="Link de Destino (Opcional)" type="url" placeholder="https://..." class="bg-slate-50 border-slate-200 rounded-lg px-4 py-2 w-full" />
        
        <div class="grid grid-cols-2 gap-6">
            <x-admin.input name="ordem" label="Ordem de Exibição" type="number" value="0" class="bg-slate-50 border-slate-200 rounded-lg px-4 py-2 w-full" />
            <div class="flex items-center mt-8">
                <label class="relative inline-flex items-center cursor-pointer">
                    <input type="checkbox" name="ativo" value="1" class="sr-only peer" checked>
                    <div class="w-11 h-6 bg-slate-200 peer-focus:outline-none rounded-full peer-checked:bg-blue-600 peer-checked:after:translate-x-full after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all"></div>
                    <span class="ml-3 text-sm font-bold text-slate-700">Ativo no site</span>
                </label>
            </div>
        </div>

        <x-admin.file-upload name="imagem" id="imagem" label="Imagem do Banner" accept="image/*" required="true" help-text="Recomendado: Proporção horizontal (ex: 800x400px)." />

        <div class="flex justify-end pt-4 border-t border-slate-100">
            <button type="submit" class="px-6 py-2.5 bg-blue-600 text-white font-bold rounded-lg shadow-md hover:bg-blue-700">Salvar Banner</button>
        </div>
    </form>
</div>
@endsection