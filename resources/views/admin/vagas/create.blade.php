@extends('layouts.admin')
@section('title', 'Nova Oportunidade - Painel Admin')

@section('content')
<div class="flex flex-col max-w-4xl gap-6 mx-auto">

    @php
        $breadcrumbsCreate = [
            ['label' => 'Dashboard', 'url' => route('admin.dashboard'), 'class' => 'hover:text-blue-600'],
            ['label' => 'Oportunidades', 'url' => route('admin.vagas.index'), 'class' => 'hover:text-blue-600'],
            ['label' => 'Nova'],
        ];
    @endphp
    <x-admin.page-header title="Nova Oportunidade" :breadcrumbs="$breadcrumbsCreate">
        <x-slot:action>
            <a href="{{ route('admin.vagas.index') }}" class="px-4 py-2 text-sm font-bold transition bg-white border rounded-lg text-slate-600 border-slate-300 hover:bg-slate-50 shadow-sm">
                Voltar
            </a>
        </x-slot:action>
    </x-admin.page-header>

    @if($errors->any())
        <div class="p-4 font-medium text-red-700 border border-red-200 bg-red-50 rounded-xl">
            <ul class="text-sm list-disc list-inside space-y-1">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('admin.vagas.store') }}" method="POST" class="space-y-6">
        @csrf

        <div class="p-6 space-y-6 bg-white border shadow-sm border-slate-200 rounded-xl">
            <div class="grid grid-cols-1 gap-6 md:grid-cols-2">

                <div class="md:col-span-2">
                    <label for="titulo" class="block mb-1.5 text-sm font-bold text-slate-700">Título da Oportunidade <span class="text-red-500">*</span></label>
                    <input id="titulo" type="text" name="titulo" value="{{ old('titulo') }}" required
                        placeholder="Ex: Auxiliar de Serviços Gerais, Eletricista Autônomo..."
                        class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-lg focus:bg-white focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none transition-all @error('titulo') border-red-400 bg-red-50 @enderror">
                    @error('titulo')<p class="mt-1 text-xs text-red-600">{{ $message }}</p>@enderror
                </div>

                <div>
                    <label for="tipo" class="block mb-1.5 text-sm font-bold text-slate-700">Categoria <span class="text-red-500">*</span></label>
                    <select id="tipo" name="tipo" required
                        class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-lg focus:bg-white focus:ring-2 focus:ring-blue-500 outline-none transition-all @error('tipo') border-red-400 bg-red-50 @enderror">
                        <option value="" disabled {{ old('tipo') ? '' : 'selected' }}>Selecione a categoria</option>
                        <option value="formal" {{ old('tipo') == 'formal' ? 'selected' : '' }}>Vaga Formal (Prefeitura / Empresas)</option>
                        <option value="informal" {{ old('tipo') == 'informal' ? 'selected' : '' }}>Trabalho Informal (Bicos / Autônomos)</option>
                    </select>
                    @error('tipo')<p class="mt-1 text-xs text-red-600">{{ $message }}</p>@enderror
                </div>

                <div>
                    <label for="setor_ou_contato" class="block mb-1.5 text-sm font-bold text-slate-700">Setor ou Contato <span class="text-red-500">*</span></label>
                    <input id="setor_ou_contato" type="text" name="setor_ou_contato" value="{{ old('setor_ou_contato') }}" required
                        placeholder="Ex: Secretaria de Trabalho, (99) 9999-9999..."
                        class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-lg focus:bg-white focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none transition-all @error('setor_ou_contato') border-red-400 bg-red-50 @enderror">
                    @error('setor_ou_contato')<p class="mt-1 text-xs text-red-600">{{ $message }}</p>@enderror
                </div>

                <div>
                    <label for="data_limite" class="block mb-1.5 text-sm font-bold text-slate-700">Data Limite <span class="text-xs font-normal text-slate-400">(Opcional)</span></label>
                    <input id="data_limite" type="date" name="data_limite" value="{{ old('data_limite') }}"
                        class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-lg focus:bg-white focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none transition-all">
                    @error('data_limite')<p class="mt-1 text-xs text-red-600">{{ $message }}</p>@enderror
                </div>

                <div>
                    <label for="link_acao" class="block mb-1.5 text-sm font-bold text-slate-700">Link de Ação <span class="text-xs font-normal text-slate-400">(Opcional)</span></label>
                    <input id="link_acao" type="text" name="link_acao" value="{{ old('link_acao') }}"
                        placeholder="Ex: https://wa.me/... ou URL de inscrição"
                        class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-lg focus:bg-white focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none transition-all">
                    <p class="mt-1 text-xs text-slate-400">Aceita links de WhatsApp (wa.me) ou qualquer URL de inscrição.</p>
                    @error('link_acao')<p class="mt-1 text-xs text-red-600">{{ $message }}</p>@enderror
                </div>

                <div class="md:col-span-2">
                    <label for="descricao" class="block mb-1.5 text-sm font-bold text-slate-700">Descrição Detalhada <span class="text-xs font-normal text-slate-400">(Opcional)</span></label>
                    <textarea id="descricao" name="descricao" rows="4"
                        placeholder="Requisitos, benefícios, horários, local de trabalho..."
                        class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-lg focus:bg-white focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none transition-all resize-none @error('descricao') border-red-400 bg-red-50 @enderror">{{ old('descricao') }}</textarea>
                    @error('descricao')<p class="mt-1 text-xs text-red-600">{{ $message }}</p>@enderror
                </div>

                <div class="md:col-span-2">
                    <label class="flex items-center gap-3 p-3 transition border cursor-pointer border-slate-200 rounded-xl hover:bg-slate-50 w-full">
                        <input type="checkbox" name="status" value="1" {{ old('status', true) ? 'checked' : '' }}
                            class="w-5 h-5 border-gray-300 rounded text-blue-600 focus:ring-blue-500">
                        <div>
                            <span class="block text-sm font-bold text-slate-700">Oportunidade Ativa</span>
                            <span class="block text-xs text-slate-500">Exibir esta oportunidade publicamente no portal.</span>
                        </div>
                    </label>
                </div>

            </div>
        </div>

        <div class="flex items-center gap-4">
            <button type="submit" class="inline-flex items-center gap-2 px-6 py-2.5 text-sm font-bold text-white transition bg-blue-700 rounded-xl hover:bg-blue-800 shadow-md">
                <i class="fa-solid fa-plus"></i>
                Cadastrar Oportunidade
            </button>
            <a href="{{ route('admin.vagas.index') }}" class="text-sm font-medium text-slate-500 hover:text-slate-800 transition-colors">Cancelar</a>
        </div>
    </form>

</div>
@endsection
