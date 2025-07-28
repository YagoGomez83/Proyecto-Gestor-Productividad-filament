<?php

namespace App\Filament\Supervisor\Resources;

use Filament\Forms;
use Filament\Tables;
use App\Models\Camera;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Filament\Resources\Resource;
use Filament\Tables\Actions\Action;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Supervisor\Resources\CameraResource\Pages;
use App\Filament\Supervisor\Resources\CameraResource\RelationManagers;

class CameraResource extends Resource
{
    protected static ?string $model = Camera::class;

    protected static ?string $navigationGroup = 'IGE';
    protected static ?string $navigationLabel = 'Cámaras';
    protected static ?string $navigationIcon = 'heroicon-o-video-camera';
    protected static ?int $navigationSort = 2;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('identifier')
                    ->label('Identificador')
                    ->required(),

                Select::make('city_id')
                    ->relationship('city', 'name')
                    ->label('Ciudad')
                    ->required(),

                Select::make('police_station_id')
                    ->relationship('policeStation', 'name')
                    ->label('Comisaría')
                    ->required(),
                //
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('identifier')
                    ->label('Identificador')
                    ->searchable(),
                Tables\Columns\TextColumn::make('city.name')
                    ->label('Ciudad')
                    ->numeric()
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('policeStation.name')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('location.address')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->actions([
                Action::make('editWithLocation')
                    ->label('Editar')
                    ->url(fn($record) => route('camera.edit', $record->id))
                    ->icon('heroicon-o-pencil'),
                //
            ])
            ->defaultSort('created_at', 'desc')
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\DeleteAction::make(),
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
            'index' => Pages\ListCameras::route('/'),
            'create' => Pages\CreateCamera::route('/create'),
            'edit' => Pages\EditCamera::route('/{record}/edit'),
        ];
    }
}
