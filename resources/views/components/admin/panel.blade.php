@props(['title' => null])

<div {{ $attributes->merge(['class' => 'p-6 bg-white border shadow-sm border-slate-200 rounded-xl']) }}>
    @if($title)
        <h3 class="pb-3 mb-4 font-bold border-b text-slate-800 border-slate-100">{{ $title }}</h3>
    @endif

    {{ $slot }}
</div>