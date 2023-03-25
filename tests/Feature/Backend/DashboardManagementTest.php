<?php

namespace Tests\Feature\Backend;

use App\Model\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class DashboardManagementTest extends TestCase
{
    use RefreshDatabase;

    public function setUp(): void
    {
        parent::setUp();

        $this->seed();
    }

    /** @test */
    public function allowed_user_can_access_dashboard_page()
    {
        $response = $this->get('/backend/dashboard');
        $response->assertRedirect('/backend/login');

        $user = User::role('admin')->first();
        $this->actingAs($user);

        $response = $this->get('/backend/dashboard');
        $response->assertOK();
    }
}
