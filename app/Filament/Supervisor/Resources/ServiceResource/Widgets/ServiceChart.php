<?php

namespace App\Filament\Supervisor\Resources\ServiceResource\Widgets;

use Filament\Widgets\ChartWidget;
use Flowframe\Trend\Trend;
use Flowframe\Trend\TrendValue;
use App\Models\Service;
use Carbon\Carbon;

class ServiceChart extends ChartWidget
{
    protected static ?string $heading = 'Servicios por Mes';

    public ?string $filter = 'month'; // Filtro predeterminado

    protected function getFilters(): ?array
    {
        return [
            'month' => 'Último mes',
            'year' => 'Este año',
        ];
    }

    protected function getData(): array
    {
        $now = Carbon::now();

        if ($this->filter === 'month') {
            $data = Trend::model(Service::class)
                ->between(
                    start: $now->startOfMonth(),
                    end: $now->endOfMonth(),
                )
                ->perDay()
                ->count();
        } else {
            $data = Trend::model(Service::class)
                ->between(
                    start: $now->startOfYear(),
                    end: $now->endOfYear(),
                )
                ->perMonth()
                ->count();
        }

        return [
            'datasets' => [
                [
                    'label' => 'Servicios',
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
