<?php

namespace App\Model\Log;

use Illuminate\Database\Eloquent\Model;

class LogNotification extends Model
{
    protected $guarded = [];

    protected $casts = [
    	'request' => 'array',
    	'response' => 'array'
    ];

    public function logNotificationable()
    {
    	return $this->morpTo();
    }
}
