<?php

namespace App\Http\Requests\Role;

use Illuminate\Foundation\Http\FormRequest;

class RoleRequest extends FormRequest
{
    public function authorize()
    {
        return true; // You already handle permissions in controller middleware
    }

    public function rules()
    {
        return [
            'name' => 'required',
            'permissions' => 'required|array',
        ];
    }
}
