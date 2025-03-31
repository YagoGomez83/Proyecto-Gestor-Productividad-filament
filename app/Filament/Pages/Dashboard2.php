<?php

namespace App\Filament\Pages;


use Filament\Pages\Page;
use Filament\Facades\Filament;
use Illuminate\Support\Facades\Auth;

class Dashboard extends Page
{
    protected static ?string $navigationIcon = 'heroicon-o-document-text';

    protected static string $view = 'filament.pages.dashboard';

    public function mount(): void
    {
        if (!Auth::user()->hasRole(['coordinator'])) {
            Auth::logout();
            redirect('/')->with('error', 'No tienes acceso al panel de administración.');
        }
    }

    public function authorizeRoleBasedWidgets()
    {
        $user = Auth::user(); // Obtiene al usuario autenticado

        // Definir widgets según el rol
        // if ($user->isOperator()) {
        //     $this->addOperatorWidgets();
        // } elseif ($user->isSupervisor()) {
        //     $this->addSupervisorWidgets();
        // } elseif ($user->isCoordinator()) {
        //     $this->addCoordinatorWidgets();
        // }
    }

    public function addOperatorWidgets()
    {
        $this->widgets([
            \Filament\Widgets\StatsOverviewWidget::class,  // Agregar widgets para operadores
            // Agregar widgets específicos de operador
        ]);
    }

    public function addSupervisorWidgets()
    {
        $this->widgets([
            \Filament\Widgets\StatsOverviewWidget::class,  // Agregar widgets para supervisores
            // Agregar widgets específicos de supervisor
        ]);
    }

    public function addCoordinatorWidgets()
    {
        $this->widgets([
            \Filament\Widgets\StatsOverviewWidget::class,  // Agregar widgets para coordinadores
            // Agregar widgets específicos de coordinador
        ]);
    }
}
