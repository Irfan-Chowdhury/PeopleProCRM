<?php

namespace Modules\CRM\App\Models;

use App\Models\TaxType;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\CRM\Database\factories\ContractFactory;

class Contract extends Model
{
    use HasFactory;

    protected $fillable = [
        'client_id',
        'lead_id',
        'project_id',
        'tax_type_id',
        'title',
        'start_date',
        'end_date',
        'note',
    ];

    public function project()
    {
		return $this->hasOne('App\Models\Project','id','project_id');
	}

    public function tax()
    {
		return $this->belongsTo(TaxType::class,'tax_type_id')
                ->select('id','name', 'rate', 'type');
	}
}
