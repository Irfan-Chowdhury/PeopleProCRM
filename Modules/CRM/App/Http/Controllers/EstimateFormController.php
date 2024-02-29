<?php

namespace Modules\CRM\App\Http\Controllers;

use App\Http\Controllers\Controller;
use Exception;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Modules\CRM\App\Models\EstimateForm;

class EstimateFormController extends Controller
{
    public function index()
    {
        return view('crm::prospects.estimate_form.index');
    }


    public function datatable()
    {
        if (request()->ajax())
		{
			return datatables()->of(EstimateForm::select('id','title','status','is_public','description')->get())
				->setRowId(function ($row)
				{
					return $row->id;
				})
                ->addColumn('title',function ($row)
                {
                    return $row->title;
                })
                ->addColumn('status',function ($row)
                {
                    return $row->status ? 'Active' : 'Inactive';
                })
                ->addColumn('is_public',function ($row)
                {
                    return $row->is_public ? 'Yes' : 'No';
                })
				->addColumn('action', function ($data)
                {
                    $button = '<button type="button" data-id="'. $data->id . '" class="edit btn btn-primary btn-sm"><i class="dripicons-pencil"></i></button>';
                    $button .= '&nbsp;&nbsp;';
                    $button .= '<button type="button" data-id="'.$data->id.'" class="delete btn btn-danger btn-sm"><i class="dripicons-trash"></i></button>';
                    return $button;
                })
                ->rawColumns(['action'])
                ->make(true);
		}
    }

    public function store(Request $request)
    {
        EstimateForm::create([
            'title' => $request->title,
            'status' => $request->status==='1' ? true : false,
            'is_public' => $request->is_public ? true : false,
            'description' => $request->description,
        ]);

        return response()->json(['success' =>'Data Submitted Successfully'], 200);
    }

    public function edit(EstimateForm $estimateForm)
    {
        return response()->json($estimateForm);
    }

    public function update(Request $request, EstimateForm $estimateForm)
    {
        $estimateForm->update([
            'title' => $request->title,
            'status' => $request->status==='1' ? true : false,
            'is_public' => $request->is_public ? true : false,
            'description' => $request->description,
        ]);

        return response()->json(['success' =>'Data Updated Successfully'], 200);
    }

    public function destroy(EstimateForm $estimateForm)
    {
        $estimateForm->delete();

        return response()->json(['success' =>'Data Deleted Successfully'], 200);
    }

    public function bulkDelete(Request $request)
    {
        $idsArray = $request['idsArray'];

        try {
            $estimateForm = EstimateForm::whereIntegerInRaw('id', $idsArray);
            $estimateForm->delete();
            return response()->json(['success' =>'Data Deleted Successfully'], 200);

        } catch (Exception $e) {
            return response()->json(['errorMsg' =>$e->getMessage()], 422);
        }
    }
}
