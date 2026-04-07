<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="scroll-smooth">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>@yield('title', 'Portal da Prefeitura de Assaí')</title>

    <link rel="icon" type="image/png" href="{{ asset('img/brasao.png') }}">

    @yield('meta_tags')

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;600;700;800;900&family=Poppins:wght@400;500;600;700&display=swap"
        rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" />

    <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>

    {{-- Bundle principal: app.js já importa navbar.js e widgets.js internamente --}}
    @vite(['resources/css/app.css', 'resources/js/app.js', 'resources/css/home.css', 'resources/js/home.js'])

    {{--
    Alpine.js DEVE ser carregado APÓS os módulos Vite.
    O Vite carrega scripts como módulos (que são assíncronos/defer).
    Ao colocar o Alpine.js após os módulos Vite, garantimos que
    'widgets.js' registre o listener 'alpine:init' ANTES do Alpine iniciar.
    --}}
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

    <script>
        /* Aplica preferências salvas antes da 1ª pintura — evita flash de conteúdo */
        (function () {
            var s = localStorage.getItem('a11y_fontSize');
            if (s) document.documentElement.style.fontSize = s + 'px';
            if (localStorage.getItem('a11y_contrast') === '1') document.documentElement.classList.add('contrast-mode');
        })();
    </script>
</head>

<body class="bg-gray-50 text-gray-800 antialiased font-sans min-h-screen flex flex-col overflow-x-hidden">

    {{-- Skip links (acessibilidade por teclado) --}}
    <a href="#conteudo-principal" accesskey="1"
        class="sr-only focus:not-sr-only focus:fixed focus:z-[200] focus:top-0 focus:left-0 focus:px-4 focus:py-2 focus:bg-yellow-500 focus:text-blue-900 focus:font-bold focus:text-sm">
        Ir para o conteúdo [1]
    </a>
    <a href="#menu-principal" accesskey="2"
        class="sr-only focus:not-sr-only focus:fixed focus:z-[200] focus:top-0 focus:left-24 focus:px-4 focus:py-2 focus:bg-yellow-500 focus:text-blue-900 focus:font-bold focus:text-sm">
        Ir para o menu [2]
    </a>

    @include('layouts.navbar')

    @yield('content')

{{-- @include('layouts.footer') --}}

    <div id="cookie-banner"
        class="fixed bottom-0 left-0 right-0 z-[100] hidden px-4 py-4 text-sm text-white bg-blue-950/95 backdrop-blur-md border-t border-blue-800 font-sans shadow-[0_-10px_40px_rgba(0,0,0,0.3)]">
        <div class="container flex flex-col items-center justify-between gap-4 mx-auto md:flex-row">
            <div class="flex-1">
                <p class="leading-relaxed">
                    <strong>Aviso de Cookies:</strong> Utilizamos cookies e tecnologias semelhantes para melhorar a sua
                    experiência no portal da Prefeitura Municipal de Assaí, garantindo a segurança e o desempenho do
                    site, em conformidade com a nossa <a href="https://valedosol.assai.pr.gov.br/lgpd"
                        class="font-bold text-yellow-400 underline transition hover:text-yellow-300">Política de
                        Privacidade (LGPD)</a>. Ao continuar navegando, você concorda com estas condições.
                </p>
            </div>
            <div class="flex gap-2 shrink-0">
                <button id="accept-cookies"
                    class="px-6 py-2.5 font-bold text-blue-900 transition bg-yellow-500 rounded-lg shadow-md hover:bg-yellow-400 font-heading hover:scale-105">
                    Entendi e Aceito
                </button>
            </div>
        </div>
    </div>

    {{-- Inicio do Widget VLibras --}}
    <div vw class="enabled">
        <div vw-access-button class="active"></div>
        <div vw-plugin-wrapper>
            <div class="vw-plugin-top-wrapper"></div>
        </div>
    </div>
    <script src="https://vlibras.gov.br/app/vlibras-plugin.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            new window.VLibras.Widget('https://vlibras.gov.br/app');
        });
    </script>
    {{-- Fim do Widget VLibras --}}

</body>

</html>