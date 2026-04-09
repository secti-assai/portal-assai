@extends('layouts.app')

@section('title', 'Portal - Prefeitura de Assaí')

@section('meta_tags')
<style>
    :root {
        --pl-mobile-blue-700: #005ea2;
        --pl-mobile-blue-500: #2491ff;
        --pl-mobile-bg: #f9f6f5;
        --pl-mobile-card: #ffffff;
        --pl-mobile-text: #11181d;
        --pl-mobile-muted: #3d4551;
        --pl-mobile-border: #d1d5db;
        --pl-mobile-radius: 6px;
        --pl-mobile-shadow: 0 1px 2px rgba(0, 0, 0, 0.08);
    }

    @media (max-width: 1023px) {
        #hero-oficial {
            margin-top: -2px;
        }
    }

    /* ESTILOS EXCLUSIVOS DO MOBILE/TABLET */
    @media (max-width: 1023px) {
        html,
        body {
            max-width: 100%;
            overflow-x: clip !important;
            background: #fff;
            margin: 0 !important;
            padding: 0 !important;
        }

        #home-main {
            font-family: 'Open Sans', sans-serif;
            color: #3d4551;
            max-width: 100%;
            overflow-x: clip !important;
            margin-top: 0 !important; 
            padding-top: 0 !important;
        }

        body > header,
        #site-header,
        #header,
        .site-header,
        .header,
        .top-header {
            display: none !important;
        }

        #pl-mobile-home {
            overflow-x: hidden !important;
            max-width: 100%;
            width: 100%;
        }

        #pl-mobile-home,
        #pl-mobile-home * {
            box-sizing: border-box;
        }

        #pl-mobile-home {
            -webkit-font-smoothing: antialiased;
            text-rendering: optimizeLegibility;
            position: relative;
        }

        #pl-mobile-home .topbar {
            background: #fff;
            border-bottom: 1px solid #e2e8f0;
            position: relative;
            z-index: 2147483646;
        }

        #pl-mobile-home .topbar-color-strip {
            height: 6px;
            width: 100%;
            background: linear-gradient(90deg, #0071b8 0 25%, #1f9f5b 25% 50%, #d92f2f 50% 75%, #e7c500 75% 100%);
        }

        #pl-mobile-home .topbar-inner {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 0.8rem 1rem;
            width: 100%;
        }

        #pl-mobile-home .brand {
            font-family: 'Montserrat', sans-serif;
            font-size: 1.3rem;
            font-weight: 800;
            letter-spacing: -0.02em;
            line-height: 1;
        }

        #pl-mobile-home .brand .b1 { color: #006eb7; }
        #pl-mobile-home .brand .b2 { color: #eab308; } /* Ajustado para amarelo Assaí, ou mantenha verde se preferir */
        #pl-mobile-home .brand .b3 { color: #dc2626; }
        #pl-mobile-home .brand .b4 { color: #eab308; }
        #pl-mobile-home .brand .gov { color: #334155; font-weight: 400; }

        #pl-mobile-home .menu-mobile-btn {
            color: #006eb7;
            font-weight: 800;
            font-size: 0.9rem;
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            text-decoration: none;
            border: 0;
            background: transparent;
            cursor: pointer;
        }
        
        #pl-mobile-home .menu-mobile-btn i {
            font-size: 1.2rem;
        }

        #pl-mobile-home .menu-mobile-btn .icon-close {
            display: none;
            font-family: 'Montserrat', sans-serif;
            font-size: 1.1rem;
            font-weight: 700;
            line-height: 1;
        }

        #pl-mobile-home.menu-open .menu-mobile-btn .icon-open {
            display: none;
        }

        #pl-mobile-home.menu-open .menu-mobile-btn .icon-close {
            display: inline-block;
        }

        #pl-mobile-home .mobile-drawer {
            position: absolute;
            top: 53px;
            left: 0;
            right: 0;
            width: 100%;
            max-height: min(72vh, 520px);
            background: #ffffff;
            transform: none;
            transition: opacity 0.15s ease, visibility 0.15s ease;
            z-index: 2147483647;
            box-shadow: 0 10px 22px rgba(15, 23, 42, 0.12);
            border-top: 0;
            overflow: hidden;
            opacity: 0;
            visibility: hidden;
            pointer-events: none;
        }

        #pl-mobile-home .mobile-drawer-body {
            padding: 0 1rem 0.7rem;
            overflow-y: auto;
            max-height: min(72vh, 520px);
        }

        #pl-mobile-home .mobile-nav-list {
            list-style: none;
            margin: 0;
            padding: 0;
            display: flex;
            flex-direction: column;
            gap: 0;
        }

        #pl-mobile-home .mobile-nav-link {
            display: flex;
            align-items: center;
            justify-content: space-between;
            width: 100%;
            text-decoration: none;
            color: #334155;
            font-size: 1.14rem;
            line-height: 1.22;
            font-weight: 400;
            padding: 0.94rem 0;
            border: 0;
            border-bottom: 1px solid #eef2f6;
            background: transparent;
            text-align: left;
        }

        #pl-mobile-home .mobile-nav-toggle {
            display: flex;
            align-items: center;
            justify-content: space-between;
            width: 100%;
            color: #334155;
            font-size: 1.14rem;
            line-height: 1.22;
            font-weight: 400;
            padding: 0.94rem 0;
            border: 0;
            border-bottom: 1px solid #eef2f6;
            background: transparent;
            text-align: left;
            cursor: pointer;
            font-family: 'Open Sans', sans-serif;
        }

        #pl-mobile-home .mobile-nav-toggle .caret {
            color: #3e4d5d;
            font-size: 0.95rem;
            transition: transform 0.2s ease;
        }

        #pl-mobile-home .mobile-nav-group.open .mobile-nav-toggle .caret {
            transform: rotate(180deg);
        }

        #pl-mobile-home .mobile-submenu {
            list-style: none;
            margin: 0;
            padding: 0 0 0.35rem;
            display: none;
            border-bottom: 1px solid #eef2f6;
            max-height: 240px;
            overflow-y: auto;
        }

        #pl-mobile-home .mobile-nav-group.open .mobile-submenu {
            display: block;
        }

        #pl-mobile-home .mobile-submenu-link {
            display: block;
            text-decoration: none;
            color: #516273;
            font-size: 0.92rem;
            line-height: 1.3;
            padding: 0.55rem 0 0.55rem 0.4rem;
        }

        #pl-mobile-home.menu-open .mobile-drawer {
            transform: translateY(0);
            opacity: 1;
            visibility: visible;
            pointer-events: auto;
        }

        #pl-mobile-home .home-hero-mobile {
            position: relative;
            background-image: url("{{ asset('img/Assaí.jpg') }}");
            background-size: cover;
            background-position: center;
            padding: 3rem 1.5rem;
        }

        #pl-mobile-home .home-hero-mobile::before {
            content: '';
            position: absolute;
            inset: 0;
            background: rgba(14, 38, 70, 0.75); /* Overlay escuro */
        }

        #pl-mobile-home .home-hero-content {
            position: relative;
            z-index: 1;
        }

        #pl-mobile-home .hero-title {
            color: #fff;
            font-size: clamp(1.55rem, 6vw, 1.85rem);
            line-height: 1.24;
            text-align: center;
            margin: 0 0 1.5rem 0;
            font-weight: 500;
            font-family: 'Montserrat', sans-serif;
            letter-spacing: 0.01em;
        }
        
        #pl-mobile-home .hero-title strong {
            font-weight: 800;
        }

        #pl-mobile-home .home-search-bar {
            background: #fff;
            border-radius: 50px;
            overflow: hidden;
            display: flex;
            align-items: center;
            padding: 4px;
            box-shadow: 0 4px 6px rgba(0,0,0,0.1);
        }

        #pl-mobile-home .home-search-bar .wp-block-search__input {
            width: 100%;
            border: 0;
            padding: 0.7rem 1rem;
            font-size: 1rem;
            color: #334155;
            background: transparent;
            outline: none;
        }

        #pl-mobile-home .home-search-bar .wp-block-search__button {
            border: 0;
            width: 44px;
            height: 44px;
            border-radius: 50px;
            background: #2394df; /* Azul claro do botão de busca */
            color: #fff;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
        }

        #pl-mobile-home .home-search-bar .wp-block-search__button i {
            font-size: 1.2rem;
        }

        /* Seções Gerais */
        #pl-mobile-home .section-title {
            font-family: 'Montserrat', sans-serif;
            font-size: clamp(1.55rem, 5.2vw, 1.72rem);
            font-weight: 500;
            text-align: center;
            margin: 0 0 1.5rem;
            color: #4a5c6a;
            line-height: 1.2;
            letter-spacing: 0.01em;
        }

        #pl-mobile-home .bg-white-section { background: #ffffff; padding: 2.25rem 0.85rem 2.1rem; }
        #pl-mobile-home .bg-gray-section { background: #eef1f5; padding: 2.5rem 1rem; }

        #pl-mobile-home .bg-white-section .section-title {
            font-size: clamp(1.82rem, 6.2vw, 2.05rem);
            line-height: 1.18;
        }

        /* Cards de Serviços */
        #pl-mobile-home .small-cards-grid {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 12px;
            max-width: 372px;
            margin: 0 auto;
        }

        #pl-mobile-home .small-card {
            background: #fff;
            border-radius: 22px;
            box-shadow: 0 6px 14px rgba(15, 23, 42, 0.07);
            border: 1px solid #edf2f7;
            padding: 1rem 0.56rem 0.78rem;
            min-height: 132px;
            display: flex;
            flex-direction: column;
            align-items: center;
            text-align: center;
            text-decoration: none;
            position: relative;
            width: 100%;
            min-width: 0;
        }

        #pl-mobile-home .small-card .helper-dot {
            position: absolute;
            right: 14px;
            top: 9px;
            color: #006eb7;
            font-family: 'Montserrat', sans-serif;
            font-size: 1.75rem;
            font-weight: 500;
            line-height: 1;
        }

        #pl-mobile-home .small-card .service-icon {
            color: #006eb7;
            font-size: 2.15rem;
            margin-bottom: 0.58rem;
            margin-top: 0.3rem;
        }

        #pl-mobile-home .small-card-title {
            font-size: 0.9rem;
            font-weight: 500;
            line-height: 1.28;
            margin: 0;
            color: #006eb7;
            text-wrap: balance;
            max-width: 96%;
            letter-spacing: 0.005em;
        }

        /* Botões Ver Todos */
        #pl-mobile-home .all-btn-wrapper {
            display: flex;
            justify-content: center;
            margin-top: 1.5rem;
        }

        #pl-mobile-home .all-btn {
            background: #006eb7;
            color: #fff;
            border-radius: 50px;
            padding: 0.8rem 1.8rem;
            font-size: 0.98rem;
            font-weight: 700;
            line-height: 1.15;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
        }

        /* Sliders e Notícias */
        #pl-mobile-home .glide__slides {
            display: flex;
            gap: 10px;
            overflow-x: auto;
            scroll-snap-type: x mandatory;
            scrollbar-width: none; /* Firefox */
        }
        #pl-mobile-home .glide__slides::-webkit-scrollbar { display: none; }

        #pl-mobile-home .glide__slide,
        #pl-mobile-home .card-news {
            scroll-snap-align: start;
            min-width: 90%;
            border-radius: 16px;
            overflow: hidden;
            position: relative;
            background: #fff;
            margin-bottom: 1rem;
            box-shadow: 0 4px 10px rgba(0,0,0,0.08);
        }

        #pl-mobile-home .card-news::after {
            content: '';
            position: absolute;
            inset: 0;
            background: linear-gradient(to top, rgba(2, 6, 23, 0.62), rgba(2, 6, 23, 0.06) 45%, rgba(2, 6, 23, 0));
            pointer-events: none;
            z-index: 1;
        }

        #pl-mobile-home .glide__slide img,
        #pl-mobile-home .card-news img {
            width: 100%;
            height: 240px;
            object-fit: cover;
            display: block;
        }

        #pl-mobile-home .slide-caption,
        #pl-mobile-home .card-news-content {
            position: absolute;
            left: 0; right: 0; bottom: 0;
            background: rgba(255, 255, 255, 0.12);
            border-top: 1px solid rgba(255, 255, 255, 0.28);
            backdrop-filter: blur(10px);
            -webkit-backdrop-filter: blur(10px);
            color: #fff;
            padding: 2rem 1rem 1rem;
            z-index: 2;
        }

        #pl-mobile-home .slide-caption,
        #pl-mobile-home .card-news-content,
        #pl-mobile-home .card-news-content h2,
        #pl-mobile-home .card-news-content p,
        #pl-mobile-home .card-news-content a {
            color: #fff !important;
        }

        #pl-mobile-home .slide-caption {
            font-size: 0.96rem;
            font-weight: 600;
            line-height: 1.3;
            font-family: 'Montserrat', sans-serif;
            text-shadow: 0 1px 2px rgba(0, 0, 0, 0.45);
        }

        #pl-mobile-home .card-news-content h2 {
            margin: 0;
            font-size: 1rem;
            font-weight: 600;
            line-height: 1.28;
            font-family: 'Montserrat', sans-serif;
            text-shadow: 0 1px 2px rgba(0, 0, 0, 0.4);
        }

        #pl-mobile-home .card-news-content h2 a { color: #fff; text-decoration: none; }

        #pl-mobile-home .mobile-news-grid {
            display: flex;
            flex-direction: column;
            gap: 0.85rem;
        }

        #pl-mobile-home .mobile-news-grid .card-news {
            margin-bottom: 0;
        }

        /* Calendário */
        #pl-mobile-home .calendar-wrap {
            border-radius: 16px;
            background: #fff;
            padding: 1rem;
            box-shadow: 0 4px 10px rgba(0,0,0,0.04);
        }

        #pl-mobile-home .calendar-head {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 1rem;
            color: #11181d;
        }

        #pl-mobile-home .calendar-head .month-name {
            font-family: 'Montserrat', sans-serif;
            font-size: 1.1rem;
            font-weight: 700;
        }

        #pl-mobile-home .calendar-head .arrow-btn {
            width: 36px; height: 36px;
            border-radius: 50px;
            border: 1px solid #e2e8f0;
            display: flex; align-items: center; justify-content: center;
            color: #334155;
        }

        #pl-mobile-home .calendar-grid {
            display: grid;
            grid-template-columns: repeat(7, 1fr);
            text-align: center;
            gap: 5px;
        }

        #pl-mobile-home .calendar-grid .day-name {
            color: #94a3b8;
            font-size: 0.8rem;
            font-weight: 700;
            padding-bottom: 0.5rem;
        }

        #pl-mobile-home .calendar-grid .day-number {
            color: #334155;
            font-size: 0.95rem;
            width: 36px; height: 36px;
            display: flex; align-items: center; justify-content: center;
            margin: 0 auto;
            border-radius: 50px;
        }

        #pl-mobile-home .calendar-grid .day-number.muted { color: #cbd5e1; }
        #pl-mobile-home .calendar-grid .day-number.today { border: 2px solid #14b8a6; color: #334155; }
        #pl-mobile-home .calendar-grid .day-number.event { background: #64748b; color: #fff; }

        #pl-mobile-home .event-featured {
            margin-top: 1rem;
            border-radius: 12px;
            background: #fff;
            box-shadow: 0 4px 10px rgba(0,0,0,0.04);
            display: flex;
            padding: 1rem;
            gap: 1rem;
        }

        #pl-mobile-home .event-featured .date-chip {
            display: flex; flex-direction: column; align-items: center; justify-content: center;
            border-right: 1px solid #e2e8f0;
            padding-right: 1rem;
            color: #006eb7;
        }

        #pl-mobile-home .event-featured .date-chip .day { font-size: 2.2rem; font-weight: 800; line-height: 1; font-family: 'Montserrat', sans-serif;}
        #pl-mobile-home .event-featured .date-chip .month { font-size: 0.9rem; font-weight: 600; text-transform: lowercase; }

        #pl-mobile-home .event-title {
            font-size: 0.98rem; font-weight: 700; color: #006eb7; margin: 0 0 0.5rem 0; line-height: 1.24;
        }

        #pl-mobile-home .event-meta { font-size: 0.82rem; color: #334155; margin: 0.24rem 0; display: flex; align-items: center; gap: 6px; line-height: 1.35;}

        /* Redes Sociais */
        #pl-mobile-home .social-header {
            display: flex; align-items: center; gap: 0.8rem;
            font-family: 'Montserrat', sans-serif;
            font-weight: 900;
            font-size: 1rem;
            color: #111;
            margin-bottom: 1rem;
            line-height: 1.2;
            overflow-wrap: anywhere;
        }

        #pl-mobile-home .social-avatar {
            width: 36px; height: 36px;
            border-radius: 8px; /* Quadrado arredondado como no print */
            background: #3b82f6;
            display: flex; align-items: center; justify-content: center;
            color: #fff; font-size: 1.1rem;
        }
    }

    @media (min-width: 768px) and (max-width: 1023px) {
        #pl-mobile-home {
            max-width: 920px;
            margin: 0 auto;
        }

        #pl-mobile-home .topbar-inner,
        #pl-mobile-home .home-hero-mobile,
        #pl-mobile-home .bg-white-section,
        #pl-mobile-home .bg-gray-section {
            padding-left: 1.5rem;
            padding-right: 1.5rem;
        }

        #pl-mobile-home .hero-title {
            font-size: clamp(2rem, 4.2vw, 2.45rem);
        }

        #pl-mobile-home .home-search-bar {
            max-width: 680px;
            margin: 0.95rem auto 0;
        }

        #pl-mobile-home .small-cards-grid {
            grid-template-columns: repeat(4, minmax(0, 1fr));
            max-width: none;
            gap: 14px;
        }

        #pl-mobile-home .small-card {
            min-height: 156px;
            padding: 1rem 0.6rem 0.85rem;
        }

        #pl-mobile-home .small-card-title {
            font-size: 0.86rem;
            line-height: 1.24;
        }

        #pl-mobile-home .glide__slide,
        #pl-mobile-home .card-news {
            border-radius: 18px;
        }

        #pl-mobile-home .glide__slide img,
        #pl-mobile-home .card-news img {
            height: 260px;
        }

        #pl-mobile-home .calendar-wrap,
        #pl-mobile-home .event-featured {
            max-width: 760px;
            margin-left: auto;
            margin-right: auto;
        }

        #pl-mobile-home .mobile-news-grid {
            display: grid;
            grid-template-columns: repeat(3, minmax(0, 1fr));
            gap: 12px;
        }

        #pl-mobile-home .mobile-news-grid .card-news {
            min-width: 0;
        }

        #pl-mobile-home .mobile-news-grid .card-news img {
            height: 340px;
        }

        #pl-mobile-home .mobile-drawer {
            top: 61px;
            max-height: min(70vh, 620px);
        }

        #pl-mobile-home .mobile-drawer-body {
            max-height: min(70vh, 620px);
        }
    }
