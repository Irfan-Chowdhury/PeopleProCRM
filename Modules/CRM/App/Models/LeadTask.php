<?php

namespace Modules\CRM\App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class LeadTask extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'lead_id',
        'employee_id',
        'title',
        'description',
        'points',
        'collaborator_employee_ids',
        'status',
        'priority',
        'labels',
        'start_date',
        'end_date',
        'file',
    ];

    public function employee()
    {
		return $this->hasOne('App\Models\Employee','id','employee_id');
	}
}
