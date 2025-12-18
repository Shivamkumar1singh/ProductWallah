<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class CreateAdminUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $user = User::create([
            'name' => 'Shivam Kumar', 
            'email' => 'shivamk12082002@gmail.com',
            'password' => bcrypt('password')
        ]);
        
        $role = Role::firstOrCreate(['name' => 'Admin']);

    $permissions = Permission::pluck('name')->toArray(); // ✅ use names, not IDs
    $role->syncPermissions($permissions);

    $user->assignRole($role); // ✅ assign by model, not ID
    }
}
