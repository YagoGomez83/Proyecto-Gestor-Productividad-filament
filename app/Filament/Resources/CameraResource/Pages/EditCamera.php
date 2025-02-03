<?php

namespace App\Filament\Resources\CameraResource\Pages;

use Filament\Actions;
use App\Models\Location;
use Filament\Resources\Pages\EditRecord;
use App\Filament\Resources\CameraResource;

class EditCamera extends EditRecord
{
    protected static string $resource = CameraResource::class;
    public $latitude;
    public $longitude;
    public $address;

    protected $listeners = ['setLocation'];

    public function setLocation($latitude, $longitude, $address)
    {
        $this->latitude = $latitude;
        $this->longitude = $longitude;
        $this->address = $address;
    }

    protected function mutateFormDataBeforeFill(array $data): array
    {
        if (isset($data['location_id'])) {
            $location = Location::find($data['location_id']);

            if ($location) {
                $this->latitude = $location->latitude;
                $this->longitude = $location->longitude;
                $this->address = $location->address;
            }
        }

        return $data;
    }
    protected function mutateFormDataBeforeSave(array $data): array
    {
        if ($this->latitude && $this->longitude && $this->address) {
            $location = Location::updateOrCreate(
                ['id' => $data['location_id'] ?? null],
                [
                    'address' => $this->address,
                    'latitude' => $this->latitude,
                    'longitude' => $this->longitude,
                ]
            );

            $data['location_id'] = $location->id;
        }

        return $data;
    }

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
