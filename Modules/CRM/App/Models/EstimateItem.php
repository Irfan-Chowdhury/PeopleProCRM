<?php

namespace Modules\CRM\App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\CRM\Database\factories\EstimateItemFactory;

class EstimateItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'estimate_id',
        'item_id',
        'quantity',
        'unit_type',
        'rate',
        'description'
    ];

    public function item()
    {
		return $this->belongsTo(Item::class,'item_id')
                ->select('id','title');
	}
}
