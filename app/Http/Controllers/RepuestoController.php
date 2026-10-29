<?php

namespace App\Http\Controllers;

use App\Models\Repuesto;
use Illuminate\Http\Request;
use Exception;

class RepuestoController extends Controller
{
    /**
     * Muestra la lista de repuestos en stock.
     */
    public function index()
    {
        $repuestos = Repuesto::orderBy('nombre', 'asc')->get();
        return view('repuestos.index', compact('repuestos'));
    }

    /**
     * Muestra el formulario para registrar un nuevo repuesto.
     */
    public function create()
    {
        return view('repuestos.create');
    }

    /**
     * Almacena un repuesto nuevo en la base de datos.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nombre' => 'required|string|max:100',
            'marca'  => 'required|string|max:50',
        ]);

        Repuesto::create($validated);

        return redirect()->route('repuestos.index')->with('success', 'Repuesto registrado exitosamente en el catálogo.');
    }

    /**
     * Muestra el formulario de edición.
     */
    public function edit($id)
    {
        $repuesto = Repuesto::findOrFail($id);
        return view('repuestos.edit', compact('repuesto'));
    }

    /**
     * Actualiza los datos del repuesto.
     */
    public function update(Request $request, $id)
    {
        $repuesto = Repuesto::findOrFail($id);

        $validated = $request->validate([
            'nombre' => 'required|string|max:100',
            'marca'  => 'required|string|max:50',
        ]);

        $repuesto->update($validated);

        return redirect()->route('repuestos.index')->with('success', 'Repuesto actualizado correctamente.');
    }

    /**
     * Elimina el repuesto verificando la tabla pivote de mantenimientos.
     */
    public function destroy($id)
    {
        $repuesto = Repuesto::findOrFail($id);

        try {
            // REGLA DE INTEGRIDAD: Si el repuesto ya fue usado en órdenes de trabajo, bloqueamos el borrado
            if ($repuesto->mantenimientos()->exists()) {
                return back()->with('error', 'Restricción: No se puede eliminar el repuesto porque ya se encuentra registrado en el historial de órdenes de taller.');
            }

            $repuesto->delete();
            return redirect()->route('repuestos.index')->with('success', 'Repuesto removido del catálogo.');

        } catch (Exception $e) {
            return back()->with('error', 'Error de restricción en base de datos al intentar eliminar.');
        }
    }
}
