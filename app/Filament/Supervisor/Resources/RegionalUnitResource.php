<?php

namespace App\Filament\Supervisor\Resources;

use App\Filament\Supervisor\Resources\RegionalUnitResource\Pages;
use App\Filament\Supervisor\Resources\RegionalUnitResource\RelationManagers;
use App\Models\RegionalUnit;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class RegionalUnitResource extends Resource
{
    protected static ?string $model = RegionalUnit::class;
    protected static ?string $navigationGroup = 'Policial';
    protected static ?string $navigationLabel = 'Unidades Regionales';
    protected static ?string $navigationIcon = 'heroicon-o-building-library';
    protected static ?int $navigationSort = 3;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('name')
                    ->required()
                    ->label('Nombre')
                    ->maxLength(255),
                Forms\Components\Select::make('center_id')
                    ->relationship('center', 'name')
                    ->label('Centro')
                    ->required(),
                //
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->searchable()
                    ->label('nombre'),
                Tables\Columns\TextColumn::make('center.name')
                    ->searchable()
                    ->label('Centro')
                    ->sortable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->label('Creado')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime()
                    ->label('Actualizado')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                //
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
            'index' => Pages\ListRegionalUnits::route('/'),
            'create' => Pages\CreateRegionalUnit::route('/create'),
            'edit' => Pages\EditRegionalUnit::route('/{record}/edit'),
        ];
    }
}
