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
    protected int | string | array $columnSpan = 'full';
    

    public function table(Table $table): Table
    {
        // Consulta para obtener los registros
        $query = WorkSession::query()
            ->with(['user', 'group'])
            ->where('group_id', Auth::user()->group_id)
            ->selectRaw('
                CONCAT(user_id, "-", group_id, "-", work_date) AS id,
                work_date, 
                user_id, 
                group_id,
                SUM(CASE WHEN type = \'work\' THEN TIMESTAMPDIFF(SECOND, start_time, end_time) / 60 ELSE 0 END) AS total_work_time,
                SUM(CASE WHEN type = \'pause\' THEN TIMESTAMPDIFF(SECOND, start_time, end_time) / 60 ELSE 0 END) AS total_pause_time
            ')
            ->groupBy('user_id', 'group_id', 'work_date')
            ->orderBy('work_date', 'desc');

        return $table
            ->query($query)
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
                        $totalWorkTime = $record->total_work_time ?? 0;
                        return $this->formatMinutes($totalWorkTime);
                    }),

                TextColumn::make('total_pause_time')
                    ->label('Tiempo de Descanso')
                    ->getStateUsing(function ($record) {
                        $totalPauseTime = $record->total_pause_time ?? 0;
                        return $this->formatMinutes($totalPauseTime);
                    })
            ]);
    }

    private function formatMinutes($minutes)
    {
        $minutes = $minutes ?? 0;
        $hours = floor($minutes / 60);
        $remainingMinutes = $minutes % 60;
        return sprintf('%02d:%02d', $hours, $remainingMinutes);
    }
}