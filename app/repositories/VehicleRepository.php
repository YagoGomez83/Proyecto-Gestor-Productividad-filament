<?php

namespace App\Repositories;

use App\Models\Vehicle;

class VehicleRepository
{
    public function getAllVehicles()
    {
        return Vehicle::all();
    }

    public function getVehicleById($id)
    {
        return Vehicle::findOrFail($id);
    }

    public function storeVehicle($data)
    {
        return Vehicle::create($data);
    }

    public function updateVehicle($id, $data)
    {
        $vehicle = Vehicle::find($id);
        $vehicle->update($data);
        return $vehicle;
    }

    public function deleteVehicle($id)
    {
        return Vehicle::findOrFail($id)->delete();
    }

    public function restoreVehicle($id)
    {
        return Vehicle::withTrashed()->findOrFail($id)->restore();
    }

    public function getAllVehiclesWithDeleted()
    {
        return Vehicle::withTrashed()->get();
    }

    public function getOnlyDeletedVehicles()
    {
        return Vehicle::onlyTrashed()->get();
    }

    public function getVehicleWithReports($id)
    {
        return Vehicle::with('reports')->find($id);
    }
}
