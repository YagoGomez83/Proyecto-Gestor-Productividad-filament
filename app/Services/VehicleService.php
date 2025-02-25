<?php

namespace App\Services;

use App\Repositories\VehicleRepository;

class VehicleService
{
    protected $vehicleRepository;

    public function __construct(VehicleRepository $vehicleRepository)
    {
        $this->vehicleRepository = $vehicleRepository;
    }

    public function getAllVehicles()
    {
        return $this->vehicleRepository->getAllVehicles();
    }
    public function getVehicleById($vehicleId)
    {
        return $this->vehicleRepository->getVehicleById($vehicleId);
    }

    public function createVehicle($data)
    {
        return $this->vehicleRepository->storeVehicle($data);
    }
    public function updateVehicle($vehicleId, $data)
    {
        return $this->vehicleRepository->updateVehicle($vehicleId, $data);
    }
    public function deleteVehicle($vehicleId)
    {
        return $this->vehicleRepository->deleteVehicle($vehicleId);
    }
    public function restoreVehicle($vehicleId)
    {
        return $this->vehicleRepository->restoreVehicle($vehicleId);
    }
    public function getAllVehiclesWithDeleted()
    {
        return $this->vehicleRepository->getAllVehiclesWithDeleted();
    }

    public function getOnlyDeletedVehicles()
    {
        return $this->vehicleRepository->getOnlyDeletedVehicles();
    }
    public function getVehicleWithReports($vehicleId)
    {
        return $this->vehicleRepository->getVehicleWithReports($vehicleId);
    }
}
