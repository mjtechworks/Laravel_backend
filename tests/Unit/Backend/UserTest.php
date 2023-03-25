<?php

namespace Tests\Unit\Backend;

use App\Model\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class UserTest extends TestCase
{
	use RefreshDatabase;

    /** @test */
    public function user_has_edit_link()
    {
    	$user = factory(User::class)->create();
    	$this->assertEquals(route('backend.user.edit', $user), $user->edit_link);
    }

    /** @test */
    public function user_has_destroy_link()
    {
    	$user = factory(User::class)->create();
    	$this->assertEquals(route('backend.user.destroy', $user), $user->destroy_link);
    }
}
