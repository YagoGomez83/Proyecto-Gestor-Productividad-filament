<?php

namespace App\Filament\Supervisor\Resources\PoliceMovementCodeResource\Pages;

use Filament\Actions;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\EditRecord;
use App\Filament\Supervisor\Resources\PoliceMovementCodeResource;

class EditPoliceMovementCode extends EditRecord
{
    protected static string $resource = PoliceMovementCodeResource::class;

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }

    protected function afterSave(): void
    {
        Notification::make()
            ->title('Código actualizado')
            ->success()
            ->body('El código se ha actualizado correctamente.')
            ->send();
    }
    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
