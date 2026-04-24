@extends('layouts.admin')

@section('content')


<div class="flex flex-col gap-6 max-w-6xl mx-auto">

    <x-admin.page-header
        title="Criar Nova Notícia"
        :breadcrumbs="[
            ['label' => 'Dashboard', 'url' => route('admin.dashboard'), 'class' => 'hover:text-blue-600'],
            ['label' => 'Notícias', 'url' => route('admin.noticias.index'), 'class' => 'hover:text-blue-600'],
            ['label' => 'Nova'],
        ]"
    >
        <x-slot:action>
            <a href="{{ route('admin.noticias.index') }}" class="px-4 py-2 text-sm font-bold text-slate-600 bg-white border border-slate-300 rounded-lg hover:bg-slate-50 transition">
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

    <form action="{{ route('admin.noticias.store') }}" method="POST" enctype="multipart/form-data" class="grid grid-cols-1 lg:grid-cols-3 gap-6 sm:gap-8">
        @csrf

        {{-- Coluna Principal (Formulário de Conteúdo) --}}
        <div class="lg:col-span-2 space-y-6">
            <div class="bg-white border border-slate-200 shadow-sm rounded-xl p-6 space-y-5">
                
                <x-admin.input
                    name="titulo"
                    label="Título da Notícia"
                    required="true"
                    class="px-4 py-2.5 bg-slate-50 border-slate-200 rounded-lg focus:bg-white focus:border-blue-500 outline-none transition-all"
                />

                <x-admin.textarea
                    name="resumo"
                    label="Resumo"
                    hint="(Exibido nos cards da página inicial)"
                    rows="3"
                    class="bg-slate-50 border-slate-200 focus:bg-white focus:border-blue-500 outline-none transition-all resize-none"
                />

                <x-admin.rich-editor
                    name="conteudo"
                    label="Conteúdo Completo"
                    required="true"
                    rows="10"
                    id="editor"
                />

            </div>
        </div>

        {{-- Coluna Lateral (Metadados e Publicação) --}}
        <div class="space-y-6">
            
            {{-- Bloco de Publicação --}}
            <div class="bg-white border border-slate-200 shadow-sm rounded-xl p-6 space-y-5">
                <h3 class="font-bold text-slate-800 border-b border-slate-100 pb-3 mb-4">Publicação</h3>
                
                {{-- Toggle de Ativo/Inativo --}}
                <div class="mb-2">
                    <label class="relative inline-flex items-center cursor-pointer">
                        <input type="checkbox" name="ativo" value="1" class="sr-only peer" checked>
                        <div class="w-11 h-6 bg-slate-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-blue-300 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-blue-600"></div>
                        <span class="ml-3 text-sm font-bold text-slate-700">Notícia Ativa no Site</span>
                    </label>
                </div>

                {{-- Toggle de Destaque --}}
                <div class="mb-2">
                    <label class="relative inline-flex items-center cursor-pointer">
                        <input type="checkbox" name="destaque" value="1" class="sr-only peer">
                        <div class="w-11 h-6 bg-slate-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-amber-300 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-amber-500"></div>
                        <span class="ml-3 text-sm font-bold text-slate-700">Exibir no Slider de Destaque</span>
                    </label>
                </div>

                <x-admin.select
                    name="categoria"
                    label="Categoria"
                    :options="$categorias"
                    placeholder="Geral (Todos os perfis)"
                    required="false"
                    class="bg-slate-50 border-slate-200 focus:bg-white outline-none"
                />

                <x-admin.input
                    type="date"
                    name="data_publicacao"
                    label="Data de Publicação"
                    :value="now()->format('Y-m-d')"
                    required="true"
                    class="px-4 py-2.5 bg-slate-50 border-slate-200 rounded-lg focus:bg-white outline-none"
                />
            </div>

            {{-- Bloco de Multimédia --}}
            <div class="bg-white border border-slate-200 shadow-sm rounded-xl p-6">
                <h3 class="font-bold text-slate-800 border-b border-slate-100 pb-3 mb-4">Mídia</h3>
                
                <x-admin.file-upload
                    name="imagem_capa"
                    id="file-upload"
                    label="Imagem de Capa"
                    accept="image/*"
                    help-text="PNG, JPG, GIF até 2MB"
                />
            </div>

            <div class="flex items-center justify-end mt-6">
                <x-admin.button class="w-full justify-center px-6 py-3.5 rounded-xl shadow-md inline-flex items-center gap-2">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                    Publicar Notícia
                </x-admin.button>
            </div>

        </div>
    </form>

</div>

<script>
    window.ADMIN_CONFIG = {
        editorUploadUrl: "{{ route('admin.upload.editor') }}"
    };
</script>
@endsection
