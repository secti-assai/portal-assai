@extends('layouts.admin')

@section('content')


<div class="flex flex-col gap-6 max-w-6xl mx-auto">

    <x-admin.page-header
        title="Editar Notícia"
        :breadcrumbs="[
            ['label' => 'Dashboard', 'url' => route('admin.dashboard'), 'class' => 'hover:text-blue-600'],
            ['label' => 'Notícias', 'url' => route('admin.noticias.index'), 'class' => 'hover:text-blue-600'],
            ['label' => 'Editar'],
        ]"
    >
        <x-slot:action>
            <a href="{{ route('admin.noticias.index') }}" class="px-4 py-2 text-sm font-bold text-slate-600 bg-white border border-slate-300 rounded-lg hover:bg-slate-50 transition shadow-sm">
                Voltar
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

    <form action="{{ route('admin.noticias.update', $noticia->id) }}" method="POST" enctype="multipart/form-data" class="grid grid-cols-1 lg:grid-cols-3 gap-6 sm:gap-8">
        @csrf
        @method('PUT')

        {{-- Coluna Principal (Formulário de Conteúdo) --}}
        <div class="lg:col-span-2 space-y-6">
            <x-admin.panel class="space-y-5">
                <x-admin.input
                    name="titulo"
                    label="Título da Notícia"
                    :value="$noticia->titulo"
                    required="true"
                    class="px-4 py-2.5 bg-slate-50 border-slate-200 rounded-lg focus:bg-white focus:border-blue-500 outline-none transition-all"
                />

                <x-admin.textarea
                    name="resumo"
                    label="Resumo"
                    :value="$noticia->resumo"
                    hint="(Exibido nos cards da página inicial)"
                    rows="3"
                    class="bg-slate-50 border-slate-200 focus:bg-white focus:border-blue-500 outline-none transition-all resize-none"
                />

                <x-admin.rich-editor
                    name="conteudo"
                    label="Conteúdo Completo"
                    :value="$noticia->conteudo"
                    required="true"
                    rows="10"
                    id="editor"
                />
            </x-admin.panel>
        </div>

        {{-- Coluna Lateral (Metadados e Publicação) --}}
        <div class="space-y-6">
            
            {{-- Bloco de Publicação --}}
            <x-admin.panel title="Publicação" class="space-y-5">
                
                {{-- Toggle de Ativo/Inativo inteligente baseado no banco --}}
                <div class="mb-2">
                    <label class="relative inline-flex items-center cursor-pointer">
                        <input type="checkbox" name="ativo" value="1" class="sr-only peer" {{ $noticia->ativo ? 'checked' : '' }}>
                        <div class="w-11 h-6 bg-slate-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-blue-300 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-blue-600"></div>
                        <span class="ml-3 text-sm font-bold text-slate-700">Notícia Ativa no Site</span>
                    </label>
                </div>

                {{-- Toggle de Destaque inteligente baseado no banco --}}
                <div class="mb-2">
                    <label class="relative inline-flex items-center cursor-pointer">
                        <input type="checkbox" name="destaque" value="1" class="sr-only peer" {{ $noticia->destaque ? 'checked' : '' }}>
                        <div class="w-11 h-6 bg-slate-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-amber-300 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-amber-500"></div>
                        <span class="ml-3 text-sm font-bold text-slate-700">Exibir no Slider de Destaque</span>
                    </label>
                </div>

                <x-admin.multi-select
                    name="categorias"
                    label="Categorias / Temas"
                    :options="$categorias"
                    :selected="$noticiaCategoriasIds"
                    placeholder="Busque ou selecione temas..."
                />

                <x-admin.input
                    type="date"
                    name="data_publicacao"
                    label="Data de Publicação"
                    :value="\Carbon\Carbon::parse($noticia->data_publicacao)->format('Y-m-d')"
                    required="true"
                    class="px-4 py-2.5 bg-slate-50 border-slate-200 rounded-lg focus:bg-white outline-none"
                />
            </x-admin.panel>

            {{-- Bloco de Multimédia --}}
            <x-admin.panel title="Mídia">
                <x-admin.file-upload
                    name="imagem_capa"
                    id="noticia-imagem-capa"
                    label="Nova Imagem de Capa"
                    accept="image/*"
                    help-text="PNG, JPG, GIF até 2MB"
                    :preview-src="$noticia->imagem_capa ? asset('storage/' . $noticia->imagem_capa) : null"
                />

                <div class="mt-6 pt-6 border-t border-slate-100">
                    <label class="block mb-4 text-sm font-bold text-gray-700">Galeria de Fotos</label>
                    
                    @if($noticia->galeria && count($noticia->galeria) > 0)
                        <div class="grid grid-cols-3 gap-3 mb-6">
                            @foreach($noticia->galeria as $foto)
                                <div class="relative group aspect-square rounded-lg overflow-hidden border border-slate-200 bg-slate-50">
                                    <img src="{{ asset('storage/' . $foto) }}" class="w-full h-full object-cover">
                                    <div class="absolute inset-0 bg-red-600/60 opacity-0 group-hover:opacity-100 transition-opacity flex items-center justify-center">
                                        <label class="flex items-center gap-2 cursor-pointer bg-white px-2 py-1 rounded shadow-sm text-[10px] font-bold text-red-600 uppercase">
                                            <input type="checkbox" name="remover_fotos[]" value="{{ $foto }}" class="rounded text-red-600 focus:ring-red-500">
                                            Remover
                                        </label>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @endif

                    <div class="p-4 bg-blue-50 border border-blue-100 rounded-xl">
                        <label class="block mb-2 text-xs font-bold text-blue-800 uppercase tracking-wide">Adicionar Novas Fotos</label>
                        <input type="file" name="galeria[]" multiple accept="image/*" class="block w-full text-xs text-slate-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-xs file:font-semibold file:bg-blue-600 file:text-white hover:file:bg-blue-700 transition-all cursor-pointer">
                    </div>
                </div>
            </x-admin.panel>

            <x-admin.button color="amber" class="w-full inline-flex items-center justify-center gap-2 px-6 py-3.5 rounded-xl shadow-md">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path></svg>
                Atualizar Notícia
            </x-admin.button>

        </div>
    </form>

</div>

<script>
    window.ADMIN_CONFIG = {
        editorUploadUrl: "{{ route('admin.upload.editor') }}"
    };
</script>
@endsection
