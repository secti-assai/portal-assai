<div class="bg-white p-5 rounded-2xl border border-gray-100 shadow-sm">

    {{-- Cabeçalho --}}
    <div class="flex items-center justify-between mb-4">
        <button
            type="button"
            aria-label="Mês anterior"
            data-url="{{ route('agenda.index', ['mes' => $mesAnterior]) }}"
            onclick="carregarCalendario(this.dataset.url)"
            class="p-1.5 text-gray-400 hover:text-blue-600 hover:bg-blue-50 rounded-lg transition">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
            </svg>
        </button>
        <span class="text-sm font-bold text-gray-800 uppercase tracking-wide">
            {{ Str::ucfirst($tituloMes) }}
        </span>
        <button
            type="button"
            aria-label="Próximo mês"
            data-url="{{ route('agenda.index', ['mes' => $mesProximo]) }}"
            onclick="carregarCalendario(this.dataset.url)"
            class="p-1.5 text-gray-400 hover:text-blue-600 hover:bg-blue-50 rounded-lg transition">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
            </svg>
        </button>
    </div>

    {{-- Cabeçalho dos dias da semana --}}
    <div class="grid grid-cols-7 gap-1 mb-2">
        @foreach (['Dom', 'Seg', 'Ter', 'Qua', 'Qui', 'Sex', 'Sáb'] as $dds)
            <span class="text-center text-[10px] font-bold text-gray-400 uppercase">{{ $dds }}</span>
        @endforeach
    </div>

    {{-- Grade de dias --}}
    <div class="grid grid-cols-7 gap-y-1 gap-x-1">

        {{-- Células vazias antes do dia 1 --}}
        @for ($i = 0; $i < $primeiroDiaSemana; $i++)
            <span class="w-8 h-8 mx-auto block"></span>
        @endfor

        {{-- Dias do mês --}}
        @for ($dia = 1; $dia <= $diasNoMes; $dia++)
            @php
                $dataAtualLoop = $dataBase->copy()->day($dia)->format('Y-m-d');
                $isHoje        = $dataAtualLoop === now()->format('Y-m-d');
                $eventosDia    = $eventosPorDia[$dataAtualLoop] ?? [];
                $temEvento     = count($eventosDia) > 0;
            @endphp
            <button
                type="button"
                data-dia="{{ $dataAtualLoop }}"
                @if($temEvento) data-eventos='@json($eventosDia)' @endif
                onclick="window.abrirPreviewEvento(this)"
                title="{{ \Carbon\Carbon::parse($dataAtualLoop)->translatedFormat('d \d\e F') }}"
                class="w-8 h-8 mx-auto flex items-center justify-center text-sm rounded-full transition-all
                    @if ($isHoje) bg-blue-600 text-white font-bold shadow-md shadow-blue-500/30
                    @elseif ($temEvento) bg-blue-50 text-blue-700 font-bold border border-blue-200
                    @else text-gray-700 hover:bg-gray-100
                    @endif"
            >{{ $dia }}</button>
        @endfor

    </div>
</div>
