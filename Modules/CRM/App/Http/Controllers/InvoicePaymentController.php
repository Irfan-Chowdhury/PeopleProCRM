<?php

namespace Modules\CRM\App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Invoice;
use Exception;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Modules\CRM\App\Http\Requests\InvoicePayment\StoreInvoicePaymentRequest;
use Modules\CRM\App\Models\InvoicePayment;
use Illuminate\Support\Facades\DB;

class InvoicePaymentController extends Controller
{
    public function index()
    {
        $invoices = DB::table('invoices')
                    ->select('id', 'invoice_number', 'client_id', 'sub_total')
                    ->whereNotIn('id', function ($query) {
                        $query->select('invoice_id')
                            ->from('invoice_payments');
                    })
                    ->get();

        return view('crm::sale_section.invoice_payments.index', compact('invoices'));
    }

    public function datatable()
    {
        if (request()->ajax()) {
			return datatables()->of(InvoicePayment::with('invoice:id,invoice_number,client_id','client')->orderBy('id','DESC')->get())
				->setRowId(function ($row)
				{
					return $row->id;
				})
                ->addColumn('invoiceId',function ($row)
                {
                    return $row->invoice->invoice_number ?? " ";
                })
                ->addColumn('client',function ($row)
                {
                    return $row->client->first_name.' '.$row->client->last_name;
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
    }


    public function store(StoreInvoicePaymentRequest $request)
    {
        $invoice = Invoice::find($request->invoice_id);

        InvoicePayment::create([
            'invoice_id' => $request->invoice_id,
            'client_id' => $invoice->client_id,
            'payment_method' => $request->payment_method,
            'date' => date('Y-m-d',strtotime($request->payment_date)),
            'amount' => $request->amount,
            'payment_status' => $request->payment_status,
            'note' => $request->note,
        ]);
        return response()->json(['success' =>'Data Submitted Successfully'], 200);
    }

    public function destroy(InvoicePayment $invoicePayment)
    {
        $invoicePayment->delete();
        return response()->json(['success' =>'Data Deleted Successfully'], 200);
    }


    public function bulkDelete(Request $request)
    {
        $idsArray = $request['idsArray'];

        try {
            $invoicePayment = InvoicePayment::whereIntegerInRaw('id', $idsArray);
            $invoicePayment->delete();
            return response()->json(['success' =>'Data Deleted Successfully'], 200);

        } catch (Exception $e) {
            return response()->json(['errorMsg' =>$e->getMessage()], 422);
        }
    }
}
