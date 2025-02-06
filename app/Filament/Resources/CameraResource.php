<?php

namespace App\Filament\Resources;


use Filament\Forms;
use Filament\Tables;
use App\Models\Camera;

use Livewire\Livewire;
use Filament\Forms\Form;
use Filament\Tables\Table;

use App\Livewire\LocationPicker;
use Filament\Resources\Resource;
use Filament\Forms\Components\Hidden;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Fieldset;
use Filament\Tables\Columns\TextColumn;
use Filament\Forms\Components\TextInput;
use Illuminate\Database\Eloquent\Builder;
use Filament\Forms\Components\ToggleButtons;
use App\Filament\Resources\CameraResource\Pages;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\CameraResource\RelationManagers;


class CameraResource extends Resource
{
    protected static ?string $model = Camera::class;

    protected static ?string $navigationGroup = 'IGE';
    protected static ?string $navigationLabel = 'Cámaras';
    protected static ?string $navigationIcon = 'heroicon-o-video-camera';
    protected static ?int $navigationSort = 1;
    public static function form(Forms\Form $form): Forms\Form
    {
        return $form->schema([
            // Otros campos
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

            Fieldset::make('Ubicación')
                ->schema([
                    TextInput::make('address')
                        ->label('Dirección')
                        ->required()
                        ->reactive(),



                    Hidden::make('latitude')
                        ->reactive()
                        ->default(fn($record) => $record?->location?->latitude),

                    Hidden::make('longitude')
                        ->reactive()
                        ->default(fn($record) => $record?->location?->longitude),

                    Hidden::make('address')
                        ->reactive()
                        ->default(fn($record) => $record?->location?->address),


                    \Filament\Forms\Components\ViewField::make('map')
                        ->view('filament.forms.leaflet-map')
                        ->label('Seleccione la ubicación')
                        ->afterStateUpdated(function ($state, $get) {
                            $latitude = $get('latitude');
                            $longitude = $get('longitude');
                            $address = $get('address');

                            // Emitir el evento a Livewire
                            self::emit('setLocation', $latitude, $longitude, $address);
                        })



                ])->columns(1),
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
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\ViewAction::make(),
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
            'location' => Pages\CameraLocationMap::route('/location'),
        ];
    }
}