</style>
@endsection

@section('content')
<main id="home-main" class="transition-opacity duration-300">

    @php
    $heroVideos = [ asset('videos/panorama.mp4') ];

    $sugestoesBusca = collect($sugestoesIA ?? [
    'Emitir nota fiscal eletronica',
    'Consultar protocolo digital',
    'Agendar atendimento administrativo',
    'Solicitar matricula na rede municipal',
    ])->take(3);

    $servicosPlMobile = [
        ['titulo' => 'Lista de Espera para CEMAI', 'descricao' => 'Creches municipais', 'link' => '#', 'icone' => 'fa-baby'],
        ['titulo' => 'Vagas de Emprego', 'descricao' => 'SINE/PL', 'link' => '#', 'icone' => 'fa-briefcase'],
        ['titulo' => 'Coleta de Lixo', 'descricao' => 'Horários de coleta', 'link' => '#', 'icone' => 'fa-trash-can'],
        ['titulo' => 'Concursos e Proc. Seletivos', 'descricao' => 'Editais abertos', 'link' => '#', 'icone' => 'fa-file-circle-check'],
        ['titulo' => 'Multas de Trânsito', 'descricao' => 'Consulta e recursos', 'link' => '#', 'icone' => 'fa-car-burst'],
        ['titulo' => 'IPTU', 'descricao' => 'Guias e débitos', 'link' => '#', 'icone' => 'fa-file-invoice-dollar'],
        ['titulo' => 'Iluminação Pública', 'descricao' => 'Troca de lâmpadas', 'link' => '#', 'icone' => 'fa-lightbulb'],
        ['titulo' => 'Horário de Ônibus', 'descricao' => 'Itinerários', 'link' => '#', 'icone' => 'fa-bus'],
        ['titulo' => 'Telefones Úteis', 'descricao' => 'Contatos', 'link' => '#', 'icone' => 'fa-phone'],
        ['titulo' => 'Ouvidoria', 'descricao' => 'Manifestações', 'link' => '#', 'icone' => 'fa-circle-info'],
    ];

    $navSecretarias = \App\Models\Secretaria::orderBy('nome')->get(['id', 'nome'])->map(function ($sec) {
        $sec->nome_curto = preg_replace('/^Secretaria(?:\s+Municipal)?\s+(?:de|da|do|das|dos)\s+/iu', '', $sec->nome) ?: $sec->nome;
        $nomeMenuBase = trim((string) $sec->nome_curto);

        if (in_array(mb_strtolower($nomeMenuBase), ['chefe de gabinete', 'procuradoria geral'], true)) {
            $sec->nome_menu = $nomeMenuBase;
        } else {
            $sec->nome_menu = 'Secretaria Municipal de ' . $nomeMenuBase;
        }

        return $sec;
    });

    $calendarMesParam = request()->query('mes');
    $calendarMonth = null;

    if (is_string($calendarMesParam) && preg_match('/^\d{4}-\d{2}$/', $calendarMesParam) === 1) {
        try {
            $calendarMonth = \Carbon\Carbon::createFromFormat('Y-m', $calendarMesParam)->startOfMonth();
        } catch (\Throwable $e) {
            $calendarMonth = null;
        }
    }

    $calendarMonth = ($calendarMonth ?? \Carbon\Carbon::now())->startOfMonth();
    $calendarStart = $calendarMonth->copy()->startOfWeek(\Carbon\Carbon::SUNDAY);
    $calendarEnd = $calendarMonth->copy()->endOfMonth()->endOfWeek(\Carbon\Carbon::SATURDAY);

    $eventDates = collect($eventos ?? [])
        ->filter(fn ($evento) => !empty($evento->data_inicio))
        ->map(fn ($evento) => \Carbon\Carbon::parse($evento->data_inicio)->toDateString())
        ->unique()
        ->values()
        ->all();

    $calendarDays = [];
    $cursor = $calendarStart->copy();

    while ($cursor->lte($calendarEnd)) {
        $isoDate = $cursor->toDateString();
        $calendarDays[] = [
            'day' => (int) $cursor->format('j'),
            'isCurrentMonth' => $cursor->month === $calendarMonth->month,
            'isToday' => $cursor->isToday(),
            'hasEvent' => in_array($isoDate, $eventDates, true),
        ];
        $cursor->addDay();
    }

    $calendarMesAnterior = $calendarMonth->copy()->subMonth()->format('Y-m');
    $calendarMesProximo = $calendarMonth->copy()->addMonth()->format('Y-m');
    $calendarTituloMes = mb_strtolower($calendarMonth->locale('pt_BR')->translatedFormat('F Y'));
    @endphp

    {{-- ==========================================
         MOBILE SECTION (ESTILO PEDRO LEOPOLDO)
         ========================================== --}}
    <section id="pl-mobile-home" class="lg:hidden">
        
        {{-- Top Bar --}}
        <div class="topbar">
            <div class="topbar-color-strip" aria-hidden="true"></div>
            <div class="topbar-inner">
                <div class="brand" aria-label="assai.gov.br">
                    <span class="b1">a</span><span class="b2">s</span><span class="b1">s</span><span class="b3">a</span><span class="b4">í</span><span class="gov">.gov.br</span>
                </div>
                <button type="button" class="menu-mobile-btn" id="mobile-menu-trigger" aria-label="Abrir menu" aria-expanded="false" aria-controls="mobile-drawer-nav">
                    Menu
                    <i class="fa-solid fa-bars icon-open" aria-hidden="true"></i>
                    <span class="icon-close" aria-hidden="true">X</span>
                </button>
            </div>
        </div>

        <aside class="mobile-drawer" id="mobile-drawer-nav" aria-hidden="true" aria-label="Menu principal mobile">
            <nav class="mobile-drawer-body" aria-label="Links principais">
                <ul class="mobile-nav-list">
                    <li><a class="mobile-nav-link" href="{{ route('home') }}">Início</a></li>

                    <li class="mobile-nav-group">
                        <button type="button" class="mobile-nav-toggle" data-submenu-target="submenu-a-cidade" aria-expanded="false">
                            <span>A Cidade</span>
                            <i class="fa-solid fa-chevron-down caret" aria-hidden="true"></i>
                        </button>
                        <ul class="mobile-submenu" id="submenu-a-cidade">
                            <li><a class="mobile-submenu-link" href="{{ route('pages.sobre') }}">História e Perfil</a></li>
                            <li><a class="mobile-submenu-link" href="{{ route('pages.turismo') }}">Turismo</a></li>
                        </ul>
                    </li>

                    <li class="mobile-nav-group">
                        <button type="button" class="mobile-nav-toggle" data-submenu-target="submenu-secretarias" aria-expanded="false">
                            <span>Secretarias</span>
                            <i class="fa-solid fa-chevron-down caret" aria-hidden="true"></i>
                        </button>
                        <ul class="mobile-submenu" id="submenu-secretarias">
                            <li><a class="mobile-submenu-link" href="{{ route('secretarias.index') }}">Todas as Secretarias</a></li>
                            @foreach($navSecretarias as $sec)
                            <li>
                                <a class="mobile-submenu-link" href="{{ route('secretarias.show', $sec->id) }}" title="{{ $sec->nome_menu }}">
                                    {{ $sec->nome_menu }}
                                </a>
                            </li>
                            @endforeach
                        </ul>
                    </li>

                    <li><a class="mobile-nav-link" href="https://assai.atende.net/subportal/ouvidoria" target="_blank" rel="noopener noreferrer">Ouvidoria</a></li>
                    <li><a class="mobile-nav-link" href="{{ route('pages.transparencia') }}" target="_blank" rel="noopener noreferrer">Transparência</a></li>
                    <li><a class="mobile-nav-link" href="https://gov.assai.pr.gov.br/cpf-check" target="_blank" rel="noopener noreferrer">Entrar no Gov.Assaí</a></li>
                </ul>
            </nav>
        </aside>

        {{-- Hero --}}
        <div class="home-hero-mobile">
            <div class="home-hero-content">
                <h1 class="hero-title">O QUE VOCÊ <strong>PRECISA?</strong></h1>
                <form action="{{ route('busca.index') }}" method="GET" class="home-search-bar" role="search">
                    <input class="wp-block-search__input" type="search" name="q" placeholder="Horário ônibus" required>
                    <button class="wp-block-search__button" type="submit" aria-label="Pesquisar">
                        <i class="fa-solid fa-magnifying-glass" aria-hidden="true"></i>
                    </button>
                </form>
            </div>
        </div>

        {{-- Mais Acessados --}}
        <section class="bg-white-section">
            <h2 class="section-title">Mais Acessados</h2>
            <div class="small-cards-grid">
                @if(isset($servicos) && $servicos->count() > 0)
                @foreach($servicos->take(8) as $servicoItem)
                <a href="{{ $servicoItem->url_acesso ?? $servicoItem->link ?? '#' }}" class="small-card" target="_blank" rel="noopener">
                    <span class="helper-dot">?</span>
                    @php
                    $iconeServico = !empty($servicoItem->icone)
                    ? str_replace(['fa-', 'fas ', 'fa-solid '], '', $servicoItem->icone)
                    : 'file-lines';
                    @endphp
                    <i class="fa-solid fa-{{ $iconeServico }} service-icon" aria-hidden="true"></i>
                    <h4 class="small-card-title">{{ $servicoItem->titulo }}</h4>
                </a>
                @endforeach
                @else
                @foreach(collect($servicosPlMobile)->take(8) as $servicoItem)
                <a href="{{ $servicoItem['link'] }}" class="small-card" target="_blank" rel="noopener">
                    <span class="helper-dot">?</span>
                    <i class="fa-solid {{ $servicoItem['icone'] }} service-icon" aria-hidden="true"></i>
                    <h4 class="small-card-title">{{ $servicoItem['titulo'] }}</h4>
                </a>
                @endforeach
                @endif
            </div>
            <div class="all-btn-wrapper">
                <a href="{{ route('servicos.index') }}" class="all-btn">
                    <i class="fa-solid fa-table-cells-large" aria-hidden="true"></i> Ver Todos Serviços
                </a>
            </div>
        </section>

        {{-- Fique Ligado --}}
        <section class="bg-gray-section">
            <h2 class="section-title">Fique ligado</h2>
            @if(isset($programas) && $programas->count() > 0)
            <div class="glide__slides">
                @foreach($programas->take(3) as $programa)
                <a href="{{ $programa->link ?? '#' }}" class="glide__slide">
                    <img src="{{ $programa->imagem ? asset('storage/' . $programa->imagem) : asset('img/Assaí.jpg') }}" alt="" loading="lazy">
                    <span class="slide-caption">{{ Str::limit(ucfirst(Str::lower($programa->titulo)), 66) }}</span>
                </a>
                @endforeach
            </div>
            <div class="flex justify-center gap-2 mt-4">
                <div class="w-2.5 h-2.5 rounded-full bg-slate-500"></div>
                <div class="w-2.5 h-2.5 rounded-full border border-slate-400"></div>
                <div class="w-2.5 h-2.5 rounded-full border border-slate-400"></div>
            </div>
            @endif
        </section>

        {{-- Últimas Notícias --}}
        <section class="bg-gray-section" style="padding-top: 0;">
            <h2 class="section-title">Últimas Notícias</h2>
            <div class="mobile-news-grid">
                @if(isset($noticias))
                @foreach($noticias->take(3) as $noticia)
                <article class="card-news">
                    <a href="{{ route('noticias.show', $noticia->slug) }}">
                        <img src="{{ $noticia->imagem_capa ? asset('storage/' . $noticia->imagem_capa) : asset('img/Assaí.jpg') }}" alt="" loading="lazy">
                        <div class="card-news-content">
                            <h2>{{ ucfirst(Str::lower($noticia->titulo)) }}</h2>
                        </div>
                    </a>
                </article>
                @endforeach
                @endif
            </div>
            <div class="all-btn-wrapper">
                <a href="{{ route('noticias.index') }}" class="all-btn">
                    <i class="fa-regular fa-newspaper" aria-hidden="true"></i> Ver Todas Notícias
                </a>
            </div>
        </section>

        {{-- Calendário --}}
        <section class="bg-gray-section">
            <h2 class="section-title">Calendário de Eventos</h2>
            
            <div class="calendar-wrap">
                <div class="calendar-head">
                    <a href="{{ route('home', ['mes' => $calendarMesAnterior]) }}" class="arrow-btn" aria-label="Mês anterior"><i class="fa-solid fa-chevron-left" aria-hidden="true"></i></a>
                    <span class="month-name">{{ $calendarTituloMes }}</span>
                    <a href="{{ route('home', ['mes' => $calendarMesProximo]) }}" class="arrow-btn" aria-label="Próximo mês"><i class="fa-solid fa-chevron-right" aria-hidden="true"></i></a>
                </div>
                <div class="calendar-grid">
                    <span class="day-name">D</span><span class="day-name">S</span><span class="day-name">T</span><span class="day-name">Q</span><span class="day-name">Q</span><span class="day-name">S</span><span class="day-name">S</span>
                    @foreach($calendarDays as $calendarDay)
                    @php
                    $calendarClasses = 'day-number';
                    if (!$calendarDay['isCurrentMonth']) {
                        $calendarClasses .= ' muted';
                    }
                    if ($calendarDay['isToday']) {
                        $calendarClasses .= ' today';
                    }
                    if ($calendarDay['hasEvent']) {
                        $calendarClasses .= ' event';
                    }
                    @endphp
                    <span class="{{ $calendarClasses }}">{{ $calendarDay['day'] }}</span>
                    @endforeach
                </div>
            </div>

            @if(isset($eventos) && $eventos->count() > 0)
            @foreach($eventos->take(2) as $eventoItem)
            <div class="event-featured">
                <div class="date-chip">
                    <span class="day">{{ \Carbon\Carbon::parse($eventoItem->data_inicio)->format('d') }}</span>
                    <span class="month">{{ \Carbon\Carbon::parse($eventoItem->data_inicio)->translatedFormat('M') }}</span>
                </div>
                <div>
                    <h3 class="event-title">{{ $eventoItem->titulo }}</h3>
                    <p class="event-meta"><i class="fa-solid fa-clock"></i> {{ \Carbon\Carbon::parse($eventoItem->data_inicio)->format('d \\d\\e F \\à\\s H:i') }}</p>
                    <p class="event-meta"><i class="fa-solid fa-location-dot"></i> {{ $eventoItem->local ?? 'Assaí, PR' }}</p>
                </div>
            </div>
            @endforeach
            @endif

            <div class="all-btn-wrapper">
                <a href="{{ route('agenda.index') }}" class="all-btn">Ver todos os Eventos</a>
            </div>
        </section>
    </section>

    {{-- ==========================================
         DESKTOP SECTION (MANTIDO INTACTO)
         ========================================== --}}
    <section id="hero-oficial" class="hidden lg:block relative w-full overflow-hidden bg-slate-950">

        {{-- 1. Camada de Fundo --}}
        <div class="absolute inset-0 z-0 pointer-events-none overflow-hidden bg-slate-950">
            <video id="hero-video-lazy"
                class="hero-video-layer absolute inset-0 w-full h-full object-cover opacity-0 transition-opacity duration-1000"
                autoplay muted loop playsinline preload="none">
                <source data-src="{{ asset('videos/panorama.mp4') }}" type="video/mp4">
            </video>
        </div>

        {{-- 2. Camada de Contraste (Sombra) --}}
        <div class="absolute inset-0 z-10 pointer-events-none" style="background-color: rgba(2, 6, 23, 0.70) !important; opacity: 1 !important;"></div>

        <div id="hero-video-loader" class="fixed inset-0 z-[120] flex items-center justify-center bg-gradient-to-b from-slate-950 via-blue-950 to-slate-900 text-white transition-opacity duration-500" aria-live="polite">
            <div class="flex flex-col items-center gap-5 px-6 text-center">
                <img src="{{ asset('img/logo_branca.png') }}" alt="Prefeitura de Assaí" loading="eager" decoding="sync" fetchpriority="high" class="w-56 max-w-[80vw] h-auto object-contain">
                <div class="flex items-center gap-3 text-xs sm:text-sm font-semibold tracking-[0.18em] uppercase text-blue-100">
                    <span class="inline-block h-5 w-5 rounded-full border-2 border-white/35 border-t-white animate-spin" aria-hidden="true"></span>
                    Preparando experiência
                </div>
            </div>
        </div>

        {{-- 3. Camada de Conteúdo Interativo --}}
        <div class="relative z-30 w-full flex flex-col items-center justify-center pt-24 pb-20 md:pt-[196px] md:pb-[160px] px-4 sm:px-6 h-full">

            {{-- Banners Dinâmicos (Swiper) --}}
            <div class="w-full max-w-5xl flex flex-col justify-center">
                @if(isset($banners) && $banners->count() > 0)
                <div class="swiper swiper-hero-banners w-full">
                    <div class="swiper-wrapper">
                        @foreach($banners as $banner)
                        <div class="swiper-slide bg-transparent flex flex-col items-center text-center justify-center px-1">
                            <h2 class="w-full max-w-4xl mx-auto mb-2 sm:mb-4 text-lg sm:text-3xl md:text-5xl max-[360px]:text-base font-extrabold text-white break-words drop-shadow-lg font-heading leading-tight text-center">
                                {{ $banner->titulo }}
                            </h2>
                            @if($banner->subtitulo)
                            <p class="w-full max-w-2xl mx-auto mt-1 mb-5 text-xs sm:text-base md:text-lg font-medium text-blue-100 break-words drop-shadow font-sans max-[360px]:hidden line-clamp-3 leading-relaxed text-center">
                                {{ $banner->subtitulo }}
                            </p>
                            @endif
                            @if($banner->link)
                            <a href="{{ $banner->link }}" class="inline-flex items-center px-6 py-2.5 text-sm md:text-base font-bold bg-blue-600 hover:bg-blue-500 text-white rounded-full transition-all shadow-lg hover:-translate-y-0.5 font-heading">
                                Saiba mais
                                <svg class="w-5 h-5 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M14 5l7 7m0 0l-7 7m7-7H3"></path>
                                </svg>
                            </a>
                            @endif
                        </div>
                        @endforeach
                    </div>
                </div>

                {{-- Barra de Pesquisa Fixa --}}
                <div class="w-full max-w-3xl mx-auto mt-10 md:mt-14 shrink-0">
                    <form action="{{ route('busca.index') }}" method="GET" onsubmit="return this.q.value.trim() !== ''" class="relative flex items-center w-full bg-white/95 focus-within:bg-white backdrop-blur-md shadow-2xl rounded-full border border-white/60 transition-all duration-300 p-1" role="search">
                        <label for="busca-portal-fixo" class="sr-only">Buscar no portal</label>
                        <div class="flex items-center justify-center pl-4 md:pl-5 pr-2 text-slate-400 shrink-0 hidden md:flex" aria-hidden="true">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                            </svg>
                        </div>
                        <input id="busca-portal-fixo" type="text" name="q" placeholder="O que você procura?" required class="flex-1 min-w-0 px-3 py-2.5 text-sm text-gray-800 bg-transparent border-none md:px-2 md:py-4 md:text-base focus:ring-0 focus:outline-none font-sans placeholder:text-slate-400 w-full">
                        <button type="submit" class="m-1.5 px-3.5 max-[360px]:px-3 py-2.5 max-[360px]:py-2 font-bold text-sm text-blue-900 transition-all bg-yellow-400 rounded-full shrink-0 md:px-6 md:py-3 hover:bg-yellow-500 hover:shadow-lg font-heading">
                            Buscar
                        </button>
                    </form>

                    @if($sugestoesBusca->count() > 0)
                    <div class="flex flex-wrap items-center justify-center gap-2 mt-3 md:mt-4 max-w-xs sm:max-w-2xl lg:max-w-4xl px-2 sm:px-4 mx-auto">
                        @foreach($sugestoesBusca as $sugestao)
                        <a href="{{ route('busca.index', ['q' => $sugestao]) }}" class="inline-flex items-center gap-1.5 px-3 py-1.5 text-[11px] sm:text-xs font-semibold text-white cursor-pointer select-none transition-all duration-200 bg-white/10 border border-white/25 backdrop-blur-sm rounded-full hover:bg-blue-600 hover:text-white hover:border-transparent hover:shadow-md active:scale-95 focus:outline-none focus:ring-2 focus:ring-white/60 font-sans whitespace-nowrap">
                            <svg class="w-3 h-3 opacity-70" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" /></svg>
                            {{ $sugestao }}
                        </a>
                        @endforeach
                    </div>
                    @endif
                </div>
                @else
                {{-- Fallback Estático Melhorado --}}
                <div class="text-center flex flex-col items-center justify-center">
                    <span class="inline-flex items-center px-4 py-1.5 rounded-full bg-white/20 backdrop-blur-sm text-white text-[10px] md:text-xs font-bold uppercase tracking-widest mb-6 border border-white/30 shadow-sm">Portal Oficial</span>
                    <h2 class="mb-3 text-2xl sm:text-3xl md:text-5xl max-[360px]:text-[1.6rem] font-extrabold text-white drop-shadow-md font-heading leading-tight max-w-4xl mx-auto text-center break-words">Prefeitura de <span class="text-yellow-400">Assaí</span></h2>
                    <p class="text-sm sm:text-base md:text-lg text-slate-100 font-medium max-w-3xl mx-auto drop-shadow-md mb-4 leading-relaxed text-center">Acesse serviços públicos, acompanhe ações da Prefeitura e encontre informações oficiais com rapidez.</p>
                    <a href="{{ route('busca.index') }}" class="inline-flex items-center px-6 py-2.5 mb-10 text-sm md:text-base font-bold bg-blue-600 hover:bg-blue-500 text-white rounded-full transition-all shadow-lg hover:-translate-y-0.5 font-heading mx-auto">Saiba mais<svg class="w-5 h-5 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg></a>
                </div>
                @endif
            </div>

        </div>

        {{-- Indicador de rolagem --}}
        <div class="absolute bottom-6 md:bottom-10 left-1/2 -translate-x-1/2 z-30 flex flex-col items-center">
            <span class="hidden md:block mb-3 text-[10px] font-bold tracking-[0.2em] text-white/70 uppercase">Role para explorar</span>
            <a href="#noticias" class="inline-flex items-center justify-center w-10 h-10 md:w-12 md:h-12 text-white transition-all duration-300 border border-white/20 rounded-full bg-white/10 backdrop-blur-md hover:bg-white/20 hover:scale-110 animate-bounce focus:outline-none focus:ring-2 focus:ring-yellow-400 shadow-lg"><svg class="w-5 h-5 md:w-6 md:h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 14l-7 7m0 0l-7-7m7 7V3"></path></svg></a>
        </div>
    </section>

    {{-- 3. NOTÍCIAS (DESKTOP) --}}
    <section id="noticias" class="hidden lg:block py-16 bg-[#f3f8ff] scroll-mt-20 md:scroll-mt-24">
        <div class="container px-4 mx-auto max-w-6xl font-sans">
            <div class="flex flex-col items-center mb-12 text-center">
                <h2 class="text-2xl font-extrabold text-blue-900 sm:text-3xl font-heading uppercase tracking-tight">Últimas Notícias</h2>
                <div class="w-10 h-1 mt-3 bg-yellow-400"></div>
            </div>

            @if(isset($noticias) && $noticias->count() > 0)
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 lg:gap-8 justify-center">
                @foreach($noticias->take(3) as $noticia)
                <article class="relative h-[350px] md:h-[430px] overflow-hidden rounded-2xl group bg-slate-100 shadow-md hover:shadow-xl transition-shadow duration-300">
                    <a href="{{ route('noticias.show', $noticia->slug) }}" class="block w-full h-full outline-none focus-within:ring-4 focus-within:ring-blue-500 focus-within:ring-inset">
                        <img src="{{ $noticia->imagem_capa ? asset('storage/' . $noticia->imagem_capa) : asset('img/Assaí.jpg') }}" alt="" class="absolute inset-0 object-cover w-full h-full transition-transform duration-700 ease-out group-hover:scale-110" loading="lazy" decoding="async">
                        <div class="absolute inset-0 bg-gradient-to-t from-black/80 via-black/20 to-transparent opacity-80"></div>
                        <div class="absolute bottom-0 left-0 w-full p-5 lg:p-6 bg-white/10 backdrop-blur-lg border-t border-white/30 flex flex-col justify-end transition-all duration-500">
                            <h3 class="text-sm sm:text-base font-bold leading-snug text-white font-heading drop-shadow-md">{{ ucfirst(Str::lower($noticia->titulo)) }}</h3>
                            <div class="grid grid-rows-[0fr] group-hover:grid-rows-[1fr] transition-all duration-500 ease-in-out mt-2">
                                <div class="overflow-hidden opacity-0 group-hover:opacity-100 transition-opacity duration-500 delay-100">
                                    <p class="pt-2 text-[13px] leading-relaxed text-gray-100 font-sans line-clamp-4 lg:line-clamp-5 mb-4">{{ $noticia->resumo ?? Str::limit(strip_tags($noticia->conteudo), 160) }}</p>
                                    <div class="flex items-center justify-between border-t border-white/20 pt-4">
                                        <span class="text-[10px] font-bold text-yellow-400 uppercase tracking-widest drop-shadow-sm">Ler mais</span>
                                        <time class="text-[10px] font-medium text-gray-300">{{ \Carbon\Carbon::parse($noticia->data_publicacao)->format('d/m/Y') }}</time>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </a>
                </article>
                @endforeach
            </div>
            <div class="mt-12 text-center">
                <a href="{{ route('noticias.index') }}" class="inline-flex items-center gap-3 px-10 py-4 text-sm font-bold text-white transition-all bg-blue-800 rounded-full shadow-xl hover:bg-blue-900 hover:shadow-2xl hover:-translate-y-1 group">
                    <i class="fas fa-newspaper transition-transform group-hover:rotate-12"></i> Ver todas as Notícias
                </a>
            </div>
            @endif
        </div>
    </section>

    {{-- 4. SERVIÇOS (DESKTOP) --}}
    <section id="servicos-desktop" class="hidden lg:block py-12 md:py-20 bg-[#e1eeff] border-t border-blue-200/70 scroll-mt-20">
        <div class="container px-4 mx-auto max-w-6xl font-sans">
            <div class="flex flex-col items-center mb-12 text-center">
                <h2 class="text-2xl font-extrabold text-blue-900 sm:text-3xl font-heading uppercase tracking-tight">Acesso Rápido</h2>
                <div class="w-10 h-1 mt-3 bg-yellow-400"></div>
            </div>

            @if(isset($servicos) && $servicos->count() > 0)
            <div class="grid grid-cols-2 md:grid-cols-4 gap-4 md:gap-6">
                @foreach($servicos as $servico)
                <a href="{{ $servico->url_acesso ?? $servico->link ?? '#' }}" target="_blank" rel="noopener" class="flex flex-col items-center justify-center p-6 md:p-8 bg-white border border-slate-200 rounded-2xl hover:border-emerald-500 hover:shadow-md transition-all group outline-none focus-visible:ring-2 focus-visible:ring-emerald-400 text-center">
                    <div class="text-emerald-600 mb-4 transition-transform group-hover:scale-110 duration-300">
                        @if(!empty($servico->icone))
                        <i class="fa-solid fa-{{ str_replace(['fa-', 'fas ', 'fa-solid '], '', $servico->icone) }} text-4xl" aria-hidden="true"></i>
                        @else
                        <svg class="w-10 h-10 md:w-12 md:h-12" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                        @endif
                    </div>
                    <h3 class="text-sm font-bold text-slate-700 font-heading leading-snug group-hover:text-emerald-700 transition-colors">{{ $servico->titulo }}</h3>
                </a>
                @endforeach
            </div>
            <div class="mt-12 text-center">
                <a href="{{ route('servicos.index') }}" class="inline-flex items-center gap-3 px-10 py-4 text-sm font-bold text-white transition-all bg-blue-800 rounded-full shadow-xl hover:bg-blue-900 hover:shadow-2xl hover:-translate-y-1 group">
                    <i class="fas fa-bolt transition-transform group-hover:rotate-12"></i> Ver todos os Serviços
                </a>
            </div>
            @endif
        </div>
    </section>

    {{-- 5. AGENDA (DESKTOP) --}}
    <section id="agenda-desktop" class="hidden lg:block py-12 md:py-20 bg-[#edf5ff] border-t border-blue-100/70 scroll-mt-20">
        <div class="container px-4 mx-auto max-w-6xl font-sans">
            <div class="flex flex-col items-center mb-12 text-center">
                <h2 class="text-2xl font-extrabold text-blue-900 sm:text-3xl font-heading uppercase tracking-tight">Eventos</h2>
                <div class="w-10 h-1 mt-3 bg-yellow-400"></div>
            </div>

            @if(isset($eventos) && $eventos->count() > 0)
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-4 md:gap-6">
                @foreach($eventos as $evento)
                <a href="{{ route('agenda.show', $evento->id ?? '#') }}" class="flex bg-white border border-slate-200 rounded-xl overflow-hidden hover:shadow-md hover:border-blue-300 transition-all duration-300 group outline-none focus-visible:ring-2 focus-visible:ring-blue-400">
                    <div class="flex flex-col items-center justify-center w-24 md:w-28 bg-blue-900 text-white shrink-0 group-hover:bg-blue-800 transition-colors border-r-4 border-yellow-400">
                        <span class="text-[10px] md:text-xs font-bold uppercase tracking-widest opacity-80 mb-0.5">{{ \Carbon\Carbon::parse($evento->data_inicio)->translatedFormat('M') }}</span>
                        <span class="text-3xl md:text-4xl font-black leading-none">{{ \Carbon\Carbon::parse($evento->data_inicio)->format('d') }}</span>
                    </div>
                    <div class="p-4 md:p-5 flex flex-col justify-center min-w-0 flex-1">
                        <h3 class="text-[15px] md:text-base font-bold text-slate-800 font-heading leading-snug line-clamp-2 mb-3 group-hover:text-blue-700 transition-colors">{{ $evento->titulo }}</h3>
                        <div class="flex flex-col sm:flex-row sm:items-center gap-2 sm:gap-4 text-xs font-medium text-slate-500">
                            <span class="flex items-center gap-1.5"><svg class="w-3.5 h-3.5 text-slate-400 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>{{ \Carbon\Carbon::parse($evento->data_inicio)->format('H:i') }}</span>
                            <span class="flex items-center gap-1.5 truncate"><svg class="w-3.5 h-3.5 text-slate-400 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path></svg><span class="truncate">{{ $evento->local ?? 'Assaí, PR' }}</span></span>
                        </div>
                    </div>
                </a>
                @endforeach
            </div>
            <div class="mt-12 text-center">
                <a href="{{ route('agenda.index') }}" class="inline-flex items-center gap-3 px-10 py-4 text-sm font-bold text-white transition-all bg-blue-800 rounded-full shadow-xl hover:bg-blue-900 hover:shadow-2xl hover:-translate-y-1 group">
                    <i class="fas fa-calendar-alt transition-transform group-hover:rotate-12" aria-hidden="true"></i> Ver todos os Eventos
                </a>
            </div>
            @endif
        </div>
    </section>

    {{-- 6. PROGRAMAS E AÇÕES (DESKTOP) --}}
    <section id="programas-desktop" class="hidden lg:block py-16 md:py-24 bg-[#dbeaff] border-t border-blue-200/70 scroll-mt-20">
        <div class="container px-4 mx-auto max-w-6xl font-sans">
            <div class="flex flex-col items-center mb-12 md:mb-16 text-center">
                <h2 class="text-2xl font-extrabold text-blue-900 sm:text-3xl font-heading uppercase tracking-tight">Programas e Ações</h2>
                <div class="w-10 h-1 mt-3 bg-yellow-400"></div>
            </div>

            @if(isset($programas) && $programas->count() > 0)
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                @foreach($programas as $programa)
                <a href="{{ $programa->link ?? '#' }}" class="relative group h-64 md:h-72 rounded-3xl overflow-hidden shadow-md hover:shadow-xl transition-all duration-300 hover:-translate-y-1.5 outline-none focus-visible:ring-4 focus-visible:ring-blue-500">
                    <img src="{{ $programa->imagem ? asset('storage/' . $programa->imagem) : asset('img/Assaí.jpg') }}" class="absolute inset-0 w-full h-full object-cover transition-transform duration-700 group-hover:scale-105" alt="Imagem do programa {{ $programa->titulo }}">
                    <div class="absolute inset-0 bg-gradient-to-t from-blue-950/60 to-transparent opacity-60 group-hover:opacity-80 transition-opacity duration-300"></div>
                    <div class="absolute bottom-3 left-3 right-3 md:bottom-4 md:left-4 md:right-4 py-2.5 px-3.5 md:py-3 md:px-4 bg-blue-950/85 backdrop-blur-md rounded-xl border border-white/10 flex items-center justify-between gap-3 group-hover:bg-blue-900/95 transition-colors shadow-lg">
                        <h3 class="text-xs md:text-sm font-bold text-white font-heading leading-tight group-hover:text-yellow-300 transition-colors line-clamp-2 flex-1">{{ $programa->titulo }}</h3>
                        <div class="w-7 h-7 md:w-8 md:h-8 shrink-0 rounded-full bg-white/10 flex items-center justify-center text-white group-hover:bg-yellow-400 group-hover:text-blue-900 transition-colors">
                            <svg class="w-3.5 h-3.5 md:w-4 md:h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                        </div>
                    </div>
                </a>
                @endforeach
            </div>
            <div class="mt-14 text-center">
                <a href="{{ route('programas.index') }}" class="inline-flex items-center gap-3 px-10 py-4 text-sm font-bold text-white transition-all bg-blue-800 rounded-full shadow-xl hover:bg-blue-900 hover:shadow-2xl hover:-translate-y-1 group">
                    <svg class="w-5 h-5 transition-transform group-hover:-translate-y-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path></svg> Ver todos os Programas
                </a>
            </div>
            @endif
        </div>
    </section>
