<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ReportResource\Pages;
use App\Filament\Resources\ReportResource\RelationManagers;
use App\Models\Report;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class ReportResource extends Resource
{
    protected static ?string $model = Report::class;
    protected static ?string $navigationGroup = 'IGE';
    protected static ?string $navigationLabel = 'Informes Especiales';
    protected static ?int $navigationSort = 5;
    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('title')
                    ->label('Identificador')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('description')
                    ->label('Descripción')
                    ->required()
                    ->maxLength(255),
                Forms\Components\DatePicker::make('report_date')
                    ->label('Fecha del Informe')
                    ->required(),
                Forms\Components\TextInput::make('report_time')
                    ->label('Hora del Informe')
                    ->required(),
                Forms\Components\Select::make('location_id')
                    ->relationship('location', 'address')
                    ->label('Ubicación')
                    ->required(),
                Forms\Components\Select::make('user_id')
                    ->label('Creado Por:')
                    ->relationship('user', 'name')
                    ->required(),
                Forms\Components\Select::make('police_station_id')
                    ->label('Dependencia')
                    ->relationship('policeStation', 'name')
                    ->required(),
                Forms\Components\Select::make('cause_id')
                    ->label('Causa')
                    ->relationship('cause', 'cause_name')
                    ->required(),
                Forms\Components\Select::make('accuseds')
                    ->relationship('accuseds', 'name')
                    ->getOptionLabelFromRecordUsing(fn($record) => "({$record->name} - {$record->lastName} - Apodo: {$record->nickName})")
                    ->multiple()
                    ->preload()
                    ->label('Sospechosos'),
                Forms\Components\Select::make('victims')
                    ->relationship('victims', 'name')
                    ->getOptionLabelFromRecordUsing(fn($record) => "({$record->name} - {$record->lastName})")
                    ->multiple()
                    ->preload()
                    ->label('Damnificados'),
                Forms\Components\Select::make('vehicles')
                    ->relationship('vehicles', 'brand')
                    ->getOptionLabelFromRecordUsing(fn($record) => "({$record->brand} - {$record->model} - {$record->plate_number})")
                    ->multiple()
                    ->preload()
                    ->label('Vehículos involucrados'),
                Forms\Components\Select::make('cameras')
                    ->relationship('cameras', 'identifier')
                    ->multiple()
                    ->preload()
                    ->label('Cámaras involucradas'),
                Forms\Components\Repeater::make('specialReportRequest')
                    ->relationship('specialReportRequest')
                    ->schema([
                        Forms\Components\TextInput::make('sismo_register_id')
                            ->label('Número de Solicitud')
                            ->disabled(),
                    ])
                    ->label('Solicitudes de Informe Especial')
                    ->collapsible()
                    ->columnSpanFull(),

            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('title')
                    ->label('Identificador')
                    ->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('description')
                    ->label('Descripción')
                    ->sortable(),
                Tables\Columns\TextColumn::make('report_date')
                    ->label('Fecha del Informe')
                    ->date()
                    ->sortable(),
                Tables\Columns\TextColumn::make('report_time')
                    ->label('Hora del Informe')
                    ->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('location.address')
                    ->label('Ubicación')
                    ->limit(30)
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('user.name')
                    ->label('Creado por')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('policeStation.name')
                    ->label('Dependencia ')
                    ->sortable(),
                Tables\Columns\TextColumn::make('cause.cause_name')
                    ->label('Causa ')
                    ->sortable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->label('Creado')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->defaultSort('created_at', 'desc')
            ->filters([
                Tables\Filters\TrashedFilter::make(),
            ])
            ->actions([

                Tables\Actions\DeleteAction::make(),
                Tables\Actions\ViewAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                    Tables\Actions\ForceDeleteBulkAction::make(),
                    Tables\Actions\RestoreBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListReports::route('/'),
            'create' => Pages\CreateReport::route('/create'),
            'edit' => Pages\EditReport::route('/{record}/edit'),
        ];
    }

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()
            ->withoutGlobalScopes([
                SoftDeletingScope::class,
            ]);
    }
}
