<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\CityService;
use App\Services\CauseService;
use App\Services\CameraService;
use App\Services\ReportService;
use App\Services\VictimService;
use App\Services\AccusedService;
use App\Services\VehicleService;
use App\Services\LocationService;
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
}
