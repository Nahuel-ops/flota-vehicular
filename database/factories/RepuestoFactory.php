<?php

namespace Database\Factories;

use App\Models\Repuesto;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Repuesto>
 */
class RepuestoFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
        public function definition(): array
    {
        $repuestos = ['Pastillas de Freno', 'Filtro de Aceite', 'Amortiguador Delantero', 'Batería 12V', 'Bujía de Iridio', 'Filtro de Aire', 'Banda de Distribución', 'Líquido de Frenos'];
        $marcas = ['Bosch', 'ACDelco', 'Monroe', 'Michelin', 'Denso', 'Castrol', 'Mobil1'];

        return [
            'nombre' => $this->faker->randomElement($repuestos),
            'marca'  => $this->faker->randomElement($marcas),
        ];
    }

}
