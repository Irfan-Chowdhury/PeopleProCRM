<?php

namespace Modules\CRM\App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\CRM\Database\factories\ContractItemFactory;

class ContractItem extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'contract_id',
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
