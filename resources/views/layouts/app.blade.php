<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Dashboard') - Analítica de Video</title>
    <!-- En el <head> de tu layout principal (por ejemplo, layouts.app) -->
<link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css" />
<script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>
<script src="https://unpkg.com/leaflet-heat/dist/leaflet-heat.js"></script>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script src="https://unpkg.com/@tailwindcss/browser@4"></script>
{{-- <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/4.0.1/chart.min.js"></script> --}}


<link href="https://cdn.jsdelivr.net/npm/tailwindcss@3.4.1/dist/tailwind.min.css" rel="stylesheet">

</head>
<body class="text-gray-900 m-0 bg-gradient-to-r from-gray-100 via-gray-100 to-gray-300">

    <!-- Barra de navegación -->
    <nav class="bg-white shadow-md">
        <div class="container mx-auto px-4 py-4 flex justify-between items-center">
            <!-- Nombre de usuario y saludo -->
            <div class="text-gray-700">
                <span class="font-bold">Bienvenido,</span> {{ Auth::user()->first_name }} {{ Auth::user()->last_name }}
            </div>
            
            <!-- Menú de navegación -->
            <div class="flex gap-4">
                {{-- <a href="{{ route("users.dashboard") }}" class="text-blue-600 hover:underline">Dashboard</a>
                <a href="{{ route("reports.create") }}" class="text-blue-600 hover:underline">Crear Informe</a>
                <a href="{{ route("statistics.index") }}" class="text-blue-600 hover:underline">Estadisticas</a>
                <a href="{{ route("heatmap.index") }}" class="text-blue-600 hover:underline">Mapa del calor</a>
                <form method="POST" action="{{ route('logout') }}" class="inline">
                    @csrf
                    <button type="submit" class="text-red-600 hover:underline">Logout</button>
                </form> --}}
                <a href="{{ route('filament.admin.pages.dashboard') }}" class="text-blue-600 hover:underline uppercase">Volver al Panel</a>
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
    
</body>
</html>
