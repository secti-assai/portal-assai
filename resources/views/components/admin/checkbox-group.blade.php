@props(['name', 'label', 'options' => [], 'selected' => [], 'columns' => 2])

@php
    $fieldName = str_replace('[]', '', $name);
    $selectedValues = (array) old($fieldName, $selected);
@endphp

<div class="mb-4">
    <label class="block mb-2 text-sm font-bold text-gray-700">
        {{ $label }}
    </label>
    <div class="grid grid-cols-1 md:grid-cols-{{ $columns }} gap-3">
        @foreach($options as $val => $lab)
            <label class="flex items-center gap-3 p-3 bg-slate-50 border border-slate-200 rounded-xl cursor-pointer hover:bg-white hover:border-blue-400 hover:shadow-sm transition-all group relative overflow-hidden">
                <div class="absolute inset-0 bg-blue-50 opacity-0 group-hover:opacity-100 transition-opacity pointer-events-none"></div>
                <input type="checkbox" name="{{ $fieldName }}[]" value="{{ $val }}" 
                    @checked(in_array((string)$val, array_map('strval', $selectedValues)))
                    class="relative z-10 w-5 h-5 text-blue-600 border-slate-300 rounded focus:ring-blue-500 focus:ring-offset-0 transition-all cursor-pointer"
                >
                <span class="relative z-10 text-sm font-bold text-slate-700 group-hover:text-blue-700 transition-colors">{{ $lab }}</span>
            </label>
        @endforeach
    </div>
    @error($fieldName)
        <p class="mt-1 text-xs italic text-red-500">{{ $message }}</p>
    @enderror
    @error($fieldName . '.*')
        <p class="mt-1 text-xs italic text-red-500">{{ $message }}</p>
    @enderror
</div>
