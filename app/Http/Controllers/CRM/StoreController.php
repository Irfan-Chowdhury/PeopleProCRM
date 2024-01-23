<?php

namespace App\Http\Controllers\CRM;

use App\Http\Controllers\Controller;
use App\Models\Client;
use App\Models\CRM\Item;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class StoreController extends Controller
{
    public function index()
    {
        // Session::forget('items');

        $sessionItems = Session::get('items');
        $totalAmount = self::totalAmount($sessionItems);
        $sessionItemsIds = self::getAllSessionItemsIds($sessionItems);
        $items = Item::select('id','title','description','unit_type','rate','image')->get();

        return view('crm.sale_section.store.index', compact('items','sessionItems','totalAmount','sessionItemsIds'));
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

    public function processOrder()
    {
        $sessionItems = Session::get('items');
        $totalAmount = self::totalAmount($sessionItems);
        $clients = Client::select('id','first_name','last_name')->get();

        return view('crm.sale_section.store.process_order',compact('sessionItems','totalAmount','clients'));
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
