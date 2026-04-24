@extends('layouts.admin')

@section('content')
@php
    $meta = $activity->meta;
@endphp

<div class="flex flex-col gap-6 max-w-6xl mx-auto">
    <x-admin.page-header
        title="Detalhe do Log #{$activity->id}"
        :breadcrumbs="[
            ['label' => 'Dashboard', 'url' => route('admin.dashboard'), 'class' => 'hover:text-blue-600'],
            ['label' => 'Auditoria', 'url' => route('admin.activity-logs.index'), 'class' => 'hover:text-blue-600'],
            ['label' => 'Detalhe'],
        ]"
    >
        <x-slot:action>
            <div class="flex items-center gap-2">
                <a href="{{ route('admin.activity-logs.index') }}" class="px-4 py-2 text-sm font-bold text-slate-600 bg-white border border-slate-300 rounded-lg hover:bg-slate-50 transition shadow-sm">
                    Voltar
                </a>
                @if($meta['edit_url'])
                    <a href="{{ $meta['edit_url'] }}" class="px-4 py-2 text-sm font-bold text-white bg-blue-600 rounded-lg hover:bg-blue-700 transition shadow-sm">
                        Abrir Registro
                    </a>
                @endif
            </div>
        </x-slot:action>
    </x-admin.page-header>

    <div class="grid gap-6 lg:grid-cols-3">
        <x-admin.panel class="lg:col-span-1 space-y-4">
            <div class="flex flex-wrap items-center gap-2">
                <x-admin.status-badge :label="$meta['module_label'] ?: 'Sistema'" tone="slate" />
                <x-admin.status-badge :label="$meta['event_label']" :tone="$meta['event_tone']" />
            </div>

            <div class="space-y-2 text-sm text-slate-600">
                <div><span class="font-bold text-slate-700">Descrição:</span> {{ $activity->description }}</div>
                <div><span class="font-bold text-slate-700">Registro:</span> {{ $meta['subject_label'] }}</div>
                <div><span class="font-bold text-slate-700">Subject:</span> {{ $activity->subject_type ?? 'n/a' }}</div>
                <div><span class="font-bold text-slate-700">Subject ID:</span> {{ $activity->subject_id ?? 'n/a' }}</div>
                <div><span class="font-bold text-slate-700">Usuário:</span> {{ $activity->causer->name ?? 'Sistema' }}</div>
                <div><span class="font-bold text-slate-700">Causer:</span> {{ $activity->causer_type ?? 'n/a' }}</div>
                <div><span class="font-bold text-slate-700">Causer ID:</span> {{ $activity->causer_id ?? 'n/a' }}</div>
                <div><span class="font-bold text-slate-700">Data:</span> {{ $activity->created_at?->format('d/m/Y H:i:s') }}</div>
                <div><span class="font-bold text-slate-700">Log name:</span> {{ $activity->log_name ?? 'default' }}</div>
                @if($activity->batch_uuid)
                    <div><span class="font-bold text-slate-700">Batch:</span> {{ $activity->batch_uuid }}</div>
                @endif
            </div>
        </x-admin.panel>

        <div class="lg:col-span-2 space-y-6">
            <x-admin.panel class="overflow-hidden p-0">
                <div class="px-4 py-3 bg-slate-50 border-b border-slate-200">
                    <h3 class="font-bold text-slate-700">Diff das Alterações</h3>
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
            </x-admin.panel>

            <x-admin.panel class="overflow-hidden p-0">
                <div class="px-4 py-3 bg-slate-50 border-b border-slate-200">
                    <h3 class="font-bold text-slate-700">Payload Bruto</h3>
                </div>
                <pre class="p-4 text-xs text-slate-600 whitespace-pre-wrap break-words">{{ json_encode($meta['properties'], JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES) }}</pre>
            </x-admin.panel>
        </div>
    </div>
</div>
@endsection
