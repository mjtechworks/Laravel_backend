<?php

namespace App\Http\Requests\Backend;

use Illuminate\Foundation\Http\FormRequest;

class ProfileRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'name' => 'required|string|max:50',
            'email' => 'required|string|email|unique:users,email,' . auth()->id(),
            'profile_image_file' => 'sometimes|file|mimes:jpeg,png|max:2048',
            'old_password' => 'nullable|password:web',
            'password' => 'nullable|required_with:old_password|string|min:8|confirmed'
        ];
    }

    public function messages()
    {
        return [
            'old_password.password' => 'The old password is incorrect!',
        ];
    }
}
