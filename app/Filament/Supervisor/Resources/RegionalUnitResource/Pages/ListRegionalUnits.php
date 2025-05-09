<?php

namespace App\Filament\Supervisor\Resources\RegionalUnitResource\Pages;

use App\Filament\Supervisor\Resources\RegionalUnitResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListRegionalUnits extends ListRecords
{
    protected static string $resource = RegionalUnitResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
