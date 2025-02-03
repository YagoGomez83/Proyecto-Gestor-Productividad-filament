<?php

namespace App\Services;

use App\Repositories\PoliceStationRepository;

class PoliceStationService
{
    protected $policeStationRepository;

    public function __construct(PoliceStationRepository $policeStationRepository)
    {
        $this->policeStationRepository = $policeStationRepository;
    }

    public function getAll()
    {
        return $this->policeStationRepository->getAll();
    }

    public function getById($id)
    {
        return $this->policeStationRepository->getById($id);
    }

    public function create($data)
    {
        return $this->policeStationRepository->create($data);
    }

    public function update($data, $id)
    {

        return $this->policeStationRepository->update($data, $id);
    }

    public function delete($id)
    {
        return $this->policeStationRepository->delete($id);
    }

    public function restore($id)
    {
        return $this->policeStationRepository->restore($id);
    }

    public function getOnlyDeleted()
    {
        return $this->policeStationRepository->getOnlyDeleted();
    }

    public function getPoliceStationWithCity($id)
    {
        return $this->policeStationRepository->getPoliceStationWithCity($id);
    }

    public function getPoliceStationWithCameras($id)
    {
        return $this->policeStationRepository->getPoliceStationWithCameras($id);
    }
}
