<?php

namespace App\Http\Controllers;

use App\Models\Vehiculo;
use App\Models\Mantenimiento;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    /**
     * Calcula las alertas comparando el kilometraje actual del vehículo 
     * frente a los kilómetros de su último mantenimiento preventivo.
     */
    public function index()
    {
        $vehiculosConAlerta = Vehiculo::all()->filter(function($vehiculo) {
            // Buscamos el último mantenimiento preventivo que haya tenido este vehículo en el historial
            $ultimoPreventivo = Mantenimiento::where('vehiculo_id', $vehiculo->id)
                ->where('tipo', 'Preventivo')
                ->latest('fecha')
                ->first();

            if ($ultimoPreventivo) {
                // LÓGICA DE TU CUADERNO: Kilometraje Actual de la BDD menos el del servicio anterior
                $diferencia = $vehiculo->kilometraje_actual - $ultimoPreventivo->kilometraje;
                
                // Si pasaron más de 10,000 Km desde ese taller, se dispara la alerta
                return $diferencia > 10000;
            }

            return false;
        });

        return view('dashboard', compact('vehiculosConAlerta'));
    }
}

