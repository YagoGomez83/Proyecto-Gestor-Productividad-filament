<?php

namespace App\Repositories;

use App\Models\Group;

class GroupRepository
{
    public function getAllGroups()
    {
        return Group::all();
    }

    public function getGroupById($id)
    {
        return Group::find($id);
    }

    public function storeGroup($data)
    {
        return Group::create($data);
    }

    public function updateGroup($id, $data)
    {
        $group = Group::find($id);
        $group->update($data);
        return $group;
    }

    public function deleteGroup($id)
    {
        return Group::findOrFail($id)->delete();
    }

    public function restoreGroup($id)
    {
        return Group::withTrashed()->findOrFail($id)->restore();
    }

    public function getDeletedGroups()
    {
        return Group::onlyTrashed()->get();
    }

    public function getGroupWithCenter($id)
    {
        return Group::with('center')->find($id);
    }


    public function getGroupWithMembers($id)
    {
        return Group::with('users')->find($id);
    }

    public function getGroupWithServices($id)
    {
        return Group::with('services')->find($id);
    }
}
