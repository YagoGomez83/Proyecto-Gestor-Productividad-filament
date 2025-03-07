<?php

namespace App\Filament\Supervisor\Resources\WorkSessionResource\Widgets;

use Filament\Tables\Table;
use App\Models\WorkSession;
use Illuminate\Support\Facades\Auth;
use Filament\Tables\Columns\TextColumn;
use Filament\Widgets\TableWidget as BaseWidget;

class WorkSessionTable extends BaseWidget
{
    protected static ?string $heading = 'Sesiones de Trabajo';

    public function table(Table $table): Table
    {
        // Consulta para obtener los registros
        $query = WorkSession::query()
            ->with(['user', 'group'])
            ->where('group_id', Auth::user()->group_id)
            ->selectRaw('
            (user_id || \'-\' || group_id || \'-\' || work_date) AS id,
            work_date, 
            user_id, 
            group_id,
            SUM(CASE WHEN type = \'work\' THEN EXTRACT(EPOCH FROM (end_time - start_time)) / 60 ELSE 0 END) AS total_work_time,
            SUM(CASE WHEN type = \'pause\' THEN EXTRACT(EPOCH FROM (end_time - start_time)) / 60 ELSE 0 END) AS total_pause_time
        ')
            ->groupBy('user_id', 'group_id', 'work_date')
            ->orderBy('work_date', 'desc');



        // Pasar la consulta directamente a Filament
        return $table
            ->query($query) // Pasamos la consulta directamente, no los resultados
            ->columns([
                TextColumn::make('work_date')
                    ->label('Fecha de Trabajo')
                    ->date()
                    ->sortable()
                    ->searchable(),

                TextColumn::make('user.name')
                    ->label('Nombre')
                    ->sortable()
                    ->searchable(),

                TextColumn::make('group.name')
                    ->label('Grupo')
                    ->sortable(),

                TextColumn::make('total_work_time')
                    ->label('Tiempo de Trabajo')
                    ->getStateUsing(function ($record) {
                        // Verificar si total_work_time es null y retornar 0 en su lugar
                        $totalWorkTime = $record->total_work_time ?? 0;
                        return $this->formatMinutes($totalWorkTime);
                    }),

                TextColumn::make('total_pause_time')
                    ->label('Tiempo de Descanso')
                    ->getStateUsing(function ($record) {
                        // Verificar si total_pause_time es null y retornar 0 en su lugar
                        $totalPauseTime = $record->total_pause_time ?? 0;
                        return $this->formatMinutes($totalPauseTime);
                    })
            ]);
    }

    private function formatMinutes($minutes)
    {
        // Asegurarse de que minutos no sea null o vacío
        $minutes = $minutes ?? 0;

        $hours = floor($minutes / 60);
        $remainingMinutes = $minutes % 60;
        return sprintf('%02d:%02d', $hours, $remainingMinutes);
    }
}
