<?php

namespace App\Models\CRM;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class LeadContract extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'lead_id',
        'project_id',
        'tax_id',
        'title',
        'start_date',
        'end_date',
        'note',
    ];

    public function tax()
    {
		return $this->hasOne('App\Models\CRM\Tax','id','tax_id');
	}

    public function project()
    {
		return $this->hasOne('App\Models\Project','id','project_id');
	}
}
