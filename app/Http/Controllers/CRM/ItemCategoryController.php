<?php

namespace App\Http\Controllers\CRM;

use App\Http\Controllers\Controller;
use App\Http\Requests\ItemCategory\StoreRequest;
use App\Http\Requests\ItemCategory\UpdateRequest;
use App\Models\CRM\ItemCategory;
use Exception;
use Illuminate\Http\Request;

class ItemCategoryController extends Controller
{
    public function index()
    {
        return view('crm.sale_section.item_category.index');
    }

    public function datatable()
    {
        if (request()->ajax()) {
			return datatables()->of(ItemCategory::orderBy('id','DESC')->get())
				->setRowId(function ($row)
				{
					return $row->id;
				})
                ->addColumn('name',function ($row)
                {
                    return $row->name;
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

    public function store(StoreRequest $request)
    {
        ItemCategory::create([
            'name' => $request->name,
        ]);
        return response()->json(['success' =>'Data Submitted Successfully'], 200);
    }

    public function edit(ItemCategory $itemCategory)
    {
        return response()->json(['itemCategory' => $itemCategory]);
    }

    public function update(UpdateRequest $request, ItemCategory $itemCategory)
    {
        try {
            $itemCategory->update([
                'name' => $request->name,
            ]);
        } catch (Exception $exception) {
            return response()->json(['errorMsg' => $exception->getMessage()], 422);
        }


        return response()->json(['success' =>'Data Updated Successfully'], 200);
    }


    public function destroy(ItemCategory $itemCategory)
    {
        $itemCategory->delete();
        return response()->json(['success' =>'Data Deleted Successfully'], 200);
    }


    public function bulkDelete(Request $request)
    {
        $idsArray = $request['idsArray'];

        try {
            $itemCategory = ItemCategory::whereIntegerInRaw('id', $idsArray);
            $itemCategory->delete();
            return response()->json(['success' =>'Data Deleted Successfully'], 200);

        } catch (Exception $e) {
            return response()->json(['errorMsg' =>$e->getMessage()], 422);
        }
    }
}
