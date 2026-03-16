@props([
    'href' => null,
    'type' => 'button',
    'title' => '',
    'color' => 'blue',
    'target' => null,
    'rel' => null,
])

@php
    $colorClasses = [
        'slate' => 'text-slate-600 bg-slate-50 hover:bg-slate-100 hover:text-slate-800 focus:ring-slate-500',
        'blue' => 'text-blue-600 bg-blue-50 hover:bg-blue-100 hover:text-blue-800 focus:ring-blue-500',
        'red' => 'text-red-600 bg-red-50 hover:bg-red-100 hover:text-red-800 focus:ring-red-500',
    ];

    $baseClass = 'inline-flex items-center justify-center p-2 rounded-lg transition-colors focus:outline-none focus:ring-2 focus:ring-offset-1';
    $colorClass = $colorClasses[$color] ?? $colorClasses['blue'];
@endphp

@if($href)
    <a
        href="{{ $href }}"
        @if($target) target="{{ $target }}" @endif
        @if($rel) rel="{{ $rel }}" @endif
        title="{{ $title }}"
        {{ $attributes->merge(['class' => "{$baseClass} {$colorClass}"]) }}
    >
        {{ $slot }}
    </a>
@else
    <button
        type="{{ $type }}"
        title="{{ $title }}"
        {{ $attributes->merge(['class' => "{$baseClass} {$colorClass}"]) }}
    >
        {{ $slot }}
    </button>
@endif