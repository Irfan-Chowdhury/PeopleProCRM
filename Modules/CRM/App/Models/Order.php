<?php

namespace Modules\CRM\App\Models;

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
    ];

    public function client()
    {
		return $this->hasOne('App\Models\Client','id','client_id');
	}

    public function orderDetails(){
		return $this->hasMany(OrderDetail::class);
	}

}
