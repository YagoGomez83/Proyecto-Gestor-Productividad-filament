<?php

namespace App\Filament\Resources\CityResource\Pages;

use Filament\Actions;
use App\Filament\Resources\CityResource;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\EditRecord;

class EditCity extends EditRecord
{
    protected static string $resource = CityResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }

    protected function afterSave(): void
    {
        Notification::make()
            ->title('Ciudad actualizada')
            ->success()
            ->body('La ciudad se ha actualizado correctamente.')
            ->send();
    }
}
