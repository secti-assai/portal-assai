@props([
    'label',
    'tone' => 'slate',
    'size' => 'xs',
])

@php
    $toneClasses = [
        'blue' => 'bg-blue-50 text-blue-700 border-blue-200',
        'indigo' => 'bg-indigo-50 text-indigo-700 border-indigo-200',
        'emerald' => 'bg-emerald-50 text-emerald-700 border-emerald-200',
        'amber' => 'bg-amber-50 text-amber-700 border-amber-200',
        'red' => 'bg-red-50 text-red-700 border-red-200',
        'slate' => 'bg-slate-50 text-slate-700 border-slate-200',
    ];

    $sizeClasses = [
        'xs' => 'text-xs px-2.5 py-0.5',
        '2xs' => 'text-[10px] px-2 py-0.5',
    ];

    $toneClass = $toneClasses[$tone] ?? $toneClasses['slate'];
    $sizeClass = $sizeClasses[$size] ?? $sizeClasses['xs'];
@endphp

<span {{ $attributes->merge(['class' => "inline-flex items-center rounded-full font-bold border {$sizeClass} {$toneClass}"]) }}>
    {{ $label }}
</span>