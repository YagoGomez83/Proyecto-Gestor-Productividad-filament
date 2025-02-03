<?php

namespace App\Filament\Resources\SubPoliceMovementCodeResource\Pages;

use App\Filament\Resources\SubPoliceMovementCodeResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListSubPoliceMovementCodes extends ListRecords
{
    protected static string $resource = SubPoliceMovementCodeResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
