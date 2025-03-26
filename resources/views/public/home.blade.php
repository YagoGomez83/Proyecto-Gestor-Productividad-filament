<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="h-screen bg-gradient-to-r from-blue-500 via-purple-500 to-pink-500 flex items-center justify-center">
    <div class="container mx-auto px-4">
        @if(session('error'))
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-6 text-center">
            {{ session('error') }}
        </div>
        @endif
        
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
            <!-- Tarjeta 1: Coordinación -->
            <div class="bg-white p-6 rounded-2xl shadow-lg text-center">
                <h2 class="text-xl font-bold mb-4 text-gray-700">Coordinación</h2>
                <a href="/admin/login" class="block bg-blue-600 text-white py-2 px-4 rounded-lg hover:bg-blue-700 transition">
                    Ingresar a Coordinación
                </a>
            </div>

            <!-- Tarjeta 2: Supervisión -->
            <div class="bg-white p-6 rounded-2xl shadow-lg text-center">
                <h2 class="text-xl font-bold mb-4 text-gray-700">Supervisión</h2>
                <a href="/supervisor/login" class="block bg-green-600 text-white py-2 px-4 rounded-lg hover:bg-green-700 transition">
                    Ingresar a Supervisión
                </a>
            </div>

            <!-- Tarjeta 3: Mesa de Entrada -->
            <div class="bg-white p-6 rounded-2xl shadow-lg text-center">
                <h2 class="text-xl font-bold mb-4 text-gray-700">Mesa de Entrada</h2>
                <a href="/reception/login" class="block bg-indigo-500 text-white py-2 px-4 rounded-lg hover:bg-indigo-600 transition">
                    Ingresar a Mesa de Entrada
                </a>
            </div>

            <!-- Tarjeta 4: Operador -->
            <div class="bg-white p-6 rounded-2xl shadow-lg text-center">
                <h2 class="text-xl font-bold mb-4 text-gray-700">Operador</h2>
                <a href="/operator/login" class="block bg-red-600 text-white py-2 px-4 rounded-lg hover:bg-red-700 transition">
                    Ingresar a Operador
                </a>
            </div>
        </div>
    </div>
</body>
</html>