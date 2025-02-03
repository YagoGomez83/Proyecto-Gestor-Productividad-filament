<?php

namespace App\Services;

use App\Repositories\CenterRepository;

class CenterService
{
    protected $centerRepository;

    public function __construct(CenterRepository $centerRepository)
    {
        $this->centerRepository = $centerRepository;
    }

    public function getAllCenters()
    {
        return $this->centerRepository->getAllCenters();
    }

    public function getCenterById($centerId)
    {
        return $this->centerRepository->getCenterById($centerId);
    }

    public function createCenter($data)
    {
        return $this->centerRepository->storeCenter($data);
    }

    public function updateCenter($centerId, $data)
    {
        return $this->centerRepository->updateCenter($centerId, $data);
    }

    public function deleteCenter($centerId)
    {
        return $this->centerRepository->deleteCenter($centerId);
    }

    public function restoreCenter($centerId)
    {
        return $this->centerRepository->restoreCenter($centerId);
    }

    public function getCenterWithGroups($centerId)
    {
        return $this->centerRepository->getCenterWithGroups($centerId);
    }

    public function getCenterWithRegionalUnits($centerId)
    {
        return $this->centerRepository->getCenterWithRegionalUnits($centerId);
    }

    public function getCenterWithServices($centerId)
    {
        return $this->centerRepository->getCenterWithServices($centerId);
    }

    public function getOnlyDeletedCenters()
    {
        return $this->centerRepository->getOnlyDeletedCenters();
    }
}
