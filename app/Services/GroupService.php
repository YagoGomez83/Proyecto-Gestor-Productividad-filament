<?php

namespace App\Services;

use App\Repositories\GroupRepository;

class GroupService
{
    protected $groupRepository;
    public function __construct(GroupRepository $groupRepository)
    {
        $this->groupRepository = $groupRepository;
    }


    public function getAllGroups()
    {
        return $this->groupRepository->getAllGroups();
    }

    public function getGroupById($groupId)
    {
        return $this->groupRepository->getGroupById($groupId);
    }

    public function createGroup($data)
    {
        return $this->groupRepository->storeGroup($data);
    }

    public function updateGroup($groupId, $data)
    {
        return $this->groupRepository->updateGroup($groupId, $data);
    }

    public function deleteGroup($groupId)
    {
        return $this->groupRepository->deleteGroup($groupId);
    }

    public function getGroupWithMembers($groupId)
    {
        return $this->groupRepository->getGroupWithMembers($groupId);
    }

    public function restoreGroup($groupId)
    {
        return $this->groupRepository->restoreGroup($groupId);
    }
    public function getDeleteGroups()
    {
        return $this->groupRepository->getDeletedGroups();
    }

    public function getGroupWithServices($groupId)
    {
        return $this->groupRepository->getGroupWithServices($groupId);
    }
}
