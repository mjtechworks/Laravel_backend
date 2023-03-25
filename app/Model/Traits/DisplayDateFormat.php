<?php
namespace App\Model\Traits;

use Illuminate\Database\Eloquent\Model;

trait DisplayDateformat {

	public function getDisplayCreatedAtThaiAttribute()
	{
	    return carbonToThaiDate($this->created_at);
	}

	public function getDisplayCreatedAtFullThaiAttribute()
	{
		return carbonToThaiDate($this->created_at, 'D MMM YYYY HH:mm[น.]');
	}

	public function getDisplayUpdatedAtThaiAttribute()
	{
	    return carbonToThaiDate($this->updated_at);
	}

	public function getDisplayUpdatedAtFullThaiAttribute()
	{
	    return carbonToThaiDate($this->updated_at, 'D MMM YYYY HH:mm[น.]');
	}

}