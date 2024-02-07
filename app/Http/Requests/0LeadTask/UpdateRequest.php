<?php

namespace App\Http\Requests\LeadTask;

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
            'title' => 'required',
            'description' => 'required',
            'points' => 'required',
            'employee_id' => 'required',
            'status' => 'required',
            'priority' => 'required',
            'start_date' => 'required|date',
            'end_date' => 'required|date',
        ];
    }
}
