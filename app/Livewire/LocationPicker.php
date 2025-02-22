<?php

namespace App\Livewire;


use Livewire\Component;
use App\Models\Location;



class LocationPicker extends Component
{
    public $latitude;
    public $longitude;
    public $address;

    protected $listeners = ['setLocation'];

    // Escucha el evento 'setLocation' desde el frontend (JavaScript)
    public function setLocation($latitude, $longitude, $address)
    {
        $this->latitude = $latitude;
        $this->longitude = $longitude;
        $this->address = $address;

        // Emitir el evento de actualización al formulario de Filament
        $this->emit('locationUpdated', [
            'latitude' => $latitude,
            'longitude' => $longitude,
            'address' => $address,
        ]);
    }

    public function render()
    {
        return view('livewire.location-picker');
    }
}
