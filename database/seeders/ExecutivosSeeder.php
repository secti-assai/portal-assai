<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Executivo;

class ExecutivosSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Dados do Prefeito
        Executivo::firstOrCreate(
            ['cargo' => 'Prefeito'],
            [
                'nome' => 'Tuti Bomtempo',
                'foto' => 'executivos/Tuti.jpg', // Caminho relativo ao storage/app/public
            ]
        );

        // Dados do Vice-Prefeito
        Executivo::firstOrCreate(
            ['cargo' => 'Vice-Prefeito'],
            [
                'nome' => 'Rafael Gouveia Greca',
                'foto' => 'executivos/RafaelGouveiaGreca.jpg', // Caminho relativo ao storage/app/public
            ]
        );
    }
}