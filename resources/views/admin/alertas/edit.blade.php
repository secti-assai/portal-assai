@extends('layouts.admin')

@section('content')
<div class="flex flex-col max-w-4xl gap-6 mx-auto">

    <x-admin.page-header
        title="Editar Alerta"
        :breadcrumbs="[
            ['label' => 'Dashboard', 'url' => route('admin.dashboard'), 'class' => 'hover:text-red-600'],
            ['label' => 'Alertas', 'url' => route('admin.alertas.index'), 'class' => 'hover:text-red-600'],
            ['label' => 'Editar'],
        ]"
    >
        <x-slot:action>
            <a href="{{ route('admin.alertas.index') }}" class="px-4 py-2 text-sm font-bold transition bg-white border rounded-lg text-slate-600 border-slate-300 hover:bg-slate-50 shadow-sm">
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

    <form action="{{ route('admin.alertas.update', $alerta->id) }}" method="POST" class="space-y-6">
        @csrf
        @method('PUT')

        <div class="p-6 space-y-6 bg-white border shadow-sm border-slate-200 rounded-xl">
            
            <div class="grid grid-cols-1 gap-6 md:grid-cols-2">
                <div class="md:col-span-2">
                    <label class="block mb-1.5 text-sm font-bold text-slate-700">Título Breve <span class="text-red-500">*</span></label>
                    <input type="text" name="titulo" value="{{ old('titulo', $alerta->titulo) }}" required class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-lg focus:bg-white focus:ring-2 focus:ring-red-500 focus:border-red-500 outline-none transition-all">
                </div>

                <div class="md:col-span-2">
                    <label class="block mb-1.5 text-sm font-bold text-slate-700">Mensagem Completa <span class="text-red-500">*</span></label>
                    <textarea name="mensagem" rows="3" required class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-lg focus:bg-white focus:ring-2 focus:ring-red-500 focus:border-red-500 outline-none transition-all resize-none">{{ old('mensagem', $alerta->mensagem) }}</textarea>
                </div>

                <div class="md:col-span-2">
                    <label class="block mb-1.5 text-sm font-bold text-slate-700">Link para mais informações <span class="text-xs font-normal text-slate-400">(Opcional)</span></label>
                    <input type="url" name="link" value="{{ old('link', $alerta->link) }}" placeholder="https://..." class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-lg focus:bg-white focus:ring-2 focus:ring-red-500 focus:border-red-500 outline-none transition-all">
                </div>

                <div class="md:col-span-2 mt-2">
                    <label class="flex items-center gap-3 p-4 transition border cursor-pointer {{ old('ativo', $alerta->ativo) ? 'border-red-200 bg-red-50/50' : 'border-slate-200 bg-slate-50' }} rounded-xl hover:bg-red-50 w-full" id="alerta-status-container">
                        <input type="checkbox" name="ativo" value="1" {{ old('ativo', $alerta->ativo) ? 'checked' : '' }} class="w-5 h-5 border-gray-300 rounded text-red-600 focus:ring-red-500" onchange="document.getElementById('alerta-status-container').className = this.checked ? 'flex items-center gap-3 p-4 transition border cursor-pointer border-red-200 bg-red-50/50 rounded-xl hover:bg-red-50 w-full' : 'flex items-center gap-3 p-4 transition border cursor-pointer border-slate-200 bg-slate-50 rounded-xl hover:bg-slate-100 w-full'">
                        <div>
                            <span class="block text-sm font-bold text-slate-800">Alerta Ativo no portal</span>
                            <span class="block text-xs text-slate-500">Desmarque para esconder temporariamente sem excluir.</span>
                        </div>
                    </label>
                </div>
            </div>

        </div>

        <div class="flex justify-end">
            <button type="submit" class="flex items-center gap-2 px-8 py-3 font-bold text-white transition rounded-xl bg-amber-500 hover:bg-amber-600 shadow-md">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path></svg>
                Atualizar Alerta
            </button>
        </div>
    </form>
</div>
@endsection
