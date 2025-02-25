<?php

namespace App\Filament\Resources\VictimResource\Pages;

use Filament\Actions;
use Filament\Notifications\Notification;
use App\Filament\Resources\VictimResource;
use Filament\Resources\Pages\CreateRecord;

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
