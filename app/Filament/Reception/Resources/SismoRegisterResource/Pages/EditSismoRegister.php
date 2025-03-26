<?php

namespace App\Filament\Reception\Resources\SismoRegisterResource\Pages;

use Filament\Actions;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\EditRecord;
use App\Filament\Reception\Resources\SismoRegisterResource;

class EditSismoRegister extends EditRecord
{
    protected static string $resource = SismoRegisterResource::class;

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
            ->title('Solicitud Actualizada')
            ->success()
            ->body('La solicitud se ha actualizado correctamente.')
            ->send();
    }
}
