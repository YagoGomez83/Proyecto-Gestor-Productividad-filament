<?php

namespace App\Filament\Resources\SolicitudeTypeResource\Pages;

use App\Filament\Resources\SolicitudeTypeResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListSolicitudeTypes extends ListRecords
{
    protected static string $resource = SolicitudeTypeResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
