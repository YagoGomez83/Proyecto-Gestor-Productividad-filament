<?php

namespace App\Filament\Reception\Resources\SismoRegisterResource\Widgets;

use App\Models\PoliceStation;
use App\Models\SismoRegister;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget as BaseWidget;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\DB;

class SismoRegisterByPoliceStation extends BaseWidget
{
    protected int | string | array $columnSpan = 'full';
    protected static ?string $heading = 'Registros por Comisaría';
    public array $filters = [];

    public function table(Table $table): Table
    {
        return $table
            ->query(
                PoliceStation::query()
                    ->with(['city'])
                    ->withCount(['sismoRegisters' => function (Builder $query) {
                        // Aplicar filtros de fecha si están presentes
                        if ($this->filters['year'] ?? false) {
                            $query->whereYear('date_solicitude', $this->filters['year']);
                        }

                        if ($this->filters['month'] ?? false) {
                            $query->whereMonth('date_solicitude', $this->filters['month']);
                        }

                        if ($this->filters['day'] ?? false) {
                            $query->whereDay('date_solicitude', $this->filters['day']);
                        }
                    }])
                    ->orderBy('sismo_registers_count', 'desc')
            )
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->label('Comisaría')
                    ->searchable()
                    ->sortable(),

                Tables\Columns\TextColumn::make('city.name')
                    ->label('Ciudad')
                    ->sortable(),

                Tables\Columns\TextColumn::make('sismo_registers_count')
                    ->label('Cantidad de Registros')
                    ->sortable()
                    ->numeric(),
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
                    ->url(fn(PoliceStation $record): string => route('filament.reception.resources.sismo-registers.index', [
                        'tableFilters' => [
                            'police_station_id' => [
                                'value' => $record->id,
                            ],
                            'date_solicitude' => [
                                'year' => $this->filters['year'] ?? null,
                                'month' => $this->filters['month'] ?? null,
                                'day' => $this->filters['day'] ?? null,
                            ],
                        ],
                    ]))
                    ->icon('heroicon-o-eye'),
            ])
            ->emptyStateHeading('No hay registros')
            ->emptyStateDescription('No se encontraron registros para los filtros aplicados');
    }
}
