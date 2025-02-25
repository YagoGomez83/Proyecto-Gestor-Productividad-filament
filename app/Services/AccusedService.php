<?php

namespace App\Services;

use App\Repositories\AccusedRepository;

class AccusedService
{
    protected $accusedRepository;

    public function __construct(AccusedRepository $accusedRepository)
    {
        $this->accusedRepository = $accusedRepository;
    }

    public function getAllAccuseds()
    {
        return $this->accusedRepository->getAllAccuseds();
    }
    public function getAccusedById($accusedId)
    {
        return $this->accusedRepository->getAccusedById($accusedId);
    }

    public function createAccused($data)
    {
        return $this->accusedRepository->storeAccused($data);
    }
    public function updateAccused($accusedId, $data)
    {
        return $this->accusedRepository->updateAccused($accusedId, $data);
    }

    public function deleteAccused($accusedId)
    {
        return $this->accusedRepository->deleteAccused($accusedId);
    }

    public function restoreAccused($accusedId)
    {
        return $this->accusedRepository->restoreAccused($accusedId);
    }

    public function getAllAccusedsWithDeleted()
    {
        return $this->accusedRepository->getAllAccusedsWithDeleted();
    }

    public function getOnlyDeletedAccuseds()
    {
        return $this->accusedRepository->getOnlyDeletedAccuseds();
    }

    public function getAccusedWithReports($accusedId)
    {
        return $this->accusedRepository->getAccusedWithReports($accusedId);
    }
}
