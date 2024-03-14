<?php

namespace Modules\CRM\App\Models;

use App\Models\Invoice;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\CRM\Database\factories\InvoicePaymentFactory;

class InvoicePayment extends Model
{
    use HasFactory;

    protected $fillable = [
        'invoice_id',
        'payment_method',
        'date',
        'amount',
        'payment_status',
        'note',
    ];

    public function invoice(){
		return $this->belongsTo(Invoice::class,'invoice_id');
	}
}
