<?php

namespace Modules\CRM\App\Models;

use App\Models\TaxType;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class LeadContract extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'lead_id',
        'project_id',
        'tax_type_id',
        'title',
        'start_date',
        'end_date',
        'note',
    ];

    public function tax()
    {
		return $this->belongsTo(TaxType::class,'tax_type_id')
                ->select('id','name', 'rate', 'type');
	}

    public function project()
    {
		return $this->hasOne('App\Models\Project','id','project_id');
	}
}
