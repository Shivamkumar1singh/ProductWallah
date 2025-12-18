<?php

namespace App\Services;

use App\Repositories\UserRepository;
use Illuminate\Support\Facades\Hash;

class UserService
{
    protected $repo;

    public function __construct(UserRepository $repo)
    {
        $this->repo = $repo;
    }

    public function getAllPaginated()
    {
        return [
            'data' => $this->repo->paginateUsers(5),
            'i' => (request()->input('page', 1) - 1) * 5
        ];
    }

    public function getAllRoles()
    {
        return $this->repo->getAllRoles();
    }

    public function createUser($data)
    {
        $data['password'] = Hash::make($data['password']);
        $user = $this->repo->createUser($data);

        $this->repo->assignRole($user, $data['roles']);
    }

    public function findUser($id)
    {
        return $this->repo->findUser($id);
    }

    public function getUserForEdit($id)
    {
        $user = $this->repo->findUser($id);

        return [
            'user' => $user,
            'roles' => $this->repo->getAllRoles(),
            'userRole' => $this->repo->getUserRoles($user),
        ];
    }

    public function updateUser($data, $id)
    {
        if (!empty($data['password'])) {
            $data['password'] = Hash::make($data['password']);
        } else {
            unset($data['password']);
        }

        $user = $this->repo->updateUser($data, $id);

        $this->repo->syncRoles($user, $data['roles']);
    }

    public function deleteUser($id)
    {
        return $this->repo->deleteUser($id);
    }
}
