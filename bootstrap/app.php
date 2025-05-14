<?php

use App\Http\Middleware\HandlePanelAccess;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware; // Asegúrate de que esta clase esté importada

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__ . '/../routes/web.php',
        commands: __DIR__ . '/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) { // Recibe la instancia de Middleware
        // --- ¡LA MODIFICACIÓN CLAVE! ---
        // Anula la configuración por defecto de redirectGuestsTo que llama a route('login')
        // Configura la redirección para invitados a la ruta nombrada 'home'
        $middleware->redirectGuestsTo(fn (string $guard) => route('home'));
        // El callback recibe el nombre del 'guard', aunque no lo usemos para redirigir a una ruta fija.
        // También podrías usar simplemente fn () => route('home') en algunas versiones,
        // pero fn (string $guard) es más robusto y compatible con la firma del método.
        // -----------------------------

        // Ahora, registra tus alias de middleware
        $middleware->alias([
            'role' => \Spatie\Permission\Middleware\RoleMiddleware::class,
            'permission' => \Spatie\Permission\Middleware\PermissionMiddleware::class,
            'role_or_permission' => \Spatie\Permission\Middleware\RoleOrPermissionMiddleware::class,
            'auth_panel' => HandlePanelAccess::class,
            // 'check.panel' => \App\Http\Middleware\CheckPanelAccess::class,
        ]);

        // Si tienes middleware groups globales o otras configuraciones de middleware aquí, mantenlas.
        // $middleware->group('web', [ ... ]);
        // $middleware->group('api', [ ... ]);
    })
    ->withExceptions(function (Exceptions $exceptions) {
        // Tu configuración de excepciones (que ahora debería usar tu Handler.php creado)
        // Puedes dejarlo vacío si no añades más configuración aquí,
        // o puedes registrar renderables/reportables aquí si prefieres.
        // $exceptions->renderable(function (Throwable $e, Request $request) { ... });
    })
    ->create();