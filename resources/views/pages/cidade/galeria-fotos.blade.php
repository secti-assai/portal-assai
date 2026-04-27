@extends('layouts.app')

@section('title', 'Galeria de Fotos - Prefeitura Municipal de Assaí')

@section('content')
<section class="pt-20 pb-12 bg-slate-50 min-h-[60vh]">
    <div class="container mx-auto max-w-6xl px-4">
        <div class="mb-10 text-center">
            <h1 class="text-4xl md:text-5xl font-extrabold text-[#006eb7] mb-3 font-heading">Galeria de Fotos</h1>
            <p class="text-slate-500 text-lg max-w-2xl mx-auto">Confira registros de eventos, paisagens e momentos marcantes de Assaí.</p>
        </div>

        <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 gap-4 md:gap-6" id="galeria-fotos-grid">
            @forelse($fotos as $noticia)
            @php
                $img = str_starts_with($noticia->imagem_capa, 'img/') ? asset($noticia->imagem_capa) : asset('storage/' . $noticia->imagem_capa);
            @endphp
            <div class="relative group cursor-pointer rounded-2xl overflow-hidden shadow hover:shadow-xl transition-all border border-slate-100 bg-white">
                <img src="{{ $img }}" alt="{{ $noticia->titulo ?? 'Foto de Assaí' }}" title="{{ $noticia->titulo }}" class="w-full h-44 sm:h-48 md:h-56 object-cover group-hover:scale-105 transition-transform duration-300" loading="lazy" onclick="showFotoModal('{{ $img }}', '{{ addslashes($noticia->titulo ?? '') }}')">
            </div>
            @empty
            <div class="col-span-full text-center py-12 text-slate-500">
                <p>Nenhuma foto disponível no momento.</p>
            </div>
            @endforelse
        </div>

        <div class="mt-12" id="pagination-container">
            {{ $fotos->links('components.pagination.agenda-style') }}
        </div>
    </div>

    <!-- Modal para exibir foto ampliada -->
    <div id="fotoModal" class="fixed inset-0 z-50 flex items-center justify-center bg-black/70 backdrop-blur-sm hidden" style="transition: all 0.3s;">
        <div class="relative flex items-center justify-center p-4 bg-white rounded-2xl shadow-2xl border border-slate-200" style="max-width:90vw; max-height:90vh;">
            <button onclick="hideFotoModal()" aria-label="Fechar" class="absolute top-2 right-2 bg-white/80 hover:bg-white rounded-full p-2 shadow focus:outline-none focus:ring-2 focus:ring-yellow-400 z-10">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-slate-800" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" /></svg>
            </button>
            <img id="fotoModalImg" src="" alt="Foto ampliada" class="block mx-auto" style="max-width: min(600px, 90vw); max-height: min(80vh, 500px); width: auto; height: auto; object-fit: contain;" />
        </div>
    </div>
    <script>
        function showFotoModal(src, title) {
            var modal = document.getElementById('fotoModal');
            var img = document.getElementById('fotoModalImg');
            img.src = src;
            if(title) {
                img.alt = title;
                img.title = title;
            }
            modal.classList.remove('hidden');
            document.body.style.overflow = 'hidden';
        }
        function hideFotoModal() {
            var modal = document.getElementById('fotoModal');
            modal.classList.add('hidden');
            document.body.style.overflow = '';
        }
        document.addEventListener('click', function(e) {
            var modal = document.getElementById('fotoModal');
            var img = document.getElementById('fotoModalImg');
            if (!modal.classList.contains('hidden') && e.target === modal) {
                hideFotoModal();
            }
        });
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape') hideFotoModal();
        });
    </script>
</section>
@endsection