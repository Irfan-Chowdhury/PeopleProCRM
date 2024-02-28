<?php

namespace Modules\CRM\App\Http\Requests\ProspectProposal;

use Illuminate\Foundation\Http\FormRequest;

class UpdateProposalRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'start_date' => 'required|date',
            'end_date' => 'required|date',
            'tax_type_id' => 'required',
            'candidate' => 'required',
        ];
    }

    public function authorize(): bool
    {
        return true;
    }
}
