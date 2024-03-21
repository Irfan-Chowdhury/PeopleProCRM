<?php

namespace Modules\CRM\App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Client;
use Modules\CRM\App\Models\Item;
use Modules\CRM\App\Models\Order;
use Modules\CRM\App\Models\OrderDetail;
use App\Models\TaxType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class StoreController extends Controller
{
    public function index()
    {
        $sessionItems = Session::get('items');
        $totalAmount = self::totalAmount($sessionItems);
        $sessionItemsIds = self::getAllSessionItemsIds($sessionItems);
        $items = Item::select('id','title','description','unit_type','rate','image')->get();

        return view('crm::sale_section.store.index', compact('items','sessionItems','totalAmount','sessionItemsIds'));
    }

    public function addToCart(Item $item)
    {
        $data = [];
        if(Session::has('items')) {
            $data = Session::get('items');
        }

        array_push($data, $item);

        Session::put('items', $data);


        return redirect()->back();
    }

    public function chekout()
    {
        $sessionItems = Session::get('items');
        $totalAmount = self::totalAmount($sessionItems);
        $clients = Client::select('id','first_name','last_name')->get();
        $taxTypes = TaxType::select('id', 'name', 'rate', 'type')->get();

        return view('crm::sale_section.store.chekout',compact('sessionItems','totalAmount','clients','taxTypes'));
    }

    public function processOrder(Request $request)
    {
        $getAllRequest =  $request->all();
        $orderDetails = [];
        // return count($getAllRequest['item_id']);


        $order = Order::create([
            'client_id' => $request->client_id,
            'tax_type_id' => $request->tax_type_id,
            'tax' => $request->tax,
            // 'total' => $request->total + $request->tax,
            'total' => $request->total,
            'status' => 'pending',
        ]);

        for ($i=0; $i < count($getAllRequest['item_id']); $i++) {
            $orderDetails[$i] = [
                'order_id' => $order->id,
                'item_id' => $getAllRequest['item_id'][$i],
                'quantity' => $getAllRequest['quantity'][$i],
                'rate' => $getAllRequest['rate'][$i],
                'subtotal' => $getAllRequest['subtotal'][$i],
            ];
        }
        OrderDetail::insert($orderDetails);
        Session::forget('items');

        return redirect()->route('order.index'); //$request->all();

    }


    protected function totalAmount(array|null $sessionItems) : int
    {
        $total = 0;
        if (isset($sessionItems)) {
            foreach ($sessionItems as $value) {
                $total+= $value->rate;
            }
        }
        return $total;
    }

    protected function getAllSessionItemsIds(array|null $sessionItems) : array
    {
        if (isset($sessionItems)) {
            return array_map(function($item) {
                return $item['id'];
            }, $sessionItems);
        }
        return [];
    }
}
