@extends('layouts.admin')

@section('content')
<div class="flex flex-col max-w-5xl gap-6 mx-auto">

    <x-admin.page-header
        title="Editar Banner"
        :breadcrumbs="[
            ['label' => 'Dashboard', 'url' => route('admin.dashboard'), 'class' => 'hover:text-indigo-600'],
            ['label' => 'Banners', 'url' => route('admin.banners.index'), 'class' => 'hover:text-indigo-600'],
            ['label' => 'Editar'],
        ]"
    >
        <x-slot:action>
            <a href="{{ route('admin.banners.index') }}" class="px-4 py-2 text-sm font-bold transition bg-white border rounded-lg text-slate-600 border-slate-300 hover:bg-slate-50 shadow-sm">
                Voltar
            </a>
        </x-slot:action>
    </x-admin.page-header>

    @if($errors->any())
        <div class="p-4 font-medium text-red-700 border border-red-200 bg-red-50 rounded-xl">
            <ul class="text-sm list-disc list-inside">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('admin.banners.update', $banner->id) }}" method="POST" class="grid grid-cols-1 gap-6 sm:gap-8 lg:grid-cols-3">
        @csrf
        @method('PUT')

        <div class="space-y-6 lg:col-span-2">
            <x-admin.panel class="space-y-6">
                <x-admin.input
                    name="titulo"
                    label="Título Principal"
                    :value="$banner->titulo"
                    required="true"
                    class="px-4 py-2.5 bg-slate-50 border-slate-200 rounded-lg focus:bg-white focus:ring-indigo-500 focus:border-indigo-500 outline-none transition-all"
                />

                <x-admin.input
                    name="subtitulo"
                    label="Subtítulo"
                    :value="$banner->subtitulo"
                    class="px-4 py-2.5 bg-slate-50 border-slate-200 rounded-lg focus:bg-white focus:ring-indigo-500 focus:border-indigo-500 outline-none transition-all"
                />

                <x-admin.input
                    type="url"
                    name="link"
                    label="Botão de Ação / Link de Destino"
                    :value="$banner->link"
                    class="px-4 py-2.5 bg-slate-50 border-slate-200 rounded-lg focus:bg-white focus:ring-indigo-500 focus:border-indigo-500 outline-none transition-all"
                />
            </x-admin.panel>
        </div>

        <div class="space-y-6">

            <x-admin.panel title="Visibilidade">
                <x-admin.checkbox name="ativo" label="Exibir no carrossel" :checked="$banner->ativo" color="indigo" />
            </x-admin.panel>

            <x-admin.button color="amber" class="w-full inline-flex items-center justify-center gap-2 px-6 py-3.5 rounded-xl shadow-md">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path></svg>
                Atualizar Banner
            </x-admin.button>

        </div>
    </form>
</div>
@endsection