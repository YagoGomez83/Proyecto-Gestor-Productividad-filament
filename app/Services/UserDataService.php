<?php

namespace App\Services;

use App\Models\City;
use App\Models\User;
use App\Models\Group;
use App\Models\Center;

class UserDataService
{
    public function getCreatePageData()
    {
        return [
            'cities' => City::all(),
            'groups' => Group::all(),
            'centers' => Center::all(),
        ];
    }

    public function getAllUsers()
    {
        return User::all();
    }
}
