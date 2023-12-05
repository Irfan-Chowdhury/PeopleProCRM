<?php

namespace App\Models\CRM;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Lead extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'company_id',
        'employee_id',
        'status',
        'country_id',
        'city',
        'state',
        'zip',
        'address',
        'phone',
        'website',
        'vat_number',
        'gst_number',
    ];

    public function company()
    {
		return $this->hasOne('App\Models\company','id','company_id');
	}
    public function owner()
    {
		return $this->hasOne('App\Models\Employee','id','employee_id');
	}

    public function country()
    {
		return $this->hasOne('App\Models\Country','id','country_id');
	}
}
