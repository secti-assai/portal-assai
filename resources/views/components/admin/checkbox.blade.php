@props(['name', 'label', 'checked' => false, 'value' => '1', 'helpText' => null, 'color' => 'blue'])

@php
    $colors = [
        'blue' => 'text-blue-600 focus:ring-blue-500',
        'indigo' => 'text-indigo-600 focus:ring-indigo-500',
        'emerald' => 'text-emerald-600 focus:ring-emerald-500',
        'amber' => 'text-amber-600 focus:ring-amber-500',
        'gray' => 'text-gray-600 focus:ring-gray-500',
        'red' => 'text-red-600 focus:ring-red-500',
    ];

    $colorClass = $colors[$color] ?? $colors['blue'];
    $isChecked = old($name, $checked ? $value : null) == $value;
@endphp

<div class="mb-4">
    <label class="flex items-center gap-2 cursor-pointer">
        <input type="checkbox" name="{{ $name }}" value="{{ $value }}" @checked($isChecked) {{ $attributes->merge(['class' => "w-5 h-5 border-gray-300 rounded $colorClass"]) }}>
        <span class="text-sm font-bold text-slate-700">{{ $label }}</span>
    </label>
    @if($helpText)
        <p class="mt-2 text-xs text-slate-500">{{ $helpText }}</p>
    @endif
    @error($name)
        <p class="mt-1 text-xs italic text-red-500">{{ $message }}</p>
    @enderror
</div>