<?php

namespace App\Filament\Resources\SismoRegisterResource\RelationManagers;

use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;

class CameraExportRelationManager extends RelationManager
{
    protected static string $relationship = 'cameraExport';

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\DateTimePicker::make('start_datetime')->required(),
                Forms\Components\DateTimePicker::make('end_datetime')->required(),
                Forms\Components\Toggle::make('success')->required(),
                Forms\Components\Textarea::make('description'),
                Forms\Components\Select::make('cameras')
                    ->multiple()
                    ->relationship('cameras', 'name')
                    ->preload(),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('start_datetime')->dateTime(),
                Tables\Columns\TextColumn::make('end_datetime')->dateTime(),
                Tables\Columns\IconColumn::make('success')
                    ->boolean()
                    ->trueIcon('heroicon-o-check-circle')
                    ->falseIcon('heroicon-o-x-circle')
                    ->colors([
                        'success' => true,
                        'danger' => false,
                    ]),
                Tables\Columns\TextColumn::make('description')->limit(50),
                Tables\Columns\TextColumn::make('cameras.name')->label('Cameras')->badge(),
            ])
            ->filters([])
            ->headerActions([
                Tables\Actions\CreateAction::make(),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }
}
