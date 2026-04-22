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

        // ── Permissões de Comunicação ─────────────────────────────────────────
        Permission::firstOrCreate(['name' => 'gerir noticias']);
        Permission::firstOrCreate(['name' => 'gerir eventos']);
        Permission::firstOrCreate(['name' => 'gerir banners']);

        // ── Permissões de Gestão ──────────────────────────────────────────────
        Permission::firstOrCreate(['name' => 'gerir programas']);
        Permission::firstOrCreate(['name' => 'gerir servicos']);
        Permission::firstOrCreate(['name' => 'gerir secretarias']);

        // ── Permissão de Governança (acesso exclusivo do admin) ───────────────
        Permission::firstOrCreate(['name' => 'gerir usuarios']);

        // ── Papéis do sistema ─────────────────────────────────────────────────
        //
        // admin       → bypass global via Gate::before().
        //               A permissão 'gerir usuarios' é explícita para que
        //               Gate::authorize() e @can funcionem corretamente.
        //
        // editor      → acesso completo ao conteúdo editorial do portal.
        //               Permissões configuradas pelo admin via painel de usuários.
        //               Role pré-criada para atribuição rápida.
        //
        // comunicacao → acesso restrito à área de comunicação (notícias + eventos).
        //               Ideal para assessorias de imprensa / comunicação social.
        //               Permissões configuradas pelo admin via painel de usuários.

        $roleAdmin     = Role::firstOrCreate(['name' => 'admin']);
        Role::firstOrCreate(['name' => 'editor']);
        Role::firstOrCreate(['name' => 'comunicacao']);

        // Limpa permissões de todas as roles não-admin para evitar acúmulo
        // acidental em re-execuções do seeder. O admin gerencia as permissões
        // de editor/comunicacao individualmente via UserController.
        Role::query()
            ->where('name', '!=', 'admin')
            ->get()
            ->each(static function (Role $role): void {
                $role->syncPermissions([]);
            });

        $roleAdmin->syncPermissions(['gerir usuarios']);
    }
}
