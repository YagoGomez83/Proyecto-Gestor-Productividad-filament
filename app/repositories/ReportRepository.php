<?php

namespace App\Repositories;

use App\Models\Report;

class ReportRepository
{
    public function getAllReports($perPage = 10)
    {
        return Report::paginate($perPage);
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

    public function searchReports($search, $perPage = 10)
    {
        return Report::with(['policeStation', 'cause', 'accuseds', 'victims', 'vehicles', 'cameras', 'location'])
            ->when($search, function ($query) use ($search) {
                $query->whereRaw("LOWER(title) LIKE LOWER(?)", ["%$search%"])
                    ->orWhereRaw("LOWER(description) LIKE LOWER(?)", ["%$search%"])
                    ->orWhereRaw("CAST(report_date AS CHAR) LIKE LOWER(?)", ["%$search%"]) // ✅ Conversión de fecha
                    ->orWhereRaw("CAST(report_time AS CHAR) LIKE LOWER(?)", ["%$search%"]) // ✅ Conversión de hora
                    ->orWhereHas('location', function ($q) use ($search) {
                        $q->whereRaw("LOWER(address) LIKE LOWER(?)", ["%$search%"]);
                    })
                    ->orWhereHas('policeStation', function ($q) use ($search) {
                        $q->whereRaw("LOWER(name) LIKE LOWER(?)", ["%$search%"]);
                    })
                    ->orWhereHas('cause', function ($q) use ($search) {
                        $q->whereRaw("LOWER(cause_name) LIKE LOWER(?)", ["%$search%"]);
                    })
                    ->orWhereHas('accuseds', function ($q) use ($search) {
                        $q->whereRaw("LOWER(name) LIKE LOWER(?)", ["%$search%"]);
                    })
                    ->orWhereHas('victims', function ($q) use ($search) {
                        $q->whereRaw("LOWER(name) LIKE LOWER(?)", ["%$search%"]);
                    })
                    ->orWhereHas('vehicles', function ($q) use ($search) {
                        $q->whereRaw("LOWER(brand) LIKE LOWER(?)", ["%$search%"]);
                    })
                    ->orWhereHas('cameras', function ($q) use ($search) {
                        $q->whereRaw("LOWER(identifier) LIKE LOWER(?)", ["%$search%"]);
                    });
            })->paginate($perPage);
    }
}
