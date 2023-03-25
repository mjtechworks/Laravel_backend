<?php

namespace Tests\Feature\Backend;

use App\Model\Backend\Permission;
use App\Model\Backend\Role;
use App\Model\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class RoleManagementTest extends TestCase
{
    use RefreshDatabase;

    public function setUp(): void
    {
        parent::setUp();

        $this->seed();
        $this->seed('UserRolePermissionSeeder');
    }

    /** @test */
    public function role_list_page_can_be_displayed()
    {
        $this->actingAs(User::role('admin')->first());

        $response = $this->get('/backend/role');
        $response->assertOK();
        $response->assertViewIs('backend.role.index');
    }

    /** @test */
    public function role_create_page_can_be_displayed()
    {
        $this->actingAs(User::role('admin')->first());

        $response = $this->get('/backend/role/create');
        $response->assertOK();
        $response->assertViewIs('backend.role.create');
    }

    /** @test */
    public function role_edit_page_can_be_displayed()
    {
        $this->actingAs(User::role('admin')->first());

        $response = $this->get('/backend/role/1/edit');
        $response->assertOK();
        $response->assertViewIs('backend.role.edit');
    }

    /** @test */
    public function allowed_user_can_access_to_role_page()
    {
        $user = factory(User::class)->create([
            'status' => 'active'
        ]);
        $this->actingAs($user);

        $this->get('/backend/role')
            ->assertForbidden();
            // ->assertStatus(302)
            // ->assertRedirect('/backend/login');
        $this->get('/backend/role/create')
            ->assertForbidden();
            // ->assertStatus(302)
            // ->assertRedirect('/backend/login');
        $this->get('/backend/role/1/edit')
            ->assertForbidden();
            // ->assertStatus(302)
            // ->assertRedirect('/backend/login');

        $role = Role::create(['name' => 'role-test']);

        $role->syncPermissions([
            'access role list',
            'add role list',
            'edit role list',
        ]);

        $user->assignRole('role-test');

        $this->get('/backend/role')
            ->assertOK()
            ->assertViewIs('backend.role.index');

        $this->get('/backend/role/create')
            ->assertOK()
            ->assertViewIs('backend.role.create');

        $this->get('/backend/role/1/edit')
            ->assertOK()
            ->assertViewIs('backend.role.edit');
    }

    /** @test */
    public function role_can_be_created()
    {
        $this->actingAs(User::role('admin')->first());

        $response = $this->post('/backend/role', ['name' => 'test role']);
        $response->assertSessionHas('role-created', true);
        $response->assertRedirect('/backend/role');

        $this->assertDatabaseHas('roles', [
            'name' => 'test role'
        ]);
    }

    /** @test */
    public function role_cannot_duplicated_name()
    {
        $this->actingAs(User::role('admin')->first());

        factory(Role::class)->create([
            'name' => 'test role'
        ]);

        $this->assertCount(1, Role::whereName('test role')->get());

        $response = $this->post('/backend/role', ['name' => 'test role']);
        $response->assertSessionHasErrors('name');

        $this->assertCount(1, Role::whereName('test role')->get());
    }

    /** @test */
    public function role_can_be_edited()
    {
        $this->actingAs(User::role('admin')->first());

        $role = factory(Role::class)->create([
            'name' => 'test role',
        ]);

        $this->assertDatabaseMissing('roles', [
            'name' => 'edited role'
        ]);

        $response = $this->patch('/backend/role/' . $role->id, [
            'name' => 'edited role'
        ]);

        $response->assertSessionHas('role-updated', true);
        $response->assertRedirect('/backend/role');

        $this->assertDatabaseHas('roles', [
            'name' => 'edited role'
        ]);
    }

    /** @test */
    public function role_created_with_multiple_permissions()
    {
        $this->actingAs(User::role('admin')->first());

        $permissions = factory(Permission::class, 5)->create();

        $response = $this->post('/backend/role', [
            'name' => 'test role',
            'permissions' => $permissions->pluck('name')->toArray()
        ]);
        $response->assertSessionHas('role-created', true);
        $response->assertRedirect('/backend/role');

        $latestRole = Role::whereName('test role')->first();
        $this->assertCount(5, $latestRole->getPermissionNames());
    }

    /** @test */
    public function role_edited_with_multiple_permissions()
    {
        // $this->withoutExceptionHandling();

        $this->actingAs(User::role('admin')->first());

        $role = factory(Role::class)->create();
        $permissions = factory(Permission::class, 5)->create()->pluck('name');

        $this->assertCount(0, $role->getPermissionNames());
        $role->syncPermissions($permissions);
        $this->assertCount(5, $role->getPermissionNames());

        $permissions->splice(3);

        $response = $this->patch('/backend/role/' . $role->id, [
            'name' => 'test role',
            'permissions' => $permissions->toArray()
        ]);
        $response->assertSessionHas('role-updated', true);
        $response->assertRedirect('/backend/role');

        $role->refresh();
        $this->assertCount(3, $role->getPermissionNames());
    }

    /** @test */
    public function role_can_be_deleted()
    {
        $this->actingAs(User::role('admin')->first());

        $role = factory(Role::class)->create();

        $this->assertDatabaseHas('roles', [
            'id' => $role->id
        ]);

        $response = $this->delete('/backend/role/' . $role->id);
        $response->assertSessionHas('role-deleted', true);
        $response->assertRedirect('/backend/role');

        $this->assertDatabaseMissing('roles', [
            'id' => $role->id
        ]);
    }
}
