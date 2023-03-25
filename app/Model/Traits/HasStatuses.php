<?php
namespace App\Model\Traits;

use Illuminate\Database\Eloquent\Model;

trait HasStatuses {

	public function getDisplayStatusAttribute()
	{
	    return $this->statusOptions()[$this->status];
	}

	public static function statusOptions()
	{
	    return [
	        'active' => 'Active',
	        'inactive' => 'Inactive'
	    ];
	}

}