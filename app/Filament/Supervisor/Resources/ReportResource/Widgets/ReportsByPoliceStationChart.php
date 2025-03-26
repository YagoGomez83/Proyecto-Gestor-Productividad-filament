<?php

namespace App\Filament\Supervisor\Resources\ReportResource\Widgets;

use App\Models\PoliceStation;
use App\Models\Report;
use Filament\Widgets\ChartWidget;
use Illuminate\Support\Facades\DB;
use Flowframe\Trend\Trend;
use Flowframe\Trend\TrendValue;

class ReportsByPoliceStationChart extends ChartWidget
{
    protected static ?string $heading = 'Informes por Dependencia';
    protected static ?string $description = 'Cantidad de informes agrupados por dependencia.';
    public ?string $filter = 'month';

    protected function getFilters(): array
    {
        return [
            'today' => 'Hoy',
            'month' => 'Último mes',
            'year' => 'Este año',
        ];
    }

    protected function getData(): array
    {
        $activeFilter = $this->filter;

        $startDate = match ($activeFilter) {
            'today' => now()->startOfDay(),
            'month' => now()->subMonth(),
            'year' => now()->startOfYear(),
            default => now()->subMonth(),
        };

        // Obtener comisarías con conteo de informes en el período seleccionado
        $policeStations = PoliceStation::withCount([
            'reports' => function ($query) use ($startDate) {
                $query->where('report_date', '>=', $startDate)
                    ->where('report_date', '<=', now());
            }
        ])
            ->orderBy('reports_count', 'desc')
            ->limit(10) // Limitar a las 10 comisarías principales
            ->get();

        return [
            'datasets' => [
                [
                    'label' => 'Cantidad de Informes',
                    'data' => $policeStations->pluck('reports_count')->toArray(),
                    'backgroundColor' => '#10b981', // Color personalizable
                ],
            ],
            'labels' => $policeStations->pluck('name')->toArray(),
        ];
    }

    protected function getType(): string
    {
        return 'bar';
    }
}
