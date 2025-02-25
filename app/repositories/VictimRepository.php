<?php

namespace App\Repositories;

use App\Models\Victim;

class VictimRepository
{
    public function getAllVictims()
    {
        return Victim::all();
    }

    public function getVictimById($id)
    {
        return Victim::findOrFail($id);
    }

    public function storeVictim($data)
    {
        return Victim::create($data);
    }

    public function updateVictim($id, $data)
    {
        $victim = Victim::find($id);
        $victim->update($data);
        return $victim;
    }

    public function deleteVictim($id)
    {
        return Victim::findOrFail($id)->delete();
    }

    public function restoreVictim($id)
    {
        return Victim::withTrashed()->findOrFail($id)->restore();
    }

    public function getAllVictimsWithDeleted()
    {
        return Victim::withTrashed()->get();
    }

    public function getOnlyDeletedVictims()
    {
        return Victim::onlyTrashed()->get();
    }

    public function getVictimWithReports($id)
    {
        return Victim::with('reports')->find($id);
    }
}
