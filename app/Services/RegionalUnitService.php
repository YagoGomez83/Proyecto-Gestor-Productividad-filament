<?php

namespace App\Services;

use App\Repositories\RegionalUnitRepository;

class RegionalUnitService
{
    protected $regionalUnitRepository;

    public function __construct(RegionalUnitRepository $regionalUnitRepository)
    {
        $this->regionalUnitRepository = $regionalUnitRepository;
    }

    public function getAllRegionalUnits()
    {
        return $this->regionalUnitRepository->getAllRegionalUnits();
    }

    public function getRegionalUnitById($id)
    {
        return $this->regionalUnitRepository->getRegionalUnitById($id);
    }

    public function createRegionalUnit($data)
    {
        return $this->regionalUnitRepository->createRegionalUnit($data);
    }

    public function updateRegionalUnit($id, $data)
    {
        return $this->regionalUnitRepository->updateRegionalUnit($id, $data);
    }

    public function deleteRegionalUnit($id)
    {
        return $this->regionalUnitRepository->deleteRegionalUnit($id);
    }

    public function restoreRegionalUnit($id)
    {
        return $this->regionalUnitRepository->restoreRegionalUnit($id);
    }

    public function getAllDeletedRegionalUnits()
    {
        return $this->regionalUnitRepository->getAllDeletedRegionalUnits();
    }

    public function getRegionalUnitWithCenter($id)
    {
        return $this->regionalUnitRepository->getRegionalUnitWithCenter($id);
    }

    public function getRegionalUnitWithcities($id)
    {
        return $this->regionalUnitRepository->getRegionalUnitWithcities($id);
    }
}
