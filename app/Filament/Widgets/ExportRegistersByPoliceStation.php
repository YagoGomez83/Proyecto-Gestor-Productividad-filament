<?php

namespace App\Filament\Widgets;

use App\Models\PoliceStation;
use App\Models\SismoRegister;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget as BaseWidget;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\DB;

class ExportRegistersByPoliceStation extends BaseWidget
{
    protected int | string | array $columnSpan = 'full';
    protected static ?string $heading = 'Exportaciones de Registros por Comisaría';
    public array $filters = [];

    public function table(Table $table): Table
    {
        return $table
            ->query(
                PoliceStation::query()
                    ->with(['city'])
                    ->withCount([
                        'sismoRegisters as complete_exports_count' => function (Builder $query) {
                            $query->where('complete', true)
                                ->whereHas('cameraExport')
                                ->when($this->filters['year'] ?? false, function ($query, $year) {
                                    $query->whereYear('date_solicitude', $year);
                                })
                                ->when($this->filters['month'] ?? false, function ($query, $month) {
                                    $query->whereMonth('date_solicitude', $month);
                                })
                                ->when($this->filters['day'] ?? false, function ($query, $day) {
                                    $query->whereDay('date_solicitude', $day);
                                });
                        },
                        'sismoRegisters as incomplete_exports_count' => function (Builder $query) {
                            $query->where('complete', false)
                                ->whereHas('cameraExport')
                                ->when($this->filters['year'] ?? false, function ($query, $year) {
                                    $query->whereYear('date_solicitude', $year);
                                })
                                ->when($this->filters['month'] ?? false, function ($query, $month) {
                                    $query->whereMonth('date_solicitude', $month);
                                })
                                ->when($this->filters['day'] ?? false, function ($query, $day) {
                                    $query->whereDay('date_solicitude', $day);
                                });
                        },
                        'sismoRegisters as total_exports_count' => function (Builder $query) {
                            $query->whereHas('cameraExport')
                                ->when($this->filters['year'] ?? false, function ($query, $year) {
                                    $query->whereYear('date_solicitude', $year);
                                })
                                ->when($this->filters['month'] ?? false, function ($query, $month) {
                                    $query->whereMonth('date_solicitude', $month);
                                })
                                ->when($this->filters['day'] ?? false, function ($query, $day) {
                                    $query->whereDay('date_solicitude', $day);
                                });
                        }
                    ])
                    ->orderBy('total_exports_count', 'desc')
            )
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->label('Comisaría')
                    ->searchable()
                    ->sortable(),

                Tables\Columns\TextColumn::make('city.name')
                    ->label('Ciudad')
                    ->sortable(),

                Tables\Columns\TextColumn::make('complete_exports_count')
                    ->label('Entregados')
                    ->sortable()
                    ->numeric()
                    ->color('success'),

                Tables\Columns\TextColumn::make('incomplete_exports_count')
                    ->label('No entregados')
                    ->sortable()
                    ->numeric()
                    ->color('danger'),

                Tables\Columns\TextColumn::make('total_exports_count')
                    ->label('Total')
                    ->sortable()
                    ->numeric()
                    ->color('primary'),
            ])
            ->headerActions([
                Tables\Actions\Action::make('Filtrar')
                    ->form([
                        \Filament\Forms\Components\Select::make('year')
                            ->label('Año')
                            ->options(function () {
                                $years = SismoRegister::select(DB::raw('EXTRACT(YEAR FROM date_solicitude) as year'))
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

                        \Filament\Forms\Components\Select::make('day')
                            ->label('Día')
                            ->options(function (callable $get) {
                                $days = range(1, 31);
                                $options = ['' => 'Todos'];
                                foreach ($days as $day) {
                                    $options[$day] = $day;
                                }
                                return $options;
                            }),
                    ])
                    ->action(function (array $data): void {
                        $this->filters = [
                            'year' => $data['year'] ?? null,
                            'month' => $data['month'] ?? null,
                            'day' => $data['day'] ?? null,
                        ];
                    }),
            ])
            ->actions([
                Tables\Actions\Action::make('Ver Detalles')
                    ->url(fn(PoliceStation $record): string => route('filament.admin.resources.services.index', [
                        'tableFilters' => [
                            'police_station_id' => [
                                'value' => $record->id,
                            ],
                            'complete' => [
                                'value' => 'all',
                            ],
                            'date_solicitude' => [
                                'year' => $this->filters['year'] ?? null,
                                'month' => $this->filters['month'] ?? null,
                                'day' => $this->filters['day'] ?? null,
                            ],
                            'has_export' => [
                                'value' => true,
                            ],
                        ],
                    ]))
                    ->icon('heroicon-o-eye'),
            ])
            ->emptyStateHeading('No hay exportaciones')
            ->emptyStateDescription('No se encontraron exportaciones para los filtros aplicados');
    }
}
