@extends('layouts.app')

@section('title', 'Em Desenvolvimento')

@section('content')
<main class="min-h-[60vh] flex flex-col items-center justify-center py-20 px-4 bg-white">
    <div class="max-w-xl w-full flex flex-col items-center text-center">
        <svg xmlns="http://www.w3.org/2000/svg" class="w-20 h-20 text-yellow-400 mb-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" aria-hidden="true">
            <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
        </svg>
        <h1 class="text-3xl md:text-4xl font-extrabold text-slate-800 mb-4" style="font-family: 'Montserrat', sans-serif;">Página em Desenvolvimento</h1>
        <p class="text-lg text-slate-600 mb-8">Esta funcionalidade estará disponível em breve.<br>Estamos trabalhando para entregar a melhor experiência.</p>
        <a href="/" class="inline-flex items-center gap-2 px-6 py-3 rounded-full bg-[#006eb7] text-white font-bold text-base hover:bg-blue-800 transition shadow-md">
            <i class="fa-solid fa-arrow-left"></i> Voltar para o início
        </a>
    </div>
</main>
@endsection