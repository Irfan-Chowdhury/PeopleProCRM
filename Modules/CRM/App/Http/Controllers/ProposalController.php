<?php

namespace Modules\CRM\App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\TaxType;
use Exception;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use Modules\CRM\App\Http\Requests\ProspectProposal\StoreProposalRequest;
use Modules\CRM\App\Http\Requests\ProspectProposal\UpdateProposalRequest;
use Modules\CRM\App\Models\Proposal;

class ProposalController extends Controller
{
    public function index()
    {
        $clientsOrLeads = DB::table(DB::raw('(
            SELECT id, CONCAT(first_name," ",last_name) AS name, "client" AS type
            FROM clients
            UNION ALL
            SELECT leads.id AS id, CONCAT(employees.first_name," ",employees.last_name), "lead" AS type
            FROM leads
            JOIN employees ON employees.id = leads.employee_id
            WHERE leads.deleted_at IS NULL
        ) AS combined_result'))
        ->select('id', 'name', 'type')
        ->get();

        $taxTypes = TaxType::select('id', 'name', 'rate', 'type')->get();

        // $proposal = Proposal::with('client','lead','tax','proposalItems')->select('id','start_date','end_date','client_id','lead_id','tax_type_id')->latest()->first();
        // return $proposal->proposalItems->sum('rate');

        return view('crm::prospects.proposal.index',compact('taxTypes','clientsOrLeads'));
    }

    public function datatable()
    {
        if (request()->ajax())
		{
			return datatables()->of(Proposal::with('client','lead','tax','proposalItems')->select('id','start_date','end_date','client_id','lead_id','tax_type_id')->get())
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
                    $button = '<a href="proposals/'.$data->id.'/items"  class="btn btn-success btn-sm" data-toggle="tooltip" data-placement="top" title="View Details"><i class="dripicons-preview"></i></button></a>';
                    $button .= '&nbsp;&nbsp;';
                    $button .= '<button type="button" data-id="'. $data->id . '" class="edit btn btn-primary btn-sm"><i class="dripicons-pencil"></i></button>';
                    $button .= '&nbsp;&nbsp;';
                    $button .= '<button type="button" data-id="'.$data->id.'" class="delete btn btn-danger btn-sm"><i class="dripicons-trash"></i></button>';
                    return $button;
                })
                ->rawColumns(['action'])
                ->make(true);
		}
    }

    public function store(StoreProposalRequest $request)
    {
        Proposal::create([
            'start_date' => date('Y-m-d',strtotime($request->start_date)),
            'end_date' => date('Y-m-d',strtotime($request->end_date)),
            'client_id' => $request->candidate_type==='client' ? $request->candidate_id : null,
            'lead_id' => $request->candidate_type==='lead' ? $request->candidate_id : null,
            'tax_type_id' => $request->tax_type_id,
            'note' => $request->note,
        ]);

        return response()->json(['success' =>'Data Submitted Successfully'], 200);
    }

    public function edit(Proposal $proposal)
    {
        return response()->json($proposal);
    }

    public function update(UpdateProposalRequest $request, Proposal $proposal)
    {
        $proposal->update([
            'start_date' => date('Y-m-d',strtotime($request->start_date)),
            'end_date' => date('Y-m-d',strtotime($request->end_date)),
            'client_id' => $request->candidate_type==='client' ? $request->candidate_id : null,
            'lead_id' => $request->candidate_type==='lead' ? $request->candidate_id : null,
            'tax_type_id' => $request->tax_type_id,
            'note' => $request->note,
        ]);

        return response()->json(['success' =>'Data Updated Successfully'], 200);
    }

    public function destroy(Proposal $proposal)
    {
        $proposal->delete();

        return response()->json(['success' =>'Data Deleted Successfully'], 200);
    }

    public function bulkDelete(Request $request)
    {
        $idsArray = $request['idsArray'];

        try {
            $proposal = Proposal::whereIntegerInRaw('id', $idsArray);
            $proposal->delete();
            return response()->json(['success' =>'Data Deleted Successfully'], 200);

        } catch (Exception $e) {
            return response()->json(['errorMsg' =>$e->getMessage()], 422);
        }
    }
}
