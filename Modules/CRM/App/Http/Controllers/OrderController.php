<?php

namespace Modules\CRM\App\Http\Controllers;

use App\Http\Controllers\Controller;
use Modules\CRM\App\Models\Order;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function index()
    {
        return view('crm::sale_section.order.index');
    }

    public function datatable()
    {
        if (request()->ajax())
		{
			return datatables()->of(Order::with('client','orderDetails')->get())
				->setRowId(function ($row)
				{
					return $row->id;
				})
                ->addColumn('order_id',function ($row)
                {
                    return '#'.$row->id ?? "" ;
                })
                ->addColumn('client',function ($row)
                {
                    return $row->client->first_name.' '.$row->client->last_name ?? "" ;
                })
                ->addColumn('total',function ($row)
                {
                    return $row->total ?? 0.00 ;
                })
                // ->addColumn('status',function ($row)
                // {
                //     return $row->status ?? "" ;
                // })
                ->addColumn('status', function ($row)
                {
                    $btnColor = '';
                    if($row->status=='pending'){
                        $btnColor = 'danger';
                    }else if($row->status=='canceled'){
                        $btnColor = 'warning';
                    }else if($row->status=='completed'){
                        $btnColor = 'success';
                    }
                    return '<div class="btn-group dropright">
                                <button type="button" class="btn btn-sm btn-'.$btnColor.'">'.ucwords(str_replace('_', ' ',$row->status)).'</button>
                                <button type="button" class="btn btn-sm btn-'.$btnColor.' dropdown-toggle dropdown-toggle-split" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"></button>
                                <div class="dropdown-menu">
                                    <a class="dropdown-item" href="'.route('order.status_change',['order_id'=>$row->id,'status'=>'pending']).'">Pending</a>
                                    <a class="dropdown-item" href="'.route('order.status_change',['order_id'=>$row->id,'status'=>'completed']).'">Completed</a>
                                    <a class="dropdown-item" href="'.route('order.status_change',['order_id'=>$row->id,'status'=>'canceled']).'">Canceled</a>
                                </div>
                            </div>';
                })
                ->addColumn('order_date',function ($row)
                {
                    return date('Y-m-d', strtotime($row->created_at));
                })
				->addColumn('action', function ($data)
                {
                    return '<button type="button" data-id="'.$data->id.'" class="delete btn btn-danger btn-sm"><i class="dripicons-trash"></i></button>';
                })
                ->rawColumns(['action','status'])
                ->make(true);
		}
    }


    public function orderStatusChange($order_id, $status)
    {
        Order::where('id',$order_id)->update(['status'=> $status]);

        return redirect()->back();
    }
}
