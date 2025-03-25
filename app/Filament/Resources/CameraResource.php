<?php

namespace App\Filament\Resources;


use Filament\Forms;
use Filament\Tables;
use App\Models\Camera;

// use Livewire\Livewire;
use App\Models\Location;
use Filament\Forms\Form;
use Filament\Tables\Table;


// use Filament\Actions\Action;
use Filament\Tables\Actions\Action;
use Filament\Tables\Actions\EditAction;
use Filament\Resources\Resource;
use Filament\Forms\Components\Hidden;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Fieldset;
use Filament\Forms\Components\Livewire;
use Filament\Tables\Columns\TextColumn;
use App\Forms\Components\LocationPicker;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\ViewField;
use App\Filament\Resources\CameraResource\Pages;



class CameraResource extends Resource
{
    protected static ?string $model = Camera::class;

    protected static ?string $navigationGroup = 'IGE';
    protected static ?string $navigationLabel = 'Cámaras';
    protected static ?string $navigationIcon = 'heroicon-o-video-camera';
    protected static ?int $navigationSort = 2;
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


            // Campo de selección de ubicación
            // Select::make('location_id')
            //     ->label('Ubicación')
            //     ->options(Location::all()->pluck('address', 'id')) // Carga las ubicaciones existentes
            //     ->searchable()
            //     ->required()
            //     ->reactive()
            //     ->afterStateUpdated(function ($state, callable $set) {
            //         $set('latitude', Location::find($state)?->latitude ?? null);
            //         $set('longitude', Location::find($state)?->longitude ?? null);
            //     }),

            // Fieldset::make('Ubicación personalizada')
            //     ->schema([
            //         TextInput::make('address')
            //             ->label('Dirección')
            //             ->required()
            //             ->placeholder('Ingrese la dirección manualmente'),

            //         Hidden::make('latitude')
            //             ->reactive()
            //             ->default(fn($record) => $record?->location?->latitude ?? -33.2975),

            //         Hidden::make('longitude')
            //             ->reactive()
            //             ->default(fn($record) => $record?->location?->longitude ?? -66.3356),

            //         // ViewField::make('location_picker')
            //         //     ->view('filament.forms.components.location-picker') // Asegúrate de que esta vista exista
            //         // ->viewData([
            //         //     'latitude' => -33.2975,
            //         //     'longitude' => -66.3356,
            //         // ]),
            //     ])->columns(1),
        ]);
    }

    // public static function getActions(): array
    // {
    //     return [
    //         Action::make('createWithLocation')
    //             ->label('Crear con ubicación')
    //             ->url(route('camera.create'))
    //             ->icon('heroicon-o-plus'),
    //     ];
    // }




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
            ->actions([
                Action::make('editWithLocation')
                    ->label('Editar')
                    ->url(fn($record) => route('camera.edit', $record->id))
                    ->icon('heroicon-o-pencil'),

            ])
            ->defaultSort('created_at', 'desc')
            ->filters([
                //
            ])
            ->actions([
                // Tables\Actions\EditAction::make(),
                // Tables\Actions\ViewAction::make(),
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
