@extends('layouts.admin')

@section('content')
<div class="flex flex-col max-w-4xl gap-6 mx-auto">

    <x-admin.page-header
        title="Criar Novo Serviço"
        :breadcrumbs="[
            ['label' => 'Dashboard', 'url' => route('admin.dashboard'), 'class' => 'hover:text-orange-600'],
            ['label' => 'Serviços', 'url' => route('admin.servicos.index'), 'class' => 'hover:text-orange-600'],
            ['label' => 'Novo'],
        ]"
    >
        <x-slot:action>
            <a href="{{ route('admin.servicos.index') }}" class="px-4 py-2 text-sm font-bold transition bg-white border rounded-lg text-slate-600 border-slate-300 hover:bg-slate-50 shadow-sm">
                Cancelar
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

    <form action="{{ route('admin.servicos.store') }}" method="POST" class="space-y-6">
        @csrf

        <div class="p-6 space-y-6 bg-white border shadow-sm border-slate-200 rounded-xl">
            
            <div class="grid grid-cols-1 gap-6 md:grid-cols-2">
                <div class="md:col-span-2">
                    <label class="block mb-1.5 text-sm font-bold text-slate-700">Título do Serviço <span class="text-red-500">*</span></label>
                    <input type="text" name="titulo" value="{{ old('titulo') }}" required placeholder="Ex: Emissão de Alvará" class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-lg focus:bg-white focus:ring-2 focus:ring-orange-500 focus:border-orange-500 outline-none transition-all">
                </div>

                {{-- NOVO CAMPO: Descrição --}}
                <div class="md:col-span-2">
                    <label class="block mb-1.5 text-sm font-bold text-slate-700">Descrição / Subtítulo <span class="text-xs font-normal text-slate-400">(Opcional)</span></label>
                    <textarea name="descricao" rows="2" maxlength="150" placeholder="Breve resumo do serviço..." class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-lg focus:bg-white focus:ring-2 focus:ring-orange-500 focus:border-orange-500 outline-none transition-all resize-none">{{ old('descricao') }}</textarea>
                    <p class="mt-1 text-xs text-slate-400">Recomendamos até 80 caracteres para que o texto não fique cortado na página inicial.</p>
                </div>

                <div class="md:col-span-2">
                    <label class="block mb-1.5 text-sm font-bold text-slate-700">URL de Acesso Direto (Conecta, Gov.br, etc.) <span class="text-red-500">*</span></label>
                    <input type="url" name="link" value="{{ old('link') }}" required placeholder="https://conecta.assai.pr.gov.br/..." class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-lg focus:bg-white focus:ring-2 focus:ring-orange-500 focus:border-orange-500 outline-none transition-all">
                    <p class="mt-1 text-xs text-slate-400">O cidadão será redirecionado diretamente para esta URL ao clicar no cartão.</p>
                </div>

                <div class="md:col-span-2">
                    <label class="block mb-1.5 text-sm font-bold text-slate-700">Órgão / Secretaria Vinculada <span class="text-xs font-normal text-slate-400">(Opcional)</span></label>
                    <select name="secretaria_id" class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-lg focus:bg-white focus:ring-2 focus:ring-orange-500 outline-none transition-all">
                        <option value="">Serviço Geral (Sem vínculo específico)</option>
                        @foreach($secretarias as $sec)
                            <option value="{{ $sec->id }}" {{ old('secretaria_id') == $sec->id ? 'selected' : '' }}>{{ $sec->nome }}</option>
                        @endforeach
                    </select>
                </div>

                {{-- ICON PICKER --}}
                <div class="md:col-span-2" x-data="iconPicker('{{ old('icone', 'file-alt') }}')">
                    <label class="block mb-1.5 text-sm font-bold text-slate-700">
                        Ícone Representativo <span class="text-red-500">*</span>
                    </label>

                    {{-- Campo hidden que o form envia --}}
                    <input type="hidden" name="icone" :value="selected" required>

                    {{-- Preview + campo de busca --}}
                    <div class="flex items-center gap-3 mb-3">
                        <div class="flex items-center justify-center w-12 h-12 rounded-xl bg-orange-50 border border-orange-200 text-orange-600 shrink-0">
                            <i :class="'fas fa-' + selected + ' text-xl'"></i>
                        </div>
                        <div class="flex-1">
                            <input type="text" x-model="search" placeholder="Buscar ícone (ex: home, user, file...)"
                                class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-lg focus:bg-white focus:ring-2 focus:ring-orange-500 focus:border-orange-500 outline-none transition-all text-sm">
                        </div>
                        <code class="text-xs text-slate-500 bg-slate-100 px-2 py-1 rounded font-mono whitespace-nowrap" x-text="'fa-' + selected"></code>
                    </div>

                    {{-- Grid de ícones --}}
                    <div class="border border-slate-200 rounded-xl bg-slate-50 p-3 max-h-60 overflow-y-auto">
                        <div class="grid grid-cols-6 sm:grid-cols-8 md:grid-cols-10 gap-1.5">
                            <template x-for="icon in filteredIcons" :key="icon">
                                <button type="button"
                                    @click="selected = icon"
                                    :title="'fa-' + icon"
                                    :class="selected === icon
                                        ? 'bg-orange-500 text-white border-orange-500 shadow-md scale-105'
                                        : 'bg-white text-slate-600 border-slate-200 hover:border-orange-400 hover:text-orange-600 hover:bg-orange-50'"
                                    class="flex flex-col items-center justify-center gap-1 p-2 rounded-lg border transition-all duration-150 aspect-square min-w-0">
                                    <i :class="'fas fa-' + icon + ' text-base'"></i>
                                    <span class="text-[9px] leading-none truncate w-full text-center" x-text="icon"></span>
                                </button>
                            </template>
                            <div x-show="filteredIcons.length === 0" class="col-span-full text-center py-6 text-slate-400 text-sm">
                                Nenhum ícone encontrado para "<span x-text="search"></span>"
                            </div>
                        </div>
                    </div>
                    <p class="mt-1.5 text-xs text-slate-400">Clique no ícone desejado. Use a busca para filtrar por nome.</p>
                </div>

                <div class="flex items-center">
                    <label class="flex items-center gap-3 p-3 transition border cursor-pointer border-slate-200 rounded-xl hover:bg-slate-50 w-full">
                        <input type="checkbox" name="ativo" value="1" {{ old('ativo', '1') == '1' ? 'checked' : '' }} class="w-5 h-5 border-gray-300 rounded text-orange-600 focus:ring-orange-500">
                        <div>
                            <span class="block text-sm font-bold text-slate-700">Serviço Ativo</span>
                            <span class="block text-xs text-slate-500">Visível no catálogo do portal.</span>
                        </div>
                    </label>
                </div>
            </div>

        </div>

        <div class="flex justify-end">
            <button type="submit" class="flex items-center gap-2 px-8 py-3 font-bold text-white transition rounded-xl bg-orange-500 hover:bg-orange-600 shadow-md">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                Salvar Serviço
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
        icons: [
            'address-book','address-card','adjust','arrow-circle-down','arrow-circle-left','arrow-circle-right','arrow-circle-up',
            'arrow-down','arrow-left','arrow-right','arrow-up','asterisk','at','baby','ban','bars','bell','bell-slash',
            'book','book-open','bookmark','briefcase','building','bullhorn','bullseye','bus','calendar','calendar-alt',
            'calendar-check','calendar-times','camera','car','chart-bar','chart-line','chart-pie','check','check-circle',
            'check-square','chess','city','clipboard','clock','cloud','code','cog','cogs','comment','comment-alt',
            'comments','compass','credit-card','database','desktop','dizzy','dollar-sign','door-open','download',
            'edit','ellipsis-h','ellipsis-v','envelope','envelope-open','eraser','exclamation','exclamation-circle',
            'exclamation-triangle','external-link-alt','eye','eye-slash','fax','file','file-alt','file-archive',
            'file-audio','file-code','file-excel','file-image','file-invoice','file-invoice-dollar','file-lines',
            'file-medical','file-pdf','file-signature','file-video','file-word','filter','flag','folder','folder-open',
            'font','forward','frown','gavel','globe','graduation-cap','grip-horizontal','grip-vertical','hand-holding',
            'hand-holding-heart','hand-holding-usd','hands-helping','handshake','hashtag','headset','heart','heart-pulse',
            'history','home','hospital','hourglass','id-badge','id-card','image','inbox','info','info-circle',
            'key','landmark','laptop','layer-group','leaf','lightbulb','link','list','list-alt','location-arrow',
            'lock','lock-open','magic','magnifying-glass','map','map-marker','map-marker-alt','map-pin','medal',
            'microphone','minus','minus-circle','mobile','mobile-alt','money-bill','money-bill-wave','moon',
            'newspaper','paint-brush','paperclip','parking','passport','pause','pencil-alt','people-arrows',
            'percent','person-running','phone','phone-alt','phone-volume','place-of-worship','plane','plus',
            'plus-circle','poll','print','puzzle-piece','question','question-circle','receipt','recycle','redo',
            'reply','robot','running','save','scale-balanced','school','search','share','shield-alt','sign-in-alt',
            'sign-out-alt','sitemap','smile','sort','star','star-half-alt','sticky-note','store','sun','syringe',
            'table','tag','tags','tasks','thumbs-down','thumbs-up','times','times-circle','toggle-off','toggle-on',
            'tools','tooth','trash','trash-alt','tree','trophy','truck','umbrella','undo','university','unlock',
            'upload','user','user-check','user-circle','user-cog','user-friends','user-graduate','user-lock',
            'user-md','user-minus','user-plus','user-shield','user-slash','user-tag','user-tie','users',
            'users-cog','video','vote-yea','wallet','warehouse','wifi','wrench','x-ray'
        ],
        get filteredIcons() {
            if (!this.search.trim()) return this.icons;
            const q = this.search.toLowerCase().trim();
            return this.icons.filter(i => i.includes(q));
        }
    };
};
</script>
@endpush
@endsection