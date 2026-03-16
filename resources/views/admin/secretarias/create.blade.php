@extends('layouts.admin')

@section('content')
<div class="flex flex-col max-w-6xl gap-6 mx-auto">

    <x-admin.page-header
        title="Cadastrar Secretaria"
        :breadcrumbs="[
            ['label' => 'Dashboard', 'url' => route('admin.dashboard'), 'class' => 'hover:text-teal-600'],
            ['label' => 'Secretarias', 'url' => route('admin.secretarias.index'), 'class' => 'hover:text-teal-600'],
            ['label' => 'Nova'],
        ]"
    >
        <x-slot:action>
            <a href="{{ route('admin.secretarias.index') }}" class="px-4 py-2 text-sm font-bold transition bg-white border rounded-lg text-slate-600 border-slate-300 hover:bg-slate-50 shadow-sm">
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

    <form action="{{ route('admin.secretarias.store') }}" method="POST" enctype="multipart/form-data" class="grid grid-cols-1 gap-8 lg:grid-cols-3">
        @csrf

        {{-- Coluna Principal (Identificação e Competências) --}}
        <div class="space-y-6 lg:col-span-2">
            <div class="p-6 space-y-5 bg-white border shadow-sm border-slate-200 rounded-xl">
                
                <div>
                    <label class="block mb-1.5 text-sm font-bold text-slate-700">Nome do Órgão / Secretaria <span class="text-red-500">*</span></label>
                    <input type="text" name="nome" value="{{ old('nome') }}" required placeholder="Ex: Secretaria Municipal de Saúde" class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-lg focus:bg-white focus:ring-2 focus:ring-teal-500 focus:border-teal-500 outline-none transition-all">
                </div>

                <x-admin.rich-editor
                    name="descricao"
                    id="editor"
                    label="Competências e Atribuições"
                    rows="10"
                />

            </div>
        </div>

        {{-- Coluna Lateral (Titular e Contatos Institucionais) --}}
        <div class="space-y-6">
            
            <div class="p-6 space-y-5 bg-white border shadow-sm border-slate-200 rounded-xl">
                <h3 class="pb-3 mb-2 font-bold border-b text-slate-800 border-slate-100">Dados do Titular</h3>

                {{-- Preview circular da foto --}}
                <div class="flex flex-col items-center gap-3">
                    <label for="foto-input" class="relative group cursor-pointer" title="Clique para enviar foto">
                        <img id="foto-preview"
                             src="https://ui-avatars.com/api/?name=Foto&background=e2e8f0&color=94a3b8&size=96"
                             alt="Preview"
                             class="object-cover w-24 h-24 rounded-full border-2 border-slate-200 shadow-sm bg-slate-100 transition group-hover:brightness-75">
                        <div class="absolute inset-0 flex items-center justify-center rounded-full opacity-0 group-hover:opacity-100 transition">
                            <svg class="w-6 h-6 text-white drop-shadow" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 16.5V19a1 1 0 001 1h16a1 1 0 001-1v-2.5M12 3v12m0 0l-3.5-3.5M12 15l3.5-3.5"/>
                            </svg>
                        </div>
                    </label>
                    <input id="foto-input" type="file" name="foto" accept="image/*" class="hidden"
                           onchange="previewFoto(this)">
                    <p class="text-xs text-slate-400">JPG ou PNG &bull; máx. 2 MB</p>
                </div>

                <div>
                    <label class="block mb-1.5 text-sm font-bold text-slate-700">Nome do(a) Secretário(a) <span class="text-red-500">*</span></label>
                    <input type="text" name="nome_secretario" value="{{ old('nome_secretario') }}" required class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-lg focus:bg-white focus:ring-2 focus:ring-teal-500 outline-none">
                </div>
            </div>

            <div class="p-6 space-y-5 bg-white border shadow-sm border-slate-200 rounded-xl">
                <h3 class="pb-3 mb-2 font-bold border-b text-slate-800 border-slate-100">Atendimento ao Cidadão</h3>
                
                <div>
                    <label class="block mb-1.5 text-sm font-bold text-slate-700">Endereço Físico</label>
                    <input type="text" name="endereco" value="{{ old('endereco') }}" placeholder="Ex: Av. Principal, 123 - Centro" class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-lg focus:bg-white focus:ring-2 focus:ring-teal-500 outline-none">
                </div>

                <div>
                    <label class="block mb-1.5 text-sm font-bold text-slate-700">Horário de Funcionamento</label>
                    <input type="text" name="horario_atendimento" value="{{ old('horario_atendimento') }}" placeholder="Ex: Seg a Sex, das 08h às 17h" class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-lg focus:bg-white focus:ring-2 focus:ring-teal-500 outline-none">
                </div>

                <div>
                    <label class="block mb-1.5 text-sm font-bold text-slate-700">Telefone Institucional</label>
                    <input type="text" name="telefone" value="{{ old('telefone') }}" placeholder="(00) 0000-0000" class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-lg focus:bg-white focus:ring-2 focus:ring-teal-500 outline-none">
                </div>

                <div>
                    <label class="block mb-1.5 text-sm font-bold text-slate-700">E-mail Institucional</label>
                    <input type="email" name="email" value="{{ old('email') }}" placeholder="contato@assai.pr.gov.br" class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-lg focus:bg-white focus:ring-2 focus:ring-teal-500 outline-none">
                </div>
            </div>

            <button type="submit" class="flex items-center justify-center w-full gap-2 px-6 py-3.5 font-bold text-white transition rounded-xl bg-teal-600 hover:bg-teal-700 shadow-md">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                Salvar Secretaria
            </button>

        </div>
    </form>
</div>

@endsection