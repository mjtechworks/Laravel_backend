<?php

namespace Tests\Feature\Backend;

use App\Model\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\UploadedFile;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Tests\TestCase;

class UserManagementTest extends TestCase
{
    use RefreshDatabase;

    public function setUp(): void
    {
        parent::setUp();

        $this->seed();
        $this->seed('UserRolePermissionSeeder');
    }

    /** @test */
    public function user_list_page_can_be_displayed()
    {
        $user = User::role('admin')->first();
        $this->actingAs($user);

        $response = $this->get('/backend/user');
        $response->assertOK();
        $response->assertViewIs('backend.user.index');
    }

    /** @test */
    public function user_create_page_can_be_displayed()
    {
        $user = User::role('admin')->first();
        $this->actingAs($user);

        $response = $this->get('/backend/user/create');
        $response->assertOK();
        $response->assertViewIs('backend.user.create');
    }    

    /** @test */
    public function user_edit_page_can_be_displayed()
    {
        $user = User::role('admin')->first();
        $this->actingAs($user);

        $response = $this->get('/backend/user/1/edit');
        $response->assertOK();
        $response->assertViewIs('backend.user.edit');
    }

    /** @test */
    public function allowed_user_can_access_to_user_page()
    {
        $user = factory(User::class)->create([
            'status' => 'active'
        ]);
        $this->actingAs($user);

        $this->get('/backend/user')
            ->assertForbidden();
        $this->get('/backend/user/create')
            ->assertForbidden();
        $this->get('/backend/user/1/edit')
            ->assertForbidden();

        $role = Role::create(['name' => 'role-test']);

        $role->syncPermissions([
            'access user list',
            'add user list',
            'edit user list',
        ]);

        $user->assignRole('role-test');

        $this->get('/backend/user')
            ->assertOK()
            ->assertViewIs('backend.user.index');

        $this->get('/backend/user/create')
            ->assertOK()
            ->assertViewIs('backend.user.create');

        $this->get('/backend/user/1/edit')
            ->assertOK()
            ->assertViewIs('backend.user.edit');
    }

    /** @test */
    public function user_can_be_created()
    {
        // $this->withoutExceptionHandling();

        $user = User::role('admin')->first();
        $this->actingAs($user);

        $userData = factory(User::class)->raw([
            'name' => 'test user',
            'email' => 'test@example.com',
            'password_confirmation' => 'password',
            'status' => 'active'
        ]);

        $response = $this->post('/backend/user', $userData);
        $response->assertSessionHas('user-created', true);
        $response->assertRedirect('/backend/user');

        $this->assertDatabaseHas('users', [
            'name' => 'test user',
            'email' => 'test@example.com',
        ]);
    }

    /** @test */
    public function user_created_with_upload_profile_image_and_thumb()
    {
        // $this->withoutExceptionHandling();

        $this->storageFakeUploadMediaLibrary('images');

        $user = User::role('admin')->first();
        $this->actingAs($user);

        $file = UploadedFile::fake()->image('avatar.jpg');

        $userData = factory(User::class)->raw([
            'password' => 'password',
            'password_confirmation' => 'password',
            'profile_image_file' => $file
        ]);

        $response = $this->post('/backend/user', $userData);
        $response->assertSessionHas('user-created', true);
        $response->assertRedirect('/backend/user');

        // $createdUser = User::find(4); // 4 เพราะ seed มีมาแล้ว 3 คน
        $createdUser = User::orderBy('id', 'desc')->first();

        // original
        $this->assertFileExists($createdUser->getFirstMedia('avatar')->getPath());
        // thumb
        $this->assertFileExists($createdUser->getMedia('avatar')[0]->getPath('thumb'));
    }

