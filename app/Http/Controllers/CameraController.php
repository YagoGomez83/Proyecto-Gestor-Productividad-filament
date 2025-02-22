<?php

namespace App\Http\Controllers;

use App\Http\Requests\CameraRequest;
use Illuminate\Http\Request;
use App\Services\CityService;
use App\Services\CameraService;
use App\Services\LocationService;
use App\Services\PoliceStationService;

class CameraController extends Controller
{
    protected $cameraService;
    protected $policeStationService;
    protected $cityService;
    protected $locationService;

    public function __construct(CameraService $cameraService, PoliceStationService $policeStationService, CityService $cityService, LocationService $locationService)
    {
        $this->cameraService = $cameraService;
        $this->policeStationService = $policeStationService;
        $this->cityService = $cityService;
        $this->locationService = $locationService;
    }

    //
    public function index(Request $request)
    {
        $search = $request->input('search');


        $cameras = $this->cameraService->searchCameras($search);

        return view('camera.index', compact('cameras'));
    }
    public function create()
    {
        $policeStations = $this->policeStationService->getAll();
        $cities = $this->cityService->getAllCities();
        return view('camera.create', compact('policeStations', 'cities'));
    }

    public function show($id)
    {
        $camera = $this->cameraService->getCameraById($id);

        if (!$camera) {
            return redirect()->route('cameras.index')->with('error', 'Cámara no encontrada');
        }

        return view('camera.show', compact('camera'));
    }


    public function store(CameraRequest $request)
    {


        // Crear la ubicación primero
        $locationData = $request->only(['address', 'latitude', 'longitude']);
        $location = $this->locationService->createLocation($locationData);

        // Crear la cámara con la ubicación asignada
        $cameraData = $request->only(['identifier', 'city_id', 'police_station_id']);
        $cameraData['location_id'] = $location->id;

        $this->cameraService->createCamera($cameraData);

        return redirect()->route('cameras.custom')->with('success', 'Cámara creada exitosamente');
    }

    public function edit($id)
    {
        $camera = $this->cameraService->getCameraById($id);
        $policeStations = $this->policeStationService->getAll();
        $cities = $this->cityService->getAllCities();
        return view('camera.edit', compact('camera', 'policeStations', 'cities'));
    }

    public function update(CameraRequest $request, $id)
    {
        $camera = $this->cameraService->getCameraById($id);

        // Actualizar ubicación
        $locationData = $request->only(['address', 'latitude', 'longitude']);
        $this->locationService->updateLocation($camera->location->id, $locationData);

        // Actualizar cámara
        $cameraData = $request->only(['identifier', 'city_id', 'police_station_id']);
        $this->cameraService->updateCamera($id, $cameraData);

        return redirect()->route('cameras.custom')->with('success', 'Cámara actualizada exitosamente');
    }
    public function destroy($id)
    {
        $this->cameraService->deleteCamera($id);
        return redirect()->route('cameras.custom')->with('success', 'Cámara eliminada exitosamente');
    }

    public function deteledCameras()
    {
        $cameras = $this->cameraService->getAllDeletedCameras();
        return view('camera.deleted', compact('cameras'));
    }

    public function restoreCamera($id)
    {
        $this->cameraService->restoreCamera($id);
        return redirect()->route('cameras.deleted')->with('success', 'Cámara restaurada exitosamente');
    }
}
