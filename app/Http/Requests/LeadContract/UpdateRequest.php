<?php

namespace App\Http\Requests\LeadContract;

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
            'title' => 'required|string|unique:lead_contracts,title,'.$this->model_id.',id,deleted_at,NULL',
            'start_date' => 'required|date',
            'end_date' => 'required|date',
            'project_id' => 'required',
            'tax_id' => 'required',
        ];
    }
}
