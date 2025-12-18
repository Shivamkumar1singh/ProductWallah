<?php

namespace App\Repositories;

use App\Models\User;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\DB;

class UserRepository
{
    public function paginateUsers($limit)
    {
        return User::latest()->paginate($limit);
    }

    public function getAllRoles()
    {
        return Role::pluck('name', 'name')->all();
    }

    public function createUser($data)
    {
        return User::create($data);
    }

    public function assignRole($user, $role)
    {
        $user->assignRole($role);
    }

    public function findUser($id)
    {
        return User::findOrFail($id);
    }

    public function getUserRoles($user)
    {
        return $user->roles->pluck('name', 'name')->all();
    }

    public function updateUser($data, $id)
    {
        $user = User::findOrFail($id);
        $user->update($data);
        return $user;
    }

    public function syncRoles($user, $roles)
    {
        DB::table('model_has_roles')->where('model_id', $user->id)->delete();
        $user->assignRole($roles);
    }

    public function deleteUser($id)
    {
        return User::findOrFail($id)->delete();
    }
}
