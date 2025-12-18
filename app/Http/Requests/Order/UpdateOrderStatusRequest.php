<?php

namespace App\Http\Requests\Order;

use Illuminate\Foundation\Http\FormRequest;

class UpdateOrderStatusRequest extends FormRequest
{
    public function authorize()
    {
        return true; // Add auth/policy logic later
    }

    public function rules()
    {
        return [
            'status' => 'required|string|in:pending,processing,shipped,delivered,cancelled'
        ];
    }
}
