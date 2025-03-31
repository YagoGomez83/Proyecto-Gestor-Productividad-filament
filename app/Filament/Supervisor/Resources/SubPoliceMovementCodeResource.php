<?php

namespace App\Filament\Supervisor\Resources;

use App\Filament\Supervisor\Resources\SubPoliceMovementCodeResource\Pages;
use App\Filament\Supervisor\Resources\SubPoliceMovementCodeResource\RelationManagers;
use App\Models\SubPoliceMovementCode;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class SubPoliceMovementCodeResource extends Resource
{
    protected static ?string $model = SubPoliceMovementCode::class;
    protected static ?string $navigationGroup = 'Policial';
    protected static ?string $navigationLabel = 'Sub Códigos de Desplazamientos';
    protected static ?string $navigationIcon = 'heroicon-s-pencil-square';
    protected static ?int $navigationSort = 6;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('police_movement_code_id')
                    ->relationship('policeMovementCode', 'code')
                    ->label('Código de desplazamiento')
                    ->required(),
                Forms\Components\TextInput::make('description')
                    ->label('Descripción')
                    ->required()
                    ->maxLength(255),
                //
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('description')
                    ->searchable(),
                Tables\Columns\TextColumn::make('policeMovementCode.code')
                    ->label('Código de desplazamiento')
                    ->sortable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime()
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
            'index' => Pages\ListSubPoliceMovementCodes::route('/'),
            'create' => Pages\CreateSubPoliceMovementCode::route('/create'),
            'edit' => Pages\EditSubPoliceMovementCode::route('/{record}/edit'),
        ];
    }
}
