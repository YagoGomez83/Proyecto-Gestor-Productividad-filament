<?php

namespace App\Services;

use App\Repositories\VictimRepository;


class VictimService
{
    protected $victimRepository;

    public function __construct(VictimRepository $victimRepository)
    {
        $this->victimRepository = $victimRepository;
    }

    public function getAllVictims()
    {
        return $this->victimRepository->getAllVictims();
    }
    public function getVictimById($victimId)
    {
        return $this->victimRepository->getVictimById($victimId);
    }

    public function createVictim($data)
    {
        return $this->victimRepository->storeVictim($data);
    }

    public function updateVictim($victimId, $data)
    {
        return $this->victimRepository->updateVictim($victimId, $data);
    }

    public function deleteVictim($victimId)
    {
        return $this->victimRepository->deleteVictim($victimId);
    }

    public function restoreVictim($victimId)
    {
        return $this->victimRepository->restoreVictim($victimId);
    }

    public function getAllVictimsWithDeleted()
    {
        return $this->victimRepository->getAllVictimsWithDeleted();
    }

    public function getOnlyDeletedVictims()
    {
        return $this->victimRepository->getOnlyDeletedVictims();
    }

    public function getVictimWithReports($victimId)
    {
        return $this->victimRepository->getVictimWithReports($victimId);
    }
}
