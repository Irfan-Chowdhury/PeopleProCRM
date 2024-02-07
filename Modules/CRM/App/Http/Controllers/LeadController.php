<?php

namespace Modules\CRM\App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\company;
use App\Models\Country;
use App\Models\Employee;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Modules\CRM\App\Http\Requests\Lead\StoreRequest;
use Modules\CRM\App\Http\Requests\Lead\UpdateRequest;
use Modules\CRM\App\Models\Lead;
use Nwidart\Modules\Facades\Module;

class LeadController extends Controller
{
    public function index()
    {
        // $fileExists =File::exists(module_path('CRM').'/Assets/css/style.css');
        // if ($fileExists)
        //     return 1;
        // return 2;
        // return Module::getPath();

        $companies = company::select('id', 'company_name')->get();
        $countries = Country::all();

        return view('crm::lead_section.lead.index',compact('companies','countries'));
    }

    public function datatable()
    {
        if (request()->ajax())
		{
			return datatables()->of(Lead::with('company:id,company_name','owner')->get())
				->setRowId(function ($row)
				{
					return $row->id;
				})
                ->addColumn('company_name',function ($row)
                {
                    return $row->company->company_name ?? "" ;
                })
                ->addColumn('owner',function ($row)
                {
                    return $row->owner->first_name.' '.$row->owner->last_name ?? "" ;
                })
				->addColumn('action', function ($data)
                {
                    $button = '<a href="leads/details/'.$data->id.'/contact"  class="edit btn btn-success btn-sm" data-toggle="tooltip" data-placement="top" title="View Details"><i class="dripicons-preview"></i></button></a>';
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

    public function store(StoreRequest $request)
    {
        Lead::create([
            'company_id' => $request->company_id,
            'employee_id' => $request->employee_id,
            'status' => $request->status,
            'country_id' => $request->country_id,
            'city' => $request->city,
            'state' => $request->state,
            'zip' => $request->zip,
            'address' => $request->address,
            'phone' => $request->phone,
            'website' => $request->website,
            'vat_number' => $request->vat_number,
            'gst_number' => $request->gst_number,
        ]);
        return response()->json(['success' =>'Data Submitted Successfully'], 200);
    }

    public function edit(Lead $lead)
    {
        $employees = Employee::where('company_id',$lead->company_id)->get();

        return response()->json(['lead'=>$lead, 'employees'=>$employees]);
    }

    public function update(UpdateRequest $request, Lead $lead)
    {
        $lead->update([
            'company_id' => $request->company_id,
            'employee_id' => $request->employee_id,
            'status' => $request->status,
            'country_id' => $request->country_id,
            'city' => $request->city,
            'state' => $request->state,
            'zip' => $request->zip,
            'address' => $request->address,
            'phone' => $request->phone,
            'website' => $request->website,
            'vat_number' => $request->vat_number,
            'gst_number' => $request->gst_number,
        ]);

        return response()->json(['success' =>'Data Updated Successfully'], 200);
    }

    public function destroy(Lead $lead)
    {
        $lead->delete();
        return response()->json(['success' =>'Data Deleted Successfully'], 200);
    }

    public function bulkDelete(Request $request)
    {
        $leadIdsArray = $request['leadIdsArray'];

        try {
            $lead = Lead::whereIntegerInRaw('id', $leadIdsArray);
            $lead->delete();

            return response()->json(['success' =>'Data Deleted Successfully'], 200);

        } catch (Exception $e) {
            return response()->json(['errorMsg' =>$e->getMessage()], 422);
        }
    }
}
