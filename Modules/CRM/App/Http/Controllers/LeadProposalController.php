<?php

namespace Modules\CRM\App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\TaxType;
use Modules\CRM\App\Http\Requests\LeadProposal\StoreRequest;
use Modules\CRM\App\Http\Requests\LeadProposal\UpdateRequest;
use Modules\CRM\App\Models\Lead;
use Modules\CRM\App\Models\LeadProposal;
use Exception;
use Illuminate\Http\Request;

class LeadProposalController extends Controller
{
    public function index(Lead $lead)
    {
        $taxes = TaxType::select('id', 'name', 'rate', 'type')->get();

        return view('crm::lead_section.proposals.index', compact('lead','taxes'));
    }


    public function datatable()
    {
        if (request()->ajax()) {
			return datatables()->of(LeadProposal::with('tax')->orderBy('id','DESC')->get())
				->setRowId(function ($row)
				{
					return $row->id;
				})
                ->addColumn('proposal',function ($row)
                {
                    return 'Proposal- #'.$row->id;
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
                    return $row->tax->rate.' %';
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

        LeadProposal::create([
            'lead_id' => $lead->id,
            'tax_type_id' => isset($request->tax_type_id) ? $request->tax_type_id : null,
            'start_date' => date('Y-m-d',strtotime($request->start_date)),
            'end_date' => date('Y-m-d',strtotime($request->end_date)),
            'note' => $request->note,
        ]);
        return response()->json(['success' =>'Data Submitted Successfully'], 200);
    }

    public function edit(Lead $lead, LeadProposal $leadProposal)
    {
        return response()->json(['leadProposal' => $leadProposal]);
    }

    public function update(UpdateRequest $request, Lead $lead, LeadProposal $leadProposal)
    {
        if(strtotime($request->start_date) > strtotime($request->end_date)) {
            return response()->json(['errorMsg' => 'The start date must be greater than the end date.'], 422);
        }

        $leadProposal->update([
            'lead_id' => $lead->id,
            'tax_type_id' => $request->tax_type_id ?? null,
            'start_date' => date('Y-m-d',strtotime($request->start_date)),
            'end_date' => date('Y-m-d',strtotime($request->end_date)),
            'note' => $request->note,
        ]);

        return response()->json(['success' =>'Data Updated Successfully'], 200);
    }


    public function destroy(Lead $lead, LeadProposal $leadProposal)
    {
        $leadProposal->delete();
        return response()->json(['success' =>'Data Deleted Successfully'], 200);
    }


    public function bulkDelete(Request $request)
    {
        $idsArray = $request['idsArray'];

        try {
            $leadTask = LeadProposal::whereIntegerInRaw('id', $idsArray);
            $leadTask->delete();
            return response()->json(['success' =>'Data Deleted Successfully'], 200);

        } catch (Exception $e) {
            return response()->json(['errorMsg' =>$e->getMessage()], 422);
        }
    }
}
