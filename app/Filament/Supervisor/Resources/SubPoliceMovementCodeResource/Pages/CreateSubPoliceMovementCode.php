<?php

namespace App\Filament\Supervisor\Resources\SubPoliceMovementCodeResource\Pages;

use Filament\Actions;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\CreateRecord;
use App\Filament\Supervisor\Resources\SubPoliceMovementCodeResource;

class CreateSubPoliceMovementCode extends CreateRecord
{
    protected static string $resource = SubPoliceMovementCodeResource::class;
    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
    protected function afterCreate(): void
    {
        Notification::make()
            ->title('Sub Código creado')
            ->success()
            ->body('Creado correctamente.')
            ->send();
    }
}
