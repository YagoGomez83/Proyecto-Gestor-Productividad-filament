<?php

namespace App\Filament\Resources\GroupResource\Pages;

use Filament\Actions;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\EditRecord;
use App\Filament\Resources\GroupResource;

class EditGroup extends EditRecord
{
    protected static string $resource = GroupResource::class;
    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
    protected function afterCreate(): void
    {
        Notification::make()
            ->title('Grupo Actualizado')
            ->success()
            ->body('El Grupo se ha actualizado correctamente.')
            ->send();
    }

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
