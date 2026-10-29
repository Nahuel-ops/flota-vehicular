<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Models\Vehiculo;
use Symfony\Component\HttpFoundation\Response;

class VerificarEstadoVehiculo
{
    /**
     * Intercepta la petición para validar la regla de negocio del Caso #7.
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Capturamos el ID del vehículo que se intenta procesar desde el formulario o URL
        $vehiculoId = $request->input('vehiculo_id') ?? $request->route('vehiculo');

        if ($vehiculoId) {
            $vehiculo = Vehiculo::find($vehiculoId);

            // Regla de Negocio: Si tiene un mantenimiento registrado con fecha de hoy, está en taller
            if ($vehiculo && $vehiculo->mantenimientos()->whereDate('fecha', now()->toDateString())->exists()) {
                return redirect()->back()->withErrors([
                    'vehiculo_error' => "Operación Denegada: El vehículo con Placa [{$vehiculo->placa}] está retenido en mantenimiento mecánico hoy."
                ])->withInput();
            }
        }

        return $next($request);
    }
}
