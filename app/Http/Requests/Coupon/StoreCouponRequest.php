<?php

namespace App\Http\Requests\Coupon;

use Illuminate\Foundation\Http\FormRequest;

class StoreCouponRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true; // restrict via middleware
    }

    public function rules(): array
    {
        return [
            'code' => 'required|unique:coupons,code',
            'type' => 'required|in:percentage,flat',
            'value' => 'required|numeric|min:1',
            'min_order_amount' => 'nullable|numeric|min:0',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after:start_date',
            'usage_limit' => 'nullable|integer',
            'is_active' => 'required|boolean'
        ];
    }
}
