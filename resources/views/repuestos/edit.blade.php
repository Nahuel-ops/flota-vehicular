<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Repuesto - UPDS Flota</title>
    <!-- CSS de Tailwind CSS Estable -->
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 font-sans antialiased">

    <div class="max-w-2xl mx-auto py-10 px-4">
        
        <!-- Encabezado -->
        <div class="flex justify-between items-center mb-6">
            <div>
                <h1 class="text-2xl font-bold text-gray-800">📝 Modificar Ficha del Repuesto</h1>
                <p class="text-sm text-gray-500">Actualización de especificaciones de componentes en stock.</p>
            </div>
            <a href="{{ route('repuestos.index') }}" class="bg-gray-500 hover:bg-gray-600 text-white font-semibold py-2 px-4 rounded shadow transition text-sm">
                Volver al Catálogo
            </a>
        </div>

        <!-- Alertas de Validación -->
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

        <!-- Formulario -->
        <form action="{{ route('repuestos.update', $repuesto->id) }}" method="POST" class="bg-white rounded-lg shadow-md p-6 space-y-6">
            @csrf
            @method('PUT') <!-- Requerido para actualización en Laravel -->

            <div class="space-y-4">
                <!-- Nombre del Repuesto -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Nombre del Insumo / Repuesto *</label>
                    <input type="text" name="nombre" value="{{ old('nombre', $repuesto->nombre) }}" required class="w-full rounded-md border border-gray-300 py-2 px-3 shadow-sm focus:outline-none focus:ring-2 focus:ring-indigo-500">
                </div>

                <!-- Marca de Fábrica -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Marca del Fabricante *</label>
                    <input type="text" name="marca" value="{{ old('marca', $repuesto->marca) }}" required class="w-full rounded-md border border-gray-300 py-2 px-3 shadow-sm focus:outline-none focus:ring-2 focus:ring-indigo-500">
                </div>
            </div>

            <!-- Botones de Envíos -->
            <div class="flex justify-end items-center gap-3 pt-4 border-t border-gray-100">
                <a href="{{ route('repuestos.index') }}" class="text-sm font-semibold text-gray-600 hover:text-gray-800 py-2 px-4 transition">
                    Cancelar
                </a>
                <button type="submit" class="bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-2 px-6 rounded-lg shadow transition text-sm">
                    💾 Guardar Cambios Técnicos
                </button>
            </div>

        </form>
    </div>

</body>
</html>
