<?php

namespace Modules\CRM\App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Invoice;
use App\Models\Project;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class ReportController extends Controller
{
    public function invoice(Request $request)
    {
        $projects = Project::select('id','title')->get();

        if($request->status) {
            $data = Invoice::with('project:id,title', 'invoicePayment')
                ->whereHas('invoicePayment', function ($query) use ($request) {
                    $query->where('payment_status', $request->status);
                })
                ->orderBy('id', 'DESC')
                ->get();
        }
        else if($request->project_id) {
            $data = Invoice::with('project:id,title', 'invoicePayment')
                    ->where('project_id', $request->project_id)
                ->orderBy('id', 'DESC')
                ->get();

        }
         else {
            $data = Invoice::with('project:id,title','invoicePayment')->orderBy('id','DESC')->get();
        }

        if (request()->ajax())
        {
            return datatables()->of($data)
                ->setRowId(function ($invoice)
                {
                    return $invoice->id;
                })
                ->addColumn('project', function ($row)
                {
                    $project_name = empty($row->project->title) ? '' : $row->project->title;

                    return $project_name;
                })
                ->addColumn('payment_status',function ($row)
                {
                    if (!$row->invoicePayment) {
                        return '<span class="p-1 badge badge-pill badge-secondary">None</span>';
                    }
                    else {

                        $btnColor = '';
                        if($row->invoicePayment->payment_status=='pending'){
                            $btnColor = 'danger';
                        }else if($row->invoicePayment->payment_status=='canceled'){
                            $btnColor = 'warning';
                        }else if($row->invoicePayment->payment_status=='completed'){
                            $btnColor = 'success';
                        }
                        return '<span class="p-1 badge badge-pill badge-'.$btnColor.'">'.ucwords(str_replace('_', ' ',$row->invoicePayment->payment_status))."</span>";
                    }
                })

                ->rawColumns(['action','payment_status'])
                ->make(true);
        }

        return view('crm::report.invoice', compact('projects'));
    }


}
