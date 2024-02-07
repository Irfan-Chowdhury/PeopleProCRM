<?php

namespace App\Http\Controllers\CRM;

use App\Http\Controllers\Controller;
use App\Models\CRM\Order;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function index()
    {
        return view('crm.sale_section.order.index');
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
                ->addColumn('status',function ($row)
                {
                    return $row->status ?? "" ;
                })
                ->addColumn('order_date',function ($row)
                {
                    return date('Y-m-d', strtotime($row->created_at));
                })
				->addColumn('action', function ($data)
                {
                    return '<button type="button" data-id="'.$data->id.'" class="delete btn btn-danger btn-sm"><i class="dripicons-trash"></i></button>';
                })
                ->rawColumns(['action'])
                ->make(true);
		}
    }
}
