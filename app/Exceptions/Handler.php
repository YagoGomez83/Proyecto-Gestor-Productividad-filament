<?php

namespace App\Exceptions;

use Throwable;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\Request; // Importa Request si aún no está
use Illuminate\Http\Response; // Importa Response si aún no está
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Auth\AuthenticationException; // Importa esta clase

class Handler extends ExceptionHandler
{
    /**
     * A list of exception types with their corresponding custom log levels.
     *
     * @var array<class-string<\Throwable>, \Psr\Log\LogLevel::*>
     */
    protected $levels = [
        //
    ];

    /**
     * A list of the exception types that are not reported.
     *
     * @var array<int, class-string<\Throwable>>
     */
    protected $dontReport = [
        //
    ];

    /**
     * A list of the inputs that are never flashed to the session on validation exceptions.
     *
     * @var array<int, string>
     */
    protected $dontFlash = [
        'current_password',
        'password',
        'password_confirmation',
    ];

    /**
     * Register the exception handling callbacks for the application.
     *
     * @return void
     */
    public function register()
    {
        $this->reportable(function (Throwable $e) {
            //
        });

        // Puedes usar register()->renderable() si prefieres no anular render() completamente
        // $this->renderable(function (Throwable $e, Request $request) {
        //     if ($e instanceof AuthenticationException && ! $request->expectsJson()) {
        //         // Captura AuthenticationException para solicitudes web
        //         // Redirige a la ruta 'home'
        //         return redirect()->route('home');
        //     }
        //     // Para otras excepciones, no necesitas hacer nada aquí si usas parent::render()
        //     // return parent::render($request, $e); // Si llamas a render aquí
        // });
    }

    /**
     * Render an exception into an HTTP response.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Throwable  $exception
     * @return \Symfony\Component\HttpFoundation\Response
     *
     * @throws \Throwable
     */
    public function render($request, Throwable $exception)
{
    // Log para saber si el método render se está ejecutando
    Log::info('Handler render called for exception: ' . get_class($exception) . ' on path: ' . $request->path());

    // --- MODIFICACIÓN CLAVE ---
    if ($exception instanceof AuthenticationException && ! $request->expectsJson()) {
        Log::info('AuthenticationException caught in handler. Redirecting to home.');
        return redirect()->route('home');
    }
    // --- FIN MODIFICACIÓN CLAVE ---

    // Para todas las demás excepciones...
    Log::info('Exception not AuthenticationException or expects JSON. Letting parent render.');
    return parent::render($request, $exception);
}
}