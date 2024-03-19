<?php

namespace Modules\CRM\App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Modules\CRM\App\Models\Contract;
use Modules\CRM\App\Models\Subscription;

class ClientController extends Controller
{
    public function overview()
    {
        $clients = Client::where('is_active',true)->get();
        $subscriptions = Subscription::all();
        $contracts = Contract::all();

        $invoices = DB::table(DB::raw('(SELECT
            COUNT(*) AS total_clients,
            SUM(CASE WHEN status = 1 THEN 1 ELSE 0 END) AS paid_clients,
            SUM(IF(status = 2, 1, 0)) AS unpaid_clients,
            SUM(IF(status != 1 AND status != 2 , 1, 0)) AS sent_clients
        FROM
            invoices) AS subquery'))
        ->select([
            DB::raw('ROUND((paid_clients / total_clients) * 100) AS paid_percentage'),
            DB::raw('ROUND((unpaid_clients / total_clients) * 100 ) AS unpaid_percentage'),
            DB::raw('ROUND((sent_clients / total_clients) * 100 )AS sent_percentage')
        ])->first();


        $orderResult = DB::table('orders')
            ->selectRaw('
                SUM(IF(status = "pending", 1, 0)) AS totalPendingOrder,
                SUM(IF(status = "completed", 1, 0)) AS totalCompletedOrder,
                SUM(IF(status = "canceled", 1, 0)) AS totalCanceledOrder
            ')
            ->first();


        return view('crm::client.overview', compact('clients','subscriptions','contracts','invoices','orderResult'));
    }
}
