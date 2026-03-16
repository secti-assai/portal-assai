@props(['name', 'label', 'options' => [], 'value' => null, 'required' => false])

<div class="mb-4">
    <label for="{{ $name }}" class="block mb-2 text-sm font-bold text-gray-700">
        {{ $label }} @if($required) <span class="text-red-500">*</span> @endif
    </label>
    <select
        name="{{ $name }}"
        id="{{ $name }}"
        {{ $required ? 'required' : '' }}
        {{ $attributes->merge(['class' => 'w-full px-4 py-2.5 leading-tight text-gray-700 border rounded-lg shadow-sm appearance-none focus:outline-none focus:ring-2 focus:ring-blue-500 ' . ($errors->has($name) ? 'border-red-500' : 'border-gray-300')]) }}
    >
        @foreach($options as $optionValue => $optionLabel)
            <option value="{{ $optionValue }}" @selected(old($name, $value) == $optionValue)>{{ $optionLabel }}</option>
        @endforeach
    </select>
    @error($name)
        <p class="mt-1 text-xs italic text-red-500">{{ $message }}</p>
    @enderror
</div>