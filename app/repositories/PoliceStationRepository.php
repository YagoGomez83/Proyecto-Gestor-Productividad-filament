<?php

namespace App\Repositories;

use App\Models\PoliceStation;

class PoliceStationRepository
{

    public function getAll()
    {
        return PoliceStation::all();
    }

    public function getById($id)
    {
        return PoliceStation::find($id);
    }

    public function create($data)
    {
        return PoliceStation::create($data);
    }

    public function update(array $data, $id)
    {

        return PoliceStation::where('id', $id)->update($data);
    }

    public function delete($id)
    {
        return PoliceStation::findOrfail($id)->delete();
    }

    public function restore($id)
    {
        return PoliceStation::withTrashed()->findOrfail($id)->restore();
    }

    public function getOnlyDeleted()
    {
        return PoliceStation::onlyTrashed()->get();
    }

    public function getPoliceStationWithCity($id)
    {
        return PoliceStation::with('city')->find($id);
    }

    public function getPoliceStationWithCameras($id)
    {
        return PoliceStation::with('cameras')->find($id);
    }
}
