<?php

namespace App\Models\CRM;

use App\Models\CRM\Tax;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class LeadProposal extends Model
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
		return $this->hasOne(Tax::class,'id','tax_id');
	}
}
