@extends('layouts.admin')

@section('content')
@php
    $statusOptions = [
        'confirmado' => '✅ Confirmado / Agendado',
        'cancelado' => '❌ Cancelado',
    ];
@endphp

<div class="flex flex-col max-w-6xl gap-6 mx-auto">

    <x-admin.page-header
        title="Editar Evento"
        :breadcrumbs="[
            ['label' => 'Dashboard', 'url' => route('admin.dashboard'), 'class' => 'hover:text-blue-600'],
            ['label' => 'Agenda', 'url' => route('admin.eventos.index'), 'class' => 'hover:text-blue-600'],
            ['label' => 'Editar'],
        ]"
    >
        <x-slot:action>
            <a href="{{ route('admin.eventos.index') }}" class="px-4 py-2 text-sm font-bold transition bg-white border rounded-lg text-slate-600 border-slate-300 hover:bg-slate-50 shadow-sm">
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

    <form action="{{ route('admin.eventos.update', $evento->id) }}" method="POST" enctype="multipart/form-data" class="grid grid-cols-1 gap-6 sm:gap-8 lg:grid-cols-3">
        @csrf
        @method('PUT')

        <div class="space-y-6 lg:col-span-2">
            <x-admin.panel class="space-y-5">
                <x-admin.input
                    name="titulo"
                    label="Título do Evento"
                    :value="$evento->titulo"
                    required="true"
                    class="px-4 py-2.5 bg-slate-50 border-slate-200 rounded-lg focus:bg-white focus:border-blue-500 outline-none transition-all"
                />

                <x-admin.input
                    name="local"
                    label="Localização"
                    :value="$evento->local"
                    class="px-4 py-2.5 bg-slate-50 border-slate-200 rounded-lg focus:bg-white focus:border-blue-500 outline-none transition-all"
                />

                <x-admin.rich-editor
                    name="descricao"
                    label="Descrição Detalhada"
                    :value="$evento->descricao"
                    rows="6"
                    id="editor"
                />
            </x-admin.panel>
        </div>

        <div class="space-y-6">
            
            <x-admin.panel title="Agendamento" class="space-y-5">
                <x-admin.input
                    type="datetime-local"
                    name="data_inicio"
                    label="Início"
                    :value="\Carbon\Carbon::parse($evento->data_inicio)->format('Y-m-d\TH:i')"
                    required="true"
                    class="px-4 py-2.5 bg-slate-50 border-slate-200 rounded-lg focus:bg-white outline-none"
                />

                <x-admin.input
                    type="datetime-local"
                    name="data_fim"
                    label="Fim"
                    :value="$evento->data_fim ? \Carbon\Carbon::parse($evento->data_fim)->format('Y-m-d\TH:i') : ''"
                    class="px-4 py-2.5 bg-slate-50 border-slate-200 rounded-lg focus:bg-white outline-none"
                />

                <x-admin.select
                    name="status"
                    label="Status do Evento"
                    :options="$statusOptions"
                    :value="$evento->status"
                    class="bg-slate-50 border-slate-200 focus:bg-white outline-none"
                />

                <p class="text-xs text-slate-500">
                    Para adiar um evento, atualize as datas de início/fim e mantenha o status como <strong>Confirmado</strong>.
                </p>
            </x-admin.panel>

            <x-admin.panel title="Mídia">
                <x-admin.file-upload
                    name="imagem"
                    id="evento-imagem"
                    label="Imagem de Divulgação"
                    accept="image/*"
                    help-text="PNG, JPG, GIF até 2MB"
                    :preview-src="$evento->imagem ? asset('storage/' . $evento->imagem) : null"
                />
            </x-admin.panel>

            <x-admin.button color="amber" class="w-full inline-flex items-center justify-center gap-2 px-6 py-3.5 rounded-xl shadow-md">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path></svg>
                Atualizar Evento
            </x-admin.button>

        </div>
    </form>
</div>

@endsection