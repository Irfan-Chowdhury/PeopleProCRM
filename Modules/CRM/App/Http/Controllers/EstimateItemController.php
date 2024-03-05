<?php

namespace Modules\CRM\App\Http\Controllers;

use App\Http\Controllers\Controller;
use Exception;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Modules\CRM\App\Models\Estimate;
use Modules\CRM\App\Models\EstimateItem;
use Modules\CRM\App\Models\Item;

class EstimateItemController extends Controller
{
    public function index(Estimate $estimate)
    {
        $items = Item::select('id','title','description','unit_type','rate')->get();

        if (request()->ajax()) {
			return datatables()->of(EstimateItem::with('item')->where('estimate_id',$estimate->id)->get())
				->setRowId(function ($row)
				{
					return $row->id;
				})
                ->addColumn('item',function ($row)
                {
                    return $row->item->title;
                })
                ->addColumn('rate',function ($row)
                {
                    return $row->rate;
                })
                ->addColumn('quantity',function ($row)
                {
                    return $row->quantity;
                })
                ->addColumn('total',function ($row)
                {
                    return $row->rate * $row->quantity;
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

        return view('crm::prospects.estimate.estimate_item.index', compact('items','estimate'));
    }


    public function store(Request $request)
    {
        EstimateItem::create([
            'estimate_id'=>$request->estimate_id,
            'item_id'=>$request->item_id,
            'quantity'=>$request->quantity,
            'unit_type'=>$request->unit_type,
            'rate'=>$request->rate,
            'description'=> $request->description
        ]);

        return response()->json(['success' =>'Data Submitted Successfully'], 200);
    }

    public function edit($estimate, EstimateItem $estimateItem)
    {
        return response()->json($estimateItem);
    }


    public function update($estimate, EstimateItem $estimateItem, Request $request)
    {
        $estimateItem->update([
            'estimate_id'=>$estimate, //id
            'item_id'=>$request->item_id,
            'quantity'=>$request->quantity,
            'unit_type'=>$request->unit_type,
            'rate'=>$request->rate,
            'description'=> $request->description
        ]);

        return response()->json(['success' =>'Data Updated Successfully'], 200);
    }

    public function destroy($estimate,  EstimateItem $estimateItem)
    {
        $estimateItem->delete();

        return response()->json(['success' =>'Data Deleted Successfully'], 200);
    }

    public function bulkDelete(Request $request)
    {
        $idsArray = $request['idsArray'];

        try {
            $estimateItem = EstimateItem::whereIntegerInRaw('id', $idsArray);
            $estimateItem->delete();
            return response()->json(['success' =>'Data Deleted Successfully'], 200);

        } catch (Exception $e) {
            return response()->json(['errorMsg' =>$e->getMessage()], 422);
        }
    }
}
