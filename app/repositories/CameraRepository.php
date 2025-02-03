<?php

namespace App\Repositories;

use App\Models\Camera;

class CameraRepository
{
    public function getAllCameras()
    {
        return Camera::all();
    }

    public function getCameraById($id)
    {
        return Camera::findOrFail($id);
    }

    public function storeCamera($data)
    {
        return Camera::create($data);
    }

    public function updateCamera($id, $data)
    {
        $camera = Camera::find($id);
        $camera->update($data);
        return $camera;
    }
    public function deleteCamera($id)
    {
        return Camera::findOrFail($id)->delete();
    }

    public function restoreCamera($id)
    {
        return Camera::withTrashed()->findOrFail($id)->restore();
    }

    public function getAllCamerasWithDeleted()
    {
        return Camera::withTrashed()->get();
    }

    public function getOnlyDeletedCameras()
    {
        return Camera::onlyTrashed()->get();
    }

    public function getCameraWithPoliceStation($id)
    {
        return Camera::with('policeStation')->find($id);
    }

    public function getCameraWithLocation($id)
    {
        return Camera::with('location')->find($id);
    }

    public function getCameraWithPoliceStationAndLocation($id)
    {
        return Camera::with(['policeStation', 'location'])->find($id);
    }

    public function getCameraWithCity($id)
    {
        return Camera::with('city')->find($id);
    }

    public function getCameraWithPoliceStationAndCity($id)
    {
        return Camera::with(['policeStation', 'city'])->find($id);
    }
}
