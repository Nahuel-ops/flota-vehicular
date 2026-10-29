<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - Sistema Flota</title>
    <!--k href="https://unpkg.com@^2/dist/tailwind.min.css" rel="stylesheet">-->
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-slate-100 font-sans antialiased">
    <!-- Barra de Navegación Superior -->
    <nav class="bg-slate-800 text-white p-4 flex justify-between items-center shadow-md">
        <div class="flex items-center space-x-2">
            <span class="text-xl font-bold tracking-wider">UPDS Flota</span>
        </div>
        <div class="flex items-center space-x-4">
            <span class="text-sm text-slate-300">Bienvenido, <strong>{{ Auth::user()->name }}</strong></span>
            <form action="{{ route('logout') }}" method="POST">
                @csrf
                <button type="submit" class="bg-red-500 hover:bg-red-600 px-3 py-1.5 rounded text-sm font-medium transition">Cerrar Sesión</button>
            </form>
        </div>
    </nav>

    <!-- Contenedor Principal -->
    <div class="max-w-7xl mx-auto p-6 mt-6">
        <h1 class="text-3xl font-bold text-slate-800 mb-6">Módulo General Operativo</h1>
        
        <!-- Tarjetas Informativas Rápidas -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
            <div class="bg-white p-6 rounded-lg shadow-sm border-l-4 border-blue-500">
                <h3 class="text-sm font-semibold text-slate-500 uppercase">Caso Asignado</h3>
                <p class="text-xl font-bold text-slate-800 mt-1">Caso #7: Flota Vehicular</p>
            </div>
            <div class="bg-white p-6 rounded-lg shadow-sm border-l-4 border-green-500">
                <h3 class="text-sm font-semibold text-slate-500 uppercase">Estudiante</h3>
                <p class="text-xl font-bold text-slate-800 mt-1">Luis F. Urruelo Sossa</p>
            </div>
            <div class="bg-white p-6 rounded-lg shadow-sm border-l-4 border-purple-500">
                <h3 class="text-sm font-semibold text-slate-500 uppercase">Estado Base de Datos</h3>
                <p class="text-xl font-bold text-slate-800 mt-1">1,000 Registros Cargados</p>
            </div>
        </div>

        <!-- Módulos de Gestión de Flota -->
        <div class="bg-white p-8 rounded-lg shadow-sm mb-8">
            <h2 class="text-xl font-bold text-slate-700 mb-4">Módulos de Gestión de Flota</h2>
            <p class="text-slate-600 mb-6">Selecciona una acción operativa para administrar el estado técnico de los vehículos de la empresa.</p>
            
            <div class="flex flex-wrap gap-4">
                <a href="{{ route('mantenimientos.index') }}" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-3 px-6 rounded-lg shadow transition flex items-center space-x-2 text-sm">
                    <span>📋 Ver Historial de Mantenimientos</span>
                </a>

                <a href="{{ route('mantenimientos.create') }}" class="bg-green-600 hover:bg-green-700 text-white font-bold py-3 px-6 rounded-lg shadow transition flex items-center space-x-2 text-sm">
                    <span>⚙️ Registrar Orden de Taller (Subir Factura)</span>
                </a>

                <a href="{{ route('vehiculos.index') }}" class="bg-amber-600 hover:bg-amber-700 text-white font-bold py-3 px-6 rounded-lg shadow transition flex items-center space-x-2 text-sm">
                    <span>🚘 Administrar Flota Vehicular (CRUD)</span>
                </a>

                <!-- NUEVO ACCESO DIRECTO CONTROL DE CHOFERES -->
                <a href="{{ route('choferes.index') }}" class="bg-purple-600 hover:bg-purple-700 text-white font-bold py-3 px-6 rounded-lg shadow transition flex items-center space-x-2 text-sm">
                    <span>👤 Administrar Personal (Choferes)</span>
                </a>
                                <!-- ACCESO DIRECTO CONTROL DE REPUESTOS -->
                <a href="{{ route('repuestos.index') }}" class="bg-teal-600 hover:bg-teal-700 text-white font-bold py-3 px-6 rounded-lg shadow transition flex items-center space-x-2 text-sm">
                    <span>📦 Catálogo de Repuestos (CRUD)</span>
                </a>

            </div>
        </div>
        
        <!-- Sección Dinámica de Alertas Críticas (> 10,000 Km) con Motor de Búsqueda -->
        <div class="bg-white p-8 rounded-lg shadow-sm border border-slate-200">
            <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4 mb-6">
                <div class="flex items-center space-x-2">
                    <span class="text-2xl">🚨</span>
                    <h2 class="text-xl font-bold text-red-700 uppercase tracking-wider">Alertas de Desgaste Crítico (+10,000 Km)</h2>
                </div>
                
                <!-- Barra de Búsqueda Integrada -->
                <div class="w-full md:w-80">
                    <div class="relative">
                        <input type="text" id="inputBuscar" onkeyup="filtrarAlertas()" placeholder="🔍 Buscar por placa o chofer..." class="w-full rounded border border-slate-300 p-2 text-sm focus:outline-none focus:ring-2 focus:ring-red-500 bg-white text-slate-700">
                    </div>
                </div>
            </div>
            
            <p class="text-slate-600 mb-4 text-sm">Los siguientes vehículos han recorrido más de 10,000 km desde su última revisión preventiva (Kilometraje Actual BDD vs Último Taller) y requieren ingresar a taller.</p>

            @if($vehiculosConAlerta->count() > 0)
                <div class="overflow-x-auto rounded-lg border border-red-200">
                    <!--Tabla ALERTAS -->
                                @if($vehiculosConAlerta->count() > 0)
                <div class="overflow-x-auto rounded-lg border border-red-200">
                    <table class="w-full text-left border-collapse" id="tablaAlertas">
                        <thead>
                            <tr class="bg-red-600 text-white text-xs uppercase tracking-wider">
                                <th class="p-3">Placa Vehicular</th>
                                <th class="p-3">Marca / Modelo</th>
                                <th class="p-3">Chofer Asignado</th>
                                <th class="p-3">Kilometraje Actual</th>
                                <th class="p-3">Último Preventivo</th>
                                <th class="p-3">Exceso Recorridos</th>
                            </tr>
                        </thead>
                        <tbody class="text-sm divide-y divide-red-100 text-slate-700 bg-red-50/50">
                            @foreach($vehiculosConAlerta as $v)
                                @php 
                                    $ultimo = \App\Models\Mantenimiento::where('vehiculo_id', $v->id)->where('tipo', 'Preventivo')->latest('fecha')->first();
                                    $recorridos = $v->kilometraje_actual - $ultimo->kilometraje;
                                @endphp
                                <tr class="filaAlerta hover:bg-red-50 transition">
                                    <td class="p-3 font-bold text-red-900 colPlaca">🚍 Placa: {{ $v->placa }}</td>
                                    <td class="p-3">{{ $v->marca }} {{ $v->modelo }}</td>
                                    <td class="p-3 font-medium text-slate-800 colChofer">{{ $v->chofer ? $v->chofer->nombre : 'Sin asignar' }}</td>
                                    <td class="p-3 font-semibold">{{ number_format($v->kilometraje_actual) }} Km</td>
                                    <td class="p-3">{{ number_format($ultimo->kilometraje) }} Km ({{ $ultimo->fecha }})</td>
                                    <td class="p-3 font-bold text-red-700">⚠️ +{{ number_format($recorridos) }} Km</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                
                <!-- CONTROL DE PAGINACIÓN DINÁMICA -->
                <div class="flex justify-between items-center mt-4 bg-slate-50 p-3 rounded-lg border border-slate-200">
                    <div class="text-xs text-slate-500 font-medium">
                        Mostrando alertas del <span id="txtDesde" class="font-bold">0</span> al <span id="txtHasta" class="font-bold">0</span> (Total: <span id="txtTotalAlertas" class="font-bold">0</span>)
                    </div>
                    <div class="flex space-x-2">
                        <button type="button" id="btnAnterior" onclick="cambiarPagina(-1)" class="bg-white hover:bg-slate-100 text-slate-700 border border-slate-300 font-bold py-1 px-3 rounded shadow-sm text-xs transition disabled:opacity-50 disabled:cursor-not-allowed">
                            ◀ Anterior
                        </button>
                        <button type="button" id="btnSiguiente" onclick="cambiarPagina(1)" class="bg-white hover:bg-slate-100 text-slate-700 border border-slate-300 font-bold py-1 px-3 rounded shadow-sm text-xs transition disabled:opacity-50 disabled:cursor-not-allowed">
                            Siguiente ▶
                        </button>
                    </div>
                </div>

                <!-- Mensaje de aviso cuando la búsqueda no encuentra coincidencias -->
                <div id="sinResultados" class="hidden bg-slate-50 border border-slate-200 p-4 rounded-lg text-slate-500 text-sm text-center italic mt-4">
                    No se encontraron vehículos en alerta que coincidan con la búsqueda.
                </div>
            @else
                <div class="bg-green-50 border border-green-200 p-4 rounded-lg text-green-800 text-sm flex items-center space-x-2">
                    <span>✅</span>
                    <span><strong>Excelente estado técnico:</strong> No se detectan vehículos que superen el límite de desgaste de 10,000 km desde su último preventivo.</span>
                </div>
            @endif

                </div>
                
                <!-- Mensaje de aviso cuando la búsqueda no encuentra coincidencias -->
                <div id="sinResultados" class="hidden bg-slate-50 border border-slate-200 p-4 rounded-lg text-slate-500 text-sm text-center italic mt-4">
                    No se encontraron vehículos en alerta que coincidan con la búsqueda.
                </div>
            @else
                <div class="bg-green-50 border border-green-200 p-4 rounded-lg text-green-800 text-sm flex items-center space-x-2">
                    <span>✅</span>
                    <span><strong>Excelente estado técnico:</strong> No se detectan vehículos que superen el límite de desgaste de 10,000 km desde su último preventivo.</span>
                </div>
            @endif
        </div>
    </div>

    <!-- Script JavaScript Completo para filtrado reactivo instantáneo -->
        <script>
        // CONFIGURACIÓN DE LA PAGINACIÓN
        let paginaActual = 1;
        const filasPorPagina = 5; // <-- Ajusta aquí cuántas alertas quieres ver por pantalla
        let filasFiltradas = [];

        // Inicializar el renderizado cuando cargue el documento
        document.addEventListener("DOMContentLoaded", function() {
            actualizarEstructuraPaginacion();
        });

        function actualizarEstructuraPaginacion() {
            let filas = Array.from(document.getElementsByClassName("filaAlerta"));
            let input = document.getElementById("inputBuscar");
            let filter = input ? input.value.toLowerCase().trim() : "";

            // 1. Filtrar las filas según el buscador reactivo
            filasFiltradas = filas.filter(filen => {
                let placa = filen.getElementsByClassName("colPlaca")[0].innerText.toLowerCase();
                let chofer = filen.getElementsByClassName("colChofer")[0].innerText.toLowerCase();
                return placa.includes(filter) || chofer.includes(filter);
            });

            // 2. Controlar visibilidad del mensaje de contingencia "Sin Resultados"
            let mensajeSinResultados = document.getElementById("sinResultados");
            if (filasFiltradas.length === 0 && filas.length > 0) {
                if (mensajeSinResultados) mensajeSinResultados.classList.remove("hidden");
            } else {
                if (mensajeSinResultados) mensajeSinResultados.classList.add("hidden");
            }

            // 3. Ajustar límites mecánicos de páginas si el filtro reduce el volumen de datos
            let totalPaginas = Math.ceil(filasFiltradas.length / filasPorPagina) || 1;
            if (paginaActual > totalPaginas) paginaActual = totalPaginas;

            let inicio = (paginaActual - 1) * filasPorPagina;
            let fin = inicio + filasPorPagina;

            // 4. Ocultar todas las filas de la BDD y encender solo las del segmento de la página activa
            filas.forEach(f => f.style.display = "none");
            filasFiltradas.slice(inicio, fin).forEach(f => f.style.display = "");

            // 5. Sincronizar textos e indicadores del navegador visual
            if(document.getElementById("txtDesde")) {
                document.getElementById("txtDesde").innerText = filasFiltradas.length === 0 ? 0 : inicio + 1;
                document.getElementById("txtHasta").innerText = Math.min(fin, filasFiltradas.length);
                document.getElementById("txtTotalAlertas").innerText = filasFiltradas.length;

                document.getElementById("btnAnterior").disabled = (paginaActual === 1);
                document.getElementById("btnSiguiente").disabled = (paginaActual === totalPaginas || filasFiltradas.length === 0);
            }
        }

        // Ejecutada instantáneamente por el evento onkeyup de la barra de búsqueda
        function filtrarAlertas() {
            paginaActual = 1; // Resetea a la primera página al escribir
            actualizarEstructuraPaginacion();
        }

        // Ejecutada por los botones Anterior y Siguiente
        function cambiarPagina(direccion) {
            paginaActual += direccion;
            actualizarEstructuraPaginacion();
            
            // Efecto scroll automático hacia la cabecera del panel de alertas para mejorar la UX
            document.getElementById("inputBuscar").scrollIntoView({ behavior: 'smooth', block: 'center' });
        }
    </script>

</body>
</html>
