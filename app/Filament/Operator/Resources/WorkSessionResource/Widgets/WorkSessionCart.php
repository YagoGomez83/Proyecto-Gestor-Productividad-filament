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
            Stat::make('Duración de la sesión actual', $this->getCurrentSessionDuration(Auth::user())),
            // Add more stats as needed...
            //
        ];
    }
    protected function getTotalWork(User $user)
    {
        $workSessions = WorkSession::where('user_id', $user->id)
            ->where('type', 'work')
            ->whereDate('created_at', Carbon::today())
            ->get();

        $totalWork = 0;
        // dd($workSessions);
        foreach ($workSessions as $session) {
            if ($session->end_time) {
                $endTime = Carbon::parse($session->end_time);
            } else {
                $endTime = now(); // Si está en curso
            }

            $startTime = Carbon::parse($session->start_time);


            $totalWork += abs($endTime->diffInSeconds($startTime)); // Siempre positivo

            // dd($totalWork, $startTime, $endTime);
        }

        return gmdate('H:i:s', $totalWork);
    }

    protected function getTotalPause(User $user)
    {
        $pauseSessions = WorkSession::where('user_id', $user->id)
            ->where('type', 'pause')
            ->whereDate('created_at', Carbon::today())
            ->get();

        $totalPause = 0;

        foreach ($pauseSessions as $session) {
            if ($session->end_time) {
                $endTime = Carbon::parse($session->end_time);
            } else {
                $endTime = now(); // Si está en curso
            }

            $startTime = Carbon::parse($session->start_time);
            $totalPause += abs($endTime->diffInSeconds($startTime));
        }

        return gmdate('H:i:s', $totalPause);
    }

    protected function getCurrentSessionDuration(User $user): string
    {
        $lastSession = WorkSession::where('user_id', $user->id)
            ->latest()
            ->first();

        if (!$lastSession) {
            return "Sin registros";
        }

        $status = $lastSession->type === 'work' ? 'Trabajo' : 'Descanso';

        if ($lastSession->end_time) {
            $startTime = Carbon::parse($lastSession->start_time);
            $endTime = Carbon::parse($lastSession->end_time);
            $minutes = floor($endTime->diffInSeconds($startTime) / 60);
        } else {
            // Si la sesión aún está activa, calcular desde el inicio hasta ahora
            $startTime = Carbon::parse($lastSession->start_time);
            $minutes = abs(floor(now()->diffInSeconds($startTime) / 60));
        }
        // dd($minutes);
        return "{$status} - {$minutes} minutos";
    }
}
