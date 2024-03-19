<?php

namespace Modules\CRM\App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Invoice;
use App\Models\Project;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Modules\CRM\App\Models\InvoicePayment;

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

    public function invoicePayment(Request $request)
    {
        if($request->status) {
            $data = InvoicePayment::with('invoice:id,invoice_number,client_id')
                    ->where('payment_status', $request->status)
                    ->orderBy('id','DESC')->get();
        }
        else if($request->date) {
            $data = InvoicePayment::with('invoice:id,invoice_number,client_id')
                    ->where('date', date('Y-m-d', strtotime($request->date)))
                    ->orderBy('id','DESC')->get();
        }
        else {
            $data = InvoicePayment::with('invoice:id,invoice_number,client_id')->orderBy('id','DESC')->get();
        }

        if (request()->ajax()) {
			return datatables()->of($data)
				->setRowId(function ($row)
				{
					return $row->id;
				})
                ->addColumn('invoiceId',function ($row)
                {
                    return $row->invoice->invoice_number ?? " ";
                })
                ->addColumn('payment_date',function ($row)
                {
                    return $row->date;
                })
                ->addColumn('payment_method',function ($row)
                {
                    return ucfirst($row->payment_method);
                })
                ->addColumn('amount',function ($row)
                {
                    return $row->amount;
                })
                ->addColumn('payment_status',function ($row)
                {
                    $btnColor = '';
                    if($row->payment_status=='pending'){
                        $btnColor = 'danger';
                    }else if($row->payment_status=='canceled'){
                        $btnColor = 'warning';
                    }else if($row->payment_status=='completed'){
                        $btnColor = 'success';
                    }

                    return '<span class="p-1 badge badge-pill badge-'.$btnColor.'">'.ucwords(str_replace('_', ' ',$row->payment_status))."</span>";
                })
				->addColumn('action', function ($data)
                {
                    return '<button type="button" data-id="'.$data->id.'" class="delete btn btn-danger btn-sm"><i class="dripicons-trash"></i></button>';
                })
                ->rawColumns(['payment_status','action'])
                ->make(true);
		}

        return view('crm::report.invoice-payment');
    }


}
