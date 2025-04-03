<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Camera;
use App\Models\Service;
use App\Models\PoliceMovementCode;

class CameraHeatmapController extends Controller
{
    public function index()
    {
        // Obtener datos iniciales para los filtros
        $cameras = Camera::with('location')->get();
        $statuses = ['Preventivo', 'Reactivo']; // Posibles valores de status
        $codes = PoliceMovementCode::select('code', 'id','description')->get();
        
        // Obtener datos iniciales para el mapa de calor
        $heatmapData = $this->getInitialHeatmapData();
        
        return view('camera.heatmap', compact('cameras', 'statuses', 'codes', 'heatmapData'));
    }
    
    protected function getInitialHeatmapData()
    {
        // Obtener servicios con cámaras que tienen ubicación
        $services = Service::with(['camera.location', 'initialPoliceMovementCode'])
            ->has('camera.location')
            ->get();
        
        $heatmapData = [];
        foreach ($services as $service) {
            if ($service->camera && $service->camera->location) {
                $heatmapData[] = [
                    'lat' => $service->camera->location->latitude,
                    'lng' => $service->camera->location->longitude,
                    'intensity' => 1,
                    'camera_id' => $service->camera->id,
                    'status' => $service->status,
                    'code' => $service->initialPoliceMovementCode->code ?? null
                ];
            }
        }
        
        return $heatmapData;
    }
    
    public function getHeatmapData(Request $request)
    {
        // Consulta base para obtener servicios con cámaras que tienen ubicación
        $query = Service::with(['camera.location', 'initialPoliceMovementCode'])
            ->has('camera.location');
            
        // Aplicar filtros
        if ($request->has('cameras') && !empty($request->cameras)) {
            $query->whereIn('camera_id', $request->cameras);
        }
        
        if ($request->has('status') && !empty($request->status)) {
            $query->whereIn('status', $request->status);
        }
        
        if ($request->has('codes') && !empty($request->codes)) {
            $query->whereHas('initialPoliceMovementCode', function($q) use ($request) {
                $q->whereIn('code', $request->codes);
            });
        }
        
        // Obtener servicios filtrados
        $services = $query->get();
        
        $heatmapData = [];
        foreach ($services as $service) {
            if ($service->camera && $service->camera->location) {
                $heatmapData[] = [
                    'lat' => $service->camera->location->latitude,
                    'lng' => $service->camera->location->longitude,
                    'intensity' => 1
                ];
            }
        }
        
        return response()->json($heatmapData);
    }
}