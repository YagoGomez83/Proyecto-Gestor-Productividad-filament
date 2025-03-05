<?php

namespace App\Filament\Operator\Resources\WorkSessionResource\Widgets;

use Carbon\Carbon;
use App\Models\User;
use App\Models\WorkSession;
use Illuminate\Support\Facades\Auth;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;

class WorkSessionCart extends BaseWidget
{
    protected function getStats(): array
    {
        return [
            Stat::make('Total de trabajo', $this->getTotalWork(Auth::user())),
            Stat::make('Total de Descanso', $this->getTotalPause(Auth::user())),
            // Add more stats as needed...
            //
        ];
    }
    protected function getTotalWork(User $user)
    {
        $workSession = WorkSession::where('user_id', $user->id)
            ->where('type', 'work')
            ->whereDate('created_at', Carbon::today())->get();
        $totalWork = 0;
        foreach ($workSession as $work) {
            $startTime = Carbon::parse($work->start_time);
            $endTime = $work->end_time ? Carbon::parse($work->end_time) : now(); // Si end_time es NULL, usamos now()

            $totalDuration = $endTime->diffInSeconds($startTime);
            $totalWork += $totalDuration;
        }

        $timeFormat = gmdate('H:i:s', $totalWork);
        return $timeFormat;
    }
    protected function getTotalPause(User $user)
    {
        $workSession = WorkSession::where('user_id', $user->id)->where('type', 'pause')->whereDate('created_at', Carbon::today())->get();
        // dd($workSession->start_time);
        $totalPause = 0;
        foreach ($workSession as $work) {
            $startTime = Carbon::parse($work->start_time);
            $endTime = $work->end_time ? Carbon::parse($work->end_time) : now(); // Si end_time es NULL, usamos now()

            $totalDuration = $endTime->diffInSeconds($startTime);
            $totalPause += $totalDuration;
        }

        $timeFormat = gmdate('H:i:s', $totalPause);
        return $timeFormat;
    }
}
