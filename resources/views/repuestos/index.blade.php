<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Catálogo de Repuestos - UPDS Flota</title>
    <!--k href="https://unpkg.com@^2/dist/tailwind.min.css" rel="stylesheet">-->
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 font-sans antialiased">

    <div class="max-w-4xl mx-auto py-10 px-4">
        
        <!-- Encabezado -->
        <div class="flex flex-col sm:flex-row justify-between items-center mb-6 gap-4">
            <div>
                <h1 class="text-2xl font-bold text-gray-800">📦 Catálogo de Repuestos</h1>
                <p class="text-sm text-gray-500">Administración de repuestos e insumos para el taller.</p>
            </div>
            <div class="flex gap-2">
                <a href="{{ route('dashboard') }}" class="bg-gray-500 hover:bg-gray-600 text-white font-semibold py-2 px-4 rounded shadow transition text-sm">
                    Volver al Dashboard
                </a>
                <a href="{{ route('repuestos.create') }}" class="bg-indigo-600 hover:bg-indigo-700 text-white font-semibold py-2 px-4 rounded shadow transition text-sm">
                    + Registrar Repuesto
                </a>
            </div>
        </div>

        <!-- Alertas -->
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

        <!-- Tabla -->
        <div class="bg-white rounded-lg shadow-md overflow-hidden">
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Nombre del Insumo / Repuesto</th>
                            <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Marca de Fábrica</th>
                            <th class="px-6 py-3 text-center text-xs font-semibold text-gray-600 uppercase tracking-wider w-40">Acciones</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200 bg-white">
                        @forelse($repuestos as $repuesto)
                            <tr class="hover:bg-gray-50 transition">
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-semibold text-gray-800">
                                    {{ $repuesto->nombre }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">
                                    <span class="bg-blue-50 text-blue-800 border border-blue-200 rounded-full px-2.5 py-0.5 font-medium text-xs">
                                        {{ $repuesto->marca }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-center">
                                    <div class="flex justify-center items-center gap-3">
                                        <a href="{{ route('repuestos.edit', $repuesto->id) }}" class="text-indigo-600 hover:text-indigo-900 font-semibold transition">
                                            Editar
                                        </a>
                                        <form action="{{ route('repuestos.destroy', $repuesto->id) }}" method="POST" onsubmit="return confirm('¿Deseas dar de baja este insumo del catálogo?');" class="inline">
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
                                <td colspan="3" class="px-6 py-10 text-center text-gray-400 italic">
                                    No existen repuestos cargados en el stock de datos.
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
