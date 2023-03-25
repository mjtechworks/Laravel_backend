<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Http\Requests\Backend\RoleRequest;
use App\Model\Backend\Role;
use App\ViewModels\Backend\RoleFormViewModel;

class RoleController extends Controller
{
    public function index()
    {
        $this->authorize('access role list');

        $contentHeader = [
            'title' => 'Role',
            'subtitle' => 'Role List',
            'bcs' => [
                [
                    'title' => 'Role List',
                    'active' => true
                ]
            ]
        ];

        return view('backend.role.index', compact('contentHeader'));
    }

    public function listData()
    {
        $this->authorize('access role list');

        $role = Role::query()
            ->withCount('users')
            ->withCount('permissions');

        return datatables()
            ->eloquent($role)
            ->addColumns([
                'display_created_at_full_thai',
                'edit_link',
                'destroy_link'
            ])
            ->orderColumn('display_created_at_full_thai', 'created_at $1')
            ->toJson();
    }

    public function create()
    {
        $this->authorize('add role list');

        $contentHeader = [
            'title' => 'Add Role',
            'bcs' => [
                [
                    'title' => 'Role List',
                    'link' => route('backend.role.index')
                ],
                [
                    'title' => 'Add Role',
                    'active' => true
                ],
            ]
        ];
        return view('backend.role.create', new RoleFormViewModel($contentHeader));
    }

    public function store(RoleRequest $request)
    {
        $this->authorize('add role list');

        $validatedData = $request->validated();

        $role = Role::create([
            'name' => $validatedData['name']
        ]);

        $this->storePermissions($role);

        $alert = [
            'role-created' => true,
            'alert-type' => 'success',
            'alert-message' => 'Role is created!',
        ];

        return redirect(route('backend.role.index'))->with($alert);
    }

    public function show(Role $role)
    {
        //
    }

    public function edit(Role $role)
    {
        $this->authorize('edit role list');

        $contentHeader = [
            'title' => 'Edit Role',
            'bcs' => [
                [
                    'title' => 'Role List',
                    'link' => route('backend.role.index')
                ],
                [
                    'title' => 'Edit Role',
                    'active' => true
                ],
            ]
        ];

        return view('backend.role.edit', new RoleFormViewModel($contentHeader, $role));
    }

    public function update(RoleRequest $request, Role $role)
    {
        $this->authorize('edit role list');

        $validatedData = $request->validated();

        $role->update([
            'name' => $validatedData['name']
        ]);

        $this->storePermissions($role);

        $alert = [
            'role-updated' => true,
            'alert-type' => 'success',
            'alert-message' => 'Role is updated!',
        ];

        return redirect(route('backend.role.index'))->with($alert);
    }

    public function destroy(Role $role)
    {
        $this->authorize('delete role list');

        $role->delete();

        $alert = [
            'role-deleted' => true,
            'alert-type' => 'success',
            'alert-message' => 'Successfully deleted!',
        ];

        return redirect(route('backend.role.index'))->with($alert);
    }

    public function isValidName()
    {
        $this->authorize('access role list');

        $exceptId = request()->has('id') ? ',' . request('id') : '' ;

        $validator = \Illuminate\Support\Facades\Validator::make(request()->all(), [
            'name' => 'required|string|max:255|unique:roles,name' . $exceptId,
            'id' => 'sometimes|exists:roles'
        ]);

        return $validator->fails() ? 'false' : 'true' ;
    }

    private function storePermissions($role)
    {
        $permissions = request()->has('permissions') ? request('permissions') : [] ;
        $role->syncPermissions($permissions);
    }
}
