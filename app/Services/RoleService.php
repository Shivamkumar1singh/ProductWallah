<?php

namespace App\Services;

use App\Repositories\RoleRepository;

class RoleService
{
    protected $roleRepo;

    public function __construct(RoleRepository $roleRepo)
    {
        $this->roleRepo = $roleRepo;
    }

    public function listRoles($perPage = 5)
    {
        return $this->roleRepo->getAllPaginated($perPage);
    }

    public function createRole(array $data)
    {
        return $this->roleRepo->createRole(
            $data['name'],
            $data['permissions']
        );
    }

    public function updateRole($id, array $data)
    {
        return $this->roleRepo->updateRole(
            $id,
            $data['name'],
            $data['permissions']
        );
    }

    public function deleteRole($id)
    {
        return $this->roleRepo->deleteRole($id);
    }

    public function getPermissions()
    {
        return $this->roleRepo->getAllPermissions();
    }

    public function findRole($id)
    {
        return $this->roleRepo->findRole($id);
    }

    public function getRolePermissions($id)
    {
        return $this->roleRepo->getRolePermissions($id);
    }

    public function getPermissionIds($id)
    {
        return $this->roleRepo->getRolePermissionIds($id);
    }
}
