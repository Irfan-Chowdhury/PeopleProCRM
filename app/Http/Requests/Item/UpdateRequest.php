<?php

namespace App\Http\Requests\Item;

use Illuminate\Foundation\Http\FormRequest;

class UpdateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'item_category_id' => 'required',
            'title' => 'required|string|max:255|unique:items,title,'.$this->model_id.',id,deleted_at,NULL',
            'description' => 'nullable|string',
            'unit_type' => 'required',
            'rate' => 'required|numeric',
            'is_client_visible' => 'nullable',
            'image' => 'nullable|image|mimes:jpg,jpeg,png,gif|max:100000',
        ];
    }
}
