<?php

namespace Modules\CRM\App\Models;

use App\Models\TaxType;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Order extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'client_id',
        'tax_type_id',
        'tax',
        'total',
        'status'
    ];

    public function client()
    {
		return $this->hasOne('App\Models\Client','id','client_id');
	}

    public function orderDetails(){
		return $this->hasMany(OrderDetail::class)
                    ->with('item');
	}

    public function taxData()
    {
		return $this->belongsTo(TaxType::class,'tax_type_id')
                ->select('id','name', 'rate', 'type');
	}

}
