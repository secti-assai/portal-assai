<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Painel Administrativo - Assaí</title>
    <link rel="icon" type="image/x-icon" href="{{ asset('favicon.ico') }}?v=3">
    <link rel="shortcut icon" type="image/x-icon" href="{{ asset('favicon.ico') }}?v=3">
    <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('img/brasao.png') }}?v=3">
    <link rel="icon" type="image/png" sizes="192x192" href="{{ asset('img/brasao.png') }}?v=3">
    <link rel="apple-touch-icon" href="{{ asset('img/brasao.png') }}?v=3">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;600;700;800;900&family=Poppins:wght@400;500;600;700&display=swap"
        rel="stylesheet">
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    @vite(['resources/css/admin.css', 'resources/js/admin.js'])

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" />

    <script src="https://cdn.ckeditor.com/ckeditor5/41.1.0/classic/ckeditor.js"></script>
</head>

<body class="flex h-screen overflow-hidden font-sans bg-slate-50">

    <aside class="flex-col hidden w-64 text-white transition-all bg-blue-900 shadow-xl lg:flex shrink-0 z-20">

        <div class="flex items-center justify-center h-16 border-b bg-blue-950 border-blue-800/50 shrink-0">
            <a href="{{ route('admin.dashboard') }}"
                class="text-xl font-extrabold tracking-tight text-white transition hover:text-yellow-400">
                Admin
            </a>
        </div>

        <nav class="flex flex-col flex-1 gap-2 p-4 mt-2 overflow-y-auto">

            <a href="{{ route('admin.dashboard') }}"
                class="flex items-center gap-3 px-4 py-3 transition rounded-lg hover:bg-blue-800 {{ request()->routeIs('admin.dashboard') ? 'bg-blue-800 border-l-4 border-yellow-400 text-yellow-400 font-bold' : 'text-blue-100 font-medium' }}">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6">
                    </path>
                </svg>
                Dashboard
            </a>

            @if(auth()->user()->canAny(['gerir alertas', 'gerir banners', 'gerir servicos', 'gerir programas', 'gerir noticias', 'gerir eventos', 'gerir secretarias', 'gerenciar vagas']))
                <div class="mt-4 mb-2 text-xs font-bold tracking-wider text-blue-400 uppercase px-4">Conteúdo</div>
            @endif

            @can('gerir banners')
                <a href="{{ route('admin.banners.index') }}"
                    class="flex items-center gap-3 px-4 py-3 transition rounded-lg hover:bg-blue-800 {{ request()->routeIs('admin.banners.index') ? 'bg-blue-800 border-l-4 border-yellow-400 text-yellow-400 font-bold' : 'text-blue-100 font-medium' }}">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z">
                        </path>
                    </svg>
                    Imagem Pop-up
                </a>
            @endcan

            @canany(['gerir noticias', 'gerir servicos', 'gerir programas', 'gerir eventos'])
                <a href="{{ route('admin.categorias.index') }}"
                    class="flex items-center gap-3 px-4 py-3 transition rounded-lg hover:bg-blue-800 {{ request()->routeIs('admin.categorias.*') ? 'bg-blue-800 border-l-4 border-yellow-400 text-yellow-400 font-bold' : 'text-blue-100 font-medium' }}">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z">
                        </path>
                    </svg>
                    Categorias / Temas
                </a>
            @endcanany

            @can('gerir noticias')
                <a href="{{ route('admin.noticias.index') }}"
                    class="flex items-center gap-3 px-4 py-3 transition rounded-lg hover:bg-blue-800 {{ request()->routeIs('admin.noticias.index') || request()->routeIs('admin.noticias.create') || request()->routeIs('admin.noticias.edit') ? 'bg-blue-800 border-l-4 border-yellow-400 text-yellow-400 font-bold' : 'text-blue-100 font-medium' }}">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9.5a2 2 0 00-2-2h-2">
                        </path>
                    </svg>
                    Notícias
                </a>
            @endcan

            @can('gerir banners')
                <a href="{{ route('admin.banner-destaques.index') }}"
                    class="flex items-center gap-3 px-4 py-3 transition rounded-lg hover:bg-blue-800 {{ request()->routeIs('admin.banner-destaques.*') ? 'bg-blue-800 border-l-4 border-yellow-400 text-yellow-400 font-bold' : 'text-blue-100 font-medium' }}">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z">
                        </path>
                    </svg>
                    Banners
                </a>
            @endcan

            @can('gerir servicos')
                <a href="{{ route('admin.servicos.index') }}"
                    class="flex items-center gap-3 px-4 py-3 transition rounded-lg hover:bg-blue-800 {{ request()->routeIs('admin.servicos.*') ? 'bg-blue-800 border-l-4 border-yellow-400 text-yellow-400 font-bold' : 'text-blue-100 font-medium' }}">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                    </svg>
                    Serviços
                </a>
            @endcan

            @can('gerir programas')
                <a href="{{ route('admin.programas.index') }}"
                    class="flex items-center gap-3 px-4 py-3 transition rounded-lg hover:bg-blue-800 {{ request()->routeIs('admin.programas.*') ? 'bg-blue-800 border-l-4 border-yellow-400 text-yellow-400 font-bold' : 'text-blue-100 font-medium' }}">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10">
                        </path>
                    </svg>
                    Programas
                </a>
            @endcan

            @can('gerir eventos')
                <a href="{{ route('admin.eventos.index') }}"
                    class="flex items-center gap-3 px-4 py-3 transition rounded-lg hover:bg-blue-800 {{ request()->routeIs('admin.eventos.*') ? 'bg-blue-800 border-l-4 border-yellow-400 text-yellow-400 font-bold' : 'text-blue-100 font-medium' }}">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z">
                        </path>
                    </svg>
                    Agenda de Eventos
                </a>
            @endcan

            @can('gerenciar vagas')
                <a href="{{ route('admin.vagas.index') }}"
                    class="flex items-center gap-3 px-4 py-3 transition rounded-lg hover:bg-blue-800 {{ request()->routeIs('admin.vagas.*') ? 'bg-blue-800 border-l-4 border-yellow-400 text-yellow-400 font-bold' : 'text-blue-100 font-medium' }}">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z">
                        </path>
                    </svg>
                    Oportunidades
                </a>
            @endcan

            @can('gerir secretarias')
                <a href="{{ route('admin.executivos.index') }}"
                    class="flex items-center gap-3 px-4 py-3 transition rounded-lg hover:bg-blue-800 {{ request()->routeIs('admin.executivos.*') ? 'bg-blue-800 border-l-4 border-yellow-400 text-yellow-400 font-bold' : 'text-blue-100 font-medium' }}">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                    </svg>
                    Executivo (Prefeito)
                </a>
            @endcan

            @can('gerir secretarias')
                <a href="{{ route('admin.secretarias.index') }}"
                    class="flex items-center gap-3 px-4 py-3 transition rounded-lg hover:bg-blue-800 {{ request()->routeIs('admin.secretarias.*') ? 'bg-blue-800 border-l-4 border-yellow-400 text-yellow-400 font-bold' : 'text-blue-100 font-medium' }}">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z">
                        </path>
                    </svg>
                    Secretarias
                </a>
            @endcan

            @can('gerir banners')
                <a href="{{ route('admin.redes-sociais.index') }}"
                    class="flex items-center gap-3 px-4 py-3 transition rounded-lg hover:bg-blue-800 {{ request()->routeIs('admin.redes-sociais.*') ? 'bg-blue-800 border-l-4 border-yellow-400 text-yellow-400 font-bold' : 'text-blue-100 font-medium' }}">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M8.684 13.342C8.886 12.938 9 12.482 9 12c0-.482-.114-.938-.316-1.342m0 2.684a3 3 0 110-2.684m0 2.684l6.632 3.316m-6.632-6l6.632-3.316m0 0a3 3 0 105.367-2.684 3 3 0 00-5.367 2.684zm0 9.316a3 3 0 105.368 2.684 3 3 0 00-5.368-2.684z">
                        </path>
                    </svg>
                    Redes Sociais
                </a>
            @endcan

            @hasanyrole('admin')
            <div class="mt-4 mb-2 text-xs font-bold tracking-wider text-blue-400 uppercase px-4">Governança</div>

            <a href="{{ route('admin.activity-logs.index') }}"
                class="flex items-center gap-3 px-4 py-3 transition rounded-lg hover:bg-blue-800 {{ request()->routeIs('admin.activity-logs.*') ? 'bg-blue-800 border-l-4 border-yellow-400 text-yellow-400 font-bold' : 'text-blue-100 font-medium' }}">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M9 17v-2m3 2v-4m3 4V7m3 10H6a2 2 0 01-2-2V5a2 2 0 012-2h12a2 2 0 012 2v10a2 2 0 01-2 2z">
                    </path>
                </svg>
                Auditoria
            </a>

            @can('gerir usuarios')
                <a href="{{ route('users.index') }}"
                    class="flex items-center gap-3 px-4 py-3 transition rounded-lg hover:bg-blue-800 {{ request()->routeIs('admin.users.*') ? 'bg-blue-800 border-l-4 border-yellow-400 text-yellow-400 font-bold' : 'text-blue-100 font-medium' }}">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z">
                        </path>
                    </svg>
                    Usuários
                </a>
            @endcan
            @endhasanyrole

        </nav>

        <div class="p-4 border-t border-blue-800/50 shrink-0">
            <div class="flex flex-col items-center gap-2 text-center">
                {{-- Badge de role do usuário logado --}}
                @php
                    $sidebarPapeis = Auth::user()->getRoleNames();
                    $sidebarPapel  = $sidebarPapeis->first() ?? null;
                    $roleStyle = match($sidebarPapel) {
                        'admin'       => 'bg-yellow-400/20 text-yellow-300 border-yellow-500/30',
                        'editor'      => 'bg-purple-400/20 text-purple-300 border-purple-500/30',
                        'comunicacao' => 'bg-emerald-400/20 text-emerald-300 border-emerald-500/30',
                        default       => 'bg-blue-400/20 text-blue-300 border-blue-500/30',
                    };
                    $roleIcon = match($sidebarPapel) {
                        'admin'       => 'fa-shield-halved',
                        'editor'      => 'fa-pen-to-square',
                        'comunicacao' => 'fa-bullhorn',
                        default       => 'fa-user',
                    };
                @endphp
                @if($sidebarPapel)
                <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full border text-xs font-bold uppercase tracking-wide {{ $roleStyle }}">
                    <i class="fa-solid {{ $roleIcon }} text-[10px]"></i>
                    {{ $sidebarPapel }}
                </span>
                @endif
                <span class="text-xs text-blue-400">Prefeitura de Assaí &copy; {{ date('Y') }}</span>
            </div>
        </div>
    </aside>

    <div class="flex flex-col flex-1 min-w-0 overflow-hidden">

        <header
            class="flex items-center justify-between px-4 md:px-6 py-4 bg-white border-b shadow-sm border-slate-200 shrink-0 z-10">
            <div class="flex items-center gap-4">
                <span class="text-xl font-bold text-slate-800 lg:hidden">Painel Admin</span>
                <details class="lg:hidden relative">
                    <summary
                        class="list-none inline-flex items-center gap-2 px-3 py-2 text-xs font-bold text-blue-900 bg-blue-50 border border-blue-100 rounded-lg cursor-pointer">
                        Menu
                    </summary>
                    <nav
                        class="absolute left-0 mt-2 z-30 w-56 p-2 bg-white border border-slate-200 rounded-xl shadow-xl">
                        <a href="{{ route('admin.dashboard') }}"
                            class="block px-3 py-2 text-sm font-medium text-slate-700 rounded-lg hover:bg-slate-50">Dashboard</a>
                        @canany(['gerir noticias', 'gerir servicos', 'gerir programas', 'gerir eventos'])
                            <a href="{{ route('admin.categorias.index') }}"
                                class="block px-3 py-2 text-sm font-medium text-slate-700 rounded-lg hover:bg-slate-50">Categorias / Temas</a>
                        @endcanany
                        @can('gerir noticias')
                            <a href="{{ route('admin.noticias.index') }}"
                                class="block px-3 py-2 text-sm font-medium text-slate-700 rounded-lg hover:bg-slate-50">Notícias</a>
                        @endcan
                        @can('gerir banners')
                            <a href="{{ route('admin.banners.index') }}"
                                class="block px-3 py-2 text-sm font-medium text-slate-700 rounded-lg hover:bg-slate-50">Banners</a>
                        @endcan
                        @can('gerir eventos')
                            <a href="{{ route('admin.eventos.index') }}"
                                class="block px-3 py-2 text-sm font-medium text-slate-700 rounded-lg hover:bg-slate-50">Eventos</a>
                        @endcan
                        @can('gerir programas')
                            <a href="{{ route('admin.programas.index') }}"
                                class="block px-3 py-2 text-sm font-medium text-slate-700 rounded-lg hover:bg-slate-50">Programas</a>
                        @endcan
                        @can('gerenciar vagas')
                            <a href="{{ route('admin.vagas.index') }}"
                                class="block px-3 py-2 text-sm font-medium text-slate-700 rounded-lg hover:bg-slate-50">Oportunidades</a>
                        @endcan
                        @can('gerir secretarias')
                            <a href="{{ route('admin.executivos.index') }}"
                                class="block px-3 py-2 text-sm font-medium text-slate-700 rounded-lg hover:bg-slate-50">Executivo</a>
                            <a href="{{ route('admin.secretarias.index') }}"
                                class="block px-3 py-2 text-sm font-medium text-slate-700 rounded-lg hover:bg-slate-50">Secretarias</a>
                        @endcan
                        @can('gerir servicos')
                            <a href="{{ route('admin.servicos.index') }}"
                                class="block px-3 py-2 text-sm font-medium text-slate-700 rounded-lg hover:bg-slate-50">Serviços</a>
                        @endcan
                        @role('admin')
                        <a href="{{ route('admin.activity-logs.index') }}"
                            class="block px-3 py-2 text-sm font-medium text-slate-700 rounded-lg hover:bg-slate-50">Auditoria</a>
                        @endrole
                    </nav>
                </details>
            </div>

            <div class="flex items-center gap-3 md:gap-4">
                <span class="hidden text-sm font-medium text-slate-500 lg:block">
                    Bem-vindo(a), <strong class="text-slate-700">{{ Auth::user()->name }}</strong>
                </span>

                <a href="/" target="_blank"
                    class="hidden lg:flex items-center gap-2 px-4 py-2 text-sm font-bold transition rounded-lg text-slate-600 hover:text-blue-600 bg-slate-100 hover:bg-blue-50">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"></path>
                    </svg>
                    Ver site
                </a>

                <form action="{{ route('logout') }}" method="POST" class="m-0">
                    @csrf
                    <button type="submit"
                        class="inline-flex items-center justify-center gap-2 px-3 md:px-4 py-2 text-sm font-bold text-red-700 transition bg-red-100 rounded-lg hover:bg-red-200 hover:-translate-y-0.5 shadow-sm border border-red-200">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1">
                            </path>
                        </svg>
                        Sair
                    </button>
                </form>
            </div>
        </header>

        <main class="flex-1 w-full p-4 overflow-y-auto md:p-8">
            <div class="max-w-6xl mx-auto pb-10">
                @yield('content')
            </div>
        </main>

    </div>

    @stack('scripts')
</body>

</html>