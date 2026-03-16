@extends('layouts.admin')

@section('content')
<div class="flex flex-col max-w-5xl gap-6 mx-auto">

    <x-admin.page-header
        title="Criar Novo Banner"
        :breadcrumbs="[
            ['label' => 'Dashboard', 'url' => route('admin.dashboard'), 'class' => 'hover:text-indigo-600'],
            ['label' => 'Banners', 'url' => route('admin.banners.index'), 'class' => 'hover:text-indigo-600'],
            ['label' => 'Novo'],
        ]"
    >
        <x-slot:action>
            <a href="{{ route('admin.banners.index') }}" class="px-4 py-2 text-sm font-bold transition bg-white border rounded-lg text-slate-600 border-slate-300 hover:bg-slate-50 shadow-sm">
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

    <form action="{{ route('admin.banners.store') }}" method="POST" enctype="multipart/form-data" class="grid grid-cols-1 gap-8 lg:grid-cols-3">
        @csrf

        {{-- Coluna Principal --}}
        <div class="space-y-6 lg:col-span-2">
            <x-admin.panel class="space-y-6">
                
                <div class="p-4 bg-indigo-50 border border-indigo-100 rounded-lg text-sm text-indigo-800">
                    <p class="font-bold mb-1">Recomendações de Imagem:</p>
                    <ul class="list-disc list-inside text-indigo-700/80">
                        <li>Utilize imagens em alta resolução (formato horizontal / paisagem).</li>
                        <li>Tamanho ideal: 1920x800 pixels.</li>
                        <li>A imagem receberá uma sobreposição escura nativa no portal para garantir a legibilidade do texto.</li>
                    </ul>
                </div>

                <x-admin.input
                    name="titulo"
                    label="Título Principal"
                    required="true"
                    placeholder="Ex: Assaí Recebe Novo Polo de Inovação"
                    class="px-4 py-2.5 bg-slate-50 border-slate-200 rounded-lg focus:bg-white focus:ring-indigo-500 focus:border-indigo-500 outline-none transition-all"
                />

                <x-admin.input
                    name="subtitulo"
                    label="Subtítulo"
                    placeholder="Texto de apoio exibido abaixo do título..."
                    class="px-4 py-2.5 bg-slate-50 border-slate-200 rounded-lg focus:bg-white focus:ring-indigo-500 focus:border-indigo-500 outline-none transition-all"
                />

                <x-admin.input
                    type="url"
                    name="link"
                    label="Botão de Ação / Link de Destino"
                    placeholder="https://..."
                    help-text='Se preenchido, um botão "Saiba mais" será gerado automaticamente no banner.'
                    class="px-4 py-2.5 bg-slate-50 border-slate-200 rounded-lg focus:bg-white focus:ring-indigo-500 focus:border-indigo-500 outline-none transition-all"
                />

            </x-admin.panel>
        </div>

        {{-- Coluna Lateral --}}
        <div class="space-y-6">
            
            <x-admin.panel title="Upload de Arquivo">
                <x-admin.file-upload
                    name="imagem"
                    id="banner-imagem"
                    label="Arquivo de Imagem"
                    accept="image/*"
                    help-text="PNG, JPG ou WEBP até 5MB"
                    required="true"
                />
            </x-admin.panel>

            <x-admin.panel title="Visibilidade">
                <x-admin.checkbox name="ativo" label="Exibir no carrossel" checked="true" color="indigo" />
            </x-admin.panel>

            <x-admin.button color="indigo" class="w-full inline-flex items-center justify-center gap-2 px-6 py-3.5 rounded-xl shadow-md">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                Publicar Banner
            </x-admin.button>

        </div>
    </form>
</div>

@endsection