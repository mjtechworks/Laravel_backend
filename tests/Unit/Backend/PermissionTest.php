<?php

namespace Tests\Unit\Backend;

use App\Model\Backend\Permission;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PermissionTest extends TestCase
{
	use RefreshDatabase;

	/** @test */
    public function permission_has_name_slug()
    {
    	$permission = factory(Permission::class)->create();
        $this->assertEquals(\Illuminate\Support\Str::slug($permission->name, '-'), $permission->name_slug);
    }
}
