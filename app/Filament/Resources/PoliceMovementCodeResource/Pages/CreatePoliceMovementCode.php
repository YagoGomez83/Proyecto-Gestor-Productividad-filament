<?php

namespace App\Filament\Resources\PoliceMovementCodeResource\Pages;

use Filament\Actions;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\CreateRecord;
use App\Filament\Resources\PoliceMovementCodeResource;

class CreatePoliceMovementCode extends CreateRecord
{
    protected static string $resource = PoliceMovementCodeResource::class;
    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }

    protected function afterSave(): void
    {
        Notification::make()
            ->title('Registro creado')
            ->success()
            ->body('El código se ha creado correctamente.')
            ->send();
    }
}
