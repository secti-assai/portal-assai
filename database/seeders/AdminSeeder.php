<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $user = User::firstOrCreate(
            ['email' => 'admin@assai.pr.gov.br'], // Condição de busca
            [
                'name' => 'Admin',
                'password' => Hash::make('admin123') // Criptografa a senha de forma segura
            ]
        );

        if (Role::where('name', 'admin')->exists()) {
            $user->assignRole('admin');
        }
    }
}