<?php

namespace App\Filament\Supervisor\Resources\ReportResource\Widgets;

use App\Models\PoliceStation;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget as BaseWidget;
use Illuminate\Database\Eloquent\Builder;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Section;
use Carbon\Carbon;

class ReportPoliceStationTable extends BaseWidget
{
    protected int | string | array $columnSpan = 'full';
    protected static ?string $heading = 'Infomes Especiales Por Dependencia';
    public ?string $filterYear = null;
    public ?string $filterMonth = null;
    public ?string $filterDay = null;


    public function table(Table $table): Table
    {
        return $table
            ->query(
                PoliceStation::query()
                    ->withCount(['reports' => function (Builder $query) {
                        $query->when($this->filterYear, function (Builder $query) {
                            $query->whereYear('report_date', $this->filterYear);
                        })
                            ->when($this->filterMonth, function (Builder $query) {
                                $query->whereMonth('report_date', $this->filterMonth);
                            })
                            ->when($this->filterDay, function (Builder $query) {
                                $query->whereDay('report_date', $this->filterDay);
                            });
                    }])
                    ->with(['city']) // Cargar la relación ciudad
                    ->orderBy('reports_count', 'desc')
            )
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->label('Comisaría')
                    ->searchable()
                    ->sortable(),

                Tables\Columns\TextColumn::make('city.name')
                    ->label('Ciudad')
                    ->searchable()
                    ->sortable(),

                Tables\Columns\TextColumn::make('reports_count')
                    ->label('Cantidad de Reportes')
                    ->numeric()
                    ->sortable(),
            ])
            ->headerActions([
                Tables\Actions\Action::make('Filtrar')
                    ->form([
                        Section::make('Filtros por fecha')
                            ->schema([
                                Select::make('filterYear')
                                    ->label('Año')
                                    ->options(function () {
                                        $years = [];
                                        $startYear = 2020; // Año inicial
                                        $endYear = now()->year;

                                        for ($year = $startYear; $year <= $endYear; $year++) {
                                            $years[$year] = $year;
                                        }

                                        return $years;
                                    })
                                    ->placeholder('Todos los años'),

                                Select::make('filterMonth')
                                    ->label('Mes')
                                    ->options([
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
                                    ])
                                    ->placeholder('Todos los meses'),

                                TextInput::make('filterDay')
                                    ->label('Día')
                                    ->type('number')
                                    ->minValue(1)
                                    ->maxValue(31)
                                    ->placeholder('Todos los días'),
                            ])
                            ->columns(3)
                    ])
                    ->action(function (array $data): void {
                        $this->filterYear = $data['filterYear'] ?? null;
                        $this->filterMonth = $data['filterMonth'] ?? null;
                        $this->filterDay = $data['filterDay'] ?? null;
                    })
            ]);
    }

    public function getTableRecordsPerPageSelectOptions(): array
    {
        return [10, 25, 50, 100];
    }
}
