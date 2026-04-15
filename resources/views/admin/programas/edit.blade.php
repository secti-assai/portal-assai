@extends('layouts.admin')

@section('content')
<div class="flex flex-col max-w-5xl gap-6 mx-auto">

    <x-admin.page-header
        title="Editar Programa"
        :breadcrumbs="[
            ['label' => 'Dashboard', 'url' => route('admin.dashboard'), 'class' => 'hover:text-emerald-600'],
            ['label' => 'Programas', 'url' => route('admin.programas.index'), 'class' => 'hover:text-emerald-600'],
            ['label' => 'Editar'],
        ]">
        <x-slot:action>
            <a href="{{ route('admin.programas.index') }}" class="px-4 py-2 text-sm font-bold transition bg-white border rounded-lg text-slate-600 border-slate-300 hover:bg-slate-50 shadow-sm">
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

    <form action="{{ route('admin.programas.update', $programa->id) }}" method="POST" enctype="multipart/form-data" class="grid grid-cols-1 gap-6 sm:gap-8 lg:grid-cols-3">
        @csrf
        @method('PUT')

        <div class="space-y-6 lg:col-span-2">
            <x-admin.panel class="space-y-5">
                <x-admin.input
                    name="titulo"
                    label="Título do Programa"
                    :value="$programa->titulo"
                    required="true"
                    class="px-4 py-2.5 bg-slate-50 border-slate-200 rounded-lg focus:bg-white focus:ring-emerald-500 focus:border-emerald-500 outline-none transition-all" />

                <x-admin.textarea
                    name="descricao"
                    label="Descrição Breve"
                    :value="$programa->descricao"
                    required="true"
                    rows="4"
                    class="bg-slate-50 border-slate-200 focus:bg-white focus:ring-emerald-500 focus:border-emerald-500 outline-none transition-all resize-none" />

                <x-admin.input
                    type="url"
                    name="link"
                    label="Link Externo de Acesso"
                    :value="$programa->link"
                    placeholder="https://..."
                    class="px-4 py-2.5 bg-slate-50 border-slate-200 rounded-lg focus:bg-white focus:ring-emerald-500 focus:border-emerald-500 outline-none transition-all" />
            </x-admin.panel>
        </div>

        <div class="space-y-6">

            <x-admin.panel title="Visibilidade">
                <x-admin.checkbox name="ativo" label="Programa Ativo" :checked="$programa->ativo" color="emerald" help-text="Se desmarcado, o programa não será exibido no portal público." />
                <x-admin.checkbox name="destaque" label="Destaque na Página Inicial" :checked="$programa->destaque" color="blue" help-text="Programas marcados como destaque têm prioridade na seção de programas da página inicial, que exibe 3 cards. O limite total é de 3 destaques." />
            </x-admin.panel>

            <x-admin.panel title="Identidade Visual">
                <x-admin.file-upload
                    name="icone"
                    id="programa-icone"
                    label="Ícone ou Imagem"
                    accept="image/*"
                    help-text="PNG, SVG ou JPG recomendado"
                    :preview-src="$programa->icone ? (str_starts_with($programa->icone, 'img/') ? asset($programa->icone) : asset('storage/' . $programa->icone)) : null" />
            </x-admin.panel>

            <x-admin.button color="amber" class="w-full inline-flex items-center justify-center gap-2 px-6 py-3.5 rounded-xl shadow-md">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path>
                </svg>
                Atualizar Programa
            </x-admin.button>

        </div>
    </form>
</div>

@endsection