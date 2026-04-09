@if ($paginator->hasPages())
<div class="rounded-2xl border border-slate-200 bg-white p-4 sm:p-5 shadow-sm">
    <div class="flex flex-col gap-4 lg:flex-row lg:items-center lg:justify-between">
        <p class="text-sm text-slate-700">
            Mostrando
            <span class="font-bold text-slate-900">{{ $paginator->firstItem() }}</span>
            a
            <span class="font-bold text-slate-900">{{ $paginator->lastItem() }}</span>
            de
            <span class="font-bold text-slate-900">{{ $paginator->total() }}</span>
            resultados
        </p>

        <nav class="flex flex-wrap items-center gap-2" role="navigation" aria-label="Paginação">
            @if ($paginator->onFirstPage())
            <span class="inline-flex items-center rounded-lg border border-slate-200 bg-slate-100 px-3 py-2 text-sm font-semibold text-slate-400 cursor-not-allowed">Anterior</span>
            @else
            <a href="{{ $paginator->previousPageUrl() }}" class="inline-flex items-center rounded-lg border border-slate-300 bg-white px-3 py-2 text-sm font-semibold text-slate-700 hover:bg-slate-50 transition-colors" rel="prev">Anterior</a>
            @endif

            @foreach ($elements as $element)
                @if (is_string($element))
                <span class="inline-flex min-w-[2.25rem] items-center justify-center rounded-lg border border-slate-200 bg-slate-100 px-3 py-2 text-sm font-semibold text-slate-500">{{ $element }}</span>
                @endif

                @if (is_array($element))
                    @foreach ($element as $page => $url)
                        @if ($page == $paginator->currentPage())
                        <span aria-current="page" class="inline-flex min-w-[2.25rem] items-center justify-center rounded-lg border border-blue-700 bg-blue-700 px-3 py-2 text-sm font-bold text-white">{{ $page }}</span>
                        @else
                        <a href="{{ $url }}" class="inline-flex min-w-[2.25rem] items-center justify-center rounded-lg border border-slate-300 bg-white px-3 py-2 text-sm font-semibold text-slate-700 hover:bg-blue-50 hover:text-blue-800 hover:border-blue-200 transition-colors" aria-label="Ir para página {{ $page }}">{{ $page }}</a>
                        @endif
                    @endforeach
                @endif
            @endforeach

            @if ($paginator->hasMorePages())
            <a href="{{ $paginator->nextPageUrl() }}" class="inline-flex items-center rounded-lg border border-slate-300 bg-white px-3 py-2 text-sm font-semibold text-slate-700 hover:bg-slate-50 transition-colors" rel="next">Próxima</a>
            @else
            <span class="inline-flex items-center rounded-lg border border-slate-200 bg-slate-100 px-3 py-2 text-sm font-semibold text-slate-400 cursor-not-allowed">Próxima</span>
            @endif
        </nav>
    </div>
</div>
@endif