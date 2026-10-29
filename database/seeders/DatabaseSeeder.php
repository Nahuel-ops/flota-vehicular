<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Chofer;
use App\Models\Vehiculo;
use App\Models\Mantenimiento;
use App\Models\Repuesto;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // 1. Creamos primero un colchón base de 50 Choferes y 100 Repuestos en el catálogo
        $choferes = Chofer::factory(50)->create();
        $repuestos = Repuesto::factory(100)->create();

        // 2.  Creamos 200 Vehículos distribuidos aleatoriamente entre los choferes existentes
        $vehiculos = Vehiculo::factory(200)->create([
            'chofer_id' => fn () => $choferes->random()->id
        ]);

        // 3. Generamos los 1,000 Mantenimientos requeridos por la consigna masiva
        // Usamos chunks o colecciones para conectarlos eficientemente con la tabla pivote N a N
        Mantenimiento::factory(1000)->create([
            'vehiculo_id' => fn () => $vehiculos->random()->id
        ])->each(function ($mantenimiento) use ($repuestos) {
            
            // A cada mantenimiento le asignamos entre 1 y 3 repuestos de forma aleatoria
            $repuestosAleatorios = $repuestos->random(fake()->numberBetween(1, 3));

            $datosPivote = [];
            $costoAcumulado = 0;

            foreach ($repuestosAleatorios as $repuesto) {
                $cantidad = fake()->numberBetween(1, 4); // Cantidad de piezas usadas
                $precioUnatario = fake()->randomFloat(2, 10, 300); // Precio por pieza
                
                $costoAcumulado += ($cantidad * $precioUnatario);

                $datosPivote[$repuesto->id] = [
                    'cantidad' => $cantidad,
                    'precio'   => $precioUnatario,
                ];
            }

            // Conectamos los repuestos en la tabla intermedia 'mantenimiento_repuesto'
            $mantenimiento->repuestos()->attach($datosPivote);

            // Actualizamos el costo total real sumando la mano de obra básica del taller
            $mantenimiento->update([
                'costo_total' => $costoAcumulado + fake()->randomFloat(2, 30, 100)
            ]);
        });
    }
}
