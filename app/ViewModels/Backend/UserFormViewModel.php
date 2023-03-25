<?php

namespace App\ViewModels\Backend;

use App\Model\User;
use Spatie\ViewModels\ViewModel;

class UserFormViewModel extends ViewModel
{

	public $contentHeader;
	public $user;

    public function __construct($contentHeader, User $user = null)
    {
        $this->contentHeader = $contentHeader;
        $this->user = $user ?? new User();
    }

    public function statuses(): array
    {
    	return $this->user->statusOptions();
    }

    public function selectedStatus($value): string
    {
    	return $value == old('status', $this->user->status)
    	    ? 'selected'
    	    : '' ;
    }

    public function roleOptions()
    {
        return \App\Model\Backend\Role::orderBy('name')->get();
    }

    public function selectedRoles($value): string
    {
        $userRoles = $this->user->getRoleNames() ?? [] ;

        return in_array($value, old('roles', $userRoles->toArray()))
            ? 'selected'
            : '' ;
    }
}
