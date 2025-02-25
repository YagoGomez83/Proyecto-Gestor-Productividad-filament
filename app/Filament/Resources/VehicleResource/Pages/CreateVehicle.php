<?php

namespace App\Filament\Resources\VehicleResource\Pages;

use Filament\Actions;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\CreateRecord;
use App\Filament\Resources\VehicleResource;

class CreateVehicle extends CreateRecord
{
    protected static string $resource = VehicleResource::class;

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
    protected function afterCreate(): void
    {
        Notification::make()
            ->title('Vehiculo creado')
            ->success()
            ->body('El Vehículo se ha creado correctamente.')
            ->send();
    }
}
