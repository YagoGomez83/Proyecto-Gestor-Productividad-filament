<?php

namespace App\Filament\Reception\Resources\CauseResource\Pages;

use Filament\Actions;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\EditRecord;
use App\Filament\Reception\Resources\CauseResource;

class EditCause extends EditRecord
{
    protected static string $resource = CauseResource::class;
    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }

    protected function afterSave(): void
    {
        Notification::make()
            ->title('Registro actualizado')
            ->success()
            ->body('La causa se ha actualizado correctamente.')
            ->send();
    }
    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
