<?php

namespace App\Filament\Supervisor\Resources\ServiceResource\Widgets;

use Filament\Widgets\ChartWidget;
use Flowframe\Trend\Trend;
use Flowframe\Trend\TrendValue;
use App\Models\Service;
use Carbon\Carbon;
use Illuminate\Contracts\Support\Htmlable;
use Illuminate\Support\Facades\Auth;

class ServiceChart extends ChartWidget
{
    protected static ?string $heading = 'Servicios Preventivos'; // Título del widget

    public ?string $filter = 'month'; // Filtro predeterminado

    protected function getFilters(): ?array
    {
        return [
            'today' => 'Hoy',
            'month' => 'Último mes',
            'year' => 'Este año',
        ];
    }

    public function getDescription(): string|Htmlable|null
    {
        return 'Cantidad de servicios Preventivos';
    }

    protected function getData(): array
    {
        $activeFilter = $this->filter;
        $data = Trend::query(Service::where('group_id', Auth::user()->group_id)->where('status', 'preventive'))
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
                    'label' => 'Servicios Preventuvos',
                    'data' => $data->map(fn(TrendValue $value) => $value->aggregate),
                ],
            ],
            'labels' => $data->map(fn(TrendValue $value) => $value->date),
        ];
    }

    protected function getType(): string
    {
        return 'bar'; // Gráfico de barras
    }
}
