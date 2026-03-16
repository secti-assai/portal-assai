@extends('layouts.admin')

@section('content')
<div class="flex flex-col max-w-4xl gap-6 mx-auto">

    <x-admin.page-header
        title="Criar Novo Alerta"
        :breadcrumbs="[
            ['label' => 'Dashboard', 'url' => route('admin.dashboard'), 'class' => 'hover:text-red-600'],
            ['label' => 'Alertas', 'url' => route('admin.alertas.index'), 'class' => 'hover:text-red-600'],
            ['label' => 'Novo'],
        ]"
    >
        <x-slot:action>
            <a href="{{ route('admin.alertas.index') }}" class="px-4 py-2 text-sm font-bold transition bg-white border rounded-lg text-slate-600 border-slate-300 hover:bg-slate-50 shadow-sm">
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

    <form action="{{ route('admin.alertas.store') }}" method="POST" class="space-y-6">
        @csrf

        <div class="p-6 space-y-6 bg-white border shadow-sm border-slate-200 rounded-xl">
            
            <div class="p-4 mb-2 bg-red-50 border border-red-100 rounded-lg flex gap-3 text-red-800 text-sm">
                <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                <p>Os alertas ativos serão exibidos em uma barra vermelha de destaque no topo de todas as páginas do portal. Use com moderação para comunicados urgentes (ex: Campanhas de Vacinação, Alertas Climáticos, Interrupção de Serviços).</p>
            </div>

            <div class="grid grid-cols-1 gap-6 md:grid-cols-2">
                <div class="md:col-span-2">
                    <label class="block mb-1.5 text-sm font-bold text-slate-700">Título Breve <span class="text-red-500">*</span></label>
                    <input type="text" name="titulo" value="{{ old('titulo') }}" required placeholder="Ex: Campanha de Vacinação Contra a Gripe" class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-lg focus:bg-white focus:ring-2 focus:ring-red-500 focus:border-red-500 outline-none transition-all">
                </div>

                <div class="md:col-span-2">
                    <label class="block mb-1.5 text-sm font-bold text-slate-700">Mensagem Completa <span class="text-red-500">*</span></label>
                    <textarea name="mensagem" rows="3" required placeholder="Detalhe a informação de forma clara e direta..." class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-lg focus:bg-white focus:ring-2 focus:ring-red-500 focus:border-red-500 outline-none transition-all resize-none">{{ old('mensagem') }}</textarea>
                </div>

                <div class="md:col-span-2">
                    <label class="block mb-1.5 text-sm font-bold text-slate-700">Link para mais informações <span class="text-xs font-normal text-slate-400">(Opcional)</span></label>
                    <input type="url" name="link" value="{{ old('link') }}" placeholder="https://..." class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-lg focus:bg-white focus:ring-2 focus:ring-red-500 focus:border-red-500 outline-none transition-all">
                </div>

                <div class="md:col-span-2 mt-2">
                    <label class="flex items-center gap-3 p-4 transition border cursor-pointer border-red-200 bg-red-50/50 rounded-xl hover:bg-red-50 w-full">
                        <input type="checkbox" name="ativo" value="1" {{ old('ativo', '1') == '1' ? 'checked' : '' }} class="w-5 h-5 border-gray-300 rounded text-red-600 focus:ring-red-500">
                        <div>
                            <span class="block text-sm font-bold text-red-900">Ativar alerta imediatamente</span>
                            <span class="block text-xs text-red-700/70">O alerta aparecerá no site assim que for salvo.</span>
                        </div>
                    </label>
                </div>
            </div>

        </div>

        <div class="flex justify-end">
            <button type="submit" class="flex items-center gap-2 px-8 py-3 font-bold text-white transition rounded-xl bg-red-600 hover:bg-red-700 shadow-md">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                Publicar Alerta
            </button>
        </div>
    </form>
</div>
@endsection