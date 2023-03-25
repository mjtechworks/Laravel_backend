<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Http\Requests\Backend\ProfileRequest;
use App\Model\User;
use Illuminate\Http\Request;

class ProfileController extends Controller
{
    public function edit()
    {
        $contentHeader = [
            'title' => 'Edit Profile',
            'bcs' => [
                [
                    'title' => 'Edit Profile',
                    'active' => true
                ]
            ]
        ];

        $user = auth()->user();

        return view('backend.profile.edit', compact('contentHeader', 'user'));
    }

    public function update(ProfileRequest $request)
    {
        $validatedData = $request->validated();

        if (empty(request('password'))) {
            unset($validatedData['password']);
        }

        auth()->user()->update($validatedData);
        auth()->user()->storeAvatar();

        $alert = [
            'profile-updated' => true,
            'alert-type' => 'success',
            'alert-message' => 'Profile is updated!',
        ];

        return redirect(route('backend.profile.edit'))->with($alert);
    }
}
