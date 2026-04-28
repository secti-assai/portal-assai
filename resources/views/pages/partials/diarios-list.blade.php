<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mb-10">
    @forelse($diarios as $diario)
        <div class="bg-white rounded-2xl shadow-sm border border-slate-200 overflow-hidden hover:shadow-xl hover:-translate-y-1 transition-all duration-300 group">
            <div class="bg-blue-900 p-4 flex justify-between items-center text-white">
                <span class="text-sm font-bold opacity-80 uppercase">Edição #{{ $diario->edicao }}</span>
                <i class="fa-solid fa-newspaper text-xl opacity-50"></i>
            </div>
            <div class="p-6">
                <div class="flex items-center gap-3 text-slate-500 mb-4 font-bold text-sm uppercase">
                    <i class="fa-regular fa-calendar-days text-blue-600 text-lg"></i>
                    {{ $diario->data_publicacao->translatedFormat('d \d\e F \d\e Y') }}
                </div>
                
                <div class="space-y-3 mb-6">
                    @if($diario->assinante_nome)
                        <div class="flex gap-2 text-sm">
                            <span class="text-slate-400 font-bold w-20 shrink-0">Assinado:</span>
                            <span class="text-slate-700 font-medium truncate">{{ $diario->assinante_nome }}</span>
                        </div>
                    @endif
                    <div class="flex gap-2 text-sm">
                        <span class="text-slate-400 font-bold w-20 shrink-0">Status:</span>
                        <span class="inline-flex items-center gap-1.5 text-emerald-600 font-bold">
                            <i class="fa-solid fa-circle-check text-[10px]"></i>
                            Autenticado
                        </span>
                    </div>
                </div>

                @php
                    $link = $diario->caminho_local ? asset('storage/' . $diario->caminho_local) : $diario->pdf_url;
                @endphp
                
                @if($link)
                    <a href="{{ $link }}" target="_blank" class="flex items-center justify-center gap-2 w-full py-3.5 bg-blue-50 text-blue-600 hover:bg-blue-600 hover:text-white font-extrabold rounded-xl transition-all border border-blue-100 group-hover:border-blue-600">
                        <i class="fa-solid fa-file-pdf"></i>
                        Visualizar Edição
                    </a>
                @else
                    <div class="w-full py-3.5 bg-slate-50 text-slate-400 text-center font-bold rounded-xl border border-dashed border-slate-200">
                        Aguardando PDF
                    </div>
                @endif
            </div>
        </div>
    @empty
        <div class="col-span-full p-20 bg-white rounded-2xl border border-dashed border-slate-200 text-center">
            <i class="fa-solid fa-newspaper text-5xl text-slate-100 mb-4"></i>
            <p class="text-slate-500 font-medium">Nenhum diário oficial encontrado.</p>
            <a href="javascript:void(0)" onclick="window.clearFilters()" class="mt-4 text-blue-600 font-bold hover:underline">Limpar filtros e ver todos</a>
        </div>
    @endforelse
</div>

@if($diarios->hasPages())
    <div class="mt-8 flex justify-center">
        {{ $diarios->links() }}
    </div>
@endif
