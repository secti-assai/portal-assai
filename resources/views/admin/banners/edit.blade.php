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

    <form action="{{ route('admin.banners.update', $banner->id) }}" method="POST" enctype="multipart/form-data" class="grid grid-cols-1 gap-6 sm:gap-8 lg:grid-cols-3">
        @csrf
        @method('PUT')

        <div class="space-y-6 lg:col-span-2">
            <x-admin.panel class="space-y-6">
                @if($banner->imagem)
                    <div class="mb-4">
                        <span class="block text-sm font-semibold text-slate-700 mb-2">Imagem Atual</span>
                        <img src="{{ asset('storage/' . $banner->imagem) }}" alt="Banner" class="w-full max-w-md rounded-lg shadow-sm border border-slate-200 object-contain bg-slate-100 h-32">
                    </div>
                @endif

                <div>
                    <label for="imagem" class="block text-sm font-semibold text-slate-700 mb-2">Substituir Imagem</label>
                    <input type="file" name="imagem" id="imagem" accept="image/jpeg,image/png,image/webp" class="block w-full text-sm text-slate-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-indigo-50 file:text-indigo-700 hover:file:bg-indigo-100 transition">
                    <p class="mt-2 text-xs text-slate-500">Deixe em branco para manter a imagem atual.</p>
                </div>

                <div class="pt-2">
                    <label class="flex items-center gap-2 cursor-pointer group">
                        <input type="checkbox" name="exibir_inteira" value="1" {{ $banner->exibir_inteira ? 'checked' : '' }} class="w-5 h-5 text-indigo-600 rounded bg-slate-100 border-slate-300 focus:ring-indigo-600 focus:ring-2 transition">
                        <span class="text-sm font-semibold text-slate-700 group-hover:text-indigo-600 transition">
                            Modo Imagem Inteira (Sem cortes)
                        </span>
                    </label>
                    <p class="mt-1 text-xs text-slate-500 pl-7">Ideal para panfletos e flyers onde todo o texto da imagem precisa ficar visível sem ser cortado pelo ajuste da tela.</p>
                </div>


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
