<?php

namespace App\Filament\Resources\CameraResource\Pages;

use App\Models\Location;
use Illuminate\Support\Facades\Log;
use Filament\Notifications\Notification;
use App\Filament\Resources\CameraResource;
use Filament\Resources\Pages\CreateRecord;

class CreateCamera extends CreateRecord
{
    protected static string $resource = CameraResource::class;

    // public $latitude;
    // public $longitude;
    // public $address;

    // protected $listeners = ['setLocation'];

    // public function setLocation($latitude, $longitude, $address)
    // {
    //     Log::info("📡 Evento setLocation recibido en backend", [
    //         'latitude' => $latitude,
    //         'longitude' => $longitude,
    //         'address' => $address
    //     ]);

    //     $this->latitude = $latitude;
    //     $this->longitude = $longitude;
    //     $this->address = $address;
    // }

    // protected function mutateFormDataBeforeCreate(array $data): array
    // {
    //     if ($this->latitude && $this->longitude && $this->address) {
    //         $location = Location::create([
    //             'address' => $this->address,
    //             'latitude' => $this->latitude,
    //             'longitude' => $this->longitude,
    //         ]);

    //         $data['location_id'] = $location->id;

    //         Log::info("📍 Ubicación creada para cámara", [
    //             'location_id' => $location->id,
    //             'latitude' => $this->latitude,
    //             'longitude' => $this->longitude,
    //             'address' => $this->address
    //         ]);
    //     } else {
    //         throw new \Exception('Ubicación no establecida correctamente.');
    //     }

    //     return $data;
    // }

    // protected function getRedirectUrl(): string
    // {
    //     return $this->getResource()::getUrl('index');
    // }

    // protected function afterCreate(): void
    // {
    //     Notification::make()
    //         ->title('Cámara creada')
    //         ->success()
    //         ->body('La cámara se ha creado correctamente.')
    //         ->send();
    // }
}
