<?php

namespace Modules\CRM\App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Modules\CRM\App\Models\Estimate;

class ClientEstimateController extends Controller
{
    public function index()
    {
        return view('crm::client.estimates.index');
    }


    public function datatable()
    {
        if (request()->ajax())
		{
			return datatables()->of(Estimate::with('client','tax','estimateItems')->where('client_id',auth()->user()->id)->select('id','start_date','end_date','client_id','tax_type_id')->get())
				->setRowId(function ($row)
				{
					return $row->id;
				})
                ->addColumn('start_date',function ($row)
                {
                    return $row->start_date;
                })
                ->addColumn('end_date',function ($row)
                {
                    return $row->end_date;
                })
                ->addColumn('client',function ($row)
                {
                    return $row->client->first_name.' '.$row->client->last_name ?? "" ;
                })
                ->addColumn('tax',function ($row)
                {
                    return $row->tax->rate.' %';
                })
                ->addColumn('amount',function ($row)
                {
                    if($row->estimateItems) {
                        $total = 0;
                        foreach($row->estimateItems as $item) {
                            $total += $item->rate * $item->quantity;
                        }
                        return $total + ($total * ($row->tax->rate/100));
                    }else
                        return 0;
                })
				->addColumn('action', function ($data)
                {
                    return '<a href="estimates/'.$data->id.'"  class="btn btn-success btn-sm" data-toggle="tooltip" data-placement="top" title="View Details"><i class="dripicons-preview"></i></button></a>';
                })
                ->rawColumns(['action'])
                ->make(true);
		}
    }

    public function estimateItemDetails(Estimate $estimate)
    {
        $estimate = $estimate->load('estimateItems','tax');

        $totalAmoutWithTax = 0;
        $total = 0;
        if($estimate->estimateItems) {
            foreach($estimate->estimateItems as $item) {
                $total += $item->rate * $item->quantity;
            }
            $totalAmoutWithTax = $total + ($total * ($estimate->tax->rate/100));
        }

        return view('crm::client.estimates.estimate_items_details', compact('estimate','total','totalAmoutWithTax'));
    }
}
