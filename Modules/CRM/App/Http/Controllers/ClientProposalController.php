<?php

namespace Modules\CRM\App\Http\Controllers;

use App\Http\Controllers\Controller;
use Modules\CRM\App\Models\Contract;
use Modules\CRM\App\Models\Proposal;

class ClientProposalController extends Controller
{
    public function index()
    {
        return view('crm::client.proposals.index');
    }

    public function datatable()
    {
        if (request()->ajax())
		{
			return datatables()->of(Proposal::with('client','lead','tax','proposalItems')->select('id','start_date','end_date','client_id','lead_id','tax_type_id')->where('client_id',auth()->user()->id)->get())
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
                ->addColumn('assign_to',function ($row)
                {
                    if(isset($row->client_id))
                        return $row->client->first_name.' '.$row->client->last_name ?? "" ;
                    else
                        return $row->lead->owner->first_name.' '.$row->lead->owner->last_name ?? "" ;
                })
                ->addColumn('tax',function ($row)
                {
                    return $row->tax->rate.' %';
                })
                ->addColumn('amount',function ($row)
                {
                    if($row->proposalItems) {
                        $total = 0;
                        foreach($row->proposalItems as $item) {
                            $total += $item->rate * $item->quantity;
                        }
                        return $total + ($total * ($row->tax->rate/100));
                    }else
                        return 0;
                })
				->addColumn('action', function ($data)
                {
                    return '<a href="proposals/'.$data->id.'"  class="btn btn-success btn-sm" data-toggle="tooltip" data-placement="top" title="View Details"><i class="dripicons-preview"></i></button></a>';
                })
                ->rawColumns(['action'])
                ->make(true);
		}
    }

    public function proposalItemDetails(Proposal $proposal)
    {
        $proposal = $proposal->load('proposalItems','tax');
        $totalAmoutWithTax = 0;
        $total = 0;
        if($proposal->proposalItems) {
            foreach($proposal->proposalItems as $item) {
                $total += $item->rate * $item->quantity;
            }
            $totalAmoutWithTax = $total + ($total * ($proposal->tax->rate/100));
        }

        return view('crm::client.proposals.proposal_items_details', compact('proposal','total','totalAmoutWithTax'));
    }

    public function show($client_id)
    {
        $proposals = Proposal::with('client','lead','tax','proposalItems')
                    ->select('id','start_date','end_date','client_id','lead_id','tax_type_id')
                    ->where('client_id', $client_id)
                    ->get();

        if (request()->ajax())
		{
			return datatables()->of($proposals)
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
                ->addColumn('assign_to',function ($row)
                {
                    if(isset($row->client_id))
                        return $row->client->first_name.' '.$row->client->last_name ?? "" ;
                    else
                        return $row->lead->owner->first_name.' '.$row->lead->owner->last_name ?? "" ;
                })
                ->addColumn('tax',function ($row)
                {
                    return $row->tax->rate.' %';
                })
                ->addColumn('amount',function ($row)
                {
                    if($row->proposalItems) {
                        $total = 0;
                        foreach($row->proposalItems as $item) {
                            $total += $item->rate * $item->quantity;
                        }
                        return $total + ($total * ($row->tax->rate/100));
                    }else
                        return 0;
                })
				->addColumn('action', function ($data)
                {
                    return '<a href="' . url('client/proposals/' . $data->id) . '" class="btn btn-success btn-sm" data-toggle="tooltip" data-placement="top" title="View Details"><i class="dripicons-preview"></i></button></a>';
                })
                ->rawColumns(['action'])
                ->make(true);
		}

        return view('crm::client.proposals.index', compact('client_id'));
    }
}
