<?php

namespace App\Http\Controllers\CRM;

use App\Http\Controllers\Controller;
use App\Models\Client;
use App\Models\CRM\Tax;
use App\Models\Project;
use Illuminate\Http\Request;

class InvoiceController extends Controller
{
    public function index()
    {
        $clients = Client::select('id','first_name','last_name')->get();
        $taxes = Tax::select('id','name')->get();

        return view('crm.sale_section.invoices.index', compact('clients','taxes'));
    }
}
