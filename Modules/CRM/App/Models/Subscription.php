<?php

namespace Modules\CRM\App\Models;

use App\Models\TaxType;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Subscription extends Model
{
    use HasFactory, SoftDeletes;

    public const DAY = 'day';
    public const WEEK = 'week';
    public const MONTH = 'month';
    public const YEAR = 'year';

    protected $fillable = [
        'client_id',
        'tax_type_id',
        'title',
        'first_billing_date',
        'repeat_type',
        'note',
    ];

    public function client()
    {
		return $this->hasOne('App\Models\Client','id','client_id');
	}

    public function tax()
    {
		return $this->belongsTo(TaxType::class,'tax_type_id')
                ->select('id','name', 'rate', 'type');
	}

}
