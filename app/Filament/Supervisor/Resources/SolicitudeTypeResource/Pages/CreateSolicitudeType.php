<?php

namespace App\Filament\Supervisor\Resources\SolicitudeTypeResource\Pages;

use Filament\Actions;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\CreateRecord;
use App\Filament\Supervisor\Resources\SolicitudeTypeResource;

class CreateSolicitudeType extends CreateRecord
{
    protected static string $resource = SolicitudeTypeResource::class;
    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
    protected function afterCreate(): void
    {
        Notification::make()
            ->title('Tipo de solicitud creada')
            ->success()
            ->body('Creado correctamente.')
            ->send();
    }
}
