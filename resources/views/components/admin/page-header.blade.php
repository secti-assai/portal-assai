@props(['title', 'breadcrumbs' => []])

<div class="flex flex-col items-start sm:flex-row sm:items-center sm:justify-between gap-4">
    <div>
        @if(!empty($breadcrumbs))
            <nav class="flex flex-wrap items-center gap-2 mb-2 text-sm text-slate-500">
                @foreach($breadcrumbs as $index => $item)
                    @if($index > 0)
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                    @endif

                    @if(!empty($item['url']))
                        <a href="{{ $item['url'] }}" class="transition {{ $item['class'] ?? 'hover:text-blue-600' }}">{{ $item['label'] }}</a>
                    @else
                        <span class="font-bold text-slate-700">{{ $item['label'] }}</span>
                    @endif
                @endforeach
            </nav>
        @endif

        <h1 class="text-2xl sm:text-3xl font-bold text-slate-800">{{ $title }}</h1>
    </div>

    @isset($action)
        <div class="w-full sm:w-auto">
            {{ $action }}
        </div>
    @endisset
</div>