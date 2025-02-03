<?php

namespace App\Repositories;

use App\Models\Center;


class CenterRepository
{
    public function getAllCenters()
    {
        return Center::all();
    }

    public function getCenterById($id)
    {
        return Center::findOrFail($id);
    }

    public function storeCenter($data)
    {
        return Center::create($data);
    }

    public function updateCenter($id, $data)
    {
        $center = Center::find($id);
        $center->update($data);
        return $center;
    }

    public function deleteCenter($id)
    {
        return Center::findOrFail($id)->delete();
    }

    public function restoreCenter($id)
    {
        return Center::withTrashed()->findOrFail($id)->restore();
    }

    public function getAllCentersWithDeleted()
    {
        return Center::withTrashed()->get();
    }

    public function getOnlyDeletedCenters()
    {
        return Center::onlyTrashed()->get();
    }

    public function getCenterWithRegionalUnits($id)
    {
        return Center::with('regionalUnits')->find($id);
    }

    public function getCenterWithGroups($id)
    {
        return Center::with('groups')->find($id);
    }

    public function getCenterWithServices($id)
    {
        return Center::with('services')->find($id);
    }
}
