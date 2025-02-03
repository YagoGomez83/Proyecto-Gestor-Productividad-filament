<?php

namespace App\Repositories;

use App\Models\SubPoliceMovementCode;

class SubPoliceMovementCodeRepository
{
    public function getAll()
    {
        return SubPoliceMovementCode::all();
    }

    public function getById($id)
    {
        return SubPoliceMovementCode::findOrFail($id);
    }

    public function create($data)
    {
        return SubPoliceMovementCode::create($data);
    }

    public function update($id, $data)
    {
        $subPoliceMovementCode = SubPoliceMovementCode::findOrFail($id);
        $subPoliceMovementCode->update($data);
        return $subPoliceMovementCode;
    }

    public function delete($id)
    {
        return SubPoliceMovementCode::findOrFail($id)->delete();
    }

    public function restore($id)
    {
        return SubPoliceMovementCode::withTrashed()->findOrFail($id)->restore();
    }

    public function getSubPoliceMovementCodeWithPoliceMovementCode($id)
    {
        return SubPoliceMovementCode::with('policeMovementCode')->findOrFail($id);
    }
}
