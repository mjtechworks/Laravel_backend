<?php

namespace Tests\Feature\Backend;

use App\Model\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\UploadedFile;
use Tests\TestCase;

class ProfileManagementTest extends TestCase
{
    use RefreshDatabase;

    public function setUp(): void
    {
        parent::setUp();

        $this->seed();
    }

    /** @test */
    public function profile_page_can_access()
    {
        $this->assertGuest();
        $response = $this->get('backend/profile');
        $response->assertRedirect('/backend/login');

        $this->actingAs(User::role('admin')->first());

        $response = $this->get('backend/profile');
        $response->assertRedirect('/backend/profile/edit');

        $response = $this->get('backend/profile/edit');
        $response->assertOK();
        $response->assertViewIs('backend.profile.edit');
    }

    /** @test */
    public function profile_can_edit()
    {
        $user = User::role('admin')->first();
        $this->actingAs($user);

        $response = $this->patch('/backend/profile', [
            'name' => 'test edited name',
            'email' => 'test@test.com'
        ]);

        $response->assertSessionHas('profile-updated', true);
        $response->assertRedirect('/backend/profile/edit');

        $this->assertDatabaseHas('users', [
            'name' => 'test edited name',
            'email' => 'test@test.com'
        ]);
    }

    /** @test */
    public function profile_can_edit_to_new_email_or_old_email()
    {
        factory(User::class)->create([
            'email' => 'test@test.com'
        ]);

        $user = User::role('admin')->first();
        $this->actingAs($user);

        // cannot edit to duplicated email
        $response = $this->patch('/backend/profile', [
            'name' => 'test edited name',
            'email' => 'test@test.com'
        ]);
        $response->assertSessionHasErrors(['email']);

        $this->assertDatabaseHas('users', ['email' => 'test@test.com']);

        // edit to valid email
        $response = $this->patch('/backend/profile', [
            'name' => 'test edited name',
            'email' => 'test1@test.com'
        ]);
        $response->assertSessionHas('profile-updated', true);
        $response->assertRedirect('/backend/profile/edit');

        $this->assertDatabaseHas('users', [
            'name' => 'test edited name',
            'email' => 'test1@test.com'
        ]);

        // can change only name and email is owned
        $response = $this->patch('/backend/profile', [
            'name' => 'test edited name 1',
            'email' => 'test1@test.com'
        ]);
        $response->assertSessionHas('profile-updated', true);
        $response->assertRedirect('/backend/profile/edit');

        $this->assertDatabaseHas('users', [
            'name' => 'test edited name 1',
            'email' => 'test1@test.com'
        ]);
        $this->assertCount(1 , User::whereEmail('test1@test.com')->get());
        $this->assertCount(1 , User::whereEmail('test@test.com')->get());
    }

    /** @test */
    public function profile_page_can_change_password()
    {
        // $this->withoutExceptionHandling();

        $user = factory(User::class)->create([
            'id' => 10,
            'email' => 'xxxx@xxxx.com',
            'password' => 'password',
            'status' => 'active'
        ]);

        // login with old password before changed
        $credentials = [
            'email' => 'xxxx@xxxx.com',
            'password' => 'password'
        ];
        $response = $this->post('/backend/login', $credentials);
        $response->assertSessionHasNoErrors();
        $this->assertCredentials($credentials);
        $this->assertAuthenticatedAs($user);

        // change password
        $response = $this->patch('/backend/profile', [
            'name' => 'test name',
            'email' => 'xxxx@xxxx.com',
            'old_password' => 'password',
            'password' => 'new-password',
            'password_confirmation' => 'new-password'
        ]);
        $response->assertSessionHas('profile-updated', true);
        $response->assertRedirect('/backend/profile/edit');

        // logout
        $this->post('/backend/logout');
        $this->assertGuest();
        $user->refresh();

        // login with old password after changed
        $credentials = [
            'email' => 'xxxx@xxxx.com',
            'password' => 'password'
        ];
        $response = $this->post('/backend/login', $credentials);
        $response->assertSessionHasErrors(['email']);
        $this->assertInvalidCredentials($credentials);

        // login with new password
        $credentials = [
            'email' => 'xxxx@xxxx.com',
            'password' => 'new-password'
        ];
        $response = $this->post('/backend/login', $credentials);
        $response->assertSessionHasNoErrors();
        $this->assertCredentials($credentials);
        $this->assertAuthenticatedAs($user);
    }

    /** @test */
    public function profile_page_can_edit_profile_image()
    {
        $this->storageFakeUploadMediaLibrary('images');

        $user = User::role('admin')->first();
        $this->actingAs($user);

        $this->assertNull($user->getFirstMedia('avatar'));

        $file = UploadedFile::fake()->image('avatar.jpg');

        $profileData = [
            'name' => 'name',
            'email' => 'test@test.com',
            'profile_image_file' => $file
        ];

        $response = $this->patch('/backend/profile', $profileData);
        $response->assertSessionHas('profile-updated', true);
        $response->assertRedirect('/backend/profile/edit');

        $user->refresh();

        $this->assertNotNull($user->getFirstMedia('avatar'));

        // original
        $this->assertFileExists($user->getFirstMedia('avatar')->getPath());
        // thumb
        $this->assertFileExists($user->getMedia('avatar')[0]->getPath('thumb'));
    }

}
