<?php

namespace App\Http\Requests\Category;

use Illuminate\Foundation\Http\FormRequest;

class CategoryUpdateRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $id = $this->category->id;

        return [
            'name' => "required|string|max:255|unique:categories,name,$id",
            'parent_id' => 'nullable|exists:categories,id|not_in:' . $id,
            'description' => 'nullable|string',
        ];
    }
}
