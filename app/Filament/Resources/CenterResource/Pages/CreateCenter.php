<?php

namespace App\Filament\Resources\CenterResource\Pages;

use Filament\Actions;
use Filament\Notifications\Notification;
use App\Filament\Resources\CenterResource;
use Filament\Resources\Pages\CreateRecord;

class CreateCenter extends CreateRecord
{
    protected static string $resource = CenterResource::class;

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
    protected function afterCreate(): void
    {
        Notification::make()
            ->title('Centro creado')
            ->success()
            ->body('El Centro se ha creado correctamente.')
            ->send();
    }
}
