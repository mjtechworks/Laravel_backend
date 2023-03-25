<?php

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;

class UserRolePermissionSeeder extends Seeder
{
	private function userPermissions()
	{
	    return [
	        // 
	    ];
	}

    public function run()
    {
    	app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

    	$existPermissions = Permission::all()->pluck('name')->toArray();

    	foreach($this->userPermissions() as $permission) {
    		if (!in_array($permission, $existPermissions)) {
    	    	Permission::create(['name' => $permission])->assignRole('admin');
    		}
    	}

    	/**
    	 * Remove Permission
    	 */
		// foreach($this->userPermissions() as $permission) {
		//     Permission::whereName($permission)->delete();
		// }
    }
}
