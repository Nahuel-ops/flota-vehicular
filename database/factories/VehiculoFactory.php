<?php

namespace Database\Factories;

use App\Models\Vehiculo;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Vehiculo>
 */
class VehiculoFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
        public function definition(): array
    {
        $marcasModelos = [
            'Toyota' => ['Hilux', 'Corolla', 'RAV4'],
            'Nissan' => ['Frontier', 'Sentra', 'Versa'],
            'Suzuki' => ['Grand Vitara', 'Swift', 'Carry'],
            'Volvo'  => ['FH16', 'FMX', 'VM'] // Camiones pesados de flota
        ];

        $marcaAleatoria = $this->faker->randomElement(array_keys($marcasModelos));
        $modeloAleatorio = $this->faker->randomElement($marcasModelos[$marcaAleatoria]);

        return [
            //Trae un chofer aleatorio existente o crea uno nuevo al vuelo
            'chofer_id'           => \App\Models\Chofer::factory(),
            // Simula placas de control vehicular únicas (Ej: 4829-KXL)
            'placa'               => $this->faker->unique()->bothify('####-???'),
            'marca'               => $marcaAleatoria,
            'modelo'              => $modeloAleatorio,
            'anio'                => $this->faker->numberBetween(2015, 2026),
            // Kilometrajes variados para cruzar con tus consultas
            'kilometraje_actual'  => $this->faker->numberBetween(5000, 150000),
        ];
    }

}
