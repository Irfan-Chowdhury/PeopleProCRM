<?php

namespace Modules\CRM\App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\TaxType;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Modules\CRM\App\Models\Subscription;
use App\Models\Client;

class ClientSubscriptionController extends Controller
{
    public function index()
    {
        $clients = Client::select('id','first_name','last_name')->get();
        $taxes = TaxType::select('id','name', 'rate', 'type')->get();


        if (request()->ajax())
		{
			return datatables()->of(Subscription::with('client','tax')->where('client_id',auth()->user()->id)->get())
				->setRowId(function ($row)
				{
					return $row->id;
				})
                ->addColumn('title',function ($row)
                {
                    return $row->title ?? "" ;
                })
                ->addColumn('client',function ($row)
                {
                    return $row->client->first_name.' '.$row->client->last_name ?? "" ;
                })
                ->addColumn('next_billing_date',function ($row)
                {
                    return $row->first_billing_date;
                })
                ->addColumn('repeat_type',function ($row)
                {
                    return ucfirst($row->repeat_type);
                })
				->addColumn('action', function ($data)
                {
                    return  '<button type="button" data-id="'. $data->id . '" class="edit btn btn-primary btn-sm"><i class="dripicons-preview"></i></button>';
                })
                ->rawColumns(['action'])
                ->make(true);
		}

        return view('crm::client.subscription.index',compact('clients','taxes'));
    }

}
