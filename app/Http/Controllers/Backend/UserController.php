<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Http\Requests\Backend\UserRequest;
use App\Model\User;
use App\ViewModels\Backend\UserFormViewModel;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index()
    {
        $this->authorize('access user list');

        $contentHeader = [
            'title' => 'User',
            'subtitle' => 'User List',
            'bcs' => [
                [
                    'title' => 'User List',
                    'active' => true
                ]
            ]
        ];

        return view('backend.user.index', compact('contentHeader'));
    }

    public function listData()
    {
        $this->authorize('access user list');

        $user = User::query()
            ->when(request('status'), function ($query) {
                return $query->where('status', request('status'));
            })
            ->when(request('role'), function ($query) {
                // ไม่มี (filtered from 102 total entries) ด้านล่าง ต่างจากใช้ ->filter()
                return $query->role(request('role'));
            })
            ->with('roles');

        return datatables()
            ->eloquent($user)
            ->filterColumn('role_names', function($query, $keyword) {
                $query->whereHas('roles', function($query) use ($keyword) {
                    $query->where('name', 'like', '%' . $keyword . '%');
                });
            })
            /*
            ->filter(function ($query) { 
                // มี (filtered from 102 total entries) ด้านล่าง
                if (request()->filled('role')) {
                    $query->role(request('role'));
                }
            }, true)
            */
            ->addColumns([
                'display_status',
                'display_created_at_full_thai',
                'edit_link',
                'destroy_link'
            ])
            ->addColumn('avatar_thumb', function(User $user) {
                return '<img src="' . $user->avatar_thumb .'" height="30"/>';
            })
            ->addColumn('role_names', function(User $user) {
                return $user->roles->implode('name', ', ');
            })
            ->rawColumns(['avatar_thumb'])
            ->orderColumn('display_created_at_full_thai', 'created_at $1')
            ->toJson();
    }

    public function create()
    {
        $this->authorize('add user list');

        $contentHeader = [
            'title' => 'Add User',
            'bcs' => [
                [
                    'title' => 'User List',
                    'link' => route('backend.user.index')
                ],
                [
                    'title' => 'Add User',
                    'active' => true
                ],
            ]
        ];

        return view('backend.user.create', new UserFormViewModel($contentHeader));
    }

    public function store(UserRequest $request)
    {
        $this->authorize('add user list');

        $user = User::create($request->validated());
        $user->storeAvatar();
        $user->storeRoles();

        $alert = [
            'user-created' => true,
            'alert-type' => 'success',
            'alert-message' => 'User is created!',
        ];

        return redirect(route('backend.user.index'))->with($alert);
    }

    public function show(User $user)
    {
        //
    }

    public function edit(User $user)
    {
        $this->authorize('edit user list');

        $contentHeader = [
            'title' => 'Edit User',
            'bcs' => [
                [
                    'title' => 'User List',
                    'link' => route('backend.user.index')
                ],
                [
                    'title' => 'Edit User',
                    'active' => true
                ],
            ]
        ];

        return view('backend.user.edit', new UserFormViewModel($contentHeader, $user));
    }

    public function update(UserRequest $request, User $user)
    {
        $this->authorize('edit user list');

        $user->update($request->validated());
        $user->storeAvatar();
        $user->storeRoles();

        $alert = [
            'user-updated' => true,
            'alert-type' => 'success',
            'alert-message' => 'User is updated!',
        ];

        return redirect(route('backend.user.index'))->with($alert);
    }

    public function destroy(User $user)
    {
        $this->authorize('delete user list');

        $user->delete();

        $alert = [
            'user-deleted' => true,
            'alert-type' => 'success',
            'alert-message' => 'Successfully deleted!',
        ];

        return redirect(route('backend.user.index'))->with($alert);
    }

    public function export()
    {
        $this->authorize('export user list');

        return \Maatwebsite\Excel\Facades\Excel::download(new \App\Exports\Backend\UserExport, 'users.xlsx');
    }

    public function isValidEmail()
    {
        $exceptId = request()->has('id') ? ',' . request('id') : '' ;

        $validator = \Illuminate\Support\Facades\Validator::make(request()->all(), [
            'email' => 'required|email|max:255|unique:users,email' . $exceptId,
            'id' => 'sometimes|exists:users'
        ]);

        if ($validator->fails()) {
            return 'false';
        }

        return 'true';
    }
}
