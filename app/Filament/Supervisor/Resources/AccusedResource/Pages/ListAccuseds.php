<?php

namespace App\Filament\Supervisor\Resources\AccusedResource\Pages;

use App\Filament\Supervisor\Resources\AccusedResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListAccuseds extends ListRecords
{
    protected static string $resource = AccusedResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
