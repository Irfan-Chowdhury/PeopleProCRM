<?php

namespace Modules\CRM\App\Http\Controllers;

use App\Http\Controllers\Controller;
use Exception;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Modules\CRM\App\Models\Item;
use Modules\CRM\App\Models\Proposal;
use Modules\CRM\App\Models\ProposalItem;

class ProposalItemController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Proposal $proposal)
    {
        $items = Item::select('id','title','description','unit_type','rate')->get();

        if (request()->ajax()) {
			return datatables()->of(ProposalItem::where('proposal_id',$proposal->id)->get())
				->setRowId(function ($row)
				{
					return $row->id;
				})
                ->addColumn('item',function ($row)
                {
                    return $row->item_id;
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

        return view('crm::prospects.proposal_item.index', compact('items','proposal'));
    }

    public function store(Request $request)
    {
        ProposalItem::create([
            'proposal_id'=>$request->proposal_id,
            'item_id'=>$request->item_id,
            'quantity'=>$request->quantity,
            'unit_type'=>$request->unit_type,
            'rate'=>$request->rate,
            'description'=> $request->description
        ]);

        return response()->json(['success' =>'Data Submitted Successfully'], 200);

    }


    public function edit($proposal, ProposalItem $proposalItem)
    {
        return response()->json($proposalItem);
    }

  
    public function update($proposal,ProposalItem $proposalItem, Request $request)
    {
        $proposalItem->update([
            'proposal_id'=>$proposal,
            'item_id'=>$request->item_id,
            'quantity'=>$request->quantity,
            'unit_type'=>$request->unit_type,
            'rate'=>$request->rate,
            'description'=> $request->description
        ]);

        return response()->json(['success' =>'Data Updated Successfully'], 200);
    }

    public function destroy($proposal, ProposalItem $proposalItem)
    {
        $proposalItem->delete();

        return response()->json(['success' =>'Data Deleted Successfully'], 200);
    }

    public function bulkDelete(Request $request)
    {
        $idsArray = $request['idsArray'];

        try {
            $proposalItem = ProposalItem::whereIntegerInRaw('id', $idsArray);
            $proposalItem->delete();
            return response()->json(['success' =>'Data Deleted Successfully'], 200);

        } catch (Exception $e) {
            return response()->json(['errorMsg' =>$e->getMessage()], 422);
        }
    }
}
