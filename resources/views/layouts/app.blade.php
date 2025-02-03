<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ config('app.name') }}</title>

    <!-- CSS -->
    @vite(['resources/css/app.css']) <!-- Usa Vite para la carga de estilos -->
    <link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css" /> <!-- Leaflet CSS -->

    @livewireStyles <!-- Estilos de Livewire -->
    @stack('styles') <!-- Permite agregar más estilos desde otras vistas -->
</head>
<body class="bg-gray-100">
    
    @yield('content') <!-- Sección para el contenido dinámico -->

    <!-- Scripts -->
    @vite('resources/js/app.js') <!-- Carga de scripts con Vite -->
    <script src="https://unpkg.com/leaflet/dist/leaflet.js"></script> <!-- Leaflet JS -->
    @livewireScripts <!-- Scripts de Livewire -->
    @stack('scripts') <!-- Permite agregar más scripts desde otras vistas -->
</body>
</html>
