@extends('layouts.admin')

@section('content')
<div class="flex flex-col gap-6 max-w-6xl mx-auto">

    <x-admin.page-header
        title="Editar Diário Oficial"
        :breadcrumbs="[
            ['label' => 'Dashboard', 'url' => route('admin.dashboard'), 'class' => 'hover:text-blue-600'],
            ['label' => 'Diários Oficiais', 'url' => route('admin.diarios.index'), 'class' => 'hover:text-blue-600'],
            ['label' => 'Editar'],
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

    <form action="{{ route('admin.diarios.update', $diario->id) }}" method="POST" enctype="multipart/form-data" class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        @csrf
        @method('PUT')

        {{-- Coluna Principal: Dados da Edição e PDF --}}
        <div class="lg:col-span-2 space-y-6">
            <div class="bg-white border border-slate-200 shadow-sm rounded-xl p-6 space-y-6">
                <h3 class="font-bold text-slate-800 border-b border-slate-100 pb-3">Dados da Edição</h3>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <x-admin.input
                        type="number"
                        name="edicao"
                        label="Número da Edição"
                        required="true"
                        :value="$diario->edicao"
                    />

                    <x-admin.input
                        type="date"
                        name="data_publicacao"
                        label="Data de Publicação"
                        required="true"
                        :value="$diario->data_publicacao->format('Y-m-d')"
                    />
                </div>

                <div class="border-t border-slate-100 pt-6 mt-6">
                    <h3 class="font-bold text-slate-800 pb-3">Documento PDF</h3>
                    
                    @if($diario->caminho_local)
                        <div class="mb-4 p-4 bg-blue-50 border border-blue-100 rounded-lg flex items-center justify-between">
                            <div class="flex items-center gap-3">
                                <i class="fa-solid fa-file-pdf text-2xl text-blue-600"></i>
                                <div>
                                    <p class="text-sm font-bold text-blue-900">Arquivo atual já enviado</p>
                                    <a href="{{ asset('storage/' . $diario->caminho_local) }}" target="_blank" class="text-xs text-blue-600 hover:underline">Clique para visualizar</a>
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
                            help-text="Arquivo PDF até 20MB"
                        />

                        <div class="space-y-4">
                            <x-admin.input
                                name="pdf_url"
                                label="Ou informe uma URL externa"
                                :value="$diario->pdf_url"
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
                    <x-admin.input name="assinante_nome" label="Nome do Responsável" :value="$diario->assinante_nome" />
                    <x-admin.input name="assinante_cpf" label="CPF (somente números)" maxlength="11" :value="$diario->assinante_cpf" />
                    <x-admin.input name="assinante_email" label="E-mail do Responsável" type="email" :value="$diario->assinante_email" />
                    <x-admin.input name="assinante_id" label="ID do Assinante" :value="$diario->assinante_id" />
                </div>
            </div>
        </div>

        {{-- Coluna Lateral: Certificado e Carimbo --}}
        <div class="space-y-6">
            <div class="bg-white border border-slate-200 shadow-sm rounded-xl p-6 space-y-6">
                <h3 class="font-bold text-slate-800 border-b border-slate-100 pb-3">Certificado Digital</h3>
                <x-admin.input type="date" name="certificado_emissao" label="Emissão" :value="$diario->certificado_emissao ? $diario->certificado_emissao->format('Y-m-d') : ''" />
                <x-admin.input type="date" name="certificado_validade" label="Validade" :value="$diario->certificado_validade ? $diario->certificado_validade->format('Y-m-d') : ''" />
                <x-admin.input name="certificado_versao" label="Versão" :value="$diario->certificado_versao" />
                <x-admin.input name="certificado_serial" label="Número Serial" :value="$diario->certificado_serial" />
                <x-admin.textarea name="certificado_hash" label="Hash do Certificado" rows="2" :value="$diario->certificado_hash" />
            </div>

            <div class="bg-white border border-slate-200 shadow-sm rounded-xl p-6 space-y-6">
                <h3 class="font-bold text-slate-800 border-b border-slate-100 pb-3">Carimbo de Tempo</h3>
                <x-admin.input type="datetime-local" name="carimbo_data_hora" label="Data e Hora" :value="$diario->carimbo_data_hora ? $diario->carimbo_data_hora->format('Y-m-d\TH:i') : ''" />
                <x-admin.input name="carimbo_servidor" label="Servidor" :value="$diario->carimbo_servidor" />
                <x-admin.input name="carimbo_politica" label="Política" :value="$diario->carimbo_politica" />
            </div>

            <div class="flex items-center justify-end mt-6">
                <x-admin.button class="w-full justify-center px-6 py-3.5 rounded-xl shadow-md inline-flex items-center gap-2">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                    Atualizar Diário Oficial
                </x-admin.button>
            </div>
        </div>
    </form>

</div>
@endsection
