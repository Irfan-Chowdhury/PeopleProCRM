<?php

namespace Modules\CRM\App\Http\Controllers;

use App\Http\Controllers\Controller;
use Modules\CRM\App\Http\Requests\Item\StoreRequest;
use Modules\CRM\App\Http\Requests\Item\UpdateRequest;
use App\Http\traits\FileHandleTrait;
use Modules\CRM\App\Models\ItemCategory;
use Exception;
use Illuminate\Http\Request;
use Modules\CRM\App\Models\Item;
use Nwidart\Modules\Facades\Module;

class ItemController extends Controller
{
    use FileHandleTrait;
    public function index()
    {
        $itemCategogries = ItemCategory::all();

        return view('crm::sale_section.items.index', compact('itemCategogries'));
    }

    public function datatable()
    {
        if (request()->ajax()) {
			return datatables()->of(Item::with('itemCategory')->orderBy('id','DESC')->get())
				->setRowId(function ($row)
				{
					return $row->id;
				})
                ->addColumn('image',function ($row)
                {
                    if ($row->image) {
                        $url = url('uploads/crm/items/'.$row->image);
                        $image = '<img src="'.$url.'" style="height:35px;width:35px"/>';
                    } else {
                        $url = url('logo/empty.jpg');
                        $image = '<img src="'.$url.'" style="height:35px;width:35px"/>';
                    };

                    return $image;
                })
                ->addColumn('title',function ($row)
                {
                    return $row->title;
                })
                ->addColumn('category',function ($row)
                {
                    return $row->itemCategory->name;
                })
                ->addColumn('unit_type',function ($row)
                {
                    return $row->unit_type;
                })
                // ->addColumn('rate',function ($row)
                // {
                //     return $row->rate;
                // })
				->addColumn('action', function ($data)
                {
                    $button = '<button type="button" data-id="'. $data->id . '" class="edit btn btn-primary btn-sm"><i class="dripicons-pencil"></i></button>';
                    $button .= '&nbsp;&nbsp;';
                    $button .= '<button type="button" data-id="'.$data->id.'" class="delete btn btn-danger btn-sm"><i class="dripicons-trash"></i></button>';
                    return $button;
                })
                ->rawColumns(['image','action'])
                ->make(true);
		}
    }

    public function show(Item $item)
    {
        return response()->json($item);
    }

    public function store(StoreRequest $request)
    {
        try {
            Item::create([
                'item_category_id' => $request->item_category_id,
                'title' => $request->title,
                'description' => $request->description,
                'unit_type' => $request->unit_type,
                'rate' => $request->rate,
                'is_client_visible' => $request->is_client_visible ? true : false,
                'image' => $this->fileUploadHandle($request->image, 'uploads/crm/items', 'item'),
            ]);

            return response()->json(['success' =>'Data Submitted Successfully'], 200);
        }
        catch (Exception $exception) {
            return response()->json(['errorMsg' => $exception->getMessage()], 422);
        }
    }

    public function edit(Item $item)
    {
        return response()->json(['item' => $item]);
    }

    public function update(UpdateRequest $request, Item $item)
    {
        try {
            $data = [
                'item_category_id' => $request->item_category_id,
                'title' => $request->title,
                'description' => $request->description,
                'unit_type' => $request->unit_type,
                'rate' => $request->rate,
                'is_client_visible' => $request->is_client_visible ? true : false,
            ];

            if($request->hasFile('image')) {
                $data['image'] = $this->fileUploadHandle($request->image, 'uploads/crm/items', 'item', $item->image);
            }
            $item->update($data);

            return response()->json(['success' =>'Data Submitted Successfully'], 200);
        }
        catch (Exception $exception) {
            return response()->json(['errorMsg' => $exception->getMessage()], 422);
        }
    }

    public function destroy(Item $item)
    {
        $this->previousFileDelete('uploads/crm/items', $item->image);
        $item->delete();

        return response()->json(['success' =>'Data Deleted Successfully'], 200);
    }


    public function bulkDelete(Request $request)
    {
        $idsArray = $request['idsArray'];

        try {
            $item = Item::whereIntegerInRaw('id', $idsArray);
            foreach ($item->get() as $value) {
                $this->previousFileDelete('uploads/crm/items', $value->image);
            }
            $item->delete();
            return response()->json(['success' =>'Data Deleted Successfully'], 200);

        } catch (Exception $e) {
            return response()->json(['errorMsg' =>$e->getMessage()], 422);
        }
    }
}
        // return  module_path('CRM').'/assets/images/';
        // return url('uploads/crm/items/item_1702440585.png');
        // return url(module_path('CRM').'/assets/images/items/item_1702440585.png');
        // return file_get_contents(Module::find('CRM')->getPath(). "/assets/images/items/item_1702440585.png");

