<?php

namespace App\Http\Controllers;

use App\Models\Report;
use App\Models\Service;
use Illuminate\Http\Request;
use App\Services\CityService;
use App\Services\CauseService;
use App\Services\CameraService;
use App\Services\ReportService;
use App\Services\VictimService;
use App\Services\AccusedService;
use App\Services\VehicleService;
use App\Services\LocationService;
use App\Models\PoliceMovementCode;
use App\Http\Requests\ReportRequest;
use Illuminate\Support\Facades\Auth;
use App\Services\PoliceStationService;

class ReportController extends Controller
{
    protected $reportService;
    protected $locationService;
    protected $causeService;
    protected $victimService;
    protected $vehicleService;
    protected $accusedService;
    protected $cityService;
    protected $policeStationService;
    protected $cameraService;


    public function __construct(
        ReportService $reportService,
        VehicleService $vehicleService,
        AccusedService $accusedService,
        VictimService $victimService,
        LocationService $locationService,
        CameraService $cameraService,
        CityService $cityService,
        PoliceStationService $policeStationService,
        CauseService $causeService
    ) {
        $this->reportService = $reportService;
        $this->causeService = $causeService;
        $this->locationService = $locationService;
        $this->cameraService = $cameraService;
        $this->victimService = $victimService;
        $this->vehicleService = $vehicleService;
        $this->accusedService = $accusedService;
        $this->cityService = $cityService;
        $this->policeStationService = $policeStationService;
    }


    public function index(Request $request)
    {
        $search = $request->input('search');

        $reports = $this->reportService->searchReports($search, 10);

        return view('reports.index', compact('reports'));
    }


    public function create()
    {
        $vehicles = $this->vehicleService->getAllVehicles();
        $accuseds = $this->accusedService->getAllAccuseds();
        $victims = $this->victimService->getAllVictims();
        $locations = $this->locationService->getAllLocations();
        $cameras = $this->cameraService->getAllCameras();
        $cities = $this->cityService->getAllCities();
        $policeStations = $this->policeStationService->getAll();
        $causes = $this->causeService->getAllCauses();
        return view('reports.create', compact(['vehicles', 'accuseds', 'victims', 'locations', 'cameras', 'cities', 'policeStations', 'causes']));
    }

    public function store(ReportRequest $request)
    {


        // Crear la ubicación primero
        $locationData = $request->only(['address', 'latitude', 'longitude']);
        $location = $this->locationService->createLocation($locationData);

        $reportData = $request->only(['title', 'description', 'report_date', 'report_time', 'police_station_id', 'cause_id']);
        $reportData['location_id'] = $location->id;
        $reportData['user_id'] = Auth::user()->id;
        $report = $this->reportService->createReport($reportData);


        $report->cameras()->sync($request->input('cameras', []));
        $report->victims()->sync($request->input('victims', []));
        $report->vehicles()->sync($request->input('vehicles', []));
        $report->accuseds()->sync($request->input('accuseds', []));

        return redirect()->route('reports.custom')->with('success', 'Report created successfully.');
    }

    public function show($id)
    {
        $report = $this->reportService->getReportById($id);
        return view('reports.show', compact('report'));
    }

    public function edit($id)
    {
        $vehicles = $this->vehicleService->getAllVehicles();
        $accuseds = $this->accusedService->getAllAccuseds();
        $victims = $this->victimService->getAllVictims();
        $locations = $this->locationService->getAllLocations();
        $cameras = $this->cameraService->getAllCameras();
        $cities = $this->cityService->getAllCities();
        $policeStations = $this->policeStationService->getAll();
        $causes = $this->causeService->getAllCauses();
        $report = $this->reportService->getReportById($id);
        return view('reports.edit', compact(['report', 'vehicles', 'accuseds', 'victims', 'locations', 'cameras', 'cities', 'policeStations', 'causes']));
    }

    public function update(ReportRequest $request, $id)
    {
        // Obtener el informe existente
        $report = $this->reportService->getReportById($id);

        // Actualizar la ubicación
        $locationData = $request->only(['address', 'latitude', 'longitude']);
        $this->locationService->updateLocation($report->location_id, $locationData);

        // Actualizar el informe
        $reportData = $request->only(['title', 'description', 'report_date', 'report_time', 'police_station_id', 'cause_id']);
        $this->reportService->updateReport($id, $reportData);

        // Sincronizar relaciones
        $report->cameras()->sync($request->input('cameras', []));
        $report->victims()->sync($request->input('victims', []));
        $report->vehicles()->sync($request->input('vehicles', []));
        $report->accuseds()->sync($request->input('accuseds', []));

        return redirect()->route('reports.custom')->with('success', 'Report updated successfully.');
    }

    public function destroy($id)
    {
        $this->reportService->deleteReport($id);

        return redirect()->route('reports.custom')->with('success', 'Report deleted successfully.');
    }

  // En ReportController.php

