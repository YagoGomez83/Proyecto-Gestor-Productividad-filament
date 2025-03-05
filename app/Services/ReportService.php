<?php

namespace App\Services;

use App\Repositories\ReportRepository;

class ReportService
{
    protected $reportRepository;

    public function __construct(ReportRepository $reportRepository)
    {
        $this->reportRepository = $reportRepository;
    }

    public function getAllReports($perPage = 10)
    {
        return $this->reportRepository->getAllReports($perPage);
    }

    public function getReportById($reportId)
    {
        return $this->reportRepository->getReportById($reportId);
    }

    public function createReport($data)
    {
        return $this->reportRepository->storeReport($data);
    }

    public function updateReport($reportId, $data)
    {
        return $this->reportRepository->updateReport($reportId, $data);
    }

    public function deleteReport($reportId)
    {
        return $this->reportRepository->deleteReport($reportId);
    }

    public function restoreReport($reportId)
    {
        return $this->reportRepository->restoreReport($reportId);
    }

    public function getAllReportsWithDeleted()
    {
        return $this->reportRepository->getAllReportsWithDeleted();
    }

    public function getOnlyDeletedReports()
    {
        return $this->reportRepository->getOnlyDeletedReports();
    }

    public function getReportsWithLocation($locationId)
    {
        return $this->reportRepository->getReportsWithLocation($locationId);
    }

    public function getReportsWithVehicle($vehicleId)
    {
        return $this->reportRepository->getReportsWithVehicle($vehicleId);
    }

    public function getReportsWithUser($userId)
    {
        return $this->reportRepository->getReportsWithUser($userId);
    }

    public function getReportsWithCause($causeId)
    {
        return $this->reportRepository->getReportsWithCause($causeId);
    }

    public function getReportsWithAccuseds($accusedId)
    {
        return $this->reportRepository->getReportsWithAccuseds($accusedId);
    }

    public function getReportsWithPoliceStation($policeStationId)
    {
        return $this->reportRepository->getReportsWithPoliceStation($policeStationId);
    }

    public function getReportsWithVictims($victimId)
    {
        return $this->reportRepository->getReportsWithVictims($victimId);
    }

    public function getReportsWithCameras($camerasId)
    {
        return $this->reportRepository->getReportsWithCameras($camerasId);
    }
    public function searchReports($search, $perPage = 10)
    {
        return $this->reportRepository->searchReports($search);
    }
}
