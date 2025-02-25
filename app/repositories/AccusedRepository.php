<?php

namespace App\Repositories;

use App\Models\Accused;

class AccusedRepository
{
    public function getAllAccuseds()
    {
        return Accused::all();
    }

    public function getAccusedById($id)
    {
        return Accused::findOrFail($id);
    }

    public function storeAccused($data)
    {
        return Accused::create($data);
    }

    public function updateAccused($id, $data)
    {
        $accused = Accused::find($id);
        $accused->update($data);
        return $accused;
    }
    public function deleteAccused($id)
    {
        return Accused::findOrFail($id)->delete();
    }

    public function restoreAccused($id)
    {
        return Accused::withTrashed()->findOrFail($id)->restore();
    }

    public function getAllAccusedsWithDeleted()
    {
        return Accused::withTrashed()->get();
    }

    public function getOnlyDeletedAccuseds()
    {
        return Accused::onlyTrashed()->get();
    }

    public function getAccusedWithReports($id)
    {
        return Accused::with('reports')->find($id);
    }
}
