<?php

namespace App\Filament\Reception\Resources\PoliceStationResource\Pages;

use App\Filament\Reception\Resources\PoliceStationResource;
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
