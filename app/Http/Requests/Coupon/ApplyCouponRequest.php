<?php

namespace App\Http\Requests\Coupon;

use Illuminate\Foundation\Http\FormRequest;

class ApplyCouponRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }
    public function rules(): array
    {
        return [
            'coupon_code' => 'required|string|max:50',
            'order_total' => 'required|numeric|min:1',
        ];
    }
}
