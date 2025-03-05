<?php

namespace App\Filament\Operator\Resources\WorkSessionResource\Pages;

use App\Filament\Operator\Resources\WorkSessionResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Support\Facades\Auth;

class CreateWorkSession extends CreateRecord
{
    protected static string $resource = WorkSessionResource::class;
    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $user = Auth::user();
        $data['user_id'] = $user->id;
        $data['group_id'] = $user->group_id;
        return $data;
    }
}
