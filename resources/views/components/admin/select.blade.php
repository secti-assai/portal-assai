@props(['name', 'label', 'options' => [], 'value' => null, 'required' => false, 'placeholder' => null])

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
        @if($placeholder)
            <option value="">{{ $placeholder }}</option>
        @endif
        @php
            $oldValue = old(str_replace('[]', '', $name), $value);
            $isSelected = function($optVal) use ($oldValue, $attributes) {
                if ($attributes->has('multiple')) {
                    return in_array($optVal, (array) $oldValue);
                }
                return $oldValue == $optVal;
            };
        @endphp
        @foreach($options as $optionValue => $optionLabel)
            <option value="{{ $optionValue }}" @selected($isSelected($optionValue))>{{ $optionLabel }}</option>
        @endforeach
    </select>
    @error($name)
        <p class="mt-1 text-xs italic text-red-500">{{ $message }}</p>
    @enderror
</div>