    /** @test */
    public function user_created_with_upload_profile_image_size_over_2mb_and_invalid_type()
    {
        $this->storageFakeUploadMediaLibrary('images');

        $user = User::role('admin')->first();
        $this->actingAs($user);

        $file = UploadedFile::fake()->image('avatar.jpg')->size(2500);

        $userData = factory(User::class)->raw([
            'name' => 'test name upload',
            'password' => 'password',
            'password_confirmation' => 'password',
            'profile_image_file' => $file
        ]);

        $response = $this->post('/backend/user', $userData);
        $response->assertSessionHasErrors('profile_image_file');
        $this->assertDatabaseMissing('users', [
            'name' => 'test name upload'
        ]);

        $userData['profile_image_file'] = UploadedFile::fake()->image('avatar.gif');

        $response = $this->post('/backend/user', $userData);
        $response->assertSessionHasErrors('profile_image_file');
        $this->assertDatabaseMissing('users', [
            'name' => 'test name upload'
        ]);
    }

    /** @test */
    public function user_can_be_edited()
    {
        // $this->withoutExceptionHandling();

        $user = User::role('admin')->first();
        $this->actingAs($user);

        factory(User::class)->create([
            'id' => 10,
            'name' => 'test user',
            'email' => 'test@example.com'
        ]);

        $this->assertDatabaseMissing('users', [
            'name' => 'edited user'
        ]);

        $response = $this->patch('/backend/user/10', [
            'name' => 'edited user',
            'email' => 'test@example.com',
            'status' => 'active'
        ]);
        // dd(session()->get('errors'));
        $response->assertSessionHas('user-updated', true);
        $response->assertRedirect('/backend/user');

        $this->assertDatabaseHas('users', [
            'name' => 'edited user'
        ]);
    }

    /** @test */
    public function user_edited_with_upload_profile_image_and_thumb()
    {
        // $this->withoutExceptionHandling();
        
        $this->storageFakeUploadMediaLibrary('images');

        $user = User::role('admin')->first();
        $this->actingAs($user);

        factory(User::class)->create([
            'id' => 10
        ]);

        $file = UploadedFile::fake()->image('edit-avatar.jpg');

        $response = $this->patch('/backend/user/10', [
            'name' => 'edited name',
            'email' => 'edited@edited.com',
            'profile_image_file' => $file,
            'status' => 'active'
        ]);
        // dd(session()->get('errors'));
        $response->assertSessionHas('user-updated', true);
        $response->assertRedirect('/backend/user');

        $createdUser = User::find(10);
        // name
        $this->assertEquals($createdUser->getFirstMedia('avatar')->name, 'edit-avatar');
        // original
        $this->assertFileExists($createdUser->getFirstMedia('avatar')->getPath());
        // thumb
        $this->assertFileExists($createdUser->getMedia('avatar')[0]->getPath('thumb'));
    }

    /** @test */
    public function user_edited_can_change_password_and_login()
    {
        factory(User::class)->create([
            'id' => 10,
            'email' => 'xxxx@xxxx.com',
            'password' => bcrypt('password'),
            'status' => 'active'
        ]);

        // Login Failed
        $credentials = [
            'email' => 'xxxx@xxxx.com',
            'password' => 'new-password'
        ];
        $response = $this->post('/backend/login', $credentials);

        $response->assertSessionHasErrors(['email']);
        $this->assertInvalidCredentials($credentials);

        $user = User::role('admin')->first();
        $this->actingAs($user);

        // Change Password
        $response = $this->patch('/backend/user/10', [
            'name' => 'edited name',
            'email' => 'xxxx@xxxx.com',
            'password' => 'new-password',
            'password_confirmation' => 'new-password',
            'status' => 'active'
        ]);
        // dd(session()->get('errors'));
        $response->assertSessionHas('user-updated', true);
        $response->assertRedirect('/backend/user');

        // logout
        $this->post('/backend/logout');

        // Login with new password
        $credentials = [
            'email' => 'xxxx@xxxx.com',
            'password' => 'new-password'
        ];
        $response = $this->post('/backend/login', $credentials);

        $response->assertSessionHasNoErrors();
        $this->assertCredentials($credentials);
        $this->assertAuthenticatedAs(User::find(10));
    }

