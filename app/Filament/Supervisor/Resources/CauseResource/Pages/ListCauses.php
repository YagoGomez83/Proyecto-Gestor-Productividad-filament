<?php

namespace App\Filament\Supervisor\Resources\CauseResource\Pages;

use App\Filament\Supervisor\Resources\CauseResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListCauses extends ListRecords
{
    protected static string $resource = CauseResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
