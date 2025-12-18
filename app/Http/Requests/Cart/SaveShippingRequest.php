<?php

namespace App\Http\Requests\Cart;

use Illuminate\Foundation\Http\FormRequest;

class SaveShippingRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'shipping.full_name' => 'required|string|max:255',
            'shipping.email'     => 'required|email',
            'shipping.phone'     => 'required|string|max:20',
            'shipping.address'   => 'required|string|max:255',
            'shipping.city'      => 'required|string|max:100',
            'shipping.state'     => 'required|string|max:100',
            'shipping.pincode'   => 'required|string|size:6',
        ];
    }
}
