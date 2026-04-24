@props(['name', 'label', 'options' => [], 'selected' => [], 'placeholder' => 'Selecione uma ou mais categorias...'])

@php
    $fieldName = str_replace('[]', '', $name);
    $initialSelected = collect($options)
        ->filter(fn($val, $key) => in_array((string)$key, array_map('strval', (array) old($fieldName, $selected))))
        ->map(fn($val, $key) => ['id' => $key, 'text' => $val])
        ->values();
@endphp

<div class="mb-4" x-data="{
    open: false,
    search: '',
    selected: {{ $initialSelected->toJson() }},
    options: {{ collect($options)->map(fn($val, $key) => ['id' => $key, 'text' => $val])->values()->toJson() }},
    get filteredOptions() {
        if (!this.search) return this.options.filter(i => !this.selected.find(s => s.id == i.id));
        return this.options.filter(i => 
            !this.selected.find(s => s.id == i.id) && 
            i.text.toLowerCase().includes(this.search.toLowerCase())
        );
    },
    add(option) {
        this.selected.push(option);
        this.search = '';
        this.open = false;
    },
    remove(id) {
        this.selected = this.selected.filter(i => i.id != id);
    }
}" @click.away="open = false">
    <label class="block mb-2 text-sm font-bold text-gray-700">
        {{ $label }}
    </label>
    
    <div class="relative">
        {{-- Área de Input e Tags --}}
        <div class="flex flex-wrap gap-1.5 p-2 bg-slate-50 border border-slate-200 rounded-xl min-h-[46px] cursor-text focus-within:bg-white focus-within:border-blue-500 focus-within:ring-2 focus-within:ring-blue-100 transition-all" @click="$refs.searchInput.focus()">
            <template x-for="item in selected" :key="item.id">
                <span class="inline-flex items-center gap-1.5 px-2 py-1 bg-blue-600 text-white text-[11px] font-bold rounded-lg shadow-sm border border-blue-700 group">
                    <span x-text="item.text"></span>
                    <button type="button" @click.stop="remove(item.id)" class="text-blue-200 hover:text-white transition-colors">
                        <i class="fa-solid fa-xmark"></i>
                    </button>
                    {{-- Input oculto para o envio do formulário --}}
                    <input type="hidden" name="{{ $fieldName }}[]" :value="item.id">
                </span>
            </template>
            <input 
                x-ref="searchInput"
                x-model="search" 
                @focus="open = true"
                @keydown.escape="open = false"
                @keydown.enter.prevent="if(filteredOptions.length > 0) add(filteredOptions[0])"
                placeholder="{{ $placeholder }}"
                class="flex-1 bg-transparent border-none outline-none text-sm text-slate-700 min-w-[120px] h-7 px-1"
            >
        </div>

        {{-- Dropdown de Opções --}}
        <div x-show="open && filteredOptions.length > 0" 
             class="absolute z-50 w-full mt-2 bg-white border border-slate-200 rounded-xl shadow-2xl max-h-60 overflow-y-auto py-1"
             x-transition:enter="transition ease-out duration-200"
             x-transition:enter-start="transform opacity-0 -translate-y-2"
             x-transition:enter-end="transform opacity-100 translate-y-0"
             style="display: none;">
            <template x-for="option in filteredOptions" :key="option.id">
                <div @click="add(option)" 
                     class="px-4 py-2.5 text-sm text-slate-700 hover:bg-blue-600 hover:text-white cursor-pointer transition-colors font-semibold flex items-center justify-between group">
                    <span x-text="option.text"></span>
                    <i class="fa-solid fa-plus text-[10px] opacity-0 group-hover:opacity-100 transition-opacity"></i>
                </div>
            </template>
        </div>
    </div>
    
    @error($fieldName)
        <p class="mt-1 text-xs italic text-red-500">{{ $message }}</p>
    @enderror
    @error($fieldName . '.*')
        <p class="mt-1 text-xs italic text-red-500">{{ $message }}</p>
    @enderror
</div>
