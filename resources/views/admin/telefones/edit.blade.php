@extends('layouts.admin')

@section('content')
<div class="flex flex-col max-w-4xl gap-6 mx-auto">

    <x-admin.page-header
        title="Editar Telefone"
        :breadcrumbs="[
            ['label' => 'Dashboard', 'url' => route('admin.dashboard'), 'class' => 'hover:text-emerald-600'],
            ['label' => 'Telefones', 'url' => route('admin.telefones.index'), 'class' => 'hover:text-emerald-600'],
            ['label' => 'Editar'],
        ]"
    >
        <x-slot:action>
            <a href="{{ route('admin.telefones.index') }}" class="px-4 py-2 text-sm font-bold transition bg-white border rounded-lg text-slate-600 border-slate-300 hover:bg-slate-50 shadow-sm">
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

    <form action="{{ route('admin.telefones.update', $telefone->id) }}" method="POST" class="space-y-6">
        @csrf
        @method('PUT')

        <div class="p-6 space-y-6 bg-white border shadow-sm border-slate-200 rounded-xl">
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div class="md:col-span-2">
                    <label class="block mb-1.5 text-sm font-bold text-slate-700">Nome / Identificação <span class="text-red-500">*</span></label>
                    <input type="text" name="nome" value="{{ old('nome', $telefone->nome) }}" required placeholder="Ex: Recepção da Prefeitura" class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-lg focus:bg-white focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 outline-none transition-all">
                </div>

                <div>
                    <label class="block mb-1.5 text-sm font-bold text-slate-700">Número do Telefone <span class="text-red-500">*</span></label>
                    <input type="text" name="numero" value="{{ old('numero', $telefone->numero) }}" required placeholder="(43) 3262-XXXX" class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-lg focus:bg-white focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 outline-none transition-all">
                </div>

                <div>
                    <label class="block mb-1.5 text-sm font-bold text-slate-700">Secretaria Vinculada <span class="text-xs font-normal text-slate-400">(Opcional)</span></label>
                    <select name="secretaria_id" class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-lg focus:bg-white focus:ring-2 focus:ring-emerald-500 outline-none transition-all">
                        <option value="">Nenhuma (Telefone Geral/Emergência)</option>
                        @foreach($secretarias as $sec)
                            <option value="{{ $sec->id }}" {{ old('secretaria_id', $telefone->secretaria_id) == $sec->id ? 'selected' : '' }}>{{ $sec->nome }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="md:col-span-2">
                    <label class="flex items-center gap-3 p-3 transition border cursor-pointer border-slate-200 rounded-xl hover:bg-slate-50 w-full">
                        <input type="checkbox" name="ativo" value="1" {{ old('ativo', $telefone->ativo) ? 'checked' : '' }} class="w-5 h-5 border-gray-300 rounded text-emerald-600 focus:ring-emerald-500">
                        <div>
                            <span class="block text-sm font-bold text-slate-700">Telefone Ativo</span>
                            <span class="block text-xs text-slate-500">Visível no portal para os cidadãos.</span>
                        </div>
                    </label>
                </div>
            </div>

        </div>

        <div class="flex justify-end">
            <button type="submit" class="flex items-center gap-2 px-8 py-3 font-bold text-white transition rounded-xl bg-emerald-600 hover:bg-emerald-700 shadow-md">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                Atualizar Telefone
            </button>
        </div>
    </form>
</div>
@endsection
