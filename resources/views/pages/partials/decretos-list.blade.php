<div class="overflow-x-auto">
    <table class="w-full text-left border-collapse">
        <thead>
            <tr class="bg-blue-900 text-white">
                <th class="p-5 font-bold uppercase tracking-wider text-sm w-32">Número</th>
                <th class="p-5 font-bold uppercase tracking-wider text-sm w-40">Tipo</th>
                <th class="p-5 font-bold uppercase tracking-wider text-sm w-32 text-center">Data</th>
                <th class="p-5 font-bold uppercase tracking-wider text-sm">Súmula / Ementa</th>
                <th class="p-5 font-bold uppercase tracking-wider text-sm w-32 text-center">PDF</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-slate-100">
            @forelse($decretos as $decreto)
                <tr class="hover:bg-slate-50 transition-colors">
                    <td class="p-5 font-extrabold text-blue-900">
                        {{ $decreto->numero }}
                    </td>
                    <td class="p-5">
                        @if($decreto->tipo)
                            <span class="px-3 py-1 bg-slate-100 text-slate-600 text-xs font-bold uppercase rounded-full border border-slate-200">
                                {{ $decreto->tipo }}
                            </span>
                        @else
                            <span class="text-slate-300 italic text-xs">N/A</span>
                        @endif
                    </td>
                    <td class="p-5 text-center text-slate-600 font-medium">
                        {{ $decreto->data_publicacao->format('d/m/Y') }}
                    </td>
                    <td class="p-5">
                        <p class="text-slate-700 leading-relaxed">{{ $decreto->sumula }}</p>
                    </td>
                    <td class="p-5 text-center">
                        @php
                            $link = $decreto->caminho_local ? asset('storage/' . $decreto->caminho_local) : $decreto->pdf_url;
                        @endphp
                        @if($link)
                            <a href="{{ $link }}" target="_blank" class="inline-flex items-center justify-center w-12 h-12 rounded-full bg-blue-50 text-blue-600 hover:bg-blue-600 hover:text-white transition-all shadow-sm border border-blue-100" title="Ver Documento">
                                <i class="fa-solid fa-file-pdf text-xl"></i>
                            </a>
                        @else
                            <span class="text-slate-300 text-sm font-medium italic">Não disponível</span>
                        @endif
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="5" class="p-20 text-center">
                        <div class="flex flex-col items-center">
                            <i class="fa-solid fa-folder-open text-5xl text-slate-200 mb-4"></i>
                            <p class="text-slate-500 font-medium text-lg">Nenhum decreto encontrado com os filtros selecionados.</p>
                            <a href="javascript:void(0)" onclick="window.clearFilters()" class="mt-4 text-blue-600 font-bold hover:underline">Limpar filtros e ver todos</a>
                        </div>
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>

@if($decretos->hasPages())
    <div class="p-6 bg-slate-50 border-t border-slate-100">
        {{ $decretos->links() }}
    </div>
@endif
