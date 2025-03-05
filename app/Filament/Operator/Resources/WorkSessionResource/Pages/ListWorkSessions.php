<?php

namespace App\Filament\Operator\Resources\WorkSessionResource\Pages;

use Carbon\Carbon;
use Filament\Actions;
use App\Models\WorkSession;
use Filament\Actions\Action;
use Illuminate\Support\Facades\Auth;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\ListRecords;
use App\Filament\Operator\Resources\WorkSessionResource;

class ListWorkSessions extends ListRecords
{
    protected static string $resource = WorkSessionResource::class;

    protected function getHeaderActions(): array
    {
        $lastWorkSession = WorkSession::where('user_id', Auth::user()->id)->latest()->first();
        $user = Auth::user();

        return [
            $this->startWorkAction($lastWorkSession, $user),
            $this->endWorkAction($lastWorkSession),
            $this->startPauseAction($lastWorkSession, $user),
            $this->endPauseAction($lastWorkSession, $user),
        ];
    }

    private function startWorkAction($lastWorkSession, $user)
    {
        return Action::make('start_work')
            ->label('Comenzar a trabajar')
            ->color('success')
            ->icon('heroicon-o-play')
            ->requiresConfirmation()
            ->visible(!$lastWorkSession || !is_null($lastWorkSession->end_time))
            ->action(function () use ($user) {
                WorkSession::create([
                    'user_id' => $user->id,
                    'group_id' => $user->group_id,
                    'work_date' => now()->toDateString(),
                    'start_time' => now(),
                    'type' => 'work',
                ]);

                Notification::make()
                    ->title('Sesión de Trabajo Iniciada')
                    ->body('Has comenzado una sesión de trabajo.')
                    ->color('success')
                    ->send();
            });
    }

    private function endWorkAction($lastWorkSession)
    {
        return Action::make('end_work')
            ->label('Finalizar trabajo')
            ->color('danger')
            ->icon('heroicon-o-stop')
            ->requiresConfirmation()
            ->visible($lastWorkSession && is_null($lastWorkSession->end_time) && $lastWorkSession->type === 'work')
            ->action(function () use ($lastWorkSession) {
                $lastWorkSession->update(['end_time' => now()]);

                Notification::make()
                    ->title('Sesión de Trabajo Finalizada')
                    ->body('Has terminado una sesión de trabajo.')
                    ->color('danger')
                    ->send();
            });
    }

    private function startPauseAction($lastWorkSession, $user)
    {
        return Action::make('start_pause')
            ->label('Iniciar descanso')
            ->color('info')
            ->icon('heroicon-o-pause')
            ->requiresConfirmation()
            ->visible($lastWorkSession && is_null($lastWorkSession->end_time) && $lastWorkSession->type === 'work')
            ->action(function () use ($lastWorkSession, $user) {
                $lastWorkSession->update(['end_time' => now()]);

                WorkSession::create([
                    'user_id' => $user->id,
                    'group_id' => $user->group_id,
                    'start_time' => now(),
                    'work_date' => now()->toDateString(),
                    'type' => 'pause',
                ]);

                Notification::make()
                    ->title('Descanso Iniciado')
                    ->body('Has iniciado un descanso.')
                    ->color('info')
                    ->send();
            });
    }

    private function endPauseAction($lastWorkSession, $user)
    {
        return Action::make('end_pause')
            ->label('Finalizar descanso')
            ->color('info')
            ->icon('heroicon-o-play')
            ->requiresConfirmation()
            ->visible($lastWorkSession && is_null($lastWorkSession->end_time) && $lastWorkSession->type === 'pause')
            ->action(function () use ($lastWorkSession, $user) {
                $lastWorkSession->update(['end_time' => now()]);

                WorkSession::create([
                    'user_id' => $user->id,
                    'group_id' => $user->group_id,
                    'start_time' => now(),
                    'work_date' => now()->toDateString(),
                    'type' => 'work',
                ]);

                Notification::make()
                    ->title('Descanso Finalizado')
                    ->body('Has finalizado tu descanso.')
                    ->color('success')
                    ->send();
            });
    }
}
