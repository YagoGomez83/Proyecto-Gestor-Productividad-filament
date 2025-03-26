<?php

namespace App\Filament\Reception\Resources\PoliceStationResource\Pages;

use Filament\Actions;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\CreateRecord;
use App\Filament\Reception\Resources\PoliceStationResource;

class CreatePoliceStation extends CreateRecord
{
    protected static string $resource = PoliceStationResource::class;
    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
    protected function afterCreate(): void
    {
        Notification::make()
            ->title('Comisaria creada')
            ->success()
            ->body('La comisaria se ha creado correctamente.')
            ->send();
    }
}
