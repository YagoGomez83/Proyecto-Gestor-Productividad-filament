<?php

namespace App\Repositories;

use App\Models\City;
use Illuminate\Support\Facades\DB;

class CityRepository
{
    public function getAllCities()
    {
        return City::all();
    }

    public function getCityById($id)
    {
        return City::findOrFail($id);
    }


    public function storeCity($data)
    {
        return City::create($data);
    }

    public function updateCity($id, $data)
    {
        $city = City::findOrFail($id);
        $city->update($data);
        return $city;
    }

    public function deleteCity($id)
    {
        return City::findOrFail($id)->delete();
    }

    public function restoreCity($id)
    {
        return City::withTrashed()->findOrFail($id)->restore();
    }

    public function getAllCitiesWithDeleted()
    {
        return City::withTrashed()->get();
    }

    public function getOnlyDeletedCities()
    {
        return City::onlyTrashed()->get();
    }

    public function getCityWithRegionalUnit($id)
    {
        return City::with('regionalUnit')->find($id);
    }

    public function getCityWithPoliceStatios($id)
    {
        return City::with('policeStations')->find($id);
    }

    public function getCityWithCameras($id)
    {
        return City::with('cameras')->find($id);
    }
}
