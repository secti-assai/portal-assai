@extends('layouts.admin')

@section('content')
<div class="flex flex-col gap-6 max-w-3xl mx-auto">
    <x-admin.page-header
        title="Nova Categoria de Notícia"
        :breadcrumbs="[
            ['label' => 'Dashboard', 'url' => route('admin.dashboard'), 'class' => 'hover:text-blue-600'],
            ['label' => 'Notícias', 'url' => route('admin.noticias.index'), 'class' => 'hover:text-blue-600'],
            ['label' => 'Categorias', 'url' => route('admin.categorias.index'), 'class' => 'hover:text-blue-600'],
            ['label' => 'Nova'],
        ]"
    >
        <x-slot:action>
            <a href="{{ route('admin.categorias.index') }}" class="px-4 py-2 text-sm font-bold text-slate-600 bg-white border border-slate-300 rounded-lg hover:bg-slate-50 transition">
                Cancelar
            </a>
        </x-slot:action>
    </x-admin.page-header>

    @if($errors->any())
        <div class="p-4 bg-red-50 border border-red-200 rounded-xl text-red-700">
            <ul class="list-disc list-inside text-sm font-medium">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('admin.categorias.store') }}" method="POST" class="bg-white border border-slate-200 shadow-sm rounded-xl p-6 space-y-6">
        @csrf
        
        <x-admin.input
            name="nome"
            label="Nome do Tema/Categoria"
            required="true"
            placeholder="Ex: Saúde, Educação, Inovação..."
            class="bg-slate-50 border-slate-200 focus:bg-white focus:border-blue-500 outline-none transition-all"
        />

        <x-admin.checkbox-group
            name="perfis"
            label="Perfis Vinculados"
            :options="[
                'Cidadão' => 'Cidadão',
                'Turista' => 'Turista',
                'Empresário' => 'Empresário',
                'Servidor Público' => 'Servidor Público'
            ]"
            :columns="2"
        />

        <div class="pt-2">
            <label class="relative inline-flex items-center cursor-pointer">
                <input type="checkbox" name="ativo" value="1" class="sr-only peer" checked>
                <div class="w-11 h-6 bg-slate-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-blue-300 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-blue-600"></div>
                <span class="ml-3 text-sm font-bold text-slate-700">Categoria Ativa</span>
            </label>
            <p class="text-xs text-slate-500 mt-1 ml-14">Apenas categorias ativas aparecerão no momento de publicar uma notícia.</p>
        </div>

        <div class="pt-6 border-t border-slate-100 flex justify-end">
            <x-admin.button class="px-6 py-2.5 rounded-xl shadow-md flex items-center gap-2">
                <i class="fa-solid fa-check" aria-hidden="true"></i> Salvar Categoria
            </x-admin.button>
        </div>
    </form>
</div>
@endsection
