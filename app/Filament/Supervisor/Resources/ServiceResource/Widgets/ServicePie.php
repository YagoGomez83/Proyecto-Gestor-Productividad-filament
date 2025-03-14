<?php

namespace App\Filament\Supervisor\Resources\ServiceResource\Widgets;

use Filament\Widgets\ChartWidget;
use App\Models\Service;
use Illuminate\Support\Facades\Auth;

class ServicePie extends ChartWidget
{
    protected static ?string $heading = 'Distribución de Servicios';

    public ?string $filter = 'month';

    protected function getFilters(): ?array
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
        $groupId = Auth::user()->group_id;

        $query = Service::where('group_id', $groupId);

        $query->whereBetween('service_date', [
            match ($activeFilter) {
                'today' => now()->startOfDay(),
                'month' => now()->subMonth(),
                'year' => now()->startOfYear(),
                default => now()->subMonth(),
            },
            now()
        ]);

        $reactiveCount = (clone $query)->where('status', 'reactive')->count();
        $preventiveCount = (clone $query)->where('status', 'preventive')->count();

        return [
            'datasets' => [
                [
                    'data' => [$reactiveCount, $preventiveCount],
                    'backgroundColor' => ['#FF6384', '#36A2EB'],
                    'hoverBackgroundColor' => ['#FF4364', '#2492DB'],
                ],
            ],
            'labels' => ['Reactivos', 'Preventivos'],
        ];
    }

    protected function getType(): string
    {
        return 'pie';
    }
}
