<?php
namespace App\Services;

use App\Models\Report;
use App\Repositories\Contracts\HeatmapRepositoryInterface;

class HeatmapService
{
    protected HeatmapRepositoryInterface $repository;

    public function __construct(HeatmapRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    public function generateHeatmapData(array $filters): array
    {
        return $this->repository->getFilteredReports($filters)
            ->map(function ($report) {
                return [
                    'lat' => $report->location->latitude ?? null,
                    'lng' => $report->location->longitude ?? null,
                    'intensity' => 1,
                    'title' => $report->title,
                    'description' => $report->description,
                    'city' => $report->policeStation->city->name ?? null,
                    'station' => $report->policeStation->name ?? null,
                    'cause' => $report->cause->cause_name ?? null,
                    'report_id' => $report->id,
                ];
            })
            ->filter(fn ($item) => $item['lat'] && $item['lng'])
            ->values()
            ->toArray();
    }

    public function generateServiceHeatmap(array $filters): array
    {
        return $this->repository->getFilteredServices($filters)
        ->filter(fn ($service) => $service->camera && $service->camera->location)
        ->groupBy(fn ($service) => $service->camera->location->latitude . ',' . $service->camera->location->longitude)
        ->map(function ($group) {
            $first = $group->first();
            $lat = $first->camera->location->latitude;
            $lng = $first->camera->location->longitude;
    
            $codesText = $group->groupBy('initialPoliceMovementCode.description')
                ->map(fn ($items, $desc) => $desc . ': ' . $items->count())
                ->implode(', ');
    
            return [
                'lat' => $lat,
                'lng' => $lng,
                'intensity' => 0.5, // o alguna lógica basada en total_services
                'title' => $first->camera->identifier ?? 'Cámara desconocida',
                'cause' => $codesText,
                'description' => "Total de servicios: " . $group->count(),
                'station' => $first->camera->policeStation->name ?? 'No especificada',
                'city' => $first->city->name ?? 'Sin ciudad',
            ];
        })
        ->values()
        ->toArray();
    
    }
    
}
