<?php

namespace App\Filament\Supervisor\Resources\CameraResource\Pages;

use Filament\Actions;
use Filament\Actions\Action;
use Filament\Resources\Pages\ListRecords;
use App\Filament\Supervisor\Resources\CameraResource;

class ListCameras extends ListRecords
{
    protected static string $resource = CameraResource::class;

    protected function getHeaderActions(): array
    {
        return [
            // Actions\CreateAction::make(),
            Action::make('index')
                ->label('Ver cámaras')
                ->url(route('cameras.custom'), true) // Ahora apunta a la ruta personalizada
                ->icon('heroicon-o-eye'),

        ];
    }
}
