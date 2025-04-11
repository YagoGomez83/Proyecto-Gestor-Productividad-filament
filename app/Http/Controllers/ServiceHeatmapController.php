<?php
namespace App\Http\Controllers;

use App\Models\City;
use App\Models\Group;
use Illuminate\Http\Request;
use App\Services\HeatmapService;
use App\Models\PoliceMovementCode;

class ServiceHeatmapController extends Controller
{
    protected HeatmapService $heatmapService;

    public function __construct(HeatmapService $heatmapService)
    {
        $this->heatmapService = $heatmapService;
    }

    public function index(Request $request)
{
    $filters = $request->only([
        'city_id', 'group_id', 'start_date', 'end_date', 'start_time', 'end_time', 'initial_code_id','status'
    ]);

    $cities = City::all();
    $groups = Group::all();
    $initialCodes = PoliceMovementCode::all();

    $heatmapData = $this->heatmapService->generateServiceHeatmap($filters);

    return view('heatmap.services', compact('filters', 'cities', 'groups', 'heatmapData', 'initialCodes'));
}

    public function getHeatmapData(Request $request)
    {
        $filters = $request->only([
            'city_id', 'group_id', 'start_date', 'end_date', 'start_time', 'end_time', 'initial_code_id', 'status'
        ]);
        
        

        $heatData = $this->heatmapService->generateServiceHeatmap($filters);

        return response()->json($heatData);
    }
}
