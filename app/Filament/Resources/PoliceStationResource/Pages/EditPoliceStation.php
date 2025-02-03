<?php

namespace App\Filament\Resources\PoliceStationResource\Pages;

use App\Filament\Resources\PoliceStationResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditPoliceStation extends EditRecord
{
    protected static string $resource = PoliceStationResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
