<?php

declare(strict_types=1);

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
        Permission::firstOrCreate(['name' => 'gerir alertas']);

        // Permissões de Gestão
        Permission::firstOrCreate(['name' => 'gerir programas']);
        Permission::firstOrCreate(['name' => 'gerir servicos']);
        Permission::firstOrCreate(['name' => 'gerir secretarias']);

        // Permissão de Governança (acesso exclusivo do admin)
        Permission::firstOrCreate(['name' => 'gerir usuarios']);

        // Único papel fixo do sistema
        $roleAdmin = Role::firstOrCreate(['name' => 'admin']);

        Role::query()
            ->where('name', '!=', 'admin')
            ->get()
            ->each(static function (Role $role): void {
                $role->syncPermissions([]);
            });

        // O admin tem bypass global (Gate::before em AppServiceProvider) — a permissão explícita
        // existe para que o Gate::authorize() e @can funcionem sem depender do bypass.
        $roleAdmin->syncPermissions(['gerir usuarios']);
    }
}
