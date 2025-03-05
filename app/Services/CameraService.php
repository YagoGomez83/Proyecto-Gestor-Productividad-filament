<?php

namespace App\Services;

use App\Repositories\CameraRepository;

class CameraService
{
    protected $cameraRepository;

    public function __construct(CameraRepository $cameraRepository)
    {
        $this->cameraRepository = $cameraRepository;
    }

    public function getAllCameras()
    {
        return $this->cameraRepository->getAllCameras();
    }

    public function getCameraById($cameraId)
    {
        return $this->cameraRepository->getCameraById($cameraId);
    }

    public function createCamera($data)
    {
        return $this->cameraRepository->storeCamera($data);
    }

    public function updateCamera($cameraId, $data)
    {
        return $this->cameraRepository->updateCamera($cameraId, $data);
    }

    public function deleteCamera($cameraId)
    {
        return $this->cameraRepository->deleteCamera($cameraId);
    }

    public function getAllDeletedCameras()
    {
        return $this->cameraRepository->getOnlyDeletedCameras();
    }

    public function restoreCamera($cameraId)
    {
        return $this->cameraRepository->restoreCamera($cameraId);
    }

    public function getCameraWithPoliceStation($cameraId)
    {
        return $this->cameraRepository->getCameraWithPoliceStation($cameraId);
    }

    public function getCameraWithLocation($cameraId)
    {
        return $this->cameraRepository->getCameraWithLocation($cameraId);
    }

    public function getCameraWithPoliceStationAndLocation($cameraId)
    {
        return $this->cameraRepository->getCameraWithPoliceStationAndLocation($cameraId);
    }

    public function searchCameras($search, $perPage = 10)
    {
        return $this->cameraRepository->searchCameras($search, $perPage);
    }
}
