<?php

namespace Database\Factories;

use App\Models\Mantenimiento;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Mantenimiento>
 */
class MantenimientoFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
        public function definition(): array
    {
        return [
            // Conecta con un vehículo
            'vehiculo_id' => \App\Models\Vehiculo::factory(),
            'tipo'        => $this->faker->randomElement(['Preventivo', 'Correctivo']),
            'fecha'       => $this->faker->dateTimeBetween('-1 year', 'now')->format('Y-m-d'),
            'kilometraje' => $this->faker->numberBetween(5000, 140000),
            'taller'      => 'Taller Mecánico ' . $this->faker->lastName(),
            'costo_total' => $this->faker->randomFloat(2, 50, 1500), // Costos entre 50 y 1500 USD
        ];
    }

}
