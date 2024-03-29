<?php

namespace Modules\CRM\App\Http\Requests\Subscription;

use Illuminate\Foundation\Http\FormRequest;

class StoreRequest extends FormRequest
{

    public function authorize(): bool
    {
        return true;
    }


    public function rules(): array
    {
        return [
            'title' => 'required|string|max:255|unique:subscriptions,title,NULL,id,deleted_at,NULL',
            'first_billing_date' => 'required|date',
            'repeat_type' => 'required',
            'client_id' => 'required',
            'tax_type_id' => 'required',
            'note' => 'nullable',
        ];
    }
}
