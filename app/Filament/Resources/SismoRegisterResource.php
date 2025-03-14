<?php

namespace App\Filament\Resources;

use Filament\Forms;
use Filament\Tables;
use Filament\Forms\Form;
use Filament\Tables\Table;
use App\Models\SismoRegister;
use Filament\Resources\Resource;
use App\Filament\Resources\SismoRegisterResource\Pages;
use App\Filament\Resources\SismoRegisterResource\RelationManagers;

class SismoRegisterResource extends Resource
{
    protected static ?string $model = SismoRegister::class;
    protected static ?string $navigationGroup = 'IGE';
    protected static ?string $navigationLabel = "Registros de Exportación";
    protected static ?int  $navigationSort = 1;
    protected static ?string $navigationIcon = 'heroicon-o-book-open';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\DatePicker::make('date_solicitude')
                    ->label('Fecha de la solicitud')
                    ->required(),
                Forms\Components\TextInput::make('solicitud_number')
                    ->label('Numero (Ampsum/EXD/N° Oficio)')
                    ->required(),

                Forms\Components\Select::make('solicitude_type_id')
                    ->relationship('solicitudeType', 'type')
                    ->required()
                    ->label('Tipo de solicitud'),
                Forms\Components\Select::make('center_id')
                    ->relationship('center', 'name')
                    ->required()
                    ->label('Centro'),
                Forms\Components\Select::make('police_station_id')
                    ->relationship('policeStation', 'name')
                    ->required()
                    ->label('Comisaría'),
                Forms\Components\Select::make('cause_id')
                    ->relationship('cause', 'cause_name')
                    ->required()
                    ->label('Causa'),

                // 🔥 Repeater para agregar varios CameraExport directamente desde el formulario de SismoRegister
                Forms\Components\Repeater::make('cameraExport')
                    ->relationship('cameraExport') // Se vincula con la relación
                    ->schema([
                        Forms\Components\DateTimePicker::make('start_datetime')
                            ->label('Fecha de incion')
                            ->required(),
                        Forms\Components\DateTimePicker::make('end_datetime')
                            ->label('Fecha de finalización')
                            ->required(),
                        Forms\Components\Toggle::make('success')
                            ->label('logrado'),

                        Forms\Components\Textarea::make('description')
                            ->label('Observaciones'),
                        Forms\Components\Select::make('cameras')
                            ->label('Camaras')
                            ->multiple()
                            ->relationship('cameras', 'identifier')
                            ->label('Camaras')
                            ->preload(),
                    ])
                    ->collapsible()
                    ->defaultItems(1),

                Forms\Components\Repeater::make('callLetterExport')
                    ->relationship('callLetterExport') // Se vincula con la relación
                    ->schema([
                        Forms\Components\TextInput::make('event_number')
                            ->label('Numero de Suceso')
                            ->required(),
                        Forms\Components\DateTimePicker::make('start_datetime')
                            ->label('Hora de Inicialización')
                            ->required(),
                        Forms\Components\DateTimePicker::make('end_datetime')
                            ->label('Hora de Finalización')
                            ->required(),
                        Forms\Components\Toggle::make('success')
                            ->label('logrado'),
                        Forms\Components\Textarea::make('description')
                            ->label('Observaciones'),


                    ])
                    ->collapsible()
                    ->defaultItems(1),
                Forms\Components\Textarea::make('description')
                    ->label('Observaciones'),

            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('date_solicitude')
                    ->label('Fecha de la solicitud')
                    ->sortable()
                    ->searchable()
                    ->date(),
                Tables\Columns\TextColumn::make('solicitud_number')
                    ->label('Número de solicitud')
                    ->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('solicitudeType.type')
                    ->label('Tipo de solicitud')
                    ->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('center.name')
                    ->label('Centro')
                    ->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('policeStation.name')
                    ->label('Dependencia')
                    ->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('cause.cause_name')
                    ->label('Causa')
                    ->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->label('Creado')
                    ->sortable()
                    ->searchable()
                    ->date(),
                Tables\Columns\TextColumn::make('description')
                    ->label('Descripción')
                    ->sortable()
                    ->limit(50),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
                Tables\Actions\ViewAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            RelationManagers\CameraExportRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListSismoRegisters::route('/'),
            'create' => Pages\CreateSismoRegister::route('/create'),
            'edit' => Pages\EditSismoRegister::route('/{record}/edit'),
        ];
    }
}
