<?php

namespace App\Services;

use App\Repositories\CauseRepository;

class CauseService
{
    protected $causeRepository;

    public function __construct(CauseRepository $causeRepository)
    {
        $this->causeRepository = $causeRepository;
    }

    public function getAllCauses()
    {
        return $this->causeRepository->getAllCauses();
    }
    public function getCauseById($causeId)
    {
        return $this->causeRepository->getCauseById($causeId);
    }

    public function createCause($data)
    {
        return $this->causeRepository->storeCause($data);
    }

    public function updateCause($causeId, $data)
    {
        return $this->causeRepository->updateCause($causeId, $data);
    }
    public function deleteCause($causeId)
    {
        return $this->causeRepository->deleteCause($causeId);
    }

    public function restoreCause($causeId)
    {
        return $this->causeRepository->restoreCause($causeId);
    }

    public function getAllCausesWithDeleted()
    {
        return $this->causeRepository->getAllCausesWithDeleted();
    }

    public function getOnlyDeletedCauses()
    {
        return $this->causeRepository->getOnlyDeletedCauses();
    }

    public function getCauseWithReports($causeId)
    {
        return $this->causeRepository->getCauseWithReports($causeId);
    }
}
