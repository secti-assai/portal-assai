@props([
    'name',
    'label',
    'id' => null,
    'accept' => 'image/*',
    'helpText' => null,
    'placeholderText' => 'Clique para fazer upload',
    'changeText' => 'Trocar Imagem',
    'previewSrc' => null,
    'required' => false,
])

@php
    $inputId = $id ?? $name;
    $placeholderId = $inputId . '-placeholder';
    $previewContainerId = $inputId . '-preview-container';
    $previewId = $inputId . '-preview';
@endphp

<div class="mb-4">
    <label for="{{ $inputId }}" class="block mb-2 text-sm font-bold text-gray-700">{{ $label }}</label>
    <div class="relative mt-2 overflow-hidden border border-dashed rounded-lg border-slate-300 bg-slate-50" style="min-height:160px;">
        <div id="{{ $placeholderId }}" class="absolute inset-0 flex flex-col items-center justify-center gap-2 cursor-pointer transition hover:bg-slate-100 {{ $previewSrc ? 'hidden' : '' }}" onclick="document.getElementById('{{ $inputId }}').click()">
            <svg class="w-12 h-12 text-slate-300" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true"><path fill-rule="evenodd" d="M1.5 6a2.25 2.25 0 012.25-2.25h16.5A2.25 2.25 0 0122.5 6v12a2.25 2.25 0 01-2.25 2.25H3.75A2.25 2.25 0 011.5 18V6zM3 16.06V18c0 .414.336.75.75.75h16.5A.75.75 0 0021 18v-1.94l-2.69-2.689a1.5 1.5 0 00-2.12 0l-.88.879.97.97a.75.75 0 11-1.06 1.06l-5.16-5.159a1.5 1.5 0 00-2.12 0L3 16.061zm10.125-7.81a1.125 1.125 0 112.25 0 1.125 1.125 0 01-2.25 0z" clip-rule="evenodd" /></svg>
            <p class="text-sm font-semibold text-blue-600">{{ $placeholderText }}</p>
            @if($helpText)
                <p class="text-xs text-slate-400">{{ $helpText }}</p>
            @endif
        </div>

        <div id="{{ $previewContainerId }}" class="absolute inset-0 z-20 {{ $previewSrc ? '' : 'hidden' }}">
            <img id="{{ $previewId }}" src="{{ $previewSrc }}" alt="Pré-visualização" class="object-cover w-full h-full">
            <label for="{{ $inputId }}" class="absolute inset-0 flex items-center justify-center cursor-pointer backdrop-blur-sm bg-slate-900/60 opacity-0 hover:opacity-100 transition-opacity duration-200" aria-label="{{ $changeText }}">
                <span class="text-sm font-bold text-white">{{ $changeText }}</span>
            </label>
        </div>

        <input id="{{ $inputId }}" name="{{ $name }}" type="file" accept="{{ $accept }}" class="sr-only" {{ $required ? 'required' : '' }} onchange="previewImage(event, '{{ $previewId }}', '{{ $previewContainerId }}', '{{ $placeholderId }}')">
    </div>
    @error($name)
        <p class="mt-1 text-xs italic text-red-500">{{ $message }}</p>
    @enderror
</div>