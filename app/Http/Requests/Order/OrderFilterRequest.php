<?php

namespace App\Http\Requests\Orders;

use Illuminate\Foundation\Http\FormRequest;

class OrderFilterRequest extends FormRequest
{
    public function authorize()
    {
        return true; // allow all admins
    }

    public function rules()
    {
        return [
            'filter' => 'nullable|in:all,paid,delivered,cancelled'
        ];
    }
}
