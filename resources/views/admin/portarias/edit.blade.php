@extends('layouts.admin')

@section('content')
<div class="flex flex-col gap-6 max-w-4xl mx-auto">

    <x-admin.page-header
        title="Editar Portaria"
        :breadcrumbs="[
            ['label' => 'Dashboard', 'url' => route('admin.dashboard'), 'class' => 'hover:text-blue-600'],
            ['label' => 'Portarias', 'url' => route('admin.portarias.index'), 'class' => 'hover:text-blue-600'],
            ['label' => 'Editar'],
        ]"
    >
        <x-slot:action>
            <a href="{{ route('admin.portarias.index') }}" class="px-4 py-2 text-sm font-bold text-slate-600 bg-white border border-slate-300 rounded-lg hover:bg-slate-50 transition">
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

    <div class="bg-white border border-slate-200 shadow-sm rounded-xl p-6">
        <form action="{{ route('admin.portarias.update', $portaria->id) }}" method="POST" enctype="multipart/form-data" class="space-y-6">
            @csrf
            @method('PUT')

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <x-admin.input
                    name="numero"
                    label="Número da Portaria"
                    required="true"
                    :value="$portaria->numero"
                />

                <x-admin.input
                    type="date"
                    name="data_publicacao"
                    label="Data de Publicação"
                    required="true"
                    :value="$portaria->data_publicacao->format('Y-m-d')"
                />
            </div>

            <x-admin.textarea
                name="sumula"
                label="Súmula / Ementa"
                required="true"
                rows="4"
                :value="$portaria->sumula"
            />

            <div class="border-t border-slate-100 pt-6 mt-6">
                <h3 class="text-sm font-bold text-slate-700 mb-4 uppercase tracking-wider">Documento PDF</h3>
                
                @if($portaria->caminho_local)
                    <div class="mb-4 p-4 bg-blue-50 border border-blue-100 rounded-lg flex items-center justify-between">
                        <div class="flex items-center gap-3">
                            <i class="fa-solid fa-file-pdf text-2xl text-blue-600"></i>
                            <div>
                                <p class="text-sm font-bold text-blue-900">Arquivo atual já enviado</p>
                                <a href="{{ asset('storage/' . $portaria->caminho_local) }}" target="_blank" class="text-xs text-blue-600 hover:underline">Clique para visualizar</a>
                            </div>
                        </div>
                        <span class="text-[10px] font-bold uppercase bg-blue-200 text-blue-800 px-2 py-1 rounded">Armazenado Localmente</span>
                    </div>
                @endif

                <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                    <x-admin.file-upload
                        name="pdf_file"
                        id="pdf-upload"
                        label="Substituir PDF"
                        accept="application/pdf"
                        help-text="Selecione um novo arquivo apenas se desejar substituir o atual"
                    />

                    <div class="space-y-4">
                        <x-admin.input
                            name="pdf_url"
                            label="URL externa"
                            :value="$portaria->pdf_url"
                            placeholder="https://exemplo.com/documento.pdf"
                        />
                    </div>
                </div>
            </div>

            <div class="flex items-center justify-end gap-3 pt-6 border-t border-slate-100">
                <x-admin.button class="px-8 py-3 rounded-xl shadow-md">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                    Atualizar Portaria
                </x-admin.button>
            </div>
        </form>
    </div>

</div>
@endsection
