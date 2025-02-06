<?php

namespace App\Filament\Resources\RegionalUnitResource\Pages;

use Filament\Actions;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\EditRecord;
use App\Filament\Resources\RegionalUnitResource;

class EditRegionalUnit extends EditRecord
{
    protected static string $resource = RegionalUnitResource::class;
    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }

    protected function afterSave(): void
    {
        Notification::make()
            ->title('Unidad Regional actualizada')
            ->success()
            ->body('El recurso se ha actualizado correctamente.')
            ->send();
    }

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
