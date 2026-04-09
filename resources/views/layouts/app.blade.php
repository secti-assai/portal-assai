<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="scroll-smooth">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, viewport-fit=cover">

    <title>@yield('title', 'Portal da Prefeitura de Assaí')</title>

    <link rel="icon" type="image/x-icon" href="{{ asset('favicon.ico') }}?v=3">
    <link rel="shortcut icon" type="image/x-icon" href="{{ asset('favicon.ico') }}?v=3">
    <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('img/brasao.png') }}?v=3">
    <link rel="icon" type="image/png" sizes="192x192" href="{{ asset('img/brasao.png') }}?v=3">
    <link rel="apple-touch-icon" href="{{ asset('img/brasao.png') }}?v=3">

    @yield('meta_tags')

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;600;700;800;900&family=Poppins:wght@400;500;600;700&display=swap"
        rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/js/all.min.js" integrity="sha512-u3fPA7V8qQmhBPNT5quvaXVa1mnnLSXUep5PS1qo5NRzHwG19aHmNJnj1Q8hpA/nBWZtZD4r4AX6YOt5ynLN2g==" crossorigin="anonymous" referrerpolicy="no-referrer" defer></script>

    <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>

    @if(request()->routeIs('home'))
    <link rel="preload" as="image" href="{{ asset('img/logo_branca.png') }}" fetchpriority="high">
    <style>
        html {
            background-color: #020617 !important;
        }
    </style>
    @endif

    {{-- Bundle base global do portal --}}
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    {{-- Assets exclusivos da home --}}
    @if(request()->routeIs('home'))
    @vite(['resources/css/home.css', 'resources/js/home.js'])
    @endif

    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

    <script>
        /* Aplica preferências salvas antes da 1ª pintura — evita flash de conteúdo */
        (function() {
            var s = localStorage.getItem('a11y_fontSize');
            if (s) document.documentElement.style.fontSize = s + 'px';
            if (localStorage.getItem('a11y_contrast') === '1') document.documentElement.classList.add('contrast-mode');
        })();
    </script>
</head>

<body class="{{ request()->routeIs('home')
    ? 'bg-slate-950'
    : (request()->routeIs('pages.sobre') || request()->routeIs('pages.transparencia') || request()->routeIs('pages.turismo') || request()->routeIs('pages.contato') || request()->routeIs('agenda.*') || request()->routeIs('programas.*') || request()->routeIs('secretarias.*') || request()->routeIs('servicos.*')
        ? 'bg-[#edf5ff]'
        : 'bg-gray-50') }} text-gray-800 antialiased font-sans min-h-screen flex flex-col overflow-x-hidden">

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

    {{-- Wrapper de compensação do header fixo --}}
    <div class="{{ request()->routeIs('home') || request()->routeIs('noticias.*') ? '' : 'content-offset-dynamic-header' }}">
        @yield('content')
    </div>

    @include('layouts.footer')

    <button
        id="btn-back-to-top"
        type="button"
        aria-label="Voltar ao topo da página"
        title="Voltar ao topo"
        class="fixed bottom-5 right-5 z-[90] inline-flex items-center justify-center w-12 h-12 rounded-full bg-blue-700 text-white shadow-lg shadow-blue-900/30 border border-blue-600 transition-all duration-300 opacity-0 translate-y-10 pointer-events-none hover:bg-blue-600 hover:scale-105 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-yellow-400 focus-visible:ring-offset-2 focus-visible:ring-offset-blue-950">
        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 15l7-7 7 7" />
        </svg>
    </button>

    <div id="cookie-banner"
        class="fixed bottom-0 left-0 right-0 z-[100] hidden px-4 py-4 text-sm text-white bg-blue-950/95 backdrop-blur-md border-t border-blue-800 font-sans shadow-[0_-10px_40px_rgba(0,0,0,0.3)]">
        <div class="container flex flex-col items-center justify-between gap-4 mx-auto md:flex-row">
            <div class="flex-1 text-white">
                <p class="leading-relaxed text-white">
                    <strong class="text-white">Aviso de Cookies:</strong> Utilizamos cookies e tecnologias semelhantes para melhorar a sua experiência no portal da Prefeitura Municipal de Assaí, em conformidade com a nossa <a href="https://valedosol.assai.pr.gov.br/lgpd" class="font-bold text-yellow-300 underline transition hover:text-yellow-200">Política de Privacidade (LGPD)</a>. Ao continuar navegando, você concorda com estas condições.
                </p>
            </div>
            <div class="flex gap-2 shrink-0">
                <button id="accept-cookies" class="px-6 py-2.5 font-bold text-blue-900 transition bg-yellow-500 rounded-lg shadow-md hover:bg-yellow-400 font-heading hover:scale-105">
                    Entendi e Aceito
                </button>
            </div>
        </div>
    </div>

    {{-- Widget VLibras --}}
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
</body>

</html>