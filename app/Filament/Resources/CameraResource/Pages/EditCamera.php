<?php

namespace App\Filament\Resources\CameraResource\Pages;

use Filament\Actions;
use App\Models\Location;
use Filament\Notifications\Notification;
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
        if (!empty($data['location_id'])) {
            $location = Location::find($data['location_id']);

            if ($location) {
                $data['latitude'] = $location->latitude;
                $data['longitude'] = $location->longitude;
                $data['address'] = $location->address;
            }
        }

        return $data;
    }

    protected function afterFill(): void
    {
        if ($this->record->location) {
            $this->dispatch(
                'setLocation',
                (float) $this->record->location->latitude,
                (float) $this->record->location->longitude,
                $this->record->location->address
            );
        }
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

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }

    protected function afterCreate(): void
    {
        Notification::make()
            ->title('Cámara actualizada')
            ->success()
            ->body('La cámara se ha actualizado correctamente.')
            ->send();
    }
}
