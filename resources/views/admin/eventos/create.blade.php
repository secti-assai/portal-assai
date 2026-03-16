@extends('layouts.admin')

@section('content')
@php
    $statusOptions = [
        'confirmado' => '✅ Confirmado / Agendado',
        'adiado' => '⚠️ Adiado',
        'cancelado' => '❌ Cancelado',
    ];
@endphp

<div class="flex flex-col max-w-6xl gap-6 mx-auto">

    <x-admin.page-header
        title="Criar Novo Evento"
        :breadcrumbs="[
            ['label' => 'Dashboard', 'url' => route('admin.dashboard'), 'class' => 'hover:text-blue-600'],
            ['label' => 'Agenda', 'url' => route('admin.eventos.index'), 'class' => 'hover:text-blue-600'],
            ['label' => 'Novo Evento'],
        ]"
    >
        <x-slot:action>
            <a href="{{ route('admin.eventos.index') }}" class="px-4 py-2 text-sm font-bold transition bg-white border rounded-lg text-slate-600 border-slate-300 hover:bg-slate-50 shadow-sm">
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

    <form action="{{ route('admin.eventos.store') }}" method="POST" enctype="multipart/form-data" class="grid grid-cols-1 gap-8 lg:grid-cols-3">
        @csrf

        {{-- Coluna Principal --}}
        <div class="space-y-6 lg:col-span-2">
            <x-admin.panel class="space-y-5">
                <x-admin.input
                    name="titulo"
                    label="Título do Evento"
                    required="true"
                    class="px-4 py-2.5 bg-slate-50 border-slate-200 rounded-lg focus:bg-white focus:border-blue-500 outline-none transition-all"
                />

                <x-admin.input
                    name="local"
                    label="Localização"
                    placeholder="Ex: Praça Central"
                    class="px-4 py-2.5 bg-slate-50 border-slate-200 rounded-lg focus:bg-white focus:border-blue-500 outline-none transition-all"
                />

                <x-admin.rich-editor
                    name="descricao"
                    label="Descrição Detalhada"
                    rows="6"
                    id="editor"
                />
            </x-admin.panel>
        </div>

        {{-- Coluna Lateral (Datas e Mídia) --}}
        <div class="space-y-6">
            
            <x-admin.panel title="Agendamento" class="space-y-5">
                <x-admin.input
                    type="datetime-local"
                    name="data_inicio"
                    label="Início"
                    required="true"
                    class="px-4 py-2.5 bg-slate-50 border-slate-200 rounded-lg focus:bg-white outline-none"
                />

                <x-admin.input
                    type="datetime-local"
                    name="data_fim"
                    label="Fim"
                    class="px-4 py-2.5 bg-slate-50 border-slate-200 rounded-lg focus:bg-white outline-none"
                />

                <x-admin.select
                    name="status"
                    label="Status do Evento"
                    :options="$statusOptions"
                    value="confirmado"
                    class="bg-slate-50 border-slate-200 focus:bg-white outline-none"
                />
            </x-admin.panel>

            <x-admin.panel title="Mídia">
                <x-admin.file-upload
                    name="imagem"
                    id="evento-imagem"
                    label="Imagem de Divulgação"
                    accept="image/*"
                    help-text="PNG, JPG, GIF até 2MB"
                />
            </x-admin.panel>

            <x-admin.button color="amber" class="w-full inline-flex items-center justify-center gap-2 px-6 py-3.5 rounded-xl shadow-md">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                Agendar Evento
            </x-admin.button>

        </div>
    </form>
</div>

@endsection