@extends('layouts.admin')

@section('content')
<div class="flex flex-col max-w-4xl gap-6 mx-auto">

    <x-admin.page-header
        title="Criar Novo Concurso"
        :breadcrumbs="[
            ['label' => 'Dashboard', 'url' => route('admin.dashboard'), 'class' => 'hover:text-blue-600'],
            ['label' => 'Concursos', 'url' => route('admin.concursos.index'), 'class' => 'hover:text-blue-600'],
            ['label' => 'Novo'],
        ]"
    >
        <x-slot:action>
            <a href="{{ route('admin.concursos.index') }}" class="px-4 py-2 text-sm font-bold transition bg-white border rounded-lg text-slate-600 border-slate-300 hover:bg-slate-50 shadow-sm">
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

    <form action="{{ route('admin.concursos.store') }}" method="POST" class="space-y-6">
        @csrf

        <div class="p-6 space-y-6 bg-white border shadow-sm border-slate-200 rounded-xl">
            
            <div class="grid grid-cols-1 gap-6">
                <div>
                    <label class="block mb-1.5 text-sm font-bold text-slate-700">Título do Concurso <span class="text-red-500">*</span></label>
                    <input type="text" name="titulo" value="{{ old('titulo') }}" required placeholder="Ex: Concurso Público 01/2025" class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-lg focus:bg-white focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none transition-all">
                </div>

                <div>
                    <label class="block mb-1.5 text-sm font-bold text-slate-700">Descrição Breve <span class="text-red-500">*</span></label>
                    <textarea name="descricao" rows="4" required placeholder="Descreva os cargos e informações principais..." class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-lg focus:bg-white focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none transition-all">{{ old('descricao') }}</textarea>
                </div>

                <div>
                    <label class="block mb-1.5 text-sm font-bold text-slate-700">Link para Edital / Inscrição <span class="text-xs font-normal text-slate-400">(Opcional)</span></label>
                    <input type="url" name="link" value="{{ old('link') }}" placeholder="https://..." class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-lg focus:bg-white focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none transition-all">
                    <p class="mt-1 text-xs text-slate-400">URL externa onde o edital está hospedado ou onde são feitas as inscrições.</p>
                </div>

                <div class="flex items-center">
                    <label class="flex items-center gap-3 p-3 transition border cursor-pointer border-slate-200 rounded-xl hover:bg-slate-50 w-full">
                        <input type="checkbox" name="ativo" value="1" {{ old('ativo', '1') == '1' ? 'checked' : '' }} class="w-5 h-5 border-gray-300 rounded text-blue-600 focus:ring-blue-500">
                        <div>
                            <span class="block text-sm font-bold text-slate-700">Concurso Ativo</span>
                            <span class="block text-xs text-slate-500">Visível para o público no portal.</span>
                        </div>
                    </label>
                </div>
            </div>

        </div>

        <div class="flex justify-end">
            <button type="submit" class="flex items-center gap-2 px-8 py-3 font-bold text-white transition rounded-xl bg-blue-600 hover:bg-blue-700 shadow-md">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                Salvar Concurso
            </button>
        </div>
    </form>
</div>
@endsection
