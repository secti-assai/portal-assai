<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Banner>
 */
class BannerFactory extends Factory
{
    public function definition(): array
    {
        $filename = 'banners/banner_' . Str::random(10) . '.jpg';
        
        try {
            // Baixa uma imagem aleatória própria para banners (1200x600)
            $imageUrl = 'https://picsum.photos/1200/600?random=' . $this->faker->unique()->numberBetween(1, 10000);
            $contents = file_get_contents($imageUrl);
            Storage::disk('public')->put($filename, $contents);
        } catch (\Exception $e) {
            // Fallback caso a API caia ou não tenha internet no momento do db:seed
            $filename = 'banners/placeholder' . $this->faker->numberBetween(1,3) . '.webp';
        }

        return [
            'imagem'         => $filename,
            'exibir_inteira' => false,
            'link'           => $this->faker->randomElement(['/servicos', '/noticias', null]),
            'ativo'          => true,
            'ordem'          => 0, // se aplicavel
        ];
    }
}