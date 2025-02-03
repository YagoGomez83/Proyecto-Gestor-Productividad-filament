<?php

namespace App\Services;

use App\Repositories\SubPoliceMovementCodeRepository;

class SubPoliceMovementCodeService
{
    protected $subPoliceMovementCodeRepository;
    public function __construct(SubPoliceMovementCodeRepository $subPoliceMovementCodeRepository)
    {
        $this->subPoliceMovementCodeRepository = $subPoliceMovementCodeRepository;
    }
    public function getAll()
    {
        return $this->subPoliceMovementCodeRepository->getAll();
    }
    public function getById($id)
    {
        return $this->subPoliceMovementCodeRepository->getById($id);
    }
    public function create($data)
    {
        return $this->subPoliceMovementCodeRepository->create($data);
    }
    public function update($data, $id)
    {
        return $this->subPoliceMovementCodeRepository->update($data, $id);
    }
    public function delete($id)
    {
        return $this->subPoliceMovementCodeRepository->delete($id);
    }

    public function restore($id)
    {
        return $this->subPoliceMovementCodeRepository->restore($id);
    }
    public function getSubPoliceMovementCodeWithPoliceMovementCode($id)
    {
        return $this->subPoliceMovementCodeRepository->getSubPoliceMovementCodeWithPoliceMovementCode($id);
    }
}
