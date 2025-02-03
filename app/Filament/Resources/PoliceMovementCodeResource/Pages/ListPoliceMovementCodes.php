<?php

namespace App\Filament\Resources\PoliceMovementCodeResource\Pages;

use App\Filament\Resources\PoliceMovementCodeResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListPoliceMovementCodes extends ListRecords
{
    protected static string $resource = PoliceMovementCodeResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
