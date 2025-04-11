<?php

namespace App\Repositories;

use Carbon\Carbon;
use App\Models\Report;
use App\Models\Service;
use Illuminate\Support\Collection;
use App\Repositories\Contracts\HeatmapRepositoryInterface;

class HeatmapRepository implements HeatmapRepositoryInterface
{
    public function getFilteredReports(array $filters): Collection
    {
        $query = Report::with(['location', 'cause', 'policeStation.city']);

        if (!empty($filters['cause_id'])) {
            $query->where('cause_id', $filters['cause_id']);
        }

        if (!empty($filters['police_station_id'])) {
            $query->where('police_station_id', $filters['police_station_id']);
        }

        if (!empty($filters['city_id'])) {
            $query->whereHas('policeStation', function($q) use ($filters) {
                $q->where('city_id', $filters['city_id']);
            });
        }

        if (!empty($filters['start_date']) && !empty($filters['end_date'])) {
            $startDate = Carbon::parse($filters['start_date'])->startOfDay();
            $endDate = Carbon::parse($filters['end_date'])->endOfDay();
            
            $query->whereBetween('report_date', [$startDate, $endDate]);
        }

        if (!empty($filters['start_time']) && !empty($filters['end_time'])) {
            $query->whereTime('report_time', '>=', $filters['start_time'])
                  ->whereTime('report_time', '<=', $filters['end_time']);
        }

        return $query->get();
    }

    public function getFilteredServices(array $filters): Collection
    {
        $query = Service::with(['city', 'initialPoliceMovementCode', 'finalPoliceMovementCode','camera']);

        if (!empty($filters['city_id'])) {
            $query->where('city_id', $filters['city_id']);
        }

        if (!empty($filters['group_id'])) {
            $query->where('group_id', $filters['group_id']);
        }

        if (!empty($filters['initial_code_id'])) {
            $query->where('initial_police_movement_code_id', $filters['initial_code_id']);
        }

        if (!empty($filters['start_date']) && !empty($filters['end_date'])) {
            $startDate = Carbon::parse($filters['start_date'])->startOfDay();
            $endDate = Carbon::parse($filters['end_date'])->endOfDay();
            
            $query->whereBetween('service_date', [$startDate, $endDate]);
        }

        if (!empty($filters['start_time']) && !empty($filters['end_time'])) {
            $query->whereTime('service_time', '>=', $filters['start_time'])
                  ->whereTime('service_time', '<=', $filters['end_time']);
        }
        if (!empty($filters['status'])) {
            $query->where('status', $filters['status']);
        }
        

        return $query->get();
    }
}