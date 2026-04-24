@extends('layouts.admin')

@section('content')
<div class="flex flex-col max-w-4xl gap-6 mx-auto">

    <x-admin.page-header
        title="Editar Serviço"
        :breadcrumbs="[
            ['label' => 'Dashboard', 'url' => route('admin.dashboard'), 'class' => 'hover:text-orange-600'],
            ['label' => 'Serviços', 'url' => route('admin.servicos.index'), 'class' => 'hover:text-orange-600'],
            ['label' => 'Editar'],
        ]"
    >
        <x-slot:action>
            <a href="{{ route('admin.servicos.index') }}" class="px-4 py-2 text-sm font-bold transition bg-white border rounded-lg text-slate-600 border-slate-300 hover:bg-slate-50 shadow-sm">
                Voltar
            </a>
        </x-slot:action>
    </x-admin.page-header>

    @if($errors->any())
        <div class="p-4 font-medium text-red-700 border border-red-200 bg-red-50 rounded-xl">
            <ul class="text-sm list-disc list-inside">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('admin.servicos.update', $servico->id) }}" method="POST" class="space-y-6">
        @csrf
        @method('PUT')

        <div class="p-6 space-y-6 bg-white border shadow-sm border-slate-200 rounded-xl">
            
            <div class="grid grid-cols-1 gap-6 md:grid-cols-2">
                <div class="md:col-span-2">
                    <label class="block mb-1.5 text-sm font-bold text-slate-700">Título do Serviço <span class="text-red-500">*</span></label>
                    <input type="text" name="titulo" value="{{ old('titulo', $servico->titulo) }}" required class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-lg focus:bg-white focus:ring-2 focus:ring-orange-500 focus:border-orange-500 outline-none transition-all">
                </div>

                {{-- NOVO CAMPO: Descrição --}}
                <div class="md:col-span-2">
                    <label class="block mb-1.5 text-sm font-bold text-slate-700">Descrição / Subtítulo <span class="text-xs font-normal text-slate-400">(Opcional)</span></label>
                    <textarea name="descricao" rows="2" maxlength="150" class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-lg focus:bg-white focus:ring-2 focus:ring-orange-500 focus:border-orange-500 outline-none transition-all resize-none">{{ old('descricao', $servico->descricao) }}</textarea>
                    <p class="mt-1 text-xs text-slate-400">Recomendamos até 80 caracteres para que o texto não fique cortado na página inicial.</p>
                </div>

                <div class="md:col-span-2">
                    <label class="block mb-1.5 text-sm font-bold text-slate-700">URL de Acesso Direto (Conecta, Gov.br, etc.) <span class="text-red-500">*</span></label>
                    <input type="url" name="link" value="{{ old('link', $servico->link) }}" required class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-lg focus:bg-white focus:ring-2 focus:ring-orange-500 focus:border-orange-500 outline-none transition-all">
                    <p class="mt-1 text-xs text-slate-400">O cidadão será redirecionado diretamente para esta URL ao clicar no cartão.</p>
                </div>

                <div class="md:col-span-1">
                    <label class="block mb-1.5 text-sm font-bold text-slate-700">Órgão / Secretaria Vinculada <span class="text-xs font-normal text-slate-400">(Opcional)</span></label>
                    <select name="secretaria_id" class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-lg focus:bg-white focus:ring-2 focus:ring-orange-500 outline-none transition-all">
                        <option value="">Serviço Geral (Sem vínculo específico)</option>
                        @foreach($secretarias as $sec)
                            <option value="{{ $sec->id }}" {{ old('secretaria_id', $servico->secretaria_id) == $sec->id ? 'selected' : '' }}>{{ $sec->nome }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="md:col-span-1">
                    <label class="block mb-1.5 text-sm font-bold text-slate-700">Tema / Categoria <span class="text-xs font-normal text-slate-400">(Opcional)</span></label>
                    <select name="categoria_id" class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-lg focus:bg-white focus:ring-2 focus:ring-orange-500 outline-none transition-all">
                        <option value="">Geral (Todos os perfis)</option>
                        @foreach($categorias as $id => $nome)
                            <option value="{{ $id }}" {{ old('categoria_id', $servico->categoria_id) == $id ? 'selected' : '' }}>{{ $nome }}</option>
                        @endforeach
                    </select>
                </div>

                {{-- ICON PICKER --}}
                <div class="md:col-span-2" x-data="iconPicker('{{ old('icone', $servico->icone ?? 'file-alt') }}')">
                    <label class="block mb-1.5 text-sm font-bold text-slate-700">
                        Ícone Representativo <span class="text-red-500">*</span>
                    </label>

                    {{-- Campo hidden que o form envia --}}
                    <input type="hidden" name="icone" :value="selected" required>

                    {{-- Preview + campo de busca --}}
                    <div class="flex items-center gap-3 mb-3">
                        <div class="flex items-center justify-center w-16 h-16 rounded-xl bg-orange-50 border border-orange-200 text-orange-600 shrink-0">
                            <i :class="'fas fa-' + selected + ' text-3xl'"></i>
                        </div>
                        <div class="flex-1">
                            <input type="text" x-model="search" placeholder="Buscar ícone (ex: documento, saúde, educação, tributo...)"
                                class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-lg focus:bg-white focus:ring-2 focus:ring-orange-500 focus:border-orange-500 outline-none transition-all text-sm">
                        </div>
                        <code class="text-sm text-slate-600 bg-slate-100 px-2.5 py-1 rounded font-mono whitespace-nowrap" x-text="'fa-' + selected"></code>
                    </div>

                    {{-- Grid de ícones --}}
                    <div class="border border-slate-200 rounded-xl bg-slate-50 p-4 max-h-80 overflow-y-auto space-y-4">
                        <template x-for="group in filteredGroups" :key="group.label">
                            <div>
                                <div class="sticky top-0 z-10 px-2 py-1.5 mb-2 text-[11px] font-bold tracking-wider uppercase rounded-md bg-slate-100 text-slate-600 border border-slate-200" x-text="group.label"></div>
                                <div class="grid grid-cols-4 sm:grid-cols-6 md:grid-cols-8 gap-2">
                                    <template x-for="icon in group.icons" :key="group.label + '-' + icon">
                                        <button type="button"
                                            @click="selected = icon"
                                            :title="'fa-' + icon"
                                            :class="selected === icon
                                                ? 'bg-orange-500 text-white border-orange-500 shadow-md scale-105'
                                                : 'bg-white text-slate-600 border-slate-200 hover:border-orange-400 hover:text-orange-600 hover:bg-orange-50'"
                                            class="flex flex-col items-center justify-center gap-1.5 p-2.5 rounded-xl border transition-all duration-150 aspect-square min-w-0">
                                            <i :class="'fas fa-' + icon + ' text-2xl'"></i>
                                            <span class="text-[10px] leading-none truncate w-full text-center" x-text="icon"></span>
                                        </button>
                                    </template>
                                </div>
                            </div>
                        </template>

                        <div x-show="filteredGroups.length === 0" class="text-center py-6 text-slate-400 text-sm">
                            Nenhum ícone encontrado para "<span x-text="search"></span>"
                        </div>
                    </div>
                    <p class="mt-1.5 text-xs text-slate-400">Clique no ícone desejado. Lista prioriza ícones comuns de serviços públicos e portais governamentais.</p>
                </div>

                <div class="flex items-center">
                    <label class="flex items-center gap-3 p-3 transition border cursor-pointer border-slate-200 rounded-xl hover:bg-slate-50 w-full">
                        <input type="checkbox" name="ativo" value="1" {{ old('ativo', $servico->ativo) ? 'checked' : '' }} class="w-5 h-5 border-gray-300 rounded text-orange-600 focus:ring-orange-500">
                        <div>
                            <span class="block text-sm font-bold text-slate-700">Serviço Ativo</span>
                            <span class="block text-xs text-slate-500">Visível no catálogo do portal.</span>
                        </div>
                    </label>
                </div>
            </div>

        </div>

        <div class="flex justify-end">
            <button type="submit" class="flex items-center gap-2 px-8 py-3 font-bold text-white transition rounded-xl bg-amber-500 hover:bg-amber-600 shadow-md">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path></svg>
                Atualizar Serviço
            </button>
        </div>
    </form>
</div>

@push('scripts')
<script>
window.iconPicker = function(initial) {
    return {
        selected: initial || 'file-alt',
        search: '',
        iconGroups: [
            { label: 'Institucional e Cidadão', icons: ['home','city','building','landmark','flag','university','school','graduation-cap','book','book-open','id-card','id-badge','address-card','address-book','passport','user','users','user-tie','user-check','user-plus','user-cog'] },
            { label: 'Documentos e Processos', icons: ['clipboard','clipboard-check','file','file-alt','file-lines','file-signature','file-invoice','file-invoice-dollar','file-medical','file-pdf','folder','folder-open','calendar','calendar-alt','calendar-check','clock','history','tasks'] },
            { label: 'Saúde e Assistência', icons: ['hospital','heartbeat','stethoscope','ambulance','syringe','pills','briefcase-medical','notes-medical','hand-holding-medical'] },
            { label: 'Segurança e Jurídico', icons: ['gavel','balance-scale','scale-balanced','shield-alt','lock','lock-open','key','fingerprint','user-lock'] },
            { label: 'Finanças e Tributos', icons: ['money-bill','money-bill-wave','coins','wallet','credit-card','receipt','calculator','chart-line','chart-bar','chart-pie'] },
            { label: 'Mobilidade e Território', icons: ['bus','car','road','traffic-light','map','map-marked-alt','map-marker-alt','route','parking','truck','warehouse'] },
            { label: 'Digital e Atendimento', icons: ['wifi','mobile-alt','laptop','desktop','database','server','cloud','globe','search','print','phone','phone-alt','envelope','envelope-open','comment','comments','bullhorn','newspaper','info-circle','question-circle'] },
            { label: 'Utilitários', icons: ['leaf','tree','recycle','sun','tint','water','seedling','tools','wrench','hammer','hard-hat','store','shopping-cart','external-link-alt','download','upload','link','share','plus-circle','minus-circle','edit','save','trash-alt','check-circle','exclamation-triangle','times-circle'] }
        ],
        get filteredGroups() {
            const q = this.search.toLowerCase().trim();
            if (!q) return this.iconGroups;

            return this.iconGroups
                .map(group => ({
                    label: group.label,
                    icons: group.icons.filter(icon => icon.includes(q) || group.label.toLowerCase().includes(q))
                }))
                .filter(group => group.icons.length > 0);
        }
    };
};
</script>
@endpush
@endsection
