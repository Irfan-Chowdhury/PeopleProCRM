<?php

namespace Modules\CRM\App\Models;

use App\Models\Client;
use App\Models\TaxType;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\CRM\Database\factories\ProposalFactory;

class Proposal extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'start_date',
        'end_date',
        'client_id',
        'lead_id',
        'tax_type_id',
        'note',
    ];

    public function client()
    {
		return $this->belongsTo(Client::class,'client_id')
                ->select('id','first_name','last_name');
	}

    public function lead()
    {
		return $this->belongsTo(Lead::class,'lead_id')
                ->with('owner:id,first_name,last_name')
                ->select('id','employee_id');
	}

    public function tax()
    {
		return $this->belongsTo(TaxType::class,'tax_type_id')
                ->select('id','name', 'rate', 'type');
	}

}
