<?php

namespace App\Filament\Resources\CameraResource\Pages;

use Livewire\Component;
use App\Models\Location;
use App\Filament\Resources\CameraResource;
use Filament\Resources\Pages\CreateRecord;

class CreateCamera extends CreateRecord
{
    protected static string $resource = CameraResource::class;

    public $latitude;
    public $longitude;
    public $address;

    protected $listeners = ['setLocation'];

    // Método para capturar la ubicación
    public function setLocation($latitude, $longitude, $address)
    {
        // dd($latitude, $longitude, $address);
        $this->latitude = $latitude;
        $this->longitude = $longitude;
        $this->address = $address;
    }

    protected function mutateFormDataBeforeCreate(array $data): array

    {
        // dd($this->latitude, $this->longitude, $this->address);
        if ($this->latitude && $this->longitude && $this->address) {
            // Crear la ubicación
            $location = Location::create([
                'address' => $this->address,
                'latitude' => $this->latitude,
                'longitude' => $this->longitude,
            ]);

            // Asignar la ubicación a la cámara
            $data['location_id'] = $location->id;
        } else {
            throw new \Exception('Ubicación no establecida correctamente.');
        }

        return $data;
    }
}
