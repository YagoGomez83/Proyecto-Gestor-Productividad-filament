<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Dashboard') - Analítica de Video</title>

    {{-- CSRF Token para JavaScript si lo necesitas en otros scripts --}}
    <meta name="csrf-token" content="{{ csrf_token() }}">

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @stack('styles')
</head>
<body class="font-sans antialiased text-slate-800 m-0 bg-slate-100 flex flex-col min-h-screen">

    <nav class="bg-slate-700 text-slate-100 shadow-lg sticky top-0 z-50">
        <div class="container mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-center justify-between h-16">
                <div class="flex items-center">
                    <a href="{{ url('/admin/dashboard') }}" class="text-xl font-semibold hover:text-slate-300 transition-colors duration-150">
                        Analítica de Video {{-- O el logo de tu app --}}
                    </a>
                </div>
                <div class="flex items-center space-x-2 md:space-x-4"> {{-- Ajustado space-x para más items --}}
                    @auth {{-- Mostrar solo si el usuario está autenticado --}}
                        <a href="{{ route('cameras.custom') }}" {{-- NUEVO ENLACE A CÁMARAS --}}
                           class="px-3 py-2 rounded-md text-sm font-medium hover:bg-slate-600 transition-colors duration-150">
                            Cámaras
                        </a>
                        <a href="{{ route('reports.custom') }}"
                           class="px-3 py-2 rounded-md text-sm font-medium hover:bg-slate-600 transition-colors duration-150">
                            Informes
                        </a>

                        <div class="relative hidden md:block"> {{-- Saludo y Logout en un grupo --}}
                             <span class="text-sm px-3 py-2">
                                Bienvenido, {{ Auth::user()->name }} {{-- Usando name como en tu último snippet --}}
                            </span>
                            <form method="POST" action="{{ route('logout') }}" class="inline">
                                @csrf
                                <button type="submit"
                                        class="px-3 py-2 rounded-md text-sm font-medium text-red-400 hover:bg-slate-600 hover:text-red-300 transition-colors duration-150">
                                    Cerrar Sesión
                                </button>
                            </form>
                        </div>
                        {{-- Para móvil, podríamos tener un menú desplegable para el saludo y logout si el espacio es limitado --}}
                        <div class="md:hidden"> {{-- Ejemplo de cómo podrías manejar logout en móvil si el saludo es muy largo --}}
                            <form method="POST" action="{{ route('logout') }}" class="inline">
                                @csrf
                                <button type="submit"
                                        class="px-3 py-2 rounded-md text-sm font-medium text-red-400 hover:bg-slate-600 hover:text-red-300 transition-colors duration-150">
                                    Salir
                                </button>
                            </form>
                        </div>
                    @else
                        <a href="{{ route('login') }}"
                           class="px-3 py-2 rounded-md text-sm font-medium hover:bg-slate-600 transition-colors duration-150">
                            Iniciar Sesión
                        </a>
                        @if (Route::has('register'))
                            <a href="{{ route('register') }}"
                               class="px-3 py-2 rounded-md text-sm font-medium hover:bg-slate-600 transition-colors duration-150">
                                Registrarse
                            </a>
                        @endif
                    @endauth
                </div>
                {{-- Considera un botón de menú hamburguesa aquí si la lista de enlaces crece más --}}
            </div>
        </div>
    </nav>

    <main class="container mx-auto p-4 sm:p-6 lg:p-8 flex-grow">
        @yield('content')
    </main>

    <footer class="bg-slate-200 text-slate-600 text-center py-4 border-t border-slate-300"> {{-- Añadido borde superior para definirlo mejor --}}
        <p>Derechos Reservados &copy; {{ date('Y') }} Analítica de Video.</p>
    </footer>

    @stack('scripts')
</body>
</html>