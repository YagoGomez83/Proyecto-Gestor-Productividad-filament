<?php

namespace App\Filament\Reception\Resources;

use App\Filament\Reception\Resources\ApplicationForAdmissionResource\Pages;
use App\Filament\Reception\Resources\ApplicationForAdmissionResource\RelationManagers;
use App\Models\ApplicationForAdmission;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class ApplicationForAdmissionResource extends Resource
{
    protected static ?string $model = ApplicationForAdmission::class;
    protected static ?string $navigationGroup = 'IGE';
    protected static ?string $navigationLabel = "Solicitud de Ingreso Agente Externo";
    protected static ?int  $navigationSort = 2;
    protected static ?string $navigationIcon = 'heroicon-o-bookmark-square';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\DateTimePicker::make('date_solicitude')
                    ->label('Fecha de la solicitud')
                    ->required(),
                Forms\Components\TextInput::make('name')
                    ->label('Nombre y Apellido')
                    ->required(),
                Forms\Components\TextInput::make('police_hierarchy')
                    ->label('Jerarquía Policial')
                    ->required(),
                Forms\Components\Select::make('cause_id')
                    ->relationship('cause', 'cause_name')
                    ->required()
                    ->label('Causa'),
                Forms\Components\Select::make('police_station_id')
                    ->relationship('policeStation', 'name')
                    ->required()
                    ->label('Dependencia'),
                Forms\Components\Select::make('center_id')
                    ->relationship('center', 'name')
                    ->required()
                    ->label('Centro'),

                Forms\Components\Select::make('cameras')
                    ->relationship('cameras', 'identifier')
                    ->multiple()
                    ->preload()
                    ->label('Camaras')
                    ->required(),
                Forms\Components\Textarea::make('observations')
                    ->label('Observaciones'),
                //
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('user.name')
                    ->label('Creado por')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('date_solicitude')
                    ->label('Fecha de la solicitud')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('name')
                    ->label('Nombre y Apellido')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('police_hierarchy')
                    ->label('Jerarquía Policial')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('cause.cause_name')
                    ->label('Causa')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('policeStation.name')
                    ->label('Dependencia')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('center.name')
                    ->label('Centro')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('observations')
                    ->label('Observaciones')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->label('Creado')
                    ->searchable()
                    ->sortable(),
                //
            ])
            ->defaultSort('created_at', 'desc')
            ->filters([
                //
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
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListApplicationForAdmissions::route('/'),
            'create' => Pages\CreateApplicationForAdmission::route('/create'),
            'edit' => Pages\EditApplicationForAdmission::route('/{record}/edit'),
        ];
    }
}
