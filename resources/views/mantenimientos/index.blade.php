<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Historial de Mantenimientos - Flota Vehicular</title>
    <!--<script src="{{ asset('js/tailwind.js') }}"></script>-->
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-slate-100 font-sans">
    <nav class="bg-slate-800 text-white p-4 flex justify-between items-center shadow-md">
        <span class="text-xl font-bold">UPDS Flota - Mantenimientos</span>
        <div class="space-x-2">
            <a href="{{ route('dashboard') }}" class="text-slate-300 hover:text-white px-3 py-2 text-sm font-medium">Dashboard</a>
            <a href="{{ route('mantenimientos.create') }}" class="bg-green-600 hover:bg-green-700 px-4 py-2 rounded text-sm font-bold transition">Nueva Orden</a>
        </div>
    </nav>

    <div class="max-w-7xl mx-auto p-6 mt-6">
        @if(session('success'))
            <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 rounded mb-6 shadow-sm">
                {{ session('success') }}
            </div>
        @endif

        <div class="bg-white rounded-lg shadow-md overflow-hidden">
            <div class="p-6 bg-slate-50 border-b border-slate-200">
                <h2 class="text-xl font-bold text-slate-800">Control Maestro de Órdenes de Servicio</h2>
            </div>
            
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="bg-slate-800 text-white text-sm uppercase tracking-wider">
                            <th class="p-4">Vehículo</th>
                            <th class="p-4">Tipo</th>
                            <th class="p-4">Fecha</th>
                            <th class="p-4">Kilometraje</th>
                            <th class="p-4">Taller</th>
                            <th class="p-4">Costo Total</th>
                            <th class="p-4 text-center">Comprobante</th>
                        </tr>
                    </thead>
                    <tbody class="text-sm divide-y divide-slate-200 text-slate-700">
                        @forelse($mantenimientos as $m)
                            <tr class="hover:bg-slate-50">
                                <td class="p-4 font-semibold text-slate-900">Placa: {{ $m->vehiculo->placa }}</td>
                                <td class="p-4">
                                    <span class="px-2.5 py-1 rounded-full text-xs font-semibold {{ $m->tipo == 'Preventivo' ? 'bg-blue-100 text-blue-800' : 'bg-amber-100 text-amber-800' }}">
                                        {{ $m->tipo }}
                                    </span>
                                </td>
                                <td class="p-4">{{ $m->fecha }}</td>
                                <td class="p-4">{{ number_format($m->kilometraje) }} Km</td>
                                <td class="p-4">{{ $m->taller }}</td>
                                <td class="p-4 font-bold text-slate-900">${{ number_format($m->costo_total, 2) }}</td>
                                <td class="p-4 text-center">
                                    @if($m->factura_ruta)
                                        <a href="{{ asset('storage/' . $m->factura_ruta) }}" target="_blank" class="text-blue-600 hover:text-blue-800 font-medium underline flex items-center justify-center space-x-1">
                                            <span>Ver Factura</span>
                                        </a>
                                    @else
                                        <span class="text-slate-400 italic">Sin archivo</span>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="p-8 text-center text-slate-500 italic">No existen registros de taller ingresados actualmente en el sistema.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</body>
</html>
