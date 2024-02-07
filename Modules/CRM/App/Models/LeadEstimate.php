<?php

namespace Modules\CRM\App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class LeadEstimate extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'lead_id',
        'tax_id',
        'start_date',
        'end_date',
        'note',
    ];

    public function tax()
    {
		return $this->hasOne('Modules\CRM\App\Models\Tax','id','tax_id');
	}
}
