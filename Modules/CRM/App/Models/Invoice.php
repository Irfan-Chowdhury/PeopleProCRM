<?php

namespace Modules\CRM\App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Modules\CRM\App\Models\InvoicePayment;

class Invoice extends Model
{
	protected $fillable = [
		'invoice_number', 'client_id', 'project_id', 'invoice_date', 'invoice_due_date', 'sub_total', 'discount_type', 'discount_figure', 'total_tax',
		'total_discount', 'grand_total', 'invoice_note', 'status'
	];

	public function project(){
		return $this->hasOne('App\Models\Project','id','project_id');
	}

	public function invoicePayment(){
		return $this->hasOne(InvoicePayment::class,'invoice_id');
	}

	public function client(){
		return $this->hasOne('App\Models\Client','id','client_id');
	}
	public function invoiceItems(): HasMany
    {
		return $this->hasMany(InvoiceItem::class)
                    ->with('item');
	}


	public function setInvoiceDateAttribute($value)
	{
		$this->attributes['invoice_date'] = Carbon::createFromFormat(env('Date_Format'), $value)->format('Y-m-d');
	}

	public function getInvoiceDateAttribute($value)
	{
		return Carbon::parse($value)->format(env('Date_Format'));
	}


	public function setInvoiceDueDateAttribute($value)
	{
		$this->attributes['invoice_due_date'] = Carbon::createFromFormat(env('Date_Format'), $value)->format('Y-m-d');
	}

	public function getInvoiceDueDateAttribute($value)
	{
		return Carbon::parse($value)->format(env('Date_Format'));
	}

	public function getRouteKeyName()
	{
		return 'invoice_number'; // TODO: Change the autogenerated stub
	}


}
