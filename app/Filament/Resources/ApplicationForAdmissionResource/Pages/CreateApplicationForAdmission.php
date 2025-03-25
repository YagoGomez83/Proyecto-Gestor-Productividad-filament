<?php

namespace App\Filament\Resources\ApplicationForAdmissionResource\Pages;

use Filament\Actions;
use Illuminate\Support\Facades\Auth;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\CreateRecord;
use App\Filament\Resources\ApplicationForAdmissionResource;

class CreateApplicationForAdmission extends CreateRecord
{
    protected static string $resource = ApplicationForAdmissionResource::class;
    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $user = Auth::user();
        $data['user_id'] = $user->id;
        return $data;
    }
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
