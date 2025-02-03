<?php

namespace App\Repositories;

use App\Models\Service;



class ServiceRepository
{

    public function getAllServices()
    {
        return Service::all();
    }

    public function getServiceById($id)
    {
        return Service::findOrFail($id);
    }

    public function createService($data)
    {
        return Service::create($data);
    }

    public function updateService($id, $data)
    {
        $service = Service::findOrFail($id);
        $service->update($data);
        return $service;
    }

    public function deleteService($id)
    {
        $service = Service::findOrFail($id);
        $service->delete();
    }

    public function restoreService($id)
    {
        $service = Service::withTrashed()->findOrFail($id);
        $service->restore();
    }

    public function getAllDeletedServices()
    {
        return Service::onlyTrashed()->get();
    }

    public function getServiceWithUser($id)
    {
        return Service::with('user')->findOrFail($id);
    }

    public function getServiceWithGroup($id)
    {
        return Service::with('group')->findOrFail($id);
    }

    public function getServiceWithCity($id)
    {
        return Service::with('city')->findOrFail($id);
    }

    public function getServiceWithInitialPoliceMovementCode($id)
    {
        return Service::with('initialPoliceMovementCode')->findOrFail($id);
    }

    public function getServiceWithFinalPoliceMovementCode($id)
    {
        return Service::with('finalPoliceMovementCode')->findOrFail($id);
    }
}
