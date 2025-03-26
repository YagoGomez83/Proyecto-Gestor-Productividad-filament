<?php

namespace App\Filament\Reception\Resources;

use App\Filament\Reception\Resources\SolicitudeTypeResource\Pages;
use App\Filament\Reception\Resources\SolicitudeTypeResource\RelationManagers;
use App\Models\SolicitudeType;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class SolicitudeTypeResource extends Resource
{
    protected static ?string $model = SolicitudeType::class;
    protected static ?string $navigationGroup = 'IGE';
    protected static ?string $navigationLabel = "Tipos de Solicitudes";
    protected static ?int  $navigationSort = 7;
    protected static ?string $navigationIcon = 'heroicon-o-folder';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('type')
                    ->label('Tipo')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('description')
                    ->label('Descripcion')
                    ->required()
                    ->maxLength(255),
                //
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('type')
                    ->label('Tipo')
                    ->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('description')
                    ->label('Descripción')
                    ->sortable()
                    ->searchable(),
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
            'index' => Pages\ListSolicitudeTypes::route('/'),
            'create' => Pages\CreateSolicitudeType::route('/create'),
            'edit' => Pages\EditSolicitudeType::route('/{record}/edit'),
        ];
    }
}
