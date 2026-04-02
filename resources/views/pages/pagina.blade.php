<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Portal - Prefeitura de Assaí</title>

    <link rel="icon" type="image/png" href="{{ asset('img/brasao.png') }}">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;600;700;800;900&family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    @vite(['resources/css/app.css', 'resources/js/app.js', 'resources/css/home.css', 'resources/js/home.js'])
</head>

<body class="antialiased text-slate-800 bg-slate-50">
    @include('layouts.navbar')

    <main>

        {{-- ==============
             HERO SECTION
             ============== --}}
        <section id="hero-oficial" class="relative w-full h-[100dvh] overflow-hidden bg-slate-950 flex flex-col items-center justify-center">

            {{-- Vídeo Panorâmico com Overlays de Acessibilidade (WCAG AAA) --}}
            <video autoplay loop muted playsinline class="absolute inset-0 w-full h-full object-cover object-center transform scale-105" aria-hidden="true" style="opacity: 1 !important; filter: brightness(1) !important;">
                <source src="{{ asset('video/assai (1) (1).mp4') }}" type="video/mp4">
            </video>

            {{-- Sombra Única, Estática e Uniforme blindada contra manipulação via JS --}}
            <div class="absolute inset-0 z-10 pointer-events-none" style="background-color: rgba(2, 6, 23, 0.6) !important; opacity: 1 !important;"></div>

        </section>

        {{-- Espaçador para testes de scroll --}}
        <div style="height: 100vh; background: #f8fafc;"></div>
    </main>
</body>

</html>