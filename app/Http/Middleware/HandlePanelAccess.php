<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class HandlePanelAccess
{
    public function handle(Request $request, Closure $next): Response
    {
        $response = $next($request);

        // Solo intervenir si es una respuesta 403
        if ($response->getStatusCode() === 403 && str_contains($response->getContent(), 'User does not have the right roles')) {
            Auth::logout();
            // auth()->logout();
            $request->session()->invalidate();
            $request->session()->regenerateToken();

            return redirect('/')->with('error', 'No tienes acceso a este panel. Por favor ingresa con las credenciales correctas.');
        }

        return $response;
    }
}
