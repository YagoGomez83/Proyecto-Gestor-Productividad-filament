<?php

namespace App\Filament\Supervisor\Resources\PoliceStationResource\Pages;

use App\Filament\Supervisor\Resources\PoliceStationResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListPoliceStations extends ListRecords
{
    protected static string $resource = PoliceStationResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
