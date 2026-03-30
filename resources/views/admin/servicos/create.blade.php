@extends('layouts.admin')

@section('content')
<div class="flex flex-col max-w-4xl gap-6 mx-auto">

    <x-admin.page-header
        title="Criar Novo Serviço"
        :breadcrumbs="[
            ['label' => 'Dashboard', 'url' => route('admin.dashboard'), 'class' => 'hover:text-orange-600'],
            ['label' => 'Serviços', 'url' => route('admin.servicos.index'), 'class' => 'hover:text-orange-600'],
            ['label' => 'Novo'],
        ]"
    >
        <x-slot:action>
            <a href="{{ route('admin.servicos.index') }}" class="px-4 py-2 text-sm font-bold transition bg-white border rounded-lg text-slate-600 border-slate-300 hover:bg-slate-50 shadow-sm">
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

    <form action="{{ route('admin.servicos.store') }}" method="POST" class="space-y-6">
        @csrf

        <div class="p-6 space-y-6 bg-white border shadow-sm border-slate-200 rounded-xl">
            
            <div class="grid grid-cols-1 gap-6 md:grid-cols-2">
                <div class="md:col-span-2">
                    <label class="block mb-1.5 text-sm font-bold text-slate-700">Título do Serviço <span class="text-red-500">*</span></label>
                    <input type="text" name="titulo" value="{{ old('titulo') }}" required placeholder="Ex: Emissão de Alvará" class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-lg focus:bg-white focus:ring-2 focus:ring-orange-500 focus:border-orange-500 outline-none transition-all">
                </div>

                {{-- NOVO CAMPO: Descrição --}}
                <div class="md:col-span-2">
                    <label class="block mb-1.5 text-sm font-bold text-slate-700">Descrição / Subtítulo <span class="text-xs font-normal text-slate-400">(Opcional)</span></label>
                    <textarea name="descricao" rows="2" maxlength="150" placeholder="Breve resumo do serviço..." class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-lg focus:bg-white focus:ring-2 focus:ring-orange-500 focus:border-orange-500 outline-none transition-all resize-none">{{ old('descricao') }}</textarea>
                    <p class="mt-1 text-xs text-slate-400">Recomendamos até 80 caracteres para que o texto não fique cortado na página inicial.</p>
                </div>

                <div class="md:col-span-2">
                    <label class="block mb-1.5 text-sm font-bold text-slate-700">URL de Acesso Direto (Conecta, Gov.br, etc.) <span class="text-red-500">*</span></label>
                    <input type="url" name="url_acesso" value="{{ old('url_acesso') }}" required placeholder="https://conecta.assai.pr.gov.br/..." class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-lg focus:bg-white focus:ring-2 focus:ring-orange-500 focus:border-orange-500 outline-none transition-all">
                    <p class="mt-1 text-xs text-slate-400">O cidadão será redirecionado diretamente para esta URL ao clicar no cartão.</p>
                </div>

                <div class="md:col-span-2">
                    <label class="block mb-1.5 text-sm font-bold text-slate-700">Órgão / Secretaria Vinculada <span class="text-xs font-normal text-slate-400">(Opcional)</span></label>
                    <select name="secretaria_id" class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-lg focus:bg-white focus:ring-2 focus:ring-orange-500 outline-none transition-all">
                        <option value="">Serviço Geral (Sem vínculo específico)</option>
                        @foreach($secretarias as $sec)
                            <option value="{{ $sec->id }}" {{ old('secretaria_id') == $sec->id ? 'selected' : '' }}>{{ $sec->nome }}</option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label class="block mb-1.5 text-sm font-bold text-slate-700">Ícone Representativo <span class="text-red-500">*</span></label>
                    <select name="icone" required class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-lg focus:bg-white focus:ring-2 focus:ring-orange-500 focus:border-orange-500 outline-none transition-all">
                        <option value="padrao" {{ old('icone') == 'padrao' ? 'selected' : '' }}>Padrão (Genérico)</option>
                        <option value="saude" {{ old('icone') == 'saude' ? 'selected' : '' }}>Saúde (Coração/Cruz)</option>
                        <option value="vagas" {{ old('icone') == 'vagas' ? 'selected' : '' }}>Vagas/Emprego (Maleta)</option>
                        <option value="documentos" {{ old('icone') == 'documentos' ? 'selected' : '' }}>Documentos/Notas (Papel)</option>
                        <option value="ouvidoria" {{ old('icone') == 'ouvidoria' ? 'selected' : '' }}>Ouvidoria (Megafone/Chat)</option>
                        <option value="alvara" {{ old('icone') == 'alvara' ? 'selected' : '' }}>Alvará/Empresa (Prédio)</option>
                        <option value="educacao" {{ old('icone') == 'educacao' ? 'selected' : '' }}>Educação (Capelo/Livro)</option>
                    </select>
                </div>

                <div class="flex items-center md:mt-7">
                    <label class="flex items-center gap-3 p-3 transition border cursor-pointer border-slate-200 rounded-xl hover:bg-slate-50 w-full">
                        <input type="checkbox" name="ativo" value="1" {{ old('ativo', '1') == '1' ? 'checked' : '' }} class="w-5 h-5 border-gray-300 rounded text-orange-600 focus:ring-orange-500">
                        <div>
                            <span class="block text-sm font-bold text-slate-700">Serviço Ativo</span>
                            <span class="block text-xs text-slate-500">Visível no catálogo do portal.</span>
                        </div>
                    </label>
                </div>
            </div>

        </div>

        <div class="flex justify-end">
            <button type="submit" class="flex items-center gap-2 px-8 py-3 font-bold text-white transition rounded-xl bg-orange-500 hover:bg-orange-600 shadow-md">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                Salvar Serviço
            </button>
        </div>
    </form>
</div>
@endsection