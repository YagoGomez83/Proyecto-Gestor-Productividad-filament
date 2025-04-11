<?php

namespace App\Http\Controllers;

use App\Models\Cause;
use App\Models\Report;
use Illuminate\Http\Request;
use App\Models\PoliceStation;


class ReportHeatmapController extends BaseHeatmapController
{
    public function __construct()
    {
        $this->model = Report::class;
        $this->view = 'heatmaps.reports';
        $this->filters = [
            'cause_id' => ['field' => 'cause_id'],
            'dependence_id' => ['field' => 'police_station_id'],
            // Puedes agregar más filtros según necesidad
        ];
    }
    
    public function __invoke(Request $request)
    {
        $response = parent::__invoke($request);
        
        // Agregar datos específicos para reportes
        return $response->with([
            'causes' => Cause::all(),
            'dependencies' => PoliceStation::all(),
        ]);
    }
}