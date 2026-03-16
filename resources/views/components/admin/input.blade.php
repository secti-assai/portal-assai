@props(['name', 'label', 'type' => 'text', 'value' => '', 'required' => false, 'helpText' => null])

<div class="mb-4">
    <label for="{{ $name }}" class="block mb-2 text-sm font-bold text-gray-700">
        {{ $label }} @if($required) <span class="text-red-500">*</span> @endif
    </label>
    <input
        type="{{ $type }}"
        name="{{ $name }}"
        id="{{ $name }}"
        value="{{ old($name, $value) }}"
        {{ $required ? 'required' : '' }}
        {{ $attributes->merge(['class' => 'w-full px-3 py-2 leading-tight text-gray-700 border rounded shadow-sm appearance-none focus:outline-none focus:ring-2 focus:ring-blue-500 ' . ($errors->has($name) ? 'border-red-500' : 'border-gray-300')]) }}
    >
    @if($helpText)
        <p class="mt-1 text-xs text-slate-400">{{ $helpText }}</p>
    @endif
    @error($name)
        <p class="mt-1 text-xs italic text-red-500">{{ $message }}</p>
    @enderror
</div>