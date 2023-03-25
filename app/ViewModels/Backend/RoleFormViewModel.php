<?php

namespace App\ViewModels\Backend;

use App\Model\Backend\Role;
use Spatie\ViewModels\ViewModel;

class RoleFormViewModel extends ViewModel
{

	public $contentHeader;
	public $role;

    public function __construct($contentHeader, Role $role = null)
    {
        $this->contentHeader = $contentHeader;
        $this->role = $role ?? new Role;
    }

    public function permissionOptions()
    {
        return \App\Model\Backend\Permission::orderBy('name')->get();
    }

    public function checkedPermissions($value)
    {
    	$rolePermissions = $this->role->getPermissionNames() ?? [] ;

    	return in_array($value, old('roles', $rolePermissions->toArray()))
    	    ? 'checked'
    	    : '' ;
    }
}
