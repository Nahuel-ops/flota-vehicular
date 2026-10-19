<?php

namespace Database\Factories;

use App\Models\Chofer;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Chofer>
 */
class ChoferFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
      public function definition(): array
    {
        return [
            'nombre'   => $this->faker->name(),
            // Simula una licencia única con letras y números (Ej: CH-48291)
            'licencia' => $this->faker->unique()->bothify('??-#####'), 
            'telefono' => $this->faker->phoneNumber(),
        ];
    }

}
