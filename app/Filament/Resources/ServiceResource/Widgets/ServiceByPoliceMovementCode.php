<?php

namespace App\Filament\Resources\ServiceResource\Widgets;

use App\Models\PoliceMovementCode;
use App\Models\Service;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget as BaseWidget;
use Illuminate\Database\Eloquent\Builder;

class ServiceByPoliceMovementCode extends BaseWidget
{
    protected int | string | array $columnSpan = 'full';
    protected static ?string $heading = 'Servicios por Código de Desplazamiento';
    public array $filters = [];

    public function table(Table $table): Table
    {
        return $table
            ->query(
                PoliceMovementCode::query()
                    ->withCount([
                        'servicesAsInitial as preventive_count' => fn(Builder $query) => $this->applyFilters($query)
                            ->where('status', 'preventive'),
                        'servicesAsInitial as reactive_count' => fn(Builder $query) => $this->applyFilters($query)
                            ->where('status', 'reactive'),
                        'servicesAsInitial as total_count' => fn(Builder $query) => $this->applyFilters($query)
                    ])
                    ->orderBy('total_count', 'desc')
            )
            ->columns([
                Tables\Columns\TextColumn::make('code')
                    ->label('Código')
                    ->searchable()
                    ->sortable(),

                Tables\Columns\TextColumn::make('description')
                    ->label('Descripción')
                    ->searchable()
                    ->limit(30)
                    ->tooltip(function ($state) {
                        return strlen($state) > 30 ? $state : null;
                    }),

                Tables\Columns\TextColumn::make('preventive_count')
                    ->label('Preventivos')
                    ->numeric()
                    ->sortable(),

                Tables\Columns\TextColumn::make('reactive_count')
                    ->label('Reactivos')
                    ->numeric()
                    ->sortable(),

                Tables\Columns\TextColumn::make('total_count')
                    ->label('Total')
                    ->numeric()
                    ->sortable(),

                Tables\Columns\TextColumn::make('percentage_preventive')
                    ->label('% Preventivos')
                    ->state(function (PoliceMovementCode $record): float {
                        return $record->total_count > 0
                            ? round(($record->preventive_count / $record->total_count) * 100, 2)
                            : 0;
                    })
                    ->suffix('%'),

                Tables\Columns\TextColumn::make('percentage_reactive')
                    ->label('% Reactivos')
                    ->state(function (PoliceMovementCode $record): float {
                        return $record->total_count > 0
                            ? round(($record->reactive_count / $record->total_count) * 100, 2)
                            : 0;
                    })
                    ->suffix('%'),
            ])
            ->headerActions([
                Tables\Actions\Action::make('Filtrar')
                    ->form([
                        \Filament\Forms\Components\Select::make('initial_police_movement_code_id')
                            ->label('Código de Desplazamiento')
                            ->options(PoliceMovementCode::pluck('code', 'id'))
                            ->searchable(),

                        \Filament\Forms\Components\Select::make('status')
                            ->label('Tipo de Servicio')
                            ->options([
                                '' => 'Todos',
                                'preventive' => 'Preventivos',
                                'reactive' => 'Reactivos',
                            ]),

                        \Filament\Forms\Components\Select::make('year')
                            ->label('Año')
                            ->options(function () {
                                $years = Service::query()
                                    ->selectRaw('EXTRACT(YEAR FROM service_date) as year')
                                    ->distinct()
                                    ->orderBy('year', 'desc')
                                    ->pluck('year', 'year');

                                return $years->prepend('Todos', '');
                            }),

                        \Filament\Forms\Components\Select::make('month')
                            ->label('Mes')
                            ->options([
                                '' => 'Todos',
                                '1' => 'Enero',
                                '2' => 'Febrero',
                                '3' => 'Marzo',
                                '4' => 'Abril',
                                '5' => 'Mayo',
                                '6' => 'Junio',
                                '7' => 'Julio',
                                '8' => 'Agosto',
                                '9' => 'Septiembre',
                                '10' => 'Octubre',
                                '11' => 'Noviembre',
                                '12' => 'Diciembre',
                            ]),
                    ])
                    ->action(function (array $data): void {
                        $this->filters = [
                            'initial_police_movement_code_id' => $data['initial_police_movement_code_id'] ?? null,
                            'status' => $data['status'] ?? null,
                            'year' => $data['year'] ?? null,
                            'month' => $data['month'] ?? null,
                        ];
                    }),
            ])
            ->emptyStateHeading('No hay servicios registrados')
            ->emptyStateDescription('No se encontraron servicios para los filtros aplicados');
    }

    protected function applyFilters(Builder $query): Builder
    {
        return $query
            ->when(
                $this->filters['initial_police_movement_code_id'] ?? false,
                fn(Builder $query, $codeId) => $query->where('initial_police_movement_code_id', $codeId)
            )
            ->when(
                $this->filters['status'] ?? false,
                fn(Builder $query, $status) => $query->where('status', $status)
            )
            ->when(
                $this->filters['year'] ?? false,
                fn(Builder $query, $year) => $query->whereYear('service_date', $year)
            )
            ->when(
                $this->filters['month'] ?? false,
                fn(Builder $query, $month) => $query->whereMonth('service_date', $month)
            );
    }
}
