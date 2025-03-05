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

    public function searchCameras($search, $perPage = 10)
    {
        return Camera::with(['city', 'policeStation', 'location'])
            ->when($search, function ($query) use ($search) {
                $query->whereRaw("LOWER(identifier) LIKE LOWER(?)", ["%$search%"])
                    ->orWhereHas('city', function ($q) use ($search) {
                        $q->whereRaw("LOWER(name) LIKE LOWER(?)", ["%$search%"]);
                    })
                    ->orWhereHas('location', function ($q) use ($search) {
                        $q->whereRaw("LOWER(address) LIKE LOWER(?)", ["%$search%"]); // Busca en dirección de ubicación
                    })
                    ->orWhereHas('policeStation', function ($q) use ($search) {
                        $q->whereRaw("LOWER(name) LIKE LOWER(?)", ["%$search%"]); // Busca en nombre de la comisaría
                    });
            })
            ->paginate($perPage);
    }
}
