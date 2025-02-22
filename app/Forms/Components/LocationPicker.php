<?php

namespace App\Forms\Components;

use Filament\Forms\Components\Field;

class LocationPicker extends Field
{
    protected string $view = 'forms.components.location-picker';

    protected function setUp(): void
    {
        parent::setUp();

        $this->afterStateHydrated(function () {
            $this->state([
                'latitude' => $this->state('latitude') ?? config('app.default_latitude'),
                'longitude' => $this->state('longitude') ?? config('app.default_longitude'),
            ]);
        });

        $this->dehydrateStateUsing(function ($state) {
            return [
                'lat' => $state['latitude'] ?? null,
                'lng' => $state['longitude'] ?? null,
            ];
        });
    }
}
