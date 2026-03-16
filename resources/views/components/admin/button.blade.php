@props(['type' => 'submit', 'color' => 'blue'])

@php
    $colors = [
        'blue' => 'bg-blue-600 hover:bg-blue-700 focus:ring-blue-500',
        'indigo' => 'bg-indigo-600 hover:bg-indigo-700 focus:ring-indigo-500',
        'emerald' => 'bg-emerald-600 hover:bg-emerald-700 focus:ring-emerald-500',
        'amber' => 'bg-amber-600 hover:bg-amber-700 focus:ring-amber-500',
        'gray' => 'bg-gray-500 hover:bg-gray-600 focus:ring-gray-500',
        'red' => 'bg-red-600 hover:bg-red-700 focus:ring-red-500',
    ];
    $colorClass = $colors[$color] ?? $colors['blue'];
@endphp

<button
    type="{{ $type }}"
    {{ $attributes->merge(['class' => "px-4 py-2 font-bold text-white transition-colors rounded shadow focus:outline-none focus:ring-2 focus:ring-offset-2 $colorClass"]) }}
>
    {{ $slot }}
</button>