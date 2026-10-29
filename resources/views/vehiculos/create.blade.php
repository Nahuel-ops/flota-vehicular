<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registrar Vehículo - UPDS Flota</title>
    <!-- CSS de Tailwind CSS Estable -->
    <!--k href="https://unpkg.com@^2/dist/tailwind.min.css" rel="stylesheet">-->
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-slate-100 font-sans antialiased">

    <div class="max-w-3xl mx-auto py-10 px-4">
        
        <!-- Encabezado -->
        <div class="flex justify-between items-center mb-6">
            <div>
                <h1 class="text-2xl font-bold text-gray-800">🚘 Registrar Nueva Unidad</h1>
                <p class="text-sm text-gray-500">Alta de vehículos en el sistema centralizado de flotas.</p>
            </div>
            <a href="{{ route('vehiculos.index') }}" class="bg-gray-500 hover:bg-gray-600 text-white font-semibold py-2 px-4 rounded shadow transition text-sm">
                Volver al Listado
            </a>
        </div>

        <!-- Alertas de Validación por si falta algún campo obligatorio -->
        @if ($errors->any())
            <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-6 rounded shadow" role="alert">
                <p class="font-bold">Por favor corrige los siguientes campos:</p>
                <ul class="list-disc list-inside text-sm mt-1">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <!-- Formulario de Registro de Vehículo -->
        <form action="{{ route('vehiculos.store') }}" method="POST" class="bg-white rounded-lg shadow-md p-6 space-y-6">
            @csrf

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Placa Metálica -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Número de Placa *</label>
                    <input type="text" name="placa" value="{{ old('placa') }}" required placeholder="Ej: 4732-XYZ" class="w-full rounded-md border border-gray-300 py-2 px-3 shadow-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 uppercase font-mono">
                </div>

                <!-- Chofer Vinculado -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Chofer Responsable Asignado *</label>
                    <select name="chofer_id" required class="w-full rounded-md border border-gray-300 py-2 px-3 bg-white shadow-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 text-sm">
                        <option value="">-- Elige un chofer disponible --</option>
                        @foreach($choferes as $chofer)
                            <option value="{{ $chofer->id }}" {{ old('chofer_id') == $chofer->id ? 'selected' : '' }}>
                                {{ $chofer->nombre }} (Licencia: {{ $chofer->licencia }})
                            </option>
                        @endforeach
                    </select>
                </div>

                <!-- Marca -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Marca del Fabricante *</label>
                    <input type="text" name="marca" value="{{ old('marca') }}" required placeholder="Ej: Toyota" class="w-full rounded-md border border-gray-300 py-2 px-3 shadow-sm focus:outline-none focus:ring-2 focus:ring-indigo-500">
                </div>

                <!-- Modelo -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Modelo de la Unidad *</label>
                    <input type="text" name="modelo" value="{{ old('modelo') }}" required placeholder="Ej: Hilux" class="w-full rounded-md border border-gray-300 py-2 px-3 shadow-sm focus:outline-none focus:ring-2 focus:ring-indigo-500">
                </div>

                <!-- Año de Fabricación -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Año de Fabricación *</label>
                    <input type="number" name="anio" value="{{ old('anio', date('Y')) }}" min="1900" max="{{ date('Y') + 1 }}" required class="w-full rounded-md border border-gray-300 py-2 px-3 shadow-sm focus:outline-none focus:ring-2 focus:ring-indigo-500">
                </div>

                <!-- Odómetro Inicial -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Kilometraje Inicial *</label>
                    <input type="number" name="kilometraje_actual" value="{{ old('kilometraje_actual', 0) }}" min="0" required class="w-full rounded-md border border-gray-300 py-2 px-3 shadow-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 font-mono">
                </div>
            </div>

            <!-- Botones de Envíos -->
            <div class="flex justify-end items-center gap-3 pt-4 border-t border-gray-100">
                <a href="{{ route('vehiculos.index') }}" class="text-sm font-semibold text-gray-600 hover:text-gray-800 py-2 px-4 transition">
                    Cancelar
                </a>
                <button type="submit" class="bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-2 px-6 rounded-lg shadow transition text-sm">
                    🚀 Dar de Alta Vehículo
                </button>
            </div>

        </form>
    </div>

</body>
</html>
