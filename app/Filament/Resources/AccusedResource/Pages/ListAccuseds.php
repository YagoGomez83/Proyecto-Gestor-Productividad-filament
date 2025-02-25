<?php

namespace App\Filament\Resources\AccusedResource\Pages;

use App\Filament\Resources\AccusedResource;
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
