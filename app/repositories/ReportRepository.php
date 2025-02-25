<?php

namespace App\Repositories;

use App\Models\Report;

class ReportRepository
{
    public function getAllReports()
    {
        return Report::all();
    }

    public function getReportById($id)
    {
        return Report::findOrFail($id);
    }

    public function storeReport($data)
    {
        return Report::create($data);
    }

    public function updateReport($id, $data)
    {
        $report = Report::find($id);
        $report->update($data);
        return $report;
    }

    public function deleteReport($id)
    {
        return Report::findOrFail($id)->delete();
    }

    public function restoreReport($id)
    {
        return Report::withTrashed()->findOrFail($id)->restore();
    }

    public function getAllReportsWithDeleted()
    {
        return Report::withTrashed()->get();
    }

    public function getOnlyDeletedReports()
    {
        return Report::onlyTrashed()->get();
    }

    public function getReportsWithUser($id)
    {
        return Report::with('user')->find($id);
    }

    public function getReportsWithPoliceStation($id)
    {
        return Report::with('policeStation')->find($id);
    }

    public function getReportsWithCause($id)
    {
        return Report::with('cause')->find($id);
    }

    public function getReportsWithAccuseds($id)
    {
        return Report::with('accuseds')->find($id);
    }

    public function getReportsWithVictims($id)
    {
        return Report::with('victims')->find($id);
    }

    public function getReportsWithVehicle($id)
    {
        return Report::with('vehicles')->find($id);
    }

    public function getReportsWithCameras($id)
    {
        return Report::with('cameras')->find($id);
    }

    public function getReportsWithLocation($id)
    {
        return Report::with('location')->find($id);
    }
}
