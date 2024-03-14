<?php

namespace Modules\CRM\App\Http\Requests\InvoicePayment;

use Illuminate\Foundation\Http\FormRequest;

class StoreInvoicePaymentRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     */
    public function rules(): array
    {
        return [
            'invoice_id' => 'required|unique:invoice_payments,invoice_id',
            'payment_method' => 'required',
            'payment_date' => 'required|date',
            'payment_status' => 'required',
        ];
    }

    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }
}
