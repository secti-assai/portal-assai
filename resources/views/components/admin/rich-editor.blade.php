@props(['name', 'label', 'value' => '', 'required' => false, 'rows' => 6, 'id' => null])

@php
    $editorId = $id ?? $name;
@endphp

<div class="mb-4">
    <label for="{{ $editorId }}" class="block mb-2 text-sm font-bold text-gray-700">
        {{ $label }} @if($required) <span class="text-red-500">*</span> @endif
    </label>
    <div class="overflow-hidden border rounded-lg {{ $errors->has($name) ? 'border-red-500' : 'border-slate-200' }}">
        <textarea
            name="{{ $name }}"
            id="{{ $editorId }}"
            rows="{{ $rows }}"
            aria-required="{{ $required ? 'true' : 'false' }}"
            {{ $attributes->merge(['class' => 'w-full']) }}
        >{{ old($name, $value) }}</textarea>
    </div>
    @error($name)
        <p class="mt-1 text-xs italic text-red-500">{{ $message }}</p>
    @enderror
</div>