<?php

namespace App\Filament\Supervisor\Resources\VictimResource\Pages;

use Filament\Actions;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\CreateRecord;
use App\Filament\Supervisor\Resources\VictimResource;

class CreateVictim extends CreateRecord
{
    protected static string $resource = VictimResource::class;
    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
    protected function afterCreate(): void
    {
        Notification::make()
            ->title('Damnificado creado')
            ->success()
            ->body('El Damnificado se ha creado correctamente.')
            ->send();
    }
}
