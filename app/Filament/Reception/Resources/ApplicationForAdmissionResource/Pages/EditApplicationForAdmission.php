<?php

namespace App\Filament\Reception\Resources\ApplicationForAdmissionResource\Pages;

use Filament\Actions;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\EditRecord;
use App\Filament\Reception\Resources\ApplicationForAdmissionResource;

class EditApplicationForAdmission extends EditRecord
{
    protected static string $resource = ApplicationForAdmissionResource::class;
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
    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
