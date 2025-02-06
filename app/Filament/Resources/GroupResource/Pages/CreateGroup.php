<?php

namespace App\Filament\Resources\GroupResource\Pages;

use Filament\Actions;
use Filament\Notifications\Notification;
use App\Filament\Resources\GroupResource;
use Filament\Resources\Pages\CreateRecord;

class CreateGroup extends CreateRecord
{
    protected static string $resource = GroupResource::class;
    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
    protected function afterCreate(): void
    {
        Notification::make()
            ->title('Grupo creado')
            ->success()
            ->body('El Grupo se ha creado correctamente.')
            ->send();
    }
}
