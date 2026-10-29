<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Control de Flota - UPDS Flota</title>
    <!--ipt src="https://cdn.windcss.com"></script>-->
    <script src="https://cdn.tailwindcss.com"></script>
    
</head>
<body class="bg-gray-100 font-sans antialiased">

    <div class="max-w-6xl mx-auto py-10 px-4">
        
        <!-- Encabezado -->
        <div class="flex flex-col sm:flex-row justify-between items-center mb-6 gap-4">
            <div>
                <h1 class="text-2xl font-bold text-gray-800">🚘 Control de Flota Vehicular</h1>
                <p class="text-sm text-gray-500">Gestión de unidades y asignación de choferes.</p>
            </div>
            <div class="flex gap-2">
                <a href="{{ route('dashboard') }}" class="bg-gray-500 hover:bg-gray-600 text-white font-semibold py-2 px-4 rounded shadow transition">
                    Volver al Dashboard
                </a>
                <a href="{{ route('vehiculos.create') }}" class="bg-indigo-600 hover:bg-indigo-700 text-white font-semibold py-2 px-4 rounded shadow transition">
                    + Registrar Vehículo
                </a>
            </div>
        </div>

        <!-- Alertas del Sistema -->
        @if(session('success'))
            <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-6 rounded shadow" role="alert">
                {{ session('success') }}
            </div>
        @endif

        @if(session('error'))
            <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-6 rounded shadow" role="alert">
                {{ session('error') }}
            </div>
        @endif

        <!-- Tabla de Vehículos -->
        <div class="bg-white rounded-lg shadow-md overflow-hidden">
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Placa</th>
                            <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Marca / Modelo</th>
                            <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Año</th>
                            <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Chofer Asignado</th>
                            <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Kilometraje Actual</th>
                            <th class="px-6 py-3 text-center text-xs font-semibold text-gray-600 uppercase tracking-wider w-40">Acciones</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200 bg-white">
                        @forelse($vehiculos as $vehiculo)
                            <tr class="hover:bg-gray-50 transition">
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="bg-gray-200 text-gray-800 font-mono font-bold px-2 py-1 rounded border border-gray-300">
                                        {{ $vehiculo->placa }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-800 font-semibold">
                                    {{ $vehiculo->marca }} <span class="text-gray-500 font-normal">{{ $vehiculo->modelo }}</span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">
                                    {{ $vehiculo->anio }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">
                                    {{ $vehiculo->chofer->nombre ?? 'Sin Chofer Asignado' }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-mono text-gray-600">
                                    {{ number_format($vehiculo->kilometraje_actual) }} Km
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-center">
                                    <div class="flex justify-center items-center gap-3">
                                        <!-- Editar -->
                                        <a href="{{ route('vehiculos.edit', $vehiculo->id) }}" class="text-indigo-600 hover:text-indigo-900 font-semibold transition">
                                            Editar
                                        </a>
                                        
                                        <!-- Eliminar Seguro -->
                                        <form action="{{ route('vehiculos.destroy', $vehiculo->id) }}" method="POST" onsubmit="return confirm('¿Estás completamente seguro de remover este vehículo del sistema de flotas?');" class="inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-red-600 hover:text-red-900 font-semibold transition">
                                                Eliminar
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="px-6 py-10 text-center text-gray-400 italic">
                                    No existen vehículos registrados en la base de datos de la empresa.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

    </div>

</body>
</html>
