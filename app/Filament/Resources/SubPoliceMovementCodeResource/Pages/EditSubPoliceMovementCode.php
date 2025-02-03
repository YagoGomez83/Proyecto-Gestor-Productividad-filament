<?php

namespace App\Filament\Resources\SubPoliceMovementCodeResource\Pages;

use App\Filament\Resources\SubPoliceMovementCodeResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditSubPoliceMovementCode extends EditRecord
{
    protected static string $resource = SubPoliceMovementCodeResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
