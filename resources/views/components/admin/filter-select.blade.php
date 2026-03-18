@props(['name', 'options' => [], 'value' => '', 'placeholder' => null, 'submitOnChange' => true])

<select
    name="{{ $name }}"
    @if($submitOnChange) onchange="this.form.submit()" @endif
    {{ $attributes->merge(['class' => 'py-1.5 px-2 text-sm border border-slate-200 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none bg-white w-full sm:w-auto']) }}
>
    @if($placeholder !== null)
        <option value="">{{ $placeholder }}</option>
    @endif

    @foreach($options as $optionValue => $optionLabel)
        @continue($placeholder !== null && (string) $optionValue === '')
        <option value="{{ $optionValue }}" @selected((string) $value === (string) $optionValue)>{{ $optionLabel }}</option>
    @endforeach
</select>