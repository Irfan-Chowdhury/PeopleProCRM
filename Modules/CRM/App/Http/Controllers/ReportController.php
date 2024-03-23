<?php

namespace Modules\CRM\App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Client;
use App\Models\Employee;
use App\Models\Invoice;
use App\Models\Project;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
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
    public function teamProjectReport(Request $request)
    {
        $employees = Employee::select('id', 'first_name', 'last_name')->get();
        $projects = Project::select('id', 'title')->get();

        $data = DB::table('employee_project')
                ->select(
                    'employees.id AS employee_id',
                    DB::raw('CONCAT(employees.first_name," ",employees.last_name) AS employee_name'),

                    'clients.id AS client_id',
                    DB::raw('CONCAT(clients.first_name," ",clients.last_name) AS client_name'),

                    'projects.id AS project_id',
                    'projects.title AS project_title',
                    'projects.project_priority',
                    'projects.start_date',
                    'projects.end_date'
                )
                ->join('employees','employees.id','employee_project.employee_id')
                ->join('projects','projects.id','employee_project.project_id')
                ->join('clients','clients.id','projects.client_id')
                ->get();

        if($request->employee_id) {
            $data = DB::table('employee_project')
            ->select(
                'employees.id AS employee_id',
                DB::raw('CONCAT(employees.first_name," ",employees.last_name) AS employee_name'),

                'clients.id AS client_id',
                DB::raw('CONCAT(clients.first_name," ",clients.last_name) AS client_name'),

                'projects.id AS project_id',
                'projects.title AS project_title',
                'projects.project_priority',
                'projects.start_date',
                'projects.end_date'
            )
            ->join('employees','employees.id','employee_project.employee_id')
            ->join('projects','projects.id','employee_project.project_id')
            ->join('clients','clients.id','projects.client_id')
            ->where('employee_project.employee_id', $request->employee_id)
            ->get();
        }
        else if($request->project_id) {
            $data = DB::table('employee_project')
            ->select(
                'employees.id AS employee_id',
                DB::raw('CONCAT(employees.first_name," ",employees.last_name) AS employee_name'),

                'clients.id AS client_id',
                DB::raw('CONCAT(clients.first_name," ",clients.last_name) AS client_name'),

                'projects.id AS project_id',
                'projects.title AS project_title',
                'projects.project_priority',
                'projects.start_date',
                'projects.end_date'
            )
            ->join('employees','employees.id','employee_project.employee_id')
            ->join('projects','projects.id','employee_project.project_id')
            ->join('clients','clients.id','projects.client_id')
            ->where('employee_project.project_id', $request->project_id)
            ->get();
        }
        else {
            $data = DB::table('employee_project')
            ->select(
                'employees.id AS employee_id',
                DB::raw('CONCAT(employees.first_name," ",employees.last_name) AS employee_name'),

                'clients.id AS client_id',
                DB::raw('CONCAT(clients.first_name," ",clients.last_name) AS client_name'),

                'projects.id AS project_id',
                'projects.title AS project_title',
                'projects.project_priority',
                'projects.start_date',
                'projects.end_date'
            )
            ->join('employees','employees.id','employee_project.employee_id')
            ->join('projects','projects.id','employee_project.project_id')
            ->join('clients','clients.id','projects.client_id')
            ->get();
        }

        if (request()->ajax()){

            return datatables()->of($data)
                ->setRowId(function ($project)
                {
                    return $project->project_id;
                })
                ->addColumn('project_title', function ($row)
                {
                    return $row->project_title;
                })
                ->addColumn('client', function ($row)
                {
                    return $row->client_name;
                })
                ->addColumn('assigned_employee', function ($row)
                {
                    return $row->employee_name;
                })
                ->make(true);
        }

        return view('crm::report.project', compact('employees','projects'));
    }

    public function clientProjectReport(Request $request)
	{
		$logged_user = auth()->user();
		$clients = Client::select('id', 'first_name', 'last_name')->get();
        $projects = Project::with('client:id,first_name,last_name', 'assignedEmployees')->get();

        if($request->client_id) {
            $projects = Project::with('client:id,first_name,last_name', 'assignedEmployees')
                        ->whereHas('client', function ($query) use ($request) {
                            $query->where('id', $request->client_id);
                        })
                        ->get();
        }
        else if($request->project_id) {
            $projects = Project::with('client:id,first_name,last_name', 'assignedEmployees')
                        ->where('id', $request->project_id)
                        ->get();
        }else {
            $projects = Project::with('client:id,first_name,last_name', 'assignedEmployees')->get();
        }

        if (request()->ajax()){

            return datatables()->of($projects)
                ->setRowId(function ($project)
                {
                    return $project->id;
                })
                ->addColumn('summary', function ($row)
                {
                    return '<br><h6><a href="' . route('projects.show', $row->id) . '">' . $row->title . '</a></h6>';
                })
                ->addColumn('client', function ($row)
                {
                    if ($row->client_id!=NULL) {
                        return $row->client->first_name.' '.$row->client->last_name;
                    }else{
                        return " ";
                    }

                })
                ->addColumn('assigned_employee', function ($row)
                {
                    $assigned_name = $row->assignedEmployees()->pluck('last_name', 'first_name');
                    $collection = [];
                    foreach ($assigned_name as $first => $last)
                    {
                        $full_name = $first . ' ' . $last;
                        array_push($collection, $full_name);
                    }

                    return $collection;
                })
                ->rawColumns(['action', 'summary'])
                ->make(true);
        }

        return view('crm::report.client-project', compact('clients','projects'));



	}
}
