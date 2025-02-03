<?php

namespace App\Repositories;

use App\Models\PoliceMovementCode;


class PoliceMovementCodeRepository
{

    public function getAll()
    {
        return PoliceMovementCode::all();
    }

    public function getById($id)
    {
        return PoliceMovementCode::findOrFail($id);
    }

    public function create($data)
    {
        return PoliceMovementCode::create($data);
    }

    public function update($id, $data)
    {
        $policeMovementCode = PoliceMovementCode::find($id);
        $policeMovementCode->update($data);
        return $policeMovementCode;
    }

    public function delete($id)
    {
        return PoliceMovementCode::findOrFail($id)->delete();
    }

    public function restore($id)
    {
        return PoliceMovementCode::withTrashed()->findOrFail($id)->restore();
    }

    public function getDeletePoliceMovementCodes()
    {
        return PoliceMovementCode::onlyTrashed()->get();
    }

    public function getPoliceMovementCodeWithSubPoliceMovementCodes($id)
    {
        return PoliceMovementCode::with('subPoliceMovementCodes')->find($id);
    }

    public function getPoliceMovementCodeWithServices($id)
    {
        return PoliceMovementCode::with('services')->find($id);
    }
}
