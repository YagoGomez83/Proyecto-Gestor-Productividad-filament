<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Dashboard') - Analítica de Video</title>
    @vite(['resources/css/app.css', 'resources/js/app.js','resources/js/heatmap/initHeatmap.js'])
    @stack('styles')
</head>
<body class="text-gray-900 m-0 bg-gradient-to-r from-gray-100 via-gray-100 to-gray-300">

    <!-- Barra de navegación -->
    <nav class="bg-white shadow-md">
        <div class="container mx-auto px-4 py-4 flex justify-between items-center">
            <div class="text-gray-700">
                <span class="font-bold">Bienvenido,</span> {{ Auth::user()->first_name }} {{ Auth::user()->last_name }}
            </div>
            
            <div class="flex gap-4">
                <a href="{{ url()->previous()}}" class="text-blue-600 hover:underline uppercase">Volver</a>
            </div>
        </div>
    </nav>

    <!-- Contenido principal -->
    <div class="container mx-auto p-8">
        @yield('content')
    </div>

    <!-- Footer -->
    <footer class="bg-white text-center py-4 mt-10 shadow-inner">
        <p class="text-gray-700">Derechos Reservados &copy; {{ date('Y') }} Analítica de Video</p>
    </footer>
    
    @stack('scripts')
</body>
</html>