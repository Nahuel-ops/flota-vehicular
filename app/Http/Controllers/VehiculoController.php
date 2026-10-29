<?php

namespace App\Http\Controllers;

use App\Models\Vehiculo;
use App\Models\Chofer;
use Illuminate\Http\Request;
use Exception;

class VehiculoController extends Controller
{
    /**
     * Muestra la lista de vehículos registrados con su chofer asignado (Evita N+1).
     */
    public function index()
    {
        $vehiculos = Vehiculo::with('chofer')->orderBy('placa', 'asc')->get();
        return view('vehiculos.index', compact('vehiculos'));
    }

    /**
     * Muestra el formulario para registrar un nuevo vehículo.
     */
    public function create()
    {
        $choferes = Chofer::orderBy('nombre', 'asc')->get();
        return view('vehiculos.create', compact('choferes'));
    }

    /**
     * Almacena un vehículo nuevo en la base de datos PostgreSQL.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'chofer_id'          => 'required|exists:choferes,id',
            'placa'              => 'required|string|max:15|unique:vehiculos,placa',
            'marca'              => 'required|string|max:50',
            'modelo'             => 'required|string|max:50',
            'anio'               => 'required|integer|min:1900|max:' . (date('Y') + 1),
            'kilometraje_actual' => 'required|integer|min:0',
        ]);

        Vehiculo::create($validated);

        return redirect()->route('vehiculos.index')->with('success', 'Vehículo registrado exitosamente en la flota.');
    }

    /**
     * Muestra el formulario de edición cargando los datos del vehículo.
     */
    public function edit($id)
    {
        $vehiculo = Vehiculo::findOrFail($id);
        $choferes = Chofer::orderBy('nombre', 'asc')->get();
        
        return view('vehiculos.edit', compact('vehiculo', 'choferes'));
    }

    /**
     * Actualiza los datos modificados del vehículo controlando la placa única.
     */
    public function update(Request $request, $id)
    {
        $vehiculo = Vehiculo::findOrFail($id);

        $validated = $request->validate([
            'chofer_id'          => 'required|exists:choferes,id',
            'placa'              => 'required|string|max:15|unique:vehiculos,placa,' . $vehiculo->id,
            'marca'              => 'required|string|max:50',
            'modelo'             => 'required|string|max:50',
            'anio'               => 'required|integer|min:1900|max:' . (date('Y') + 1),
            'kilometraje_actual' => 'required|integer|min:0',
        ]);

        $vehiculo->update($validated);

        return redirect()->route('vehiculos.index')->with('success', 'Vehículo modificado correctamente.');
    }

    /**
     * Elimina el vehículo controlando la integridad referencial en cascada.
     */
    public function destroy($id)
    {
        $vehiculo = Vehiculo::findOrFail($id);

        try {
            // REGLA DE NEGOCIO EXIGIDA: Si posee mantenimientos históricos en la BDD, bloqueamos el borrado físico
            if ($vehiculo->mantenimientos()->exists()) {
                return back()->with('error', 'Restricción: No se puede eliminar el vehículo porque cuenta con registros históricos de mantenimiento en taller.');
            }

            $vehiculo->delete();
            return redirect()->route('vehiculos.index')->with('success', 'Vehículo removido del sistema de flotas.');

        } catch (Exception $e) {
            return back()->with('error', 'Error mecánico en la base de datos al intentar procesar la eliminación.');
        }
    }
}
