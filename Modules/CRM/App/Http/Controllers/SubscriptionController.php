<?php

namespace Modules\CRM\App\Http\Controllers;

use App\Http\Controllers\Controller;
use Modules\CRM\App\Http\Requests\Subscription\StoreRequest;
use Modules\CRM\App\Http\Requests\Subscription\UpdateRequest;
use App\Models\Client;
use Modules\CRM\App\Models\Subscription;
use Modules\CRM\App\Models\Tax;
use Exception;
use Illuminate\Http\Request;

class SubscriptionController extends Controller
{
    public function index()
    {
        $clients = Client::select('id','first_name','last_name')->get();
        $taxes =  Tax::all();
        return view('crm::subscription_section.subscription.index',compact('clients','taxes'));
    }

    public function datatable()
    {
        if (request()->ajax())
		{
			return datatables()->of(Subscription::with('client','tax')->get())
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
                    $button = '<button type="button" data-id="'. $data->id . '" class="edit btn btn-primary btn-sm"><i class="dripicons-pencil"></i></button>';
                    $button .= '&nbsp;&nbsp;';
                    $button .= '<button type="button" data-id="'.$data->id.'" class="delete btn btn-danger btn-sm"><i class="dripicons-trash"></i></button>';
                    return $button;
                })
                ->rawColumns(['action'])
                ->make(true);
		}
    }

    public function store(StoreRequest $request)
    {
        $data = [
            'client_id' => $request->client_id,
            'tax_id' => $request->tax_id,
            'title' => $request->title,
            'first_billing_date' => date('Y-m-d', strtotime($request->first_billing_date)),
            'repeat_type' => $request->repeat_type,
            'note' => $request->note
        ];

        try {
            Subscription::create($data);
        } catch (Exception $exception) {
            return response()->json(['errorMsg' => $exception->getMessage()], 422);
        }

        return response()->json(['success' =>'Data Submitted Successfully'], 200);
    }

    public function edit(Subscription $subscription)
    {
        return response()->json(['subscription' => $subscription]);
    }

    public function update(UpdateRequest $request, Subscription $subscription)
    {
        $subscription->update([
            'client_id' => $request->client_id,
            'tax_id' => $request->tax_id,
            'title' => $request->title,
            'first_billing_date' => date('Y-m-d', strtotime($request->first_billing_date)),
            'repeat_type' => $request->repeat_type,
            'note' => $request->note
        ]);

        return response()->json(['success' =>'Data Updated Successfully'], 200);
    }


    public function destroy(Subscription $subscription)
    {
        $subscription->delete();
        return response()->json(['success' =>'Data Deleted Successfully'], 200);
    }


    public function bulkDelete(Request $request)
    {
        $idsArray = $request['idsArray'];

        try {
            $subscription = Subscription::whereIntegerInRaw('id', $idsArray);
            $subscription->delete();

            return response()->json(['success' =>'Data Deleted Successfully'], 200);
        } catch (Exception $e) {
            return response()->json(['errorMsg' =>$e->getMessage()], 422);
        }
    }
}
