@props(['name', 'label', 'value' => '', 'required' => false, 'rows' => 3, 'hint' => null, 'helpText' => null])

<div class="mb-4">
    <label for="{{ $name }}" class="block mb-2 text-sm font-bold text-gray-700">
        {{ $label }}
        @if($hint)
            <span class="text-xs text-gray-400 font-normal">{{ $hint }}</span>
        @endif
        @if($required)
            <span class="text-red-500">*</span>
        @endif
    </label>
    <textarea
        name="{{ $name }}"
        id="{{ $name }}"
        rows="{{ $rows }}"
        {{ $required ? 'required' : '' }}
        {{ $attributes->merge(['class' => 'w-full px-4 py-2.5 leading-tight text-gray-700 border rounded-lg shadow-sm appearance-none focus:outline-none focus:ring-2 focus:ring-blue-500 ' . ($errors->has($name) ? 'border-red-500' : 'border-gray-300')]) }}
    >{{ old($name, $value) }}</textarea>
    @if($helpText)
        <p class="mt-1 text-xs text-slate-400">{{ $helpText }}</p>
    @endif
    @error($name)
        <p class="mt-1 text-xs italic text-red-500">{{ $message }}</p>
    @enderror
</div>