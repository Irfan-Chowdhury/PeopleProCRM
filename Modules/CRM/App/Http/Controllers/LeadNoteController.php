<?php

namespace Modules\CRM\App\Http\Controllers;

use App\Http\Controllers\Controller;
use Modules\CRM\App\Http\Requests\LeadNote\StoreRequest;
use Modules\CRM\App\Http\Requests\LeadNote\UpdateRequest;
use Modules\CRM\App\Models\Lead;
use Modules\CRM\App\Models\LeadNote;
use Exception;
use Illuminate\Http\Request;

class LeadNoteController extends Controller
{
    public function index(Lead $lead)
    {
        return view('crm::lead_section.notes.index', compact('lead'));
    }

    public function datatable()
    {
        if (request()->ajax()) {
			return datatables()->of(LeadNote::orderBy('id','DESC')->get())
				->setRowId(function ($row)
				{
					return $row->id;
				})
                ->addColumn('title',function ($row)
                {
                    return $row->title;
                })
                ->addColumn('note',function ($row)
                {
                    return $row->note;
                })
                ->addColumn('created_at',function ($row)
                {
                    return $row->created_at;
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
        LeadNote::create([
            'lead_id' => $lead->id,
            'title' => $request->title,
            'note' => $request->note,
        ]);
        return response()->json(['success' =>'Data Submitted Successfully'], 200);
    }

    public function edit(Lead $lead, LeadNote $leadNote)
    {
        return response()->json(['leadNote' => $leadNote]);
    }

    public function update(UpdateRequest $request, Lead $lead, LeadNote $leadNote)
    {
        $leadNote->update([
            'lead_id' => $lead->id,
            'title' => $request->title,
            'note' => $request->note,
        ]);

        return response()->json(['success' =>'Data Updated Successfully'], 200);
    }


    public function destroy(Lead $lead, LeadNote $leadNote)
    {
        $leadNote->delete();
        return response()->json(['success' =>'Data Deleted Successfully'], 200);
    }


    public function bulkDelete(Request $request)
    {
        $idsArray = $request['idsArray'];

        try {
            $leadTask = LeadNote::whereIntegerInRaw('id', $idsArray);
            $leadTask->delete();
            return response()->json(['success' =>'Data Deleted Successfully'], 200);

        } catch (Exception $e) {
            return response()->json(['errorMsg' =>$e->getMessage()], 422);
        }
    }
}
