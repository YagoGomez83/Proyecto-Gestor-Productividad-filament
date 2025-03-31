<?php

namespace App\Filament\Supervisor\Resources\ReportResource\Widgets;

use App\Models\Cause;
use App\Models\Report;
use Filament\Widgets\ChartWidget;
use Illuminate\Support\Facades\DB;
use Flowframe\Trend\Trend;
use Flowframe\Trend\TrendValue;

class ReportsByCauseChart extends ChartWidget
{
    protected static ?string $heading = 'Informes por Causa';
    protected static ?string $description = 'Cantidad de informes agrupados por causa.';
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

        // Obtener causas con conteo de informes en el período seleccionado
        $causes = Cause::withCount([
            'reports' => function ($query) use ($startDate) {
                $query->where('report_date', '>=', $startDate)
                    ->where('report_date', '<=', now());
            }
        ])
            ->orderBy('reports_count', 'desc')
            ->limit(10) // Limitar a las 10 causas principales
            ->get();

        return [
            'datasets' => [
                [
                    'label' => 'Cantidad de Informes',
                    'data' => $causes->pluck('reports_count')->toArray(),
                    'backgroundColor' => '#4f46e5', // Color personalizable
                ],
            ],
            'labels' => $causes->pluck('cause_name')->toArray(),
        ];
    }

    protected function getType(): string
    {
        return 'bar';
    }
}
