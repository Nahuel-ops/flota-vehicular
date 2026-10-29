<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Iniciar Sesión - Flota Vehicular</title>
    <!--<script src="https://jsdelivr.net"></script>-->
    <script src="https://cdn.tailwindcss.com"></script>
    
</head>
<body class="bg-slate-100 flex items-center justify-center min-h-screen">
    <div class="bg-white p-8 rounded-lg shadow-md w-full max-w-md">
        <h2 class="text-2xl font-bold text-center text-slate-800 mb-6">Control de Flota Vehicular</h2>
        
        <!-- Alertas de errores globales -->
        @if ($errors->any())
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4 text-sm">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('login') }}" method="POST" class="space-y-4">
            @csrf
            <div>
                <label class="block text-sm font-medium text-slate-700">Correo Electrónico</label>
                <input type="email" name="email" value="{{ old('email') }}" required class="mt-1 block w-full rounded border border-slate-300 p-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
            </div>

            <div>
                <label class="block text-sm font-medium text-slate-700">Contraseña</label>
                <input type="password" name="password" required class="mt-1 block w-full rounded border border-slate-300 p-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
            </div>

            <button type="submit" class="w-full bg-blue-600 text-white p-2 rounded font-semibold hover:bg-blue-700 transition">Ingresar</button>
        </form>

        <p class="text-sm text-center text-slate-600 mt-4">
            ¿No tienes cuenta? <a href="{{ route('register') }}" class="text-blue-600 hover:underline">Regístrate aquí</a>
        </p>
    </div>
</body>
</html>
