<?php

namespace Modules\CRM\App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class LeadContact extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'lead_id',
        'first_name',
        'last_name',
        'email',
        'phone',
        'address',
        'gender',
        'job_title',
        'image',
        'is_primary_contact'
    ];

}
