<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Support\Facades\Hash;

class VagasAdminSeeder extends Seeder
{
    public function run(): void
    {
        // Criação da permissão e papel
        $permission = Permission::firstOrCreate(['name' => 'gerenciar vagas']);
        $role = Role::firstOrCreate(['name' => 'Admin Vagas']);
        $role->givePermissionTo($permission);

        // Criação do usuário restrito
        $user = User::firstOrCreate(
            ['email' => 'vagas@assai.pr.gov.br'],
            [
                'name' => 'Gestor de Oportunidades',
                'password' => Hash::make('vagas123'),
            ]
        );

        $user->assignRole($role);
    }
}