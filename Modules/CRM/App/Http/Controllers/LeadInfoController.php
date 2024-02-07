<?php

namespace Modules\CRM\App\Http\Controllers;

use App\Http\Controllers\Controller;
use Modules\CRM\App\Models\Lead;

class LeadInfoController extends Controller
{
    public function show(Lead $lead)
    {
        return view('crm::lead_section.lead_info.show', compact('lead'));
    }
}
