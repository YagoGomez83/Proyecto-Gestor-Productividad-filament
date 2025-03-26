<?php

namespace App\Filament\Supervisor\Resources\VictimResource\Pages;

use App\Filament\Supervisor\Resources\VictimResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListVictims extends ListRecords
{
    protected static string $resource = VictimResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
