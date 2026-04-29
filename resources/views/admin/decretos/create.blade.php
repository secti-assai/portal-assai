@extends('layouts.admin')

@section('content')
<div class="flex flex-col gap-6 max-w-4xl mx-auto">

    <x-admin.page-header
        title="Novo Decreto"
        :breadcrumbs="[
            ['label' => 'Dashboard', 'url' => route('admin.dashboard'), 'class' => 'hover:text-blue-600'],
            ['label' => 'Decretos', 'url' => route('admin.decretos.index'), 'class' => 'hover:text-blue-600'],
            ['label' => 'Novo'],
        ]"
    >
        <x-slot:action>
            <a href="{{ route('admin.decretos.index') }}" class="px-4 py-2 text-sm font-bold text-slate-600 bg-white border border-slate-300 rounded-lg hover:bg-slate-50 transition">
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
        <form action="{{ route('admin.decretos.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
            @csrf

            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <div class="md:col-span-1">
                    <x-admin.input
                        name="numero"
                        label="Número do Decreto"
                        required="true"
                        placeholder="Ex: 123/2026"
                    />
                    @if($ultimo)
                        <p class="mt-1 text-[11px] font-bold text-slate-500 italic">
                            <i class="fa-solid fa-circle-info mr-1"></i> Último decreto publicado: <span class="text-blue-600">{{ $ultimo->numero }}</span>
                        </p>
                    @endif
                </div>

                <x-admin.select
                    name="tipo"
                    label="Tipo de Decreto"
                    placeholder="Selecione o tipo..."
                    :options="[
                        'Padrão' => 'Padrão',
                        'Alteração orçamentária' => 'Alteração orçamentária',
                        'Normativo' => 'Normativo',
                        'Regulamentação' => 'Regulamentação',
                        'Prestação de contas' => 'Prestação de contas',
                        'Covid19' => 'Covid19',
                    ]"
                    class="md:col-span-1"
                />

                <x-admin.input
                    type="date"
                    name="data_publicacao"
                    label="Data de Publicação"
                    required="true"
                    :value="now()->format('Y-m-d')"
                    class="md:col-span-1"
                />
            </div>

            <x-admin.textarea
                name="sumula"
                label="Súmula / Ementa"
                required="true"
                rows="4"
                placeholder="Descrição resumida do ato oficial..."
            />

            <div class="border-t border-slate-100 pt-6 mt-6">
                <h3 class="text-sm font-bold text-slate-700 mb-4 uppercase tracking-wider">Documento PDF</h3>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                    <x-admin.file-upload
                        name="pdf_file"
                        id="pdf-upload"
                        label="Upload do PDF"
                        accept="application/pdf"
                        help-text="Arquivo PDF até 10MB"
                    />

                    <div class="space-y-4">
                        <x-admin.input
                            name="pdf_url"
                            label="Ou informe uma URL externa"
                            placeholder="https://exemplo.com/documento.pdf"
                        />
                    </div>
                </div>
            </div>

            <div class="flex items-center justify-end gap-3 pt-6 border-t border-slate-100">
                <x-admin.button class="px-8 py-3 rounded-xl shadow-md">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                    Salvar Decreto
                </x-admin.button>
            </div>
        </form>
    </div>

</div>
@endsection
