<?php

namespace App\Filament\Supervisor\Resources;

use Filament\Forms;
use Filament\Tables;
use Filament\Forms\Form;
use Filament\Tables\Table;
use App\Models\WorkSession;
use Filament\Resources\Resource;
use Illuminate\Support\Facades\Auth;
use Filament\Tables\Filters\SelectFilter;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Supervisor\Resources\WorkSessionResource\Pages;
use App\Filament\Supervisor\Resources\WorkSessionResource\RelationManagers;

class WorkSessionResource extends Resource
{
    protected static ?string $model = WorkSession::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    protected function getElocuentQuery(): Builder
    {
        return parent::getEloquentQuery()->where('group_id', Auth::user()->group_id)->orderBy('start_time', 'desc');
    }
    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('type')->options([
                    'work' => 'Work',
                    'pause' => 'Pause',
                ])->required(),
                Forms\Components\DateTimePicker::make('start_time')->required(),
                Forms\Components\DateTimePicker::make('end_time')->required(),
                Forms\Components\DateTimePicker::make('work_date')->required(),

                //
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('group.name')
                    ->label('Grupo')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('user.name')
                    ->label('Operador')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('type')
                    ->label('Tipo')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('start_time')
                    ->label('Inicio')
                    ->dateTime()
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('end_time')
                    ->label('Fin')
                    ->dateTime()
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('work_date')
                    ->label('Fecha')
                    ->date()
                    ->searchable()
                    ->sortable(),
                //
            ])
            ->filters([
                SelectFilter::make('type')->options([
                    'work' => 'Work',
                    'pause' => 'Pause',
                ]),
                //
            ])
            ->actions([

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
            'index' => Pages\ListWorkSessions::route('/'),
            'create' => Pages\CreateWorkSession::route('/create'),
            'edit' => Pages\EditWorkSession::route('/{record}/edit'),
        ];
    }
}
