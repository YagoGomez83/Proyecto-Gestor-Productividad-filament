<?php

namespace App\Filament\Reception\Resources\SismoRegisterResource\Pages;

use App\Filament\Reception\Resources\SismoRegisterResource;
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
