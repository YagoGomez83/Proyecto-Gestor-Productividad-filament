<?php

namespace App\Filament\Reception\Resources\PoliceStationResource\Pages;

use Filament\Actions;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\EditRecord;
use App\Filament\Reception\Resources\PoliceStationResource;

class EditPoliceStation extends EditRecord
{
    protected static string $resource = PoliceStationResource::class;

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
    protected function afterCreate(): void
    {
        Notification::make()
            ->title('Comisaria Actualizada')
            ->success()
            ->body('La comisaria se ha actualizada correctamente.')
            ->send();
    }
}
