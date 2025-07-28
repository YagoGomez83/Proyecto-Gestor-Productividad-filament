<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Portal de Acceso - Analítica de Video</title>
    <script src="https://cdn.tailwindcss.com"></script>
    {{-- Para una mejor tipografía, puedes enlazar a una fuente como Inter desde Google Fonts --}}
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Inter', sans-serif; }
    </style>
</head>
<body class="min-h-screen bg-slate-100 text-slate-800 antialiased">
    <div class="container mx-auto px-4 py-12 sm:py-16">
        
        <header class="text-center mb-12">
            <h1 class="text-4xl font-bold text-slate-900">Sistema de Analítica de Video</h1>
            <p class="mt-2 text-lg text-slate-600">Por favor, seleccione su portal de acceso</p>
        </header>

        @if(session('error'))
        <div class="max-w-4xl mx-auto bg-red-100 border-l-4 border-red-500 text-red-700 p-4 rounded-md mb-8" role="alert">
            <p class="font-bold">Error</p>
            <p>{{ session('error') }}</p>
        </div>
        @endif
        
        <main class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-8">
            
            <a href="/admin/login" class="group block">
                <div class="bg-white p-8 rounded-xl shadow-md hover:shadow-xl hover:-translate-y-1 transition-all duration-300 ease-in-out h-full flex flex-col items-center text-center">
                    <div class="bg-indigo-100 text-indigo-600 rounded-full p-4 mb-6 transition-colors duration-300 group-hover:bg-indigo-200">
                        {{-- Icono: Users (Heroicons) --}}
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M15 21a6 6 0 00-9-5.197M15 21a6 6 0 006-6v-1a6 6 0 00-9-5.197M12 14.25a6 6 0 00-9-5.197M15 10.5a3 3 0 11-6 0 3 3 0 016 0z" />
                        </svg>
                    </div>
                    <h2 class="text-xl font-semibold mb-3 text-slate-900">Coordinación</h2>
                    <p class="text-slate-500 text-sm flex-grow mb-6">Acceso para administradores y coordinadores de área.</p>
                    <span class="mt-auto bg-indigo-600 text-white font-medium py-2 px-6 rounded-lg transition-colors duration-300 group-hover:bg-indigo-700">
                        Ingresar
                    </span>
                </div>
            </a>

            <a href="/supervisor/login" class="group block">
                <div class="bg-white p-8 rounded-xl shadow-md hover:shadow-xl hover:-translate-y-1 transition-all duration-300 ease-in-out h-full flex flex-col items-center text-center">
                    <div class="bg-indigo-100 text-indigo-600 rounded-full p-4 mb-6 transition-colors duration-300 group-hover:bg-indigo-200">
                        {{-- Icono: Eye (Heroicons) --}}
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                            <path stroke-linecap="round" stroke-linejoin="round" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                        </svg>
                    </div>
                    <h2 class="text-xl font-semibold mb-3 text-slate-900">Supervisión</h2>
                    <p class="text-slate-500 text-sm flex-grow mb-6">Portal para supervisores de turno y seguimiento de operaciones.</p>
                    <span class="mt-auto bg-indigo-600 text-white font-medium py-2 px-6 rounded-lg transition-colors duration-300 group-hover:bg-indigo-700">
                        Ingresar
                    </span>
                </div>
            </a>

            <a href="/reception/login" class="group block">
                <div class="bg-white p-8 rounded-xl shadow-md hover:shadow-xl hover:-translate-y-1 transition-all duration-300 ease-in-out h-full flex flex-col items-center text-center">
                    <div class="bg-indigo-100 text-indigo-600 rounded-full p-4 mb-6 transition-colors duration-300 group-hover:bg-indigo-200">
                        {{-- Icono: InboxIn (Heroicons) --}}
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                           <path stroke-linecap="round" stroke-linejoin="round" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z" />
                        </svg>
                    </div>
                    <h2 class="text-xl font-semibold mb-3 text-slate-900">Mesa de Entrada</h2>
                    <p class="text-slate-500 text-sm flex-grow mb-6">Recepción y gestión de solicitudes, oficios y documentación.</p>
                    <span class="mt-auto bg-indigo-600 text-white font-medium py-2 px-6 rounded-lg transition-colors duration-300 group-hover:bg-indigo-700">
                        Ingresar
                    </span>
                </div>
            </a>

            <a href="/operator/login" class="group block">
                <div class="bg-white p-8 rounded-xl shadow-md hover:shadow-xl hover:-translate-y-1 transition-all duration-300 ease-in-out h-full flex flex-col items-center text-center">
                     <div class="bg-indigo-100 text-indigo-600 rounded-full p-4 mb-6 transition-colors duration-300 group-hover:bg-indigo-200">
                        {{-- Icono: Cog (Heroicons) --}}
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                           <path stroke-linecap="round" stroke-linejoin="round" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.096 2.572-1.065z" />
                           <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                        </svg>
                    </div>
                    <h2 class="text-xl font-semibold mb-3 text-slate-900">Operador</h2>
                    <p class="text-slate-500 text-sm flex-grow mb-6">Acceso al panel de operación y monitoreo de sistemas.</p>
                    <span class="mt-auto bg-indigo-600 text-white font-medium py-2 px-6 rounded-lg transition-colors duration-300 group-hover:bg-indigo-700">
                        Ingresar
                    </span>
                </div>
            </a>

        </main>
    </div>
</body>
</html>