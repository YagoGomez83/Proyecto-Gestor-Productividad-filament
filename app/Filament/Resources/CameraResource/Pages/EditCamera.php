<?php

namespace App\Filament\Resources\CameraResource\Pages;

use Filament\Actions;
use App\Models\Location;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\EditRecord;
use App\Filament\Resources\CameraResource;
use Illuminate\Support\Facades\Log;

class EditCamera extends EditRecord
{
    protected static string $resource = CameraResource::class;
    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('camera.editar'); // Redirige al controlador y su vista personalizada
    }

    // Sobrescribe para usar tu vista personalizada

}
