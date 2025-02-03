<?php

namespace App\Services;

use App\Repositories\ServiceRepository;

class ServiceService
{
    private $serviceRepository;
    public function __construct()
    {
        $this->serviceRepository = new ServiceRepository();
    }

    public function getAllServices()
    {
        return $this->serviceRepository->getAllServices();
    }

    public function getServiceById($id)
    {
        return $this->serviceRepository->getServiceById($id);
    }

    public function storeService($request)
    {
        $data = $request->all();
        return $this->serviceRepository->createService($data);
    }

    public function updateService($request, $id)
    {
        $data = $request->all();
        return $this->serviceRepository->updateService($id, $data);
    }

    public function deleteService($id)
    {
        return $this->serviceRepository->deleteService($id);
    }

    public function restoreService($id)
    {
        return $this->serviceRepository->restoreService($id);
    }

    public function getAllDeletedServices()
    {
        return $this->serviceRepository->getAllDeletedServices();
    }

    public function getServiceWithUser($id)
    {
        return $this->serviceRepository->getServiceWithUser($id);
    }

    public function getServiceWithGroup($id)
    {
        return $this->serviceRepository->getServiceWithGroup($id);
    }

    public function getServiceWithCity($id)
    {
        return $this->serviceRepository->getServiceWithCity($id);
    }

    public function getServiceWithInitialPoliceMovementCode($id)
    {
        return $this->serviceRepository->getServiceWithInitialPoliceMovementCode($id);
    }

    public function getServiceWithFinalPoliceMovementCode($id)
    {
        return $this->serviceRepository->getServiceWithFinalPoliceMovementCode($id);
    }
}
