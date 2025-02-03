<?php

namespace App\Livewire;


use Livewire\Component;
use App\Models\Location;

class LocationPicker extends Component
{
    public $address;
    public $latitude;
    public $longitude;

    protected $rules = [
        'address' => 'required|string',
        'latitude' => 'required|numeric',
        'longitude' => 'required|numeric',
    ];

    public function save()
    {
        $this->validate();

        $location = Location::create([
            'address' => $this->address,
            'latitude' => $this->latitude,
            'longitude' => $this->longitude,
        ]);

        $this->emit('locationCreated', $location->id);
    }

    public function render()
    {
        return view('livewire.location-picker');
    }
}
