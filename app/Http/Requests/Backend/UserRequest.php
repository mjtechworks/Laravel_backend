<?php

namespace App\Http\Requests\Backend;

use App\Model\User;
use Illuminate\Foundation\Http\FormRequest;

class UserRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        switch($this->method())
        {
            case 'GET':
            case 'DELETE':
            {
                return [];
            }
            case 'POST':
            {
                $rules = [
                    'password' => 'required|string|min:8|confirmed'
                ];
                return $this->getMergedRule($rules);
            }
            case 'PUT':
            case 'PATCH':
            {
                $rules['email'] = 'required|string|email|unique:users,email,' . $this->route('user')->id;
                if (request()->filled('password')) {
                    $rules['password'] = 'required|string|min:8|confirmed';
                }

                return $this->getMergedRule($rules);
            }
            default:break;
        }
    }

    protected function getMergedRule($rules = array())
    {
        $resultRules = [
            'email' => 'required|string|email|max:255|unique:users',
            'name' => 'required|string|max:50',
            'profile_image_file' => 'sometimes|file|mimes:jpeg,png|max:2048',
            'roles.*' => 'sometimes|exists:roles,name',
            'status' => 'required|in:' . implode_array_keys(',', User::statusOptions()),
        ];

        if (! empty($rules))
            return array_merge($resultRules, $rules);

        return $resultRules;
    }
}
