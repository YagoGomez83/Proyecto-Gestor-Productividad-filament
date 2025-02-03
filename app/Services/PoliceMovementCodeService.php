<?php

namespace App\Services;

use App\Repositories\PoliceMovementCodeRepository;

class PoliceMovementCodeService
{
    protected $policeMovementCodeRepository;
    public function __construct(PoliceMovementCodeRepository $policeMovementCodeRepository)
    {
        $this->policeMovementCodeRepository = $policeMovementCodeRepository;
    }
    public function getAll()
    {
        return $this->policeMovementCodeRepository->getAll();
    }
    public function getById($id)
    {
        return $this->policeMovementCodeRepository->getById($id);
    }
    public function create($data)
    {
        return $this->policeMovementCodeRepository->create($data);
    }
    public function update($data, $id)
    {
        return $this->policeMovementCodeRepository->update($data, $id);
    }
    public function delete($id)
    {
        return $this->policeMovementCodeRepository->delete($id);
    }

    public function restore($id)
    {
        return $this->policeMovementCodeRepository->restore($id);
    }

    public function getDeletePoliceMovementCodes()
    {
        return $this->policeMovementCodeRepository->getDeletePoliceMovementCodes();
    }

    public function getPoliceMovementCodeWithSubPoliceMovementCodes($id)
    {
        return $this->policeMovementCodeRepository->getPoliceMovementCodeWithSubPoliceMovementCodes($id);
    }

    public function getPoliceMovementCodeWithServices($id)
    {
        return $this->policeMovementCodeRepository->getPoliceMovementCodeWithServices($id);
    }
}
