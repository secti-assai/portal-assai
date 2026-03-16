@props(['items' => [], 'dark' => false])

@php
    $textMuted = $dark ? 'text-blue-200' : 'text-slate-500';
    $textActive = $dark ? 'text-white' : 'text-slate-800';
    $hoverColor = $dark ? 'hover:text-white' : 'hover:text-blue-600';
    $iconColor = $dark ? 'text-blue-300' : 'text-slate-400';
@endphp

<nav aria-label="Breadcrumb" class="mb-6">
    <ol class="flex flex-wrap items-center gap-2 text-sm {{ $textMuted }}">
        @foreach($items as $item)
            @if(!$loop->last)
                <li>
                    <a href="{{ $item['url'] }}" class="transition-colors {{ $hoverColor }}">
                        {{ $item['name'] }}
                    </a>
                </li>
                <li>
                    <svg class="w-3 h-3 {{ $iconColor }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                    </svg>
                </li>
            @else
                <li aria-current="page">
                    <span class="font-bold truncate max-w-[200px] md:max-w-md block {{ $textActive }}">
                        {{ $item['name'] }}
                    </span>
                </li>
            @endif
        @endforeach
    </ol>
</nav>