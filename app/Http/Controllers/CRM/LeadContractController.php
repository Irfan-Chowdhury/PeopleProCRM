<?php

namespace App\Http\Controllers\CRM;

use App\Http\Controllers\Controller;
use App\Http\Requests\LeadContract\StoreRequest;
use App\Http\Requests\LeadContract\UpdateRequest;
use App\Models\CRM\Lead;
use App\Models\CRM\LeadContract;
use App\Models\CRM\Tax;
use App\Models\Project;
use Exception;
use Illuminate\Http\Request;

class LeadContractController extends Controller
{
    public function index(Lead $lead)
    {
        $projects = Project::all();
        $taxes = Tax::all();

        return view('crm.lead_section.contracts.index', compact('lead','taxes','projects'));
    }

    public function datatable()
    {
        if (request()->ajax()) {
			return datatables()->of(LeadContract::with('tax','project')->orderBy('id','DESC')->get())
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
                    return $row->tax->name ?? null;
                })
				->addColumn('action', function ($data)
                {
                    $button = '<button type="button" data-id="'. $data->id . '" class="edit btn btn-primary btn-sm"><i class="dripicons-pencil"></i></button>';
                    $button .= '&nbsp;&nbsp;';
                    $button .= '<button type="button" data-id="'.$data->id.'" class="delete btn btn-danger btn-sm"><i class="dripicons-trash"></i></button>';
                    return $button;
                })
                ->rawColumns(['image','name','action'])
                ->make(true);
		}
    }

    public function store(StoreRequest $request, Lead $lead)
    {
        if(strtotime($request->start_date) > strtotime($request->end_date)) {
            return response()->json(['errorMsg' => 'The start date must be greater than the end date.'], 422);
        }

        LeadContract::create([
            'lead_id' => $lead->id,
            'project_id' => $request->project_id,
            'tax_id' => $request->tax_id,
            'title' => $request->title,
            'start_date' => date('Y-m-d',strtotime($request->start_date)),
            'end_date' => date('Y-m-d',strtotime($request->end_date)),
            'note' => $request->note,
        ]);
        return response()->json(['success' =>'Data Submitted Successfully'], 200);
    }

    public function edit(Lead $lead, LeadContract $leadContract)
    {
        return response()->json(['leadContract' => $leadContract]);
    }

    public function update(UpdateRequest $request, Lead $lead, LeadContract $leadContract)
    {
        if(strtotime($request->start_date) > strtotime($request->end_date)) {
            return response()->json(['errorMsg' => 'The start date must be greater than the end date.'], 422);
        }

        $leadContract->update([
            'lead_id' => $lead->id,
            'project_id' => $request->project_id,
            'tax_id' => $request->tax_id,
            'title' => $request->title,
            'start_date' => date('Y-m-d',strtotime($request->start_date)),
            'end_date' => date('Y-m-d',strtotime($request->end_date)),
            'note' => $request->note,
        ]);

        return response()->json(['success' =>'Data Updated Successfully'], 200);
    }


    public function destroy(Lead $lead, LeadContract $leadContract)
    {
        $leadContract->delete();
        return response()->json(['success' =>'Data Deleted Successfully'], 200);
    }


    public function bulkDelete(Request $request)
    {
        $idsArray = $request['idsArray'];

        try {
            $leadTask = LeadContract::whereIntegerInRaw('id', $idsArray);
            $leadTask->delete();
            return response()->json(['success' =>'Data Deleted Successfully'], 200);

        } catch (Exception $e) {
            return response()->json(['errorMsg' =>$e->getMessage()], 422);
        }
    }

}
