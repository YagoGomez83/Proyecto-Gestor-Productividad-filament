<?php

namespace App\Filament\Supervisor\Resources\AccusedResource\Pages;

use Filament\Actions;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\CreateRecord;
use App\Filament\Supervisor\Resources\AccusedResource;

class CreateAccused extends CreateRecord
{
    protected static string $resource = AccusedResource::class;
    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
    protected function afterCreate(): void
    {
        Notification::make()
            ->title('Sospechoso creado')
            ->success()
            ->body('El sospechoso se ha creado correctamente.')
            ->send();
    }
}
