<?php

namespace App\Filament\Reception\Resources\CityResource\Pages;

use Filament\Actions;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\CreateRecord;
use App\Filament\Reception\Resources\CityResource;

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
