<?php

namespace App\Repositories;

use App\Models\User;
use App\Repositories\CityRepository;
use App\Repositories\GroupRepository;

class UserRepository
{
    protected CityRepository $cityRepository;
    protected GroupRepository $groupRepository;
    protected CenterRepository $centerRepository;

    public function __construct(CityRepository $cityRepository, GroupRepository $groupRepository, CenterRepository $centerRepository)
    {
        $this->cityRepository = $cityRepository;
        $this->groupRepository = $groupRepository;
        $this->centerRepository = $centerRepository;
    }

    public function store(array $data)
    {
        return User::create($data);
    }

    public function getUsersByGroup($groupId)
    {
        return User::where('group_id', $groupId)
            ->where('role', 'operator')
            ->get();
    }

    public function getAllUsers()
    {
        return User::all(); // Devuelve solo usuarios activos por defecto
    }

    public function find($id)
    {
        return User::findOrFail($id);
    }

    public function update($id, array $data)
    {
        $user = $this->find($id);
        return $user->update($data);
    }

    public function deleteUser($id)
    {
        return User::findOrFail($id)->delete(); // Eliminación lógica
    }

    public function restoreUser($id)
    {
        return User::withTrashed()->findOrFail($id)->restore(); // Restauración lógica
    }

    public function getAllUsersIncludingDeleted()
    {
        return User::withTrashed()->get(); // Incluye usuarios eliminados
    }

    public function getOnlyDeletedUsers()
    {
        return User::onlyTrashed()->get(); // Solo usuarios eliminados
    }

    public function getServicesByUser($userId)
    {
        $user = User::findOrFail($userId);
        return $user->services;
    }

    public function getAllCities()
    {
        return $this->cityRepository->getAllCities();
    }

    public function getAllGroups()
    {
        return $this->groupRepository->getAllGroups();
    }

    public function getAllCenters()
    {
        return $this->centerRepository->getAllCenters();
    }
}
