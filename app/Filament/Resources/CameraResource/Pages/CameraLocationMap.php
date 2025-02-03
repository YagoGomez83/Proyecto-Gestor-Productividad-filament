<?php

namespace App\Filament\Resources\CameraResource\Pages;

use App\Filament\Resources\CameraResource;
use Filament\Resources\Pages\Page;

class CameraLocationMap extends Page
{
    protected static string $resource = CameraResource::class;

    protected static string $view = 'filament.resources.camera-resource.pages.camera-location-map';
}
