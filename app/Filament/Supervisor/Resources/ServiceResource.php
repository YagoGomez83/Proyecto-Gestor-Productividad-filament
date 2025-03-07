<?php

namespace App\Filament\Supervisor\Resources;

use App\Filament\Supervisor\Resources\ServiceResource\Pages;
use App\Filament\Supervisor\Resources\ServiceResource\RelationManagers;
use App\Models\Service;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class ServiceResource extends Resource
{
    protected static ?string $model = Service::class;
    protected static ?string $navigationLabel = "Servicios";
    protected static ?string $navigationGroup = 'IGE';
    protected static ?int $navigationSort = 4;
    protected static ?string $navigationIcon = 'heroicon-s-pencil-square';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\DatePicker::make('service_date')
                    ->label('Fecha')
                    ->required(),
                Forms\Components\TimePicker::make('service_time')
                    ->label('Hora')
                    ->required(),
                Forms\Components\Select::make('user_id')
                    ->relationship('user', 'name')
                    ->label('Usuario')
                    ->preload()
                    ->searchable()
                    ->required(),
                Forms\Components\Select::make('group_id')
                    ->relationship('group', 'name')
                    ->label('Grupo')
                    ->preload()
                    ->searchable()
                    ->required(),
                Forms\Components\Select::make('city_id')
                    ->relationship('city', 'name')
                    ->label('Ciudad')
                    ->searchable()
                    ->preload()
                    ->required(),
                Forms\Components\Select::make('camera_id')
                    ->relationship('camera', 'identifier')
                    ->label('Cámara')
                    ->searchable()
                    ->preload()
                    ->required(),
                Forms\Components\Select::make('initial_police_movement_code_id')
                    ->label('Código de Desplazamiento Inicial')
                    ->options(\App\Models\PoliceMovementCode::pluck('description', 'id'))
                    ->searchable()
                    ->preload()
                    ->reactive()
                    ->afterStateUpdated(fn($set) => $set('initial_sub_police_movement_code_id', null)), // Limpiar el subcódigo al cambiar el código

                Forms\Components\Select::make('initial_sub_police_movement_code_id')
                    ->label('Sub Código Inicial')
                    ->options(fn($get) => \App\Models\SubPoliceMovementCode::where('police_movement_code_id', $get('initial_police_movement_code_id'))
                        ->pluck('description', 'id'))
                    ->searchable()
                    ->preload()
                    ->reactive()
                    ->disabled(fn($get) => !$get('initial_police_movement_code_id')), // Bloquear si no hay código seleccionado

                Forms\Components\Select::make('final_police_movement_code_id')
                    ->label('Código de Desplazamiento Final')
                    ->options(\App\Models\PoliceMovementCode::pluck('description', 'id'))
                    ->searchable()
                    ->preload()
                    ->reactive()
                    ->afterStateUpdated(fn($set) => $set('final_sub_police_movement_code_id', null)),

                Forms\Components\Select::make('final_sub_police_movement_code_id')
                    ->label('Sub Código Final')
                    ->options(fn($get) => \App\Models\SubPoliceMovementCode::where('police_movement_code_id', $get('final_police_movement_code_id'))
                        ->pluck('description', 'id'))
                    ->searchable()
                    ->preload()
                    ->reactive()
                    ->disabled(fn($get) => !$get('final_police_movement_code_id')),


                Forms\Components\Select::make('status')
                    ->label('Estado')
                    ->options([
                        'preventive' => 'Preventivo',
                        'reactive' => 'Reactivo',
                    ])
                    ->required()
                    ->default('preventive'),
                Forms\Components\Textarea::make('description')
                    ->label('Descripción')
                    ->required()
                    ->columnSpanFull(),
                //
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('service_date')
                    ->label('Fecha')
                    ->date()
                    ->sortable(),
                Tables\Columns\TextColumn::make('service_time')
                    ->label('Hora')
                    ->sortable(),
                Tables\Columns\TextColumn::make('user.name')
                    ->label('Usuario')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('group.name')
                    ->label('Grupo')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('city.name')
                    ->label('Ciudad')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('initialPoliceMovementCode.code')
                    ->label('Código de desplazamiento inicial')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('finalPoliceMovementCode.code')
                    ->label('Código de desplazamiento final')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('status')
                    ->searchable(),
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
            'index' => Pages\ListServices::route('/'),
            'create' => Pages\CreateService::route('/create'),
            'edit' => Pages\EditService::route('/{record}/edit'),
        ];
    }
}