</main>

<script>
    (function () {
        const root = document.getElementById('pl-mobile-home');
        const trigger = document.getElementById('mobile-menu-trigger');
        const drawer = document.getElementById('mobile-drawer-nav');
        const toggles = drawer ? drawer.querySelectorAll('.mobile-nav-toggle') : [];

        if (!root || !trigger || !drawer) {
            return;
        }

        const closeAllSubmenus = () => {
            drawer.querySelectorAll('.mobile-nav-group.open').forEach((group) => {
                group.classList.remove('open');
                const btn = group.querySelector('.mobile-nav-toggle');
                if (btn) {
                    btn.setAttribute('aria-expanded', 'false');
                }
            });
        };

        const setMenuState = (isOpen) => {
            root.classList.toggle('menu-open', isOpen);
            trigger.setAttribute('aria-expanded', isOpen ? 'true' : 'false');
            drawer.setAttribute('aria-hidden', isOpen ? 'false' : 'true');

            if (!isOpen) {
                closeAllSubmenus();
            }
        };

        const openMenu = () => setMenuState(true);
        const closeMenu = () => setMenuState(false);
        const toggleMenu = () => setMenuState(!root.classList.contains('menu-open'));

        trigger.addEventListener('click', toggleMenu);

        toggles.forEach((btn) => {
            btn.addEventListener('click', () => {
                const group = btn.closest('.mobile-nav-group');
                if (!group) {
                    return;
                }

                const willOpen = !group.classList.contains('open');
                closeAllSubmenus();

                if (willOpen) {
                    group.classList.add('open');
                    btn.setAttribute('aria-expanded', 'true');
                }
            });
        });

        drawer.querySelectorAll('a').forEach((link) => {
            link.addEventListener('click', closeMenu);
        });

        document.addEventListener('click', (event) => {
            if (!root.classList.contains('menu-open')) {
                return;
            }

            const clickedInsideMenu = drawer.contains(event.target);
            const clickedTrigger = trigger.contains(event.target);

            if (!clickedInsideMenu && !clickedTrigger) {
                closeMenu();
            }
        });

        document.addEventListener('keydown', (event) => {
            if (event.key === 'Escape' && root.classList.contains('menu-open')) {
                closeMenu();
            }
        });
    })();
</script>
@endsection