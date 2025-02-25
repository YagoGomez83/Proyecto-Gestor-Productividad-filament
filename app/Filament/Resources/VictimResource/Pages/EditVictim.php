<?php

namespace App\Filament\Resources\VictimResource\Pages;

use Filament\Actions;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\EditRecord;
use App\Filament\Resources\VictimResource;

class EditVictim extends EditRecord
{
    protected static string $resource = VictimResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
            Actions\ForceDeleteAction::make(),
            Actions\RestoreAction::make(),
        ];
    }

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }

    protected function afterSave(): void
    {
        Notification::make()
            ->title('Registro actualizado')
            ->success()
            ->body('El Damnificado se ha actualizado correctamente.')
            ->send();
    }
}
