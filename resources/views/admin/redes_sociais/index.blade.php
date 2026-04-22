@extends('layouts.admin')

@section('content')
<div class="max-w-5xl mx-auto flex flex-col gap-6">
    
    <div>
        <h1 class="text-2xl font-bold text-slate-800">Vitrine do Instagram</h1>
        <p class="text-sm text-slate-500 mt-1">Gerencie as 4 imagens que aparecem na seção "Nas Redes Sociais" da página inicial.</p>
        
        {{-- Aviso claro adicionado abaixo do título --}}
        <div class="mt-3 inline-flex items-center gap-2 px-4 py-2.5 bg-blue-50 text-blue-700 text-sm font-medium rounded-lg border border-blue-100">
            <i class="fa-solid fa-circle-info text-blue-500"></i>
            <span><strong>Importante:</strong> Para que o card funcione corretamente no site, você precisa enviar a <strong>imagem</strong> e colar o <strong>link</strong> do post do Instagram em cada posição.</span>
        </div>
    </div>

    @if(session('sucesso'))
    <div class="p-4 flex items-center gap-3 text-emerald-800 bg-emerald-50 border border-emerald-200 rounded-xl shadow-sm">
        <i class="fa-solid fa-circle-check text-xl"></i>
        <span class="font-medium">{{ session('sucesso') }}</span>
    </div>
    @endif

    <form action="{{ route('admin.redes-sociais.updateAll') }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            @foreach($posts as $post)
            <div class="bg-white p-6 rounded-xl border border-slate-200 shadow-sm flex flex-col gap-4">
                <h3 class="font-bold text-lg text-slate-700 border-b border-slate-100 pb-2">Posição {{ $post->ordem }}</h3>
                
                {{-- Preview da Imagem Atual --}}
                <div class="w-full aspect-square bg-slate-100 rounded-lg border border-dashed border-slate-300 flex items-center justify-center overflow-hidden relative">
                    @if($post->imagem)
                        <img src="{{ asset('storage/' . $post->imagem) }}" class="w-full h-full object-cover">
                    @else
                        <span class="text-slate-400 text-sm"><i class="fa-regular fa-image text-2xl block text-center mb-1"></i> Sem imagem</span>
                    @endif
                </div>

                {{-- Upload de Nova Imagem --}}
                <div>
                    <label class="block text-xs font-bold text-slate-600 mb-1">Nova Imagem (1:1 Quadrada)</label>
                    <input type="file" name="imagem[{{ $post->ordem }}]" accept="image/*" class="block w-full text-xs text-slate-500 file:mr-3 file:py-1.5 file:px-3 file:rounded-md file:border-0 file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100 border border-slate-200 rounded-md bg-slate-50 cursor-pointer">
                </div>

                {{-- Link --}}
                <div>
                    <label class="block text-xs font-bold text-slate-600 mb-1">Link do Instagram</label>
                    <input type="url" name="link[{{ $post->ordem }}]" value="{{ $post->link }}" class="w-full bg-slate-50 border border-slate-300 text-slate-800 text-sm rounded-md px-3 py-2 focus:ring-2 focus:ring-blue-500 outline-none" placeholder="https://instagram.com/p/...">
                </div>
            </div>
            @endforeach
        </div>

        <div class="mt-6 flex justify-end">
            <button type="submit" class="px-8 py-3 bg-blue-600 text-white font-bold rounded-lg shadow-md hover:bg-blue-700 transition-all flex items-center gap-2">
                <i class="fa-solid fa-save"></i> Salvar Todas as Posições
            </button>
        </div>
    </form>
</div>
@endsection