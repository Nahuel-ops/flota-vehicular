<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreMantenimientoRequest;
use App\Models\Mantenimiento;
use App\Models\Vehiculo;
use App\Models\Repuesto;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Exception;

class MantenimientoController extends Controller
{
    /**
     * Muestra la lista de mantenimientos registrados con Eager Loading.
     */
    public function index()
    {
        // ORDENACIÓN BLINDADA: Primero ordena por fecha, y si las fechas son iguales,
        // ordena por ID de mayor a menor para que el último creado salga primero.
        $mantenimientos = Mantenimiento::with('vehiculo')
            ->orderBy('fecha', 'desc')
            ->orderBy('id', 'desc')
            ->get();

        return view('mantenimientos.index', compact('mantenimientos'));
    }

    /**
     * Muestra el formulario para registrar un nuevo mantenimiento.
     */
    public function create()
    {
        $vehiculos = Vehiculo::all(); 
        $repuestos = Repuesto::orderBy('nombre', 'asc')->get(); // Se envían los repuestos disponibles para la interfaz reactiva
        
        return view('mantenimientos.create', compact('vehiculos', 'repuestos'));
    }

    /**
     * Almacena el mantenimiento en la base de datos de forma transaccional (Mantenimiento + Pivote N:N + Odómetro).
     */
    public function store(StoreMantenimientoRequest $request)
    {
        $data = $request->validated();

        DB::beginTransaction();
        $rutaImagen = null;

        try {
            // 1. Almacenamiento físico de la factura en el disco virtual
            if ($request->hasFile('factura_imagen')) {
                $rutaImagen = $request->file('factura_imagen')->store('facturas', 'public');
            }

            // 2. Registro inicial de la cabecera del mantenimiento
            // Usamos el 'costo_total' enviado originalmente o lo inicializamos en 0 para calcularlo con repuestos
            $mantenimiento = Mantenimiento::create([
                'vehiculo_id'  => $data['vehiculo_id'],
                'tipo'         => $data['tipo'],
                'fecha'        => $data['fecha'],
                'kilometraje'  => $data['kilometraje'],
                'taller'       => $data['taller'],
                'costo_total'  => $data['costo_total'] ?? 0,
                'factura_ruta' => $rutaImagen,
            ]);

            // 3. SINCRO DE TABLA PIVOTE (Opción B): Procesar inserción estructurada si el formulario envía repuestos
            if ($request->has('repuestos') && is_array($request->repuestos)) {
                $costoAcumuladoRepuestos = 0;

                foreach ($request->repuestos as $repuestoId => $detalle) {
                    if (isset($detalle['cantidad']) && isset($detalle['precio'])) {
                        $cantidad = (int) $detalle['cantidad'];
                        $precio   = (float) $detalle['precio'];

                        // Acumulamos el cálculo en caliente para actualizar el costo real
                        $costoAcumuladoRepuestos += ($cantidad * $precio);

                        // Vinculamos en la tabla pivote asignando los atributos adicionales exigidos
                        $mantenimiento->repuestos()->attach($repuestoId, [
                            'cantidad' => $cantidad,
                            'precio'   => $precio
                        ]);
                    }
                }

                // Si se añadieron repuestos, actualizamos el costo total de la transacción con la suma exacta
                if ($costoAcumuladoRepuestos > 0) {
                    $mantenimiento->update([
                        'costo_total' => $costoAcumuladoRepuestos
                    ]);
                }
            }

            // 4. ACTUALIZACIÓN AUTOMÁTICA DEL ODÓMETRO EN POSTGRESQL:
            $vehiculo = Vehiculo::find($data['vehiculo_id']);
            if ($vehiculo && $data['kilometraje'] > $vehiculo->kilometraje_actual) {
                $vehiculo->update([
                    'kilometraje_actual' => $data['kilometraje']
                ]);
            }

            DB::commit();

            return redirect()->route('mantenimientos.index')->with('success', 'Mantenimiento guardado, insumos asociados y odómetro del vehículo actualizado con éxito.');

        } catch (Exception $e) {
            DB::rollBack();

            // Evitamos dejar archivos basura flotando en storage/public si la transacción falla
            if ($rutaImagen && Storage::disk('public')->exists($rutaImagen)) {
                Storage::disk('public')->delete($rutaImagen);
            }

            return back()->withErrors(['error' => 'Error de consistencia en base de datos: ' . $e->getMessage()])->withInput();
        }
    }
}
