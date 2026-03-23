@extends('layouts.admin')

@section('content')
<div class="flex flex-col max-w-4xl gap-6 mx-auto">

    <x-admin.page-header
        title="Novo Usuários"
        :breadcrumbs="[
            ['label' => 'Dashboard', 'url' => route('admin.dashboard'), 'class' => 'hover:text-blue-600'],
            ['label' => 'Usuários', 'url' => route('users.index'), 'class' => 'hover:text-blue-600'],
            ['label' => 'Novo'],
        ]"
    >
        <x-slot:action>
            <a href="{{ route('users.index') }}" class="px-4 py-2 text-sm font-bold transition bg-white border rounded-lg text-slate-600 border-slate-300 hover:bg-slate-50 shadow-sm">
                Cancelar
            </a>
        </x-slot:action>
    </x-admin.page-header>

    @if($errors->any())
        <div class="p-4 font-medium text-red-700 border border-red-200 bg-red-50 rounded-xl">
            <ul class="text-sm list-disc list-inside space-y-1">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('admin.users.store') }}" method="POST" class="space-y-6">
        @csrf

        {{-- Dados da Conta --}}
        <x-admin.panel title="Dados da Conta">
            <div class="grid grid-cols-1 gap-x-6 gap-y-0 md:grid-cols-2">
                <x-admin.input
                    name="name"
                    label="Nome Completo"
                    :required="true"
                    :value="old('name')"
                    placeholder="Ex: João da Silva"
                />
                <x-admin.input
                    name="email"
                    label="E-mail"
                    type="email"
                    :required="true"
                    :value="old('email')"
                    placeholder="usuários@prefeitura.assai.pr.gov.br"
                />
                <x-admin.input
                    name="password"
                    label="Senha"
                    type="password"
                    :required="true"
                    helpText="Mínimo de 8 caracteres."
                />
                <x-admin.input
                    name="password_confirmation"
                    label="Confirmar Senha"
                    type="password"
                    :required="true"
                />
            </div>
        </x-admin.panel>

        {{-- Papéis (Roles) --}}
        <x-admin.panel title="Papéis (Roles)">
            <p class="mb-4 text-sm text-slate-500">Papéis são apenas nomes organizacionais. O acesso é definido somente em permissões diretas. O único papel fixo é <strong>admin</strong>.</p>
            <div class="grid grid-cols-2 gap-4 md:grid-cols-4">
                @foreach($roles as $role)
                    @php
                        $tagColor = match($role->name) {
                            'admin'       => 'border-red-200 bg-red-50/50 hover:bg-red-50 has-[:checked]:bg-red-100 has-[:checked]:border-red-400',
                            default       => 'border-slate-200 bg-slate-50 hover:bg-slate-100 has-[:checked]:bg-blue-100 has-[:checked]:border-blue-400',
                        };
                        $checkColor = match($role->name) {
                            'admin'       => 'text-red-600 focus:ring-red-500',
                            default       => 'text-blue-600 focus:ring-blue-500',
                        };
                    @endphp
                    <label class="flex items-center gap-3 p-3 transition border rounded-lg cursor-pointer {{ $tagColor }}">
                        <input
                            type="checkbox"
                            name="roles[]"
                            value="{{ $role->name }}"
                            {{ in_array($role->name, old('roles', [])) ? 'checked' : '' }}
                            class="w-4 h-4 rounded border-gray-300 {{ $checkColor }}"
                        >
                        <span class="text-sm font-bold text-slate-800">{{ ucfirst($role->name) }}</span>
                    </label>
                @endforeach
            </div>
            <div class="mt-4">
                <x-admin.input
                    name="new_roles"
                    label="Novos papéis (opcional)"
                    :value="old('new_roles')"
                    placeholder="Ex: fiscalizacao, ouvidoria, gabinete"
                    helpText="Separe por vírgula para criar novos nomes de papel."
                />
            </div>
            @error('roles')
                <p class="mt-2 text-xs italic text-red-500">{{ $message }}</p>
            @enderror
            @error('new_roles')
                <p class="mt-2 text-xs italic text-red-500">{{ $message }}</p>
            @enderror
        </x-admin.panel>

        {{-- Permissões Diretas --}}
        <x-admin.panel title="Permissões Diretas">
            <p class="mb-4 text-sm text-slate-500">Concede permissões individuais, independente do papel. Use para casos excepcionais.</p>
            <div class="grid grid-cols-1 gap-3 sm:grid-cols-2 md:grid-cols-3">
                @php
                    $permissionLabels = [
                        'gerir alertas' => 'Gerenciar Alertas',
                        'gerir banners' => 'Gerenciar Banners',
                        'gerir servicos' => 'Gerenciar Serviços',
                        'gerir programas' => 'Gerenciar Programas',
                        'gerir noticias' => 'Gerenciar Notícias',
                        'gerir eventos' => 'Gerenciar Eventos',
                        'gerir secretarias' => 'Gerenciar Secretarias',
                        'gerir usuarios' => 'Gerenciar Usuários',
                    ];
                @endphp
                @foreach($permissions as $permission)
                    <label class="flex items-center gap-3 p-3 transition border rounded-lg cursor-pointer border-slate-200 bg-slate-50 hover:bg-slate-100 has-[:checked]:bg-blue-50 has-[:checked]:border-blue-300">
                        <input
                            type="checkbox"
                            name="permissions[]"
                            value="{{ $permission->name }}"
                            {{ in_array($permission->name, old('permissions', [])) ? 'checked' : '' }}
                            class="w-4 h-4 text-blue-600 border-gray-300 rounded focus:ring-blue-500"
                        >
                        <span class="text-sm font-medium text-slate-700">{{ $permissionLabels[$permission->name] ?? ucfirst($permission->name) }}</span>
                    </label>
                @endforeach
            </div>
            @error('permissions')
                <p class="mt-2 text-xs italic text-red-500">{{ $message }}</p>
            @enderror
        </x-admin.panel>

        <div class="flex justify-end">
            <x-admin.button color="blue" class="flex items-center gap-2 px-8 py-3 rounded-xl shadow-md text-base">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                Criar Usuários
            </x-admin.button>
        </div>
    </form>
</div>
@endsection
