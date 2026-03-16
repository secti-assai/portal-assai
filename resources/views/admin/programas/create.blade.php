@extends('layouts.admin')

@section('content')
<div class="flex flex-col max-w-5xl gap-6 mx-auto">

    <x-admin.page-header
        title="Criar Novo Programa"
        :breadcrumbs="[
            ['label' => 'Dashboard', 'url' => route('admin.dashboard'), 'class' => 'hover:text-emerald-600'],
            ['label' => 'Programas', 'url' => route('admin.programas.index'), 'class' => 'hover:text-emerald-600'],
            ['label' => 'Novo'],
        ]"
    >
        <x-slot:action>
            <a href="{{ route('admin.programas.index') }}" class="px-4 py-2 text-sm font-bold transition bg-white border rounded-lg text-slate-600 border-slate-300 hover:bg-slate-50 shadow-sm">
                Cancelar
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

    <form action="{{ route('admin.programas.store') }}" method="POST" enctype="multipart/form-data" class="grid grid-cols-1 gap-8 lg:grid-cols-3">
        @csrf

        <div class="space-y-6 lg:col-span-2">
            <x-admin.panel class="space-y-5">
                <x-admin.input
                    name="titulo"
                    label="Título do Programa"
                    required="true"
                    class="px-4 py-2.5 bg-slate-50 border-slate-200 rounded-lg focus:bg-white focus:ring-emerald-500 focus:border-emerald-500 outline-none transition-all"
                />

                <x-admin.textarea
                    name="descricao"
                    label="Descrição Breve"
                    required="true"
                    rows="4"
                    help-text='Texto exibido no card da página "Assaí em Ação".'
                    class="bg-slate-50 border-slate-200 focus:bg-white focus:ring-emerald-500 focus:border-emerald-500 outline-none transition-all resize-none"
                />

                <x-admin.input
                    type="url"
                    name="link"
                    label="Link Externo de Acesso"
                    placeholder="https://..."
                    class="px-4 py-2.5 bg-slate-50 border-slate-200 rounded-lg focus:bg-white focus:ring-emerald-500 focus:border-emerald-500 outline-none transition-all"
                />
            </x-admin.panel>
        </div>

        <div class="space-y-6">
            
            <x-admin.panel title="Visibilidade">
                <x-admin.checkbox name="ativo" label="Programa Ativo" checked="true" color="emerald" help-text="Se desmarcado, o programa não será exibido no portal público." />
                <x-admin.checkbox name="destaque" label="Destaque na Página Inicial" color="blue" help-text="Programas marcados como destaque aparecem primeiro na seção da página inicial (máx. 4)." />
            </x-admin.panel>

            <x-admin.panel title="Identidade Visual">
                <x-admin.file-upload
                    name="icone"
                    id="programa-icone"
                    label="Ícone ou Imagem"
                    accept="image/*"
                    help-text="PNG, SVG ou JPG recomendado"
                />
            </x-admin.panel>

            <x-admin.button color="emerald" class="w-full inline-flex items-center justify-center gap-2 px-6 py-3.5 rounded-xl shadow-md">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                Salvar Programa
            </x-admin.button>

        </div>
    </form>
</div>

@endsection