<?php

namespace App\Filament\Resources\ApplicationForAdmissionResource\Pages;

use App\Filament\Resources\ApplicationForAdmissionResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListApplicationForAdmissions extends ListRecords
{
    protected static string $resource = ApplicationForAdmissionResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
