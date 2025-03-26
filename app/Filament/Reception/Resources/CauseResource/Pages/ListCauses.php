<?php

namespace App\Filament\Reception\Resources\CauseResource\Pages;

use App\Filament\Reception\Resources\CauseResource;
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
