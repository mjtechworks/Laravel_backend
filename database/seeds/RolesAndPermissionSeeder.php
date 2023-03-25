<?php

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RolesAndPermissionsSeeder extends Seeder
{
    public function run()
    {
        // Reset cached roles and permissions
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        // General User
        Role::create(['name' => 'general user']);

        // Admin
        $adminRole = Role::create(['name' => 'admin']);
        
        // Super Admin
        Role::create(['name' => 'super admin']);

        // Permissions
        $existPermissions = Permission::all()->pluck('name')->toArray();

        foreach($this->permissionLists() as $permission) {
            if (!in_array($permission, $existPermissions)) {
                Permission::create(['name' => $permission])->assignRole('admin');
            }
        }

        $adminRole->givePermissionTo(Permission::all());
    }

    private function permissionLists()
    {
        return [
            'access user list',
            'manage user list',
            'add user list',
            'edit user list',
            'delete user list',
            'export user list',

            'access role list',
            'manage role list',
            'add role list',
            'edit role list',
            'delete role list',
            'export role list',

            'access trash list',
            'manage trash list',
            'remove trash list',
            'restore trash list',
            'remove all trash list',
            'restore all trash list',
        ];
    }
}