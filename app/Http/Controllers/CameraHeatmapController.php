<?php

namespace App\Http\Controllers;

use App\Models\Camera;
use App\Models\CameraType;

use Illuminate\Http\Request;
use App\Http\Controllers\BaseHeatmapController;

class CameraHeatmapController extends BaseHeatmapController
{
    public function __construct()
    {
        $this->model = Camera::class;
        $this->view = 'heatmaps.cameras';
        $this->filters = [
            'type_id' => ['field' => 'camera_type_id'],
            'status' => ['field' => 'is_active'],
            // Agrega más filtros según necesidad
        ];
    }
    
    public function __invoke(Request $request)
    {
        $response = parent::__invoke($request);
        
        // Agregar datos específicos para cámaras
        return $response->with([
            'types' => CameraType::all(),
        ]);
    }
}