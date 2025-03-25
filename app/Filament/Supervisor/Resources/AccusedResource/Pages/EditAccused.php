<?php

namespace App\Filament\Supervisor\Resources\AccusedResource\Pages;

use Filament\Actions;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\EditRecord;
use App\Filament\Supervisor\Resources\AccusedResource;

class EditAccused extends EditRecord
{
    protected static string $resource = AccusedResource::class;

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

    protected function afterSave(): void
    {
        Notification::make()
            ->title('Registro actualizado')
            ->success()
            ->body('El Sospechoso se ha actualizado correctamente.')
            ->send();
    }
}
