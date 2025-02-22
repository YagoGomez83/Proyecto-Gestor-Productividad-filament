<?php

namespace App\Services;

use App\Repositories\LocationRepository;

class LocationService
{
    protected $locationRepository;

    public function __construct(LocationRepository $locationRepository)
    {
        $this->locationRepository = $locationRepository;
    }

    public function getAllLocations()
    {
        return $this->locationRepository->getAllLocations();
    }

    public function getLocationById($locationId)
    {
        return $this->locationRepository->getLocationById($locationId);
    }

    public function createLocation($data)
    {
        return $this->locationRepository->createLocation($data);
    }

    public function updateLocation($locationId, $data)
    {
        return $this->locationRepository->updateLocation($locationId, $data);
    }

    public function deleteLocation($locationId)
    {
        return $this->locationRepository->deleteLocation($locationId);
    }

    public function restoreLocation($locationId)
    {
        return $this->locationRepository->restoreLocation($locationId);
    }

    public function getAllLocationsWithDeleted()
    {
        return $this->locationRepository->getAllLocationsWithDeleted();
    }

    public function getOnlyDeletedLocations()
    {
        return $this->locationRepository->getOnlyDeletedLocations();
    }
}
