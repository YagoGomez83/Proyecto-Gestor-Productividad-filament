<?php

namespace App\Filament\Resources\ServiceResource\Widgets;

use App\Models\Group;
use App\Models\Service;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget as BaseWidget;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Carbon;

class ServiceByGroup extends BaseWidget
{
    protected int | string | array $columnSpan = 'full';
    protected static ?string $heading = 'Servicios por Grupo';
    public array $filters = [];

    public function table(Table $table): Table
    {
        return $table
            ->query(
                Group::query()
                    ->withCount([
                        'services as preventive_count' => fn(Builder $query) => $this->applyFilters($query)->where('status', 'preventive'),
                        'services as reactive_count' => fn(Builder $query) => $this->applyFilters($query)->where('status', 'reactive'),
                        'services as total_count' => fn(Builder $query) => $this->applyFilters($query)
                    ])
                    ->orderBy('total_count', 'desc')
            )
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->label('Grupo')
                    ->searchable()
                    ->sortable(),

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
                    ->state(function (Group $record): float {
                        return $record->total_count > 0
                            ? round(($record->preventive_count / $record->total_count) * 100, 2)
                            : 0;
                    })
                    ->suffix('%'),

                Tables\Columns\TextColumn::make('percentage_reactive')
                    ->label('% Reactivos')
                    ->state(function (Group $record): float {
                        return $record->total_count > 0
                            ? round(($record->reactive_count / $record->total_count) * 100, 2)
                            : 0;
                    })
                    ->suffix('%'),
            ])
            ->headerActions([
                Tables\Actions\Action::make('Filtrar')
                    ->form([
                        \Filament\Forms\Components\Select::make('group_id')
                            ->label('Grupo')
                            ->options(Group::pluck('name', 'id'))
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
                            'group_id' => $data['group_id'] ?? null,
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
            ->when($this->filters['group_id'] ?? false, function (Builder $query, $groupId) {
                $query->where('group_id', $groupId);
            })
            ->when($this->filters['status'] ?? false, function (Builder $query, $status) {
                $query->where('status', $status);
            })
            ->when($this->filters['year'] ?? false, function (Builder $query, $year) {
                $query->whereYear('service_date', $year);
            })
            ->when($this->filters['month'] ?? false, function (Builder $query, $month) {
                $query->whereMonth('service_date', $month);
            });
    }
}
