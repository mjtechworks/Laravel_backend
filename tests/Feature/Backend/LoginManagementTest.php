<?php

namespace Tests\Feature\Backend;

use App\Model\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class LoginManagementTest extends TestCase
{
    use RefreshDatabase;

    public function setUp(): void
    {
        parent::setUp();

        $this->seed();
        $this->seed('UserRolePermissionSeeder');
    }

    /** @test */
    public function only_active_user_can_login()
    {
        // $this->withoutExceptionHandling();

        $user = factory(User::class)->create([
            'status' => 'inactive'
        ]);

        $credentials = [
            'email' => $user->email,
            'password' => 'password'
        ];
        $this->assertCredentials($credentials); // credential ถูกแต่ Login ไม่ได้

        $response = $this->post('/backend/login', $credentials);
        $response->assertSessionHasErrors(['email']);
        $this->assertGuest();

        $user->status = 'active';
        $user->save();

        $response = $this->post('/backend/login', $credentials);
        $response->assertSessionHasNoErrors();
        $response->assertRedirect('/backend/dashboard');
        $this->assertAuthenticatedAs($user);
    }

    /** @test */
    public function inactive_user_must_auto_redirect_to_login()
    {
        $user = factory(User::class)->create([
            'status' => 'inactive'
        ]);

        $this->actingAs($user);

        $this->get('/backend/role')
            ->assertStatus(302)
            ->assertRedirect('/backend/login');

        $this->get('/backend/user')
            ->assertStatus(302)
            ->assertRedirect('/backend/login');

        $this->get('/backend/dashboard')
            ->assertStatus(302)
            ->assertRedirect('/backend/login');
    }
}
