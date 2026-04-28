<div class="overflow-x-auto">
    <table class="w-full text-left border-collapse">
        <thead>
            <tr class="bg-blue-900 text-white">
                <th class="p-5 font-bold uppercase tracking-wider text-sm w-40">Número</th>
                <th class="p-5 font-bold uppercase tracking-wider text-sm w-32 text-center">Data</th>
                <th class="p-5 font-bold uppercase tracking-wider text-sm">Súmula / Ementa</th>
                <th class="p-5 font-bold uppercase tracking-wider text-sm w-32 text-center">Download</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-slate-100">
            @forelse($portarias as $portaria)
                <tr class="hover:bg-slate-50 transition-colors">
                    <td class="p-5 font-extrabold text-blue-900">
                        {{ $portaria->numero }}
                    </td>
                    <td class="p-5 text-center text-slate-600 font-medium">
                        {{ $portaria->data_publicacao->format('d/m/Y') }}
                    </td>
                    <td class="p-5">
                        <p class="text-slate-700 leading-relaxed">{{ $portaria->sumula }}</p>
                    </td>
                    <td class="p-5 text-center">
                        @php
                            $link = $portaria->caminho_local ? asset('storage/' . $portaria->caminho_local) : $portaria->pdf_url;
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
                    <td colspan="4" class="p-20 text-center">
                        <div class="flex flex-col items-center">
                            <i class="fa-solid fa-folder-open text-5xl text-slate-200 mb-4"></i>
                            <p class="text-slate-500 font-medium text-lg">Nenhuma portaria encontrada com os filtros selecionados.</p>
                            <a href="javascript:void(0)" onclick="window.clearFilters()" class="mt-4 text-blue-600 font-bold hover:underline">Limpar filtros e ver todas</a>
                        </div>
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>

@if($portarias->hasPages())
    <div class="p-6 bg-slate-50 border-t border-slate-100">
        {{ $portarias->links() }}
    </div>
@endif
