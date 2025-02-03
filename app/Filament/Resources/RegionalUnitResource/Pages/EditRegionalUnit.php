<?php

namespace App\Filament\Resources\RegionalUnitResource\Pages;

use App\Filament\Resources\RegionalUnitResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditRegionalUnit extends EditRecord
{
    protected static string $resource = RegionalUnitResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
