<?php

namespace Tests\Feature\Backend;

use App\Model\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class RoleSuperAdminTest extends TestCase
{
    use RefreshDatabase;

    public function setUp(): void
    {
        parent::setUp();

        $this->seed();
    }

    /** @test */
    public function superadmin_can_access_all()
    {
        $user = User::role('super admin')->first();
        $this->actingAs($user);

        $response = $this->get('/backend/dashboard');
        $response->assertOK();
    }

}
