<?php

namespace App\Repositories;

use App\Models\Location;

class LocationRepository
{
    public function getAllLocations()
    {
        return Location::all();
    }

    public function getLocationById($id)
    {
        return Location::findOrFail($id);
    }

    public function createLocation($data)
    {
        return Location::create($data);
    }

    public function updateLocation($id, $data)
    {
        $location = Location::find($id);
        $location->update($data);
        return $location;
    }

    public function deleteLocation($id)
    {
        return Location::findOrFail($id)->delete();
    }

    public function restoreLocation($id)
    {
        return Location::withTrashed()->findOrFail($id)->restore();
    }

    public function getAllLocationsWithDeleted()
    {
        return Location::withTrashed()->get();
    }

    public function getOnlyDeletedLocations()
    {
        return Location::onlyTrashed()->get();
    }
}
