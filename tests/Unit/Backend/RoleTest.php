<?php

namespace Tests\Unit\Backend;

use App\Model\Backend\Role;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class RoleTest extends TestCase
{
	use RefreshDatabase;

    /** @test */
    public function role_has_edit_link()
    {
    	$role = factory(Role::class)->create();
    	$this->assertEquals(route('backend.role.edit', $role), $role->edit_link);
    }

    /** @test */
    public function role_has_destroy_link()
    {
	    $role = factory(Role::class)->create();
	    $this->assertEquals(route('backend.role.destroy', $role), $role->destroy_link);
    }
}
