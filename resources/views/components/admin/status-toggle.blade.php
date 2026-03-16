@props([
    'checked' => false,
    'url',
    'tone' => 'blue',
    'titleOn' => 'Desativar item',
    'titleOff' => 'Ativar item',
    'onLabel' => 'ATIVO',
    'offLabel' => 'INATIVO',
])

@php
    $toneClasses = [
        'red' => [
            'ring' => 'focus-visible:ring-red-500',
            'activeBg' => 'bg-red-500',
            'activeText' => 'text-red-600',
        ],
        'indigo' => [
            'ring' => 'focus-visible:ring-indigo-500',
            'activeBg' => 'bg-indigo-500',
            'activeText' => 'text-indigo-600',
        ],
        'emerald' => [
            'ring' => 'focus-visible:ring-emerald-500',
            'activeBg' => 'bg-emerald-500',
            'activeText' => 'text-emerald-600',
        ],
        'orange' => [
            'ring' => 'focus-visible:ring-orange-500',
            'activeBg' => 'bg-orange-500',
            'activeText' => 'text-orange-600',
        ],
        'blue' => [
            'ring' => 'focus-visible:ring-blue-500',
            'activeBg' => 'bg-blue-500',
            'activeText' => 'text-blue-600',
        ],
    ];

    $cfg = $toneClasses[$tone] ?? $toneClasses['blue'];
@endphp

<button
    type="button"
    role="switch"
    aria-checked="{{ $checked ? 'true' : 'false' }}"
    title="{{ $checked ? $titleOn : $titleOff }}"
    data-url="{{ $url }}"
    onclick="toggleStatus(this, this.dataset.url)"
    {{ $attributes->merge(['class' => "relative inline-flex items-center w-11 h-6 rounded-full transition-colors duration-200 focus:outline-none focus-visible:ring-2 focus-visible:ring-offset-2 {$cfg['ring']} " . ($checked ? $cfg['activeBg'] : 'bg-slate-300')]) }}
>
    <span class="inline-block w-4 h-4 bg-white rounded-full shadow-sm transform transition-transform duration-200 {{ $checked ? 'translate-x-6' : 'translate-x-1' }}"></span>
</button>
<p class="mt-1 text-[10px] font-bold toggle-label {{ $checked ? $cfg['activeText'] : 'text-slate-400' }}">{{ $checked ? $onLabel : $offLabel }}</p>