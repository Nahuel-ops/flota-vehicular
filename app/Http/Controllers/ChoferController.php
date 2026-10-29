<?php

namespace App\Http\Controllers;

use App\Models\Chofer;
use Illuminate\Http\Request;
use Exception;

class ChoferController extends Controller
{
    /**
     * Muestra la lista de choferes registrados.
     */
    public function index()
    {
        $choferes = Chofer::orderBy('nombre', 'asc')->get();
        return view('choferes.index', compact('choferes'));
    }

    /**
     * Muestra el formulario para registrar un nuevo chofer.
     */
    public function create()
    {
        return view('choferes.create');
    }

    /**
     * Almacena un chofer nuevo validando que la licencia sea UNIQUE.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nombre'   => 'required|string|max:100',
            'licencia' => 'required|string|max:30|unique:choferes,licencia',
            'telefono' => 'required|string|max:20',
        ]);

        Chofer::create($validated);

        return redirect()->route('choferes.index')->with('success', 'Chofer registrado exitosamente en el sistema.');
    }

    /**
     * Muestra el formulario de edición.
     */
    public function edit($id)
    {
        $chofer = Chofer::findOrFail($id);
        return view('choferes.edit', compact('chofer'));
    }

    /**
     * Actualiza los datos controlando la excepción UNIQUE de la licencia del chofer.
     */
    public function update(Request $request, $id)
    {
        $chofer = Chofer::findOrFail($id);

        $validated = $request->validate([
            'nombre'   => 'required|string|max:100',
            'licencia' => 'required|string|max:30|unique:choferes,licencia,' . $chofer->id,
            'telefono' => 'required|string|max:20',
        ]);

        $chofer->update($validated);

        return redirect()->route('choferes.index')->with('success', 'Datos del chofer actualizados correctamente.');
    }

    /**
     * Elimina el chofer controlando la integridad referencial (Vehículos asignados).
     */
    public function destroy($id)
    {
        $chofer = Chofer::findOrFail($id);

        try {
            // REGLA DE NEGOCIO EXIGIDA: Si el chofer tiene vehículos a su cargo, impedimos el borrado físico directo
            if ($chofer->vehiculos()->exists()) {
                return back()->with('error', 'Restricción: No se puede eliminar al chofer porque actualmente tiene vehículos de la flota asignados a su nombre.');
            }

            $chofer->delete();
            return redirect()->route('choferes.index')->with('success', 'Chofer removido del sistema de personal.');

        } catch (Exception $e) {
            return back()->with('error', 'Error mecánico en la base de datos al intentar procesar la eliminación.');
        }
    }
}

