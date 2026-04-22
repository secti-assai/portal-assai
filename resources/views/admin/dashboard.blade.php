@extends('layouts.admin')

@section('content')

{{-- HEADER --}}
<div class="mb-8 rounded-2xl border border-[#e2e8f0] overflow-hidden shadow-md">
    <div class="bg-gradient-to-r from-[#0b2f57] via-[#006eb7] to-[#0b2f57] p-6 sm:p-8">
        <div class="flex flex-col gap-4 md:flex-row md:items-center md:justify-between">
            <div class="flex items-center gap-4">
                <div class="flex-shrink-0 w-14 h-14 rounded-2xl bg-white/20 border-2 border-white/30 flex items-center justify-center shadow-lg">
                    <span class="text-2xl font-black text-white">{{ strtoupper(substr(Auth::user()->name, 0, 1)) }}</span>
                </div>
                <div>
                    <h1 class="text-2xl md:text-3xl font-black text-white tracking-tight leading-tight">
                        Ola, {{ Auth::user()->name }}
                    </h1>
                    <p class="mt-0.5 text-blue-100 text-sm font-medium">
                        Painel de Controle &mdash;
                        <span class="font-mono text-blue-200">{{ \Carbon\Carbon::now()->isoFormat('D [de] MMMM [de] YYYY') }}</span>
                    </p>
                </div>
            </div>
            <div class="flex flex-wrap items-center gap-2">
                @foreach($meusPapeis as $papel)
                    @php
                        $badgeColor = match($papel) {
                            'admin'       => 'bg-yellow-400 text-yellow-900',
                            'editor'      => 'bg-purple-500 text-white',
                            'comunicacao' => 'bg-emerald-500 text-white',
                            default       => 'bg-white/20 text-white',
                        };
                        $badgeIcon = match($papel) {
                            'admin'       => 'fa-shield-halved',
                            'editor'      => 'fa-pen-to-square',
                            'comunicacao' => 'fa-bullhorn',
                            default       => 'fa-user',
                        };
                    @endphp
                    <span class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-full text-xs font-bold {{ $badgeColor }} uppercase tracking-wide shadow-sm">
                        <i class="fa-solid {{ $badgeIcon }}"></i>
                        {{ $papel }}
                    </span>
                @endforeach
                <span class="inline-flex items-center gap-1.5 rounded-full bg-white/10 border border-white/20 px-3 py-1.5 text-xs font-bold text-white">
                    <span class="h-2 w-2 rounded-full bg-emerald-400 animate-pulse"></span>
                    Online
                </span>
            </div>
        </div>
    </div>
    @if($minhasPerms->count() > 0)
    <div class="bg-[#f8fafc] border-t border-[#e2e8f0] px-6 py-3 flex flex-wrap items-center gap-2">
        <span class="text-xs font-bold text-slate-400 uppercase tracking-wider shrink-0">Permissoes:</span>
        @foreach($minhasPerms->take(8) as $perm)
        <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-md bg-[#e3f0fc] text-[#006eb7] text-xs font-semibold">
            <i class="fa-solid fa-key text-[10px]"></i>
            {{ $perm }}
        </span>
        @endforeach
        @if($minhasPerms->count() > 8)
        <span class="text-xs text-slate-400 font-medium">+{{ $minhasPerms->count() - 8 }} mais</span>
        @endif
    </div>
    @endif
</div>

{{-- KPIs --}}
<div class="grid grid-cols-2 gap-4 mb-8 lg:grid-cols-3 xl:grid-cols-5">

    <div class="bg-white border border-[#e2e8f0] shadow-sm rounded-2xl p-5 flex flex-col gap-3 transition-all duration-200 hover:-translate-y-0.5 hover:shadow-md">
        <div class="flex items-center justify-between">
            <div class="p-2.5 rounded-xl bg-[#e3f0fc]">
                <i class="fa-solid fa-newspaper text-[#006eb7] text-lg"></i>
            </div>
            <a href="{{ route('admin.noticias.index') }}" class="text-[10px] font-bold text-slate-400 hover:text-[#006eb7] transition-colors"><i class="fa-solid fa-arrow-right"></i></a>
        </div>
        <div>
            <p class="text-3xl font-black text-[#22223b] leading-none">{{ $totalNoticias }}</p>
            <p class="text-xs font-bold text-[#4a5c6a] uppercase tracking-wide mt-1">Noticias</p>
        </div>
    </div>

    <div class="bg-white border border-[#e2e8f0] shadow-sm rounded-2xl p-5 flex flex-col gap-3 transition-all duration-200 hover:-translate-y-0.5 hover:shadow-md">
        <div class="flex items-center justify-between">
            <div class="p-2.5 rounded-xl bg-[#fff7ed]">
                <i class="fa-solid fa-calendar-days text-[#f59e42] text-lg"></i>
            </div>
            <a href="{{ route('admin.eventos.index') }}" class="text-[10px] font-bold text-slate-400 hover:text-[#f59e42] transition-colors"><i class="fa-solid fa-arrow-right"></i></a>
        </div>
        <div>
            <p class="text-3xl font-black text-[#22223b] leading-none">{{ $totalEventosAtivos }}</p>
            <p class="text-xs font-bold text-[#4a5c6a] uppercase tracking-wide mt-1">Eventos futuros</p>
        </div>
    </div>

    <div class="bg-white border border-[#e2e8f0] shadow-sm rounded-2xl p-5 flex flex-col gap-3 transition-all duration-200 hover:-translate-y-0.5 hover:shadow-md">
        <div class="flex items-center justify-between">
            <div class="p-2.5 rounded-xl bg-[#e6f4f1]">
                <i class="fa-solid fa-bolt text-[#22c55e] text-lg"></i>
            </div>
            <a href="{{ route('admin.servicos.index') }}" class="text-[10px] font-bold text-slate-400 hover:text-[#22c55e] transition-colors"><i class="fa-solid fa-arrow-right"></i></a>
        </div>
        <div>
            <p class="text-3xl font-black text-[#22223b] leading-none">{{ $totalServicos }}</p>
            <p class="text-xs font-bold text-[#4a5c6a] uppercase tracking-wide mt-1">Servicos ativos</p>
        </div>
    </div>

    <div class="bg-white border border-[#e2e8f0] shadow-sm rounded-2xl p-5 flex flex-col gap-3 transition-all duration-200 hover:-translate-y-0.5 hover:shadow-md">
        <div class="flex items-center justify-between">
            <div class="p-2.5 rounded-xl bg-[#fdf4ff]">
                <i class="fa-solid fa-layer-group text-[#a855f7] text-lg"></i>
            </div>
            <a href="{{ route('admin.programas.index') }}" class="text-[10px] font-bold text-slate-400 hover:text-[#a855f7] transition-colors"><i class="fa-solid fa-arrow-right"></i></a>
        </div>
        <div>
            <p class="text-3xl font-black text-[#22223b] leading-none">{{ $totalProgramas }}</p>
            <p class="text-xs font-bold text-[#4a5c6a] uppercase tracking-wide mt-1">Programas</p>
        </div>
    </div>

    <div class="bg-white border border-[#e2e8f0] shadow-sm rounded-2xl p-5 flex flex-col gap-3 transition-all duration-200 hover:-translate-y-0.5 hover:shadow-md">
        <div class="flex items-center justify-between">
            <div class="p-2.5 rounded-xl bg-[#eef2ff]">
                <i class="fa-solid fa-image text-[#6366f1] text-lg"></i>
            </div>
            @can('gerir banners')
            <a href="{{ route('admin.banners.index') }}" class="text-[10px] font-bold text-slate-400 hover:text-[#6366f1] transition-colors"><i class="fa-solid fa-arrow-right"></i></a>
            @endcan
        </div>
        <div>
            <p class="text-3xl font-black text-[#22223b] leading-none">{{ isset($bannersAtivos) ? $bannersAtivos->count() : 0 }}</p>
            <p class="text-xs font-bold text-[#4a5c6a] uppercase tracking-wide mt-1">Imagens Pop-up</p>
        </div>
    </div>

</div>

{{-- ACESSO RAPIDO --}}
<div class="bg-white shadow-sm rounded-xl border border-slate-200 p-6 mb-8">
    <h2 class="mb-4 text-sm font-bold uppercase tracking-wider text-slate-400 flex items-center gap-2">
        <i class="fa-solid fa-rocket text-[#006eb7]"></i>
        Criar conteudo rapidamente
    </h2>
    <div class="grid grid-cols-2 gap-3 sm:grid-cols-3 lg:grid-cols-4 xl:flex xl:flex-wrap">
        @can('gerir noticias')
        <a href="{{ route('admin.noticias.create') }}" id="quick-create-noticia"
            class="inline-flex items-center gap-2 rounded-xl border border-blue-200 bg-blue-50 px-4 py-3 text-sm font-semibold text-blue-700 transition hover:bg-blue-600 hover:text-white hover:border-blue-600 hover:-translate-y-0.5 hover:shadow-md">
            <i class="fa-solid fa-newspaper"></i> Nova Noticia
        </a>
        @endcan
        @can('gerir eventos')
        <a href="{{ route('admin.eventos.create') }}" id="quick-create-evento"
            class="inline-flex items-center gap-2 rounded-xl border border-amber-200 bg-amber-50 px-4 py-3 text-sm font-semibold text-amber-700 transition hover:bg-amber-500 hover:text-white hover:border-amber-500 hover:-translate-y-0.5 hover:shadow-md">
            <i class="fa-solid fa-calendar-plus"></i> Novo Evento
        </a>
        @endcan
        @can('gerir programas')
        <a href="{{ route('admin.programas.create') }}" id="quick-create-programa"
            class="inline-flex items-center gap-2 rounded-xl border border-purple-200 bg-purple-50 px-4 py-3 text-sm font-semibold text-purple-700 transition hover:bg-purple-600 hover:text-white hover:border-purple-600 hover:-translate-y-0.5 hover:shadow-md">
            <i class="fa-solid fa-layer-group"></i> Novo Programa
        </a>
        @endcan
        @can('gerir servicos')
        <a href="{{ route('admin.servicos.create') }}" id="quick-create-servico"
            class="inline-flex items-center gap-2 rounded-xl border border-orange-200 bg-orange-50 px-4 py-3 text-sm font-semibold text-orange-700 transition hover:bg-orange-500 hover:text-white hover:border-orange-500 hover:-translate-y-0.5 hover:shadow-md">
            <i class="fa-solid fa-bolt"></i> Novo Servico
        </a>
        @endcan
        @can('gerir banners')
        <a href="{{ route('admin.banners.create') }}" id="quick-create-banner"
            class="inline-flex items-center gap-2 rounded-xl border border-indigo-200 bg-indigo-50 px-4 py-3 text-sm font-semibold text-indigo-700 transition hover:bg-indigo-600 hover:text-white hover:border-indigo-600 hover:-translate-y-0.5 hover:shadow-md">
            <i class="fa-solid fa-image"></i> Nova Imagem Pop-up
        </a>
        @endcan
        @can('gerir secretarias')
        <a href="{{ route('admin.secretarias.create') }}" id="quick-create-secretaria"
            class="inline-flex items-center gap-2 rounded-xl border border-teal-200 bg-teal-50 px-4 py-3 text-sm font-semibold text-teal-700 transition hover:bg-teal-600 hover:text-white hover:border-teal-600 hover:-translate-y-0.5 hover:shadow-md">
            <i class="fa-solid fa-building-columns"></i> Nova Secretaria
        </a>
        @endcan
    </div>
</div>

{{-- BANNERS ATIVOS --}}
<div class="mb-8">
    <div class="bg-white shadow-sm rounded-xl border border-slate-200 overflow-hidden">
        <div class="flex items-center justify-between px-6 py-4 border-b border-slate-100">
            <div class="flex items-center gap-2">
                <i class="fa-solid fa-image text-indigo-500"></i>
                <h2 class="text-base font-bold text-slate-800">Banners Pop-up Ativos</h2>
            </div>
            @can('gerir banners')
            <a href="{{ route('admin.banners.index') }}" class="text-xs font-medium text-blue-600 hover:underline">Ver todos</a>
            @endcan
        </div>
        <ul class="divide-y divide-slate-100">
            @forelse($bannersAtivos as $banner)
            <li class="px-6 py-4 hover:bg-slate-50 transition-colors flex items-center gap-3">
                <div class="w-2 h-2 rounded-full bg-indigo-400 shrink-0"></div>
                <div class="min-w-0 flex-1">
                    <p class="text-sm font-semibold text-slate-700 line-clamp-1">{{ $banner->titulo }}</p>
                    @if($banner->subtitulo)
                    <p class="text-xs text-slate-400 line-clamp-1">{{ $banner->subtitulo }}</p>
                    @endif
                </div>
                <span class="inline-block shrink-0 rounded-full bg-indigo-50 text-indigo-700 text-xs font-semibold px-2.5 py-0.5">Ativo</span>
            </li>
            @empty
            <li class="px-6 py-8 text-center text-slate-400 text-sm">
                <i class="fa-regular fa-image text-2xl mb-2 text-slate-300 block"></i>
                Nenhum banner ativo no momento.
            </li>
            @endforelse
        </ul>
    </div>
</div>

{{-- TOP SERVICOS --}}
@can('gerir servicos')
<div class="bg-white shadow-sm rounded-xl border border-slate-200 overflow-hidden mb-8">
    <div class="flex items-center justify-between px-6 py-4 border-b border-slate-100">
        <div class="flex items-center gap-2">
            <i class="fa-solid fa-chart-bar text-orange-500"></i>
            <h2 class="text-base font-bold text-slate-800">Top 5 Servicos Mais Acessados</h2>
        </div>
        <a href="{{ route('admin.servicos.index') }}" class="text-xs font-medium text-blue-600 hover:underline">Ver todos</a>
    </div>
    <div class="overflow-x-auto">
        <table class="min-w-full text-sm">
            <thead>
                <tr class="bg-slate-50 text-slate-500 text-xs font-semibold uppercase tracking-wide">
                    <th class="px-6 py-3 text-left w-10">#</th>
                    <th class="px-6 py-3 text-left">Servico</th>
                    <th class="px-6 py-3 text-left">Link destino</th>
                    <th class="px-6 py-3 text-right">Acessos</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-100">
                @forelse($topServicos as $index => $servico)
                <tr class="hover:bg-slate-50 transition-colors">
                    <td class="px-6 py-3">
                        <span class="inline-flex items-center justify-center w-6 h-6 rounded-full text-xs font-bold
                            {{ $index === 0 ? 'bg-yellow-400 text-yellow-900' : ($index === 1 ? 'bg-slate-300 text-slate-700' : ($index === 2 ? 'bg-orange-300 text-orange-900' : 'bg-slate-100 text-slate-400')) }}">
                            {{ $index + 1 }}
                        </span>
                    </td>
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

{{-- NOTICIAS + EVENTOS + PROGRAMAS --}}
<div class="grid grid-cols-1 gap-6 lg:grid-cols-3 mb-8">

    <div class="bg-white shadow-sm rounded-xl border border-slate-200 overflow-hidden">
        <div class="flex items-center justify-between px-6 py-4 border-b border-slate-100">
            <div class="flex items-center gap-2">
                <i class="fa-solid fa-newspaper text-blue-500"></i>
                <h2 class="text-base font-bold text-slate-800">Noticias Recentes</h2>
            </div>
            <a href="{{ route('admin.noticias.index') }}" class="text-xs font-medium text-blue-600 hover:underline">Ver todas</a>
        </div>
        <ul class="divide-y divide-slate-100">
            @forelse($ultimasNoticias as $noticia)
            <li class="px-6 py-4 hover:bg-slate-50 transition-colors">
                <p class="text-sm font-semibold text-slate-700 line-clamp-2 mb-1">{{ $noticia->titulo }}</p>
                <p class="text-xs text-slate-400 flex items-center gap-1">
                    <i class="fa-regular fa-clock"></i>
                    {{ $noticia->created_at->diffForHumans() }}
                </p>
            </li>
            @empty
            <li class="px-6 py-8 text-center text-slate-400 text-sm">Nenhuma noticia publicada ainda.</li>
            @endforelse
        </ul>
    </div>

    <div class="bg-white shadow-sm rounded-xl border border-slate-200 overflow-hidden">
        <div class="flex items-center justify-between px-6 py-4 border-b border-slate-100">
            <div class="flex items-center gap-2">
                <i class="fa-solid fa-calendar-days text-amber-500"></i>
                <h2 class="text-base font-bold text-slate-800">Proximos Eventos</h2>
            </div>
            <a href="{{ route('admin.eventos.index') }}" class="text-xs font-medium text-blue-600 hover:underline">Ver todos</a>
        </div>
        <ul class="divide-y divide-slate-100">
            @forelse($proximosEventos as $evento)
            <li class="px-6 py-4 hover:bg-slate-50 transition-colors flex items-start gap-4">
                <div class="flex-shrink-0 flex flex-col items-center justify-center w-12 h-12 bg-amber-50 border border-amber-100 rounded-xl text-amber-600">
                    <span class="text-[10px] font-bold uppercase tracking-wider leading-none">{{ $evento->data_inicio->isoFormat('MMM') }}</span>
                    <span class="text-lg font-black leading-none mt-0.5">{{ $evento->data_inicio->format('d') }}</span>
                </div>
                <div class="flex-1 min-w-0 mt-0.5">
                    <p class="text-sm font-semibold text-slate-700 line-clamp-2 mb-1">{{ $evento->titulo }}</p>
                    <div class="flex items-center gap-2 text-xs text-slate-500">
                        <span class="flex items-center gap-1">
                            <i class="fa-regular fa-clock text-[10px]"></i>
                            {{ $evento->data_inicio->format('H:i') }}
                        </span>
                        @if(!empty($evento->local))
                        <span class="truncate pl-2 border-l border-slate-200">{{ $evento->local }}</span>
                        @endif
                    </div>
                </div>
            </li>
            @empty
            <li class="px-6 py-8 text-center text-slate-400 text-sm">Nenhum evento programado.</li>
            @endforelse
        </ul>
    </div>

    <div class="bg-white shadow-sm rounded-xl border border-slate-200 overflow-hidden">
        <div class="flex items-center justify-between px-6 py-4 border-b border-slate-100">
            <div class="flex items-center gap-2">
                <i class="fa-solid fa-layer-group text-purple-500"></i>
                <h2 class="text-base font-bold text-slate-800">Programas Recentes</h2>
            </div>
            <a href="{{ route('admin.programas.index') }}" class="text-xs font-medium text-blue-600 hover:underline">Ver todos</a>
        </div>
        <ul class="divide-y divide-slate-100">
            @forelse($ultimosProgramas as $programa)
            <li class="px-6 py-4 hover:bg-slate-50 transition-colors">
                <p class="text-sm font-semibold text-slate-700 line-clamp-2 mb-1">{{ $programa->titulo }}</p>
                <p class="text-xs text-slate-400 flex items-center gap-1">
                    <i class="fa-regular fa-clock"></i>
                    {{ $programa->created_at->diffForHumans() }}
                </p>
            </li>
            @empty
            <li class="px-6 py-8 text-center text-slate-400 text-sm">Nenhum programa criado ainda.</li>
            @endforelse
        </ul>
    </div>
</div>

{{-- GOVERNANCA (apenas admin) --}}
@role('admin')
<div class="bg-gradient-to-r from-[#0b2f57] to-[#0c4a8a] rounded-2xl p-6 text-white shadow-lg">
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div class="flex items-center gap-4">
            <div class="p-3 bg-white/10 rounded-xl">
                <i class="fa-solid fa-shield-halved text-yellow-400 text-2xl"></i>
            </div>
            <div>
                <h2 class="text-lg font-black tracking-tight">Governanca e Controle</h2>
                <p class="text-blue-200 text-sm mt-0.5">
                    {{ $totalUsuarios }} {{ $totalUsuarios === 1 ? 'usuario cadastrado' : 'usuarios cadastrados' }} no sistema
                </p>
            </div>
        </div>
        <div class="flex flex-wrap gap-3">
            <a href="{{ route('users.index') }}" id="gov-users-link"
                class="inline-flex items-center gap-2 px-5 py-2.5 bg-yellow-400 text-yellow-900 rounded-xl text-sm font-bold hover:bg-yellow-300 transition-all hover:-translate-y-0.5 shadow-md">
                <i class="fa-solid fa-users"></i> Gerenciar Usuarios
            </a>
            <a href="{{ route('admin.activity-logs.index') }}" id="gov-audit-link"
                class="inline-flex items-center gap-2 px-5 py-2.5 bg-white/10 border border-white/20 rounded-xl text-sm font-bold hover:bg-white/20 transition-all hover:-translate-y-0.5">
                <i class="fa-solid fa-chart-line"></i> Log de Auditoria
            </a>
        </div>
    </div>
</div>
@endrole

@endsection
