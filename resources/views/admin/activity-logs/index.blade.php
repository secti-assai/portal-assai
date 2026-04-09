@extends('layouts.admin')

@section('content')
<div class="flex flex-col gap-6 max-w-6xl mx-auto">

    @if(session('erro'))
        <div class="flex items-center gap-3 p-4 text-red-800 bg-red-50 border border-red-200 rounded-xl" role="alert">
            <svg class="w-5 h-5 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M4.93 19h14.14c1.54 0 2.5-1.67 1.73-3L13.73 4c-.77-1.33-2.69-1.33-3.46 0L3.2 16c-.77 1.33.19 3 1.73 3z"></path></svg>
            <p class="font-medium">{{ session('erro') }}</p>
        </div>
    @endif

    <x-admin.page-header
        title="Trilha de Auditoria"
        :breadcrumbs="[
            ['label' => 'Dashboard', 'url' => route('admin.dashboard'), 'class' => 'hover:text-blue-600'],
            ['label' => 'Auditoria'],
        ]"
    />

    <x-admin.panel class="overflow-hidden p-0">
        <div class="p-4 border-b border-slate-100 bg-slate-50/50 flex flex-wrap items-center gap-3">
            <h2 class="font-semibold text-slate-700 mr-auto">Registros de Atividade</h2>
            <form method="GET" action="{{ route('admin.activity-logs.index') }}" class="flex flex-wrap items-center gap-2">
                <x-admin.filter-search value="{{ request('q') }}" placeholder="Pesquisar por descrição ou evento..." />
                <x-admin.filter-select name="module" :options="$modules" :value="request('module')" placeholder="Todos os módulos" />
                <x-admin.filter-select name="user_id" :options="$users" :value="request('user_id')" placeholder="Todos os usuários" />
                <x-admin.filter-select name="event" :options="$events" :value="request('event')" placeholder="Todos os eventos" />
                <input type="date" name="from" value="{{ request('from') }}" class="py-1.5 px-2 text-sm border border-slate-200 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none bg-white">
                <input type="date" name="to" value="{{ request('to') }}" class="py-1.5 px-2 text-sm border border-slate-200 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none bg-white">
                <button type="submit" class="px-3 py-1.5 text-sm font-bold text-white bg-blue-600 rounded-lg hover:bg-blue-700 transition">Filtrar</button>
                @if(request()->hasAny(['q', 'module', 'user_id', 'event', 'from', 'to']))
                    <a href="{{ route('admin.activity-logs.index') }}" class="px-3 py-1.5 text-sm font-bold text-slate-600 bg-white border border-slate-200 rounded-lg hover:bg-slate-50 transition">Limpar</a>
                @endif
            </form>
            <a href="{{ route('admin.activity-logs.export', request()->query()) }}" class="px-3 py-1.5 text-sm font-bold text-white bg-emerald-600 rounded-lg hover:bg-emerald-700 transition">Exportar CSV</a>
            <x-admin.status-badge :label="(string) $activities->total()" tone="slate" />
        </div>

        <div class="divide-y divide-slate-100">
            @forelse($activities as $activity)
                @php
                    $meta = $activity->meta;
                @endphp

                <div class="p-5 bg-white">
                    <div class="flex flex-col gap-4 lg:flex-row lg:items-start lg:justify-between">
                        <div class="space-y-2 min-w-0">
                            <div class="flex flex-wrap items-center gap-2">
                                <x-admin.status-badge :label="$meta['module_label'] ?: 'Sistema'" tone="slate" />
                                <x-admin.status-badge :label="$meta['event_label']" :tone="$meta['event_tone']" />
                                @if($activity->subject_id)
                                    <span class="text-xs font-mono text-slate-400">#{{ $activity->subject_id }}</span>
                                @endif
                            </div>

                            <div>
                                <p class="font-bold text-slate-800">{{ $activity->description }}</p>
                                <p class="text-sm font-medium text-slate-700 mt-1">{{ $meta['subject_label'] }}</p>
                                <p class="text-sm text-slate-500">
                                    @if($activity->causer)
                                        por <span class="font-semibold text-slate-700">{{ $activity->causer->name ?? 'Usuário #' . $activity->causer_id }}</span>
                                    @else
                                        por <span class="font-semibold text-slate-700">Sistema</span>
                                    @endif
                                    em {{ $activity->created_at?->format('d/m/Y H:i:s') }}
                                </p>
                            </div>
                        </div>

                        <div class="text-xs text-slate-400 font-mono break-all lg:max-w-sm">
                            <div>log_name: {{ $activity->log_name ?? 'default' }}</div>
                            <div>subject: {{ $activity->subject_type ?? 'n/a' }}</div>
                            <div>causer: {{ $activity->causer_type ?? 'n/a' }}</div>
                            @if($activity->batch_uuid)
                                <div>batch: {{ $activity->batch_uuid }}</div>
                            @endif
                        </div>
                    </div>

                    <div class="mt-4 flex flex-wrap items-center gap-2">
                        <x-admin.icon-action href="{{ route('admin.activity-logs.show', $activity) }}" color="slate" title="Ver detalhes do log">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        </x-admin.icon-action>
                        @if($meta['edit_url'])
                            <x-admin.icon-action href="{{ $meta['edit_url'] }}" color="blue" title="Abrir registro relacionado">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                            </x-admin.icon-action>
                        @endif
                    </div>

                    <details class="mt-4 group">
                        <summary class="cursor-pointer text-sm font-bold text-blue-700 hover:text-blue-800">Ver detalhes e diff</summary>

                        <div class="mt-4 grid gap-4 lg:grid-cols-2">
                            <div class="rounded-xl border border-slate-200 overflow-hidden">
                                <div class="px-4 py-3 bg-slate-50 border-b border-slate-200">
                                    <h3 class="font-bold text-slate-700">Alterações</h3>
                                </div>

                                @if(empty($meta['diff_rows']))
                                    <div class="p-4 text-sm text-slate-500">Nenhum diff estruturado disponível neste registro.</div>
                                @else
                                    <div class="divide-y divide-slate-100">
                                        @foreach($meta['diff_rows'] as $row)
                                            <div class="p-4 text-sm">
                                                <div class="flex items-center gap-2 mb-2">
                                                    <p class="font-bold text-slate-700">{{ $row['key'] }}</p>
                                                    @if($row['sensitive'])
                                                        <x-admin.status-badge label="Sensível" tone="red" size="2xs" />
                                                    @endif
                                                    @if(!$row['changed'])
                                                        <x-admin.status-badge label="Sem mudança" tone="slate" size="2xs" />
                                                    @endif
                                                </div>
                                                <div class="grid gap-3 md:grid-cols-2">
                                                    <div>
                                                        <p class="text-[11px] uppercase tracking-wide text-slate-400 mb-1">Valor anterior</p>
                                                        <pre class="whitespace-pre-wrap break-words rounded-lg bg-slate-50 p-3 text-xs text-slate-600">{{ $row['old_display'] }}</pre>
                                                    </div>
                                                    <div>
                                                        <p class="text-[11px] uppercase tracking-wide text-slate-400 mb-1">Novo valor</p>
                                                        <pre class="whitespace-pre-wrap break-words rounded-lg bg-emerald-50 p-3 text-xs text-emerald-800">{{ $row['new_display'] }}</pre>
                                                    </div>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                @endif
                            </div>

                            <div class="rounded-xl border border-slate-200 overflow-hidden">
                                <div class="px-4 py-3 bg-slate-50 border-b border-slate-200">
                                    <h3 class="font-bold text-slate-700">Payload bruto</h3>
                                </div>
                                <pre class="p-4 text-xs text-slate-600 whitespace-pre-wrap break-words">{{ json_encode($meta['properties'], JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES) }}</pre>
                            </div>
                        </div>
                    </details>
                </div>
            @empty
                <div class="p-10 text-center text-slate-500">
                    Nenhum log encontrado para os filtros informados.
                </div>
            @endforelse
        </div>

        @if($activities->hasPages())
            <div class="p-4 border-t border-slate-100 bg-slate-50/50">
                {{ $activities->links() }}
            </div>
        @endif
    </x-admin.panel>
</div>
@endsection