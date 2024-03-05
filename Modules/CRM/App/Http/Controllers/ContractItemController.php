<?php

namespace Modules\CRM\App\Http\Controllers;

use App\Http\Controllers\Controller;
use Exception;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Modules\CRM\App\Models\Contract;
use Modules\CRM\App\Models\ContractItem;
use Modules\CRM\App\Models\Item;

class ContractItemController extends Controller
{
    public function index(Contract $contract)
    {
        $items = Item::select('id','title','description','unit_type','rate')->get();

        if (request()->ajax()) {
			return datatables()->of(ContractItem::with('item')->where('contract_id',$contract->id)->get())
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

        return view('crm::sale_section.contracts.contract_item.index', compact('items','contract'));
    }

    public function store(Request $request)
    {
        ContractItem::create([
            'contract_id'=>$request->contract_id,
            'item_id'=>$request->item_id,
            'quantity'=>$request->quantity,
            'unit_type'=>$request->unit_type,
            'rate'=>$request->rate,
            'description'=> $request->description
        ]);

        return response()->json(['success' =>'Data Submitted Successfully'], 200);
    }
    public function edit($contract, ContractItem $contractItem)
    {
        return response()->json($contractItem);
    }

    public function update($contract, ContractItem $contractItem, Request $request)
    {
        $contractItem->update([
            'contract_id'=>$contract, //id
            'item_id'=>$request->item_id,
            'quantity'=>$request->quantity,
            'unit_type'=>$request->unit_type,
            'rate'=>$request->rate,
            'description'=> $request->description
        ]);

        return response()->json(['success' =>'Data Updated Successfully'], 200);
    }

    public function destroy($contract,  ContractItem $contractItem)
    {
        $contractItem->delete();

        return response()->json(['success' =>'Data Deleted Successfully'], 200);
    }

    public function bulkDelete(Request $request)
    {
        $idsArray = $request['idsArray'];

        try {
            $contractItem = ContractItem::whereIntegerInRaw('id', $idsArray);
            $contractItem->delete();
            return response()->json(['success' =>'Data Deleted Successfully'], 200);

        } catch (Exception $e) {
            return response()->json(['errorMsg' =>$e->getMessage()], 422);
        }
    }
}
