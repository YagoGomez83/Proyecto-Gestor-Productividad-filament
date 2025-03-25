<?php

namespace App\Filament\Supervisor\Resources\CauseResource\Pages;

use Filament\Actions;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\CreateRecord;
use App\Filament\Supervisor\Resources\CauseResource;

class CreateCause extends CreateRecord
{
    protected static string $resource = CauseResource::class;
    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
    protected function afterCreate(): void
    {
        Notification::make()
            ->title('Causa creada')
            ->success()
            ->body('La causa se ha creado correctamente.')
            ->send();
    }
}
