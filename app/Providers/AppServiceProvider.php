<?php

namespace App\Providers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\ServiceProvider;
use BezhanSalleh\PanelSwitch\PanelSwitch;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */

    public function boot()
    {
        PanelSwitch::configureUsing(function (PanelSwitch $panelSwitch) {
            $user = Auth::user(); // Obtiene el usuario autenticado

            // Si no hay usuario autenticado, el switcher no es visible
            if (!$user) {
                $panelSwitch->visible(fn() => false);
                return;
            }

            $availablePanels = [];

            // Reglas de visibilidad según el rol del usuario
            if ($user->hasRole('coordinator')) {
                // Coordinador puede ver todos los paneles
                $availablePanels = [
                    'admin' => 'Panel de Administrador',
                    'supervisor' => 'Panel de Supervisor',
                    'operator' => 'Panel de Operador',
                ];
            } elseif ($user->hasRole('supervisor')) {
                // Supervisor solo puede ver los paneles de Supervisor y Operador
                $availablePanels = [
                    'supervisor' => 'Panel de Supervisor',
                    'operator' => 'Panel de Operador',
                ];
            } elseif ($user->hasRole('operator')) {
                // Operador no puede ver ningún panel
                $panelSwitch->visible(fn() => false);
                return;
            }

            // Configurar los paneles visibles y mostrar el switcher solo si hay paneles disponibles
            $panelSwitch
                ->labels($availablePanels)
                ->visible(fn() => !empty($availablePanels)); // Solo visible si hay paneles disponibles
        });
    }
}
