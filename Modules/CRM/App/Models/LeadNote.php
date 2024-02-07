<?php

namespace Modules\CRM\App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class LeadNote extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'lead_id',
        'title',
        'note',
    ];

}
