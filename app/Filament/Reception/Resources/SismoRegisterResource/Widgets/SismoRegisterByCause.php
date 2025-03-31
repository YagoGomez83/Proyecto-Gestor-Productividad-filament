<?php

namespace App\Filament\Reception\Resources\SismoRegisterResource\Widgets;

use App\Models\SismoRegister;
use App\Models\SolicitudeType;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget as BaseWidget;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\DB;

class SismoRegisterByCause extends BaseWidget
{
    protected int | string | array $columnSpan = 'full';
    protected static ?string $heading = 'Informes Especiales por Tipo de Solicitud';
    public array $filters = [];

    public function table(Table $table): Table
    {
        return $table
            ->query(
                SolicitudeType::query()
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
                Tables\Columns\TextColumn::make('type')
                    ->label('Tipo de Solicitud')
                    ->searchable()
                    ->sortable(),

                Tables\Columns\TextColumn::make('sismo_registers_count')
                    ->label('Cantidad')
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
            ->emptyStateHeading('No hay registros')
            ->emptyStateDescription('No se encontraron registros para los filtros aplicados');
    }
}
