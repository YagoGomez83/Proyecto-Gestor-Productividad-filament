<?php

namespace App\Http\Controllers;

use App\Models\City;
use App\Models\Cause;
use Illuminate\Http\Request;
use App\Models\PoliceStation;
use App\Services\HeatmapService;
use App\View\Components\Heatmap;

class HeatmapController extends Controller
{
    protected HeatmapService $heatmapService;

    public function __construct(HeatmapService $heatmapService)
    {
        $this->heatmapService = $heatmapService;
    }

    public function index(Request $request, HeatmapService $service)
    {
        $filters = $request->only([
            'cause_id',
            'police_station_id',
            'city_id',
            'start_date',
            'end_date',
            'start_time',
            'end_time'
        ]);
    
        $cities = City::all();
        $policeStations = !empty($filters['city_id'])
        ? PoliceStation::where('city_id', $filters['city_id'])->get()
        : PoliceStation::all();
        $causes = Cause::all();
    
        $heatmapData = $service->generateHeatmapData($filters);
    
        return view('heatmap.index', compact(
            'filters', 'cities', 'policeStations', 'causes', 'heatmapData'
        ));
    }
    
    

    public function getHeatmapData(Request $request)
    {
        $filters = $request->only([
            'cause_id',
            'police_station_id',
            'city_id',
            'start_date',
            'end_date',
            'start_time',
            'end_time'
        ]);

        $heatData = $this->heatmapService->generateHeatmapData($filters);

        // Añadir URLs para la respuesta JSON si es necesario
        $heatData = array_map(function($point) {
            if (isset($point['report_id'])) {
                $point['show_url'] = route('report.show', ['id' => $point['report_id']]);
            }
            return $point;
        }, $heatData);

        return response()->json($heatData);
    }
}