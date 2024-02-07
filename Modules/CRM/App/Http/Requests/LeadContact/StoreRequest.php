<?php

namespace Modules\CRM\App\Http\Requests\LeadContact;

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

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'first_name' => 'required',
            'last_name' => 'required',
            'email' => 'required|email|max:50|unique:lead_contacts,email,NULL,id,deleted_at,NULL',
            'phone' => 'required|numeric',
            'address' => 'required',
            'gender' => 'required',
            'job_title' => 'required',
            'image' => 'nullable|image|mimes:jpg,jpeg,png,gif|max:100000',
        ];
    }
}
