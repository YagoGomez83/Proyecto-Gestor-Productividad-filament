<?php

namespace App\Filament\Resources\SismoRegisterResource\Pages;

use Filament\Actions;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\CreateRecord;
use App\Filament\Resources\SismoRegisterResource;

class CreateSismoRegister extends CreateRecord
{
    protected static string $resource = SismoRegisterResource::class;

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
    protected function afterCreate(): void
    {
        Notification::make()
            ->title('Registro creado')
            ->success()
            ->body('Creado correctamente.')
            ->send();
    }
}
