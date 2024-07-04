<?php

namespace Database\Factories;

use App\Models\Camiseta;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Camiseta>
 */
class CamisetasFactory extends Factory
{
    protected $model = Camiseta::class;
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'Nombre' => $this->faker->word,
            'Descripción' => $this->faker->sentence,
            'Precio' => $this->faker->randomFloat(2, 10, 100),
            'Talle' => $this->faker->randomElement(['S', 'M', 'L', 'XL', 'XXL', 'XXXL']),
            'Cantidad' => $this->faker->numberBetween(1, 100),
            'Categoría' => $this->faker->randomElement(['Club Nacional', 'Club Internacional', 'Selección']),
            'Imagen' => $this->faker->imageUrl(640, 480, 'fashion', true),
        ];
    }
}
