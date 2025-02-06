<?php

namespace App\Filament\Resources\RegionalUnitResource\Pages;

use Filament\Actions;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\CreateRecord;
use App\Filament\Resources\RegionalUnitResource;

class CreateRegionalUnit extends CreateRecord
{
    protected static string $resource = RegionalUnitResource::class;
    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }

    protected function afterSave(): void
    {
        Notification::make()
            ->title('Unidad Regional creada')
            ->success()
            ->body('El recurso se ha creado correctamente.')
            ->send();
    }
}
