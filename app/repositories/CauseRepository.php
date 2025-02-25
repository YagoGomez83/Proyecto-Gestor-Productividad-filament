<?php

namespace App\Repositories;

use App\Models\Cause;

class CauseRepository
{
    public function getAllCauses()
    {
        return Cause::all();
    }

    public function getCauseById($id)
    {
        return Cause::findOrFail($id);
    }

    public function storeCause($data)
    {
        return Cause::create($data);
    }

    public function updateCause($id, $data)
    {
        $cause = Cause::find($id);
        $cause->update($data);
        return $cause;
    }
    public function deleteCause($id)
    {
        return Cause::findOrFail($id)->delete();
    }

    public function restoreCause($id)
    {
        return Cause::withTrashed()->findOrFail($id)->restore();
    }

    public function getAllCausesWithDeleted()
    {
        return Cause::withTrashed()->get();
    }

    public function getOnlyDeletedCauses()
    {
        return Cause::onlyTrashed()->get();
    }

    public function getCauseWithReports($id)
    {
        return Cause::with('reports')->find($id);
    }
}
