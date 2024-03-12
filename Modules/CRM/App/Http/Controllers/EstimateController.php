<?php

namespace Modules\CRM\App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\TaxType;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Modules\CRM\App\Http\Requests\Estimate\StoreEstimateRequest;
use Modules\CRM\App\Http\Requests\Estimate\UpdateEstimateRequest;
use Modules\CRM\App\Models\Estimate;

class EstimateController extends Controller
{
    public function index()
    {
        $clients = DB::table(DB::raw('(
            SELECT id, CONCAT(first_name," ",last_name) AS name, "client" AS type
            FROM clients
        ) AS clients'))
        ->select('id', 'name', 'type')
        ->get();

        $taxTypes = TaxType::select('id', 'name', 'rate', 'type')->get();

        return view('crm::prospects.estimate.index',compact('clients','taxTypes'));
    }

    public function datatable()
    {
        if (request()->ajax())
		{
			return datatables()->of(Estimate::with('client','tax','estimateItems')->select('id','start_date','end_date','client_id','tax_type_id')->get())
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
                ->addColumn('client',function ($row)
                {
                    return $row->client->first_name.' '.$row->client->last_name ?? "" ;
                })
                ->addColumn('tax',function ($row)
                {
                    return $row->tax->rate.' %';
                })
                ->addColumn('amount',function ($row)
                {
                    if($row->estimateItems) {
                        $total = 0;
                        foreach($row->estimateItems as $item) {
                            $total += $item->rate * $item->quantity;
                        }
                        return $total + ($total * ($row->tax->rate/100));
                    }else
                        return 0;
                })
				->addColumn('action', function ($data)
                {
                    $button = '<a href="estimates/'.$data->id.'/items"  class="btn btn-success btn-sm" data-toggle="tooltip" data-placement="top" title="View Details"><i class="dripicons-preview"></i></button></a>';
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


    public function store(StoreEstimateRequest $request)
    {
        Estimate::create([
            'start_date' => date('Y-m-d',strtotime($request->start_date)),
            'end_date' => date('Y-m-d',strtotime($request->end_date)),
            'client_id' => $request->client_id,
            'tax_type_id' => $request->tax_type_id,
            'note' => $request->note,
        ]);

        return response()->json(['success' =>'Data Submitted Successfully'], 200);
    }

    public function edit(Estimate $estimate)
    {
        return response()->json($estimate);
    }

    public function update(UpdateEstimateRequest $request, Estimate $estimate)
    {
        $estimate->update([
            'start_date' => date('Y-m-d',strtotime($request->start_date)),
            'end_date' => date('Y-m-d',strtotime($request->end_date)),
            'client_id' => $request->client_id,
            'tax_type_id' => $request->tax_type_id,
            'note' => $request->note,
        ]);

        return response()->json(['success' =>'Data Updated Successfully'], 200);
    }

    public function destroy(Estimate $estimate)
    {
        $estimate->delete();

        return response()->json(['success' =>'Data Deleted Successfully'], 200);
    }

    public function bulkDelete(Request $request)
    {
        $idsArray = $request['idsArray'];

        try {
            $estimate = Estimate::whereIntegerInRaw('id', $idsArray);
            $estimate->delete();
            return response()->json(['success' =>'Data Deleted Successfully'], 200);

        } catch (Exception $e) {
            return response()->json(['errorMsg' =>$e->getMessage()], 422);
        }
    }

}
