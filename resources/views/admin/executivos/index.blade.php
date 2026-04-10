@extends('layouts.admin')

@section('title', 'Gestão Executiva')

@section('content')
<div class="container px-6 mx-auto grid">
    <div class="flex items-center justify-between my-6">
        <h2 class="text-2xl font-bold text-slate-800">
            Gestão Executiva
        </h2>
    </div>

    {{-- Alerta de Sucesso --}}
    @if(session('sucesso'))
        <div class="p-4 mb-6 text-sm font-medium text-green-800 bg-green-100 border border-green-200 rounded-xl">
            <i class="fa-solid fa-check-circle mr-2"></i> {{ session('sucesso') }}
        </div>
    @endif

    {{-- Grid com os dois formulários lado a lado (no desktop) --}}
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 mb-8">
        
        {{-- ================= FORMULÁRIO PREFEITO ================= --}}
        @if($prefeito)
        <div class="p-6 md:p-8 bg-white border rounded-2xl shadow-sm border-slate-200 flex flex-col h-full">
            <div class="flex items-center gap-3 mb-6 pb-4 border-b border-slate-100">
                <div class="w-10 h-10 rounded-full bg-yellow-100 text-yellow-700 flex items-center justify-center shrink-0">
                    <i class="fa-solid fa-star"></i>
                </div>
                <div>
                    <h3 class="text-lg font-bold text-slate-800">Prefeito Municipal</h3>
                    <p class="text-xs text-slate-500">Altere o nome ou a foto oficial.</p>
                </div>
            </div>

            <form action="{{ route('admin.executivos.update', $prefeito->id) }}" method="POST" enctype="multipart/form-data" class="flex flex-col flex-1">
                @csrf
                @method('PUT')

                <div class="mb-5">
                    <label class="block mb-2 text-sm font-bold text-slate-700">Nome <span class="text-red-500">*</span></label>
                    <input type="text" name="nome" value="{{ old('nome', $prefeito->nome) }}" required
                        class="w-full px-4 py-3 text-sm transition-colors border rounded-xl bg-slate-50 border-slate-200 focus:bg-white focus:border-blue-500 focus:ring-4 focus:ring-blue-500/10" />
                </div>

                <div class="mb-6 flex-1">
                    <label class="block mb-3 text-sm font-bold text-slate-700">Fotografia Oficial</label>
                    @if($prefeito->foto)
                        <img src="{{ asset('storage/' . $prefeito->foto) }}" alt="Foto do Prefeito" class="object-cover w-24 h-24 mb-4 border shadow-sm rounded-xl border-slate-200">
                    @endif
                    <input type="file" name="foto" accept="image/jpeg, image/png, image/webp"
                        class="block w-full text-sm text-slate-500 file:mr-4 file:py-2.5 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-bold file:bg-yellow-50 file:text-yellow-700 hover:file:bg-yellow-100 transition-all cursor-pointer border border-slate-200 rounded-full bg-slate-50" />
                </div>

                <button type="submit" class="w-full inline-flex items-center justify-center gap-2 px-6 py-3 text-sm font-bold text-white transition-colors bg-blue-700 rounded-xl hover:bg-blue-800 shadow-sm mt-auto">
                    <i class="fa-solid fa-save"></i> Atualizar Prefeito
                </button>
            </form>
        </div>
        @endif

        {{-- ================= FORMULÁRIO VICE-PREFEITO ================= --}}
        @if($vicePrefeito)
        <div class="p-6 md:p-8 bg-white border rounded-2xl shadow-sm border-slate-200 flex flex-col h-full">
            <div class="flex items-center gap-3 mb-6 pb-4 border-b border-slate-100">
                <div class="w-10 h-10 rounded-full bg-blue-100 text-blue-700 flex items-center justify-center shrink-0">
                    <i class="fa-solid fa-user-tie"></i>
                </div>
                <div>
                    <h3 class="text-lg font-bold text-slate-800">Vice-Prefeito</h3>
                    <p class="text-xs text-slate-500">Altere o nome ou a foto oficial.</p>
                </div>
            </div>

            <form action="{{ route('admin.executivos.update', $vicePrefeito->id) }}" method="POST" enctype="multipart/form-data" class="flex flex-col flex-1">
                @csrf
                @method('PUT')

                <div class="mb-5">
                    <label class="block mb-2 text-sm font-bold text-slate-700">Nome <span class="text-red-500">*</span></label>
                    <input type="text" name="nome" value="{{ old('nome', $vicePrefeito->nome) }}" required
                        class="w-full px-4 py-3 text-sm transition-colors border rounded-xl bg-slate-50 border-slate-200 focus:bg-white focus:border-blue-500 focus:ring-4 focus:ring-blue-500/10" />
                </div>

                <div class="mb-6 flex-1">
                    <label class="block mb-3 text-sm font-bold text-slate-700">Fotografia Oficial</label>
                    @if($vicePrefeito->foto)
                        <img src="{{ asset('storage/' . $vicePrefeito->foto) }}" alt="Foto do Vice" class="object-cover w-24 h-24 mb-4 border shadow-sm rounded-xl border-slate-200">
                    @endif
                    <input type="file" name="foto" accept="image/jpeg, image/png, image/webp"
                        class="block w-full text-sm text-slate-500 file:mr-4 file:py-2.5 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-bold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100 transition-all cursor-pointer border border-slate-200 rounded-full bg-slate-50" />
                </div>

                <button type="submit" class="w-full inline-flex items-center justify-center gap-2 px-6 py-3 text-sm font-bold text-slate-700 transition-colors bg-slate-100 border border-slate-200 rounded-xl hover:bg-slate-200 shadow-sm mt-auto">
                    <i class="fa-solid fa-save"></i> Atualizar Vice-Prefeito
                </button>
            </form>
        </div>
        @endif

    </div>
</div>
@endsection