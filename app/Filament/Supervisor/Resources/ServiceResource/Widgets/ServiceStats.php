<?php

namespace App\Filament\Supervisor\Resources\ServiceResource\Widgets;

use App\Models\Service;
use Illuminate\Support\Facades\Auth;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Carbon\Carbon;

class ServiceStats extends BaseWidget
{
    protected function getStats(): array
    {
        return [
            Stat::make('Total de servicios preventivos', $this->getTotalServicePreventive()),
            Stat::make('Total de servicios reactivos', $this->getTotalServiceReactive()),
            Stat::make('Total de servicios', $this->getTotalServices()),
        ];
    }

    protected function getTotalServicePreventive()
    {
        return Service::where('group_id', Auth::user()->group_id)
            ->where('status', 'preventive')
            ->whereMonth('service_date', Carbon::now()->month) // Solo mes actual
            ->whereYear('service_date', Carbon::now()->year) // Solo año actual
            ->count();
    }

    protected function getTotalServiceReactive()
    {
        return Service::where('group_id', Auth::user()->group_id)
            ->where('status', 'reactive')
            ->whereMonth('service_date', Carbon::now()->month) // Solo mes actual
            ->whereYear('service_date', Carbon::now()->year) // Solo año actual
            ->count();
    }

    protected function getTotalServices()
    {
        $totalServiceReactive = Service::where('group_id', Auth::user()->group_id)
            ->where('status', 'reactive')
            ->whereMonth('service_date', Carbon::now()->month) // Solo mes actual
            ->whereYear('service_date', Carbon::now()->year) // Solo año actual
            ->count();

        $totalServicePreventive = Service::where('group_id', Auth::user()->group_id)
            ->where('status', 'preventive')
            ->whereMonth('service_date', Carbon::now()->month) // Solo mes actual
            ->whereYear('service_date', Carbon::now()->year) // Solo año actual
            ->count();

        return ($totalServiceReactive / 2) + $totalServicePreventive;
    }
}
