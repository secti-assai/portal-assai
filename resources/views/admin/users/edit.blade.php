@extends('layouts.admin')

@section('content')
<div class="flex flex-col max-w-4xl gap-6 mx-auto">

    <x-admin.page-header
        title="Editar Usuários"
        :breadcrumbs="[
            ['label' => 'Dashboard', 'url' => route('admin.dashboard'), 'class' => 'hover:text-blue-600'],
            ['label' => 'Usuários', 'url' => route('users.index'), 'class' => 'hover:text-blue-600'],
            ['label' => $user->name],
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

    <form action="{{ route('admin.users.update', $user->id) }}" method="POST" class="space-y-6">
        @csrf
        @method('PUT')

        {{-- Dados da Conta --}}
        <x-admin.panel title="Dados da Conta">
            <div class="grid grid-cols-1 gap-x-6 gap-y-0 md:grid-cols-2">
                <x-admin.input
                    name="name"
                    label="Nome Completo"
                    :required="true"
                    :value="old('name', $user->name)"
                    placeholder="Ex: João da Silva"
                />
                <x-admin.input
                    name="email"
                    label="E-mail"
                    type="email"
                    :required="true"
                    :value="old('email', $user->email)"
                    placeholder="usuários@prefeitura.assai.pr.gov.br"
                />
                <x-admin.input
                    name="password"
                    label="Nova Senha"
                    type="password"
                    helpText="Deixe em branco para manter a senha atual. Mínimo 8 caracteres."
                />
                <x-admin.input
                    name="password_confirmation"
                    label="Confirmar Nova Senha"
                    type="password"
                />
            </div>
        </x-admin.panel>

        {{-- Papéis (Roles) --}}
        <x-admin.panel title="Papéis (Roles)">
            <p class="mb-4 text-sm text-slate-500">Papéis são apenas nomes organizacionais. O acesso é definido somente em permissões diretas. O único papel fixo é <strong>admin</strong>.</p>
            @php
                $selectedRoleNames = old('roles', $user->roles->pluck('name')->toArray());
            @endphp
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
                        $isChecked = in_array($role->name, $selectedRoleNames);
                    @endphp
                    <label class="flex items-center gap-3 p-3 transition border rounded-lg cursor-pointer {{ $tagColor }}">
                        <input
                            type="checkbox"
                            name="roles[]"
                            value="{{ $role->name }}"
                            {{ $isChecked ? 'checked' : '' }}
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
            <p class="mb-4 text-sm text-slate-500">Permissões concedidas diretamente ao Usuários, independentes dos papéis atribuídos.</p>
            @php
                $directPermissionNames = $user->getDirectPermissions()->pluck('name')->toArray();
                $selectedPermissionNames = old('permissions', $directPermissionNames);
            @endphp
                @php
                    $permissionLabels = [
                        'gerir banners' => 'Gerenciar Banners',
                        'gerir servicos' => 'Gerenciar Serviços',
                        'gerir programas' => 'Gerenciar Programas',
                        'gerir noticias' => 'Gerenciar Notícias',
                        'gerir eventos' => 'Gerenciar Eventos',
                        'gerir secretarias' => 'Gerenciar Secretarias',
                        'gerir usuarios' => 'Gerenciar Usuários',
                    ];
                @endphp
                <div class="grid grid-cols-1 gap-3 sm:grid-cols-2 md:grid-cols-3">
                    @foreach($permissions as $permission)
                        @php
                            $isChecked = in_array($permission->name, $selectedPermissionNames);
                            $label = $permissionLabels[$permission->name] ?? ucfirst($permission->name);
                        @endphp
                        <label class="flex items-center gap-3 p-3 transition border rounded-lg cursor-pointer border-slate-200 bg-slate-50 hover:bg-slate-100 has-[:checked]:bg-blue-50 has-[:checked]:border-blue-300">
                            <input
                                type="checkbox"
                                name="permissions[]"
                                value="{{ $permission->name }}"
                                {{ $isChecked ? 'checked' : '' }}
                                class="w-4 h-4 text-blue-600 border-gray-300 rounded focus:ring-blue-500"
                            >
                            <div class="min-w-0">
                                <span class="block text-sm font-medium text-slate-700">{{ $label }}</span>
                            </div>
                        </label>
                @endforeach
            </div>
            @error('permissions')
                <p class="mt-2 text-xs italic text-red-500">{{ $message }}</p>
            @enderror
        </x-admin.panel>

        <div class="flex items-center justify-between">
            {{-- Zona de perigo --}}
            @if($user->id !== auth()->id())
                <form action="{{ route('admin.users.destroy', $user->id) }}" method="POST" onsubmit="return confirm('Excluir este Usuários? Esta ação é irreversível.');">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="inline-flex items-center gap-2 px-5 py-2.5 text-sm font-bold text-red-700 bg-red-50 border border-red-200 rounded-xl hover:bg-red-100 transition">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                        Excluir Conta
                    </button>
                </form>
            @else
                <div></div>
            @endif

            <x-admin.button color="blue" class="flex items-center gap-2 px-8 py-3 rounded-xl shadow-md text-base">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                Salvar Alterações
            </x-admin.button>
        </div>
    </form>
</div>
@endsection
