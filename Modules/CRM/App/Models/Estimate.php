<?php

namespace Modules\CRM\App\Models;

use App\Models\Client;
use App\Models\TaxType;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\CRM\Database\factories\EstimateFactory;

class Estimate extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'start_date',
        'end_date',
        'client_id',
        'tax_type_id',
        'note',
    ];

    public function client()
    {
		return $this->belongsTo(Client::class,'client_id')
                ->select('id','first_name','last_name');
	}

    public function tax()
    {
		return $this->belongsTo(TaxType::class,'tax_type_id')
                ->select('id','name', 'rate', 'type');
	}

    public function estimateItems()
    {
		return $this->hasMany(EstimateItem::class,'estimate_id');
	}
}