    /** @test */
    public function cannot_create_duplicated_email()
    {
        factory(User::class)->create([
            'name' => 'test user',
            'email' => 'test@example.com',
            'password' => bcrypt('password'),
            'status' => 'active'
        ]);

        $this->actingAs(User::role('admin')->first());

        $userData = factory(User::class)->raw([
            'name' => 'test user',
            'email' => 'test@example.com',
            'password' => 'password',
            'password_confirmation' => 'password',
            'status' => 'active'
        ]);

        $response = $this->post('/backend/user', $userData);
        $response->assertSessionHasErrors('email');
        $this->assertDatabaseMissing('users', [
            'name' => 'test user',
            'email' => 'test1@example.com',
        ]);

        $userData['email'] = 'test1@example.com';

        $response = $this->post('/backend/user', $userData);
        $response->assertSessionHas('user-created', true);
        $response->assertRedirect('/backend/user');

        $this->assertDatabaseHas('users', [
            'name' => 'test user',
            'email' => 'test1@example.com',
        ]);
    }

    /** @test */
    public function cannot_edit_duplicated_email()
    {
        factory(User::class)->create([
            'name' => 'test user',
            'email' => 'test@example.com',
            'password' => bcrypt('password'),
            'status' => 'active'
        ]);

        factory(User::class)->create([
            'id' => 10,
            'name' => 'test user 2',
            'status' => 'active'
        ]);

        $this->actingAs(User::role('admin')->first());

        $userData = factory(User::class)->raw([
            'name' => 'test user',
            'email' => 'test@example.com',
            'password' => 'password',
            'password_confirmation' => 'password',
            'status' => 'active'
        ]);

        $response = $this->patch('/backend/user/10', $userData);
        $response->assertSessionHasErrors('email');

        $userData['email'] = 'test1@example.com';

        $response = $this->patch('/backend/user/10', $userData);
        $response->assertSessionHas('user-updated', true);
        $response->assertRedirect('/backend/user');

        $this->assertDatabaseHas('users', [
            'name' => 'test user',
            'email' => 'test1@example.com',
        ]);
    }

    /** @test */
    public function user_created_can_have_roles()
    {
        $this->actingAs(User::role('admin')->first());

        $userData = factory(User::class)->raw([
            'email' => 'test@test.com',
            'password' => 'password',
            'password_confirmation' => 'password'
        ]);

        $userData['roles'] = ['general user'];

        $response = $this->post('/backend/user', $userData);
        $response->assertSessionHasNoErrors();
        $response->assertSessionHas('user-created', true);
        $response->assertRedirect('/backend/user');

        // user has correct roles
        $user = User::whereEmail('test@test.com')->first();
        $this->assertEquals($user->getRoleNames()->toArray(), $userData['roles']);
    }

    /** @test */
    public function user_edited_can_change_roles()
    {
        // $this->withoutExceptionHandling();
        $user = factory(User::class)->create([
            'id' => 10
        ])->assignRole('general user');

        $this->assertEquals($user->getRoleNames()->toArray(), ['general user']);

        $this->actingAs(User::role('admin')->first());

        $userData = factory(User::class)->raw([
            'name' => 'test user',
            'email' => 'test@test.com',
            'password' => null
        ]);

        $userData['roles'] = ['admin'];

        $response = $this->patch('/backend/user/10', $userData);
        $response->assertSessionHasNoErrors();
        $response->assertSessionHas('user-updated', true);
        $response->assertRedirect('/backend/user');

        // user has correct roles
        $user = User::whereEmail('test@test.com')->first();
        $this->assertEquals($user->getRoleNames()->toArray(), $userData['roles']);
    }

    /** @test */
    public function user_can_be_deleted()
    {
        factory(User::class)->create([
            'id' => 10,
            'status' => 'active'
        ]);

        $this->actingAs(User::role('admin')->first());

        $this->assertCount(1, User::whereId(10)->get());

        $response = $this->delete('/backend/user/10');
        $response->assertSessionHasNoErrors();
        $response->assertSessionHas('user-deleted', true);
        $response->assertRedirect('/backend/user');

        $this->assertCount(0, User::whereId(10)->get());
        // only trash
        $this->assertCount(1, User::onlyTrashed()->whereId(10)->get());
    }
}