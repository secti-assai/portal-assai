<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Novo Portal - Prefeitura de Assaí</title>
    
    {{-- Fontes aprovadas pela chefia: Poppins (Corpo) e Montserrat (Títulos) --}}
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;600;700;800;900&family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    {{-- Definindo as fontes base para a página --}}
    <style>
        body { font-family: 'Poppins', sans-serif; }
        h1, h2, h3, h4, h5, h6, .font-heading { font-family: 'Montserrat', sans-serif; }
    </style>
</head>
<body class="bg-slate-50 antialiased text-slate-800">

    {{-- 1. PUXANDO A NOVA NAVBAR --}}
    @include('layouts.navbar')

    {{-- 2. CONTEÚDO PRINCIPAL --}}
    <main>

    </main>

</body>
</html>