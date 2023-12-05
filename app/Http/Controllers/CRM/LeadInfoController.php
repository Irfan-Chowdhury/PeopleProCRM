<?php

namespace App\Http\Controllers\CRM;

use App\Http\Controllers\Controller;
use App\Models\CRM\Lead;
use Illuminate\Http\Request;

class LeadInfoController extends Controller
{
    public function show(Lead $lead)
    {
        // return $lead;
        return view('crm.lead_section.lead_info.show', compact('lead'));
    }
}
