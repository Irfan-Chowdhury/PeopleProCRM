<?php

namespace Modules\CRM\App\Http\Requests\Lead;

use Illuminate\Foundation\Http\FormRequest;

class UpdateRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'company_id' => 'required',
            'employee_id' => 'required',
            'status' => 'required',
            'country_id' => 'required',
            'city' => 'required',
            'state' => 'required',
            'zip' => 'required',
            'address' => 'required',
            'phone' => 'required',
            'vat_number' => 'required',
        ];
    }
}
