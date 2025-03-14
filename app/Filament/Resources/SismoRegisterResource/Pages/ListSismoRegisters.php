<?php

namespace App\Filament\Resources\SismoRegisterResource\Pages;

use App\Filament\Resources\SismoRegisterResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListSismoRegisters extends ListRecords
{
    protected static string $resource = SismoRegisterResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
