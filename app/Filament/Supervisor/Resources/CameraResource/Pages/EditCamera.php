<?php

namespace App\Filament\Supervisor\Resources\CameraResource\Pages;

use App\Filament\Supervisor\Resources\CameraResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditCamera extends EditRecord
{
    protected static string $resource = CameraResource::class;

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('camera.editar'); // Redirige al controlador y su vista personalizada
    }
}
