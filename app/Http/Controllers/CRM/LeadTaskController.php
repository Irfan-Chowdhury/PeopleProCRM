<?php

namespace App\Http\Controllers\CRM;

use App\Http\Controllers\Controller;
use App\Http\Requests\LeadTask\StoreRequest;
use App\Http\Requests\LeadTask\UpdateRequest;
use App\Models\CRM\Lead;
use App\Models\CRM\LeadTask;
use App\Models\Employee;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class LeadTaskController extends Controller
{
    public function index(Lead $lead)
    {
        $employees = Employee::where('is_active',1)->get();
        return view('crm.lead_section.task.index', compact('lead','employees'));
    }

    public function datatable()
    {
        if (request()->ajax()) {
			return datatables()->of(LeadTask::with('employee')->orderBy('id','DESC')->get())
				->setRowId(function ($row)
				{
					return $row->id;
				})
                ->addColumn('title',function ($row)
                {
                    return $row->title;
                })
                ->addColumn('start_date',function ($row)
                {
                    return $row->start_date;
                })
                ->addColumn('end_date',function ($row)
                {
                    return $row->end_date;
                })
                ->addColumn('assigned_to',function ($row)
                {
                    return $row->employee->first_name.' '.$row->employee->last_name;
                })
                ->addColumn('status',function ($row)
                {
                    return $row->status;
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

        LeadTask::create([
            'lead_id' => $lead->id,
            'employee_id' => $request->employee_id,
            'title' => $request->title,
            'description' => $request->description,
            'points' => $request->points,
            'collaborator_employee_ids' => json_encode($request->collaborator_employee_ids),
            'status' => $request->status,
            'priority' => $request->priority,
            'labels' => $request->labels,
            'start_date' => date('Y-m-d',strtotime($request->start_date)),
            'end_date' => date('Y-m-d',strtotime($request->end_date)),
        ]);
        return response()->json(['success' =>'Data Submitted Successfully'], 200);
    }

    public function edit(Lead $lead, LeadTask $leadTask)
    {
        return response()->json(['leadTask' => $leadTask]);
    }

    public function update(UpdateRequest $request, Lead $lead, LeadTask $leadTask)
    {
        if(strtotime($request->start_date) > strtotime($request->end_date)) {
            return response()->json(['errorMsg' => 'The start date must be greater than the end date.'], 422);
        }

        $leadTask->update([
            'lead_id' => $lead->id,
            'employee_id' => $request->employee_id,
            'title' => $request->title,
            'description' => $request->description,
            'points' => $request->points,
            'collaborator_employee_ids' => json_encode($request->collaborator_employee_ids),
            'status' => $request->status,
            'priority' => $request->priority,
            'labels' => $request->labels,
            'start_date' => date('Y-m-d',strtotime($request->start_date)),
            'end_date' => date('Y-m-d',strtotime($request->end_date)),
        ]);

        return response()->json(['success' =>'Data Updated Successfully'], 200);
    }

    public function destroy(Lead $lead, LeadTask $leadTask)
    {
        $leadTask->delete();
        return response()->json(['success' =>'Data Deleted Successfully'], 200);
    }


    public function bulkDelete(Request $request)
    {
        $idsArray = $request['idsArray'];

        try {
            $leadTask = LeadTask::whereIntegerInRaw('id', $idsArray);
            $leadTask->delete();
            return response()->json(['success' =>'Data Deleted Successfully'], 200);

        } catch (Exception $e) {
            return response()->json(['errorMsg' =>$e->getMessage()], 422);
        }
    }
}
