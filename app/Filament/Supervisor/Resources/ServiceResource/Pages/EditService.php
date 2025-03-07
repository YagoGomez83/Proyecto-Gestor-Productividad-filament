<?php

namespace App\Filament\Supervisor\Resources\ServiceResource\Pages;

use Filament\Actions;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\EditRecord;
use App\Filament\Supervisor\Resources\ServiceResource;

class EditService extends EditRecord
{
    protected static string $resource = ServiceResource::class;

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
            ->title('Unidad Regional actualizada')
            ->success()
            ->body('El recurso se ha actualizado correctamente.')
            ->send();
    }
}
