@extends('layouts.admin')

@section('content')
<div class="flex flex-col gap-6 max-w-6xl mx-auto">

    <x-admin.page-header
        title="Novo Diário Oficial"
        :breadcrumbs="[
            ['label' => 'Dashboard', 'url' => route('admin.dashboard'), 'class' => 'hover:text-blue-600'],
            ['label' => 'Diários Oficiais', 'url' => route('admin.diarios.index'), 'class' => 'hover:text-blue-600'],
            ['label' => 'Novo'],
        ]"
    >
        <x-slot:action>
            <a href="{{ route('admin.diarios.index') }}" class="px-4 py-2 text-sm font-bold text-slate-600 bg-white border border-slate-300 rounded-lg hover:bg-slate-50 transition">
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

    <form action="{{ route('admin.diarios.store') }}" method="POST" enctype="multipart/form-data" class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        @csrf

        {{-- Coluna Principal: Dados da Edição e PDF --}}
        <div class="lg:col-span-2 space-y-6">
            <div class="bg-white border border-slate-200 shadow-sm rounded-xl p-6 space-y-6">
                <h3 class="font-bold text-slate-800 border-b border-slate-100 pb-3">Dados da Edição</h3>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <x-admin.input
                            type="number"
                            name="edicao"
                            label="Número da Edição"
                            required="true"
                            placeholder="Ex: 1540"
                        />
                        @if($ultimo)
                            <p class="mt-1 text-[11px] font-bold text-slate-500 italic">
                                <i class="fa-solid fa-circle-info mr-1"></i> Última edição publicada: <span class="text-blue-600">{{ $ultimo->edicao }}</span>
                            </p>
                        @endif
                    </div>

                    <x-admin.input
                        type="date"
                        name="data_publicacao"
                        label="Data de Publicação"
                        required="true"
                        :value="now()->format('Y-m-d')"
                    />
                </div>

                <div class="border-t border-slate-100 pt-6 mt-6">
                    <h3 class="font-bold text-slate-800 pb-3">Documento PDF</h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                        <x-admin.file-upload
                            name="pdf_file"
                            id="pdf-upload"
                            label="Upload do PDF"
                            accept="application/pdf"
                            help-text="Arquivo PDF até 20MB"
                        />

                        <div class="space-y-4">
                            <x-admin.input
                                name="pdf_url"
                                label="Ou informe uma URL externa"
                                placeholder="https://exemplo.com/diario.pdf"
                            />
                        </div>
                    </div>
                </div>
            </div>

            {{-- Informações do Assinante --}}
            <div class="bg-white border border-slate-200 shadow-sm rounded-xl p-6 space-y-6">
                <h3 class="font-bold text-slate-800 border-b border-slate-100 pb-3">Informações do Assinante</h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <x-admin.input name="assinante_nome" label="Nome do Responsável" />
                    <x-admin.input name="assinante_cpf" label="CPF (somente números)" maxlength="11" />
                    <x-admin.input name="assinante_email" label="E-mail do Responsável" type="email" />
                    <x-admin.input name="assinante_id" label="ID do Assinante" />
                </div>
            </div>
        </div>

        {{-- Coluna Lateral: Certificado e Carimbo --}}
        <div class="space-y-6">
            <div class="bg-white border border-slate-200 shadow-sm rounded-xl p-6 space-y-6">
                <h3 class="font-bold text-slate-800 border-b border-slate-100 pb-3">Certificado Digital</h3>
                <x-admin.input type="date" name="certificado_emissao" label="Emissão" />
                <x-admin.input type="date" name="certificado_validade" label="Validade" />
                <x-admin.input name="certificado_versao" label="Versão" />
                <x-admin.input name="certificado_serial" label="Número Serial" />
                <x-admin.textarea name="certificado_hash" label="Hash do Certificado" rows="2" />
            </div>

            <div class="bg-white border border-slate-200 shadow-sm rounded-xl p-6 space-y-6">
                <h3 class="font-bold text-slate-800 border-b border-slate-100 pb-3">Carimbo de Tempo</h3>
                <x-admin.input type="datetime-local" name="carimbo_data_hora" label="Data e Hora" />
                <x-admin.input name="carimbo_servidor" label="Servidor" />
                <x-admin.input name="carimbo_politica" label="Política" />
            </div>

            <div class="flex items-center justify-end mt-6">
                <x-admin.button class="w-full justify-center px-6 py-3.5 rounded-xl shadow-md inline-flex items-center gap-2">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                    Salvar Diário Oficial
                </x-admin.button>
            </div>
        </div>
    </form>

</div>
@endsection
