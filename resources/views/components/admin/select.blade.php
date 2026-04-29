@props(['name', 'label', 'options' => [], 'value' => null, 'required' => false, 'placeholder' => null])

<div class="mb-4">
    <label for="{{ $name }}" class="block mb-2 text-sm font-bold text-gray-700">
        {{ $label }} @if($required) <span class="text-red-500">*</span> @endif
    </label>
    <div class="relative">
        <select
            name="{{ $name }}"
            id="{{ $name }}"
            {{ $required ? 'required' : '' }}
            {{ $attributes->merge(['class' => 'w-full px-4 py-2.5 leading-tight text-gray-700 border rounded-lg shadow-sm appearance-none focus:outline-none focus:ring-2 focus:ring-blue-500 transition-all ' . ($errors->has($name) ? 'border-red-500' : 'border-gray-300')]) }}
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
        <div class="absolute inset-y-0 right-0 flex items-center px-3 pointer-events-none text-gray-500">
            <i class="fa-solid fa-chevron-down text-xs"></i>
        </div>
    </div>
    @error($name)
        <p class="mt-1 text-xs italic text-red-500">{{ $message }}</p>
    @enderror
</div>