<?php

namespace App\Model\Backend;

use Spatie\Activitylog\Traits\LogsActivity;
use App\Model\Traits\DisplayDateFormat;

class Role extends \Spatie\Permission\Models\Role
{
    use LogsActivity;
    use DisplayDateFormat;

    protected static $logGuarded = true;
    protected static $recordEvents = ['updated', 'deleted'];

    public function getEditLinkAttribute() { return route('backend.role.edit', $this); }

    public function getDestroyLinkAttribute() { return route('backend.role.destroy', $this); }

    public function scopeHasUser($query)
    {
        $query->orderBy('name')->has('users');
    }
}
