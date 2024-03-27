<?php

namespace Modules\CRM\App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Project;
use App\Models\TaxType;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use Modules\CRM\App\Models\Contract;

class ClientContractController extends Controller
{
    public function index()
    {
        return view('crm::client.contracts.index');
    }

    public function datatable()
    {
        $contracts = Contract::with('project','tax','contractItems')
                    ->where('client_id',auth()->user()->id)
                    ->orderBy('id','DESC')
                    ->get();

        if (request()->ajax()) {
			return datatables()->of($contracts)
				->setRowId(function ($row)
				{
					return $row->id;
				})
                ->addColumn('contract',function ($row)
                {
                    return 'contract- #'.$row->id;
                })
                ->addColumn('title',function ($row)
                {
                    return $row->title;
                })
                ->addColumn('project',function ($row)
                {
                    return $row->project->title ?? null;
                })
                ->addColumn('start_date',function ($row)
                {
                    return $row->start_date;
                })
                ->addColumn('end_date',function ($row)
                {
                    return $row->end_date;
                })
                ->addColumn('tax',function ($row)
                {
                    return $row->tax->rate.'%' ?? null ;
                })
                ->addColumn('amount',function ($row)
                {
                    if($row->contractItems) {
                        $total = 0;
                        foreach($row->contractItems as $item) {
                            $total += $item->rate * $item->quantity;
                        }
                        return $total + ($total * ($row->tax->rate/100));
                    }else
                        return 0;
                })
				->addColumn('action', function ($data)
                {
                    return '<a href="contracts/'.$data->id.'"  class="btn btn-success btn-sm" data-toggle="tooltip" data-placement="top" title="View Details"><i class="dripicons-preview"></i></button></a>';
                })
                ->rawColumns(['image','name','action'])
                ->make(true);
		}
    }

    public function contractItemDetails(Contract $contract)
    {
        $contract = $contract->load('contractItems','tax');
        $totalAmoutWithTax = 0;
        $total = 0;
        if($contract->contractItems) {
            foreach($contract->contractItems as $item) {
                $total += $item->rate * $item->quantity;
            }
            $totalAmoutWithTax = $total + ($total * ($contract->tax->rate/100));
        }

        return view('crm::client.contracts.contract_items_details', compact('contract','total','totalAmoutWithTax'));
    }

    public function show($client_id)
    {
        $contracts = Contract::with('project','tax','contractItems')->where('client_id', $client_id)->orderBy('id','DESC')->get();

        if (request()->ajax()) {
			return datatables()->of($contracts)
				->setRowId(function ($row)
				{
					return $row->id;
				})
                ->addColumn('contract',function ($row)
                {
                    return 'contract- #'.$row->id;
                })
                ->addColumn('title',function ($row)
                {
                    return $row->title;
                })
                ->addColumn('project',function ($row)
                {
                    return $row->project->title ?? null;
                })
                ->addColumn('start_date',function ($row)
                {
                    return $row->start_date;
                })
                ->addColumn('end_date',function ($row)
                {
                    return $row->end_date;
                })
                ->addColumn('tax',function ($row)
                {
                    return $row->tax->rate.'%' ?? null ;
                })
                ->addColumn('amount',function ($row)
                {
                    if($row->contractItems) {
                        $total = 0;
                        foreach($row->contractItems as $item) {
                            $total += $item->rate * $item->quantity;
                        }
                        return $total + ($total * ($row->tax->rate/100));
                    }else
                        return 0;
                })
				->addColumn('action', function ($data)
                {
                    return '<a href="' . url('client/contracts/' . $data->id) . '" class="btn btn-success btn-sm" data-toggle="tooltip" data-placement="top" title="View Details"><i class="dripicons-preview"></i></button></a>';
                })
                ->rawColumns(['image','name','action'])
                ->make(true);
		}

        return view('crm::client.contracts.index', compact('client_id'));
    }
}
