<?php

namespace App\Repositories;

use App\Models\RegionalUnit;

class RegionalUnitRepository
{
    public function getAllRegionalUnits()
    {
        return RegionalUnit::all();
    }

    public function getRegionalUnitById($id)
    {
        return RegionalUnit::findOrFail($id);
    }

    public function createRegionalUnit($data)
    {
        return RegionalUnit::create($data);
    }

    public function updateRegionalUnit($id, $data)
    {
        $regionalUnit = RegionalUnit::findOrFail($id);
        $regionalUnit->update($data);
        return $regionalUnit;
    }

    public function deleteRegionalUnit($id)
    {
        $regionalUnit = RegionalUnit::findOrFail($id);
        $regionalUnit->delete();
    }

    public function restoreRegionalUnit($id)
    {
        $regionalUnit = RegionalUnit::withTrashed()->findOrFail($id);
        $regionalUnit->restore();
    }
    public function getAllDeletedRegionalUnits()
    {
        return RegionalUnit::onlyTrashed()->get();
    }

    public function getRegionalUnitWithCenter($id)
    {
        return RegionalUnit::with('center')->findOrFail($id);
    }

    public function getRegionalUnitWithcities($id)
    {
        return RegionalUnit::with('cities')->findOrFail($id);
    }
}
