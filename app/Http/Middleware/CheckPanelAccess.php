<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class CheckPanelAccess
{
    public function handle(Request $request, Closure $next, ...$roles): Response
    {
        $user = Auth::user();

        if (!$user) {
            return $this->logoutAndRedirect($request);
        }

        // Verificar si el usuario tiene alguno de los roles permitidos
        $hasAccess = false;
        foreach ($roles as $role) {
            if ($user->hasRole($role)) {
                $hasAccess = true;
                break;
            }
        }

        if (!$hasAccess) {
            return $this->logoutAndRedirect($request);
        }

        return $next($request);
    }

    protected function logoutAndRedirect(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/')->with('error', 'No tienes acceso a este panel.');
    }
}
