<?php

namespace App\Filament\Operator\Widgets;

use Flowframe\Trend\Trend;
use Flowframe\Trend\TrendValue;
use Filament\Widgets\ChartWidget;
use App\Models\WorkSession;
use Illuminate\Support\Carbon;

class WorkSessionsChart extends ChartWidget
{
    protected static ?string $heading = 'Work Sessions';

    public ?string $filter = 'daily';

    protected function getFilters(): array
    {
        return [
            'daily' => 'Diario',
            'weekly' => 'Semanal',
            'monthly' => 'Mensual',
        ];
    }

    protected function getType(): string
    {
        return 'bar';
    }

    protected function getData(): array
    {
        $query = WorkSession::query();
        $filter = $this->filter;

        $trend = Trend::model(WorkSession::class)
            ->between(
                start: now()->subMonth(), // Último mes como referencia
                end: now()
            );

        switch ($filter) {
            case 'weekly':
                $trend = $trend->perWeek();
                break;
            case 'monthly':
                $trend = $trend->perMonth();
                break;
            default:
                $trend = $trend->perDay();
                break;
        }

        $data = $trend->count();

        return [
            'datasets' => [
                [
                    'label' => 'Sesiones de Trabajo',
                    'data' => $data->map(fn(TrendValue $value) => $value->aggregate)->toArray(),
                ],
            ],
            'labels' => $data->map(fn(TrendValue $value) => $value->date)->toArray(),
        ];
    }
}
