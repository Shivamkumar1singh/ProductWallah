<?php

namespace App\Repositories;

use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use DB;

class RoleRepository
{
    public function getAllPaginated($perPage = 5)
    {
        return Role::orderBy('id', 'DESC')->paginate($perPage);
    }

    public function getAllPermissions()
    {
        return Permission::all();
    }

    public function findRole($id)
    {
        return Role::findOrFail($id);
    }

    public function getRolePermissions($roleId)
    {
        return Permission::join("role_has_permissions", "role_has_permissions.permission_id", "=", "permissions.id")
            ->where("role_has_permissions.role_id", $roleId)
            ->get();
    }

    public function getRolePermissionIds($roleId)
    {
        return DB::table("role_has_permissions")
                ->where("role_has_permissions.role_id", $roleId)
                ->pluck('role_has_permissions.permission_id')
                ->toArray();
    }

    public function createRole($name, array $permissions)
    {
        $role = Role::create(['name' => $name]);
        $role->syncPermissions($permissions);
        return $role;
    }

    public function updateRole($id, $name, array $permissions)
    {
        $role = Role::findOrFail($id);
        $role->update(['name' => $name]);
        $role->syncPermissions($permissions);

        return $role;
    }

    public function deleteRole($id)
    {
        return Role::destroy($id);
    }
}
