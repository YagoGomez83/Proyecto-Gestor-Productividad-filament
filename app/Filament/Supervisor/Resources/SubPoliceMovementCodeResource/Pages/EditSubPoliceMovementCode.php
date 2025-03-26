<?php

namespace App\Filament\Supervisor\Resources\SubPoliceMovementCodeResource\Pages;

use Filament\Actions;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\EditRecord;
use App\Filament\Supervisor\Resources\SubPoliceMovementCodeResource;

class EditSubPoliceMovementCode extends EditRecord
{
    protected static string $resource = SubPoliceMovementCodeResource::class;
    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
    protected function afterCreate(): void
    {
        Notification::make()
            ->title('Sub Código actualizado')
            ->success()
            ->body('Actualizado correctamente.')
            ->send();
    }
    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
