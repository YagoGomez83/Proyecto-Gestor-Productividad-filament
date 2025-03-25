<?php

namespace App\Filament\Supervisor\Resources\ReportResource\Pages;

use Filament\Actions;
use Filament\Actions\Action;
use Filament\Resources\Pages\ListRecords;
use App\Filament\Supervisor\Resources\ReportResource;

class ListReports extends ListRecords
{
    protected static string $resource = ReportResource::class;

    protected function getHeaderActions(): array
    {
        return [
            // Actions\CreateAction::make(),
            Action::make('index')
                ->label('Ver reportes')
                ->url(route('reports.custom'), true) // Ahora apunta a la ruta personalizada
                ->icon('heroicon-o-eye'),

        ];
    }
}
