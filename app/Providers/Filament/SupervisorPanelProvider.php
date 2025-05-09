<?php

namespace App\Providers\Filament;

use App\Filament\Supervisor\Resources\ReportResource\Widgets\ReportCauseTable;
use Filament\Pages;
use Filament\Panel;
use Filament\Widgets;
use Filament\PanelProvider;
use Filament\Support\Colors\Color;
use Illuminate\Support\Facades\Auth;
use Filament\Http\Middleware\Authenticate;
use Illuminate\Session\Middleware\StartSession;
use Illuminate\Cookie\Middleware\EncryptCookies;
use Filament\Http\Middleware\AuthenticateSession;
use Illuminate\Routing\Middleware\SubstituteBindings;
use Illuminate\View\Middleware\ShareErrorsFromSession;
use Filament\Http\Middleware\DisableBladeIconComponents;
use Filament\Http\Middleware\DispatchServingFilamentEvent;
use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken;
use Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse;
use App\Filament\Supervisor\Resources\ReportResource\Widgets\ReportChart;
use App\Filament\Supervisor\Resources\ReportResource\Widgets\ReportPoliceStationTable;
use App\Filament\Supervisor\Resources\ServiceResource\Widgets\ServicePie;
use App\Filament\Supervisor\Resources\ServiceResource\Widgets\ServiceChart;
use App\Filament\Supervisor\Resources\ServiceResource\Widgets\ServiceStats;
use App\Filament\Supervisor\Resources\WokSessionResource\Widgets\WorkSession;
use App\Filament\Supervisor\Resources\ReportResource\Widgets\ReportsByCauseChart;
use App\Filament\Supervisor\Resources\ReportResource\Widgets\ReportsByPoliceStationChart;
use App\Filament\Supervisor\Resources\ServiceResource\Widgets\ServiceChartReactive;
use App\Filament\Supervisor\Resources\WorkSessionResource\Widgets\WorkSessionTable;
use App\Http\Middleware\HandlePanelAccess;

class SupervisorPanelProvider extends PanelProvider
{
    public function panel(Panel $panel): Panel
    {
        return $panel
            ->id('supervisor')
            ->path('supervisor')
            ->login()
            ->authMiddleware([Authenticate::class, 'role:supervisor'])
            ->middleware([
                EncryptCookies::class,
                AddQueuedCookiesToResponse::class,
                StartSession::class,
                AuthenticateSession::class,
                ShareErrorsFromSession::class,
                VerifyCsrfToken::class,
                SubstituteBindings::class,
                DisableBladeIconComponents::class,
                DispatchServingFilamentEvent::class,
            ])
            ->default()
            ->colors([
                'primary' => Color::Green
            ])
            ->discoverResources(in: app_path('Filament/Supervisor/Resources'), for: 'App\\Filament\\Supervisor\\Resources')
            ->discoverPages(in: app_path('Filament/Supervisor/Pages'), for: 'App\\Filament\\Supervisor\\Pages')
            ->pages([
                Pages\Dashboard::class,
            ])
            ->discoverWidgets(in: app_path('Filament/Supervisor/Widgets'), for: 'App\\Filament\\Supervisor\\Widgets')
            ->widgets([
                WorkSessionTable::class,
                ServiceStats::class,
                ServiceChart::class,
                ServiceChartReactive::class,
                ServicePie::class,
                ReportsByCauseChart::class,
                ReportsByPoliceStationChart::class,
                ReportCauseTable::class,
                ReportPoliceStationTable::class,
            ])
            ->middleware([
                EncryptCookies::class,
                AddQueuedCookiesToResponse::class,
                StartSession::class,
                AuthenticateSession::class,
                ShareErrorsFromSession::class,
                VerifyCsrfToken::class,
                SubstituteBindings::class,
                DisableBladeIconComponents::class,
                DispatchServingFilamentEvent::class,
                HandlePanelAccess::class,
            ])
            ->authMiddleware([
                Authenticate::class,
            ]);
    }
}
