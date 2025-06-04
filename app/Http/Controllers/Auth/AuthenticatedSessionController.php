<?php

namespace App\Http\Controllers\Auth; // Asegúrate que el namespace coincida con la ubicación del archivo

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\RedirectResponse; // Importa RedirectResponse

class AuthenticatedSessionController extends Controller
{
    /**
     * Muestra el formulario de login (opcional, si este controlador también maneja el login).
     * public function create() { ... }
     */

    /**
     * Maneja un intento de autenticación (opcional, si este controlador también maneja el login).
     * public function store(Request $request) { ... }
     */

    /**
     * Destruye una sesión autenticada (cierre de sesión).
     */
    public function destroy(Request $request): RedirectResponse // Especifica el tipo de retorno
    {
        Auth::guard('web')->logout(); // Cierra la sesión para el guard 'web' (el predeterminado)

        $request->session()->invalidate(); // Invalida la sesión actual

        $request->session()->regenerateToken(); // Regenera el token CSRF

        // Redirige al usuario a la página de inicio o a donde prefieras después del logout
        return redirect()->route('home'); // Asumiendo que tienes una ruta nombrada 'home'
        // Alternativamente, puedes usar: return redirect('/');
    }
}