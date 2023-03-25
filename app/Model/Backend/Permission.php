<?php

namespace App\Model\Backend;

use Spatie\Activitylog\Traits\LogsActivity;
use App\Model\Traits\DisplayDateFormat;

class Permission extends \Spatie\Permission\Models\Permission
{
    use LogsActivity;
    use DisplayDateFormat;

    protected static $logGuarded = true;
    protected static $recordEvents = ['updated', 'deleted'];

    public function getEditLinkAttribute() { return route('backend.role.edit', $this); }

    public function getDestroyLinkAttribute() { return route('backend.role.destroy', $this); }

    public function getNameSlugAttribute() { return \Illuminate\Support\Str::slug($this->name, '-'); }
}
