<?php

namespace App\Filament\Supervisor\Resources\ServiceResource\Widgets;

use App\Models\Service;
use Flowframe\Trend\Trend;
use Flowframe\Trend\TrendValue;
use Filament\Widgets\ChartWidget;
use Illuminate\Support\Facades\Auth;

class ServiceChartReactive extends ChartWidget
{
    protected static ?string $heading = 'Servicios Reactivos';
    protected static ?string $description = 'Cantidad de servicios reactivos.';
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
        $data = Trend::query(Service::where('group_id', Auth::user()->group_id)->where('status', 'reactive'))
            ->between(
                start: match ($activeFilter) {
                    'today' => now()->startOfDay(),
                    'month' => now()->subMonth(),
                    'year' => now()->startOfYear(),
                    default => now()->subMonth(),
                },
                end: now()
            )
            ->dateColumn('service_date')
            ->perDay()
            ->count();
        return [
            'datasets' => [
                [
                    'label' => 'Servicios Reactivos',
                    'data' => $data->map(fn(TrendValue $trend) => $trend->aggregate)->toArray(),
                ],
            ],
            'labels' => $data->map(fn(TrendValue $trend) => $trend->date)->toArray(), // Add labels as needed. For example, 'Monday', 'Tuesday', etc.

            //
        ];
    }

    protected function getType(): string
    {
        return 'bar';
    }
}
