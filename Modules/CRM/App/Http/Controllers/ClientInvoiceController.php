<?php

namespace Modules\CRM\App\Http\Controllers;

use App\Http\Controllers\Controller;
use Modules\CRM\App\Models\Invoice;
use Illuminate\Support\Facades\DB;

class ClientInvoiceController extends Controller
{
    public function invoices()
	{
		$logged_user = auth()->user();

		if ($logged_user->role_users_id == 3)
		{
			if (request()->ajax())
			{
				return datatables()->of(Invoice::with('project:id,title','invoicePayment')
					->where('client_id',$logged_user->id)
					->where('status','=','0')
					->get())
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
					->addColumn('action', function ($data)
					{
						$button = '<a id="' . $data->id . '" class="show btn btn-success btn-sm" href="' . route('invoices.show', $data) . '"><i class="dripicons-preview"></i></a>';
						$button .= '&nbsp;&nbsp;';
						return $button;

					})
					->rawColumns(['action','payment_status'])
					->make(true);
			}

			return view('crm::client.invoices.invoice');
		}

		return abort('403', __('You are not authorized'));
	}


	public function paidInvoices()
	{
		$logged_user = auth()->user();

        $invoices = DB::table('invoice_payments')
        ->select('invoice_payments.id',
            'invoice_payments.invoice_id',
            'invoice_payments.payment_method',
            'invoice_payments.date','amount',
            'invoice_payments.payment_status',
            'invoices.client_id',
            'invoices.invoice_number',
            )
        ->join('invoices','invoices.id','invoice_payments.invoice_id')
        ->where('invoices.client_id', $logged_user->id)
        ->orderBy('invoice_payments.id','DESC')
        ->get();


        if ($logged_user->role_users_id == 3) {
            if (request()->ajax()) {
                return datatables()->of($invoices)
                    ->setRowId(function ($row)
                    {
                        return $row->id;
                    })
                    ->addColumn('invoiceId',function ($row)
                    {
                        return $row->invoice_number;
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
                            $btnColor = 'warning';
                        }else if($row->payment_status=='canceled'){
                            $btnColor = 'danger';
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
            return view('crm::client.invoices.paid_invoice');

		}

		return abort('403', __('You are not authorized'));



	}


	// public function index()
	// {
    //     if (request()->ajax())
    //     {
    //         return datatables()->of(Invoice::with('project:id,title')->get())
    //             ->setRowId(function ($invoice)
    //             {
    //                 return $invoice->id;
    //             })
    //             ->addColumn('project', function ($row)
    //             {
    //                 $project_name = empty($row->project->title) ? '' : $row->project->title;

    //                 return $project_name;
    //             })
    //             ->addColumn('action', function ($data)
    //             {
    //                 $button = '<a  class="show btn btn-success btn-sm" href="' . route('invoices.show', $data) . '"><i class="dripicons-preview"></i></a>';
    //                 $button .= '&nbsp;&nbsp;';
    //                 if (auth()->user()->can('edit-invoice'))
    //                 {
    //                     $button .= '<a id="' . $data->id . '" class="edit btn btn-primary btn-sm" href="' . route('invoices.edit', $data) . '"><i class="dripicons-pencil"></i></a>';
    //                     $button .= '&nbsp;&nbsp;';
    //                 }
    //                 if (auth()->user()->can('delete-invoice'))
    //                 {
    //                     $button .= '<button type="button" name="delete" id="' . $data->id . '" class="delete btn btn-danger btn-sm"><i class="dripicons-trash"></i></button>';
    //                 }

    //                 return $button;

    //             })
    //             ->rawColumns(['action'])
    //             ->make(true);
    //     }

    //     return view('crm::client.invoices.index');
	// }
}
