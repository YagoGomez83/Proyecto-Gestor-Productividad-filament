<?php

namespace App\Livewire;

use Livewire\Component;

class LocationPicker extends Component
{
    public $latitude = -33.2975;
    public $longitude = -66.3356;
    public $address = 'Ubicación no establecida';

    protected $listeners = ['setLocation'];

    public function setLocation($latitude, $longitude, $address)
    {
        $this->latitude = $latitude;
        $this->longitude = $longitude;
        $this->address = $address;
    }

    public function render()
    {
        return view('livewire.location-picker');
    }
}
