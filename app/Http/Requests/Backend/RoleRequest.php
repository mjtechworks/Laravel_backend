<?php

namespace App\Http\Requests\Backend;

use Illuminate\Foundation\Http\FormRequest;

class RoleRequest extends FormRequest
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
                return $this->getMergedRule();
            }
            case 'PUT':
            case 'PATCH':
            {
                $rules = [
                    'name' => 'required|string|unique:roles,name,' . $this->route('role')->id
                ];
                return $this->getMergedRule($rules);
            }
            default:break;
        }
    }

    private function getMergedRule($rules = array())
    {
        $resultRules = [
            'name' => 'required|string|max:255|unique:roles',
            'permissions.*' => 'sometimes|exists:permissions,name'
        ];

        if (! empty($rules))
            return array_merge($resultRules, $rules);

        return $resultRules;
    }
}
