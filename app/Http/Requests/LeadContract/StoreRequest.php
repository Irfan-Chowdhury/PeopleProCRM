<?php

namespace App\Http\Requests\LeadContract;

use Illuminate\Foundation\Http\FormRequest;

class StoreRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }


    public function rules(): array
    {
        return [
            'title' => 'required|string|max:255|unique:lead_contracts,title,NULL,id,deleted_at,NULL',
            'start_date' => 'required|date',
            'end_date' => 'required|date',
            'project_id' => 'required',
            'tax_id' => 'required',
        ];
    }
}
