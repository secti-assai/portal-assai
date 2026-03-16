<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\PermissionRegistrar;

class RolesAndPermissionsSeeder extends Seeder
{
    public function run(): void
    {
        app()[PermissionRegistrar::class]->forgetCachedPermissions();

        // Permissões de Comunicação
        Permission::firstOrCreate(['name' => 'gerir noticias']);
        Permission::firstOrCreate(['name' => 'gerir eventos']);
        Permission::firstOrCreate(['name' => 'gerir banners']);

        // Permissões de Gestão
        Permission::firstOrCreate(['name' => 'gerir programas']);
        Permission::firstOrCreate(['name' => 'gerir servicos']);
        Permission::firstOrCreate(['name' => 'gerir secretarias']);

    // Permissão de Governança (acesso exclusivo do admin)
    Permission::firstOrCreate(['name' => 'gerir usuarios']);

    // Criação de Papéis e atribuição
    $roleComunicacao = Role::firstOrCreate(['name' => 'comunicacao']);
    $roleComunicacao->syncPermissions(['gerir noticias', 'gerir eventos', 'gerir banners']);

    $roleGestao = Role::firstOrCreate(['name' => 'gestao']);
    $roleGestao->syncPermissions(['gerir programas', 'gerir servicos', 'gerir secretarias']);

    $roleAdmin = Role::firstOrCreate(['name' => 'admin']);
    // O admin tem bypass global (Gate::before em AppServiceProvider) — a permissão explícita
    // existe para que o Gate::authorize() e @can funcionem sem depender do bypass.
    $roleAdmin->givePermissionTo('gerir usuarios');
    }
}
