<?php

namespace App\Filament\Operator\Resources\WorkSessionResource\Pages;

use App\Filament\Operator\Resources\WorkSessionResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditWorkSession extends EditRecord
{
    protected static string $resource = WorkSessionResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