  public function showHeatmap()
  {
      // Datos iniciales para reportes
      $initialReportData = Report::with('location')
          ->whereHas('location', function($q) {
              $q->whereNotNull('latitude')
                ->whereNotNull('longitude');
          })
          ->limit(1000)
          ->get()
          ->map(function($report) {
              return [
                  'lat' => (float)$report->location->latitude,
                  'lng' => (float)$report->location->longitude,
                  'intensity' => 1
              ];
          });
  
      // Datos iniciales para servicios
      $initialServiceData = Service::with(['camera.location', 'initialPoliceMovementCode'])
          ->whereHas('camera.location', function($q) {
              $q->whereNotNull('latitude')
                ->whereNotNull('longitude');
          })
          ->limit(1000)
          ->get()
          ->groupBy('camera_id')
          ->map(function($servicesByCamera) {
              $camera = $servicesByCamera->first()->camera;
              return [
                  'lat' => (float)$camera->location->latitude,
                  'lng' => (float)$camera->location->longitude,
                  'intensity' => $servicesByCamera->count(),
                  'type' => $servicesByCamera->first()->initialPoliceMovementCode->code,
                  'camera_id' => $camera->id,
                  'camera_identifier' => $camera->identifier,
                  'count' => $servicesByCamera->count()
              ];
          })
          ->values();
  
      $causes = $this->causeService->getAllCauses();
      $policeStations = $this->policeStationService->getAll();
      $policeMovementCodes = PoliceMovementCode::all(); // Asegúrate de importar el modelo
  
      return view('reports.heatmap', [
          'heatmapData' => $initialReportData,
          'serviceHeatmapData' => $initialServiceData,
          'causes' => $causes,
          'policeStations' => $policeStations,
          'policeMovementCodes' => $policeMovementCodes
      ]);
  }

public function heatmapData(Request $request)
{
    $type = $request->input('type', 'reports'); // 'reports' o 'services'

    if ($type === 'services') {
        return $this->getServiceHeatmapData($request);
    }

    return $this->getReportHeatmapData($request);
}

protected function getReportHeatmapData(Request $request)
{
    $query = Report::with('location')
        ->whereHas('location', function($q) {
            $q->whereNotNull('latitude')
              ->whereNotNull('longitude');
        });

    // Filtros existentes...
    if ($request->has('cause') && $request->cause) {
        $query->where('cause_id', $request->cause);
    }

    if ($request->has('date') && $request->date) {
        $query->whereDate('report_date', $request->date);
    }

    if ($request->has('start_time') && $request->has('end_time')) {
        $query->whereTime('report_time', '>=', $request->start_time)
              ->whereTime('report_time', '<=', $request->end_time);
    }

    $reports = $query->get();

    $heatmapData = $reports->map(function($report) {
        return [
            'lat' => (float)$report->location->latitude,
            'lng' => (float)$report->location->longitude,
            'intensity' => 1
        ];
    });

    return response()->json($heatmapData);
}

protected function getServiceHeatmapData(Request $request)
{
    $query = Service::with(['camera.location', 'initialPoliceMovementCode'])
        ->whereHas('camera.location', function($q) {
            $q->whereNotNull('latitude')
              ->whereNotNull('longitude');
        });

    // Filtro por tipo de movimiento policial (preventivo/reactivo)
    if ($request->has('service_type')) {
        if ($request->service_type === 'preventive') {
            $query->whereHas('initialPoliceMovementCode', function($q) {
                $q->where('code', 'P');
            });
        } elseif ($request->service_type === 'reactive') {
            $query->whereHas('initialPoliceMovementCode', function($q) {
                $q->where('code', 'R');
            });
        }
    }

    // Nuevo filtro por código de movimiento policial específico
    if ($request->has('initial_police_movement_code_id') && $request->initial_police_movement_code_id) {
        $query->where('initial_police_movement_code_id', $request->initial_police_movement_code_id);
    }

    // Filtro por comisaría
    if ($request->has('police_station_id') && $request->police_station_id) {
        $query->whereHas('camera', function($q) use ($request) {
            $q->where('police_station_id', $request->police_station_id);
        });
    }

    // Filtros por fecha y hora
    if ($request->has('date') && $request->date) {
        $query->whereDate('service_date', $request->date);
    }

    if ($request->has('start_time') && $request->has('end_time')) {
        $query->whereTime('service_time', '>=', $request->start_time)
              ->whereTime('service_time', '<=', $request->end_time);
    }

    // Agrupar por cámara y contar servicios
    $services = $query->get()
        ->groupBy('camera_id')
        ->map(function($servicesByCamera) {
            $camera = $servicesByCamera->first()->camera;
            $count = $servicesByCamera->count();
            
            return [
                'lat' => (float)$camera->location->latitude,
                'lng' => (float)$camera->location->longitude,
                'intensity' => $count, // La intensidad ahora refleja el número de servicios
                'type' => $servicesByCamera->first()->initialPoliceMovementCode->code,
                'camera_id' => $camera->id,
                'camera_identifier' => $camera->identifier,
                'count' => $count
            ];
        })
        ->values();

    return response()->json($services);
}
}
