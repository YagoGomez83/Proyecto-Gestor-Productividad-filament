<?php

namespace App\Filament\Resources\CityResource\Pages;

use Filament\Actions;
use App\Filament\Resources\CityResource;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\CreateRecord;

class CreateCity extends CreateRecord
{
    protected static string $resource = CityResource::class;
    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }

    protected function afterSave(): void
    {
        Notification::make()
            ->title('Registro creado')
            ->success()
            ->body('La ciudad se ha creado correctamente.')
            ->send();
    }
}
