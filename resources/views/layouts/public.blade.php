<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Dashboard Público')</title>
    @vite(['resources/css/app.css', 'resources/js/app.js']) 
</head>
<body class="bg-gray-100 min-h-screen flex flex-col">
    <!-- Header -->
    <header class="bg-white shadow-md">
        <div class="container mx-auto px-4 py-4 flex justify-between items-center">
            <h1 class="text-xl font-bold text-gray-800">Sistema de Gestión de productividad CCC</h1>
            <div>
                <a href="{{ route('login') }}" class="text-blue-500 hover:text-blue-700 font-semibold mr-4">Login</a>
                <a href="{{ route('public.index') }}" class="text-green-500 hover:text-green-700 font-semibold">Dashboard</a>
            </div>
        </div>
    </header>

    <!-- Main Content -->
    <main class="flex-grow">
        @yield('content')
    </main>

    <!-- Footer -->
    <footer class="bg-gray-800 text-white py-4 text-center">
        <p>&copy; {{ date('Y') }} SISMO. Todos los derechos reservados.</p>
    </footer>
</body>
</html>
