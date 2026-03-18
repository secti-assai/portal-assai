@extends('layouts.admin')

@section('content')
    {{-- ===== HEADER ===== --}}
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3 mb-8">
        <div>
            <h1 class="text-3xl font-bold text-slate-800">Visão Geral</h1>
            <p class="mt-1 text-slate-500">Painel de inteligência e monitoramento do portal · {{ \Carbon\Carbon::now()->isoFormat('D [de] MMMM [de] YYYY') }}</p>
        </div>
        <span class="inline-flex items-center gap-1.5 rounded-full bg-emerald-50 px-3 py-1 text-xs font-semibold text-emerald-700 ring-1 ring-emerald-200">
            <span class="h-2 w-2 rounded-full bg-emerald-500 animate-pulse"></span>
            Sistema online
        </span>
    </div>

    {{-- ===== LINHA 1: KPIs ===== --}}
    <div class="grid grid-cols-1 gap-6 mb-8 md:grid-cols-2 lg:grid-cols-4">

        {{-- KPI Notícias --}}
        <div class="bg-white border-l-4 border-l-blue-600 shadow-sm rounded-xl p-6 flex items-center gap-5">
            <div class="flex-shrink-0 p-3 rounded-lg bg-blue-50 text-blue-600">
                <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9.5a2 2 0 00-2-2h-2"/></svg>
            </div>
            <div>
                <p class="text-sm font-medium text-slate-500">Notícias publicadas</p>
                <p class="text-3xl font-black text-slate-800 leading-tight">{{ $totalNoticias }}</p>
            </div>
        </div>

        {{-- KPI Eventos Ativos --}}
        <div class="bg-white border-l-4 border-l-amber-500 shadow-sm rounded-xl p-6 flex items-center gap-5">
            <div class="flex-shrink-0 p-3 rounded-lg bg-amber-50 text-amber-500">
                <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
            </div>
            <div>
                <p class="text-sm font-medium text-slate-500">Eventos futuros ativos</p>
                <p class="text-3xl font-black text-slate-800 leading-tight">{{ $totalEventosAtivos }}</p>
            </div>
        </div>

        {{-- KPI Serviços --}}
        <div class="bg-white border-l-4 border-l-emerald-500 shadow-sm rounded-xl p-6 flex items-center gap-5">
            <div class="flex-shrink-0 p-3 rounded-lg bg-emerald-50 text-emerald-600">
                <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/></svg>
            </div>
            <div>
                <p class="text-sm font-medium text-slate-500">Serviços ativos</p>
                <p class="text-3xl font-black text-slate-800 leading-tight">{{ $totalServicos }}</p>
            </div>
        </div>

        {{-- KPI Alertas --}}
        <div class="bg-white border-l-4 border-l-red-600 shadow-sm rounded-xl p-6 flex items-center gap-5">
            <div class="flex-shrink-0 p-3 rounded-lg bg-red-50 text-red-600">
                <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg>
            </div>
            <div>
                <p class="text-sm font-medium text-slate-500">Alertas ativos</p>
                <p class="text-3xl font-black text-slate-800 leading-tight">{{ $totalAlertas }}</p>
            </div>
        </div>

    </div>

    <div class="grid grid-cols-1 gap-8 mb-8 xl:grid-cols-3">

        <div class="xl:col-span-2 space-y-8">
            @can('gerir servicos')
            {{-- TOP SERVIÇOS (span 2) --}}
            <div class="bg-white shadow-sm rounded-xl border border-slate-200 overflow-hidden">
                <div class="flex items-center justify-between px-6 py-4 border-b border-slate-100">
                    <div class="flex items-center gap-2">
                        <svg class="w-5 h-5 text-orange-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/></svg>
                        <h2 class="text-base font-bold text-slate-800">Top 5 Serviços Mais Acessados</h2>
                    </div>
                    <a href="{{ route('admin.servicos.index') }}" class="text-xs font-medium text-blue-600 hover:underline">Ver todos</a>
                </div>
                <div class="overflow-x-auto">
                    <table class="min-w-full text-sm">
                        <thead>
                            <tr class="bg-slate-50 text-slate-500 text-xs font-semibold uppercase tracking-wide">
                                <th class="px-6 py-3 text-left">#</th>
                                <th class="px-6 py-3 text-left">Serviço</th>
                                <th class="px-6 py-3 text-left">Link destino</th>
                                <th class="px-6 py-3 text-right">Acessos</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100">
                            @forelse($topServicos as $index => $servico)
                            <tr class="hover:bg-slate-50 transition-colors">
                                <td class="px-6 py-3 text-slate-400 font-mono">{{ $index + 1 }}</td>
                                <td class="px-6 py-3 font-medium text-slate-800">{{ $servico->titulo }}</td>
                                <td class="px-6 py-3 text-slate-400 max-w-[180px]">
                                    <span class="block truncate" title="{{ $servico->url_acesso }}">{{ $servico->url_acesso }}</span>
                                </td>
                                <td class="px-6 py-3 text-right">
                                    <span class="inline-block rounded-full bg-orange-50 text-orange-700 font-bold text-xs px-3 py-1">
                                        {{ number_format($servico->acessos, 0, ',', '.') }}
                                    </span>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="4" class="px-6 py-8 text-center text-slate-400 text-sm">
                                    Nenhum acesso registrado ainda.
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
            @endcan

            {{-- ===== LINHA 2: ANALYTICS + ATIVIDADE RECENTE ===== --}}
            <div class="grid grid-cols-1 gap-8 md:grid-cols-2">

                {{-- ÚLTIMAS NOTÍCIAS --}}
                <div class="bg-white shadow-sm rounded-xl border border-slate-200 overflow-hidden">
                    <div class="flex items-center justify-between px-6 py-4 border-b border-slate-100">
                        <div class="flex items-center gap-2">
                            <svg class="w-5 h-5 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"/></svg>
                            <h2 class="text-base font-bold text-slate-800">Notícias Recentes</h2>
                        </div>
                        <a href="{{ route('admin.noticias.index') }}" class="text-xs font-medium text-blue-600 hover:underline">Ver todas</a>
                    </div>
                    <ul class="divide-y divide-slate-100">
                        @forelse($ultimasNoticias as $noticia)
                        <li class="px-6 py-4 hover:bg-slate-50 transition-colors">
                            <p class="text-sm font-semibold text-slate-700 line-clamp-2 mb-1">{{ $noticia->titulo }}</p>
                            <p class="text-xs text-slate-400">{{ $noticia->created_at->diffForHumans() }}</p>
                        </li>
                        @empty
                        <li class="px-6 py-8 text-center text-slate-400 text-sm">
                            Nenhuma notícia publicada ainda.
                        </li>
                        @endforelse
                    </ul>
                </div>

                {{-- PRÓXIMOS EVENTOS --}}
                <div class="bg-white shadow-sm rounded-xl border border-slate-200 overflow-hidden">
                    <div class="flex items-center justify-between px-6 py-4 border-b border-slate-100">
                        <div class="flex items-center gap-2">
                            <svg class="w-5 h-5 text-amber-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                            <h2 class="text-base font-bold text-slate-800">Próximos Eventos</h2>
                        </div>
                        <a href="{{ route('admin.eventos.index') }}" class="text-xs font-medium text-blue-600 hover:underline">Ver todos</a>
                    </div>
                    <ul class="divide-y divide-slate-100">
                        @forelse($proximosEventos as $evento)
                        <li class="px-6 py-4 hover:bg-slate-50 transition-colors flex items-start gap-4">
                            {{-- Bloco de Data Destacado --}}
                            <div class="flex-shrink-0 flex flex-col items-center justify-center w-12 h-12 bg-amber-50 border border-amber-100 rounded-lg text-amber-600">
                                <span class="text-[10px] font-bold uppercase tracking-wider leading-none">{{ $evento->data_inicio->isoFormat('MMM') }}</span>
                                <span class="text-lg font-black leading-none mt-0.5">{{ $evento->data_inicio->format('d') }}</span>
                            </div>
                            {{-- Informações do Evento --}}
                            <div class="flex-1 min-w-0 mt-0.5">
                                <p class="text-sm font-semibold text-slate-700 line-clamp-2 mb-1" title="{{ $evento->titulo }}">
                                    {{ $evento->titulo }}
                                </p>
                                <div class="flex items-center gap-2 text-xs text-slate-500">
                                    <span class="flex items-center gap-1">
                                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                        {{ $evento->data_inicio->format('H:i') }}
                                    </span>
                                    @if(!empty($evento->local))
                                    <span class="truncate pl-2 border-l border-slate-200" title="{{ $evento->local }}">
                                        {{ $evento->local }}
                                    </span>
                                    @endif
                                </div>
                            </div>
                        </li>
                        @empty
                        <li class="px-6 py-8 text-center text-slate-400 text-sm">
                            Nenhum evento programado.
                        </li>
                        @endforelse
                    </ul>
                </div>

            </div>
        </div>

        <div class="xl:col-span-1">
            {{-- ===== LINHA 3: ACESSO RÁPIDO ===== --}}
            <div class="bg-white shadow-sm rounded-xl border border-slate-200 p-6">
                <h2 class="mb-4 text-sm font-bold uppercase tracking-wider text-slate-500">Acesso Rápido — Criar Conteúdo</h2>
                <div class="flex flex-col gap-3">

            @can('gerir noticias')
            <a href="{{ route('admin.noticias.create') }}" class="inline-flex w-full items-center justify-start gap-2 rounded-lg border border-blue-200 bg-blue-50 px-4 py-2 text-sm font-semibold text-blue-700 transition hover:bg-blue-600 hover:text-white hover:border-blue-600">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                Nova Notícia
            </a>
            @endcan

            @can('gerir eventos')
            <a href="{{ route('admin.eventos.create') }}" class="inline-flex w-full items-center justify-start gap-2 rounded-lg border border-amber-200 bg-amber-50 px-4 py-2 text-sm font-semibold text-amber-700 transition hover:bg-amber-500 hover:text-white hover:border-amber-500">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                Novo Evento
            </a>
            @endcan

            @can('gerir servicos')
            <a href="{{ route('admin.servicos.create') }}" class="inline-flex w-full items-center justify-start gap-2 rounded-lg border border-orange-200 bg-orange-50 px-4 py-2 text-sm font-semibold text-orange-700 transition hover:bg-orange-500 hover:text-white hover:border-orange-500">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                Novo Serviço
            </a>
            @endcan

            @role('admin')
            <a href="{{ route('admin.alertas.create') }}" class="inline-flex w-full items-center justify-start gap-2 rounded-lg border border-red-200 bg-red-50 px-4 py-2 text-sm font-semibold text-red-700 transition hover:bg-red-600 hover:text-white hover:border-red-600">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                Novo Alerta
            </a>
            @endrole

            @can('gerir banners')
            <a href="{{ route('admin.banners.create') }}" class="inline-flex w-full items-center justify-start gap-2 rounded-lg border border-indigo-200 bg-indigo-50 px-4 py-2 text-sm font-semibold text-indigo-700 transition hover:bg-indigo-600 hover:text-white hover:border-indigo-600">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                Novo Banner
            </a>
            @endcan

            @can('gerir programas')
            <a href="{{ route('admin.programas.create') }}" class="inline-flex w-full items-center justify-start gap-2 rounded-lg border border-emerald-200 bg-emerald-50 px-4 py-2 text-sm font-semibold text-emerald-700 transition hover:bg-emerald-600 hover:text-white hover:border-emerald-600">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                Novo Programa
            </a>
            @endcan

            @can('gerir secretarias')
            <a href="{{ route('admin.secretarias.create') }}" class="inline-flex w-full items-center justify-start gap-2 rounded-lg border border-teal-200 bg-teal-50 px-4 py-2 text-sm font-semibold text-teal-700 transition hover:bg-teal-600 hover:text-white hover:border-teal-600">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                Nova Secretaria
            </a>
            @endcan
                </div>
            </div>
        </div>
    </div>

@endsection