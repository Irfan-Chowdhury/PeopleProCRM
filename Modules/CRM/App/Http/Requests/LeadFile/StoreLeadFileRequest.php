<?php

namespace Modules\CRM\App\Http\Requests\LeadFile;

use Illuminate\Foundation\Http\FormRequest;

class StoreLeadFileRequest extends FormRequest
{

    public function rules(): array
    {
        return [
            'file_title' => 'required',
		    'file_attachment' => 'required|file|max:10240|mimes:jpeg,png,jpg,gif,ppt,pptx,doc,docx,pdf',
        ];
    }

    public function authorize(): bool
    {
        return true;
    }
}
