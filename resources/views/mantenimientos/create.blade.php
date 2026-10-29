<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registrar Mantenimiento - Flota Vehicular</title>
    <!--<script src="{{ asset('js/tailwind.js') }}"></script>-->
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-slate-100 font-sans">
    <nav class="bg-slate-800 text-white p-4 flex justify-between items-center shadow-md">
        <span class="text-xl font-bold">UPDS Flota</span>
        <a href="{{ route('mantenimientos.index') }}" class="bg-slate-600 hover:bg-slate-700 px-4 py-2 rounded text-sm font-medium transition">Volver al Listado</a>
    </nav>

    <div class="max-w-3xl mx-auto p-6 mt-8">
        <div class="bg-white p-8 rounded-lg shadow-md">
            <h2 class="text-2xl font-bold text-slate-800 mb-6 text-center">Registrar Nueva Orden de Taller</h2>

            @if ($errors->any())
                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4 text-sm">
                    <strong>Errores de validación:</strong>
                    <ul class="list-disc list-inside mt-1">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('mantenimientos.store') }}" method="POST" enctype="multipart/form-data" class="space-y-5">
                @csrf

                <div>
                    <label class="block text-sm font-medium text-slate-700">Vehículo Asociado</label>
                    <select name="vehiculo_id" required class="mt-1 block w-full rounded border border-slate-300 p-2.5 focus:ring-2 focus:ring-blue-500 bg-white">
                        <option value="">-- Seleccione una Placa Vehicular --</option>
                        @foreach($vehiculos as $vehiculo)
                            <option value="{{ $vehiculo->id }}" {{ old('vehiculo_id') == $vehiculo->id ? 'selected' : '' }}>
                                Placa: {{ $vehiculo->placa }} - {{ $vehiculo->marca }} {{ $vehiculo->modelo }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-slate-700">Tipo de Mantenimiento</label>
                        <select name="tipo" required class="mt-1 block w-full rounded border border-slate-300 p-2.5 focus:ring-2 focus:ring-blue-500 bg-white">
                            <option value="Preventivo" {{ old('tipo') == 'Preventivo' ? 'selected' : '' }}>Preventivo</option>
                            <option value="Correctivo" {{ old('tipo') == 'Correctivo' ? 'selected' : '' }}>Correctivo</option>
                        </select>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-slate-700">Fecha del Servicio</label>
                        <input type="date" name="fecha" value="{{ old('fecha', date('Y-m-d')) }}" required class="mt-1 block w-full rounded border border-slate-300 p-2 focus:ring-2 focus:ring-blue-500">
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-slate-700">Kilometraje Actual</label>
                        <input type="number" name="kilometraje" value="{{ old('kilometraje') }}" required min="0" class="mt-1 block w-full rounded border border-slate-300 p-2 focus:ring-2 focus:ring-blue-500">
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-slate-700">Costo Total (USD)</label>
                        <input type="number" name="costo_total" step="0.01" value="{{ old('costo_total') }}" required min="0" class="mt-1 block w-full rounded border border-slate-300 p-2 focus:ring-2 focus:ring-blue-500">
                    </div>
                </div>

                <div>
                    <label class="block text-sm font-medium text-slate-700">Taller Mecánico Encargado</label>
                    <input type="text" name="taller" value="{{ old('taller') }}" required class="mt-1 block w-full rounded border border-slate-300 p-2 focus:ring-2 focus:ring-blue-500">
                </div>

                <div class="bg-slate-50 p-4 rounded border border-dashed border-slate-300">
                    <label class="block text-sm font-medium text-slate-700 mb-1">Subir Comprobante / Foto de Factura</label>
                    <input type="file" name="factura_imagen" accept="image/*" class="w-full text-sm text-slate-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100">
                    <p class="text-xs text-slate-500 mt-1">Formatos permitidos: JPG, JPEG, PNG. Tamaño máximo de archivo: 2MB.</p>
                </div>

                <button type="submit" class="w-full bg-blue-600 text-white p-3 rounded-lg font-bold hover:bg-blue-700 transition shadow">Guardar Registro en Base de Datos</button>
            </form>
        </div>
    </div>
</body>
</html>
