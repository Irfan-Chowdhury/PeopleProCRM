<?php

namespace Modules\CRM\App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Project;
use App\Models\TaxType;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Modules\CRM\App\Http\Requests\Contract\StoreContractRequest;
use Modules\CRM\App\Http\Requests\Contract\UpdateContractRequest;
use Modules\CRM\App\Models\Contract;

class ContractController extends Controller
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

        $projects = Project::all();
        $taxTypes = TaxType::select('id', 'name', 'rate', 'type')->get();

        return view('crm::sale_section.contracts.index',compact('projects','taxTypes','clientsOrLeads'));
    }

    public function datatable()
    {
        if (request()->ajax()) {
			return datatables()->of(Contract::with('project','tax','contractItems')->orderBy('id','DESC')->get())
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
                    $button = '<a href="contracts/'.$data->id.'/items"  class="btn btn-success btn-sm" data-toggle="tooltip" data-placement="top" title="View Details"><i class="dripicons-preview"></i></button></a>';
                    $button .= '&nbsp;&nbsp;';
                    $button .= '<button type="button" data-id="'. $data->id . '" class="edit btn btn-primary btn-sm"><i class="dripicons-pencil"></i></button>';
                    $button .= '&nbsp;&nbsp;';
                    $button .= '<button type="button" data-id="'.$data->id.'" class="delete btn btn-danger btn-sm"><i class="dripicons-trash"></i></button>';
                    return $button;
                })
                ->rawColumns(['image','name','action'])
                ->make(true);
		}
    }

    public function store(StoreContractRequest $request)
    {
        if(strtotime($request->start_date) > strtotime($request->end_date)) {
            return response()->json(['errorMsg' => 'The start date must be greater than the end date.'], 422);
        }

        Contract::create([
            'client_id' => $request->candidate_type==='client' ? $request->candidate_id : null,
            'lead_id' => $request->candidate_type==='lead' ? $request->candidate_id : null,
            'project_id' => $request->project_id,
            'tax_type_id' => $request->tax_type_id,
            'title' => $request->title,
            'start_date' => date('Y-m-d',strtotime($request->start_date)),
            'end_date' => date('Y-m-d',strtotime($request->end_date)),
            'note' => $request->note,
        ]);
        return response()->json(['success' =>'Data Submitted Successfully'], 200);
    }

    public function edit(Contract $contract)
    {
        return response()->json(['contract' => $contract]);
    }

    public function update(UpdateContractRequest $request, Contract $contract)
    {
        if(strtotime($request->start_date) > strtotime($request->end_date)) {
            return response()->json(['errorMsg' => 'The start date must be greater than the end date.'], 422);
        }

        $contract->update([
            'client_id' => $request->candidate_type==='client' ? $request->candidate_id : null,
            'lead_id' => $request->candidate_type==='lead' ? $request->candidate_id : null,            'project_id' => $request->project_id,
            'tax_type_id' => $request->tax_type_id,
            'title' => $request->title,
            'start_date' => date('Y-m-d',strtotime($request->start_date)),
            'end_date' => date('Y-m-d',strtotime($request->end_date)),
            'note' => $request->note,
        ]);

        return response()->json(['success' =>'Data Updated Successfully'], 200);
    }


    public function destroy(Contract $contract)
    {
        $contract->delete();
        return response()->json(['success' =>'Data Deleted Successfully'], 200);
    }


    public function bulkDelete(Request $request)
    {
        $idsArray = $request['idsArray'];

        try {
            $contract = Contract::whereIntegerInRaw('id', $idsArray);
            $contract->delete();
            return response()->json(['success' =>'Data Deleted Successfully'], 200);

        } catch (Exception $e) {
            return response()->json(['errorMsg' =>$e->getMessage()], 422);
        }
    }

}
