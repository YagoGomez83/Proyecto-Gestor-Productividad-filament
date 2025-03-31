<?php

namespace App\Filament\Reception\Resources\SolicitudeTypeResource\Pages;

use Filament\Actions;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\EditRecord;
use App\Filament\Reception\Resources\SolicitudeTypeResource;

class EditSolicitudeType extends EditRecord
{
    protected static string $resource = SolicitudeTypeResource::class;
    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
    protected function afterCreate(): void
    {
        Notification::make()
            ->title('Tipo de solicitud Actualizada')
            ->success()
            ->body('El Recurso se ha actualizado correctamente.')
            ->send();
    }
    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
